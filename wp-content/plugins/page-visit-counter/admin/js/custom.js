(function( $ ) {
	$(window).load(function() {	
		
		jQuery( "#pvcp_dialog" ).dialog({
			
			modal: true, title: 'Subscribe Now', zIndex: 10000, autoOpen: true,
			width: '500', resizable: false,
			position: {my: "center", at:"center", of: window },
			dialogClass: 'dialogButtons',
			buttons: {
				Yes: function () {
					// $(obj).removeAttr('onclick');
					// $(obj).parents('.Parent').remove();
					var email_id = jQuery('#txt_user_sub_pvcp').val();

					var data = {
					'action': 'add_plugin_user_pvcp',
					'email_id': email_id
					};

					// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
					jQuery.post(ajaxurl, data, function(response) {
						jQuery('#pvcp_dialog').html('<h2>You have been successfully subscribed');
						jQuery(".ui-dialog-buttonpane").remove();
					});

					
				},
				No: function () {
						var email_id = jQuery('#txt_user_sub_pvcp').val();

					var data = {
					'action': 'hide_subscribe_pvcp',
					'email_id': email_id
					};

					// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
					jQuery.post(ajaxurl, data, function(response) {
													
					});
					
					jQuery(this).dialog("close");
					
				}
			},
			close: function (event, ui) {
				jQuery(this).remove();
			}
		});
		jQuery("div.dialogButtons .ui-dialog-buttonset button").removeClass('ui-state-default'); 
		jQuery("div.dialogButtons .ui-dialog-buttonset button").addClass("button-primary woocommerce-save-button");
		jQuery("div.dialogButtons .ui-dialog-buttonpane .ui-button").css("width","80px");
		
		
		$('#MyDate').datepicker({dateFormat : 'yy-mm-dd'});
		$('#example').DataTable({"iDisplayLength" : 10,"sPaginationType": "full_numbers","oLanguage": {"sEmptyTable": "No Page Found."}});
		$('#example_filter').css("display","none");
		$('#example_length').css("display","none");
		
		
		$('body').on('click',"#search-submit",function() {
					
			var pagename = $("#page-search-text").val();
			var pagedate = $(".pagedateselect").val();
			$.ajax({
				type: "POST",
				url: pagevisit.ajaxurl,
				async:false,
				data: ({
					action: 'select_input_page_value',
					page_name:pagename,
					page_date:pagedate
				}),
				success: function(data) {
					$(".page-visit-summery").empty();
					$(".page-visit-summery").append(data);
					$('#example').DataTable({"iDisplayLength" : 10,"sPaginationType": "full_numbers","oLanguage": {"sEmptyTable": "No Page Found."} });
					$('#example_filter').css("display","none");
					$('#example_length').css("display","none");
				}
			});
			
		});
		
		$("#ui-datepicker-div").css("display","none");
		
		var selectedPostArray = JSON.parse(get_post_option.optionsarray);
		var selectedPostglobalarr = [];
		for( var p in selectedPostArray ){						
		  selectedPostglobalarr.push( selectedPostArray[p] );
		}
		
		var selecteduserArray = JSON.parse(get_user_option.usersarray);
		var selectedUserglobalarr = [];
		for( var u in selecteduserArray ){						
		  selectedUserglobalarr.push( selecteduserArray[u] );
		}
		
		var selectedIpArray = JSON.parse(get_ip_option.ipaddressarray);
		var selectedIpglobalarr = [];
		for( var i in selectedIpArray ){
		  selectedIpglobalarr.push( selectedIpArray[i] );
		}
		
		var userString = '';
		userString = selectedUserglobalarr.join(",");
		
		var ipString = '';
		ipString = selectedIpglobalarr.join(",");
		
		var postString = '';
		postString = selectedPostglobalarr.join(",");
		
		$('body').on('change','.posttype',function() {
			var page_id = this.id
			if ( $('#'+page_id).is(":checked") ) {
				selectedPostglobalarr.push(page_id);
			} else {
				selectedPostglobalarr.indexOf(page_id);
				var index = selectedPostglobalarr.indexOf(page_id);
				if (index > -1) {
					selectedPostglobalarr.splice(index, 1);
				}
			}
			
		});
		
		var config = {
			'.chosen-select'           : {},
			'.chosen-select-deselect'  : {allow_single_deselect:true},
			'.chosen-select-no-single' : {disable_search_threshold:10},
			'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
			'.chosen-select-width'     : {width:"95%"}
		}
		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}
		
		
		var configip = {
			'.chosen-select-ip'           : {},
			'.chosen-select-deselect'  : {allow_single_deselect:true},
			'.chosen-select-no-single' : {disable_search_threshold:10},
			'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
			'.chosen-select-width'     : {width:"95%"}
		}
		for (var selectorip in configip) {
			$(selectorip).chosen(configip[selectorip]);
		}
		
		var configpost = {
			'.chosen-select-post'           : {},
			'.chosen-select-deselect'  : {allow_single_deselect:true},
			'.chosen-select-no-single' : {disable_search_threshold:10},
			'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
			'.chosen-select-width'     : {width:"95%"}
		}
		for (var selectorpost in configpost) {
			$(selectorpost).chosen(configpost[selectorpost]);
		}
		
		if(postString != '') {
			$.each(postString.split(","), function(p,r){
			    $("#post_type option[value='" + r + "']").prop("selected", true);
			    $('#post_type').trigger('chosen:updated');
			});
		}
		
		if(ipString != '') {
			$.each(ipString.split(","), function(i,e){
			    $("#ip_address option[value='" + e + "']").prop("selected", true);
			    $('#ip_address').trigger('chosen:updated');
			});
		}
		
		if(userString != '') {
			$.each(userString.split(","), function(j,k){
			    $("#users_list option[value='" + k + "']").prop("selected", true);
			    $('#users_list').trigger('chosen:updated');
			});
		}
		
		
		
		$('body').on('keyup','#ip_address_chosen ul.chosen-choices li.search-field input',function(evt) {
	    	var c = evt.keyCode;
	    	
	    	if(c == 188 || c == 13 || c == 59 || c == 186) {
		    	if(c == 13) {
		    		var ip = $(this).val();
		    	}
		    	if(c == 186) {
	    			var ip = $(this).val().replace(";","");
		    	} 
		    	if(c == 59) {
		    		var ip = $(this).val().replace(";","");
		    	}
		    	if(c == 188) {
		    		var ip = $(this).val().replace(",","");
		    	}
		    	var valid = ValidateIPaddress(ip);
		    	if (valid == 'yes') {
					$('#ip_address').append('<option value="'+ip+'">'+ip+'</option>');
			    	$("#ip_address option[value='"+ip+"']").prop("selected", true);
			    	$('#ip_address').trigger('chosen:updated');
		    	}
	    	}
	    });
	    
	    //$.getScript('https://www.gstatic.com/charts/loader.js');
	    //google.charts.load('current', {'packages':['corechart']});
	    
	    $('body').on('click','.page-counter-show',function() {
			
    	});
    	
    	
	   
	    $('body').on('blur','#ip_address_chosen ul.chosen-choices li.search-field input',function() {
	    	var id = $(this).val().replace(",","");
	    	
			var valid = ValidateIPaddress(id);
	    	if (valid == 'yes') {
				$('#ip_address').append('<option value="'+id+'">'+id+'</option>');
		    	$("#ip_address option[value='" + id + "']").prop("selected", true);
		    	$('#ip_address').trigger('chosen:updated');
	    	}
	    });
		
	    var ipaddress = [];
		var userlist = [];
	    var postlist = [];
	    var hidefrontview ='';
	    var text_color_page_visit ='';
	    $('body').on('click',"#pvc_reset_settings",function() {
	    	$('#action_which').val('reset');
	    });
	    
	    $('body').on('click',"#pvc_reset_counter",function() {
	    	$('#action_which').val('resetcount');
	    });
//		$('body').on('click',".pagecountsubmit",function() {
//			
//			if($("#ip_address").val()) { 
//				ipaddress = $("#ip_address").val();
//			} else {
//				ipaddress = [];
//			}
//			
//			if($("#users_list").val()) { 
//				userlist = $("#users_list").val();
//			} else {
//				userlist = [];
//			}
//			
//			if($("#post_type").val()) {
//				postlist = $("#post_type").val();
//			} else {
//				postlist = [];
//			}
//			if($('#hide_front_view').attr('checked')) {
//				var checked_val = '1';
//			} else {
//				var checked_val = '0';
//			}
//			
//			if($("#text_color_page_visit").val()) { 
//				text_color_page_visit = $("#text_color_page_visit").val();
//			} else {
//				text_color_page_visit = '';
//			}
//			
//			if($("#fb_url_page_visit").val()) { 
//				fb_url_page_visit = $("#fb_url_page_visit").val();
//			} else {
//				fb_url_page_visit = '';
//			}
//			
//			if($("#gplus_url_page_visit").val()) { 
//				gplus_url_page_visit = $("#gplus_url_page_visit").val();
//			} else {
//				gplus_url_page_visit = '';
//			}
//			
//			if($("#twitter_url_page_visit").val()) { 
//				twitter_url_page_visit = $("#twitter_url_page_visit").val();
//			} else {
//				twitter_url_page_visit = '';
//			}
//			
//			$.ajax({
//				type: "POST",
//					url: pagevisit.ajaxurl,
//					async:false,
//					data: ({
//						action:'add_page_count_option',
//						selected_posttype:unique(postlist),
//						ipaddress:unique(ipaddress),
//						userlist:unique(userlist),
//						hidefrontview:checked_val,
//						text_color_page_visit:text_color_page_visit,
//						twitter_url_page_visit:twitter_url_page_visit,
//						gplus_url_page_visit:gplus_url_page_visit,
//						fb_url_page_visit:fb_url_page_visit
//					}),
//					success: function(data) {
//						//$("td.record-mesage").empty();
//						//$("td.record-mesage").html("<h4 style='color:#075F0E;'>Settings saved Sucessfully.</h4>");
//						$("td.record-mesage").css('display','block');
//						setInterval(function(){ $("td.record-mesage").fadeOut(); }, 3000);
//					}
//				 });
//			});
			
		});
		
		$(document).ready(function(){
		    $('.my-color-field').wpColorPicker();
		});
		
		function unique(globalarr) {
			var result = [];
			$.each(globalarr, function(i, e) {
				if ($.inArray(e, result) == -1) result.push(e);
			});
			return result;
		}
		
		function ValidateIPaddress(ipaddress) {
			
			var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/; 
			if (ipaddress.match(ipformat)) {
				return 'yes';
			} else {
				return 'no';
			}
		}		
})( jQuery );