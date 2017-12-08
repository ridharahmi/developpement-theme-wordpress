<?php


// Admin --------------
class Kama_WP_Smiles_Admin extends Kama_WP_Smiles {

	private static $access_cap = 'manage_options';

	function __construct(){
		parent::__construct();

		add_action( 'admin_menu',  array( &$this, 'admin_page') );

		// добавляем смайлии к формам
		add_action( 'the_editor', array( &$this, 'admin_add_to_editor') );
		add_action( 'admin_print_footer_scripts', array( &$this, 'admin_js'), 999 );

		add_action( 'admin_head', array( &$this, 'admin_styles') );

		add_filter( 'current_screen', array( &$this, 'upgrade_init') );
	}

	function upgrade_init(){
		require_once KWS_PLUGIN_PATH .'admin/plugin_upgrade.php';
		ksw_version_upgrade();
	}

	function admin_styles(){
		echo '<style>'. $this->main_css() .'</style>';
	}

	function admin_page(){
		$hookname = add_options_page( __('Kama WP Smiles Settings','kama-wp-smile'), 'Kama WP Smiles', self::$access_cap, 'kama_wp_smiles_opt',  array( &$this, 'admin_options_page') );

		add_action("load-$hookname", array( &$this, 'opt_page_load') );
	}

	function admin_options_page(){
		if( ! current_user_can( self::$access_cap ) ) return;

		include KWS_PLUGIN_PATH .'admin/admin-page.php';
	}

	function opt_page_load(){
		wp_enqueue_style('ks_admin_page', KWS_PLUGIN_URL .'admin/admin-page.css', array(), KWS_VER );

		//ksw_version_upgrade();

		if( isset($_POST['kwps_nonce']) && wp_verify_nonce($_POST['kwps_nonce'], 'kwps_options_up') && check_admin_referer('kwps_options_up', 'kwps_nonce') ){
			if( isset($_POST['kama_sm_reset']) ) $this->set_def_options(); // сброс

			if( isset( $_POST['kama_sm_submit'] ) ) $this->update_options_handler(); //обновим опции
		}
	}

	function set_def_options(){
		$this->opt = self::def_options();

		update_option( self::OPT_NAME, $this->opt );

		return true;
	}

	static function def_options(){
		return array(
			'textarea_id'    => 'comment',
			'spec_tags'      => array('pre','code'),
			'additional_css' => '',

			// разделил для того, чтобы упростить поиск вхождений
			'used_sm'        => array('smile', 'sad', 'laugh', 'rofl', 'blum', 'kiss', 'yes', 'no', 'good', 'bad', 'unknw', 'sorry', 'pardon', 'wacko', 'acute', 'boast', 'boredom', 'dash', 'search', 'crazy', 'yess', 'cool'),

			// (исключения) имеют спец обозначения
			'hard_sm'        => array( '=)' => 'smile', ':)' => 'smile', ':-)' => 'smile', '=(' => 'sad', ':(' => 'sad', ':-(' => 'sad', '=D' => 'laugh', ':D' => 'laugh', ':-D' => 'laugh', ),

			'all_sm'         => self::get_dir_smile_names(), // все имеющиеся смайлы
			'sm_start'       => '', // начальный тег смайлка
			'sm_end'         => '', // конечный тег смайлка

			'file_ext'       => 'gif', // file extension
			'sm_pack'        => 'qip', // пакет смайликов

			'smlist_pos'     => '', // позиция списка смаликов
		);
	}

	// update options
	function update_options_handler(){
		$this->opt = array();

		// sanitize
		foreach( array_keys(self::def_options()) as $key ){
			$_val = isset($_POST[$key]) ? stripslashes($_POST[$key]) : '';

			if(0){}
			// textarea_id
			elseif( $key === 'textarea_id' ){
				$_val = sanitize_key($_val);
			}
			// additional_css
			elseif( $key === 'additional_css' ){
				$_val = strip_tags($_val);
			}
			// spec_tags
			elseif( $key === 'spec_tags' ){
				if( !empty($_val) ){
					$_val = preg_replace('/[^a-z,]/', '', strtolower($_val) );
					$_val = explode(',', $_val );
					$_val = array_map('sanitize_key', $_val );
				}
				else $_val = array();
			}
			// used_sm
			elseif( $key === 'used_sm' ){
				$_val = explode(',', trim($_val) );
				$_val = array_map('trim', $_val );
				$_val = array_map('sanitize_key', $_val ); // protect
				$_val = array_filter( $_val );
			}
			// hard_sm
			elseif( $key === 'hard_sm' ){
				$_val = strip_tags( $_val ); // protect
				$_val = trim( $_val );
				$_val = explode("\n", $_val);
				$_val = array_map('trim', $_val );
				$_val = array_filter( $_val );
				foreach( $_val as $val ){
					$vals = preg_split('/ *>>>+ */', $val );
					$_val['temp'][ trim($vals[0]) ] = sanitize_key( trim($vals[1]) );
				}
				$_val = $_val['temp'];
			}
			// all_sm
			elseif( $key === 'all_sm' ){
				$_val = self::get_dir_smile_names();
			}
			// sm_pack & file_ext
			elseif( $key === 'sm_pack' ){
				$_val = sanitize_key($_val);
				// find extention
				foreach( glob( self::$SM_PACK_PATH .'*' ) as $file ){
					$ext = substr($file, -3, 3);
					if( strpos($file, '.') && in_array( $ext, array('gif','png','jpg') ) ){
						$this->opt['file_ext'] = $ext;
						break;
					}
				}
			}
			// all_sm
			elseif( $key === 'smlist_pos' ){
				$_val = sanitize_key($_val);
			}
			// default
			else {
				$_val = sanitize_text_field($_val);
			}

			$this->opt[$key] = $_val;
		}

		update_option( self::OPT_NAME, $this->opt );

		$this->_set_packs_data();

		//delete_option('use_smilies'); // удаляем стандартную опцию отображения смайликов
	}

	## добавляем ко всем textarea созданым через the_editor
	function admin_add_to_editor( $html ){
		preg_match('~<textarea[^>]+id=[\'"]([^\'"]+)~i', $html, $match );
		$tx_id = $match[1];

		return str_replace('textarea>', 'textarea>'. $this->get_all_smile_html( $tx_id, array('add_to_editor'=>1) ), $html );
	}

	function admin_js(){
		echo $this->insert_smile_js();
		?>
		<script type="text/javascript">
		// Передвигаем блоки смайликов для визуального редактора и для HTML редактора
		jQuery(document).ready(function( $){
			// Передвигаем смайлы в HTML редактор
			// форм может быть много - перебираем массив
			$('.sm_list').each(function(){
				var $smlist = $(this);
					$quicktags = $smlist.siblings('.quicktags-toolbar');

				if( $quicktags[0] ){
					$quicktags.append( $smlist );
					$smlist
						.css({ position:'absolute', display:'inline-block', padding:'4px 0 0 25px', left:'auto', top:'auto', right:'auto', bottom:'auto', height:'23px' })
						.find('.sm_container').css({ left:'auto', right:0, top:0, bottom:'auto' });
				}

				// проверяем нет ли виз редактора
				var $editortabs = $smlist.closest('.wp-editor-container').prev().find('.wp-editor-tabs');
				if( $editortabs.length ){
					$editortabs.before( $smlist );
					$smlist
						.css({ 'margin-left':'10px' })
						.find('.sm_container').css({ left:0, right:'auto', top:0, bottom:'auto' }); // поправим стили
					//console.log( $smlist[0] );
				}
			});

			/*var $mce_editor = $('#insert-media-button');
			if( 0&& $mce_editor[0] ){
				var $smlist = $('.sm_list').first();
				$mce_editor.after(
					$smlist.css({ position:'relative', padding:'0', margin:'2px 0px 0px 30px', left:'none', top:'none', right:'none', bottom:'none' })
				);
			}*/
		});
		//*/
		</script>
		<?php
	}

	## Выберите смайлики:
	function dir_smiles_img(){
		$hard_sm = array_flip( $this->theopt('hard_sm') );
		$gather_sm = array();

		foreach( self::get_dir_smile_names() as $smile ){
			$sm_name = $sm_code = $smile;
			if( @ $hard_sm[ $smile ] ){
				$sm_code = $smile;
				$sm_name = $hard_sm[ $smile ];
			}

			echo '<b id="'. $sm_code .'" title="'. $sm_name .'" class="'. ( in_array( $sm_code, (array) $this->theopt('used_sm') ) ? 'checked':'' ) .'" >'. sprintf( self::$sm_img, $sm_code, $sm_name ) .'</b>';
		}
	}

	function activation(){
		//delete_option('use_smilies');

		if( ! get_option( self::OPT_NAME ) )
			$this->set_def_options();

		//ksw_version_upgrade();
	}

}
