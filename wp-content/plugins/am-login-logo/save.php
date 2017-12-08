<?php 
   if(isset($_POST['amll_section_general_button'])){
   
      /* change login page background color */
      if(!($_POST['amll_loginpagebackgroundcolor']=='')){
          $amll_loginpagebackgroundcolor = sanitize_text_field($_POST['amll_loginpagebackgroundcolor']); 
          if(get_option("wp_sett_loginpagebackgroundcolor")){
            update_option("wp_sett_loginpagebackgroundcolor",$amll_loginpagebackgroundcolor);
          }
          else{
            add_option("wp_sett_loginpagebackgroundcolor",$amll_loginpagebackgroundcolor);
          }
      }

      /* Upload login page Logo */
      if (!($_FILES["amll_loginpagebackgroundimage"]["name"]=="")){

            $wp_sett_loginpagebackgroundimage = sanitize_file_name($_FILES["amll_loginpagebackgroundimage"]["name"]);
            $amll_uploads = wp_upload_dir(); 
            $amll_loginpagebackground = $amll_uploads['basedir'].'/'.basename($wp_sett_loginpagebackgroundimage);
            $amll_loginpagebackgroundimage =  $amll_uploads['baseurl'].'/'.basename($wp_sett_loginpagebackgroundimage);

            $amll_flag_loginpagebackgroundimage = 1;
            // Check if image file is a actual image or fake image
            $amll_imageFileType = pathinfo($amll_loginpagebackground,PATHINFO_EXTENSION);

            // Check if image file is a actual image or fake image
            $amll_check = getimagesize($_FILES["amll_loginpagebackgroundimage"]["tmp_name"]);
            if($amll_check !== false) {
              $amll_flag_loginpagebackgroundimage = 1;
            } else {
              echo "File is not an image.";
              $amll_flag_loginpagebackgroundimage = 0;
              exit;
            }
            
            // Check file size
            if ($_FILES["amll_loginpagebackgroundimage"]["size"] > 500000) {
              echo "Sorry, your file is too large.";
              $amll_flag_loginpagebackgroundimage = 0;
              exit;
            }

            // Allow certain file formats
            if($amll_imageFileType != "jpg" && $amll_imageFileType != "png" && $amll_imageFileType != "jpeg" && $amll_imageFileType != "gif" ) {
              echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
              $amll_flag_loginpagebackgroundimage = 0;
              exit;
            }

            if ($amll_flag_loginpagebackgroundimage == 0) {
              echo "Sorry, your file was not uploaded."; exit;
            } else {
              if (move_uploaded_file($_FILES["amll_loginpagebackgroundimage"]["tmp_name"],$amll_loginpagebackground)) {
                  if(get_option("wp_sett_loginpagebackgroundimage")){
                    update_option("wp_sett_loginpagebackgroundimage", $amll_loginpagebackgroundimage);
                  }
                  else{
                   add_option("wp_sett_loginpagebackgroundimage", $amll_loginpagebackgroundimage);
                  }
                } else {
                echo "Sorry, there was an error uploading your file.";  exit;
              }
            } 
        }  
    
       /* code for change login page form background color */
        if(!($_POST['amll_loginpageformbackgroundcolor']=='')){
            $amll_loginpageformbackgroundcolor = sanitize_text_field($_POST['amll_loginpageformbackgroundcolor']); 
            if(get_option("wp_sett_loginpageformbackgroundcolor")){
              update_option("wp_sett_loginpageformbackgroundcolor",$amll_loginpageformbackgroundcolor);
            }
            else{
              add_option("wp_sett_loginpageformbackgroundcolor",$amll_loginpageformbackgroundcolor);
            }
        }
       
        /* code for change login page form field background color */
        if(!($_POST['amll_loginpageformfieldbackgroundcolor']=='')){
          $amll_loginpageformfieldbackgroundcolor = sanitize_text_field($_POST['amll_loginpageformfieldbackgroundcolor']); 
          /* adding values in database */ 
          if(get_option("wp_sett_loginpageformfieldbackgroundcolor")){
            update_option("wp_sett_loginpageformfieldbackgroundcolor",$amll_loginpageformfieldbackgroundcolor);
          }
          else{
            add_option("wp_sett_loginpageformfieldbackgroundcolor",$amll_loginpageformfieldbackgroundcolor);
          }
        }

        /* code for change login page form font color */
        if(!($_POST['amll_loginpageformfontcolor']=='')){
          $amll_loginpageformfontcolor = sanitize_text_field($_POST['amll_loginpageformfontcolor']); 
          if(get_option("wp_sett_loginpageformfontcolor")){
            update_option("wp_sett_loginpageformfontcolor",$amll_loginpageformfontcolor);
          }
          else{
            add_option("wp_sett_loginpageformfontcolor",$amll_loginpageformfontcolor);
          }
        }

        /* code for upload login logo */ 
        if (!($_FILES["amll_loginlogo"]["name"]=="")){

          $wp_sett_loginlogo = sanitize_file_name($_FILES["amll_loginlogo"]["name"]);
          $amll_uploads = wp_upload_dir(); 
          $amll_loginlogo = $amll_uploads['basedir'].'/'.basename($wp_sett_loginlogo);
          $amll_loginlogoimage =  $amll_uploads['baseurl'].'/'.basename($wp_sett_loginlogo);

          $amll_flag_loginlogo = 1;
          // Check if image file is a actual image or fake image

          $amll_imageFileType = pathinfo($amll_loginlogo,PATHINFO_EXTENSION);
          // Check if image file is a actual image or fake image

          $amll_check = getimagesize($_FILES["amll_loginlogo"]["tmp_name"]);
          
            if($amll_check !== false) {
              $amll_flag_loginlogo = 1;
            } else {
              echo "File is not an image.";
              $amll_flag_loginlogo = 0;
              exit;
            }

            // Check file size
            if ($_FILES["amll_loginlogo"]["size"] > 500000) {
              echo "Sorry, your file is too large.";
              $amll_flag_loginlogo = 0;
              exit;
            }

            // Allow certain file formats
            if($amll_imageFileType != "jpg" && $amll_imageFileType != "png" && $amll_imageFileType != "jpeg" && $amll_imageFileType != "gif" ) {
              echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
              $amll_flag_loginlogo = 0;
              exit;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($amll_flag_loginlogo == 0) {
              echo "Sorry, your file was not uploaded."; exit;
              // if everything is ok, try to upload file
            } else {
              if (move_uploaded_file($_FILES["amll_loginlogo"]["tmp_name"],$amll_loginlogo)) {
                /* adding values in database */ 
                if(get_option("wp_sett_loginlogo")){
                  update_option("wp_sett_loginlogo", $amll_loginlogoimage );
                }
                else{
                  add_option("wp_sett_loginlogo",$amll_loginlogoimage);
                }
              } else {
                echo "Sorry, there was an error uploading your file.";  exit;
              }
            }
          }
        }  
       
   if(isset($_POST['amll_section_general_reset'])){
     delete_option('wp_sett_faviconimage');
     delete_option('wp_sett_uploadfilesize');
     delete_option('wp_sett_loginpagebackgroundcolor');
     delete_option('wp_sett_loginpageformbackgroundcolor');
     delete_option('wp_sett_loginpageformfieldbackgroundcolor');
     delete_option('wp_sett_loginpageformfontcolor');
     delete_option('wp_sett_loginlogo');
   }

if(isset($_POST['amll_section_advanced_button'])){
  
    /* code for change navigation background color */
    if(!($_POST['amll_navigationbackgroundcolor']=='')){
        $amll_navigationbackgroundcolor = sanitize_text_field($_POST['amll_navigationbackgroundcolor']); 
        if(get_option("wp_sett_navigationbackgroundcolor")){
          update_option("wp_sett_navigationbackgroundcolor",$amll_navigationbackgroundcolor);
        }
        else{
          add_option("wp_sett_navigationbackgroundcolor",$amll_navigationbackgroundcolor);
        }
    }

    /* code for change navigation font color */
    if(!($_POST['amll_navigationfontcolor']=='')){
      $amll_navigationfontcolor = sanitize_text_field($_POST['amll_navigationfontcolor']);
      if(get_option("wp_sett_navigationfontcolor")){
        update_option("wp_sett_navigationfontcolor",$amll_navigationfontcolor);
      }
      else{
        add_option("wp_sett_navigationfontcolor",$amll_navigationfontcolor);
      }
    }

    /* code for change navigation font hover color */
    if(!($_POST['amll_navigationfonthovercolor']=='')){
      $amll_navigationfonthovercolor = sanitize_text_field($_POST['amll_navigationfonthovercolor']); 
      if(get_option("wp_sett_navigationfonthovercolor")){
       update_option("wp_sett_navigationfonthovercolor",$amll_navigationfonthovercolor);
      }
      else{
        add_option("wp_sett_navigationfonthovercolor",$amll_navigationfonthovercolor);
      }
    }
      
    /* code for change navigation font hover background color */
    if(!($_POST['amll_navigationhoverbackgroundcolor']=='')){
      $amll_navigationhoverbackgroundcolor = sanitize_text_field($_POST['amll_navigationhoverbackgroundcolor']); 
      if(get_option("wp_sett_navigationhoverbackgroundcolor")){
        update_option("wp_sett_navigationhoverbackgroundcolor",$amll_navigationhoverbackgroundcolor);
      }
      else{
        add_option("wp_sett_navigationhoverbackgroundcolor",$amll_navigationhoverbackgroundcolor);
      }
    }
    
    /* code for change sub navigation background color */
    if(!($_POST['amll_subnavigationbackgroundcolor']=='')){
      $amll_subnavigationbackgroundcolor = sanitize_text_field($_POST['amll_subnavigationbackgroundcolor']); 
      if(get_option("wp_sett_subnavigationbackgroundcolor")){
       update_option("wp_sett_subnavigationbackgroundcolor",$amll_subnavigationbackgroundcolor);
      }
      else{
        add_option("wp_sett_subnavigationbackgroundcolor",$amll_subnavigationbackgroundcolor);
      }
    }

    /* code for change sub navigation font color  */
    if(!($_POST['amll_subnavigationfontcolor']=='')){
      $amll_subnavigationfontcolor = sanitize_text_field($_POST['amll_subnavigationfontcolor']); 
      if(get_option("wp_sett_subnavigationfontcolor")){
        update_option("wp_sett_subnavigationfontcolor",$amll_subnavigationfontcolor);
      }
      else{
        add_option("wp_sett_subnavigationfontcolor",$amll_subnavigationfontcolor);
      }
    }
      
    /* code for change icons color */
    if(!($_POST['amll_iconscolor']=='')){
      $amll_iconscolor = sanitize_text_field($_POST['amll_iconscolor']); 
      if(get_option("wp_sett_iconscolor")){
       update_option("wp_sett_iconscolor",$amll_iconscolor);
      }
      else{
        add_option("wp_sett_iconscolor",$amll_iconscolor);
      }
    }
   
    /* code for change howdy text */
    if(!($_POST['amll_howdytext'])==""){
      $amll_howdytext = sanitize_text_field($_POST['amll_howdytext']);
      if(get_option("wp_sett_howdytext")){
       update_option("wp_sett_howdytext", $amll_howdytext );
      }
      else{
        add_option("wp_sett_howdytext",$amll_howdytext);
      }
    }


    /* code for change footer text  */
    if(!($_POST['amll_footertext'])==""){
      $amll_footertext = sanitize_text_field($_POST['amll_footertext']);
      if(get_option("wp_sett_footertext")){
        update_option("wp_sett_footertext", $amll_footertext );
      }
      else{
        add_option("wp_sett_footertext",$amll_footertext);
      }
    }
       
               
    /* code for hide admin logo */
    if(isset($_POST['amll_hideadminlogo'])){

      $amll_hideadminlogo = sanitize_text_field($_POST['amll_hideadminlogo']);
      if(get_option("wp_sett_hideadminlogo")){
        update_option("wp_sett_hideadminlogo",$amll_hideadminlogo);
      }
      else{
        add_option("wp_sett_hideadminlogo",$amll_hideadminlogo);
      }
    } else {
      $amll_hideadminlogo = "show";
      if(get_option("wp_sett_hideadminlogo")){
        update_option("wp_sett_hideadminlogo",$amll_hideadminlogo);
      }
      else{
        add_option("wp_sett_hideadminlogo",$amll_hideadminlogo);
      }
    }
       
    /* code for hide admin bar  */
    if(isset($_POST['amll_hideadminbar'])){

        $amll_hideadminbar = sanitize_text_field($_POST['amll_hideadminbar']);
        if(get_option("wp_sett_hideadminbar")){
          update_option("wp_sett_hideadminbar",$amll_hideadminbar);
        }
        else{
          add_option("wp_sett_hideadminbar",$amll_hideadminbar);
        }
      } else {
        $amll_hideadminbar = "show";
        if(get_option("wp_sett_hideadminbar")){
          update_option("wp_sett_hideadminbar",$amll_hideadminbar);
        }
        else{
          add_option("wp_sett_hideadminbar",$amll_hideadminbar);
        }
      }
    }

                      
    if(isset($_POST['amll_section_advanced_reset'])){

        delete_option('wp_sett_navigationbackgroundcolor');
        delete_option('wp_sett_navigationfontcolor');
        delete_option('wp_sett_navigationfonthovercolor');
        delete_option('wp_sett_navigationhoverbackgroundcolor');
        delete_option('wp_sett_subnavigationbackgroundcolor');
        delete_option('wp_sett_subnavigationfontcolor');
        delete_option('wp_sett_iconscolor');
        delete_option('wp_sett_howdytext');
        delete_option('wp_sett_footertext');


        if(get_option($amll_current_admin_id)){
          delete_option($amll_current_admin_id);
        }
        delete_option('wp_sett_hideadminlogo');
        delete_option('wp_sett_hideadminbar');
    }
?>