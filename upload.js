
        
         
        function image_upload(id){
         formfield = jQuery('#shop_image'+id).attr('name');  
         tb_show('', 'media-upload.php?type=image&TB_iframe=true&ETI_field=shop_image'+id);  
      
         window.send_to_editor = function(html) {  
         imgurl = jQuery('img',html).attr('src'); 
         jQuery('input[name='+formfield+']').val(imgurl);  
         tb_remove();  
        }  
         return false;  
        };  
      

