<?php

class Kama_WP_Smiles {

	const OPT_NAME = 'kwsmile_opt';

	public $opt;

	static $sm_start = '(:';
	static $sm_end   = ':)';

	static $sm_img; // шаблон замены

	static $SM_PACK_URL;  // KWS_PLUGIN_URL .'packs/qip/';
	static $SM_PACK_PATH; // KWS_PLUGIN_PATH .'packs/qip/';

	static $inst;

	static function instance(){
		if( is_null(self::$inst) )
			self::$inst = ( is_admin() && ! defined('DOING_AJAX') ) ? new Kama_WP_Smiles_Admin() : new self;

		return self::$inst;
	}

	function __construct(){
		$this->opt = get_option( self::OPT_NAME );
		if( false === $this->opt ) $this->opt = get_option('wp_sm_opt'); // for ver less then 1.9.0

		$this->_set_packs_data();

		self::_set_sm_start_end( $this->opt );

		self::load_textdomain();

		// инициализация
		add_action( 'wp_head', array( &$this, 'styles') );

		if( $this->theopt('textarea_id') )
			add_action('wp_footer', array( &$this, 'footer_scripts') );

		add_filter('comment_text', array( &$this, 'convert_smilies'), 5 );
		add_filter('the_content', array( &$this, 'convert_smilies'), 5 );
		add_filter('the_excerpt', array( &$this, 'convert_smilies'), 5 );

	}

	## подключаем файл перевода
	static function load_textdomain(){
		load_plugin_textdomain( 'kama-wp-smile', false, basename(KWS_PLUGIN_PATH) .'/languages' );
	}

	function _set_packs_data(){
		self::$SM_PACK_URL  = KWS_PLUGIN_URL .'packs/qip/';
		self::$SM_PACK_PATH = KWS_PLUGIN_PATH .'packs/qip/';

		// external folder - /plugins/kama-wp-smile-packs/
		$_sm_pack = $this->theopt('sm_pack');
		if( is_dir(untrailingslashit(KWS_PLUGIN_PATH)  ."-packs/$_sm_pack") ){
			self::$SM_PACK_URL  = untrailingslashit(KWS_PLUGIN_URL)  ."-packs/$_sm_pack/";
			self::$SM_PACK_PATH = untrailingslashit(KWS_PLUGIN_PATH) ."-packs/$_sm_pack/";
		}
		// inner folder - /plugins/kama-wp-smile/packs/
		elseif( is_dir(KWS_PLUGIN_PATH ."packs/$_sm_pack") ){
			self::$SM_PACK_URL  = KWS_PLUGIN_URL  ."packs/$_sm_pack/";
			self::$SM_PACK_PATH = KWS_PLUGIN_PATH ."packs/$_sm_pack/";
		}

		self::$sm_img = '<img class="kws-smiley" src="'. self::$SM_PACK_URL .'%s.'. $this->theopt('file_ext') .'" alt="%s" />';
	}

	static function _set_sm_start_end( $opt ){
		if( ! empty($opt['sm_start']) ) self::$sm_start = $opt['sm_start'];
		if( ! empty($opt['sm_end']) )   self::$sm_end = $opt['sm_end'];
	}

	## get option by name or all options
	function theopt( $name = '' ){
		// important options
		if( empty($this->opt['file_ext']) ) $this->opt['file_ext'] = 'gif';
		if( empty($this->opt['sm_pack']) ) $this->opt['sm_pack'] = 'qip';

		if( $name ){
			return isset($this->opt[$name]) ? $this->opt[$name] : null;
		}
		else
			return $this->opt;
	}

	## Функция замены кодов на смайлы
	function convert_smilies( $text ){
		$pattern = array();

		// общий паттерн смайликов для замены (:good:)
		$pattern[] = preg_quote(self::$sm_start) .'([a-zA-Z0-9_-]{1,20})'. preg_quote(self::$sm_end);

		// спец смайлики ":)"
		foreach( $this->theopt('hard_sm') as $sm_code => $sm_name ){
			$pat = preg_quote( $sm_code );

			// если код смайлика начинается с ";" добавим возможность использвать спецсимволы вроде &quot;)
			if( $pat{0} == ';' )
				$pat = '(?<!&.{2}|&.{3}|&.{4}|&.{5}|&.{6})' . $pat; // &#34; &#165; &#8254; &quot; // {2,6} Lookbehinds need to be zero-width, thus quantifiers are not allowed

			$pattern[] = $pat;
		}

		//$combine_pattern = implode('|', $pattern ); // объединим все патерны - так работае в 50 раз медленнее, лучше по отдельности обрабатывать

		$skip_tags = array_merge( array('style','script','textarea'), $this->theopt('spec_tags') );
		$skip_tags_patt = array();

		foreach( $skip_tags as $tag )
			$skip_tags_patt[] = "(<$tag.*?$tag>)"; // (<code.*?code>)|(<pre.*?pre>)

		$skip_tags_patt = implode('|', $skip_tags_patt );

		// разберем текст
		$text_parts = preg_split("/$skip_tags_patt/si", $text, -1, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY );

		$new_text = '';

		$skip_tags_patt2 = '^<(?:'. implode('|', $skip_tags ) .')'; // ^<(?:code|pre|blockquote)
		foreach( $text_parts as $txpart ){
			// Только разрешенные части
			if( ! preg_match("/$skip_tags_patt2/i", $txpart ) ){
				// заменяем по отдельности, так в 50 раз быстрее
				foreach( $pattern as $patt )
					$txpart = preg_replace_callback("/$patt/", array( & $this, '_smiles_replace_cb'), $txpart );
			}

			$new_text .= $txpart;
		}

		return $new_text;
	}

	## Коллбэк функция для замены
	function _smiles_replace_cb( $match ){
		// сначала заменяем полные патерны с названием файла - (:smile:)
		$filename = isset($match[1]) ? $match[1] : '';
		if( $filename ){
			if( in_array( $filename, $this->theopt('all_sm') ) )
				return sprintf( self::$sm_img, $match[1], $match[1] );
			else
				return '<span title="'. $filename .'.'. $this->theopt('file_ext') .' - no smiley file...">--</span>';
		}
		// специальные обозначения
		else {
			$hard_sm = $this->theopt('hard_sm');
			if( $hard_sm && isset($hard_sm[ $match[0] ]) )
				return sprintf( self::$sm_img, $hard_sm[ $match[0] ], $hard_sm[ $match[0] ] );
		}

		return $match[0]; // " {smile $match[0] not defined} ";
	}

	function footer_scripts(){
		if( ! is_singular() || ( isset($GLOBALS['post']) && $GLOBALS['post']->comment_status != 'open' ) )
			return;

		$all_smile = addslashes( $this->get_all_smile_html( $this->theopt('textarea_id') ) );

		?>
		<!-- Kama WP Smiles -->
		<?php echo $this->insert_smile_js(); ?>
		<script type="text/javascript">
			var tx = document.getElementById('<?php echo $this->theopt('textarea_id') ?>');
			if( tx ){
				var
				txNext = tx.nextSibling,
				txPar  = tx.parentNode,
				txWrapper = document.createElement('DIV');

				txWrapper.innerHTML = '<?php echo $all_smile ?>';
				txWrapper.setAttribute('class', 'kws-wrapper');
				txWrapper.appendChild(tx);
				txWrapper = txPar.insertBefore(txWrapper, txNext);
			}
		</script>
		<?php
	}

	function get_all_smile_html( $textarea_id = '', $args = array() ){
		$all_smiles = $this->all_smiles( $textarea_id );

		// прячем src чтобы не было загрузки картинок при загрузке страницы, только при наведении
		$all_smiles = str_replace( 'style', 'bg', $all_smiles );

		$out = '<div class="sm_list '.( isset($args['add_to_editor']) ?'': $this->theopt('smlist_pos') ).' '. $this->theopt('sm_pack') .'" style="width:30px; height:30px; background-image:url('. self::$SM_PACK_URL .'smile.'. $this->theopt('file_ext') .'); background-position:center center; background-repeat:no-repeat;"
			onmouseover="
			var el = this.childNodes[0];
			if( el.style.display == \'block\' )	return;

			el.style.display=\'block\';

			for( var i=0; i < el.childNodes.length; i++ ){
				var l = el.childNodes[i];
				var bg = l.getAttribute(\'bg\');
				if( bg )
					l.setAttribute( \'style\', bg );
			}
			"
			onmouseout="this.childNodes[0].style.display = \'none\'">
			<div class="sm_container">'. $all_smiles .'</div>
		</div>';

		// нужно в одну строку, используется в js
		return str_replace( array("\n","\t","\r"), '', $out );
	}

	function all_smiles( $textarea_id = false ){
		$gather_sm = array(); //собираем все в 1 массив

		// переварачиваем массив и избавляемся от дублей
		$hard_sm = array_flip( $this->theopt('hard_sm') );

		foreach( $this->theopt('used_sm') as $val ){
			$gather_sm[ $val ] = isset($hard_sm[ $val ]) ? $hard_sm[ $val ] : null;

			if( empty($gather_sm[$val]) )
				$gather_sm[ $val ] = self::$sm_start . $val . self::$sm_end;
		}

		// преобразуем в картинки
		$out = '';
		foreach( $gather_sm as $name => $text ){
			$params = "'$text', " . ( $textarea_id ? "'$textarea_id'" : "'". $this->theopt('textarea_id') ."'");
			$out .= '<div class="smiles_button" onclick="ksm_insert('. $params .');" style="background-image:url('. self::$SM_PACK_URL . $name .'.'. $this->theopt('file_ext') .');" title="'. $text .'"></div>';
		}

		return $out;
	}

	## wp_head
	function styles(){
		if( ! is_singular() || $GLOBALS['post']->comment_status != 'open' )
			return;

		echo '<style>'. $this->main_css() . strip_tags( $this->theopt('additional_css') ) .'</style>';
	}

	function main_css(){
		ob_start();
		?>
<style>
	/* kwsmiles preset */
	.kws-wrapper{ position:relative; z-index:99; }
	.sm_list{ z-index:9999; position:absolute; bottom:.3em; left:.3em; }
	.sm_container{
		display:none; position:absolute; top:0px; left:0px; box-sizing:border-box;
		width:410px; background:#fff; padding:5px;
		border-radius:2px; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.35);
		max-height:200px; overflow-y:auto; overflow-x:hidden;
	}
	.sm_container:after{ content:''; display:table; clear:both; }
	.sm_container .smiles_button{ cursor:pointer; width:50px; height:35px; display:block; float:left; background-position:center center; background-repeat:no-repeat; /*background-size:contain;*/ }
	.sm_container .smiles_button:hover{ background-color:rgba(200, 222, 234, 0.32); }
	.kws-smiley{ display:inline !important; border:none !important; box-shadow:none !important; background:none !important; padding:0; margin:0 .07em !important; vertical-align:-0.4em !important;
	}

	.sm_list.topright{ top:.3em; right:.3em; bottom:auto; left:auto; }
	.sm_list.topright .sm_container{ right:0; left:auto; }
	.sm_list.bottomright{ top:auto; right:.3em; bottom:.3em; left:auto; }
	.sm_list.bottomright .sm_container{ top:auto; right:0; bottom:0; left:auto; }

	.sm_list.skype_big, .sm_list.skype_big .smiles_button{ background-size:contain; }
</style>
		<?php

		return str_replace( array('<style>','</style>'), '', ob_get_clean() );
	}

	function insert_smile_js(){
		static $once; if( $once ) return; $once = 1; // один раз
		ob_start();
		?>
		<script type="text/javascript">
		function ksm_insert( aTag, txtr_id ){
			var tx = document.getElementById( txtr_id );
			tx.focus();
			aTag = ' ' + aTag + ' ';
			if( typeof tx.selectionStart != 'undefined'){
				var start = tx.selectionStart;
				var end = tx.selectionEnd;

				var insText = tx.value.substring(start, end);
				tx.value = tx.value.substr(0, start) +  aTag  + tx.value.substr(end);

				var pos = start + aTag.length;
				tx.selectionStart = pos;
				tx.selectionEnd = pos;
			}
			else if(typeof document.selection != 'undefined') {
				var range = document.selection.createRange();
				range.text = aTag;
			}

			document.querySelector('.sm_container').style.display = 'none';

			if( typeof tinyMCE != 'undefined' )
				tinyMCE.execCommand("mceInsertContent", false, aTag );
		}
		</script>
		<?php
		return str_replace( array("\n","\t","\r"), '', ob_get_clean() );
	}

	## читаем файлы с каталога. вернет массив
	static function get_dir_smile_names( $dir = '' ){
		$out = array();

		if( ! $dir ) $dir = self::$SM_PACK_PATH;

		foreach( glob( trailingslashit($dir) .'*.{gif,png}', GLOB_BRACE ) as $fpath ){
			$fname = basename( $fpath );
			$out[] = preg_replace('/\.[^.]+$/', '', $fname ); // удяляем расширение
		}

		return $out;
	}

	/*
	static function uninstall(){
		global $wpdb;

		if( __FILE__ != WP_UNINSTALL_PLUGIN ) return;

		self::_set_sm_start_end( get_option(self::OPT_NAME) );

		// Delete options
		delete_option( self::OPT_NAME );

		// Delete smiles in content
		foreach( self::get_dir_smile_names() as $val ){
			$val = addslashes( $val );
			if( $val ){
				$smile_code = self::$sm_start . $wpdb->escape($val) . self::$sm_end;
				$wpdb->query( "UPDATE $wpdb->posts SET post_content = REPLACE(post_content, '$smile_code', '') WHERE post_type NOT IN ('attachment','revision','nav_meny_item')" );
				$wpdb->query( "UPDATE $wpdb->comments SET comment_content = REPLACE(comment_content, '$smile_code', '')" );
			}
		}

	}
	*/
}


