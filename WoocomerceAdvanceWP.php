<?php 
/*
Plugin Name: WoocomerceAdvanceWP
Description: WoocomerceAdvanceWP
Version: 1.0
Author: WebWare
*/

function WoocomerceAdvanceWP_add_custom_box() {
		add_meta_box( 'myplugin_sectionid', 'WoocomerceAdvanceWP', 'WoocomerceAdvanceWPShowMetaBox', 'product' );
}
add_action('add_meta_boxes', 'WoocomerceAdvanceWP_add_custom_box');

function checkboxstatus($status){ if ($status) return "checked"; }

/* HTML код блока */
function WoocomerceAdvanceWPShowMetaBox($post) {

	$data  = unserialize(get_post_meta($post->ID,'_my_meta_value_key',true));
	//print_r($data);

	echo "<script>var product = []; var sub = [[]];</script>";
	
	echo "<div id='WoocomerceAdvanceWPShowMetaBox'>";
	echo "";
	$i = 0;
	if (!empty($data)) {
		foreach ($data as $key => $market) {
			echo "<div id='MarkeID".$i."'>";

			echo ' MarketIcon Url: <input id="shop_image'.$i.'" type="text" size="90" name="shop_image'.$i.'" value="'.$market['MarketIcon'].'" /> OR ';
			echo '<input type="button" class="button" value="Upload" onclick="image_upload('.$i.')" /><br>';
			echo ' MarketName <input type="text" 	 name="MarketName_N'.$i.'" value="'.$market['MarketName'].'">';
			echo ' ProdName   <input type="text" 	 name="ProdName_N'.$i.'"   value="'.$market['ProdName'].'"><br><br>';
			echo ' ProdPrice  <input type="number" 	 name="ProdPrice_N'.$i.'"  value="'.$market['ProdPrice'].'">';
			echo ' ProdWeight <input type="number" 	 name="ProdWeight_N'.$i.'" value="'.$market['ProdWeight'].'">';
			echo ' ProdInfo   <input type="text" 	 name="ProdInfo_N'.$i.'"   value="'.$market['ProdInfo'].'">';
			echo ' InStock 	  <input type="checkbox" name="InStock_N'.$i.'"	   '.checkboxstatus($market['InStock']).' value="1"><br>';
			
			$submain = 0;
			if (!empty($market['SubtypeMain'])) {
				foreach ($market['SubtypeMain'] as $SubtypeMain) {
					echo "<div id='MarkeID".$i."_Sub".$SubtypeMain."'>";
					echo "&nbsp;";
					echo ' Subtype <input type="text" 	  name="SubtypeName_N'.$i.'_Alt'.$a.'_Sub'.$sub.'" 			  value="'.$SubtypeMain['SubtypeName'].'">';
					echo ' InStock <input type="checkbox" name="InStock_N'.$i.'_Alt'.$a.'_Sub'.$sub.'"   			  value="1" '.checkboxstatus($SubtypeMain['InStock']).'>';
					echo " <input type='button' onclick='remove_market_meta(\"MarkeID".$i."_Alt".$a."_Sub".$sub."\")' value='Remove' class='button button-small'><br>";
					echo '</div>';
					$submain++;
				}
			}


			echo "<br>";

			$a = 0;
			echo "<div id='MarkeID_ShowAlt".$i."'>";
			if (!empty($market['Alt'])) {
				foreach ($market['Alt'] as $altprod) {
					echo "<div id='MarkeID".$i."_Alt".$a."'>";
					echo ' ProdPrice  <input type="number" 	 name="ProdPrice_N'.$i.'_Alt'.$a.'"  value="'.$altprod['ProdPrice'].'">';
					echo ' ProdWeight <input type="number" 	 name="ProdWeight_N'.$i.'_Alt'.$a.'" value="'.$altprod['ProdWeight'].'">';
					echo ' ProdInfo   <input type="text" 	 name="ProdInfo_N'.$i.'_Alt'.$a.'"   value="'.$altprod['ProdInfo'].'">';
					echo ' InStock 	  <input type="checkbox" name="InStock_N'.$i.'_Alt'.$a.'"	'.checkboxstatus($altprod['InStock']).' value="1">';

					echo " <input type='button' onclick='add_subtupe_meta(".$i.",".$a.")' value='Add Subtype' class='button button-small'>";
					echo " <input type='button' onclick='remove_market_meta(\"MarkeID".$i."_Alt".$a."\")' value='Remove' class='button button-small'><br>";

					$sub = 0;
					if (!empty($altprod['Subtype'])) {
						foreach ($altprod['Subtype'] as $Subtype) {
							echo "<div id='MarkeID".$i."_Alt".$a."_Sub".$sub."'>";
							echo "&nbsp;";
							echo ' Subtype  <input type="text" 	  name="SubtypeName_N'.$i.'_Alt'.$a.'_Sub'.$sub.'" value="'.$Subtype['SubtypeName'].'">';
							echo ' InStock <input type="checkbox" name="InStock_N'.$i.'_Alt'.$a.'_Sub'.$sub.'"   value="1" '.checkboxstatus($Subtype['InStock']).'>';
							echo " <input type='button' onclick='remove_market_meta(\"MarkeID".$i."_Alt".$a."_Sub".$sub."\")' value='Remove' class='button button-small'><br>";
							echo '</div>';
							$sub++;
						}
					}
					echo "<script>sub[".$i."][".$a."] =".$sub.";</script>";
					echo '<input type="hidden" name="count_subtype_N'.$i.'_Alt'.$a.'" id="count_subtype_N'.$i.'_Alt'.$a.'" value="'.$sub.'">';



					echo '</div>';
					echo "<br>";
					$a++;
				}
			}
			echo "<script>product[".$i."] =".$a.";</script>";
			echo "<script>sub[".$i."] = [".$a."];</script>";
			echo "</div>";


			echo '<input type="hidden" name="count_alt_N'.$i.'" id="count_alt_N'.$i.'" value="'.$a.'">';
			echo "<input type='button' onclick='remove_market_meta(\"MarkeID".$i."\")' value='Remove' class='button'>";
			echo " <input type='button' onclick='add_product_meta(".$i.")' value='Add product' class='button'>";
			echo '<br><br><hr><hr><br>';
			echo "</div>";
			$i++;	
		}
	}

	echo "<script>var i =".$i.";</script>";

	
	echo "</div>";

	echo '<script type="text/javascript" src="'.plugins_url('/WoocomerceAdvanceWP/script.js').'"></script>';

	
	echo '<input type="hidden" name="count_markets" id="count_markets" value="'.$i.'">';
	echo "<input type='button' onclick='add_market_meta(i)' value='Add store' class='button'>";

}
?>

<?php
/* Сохраняем данные, когда пост сохраняется */
function WoocomerceAdvanceWPSavePostdata( $post_id ) {

	// проверяем, если это автосохранение ничего не делаем с данными нашей формы.
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	// проверяем разрешено ли пользователю указывать эти данные
	if ( 'page' == $_POST['post_type'] && ! current_user_can( 'edit_page', $post_id ) ) {
		  return $post_id;
	} elseif( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	$counter =   sanitize_text_field( $_POST['count_markets'] );

	// Убедимся что поле установлено.
	if ( $counter == 0)	return;

	// Все ОК. Теперь, нужно найти и сохранить данные

	for ($i=0; $i < $counter; $i++) {
		if (!empty($_POST['shop_image'.$i]) AND !empty($_POST['MarketName_N'.$i]) AND !empty($_POST['ProdName_N'.$i]) AND !empty($_POST['ProdPrice_N'.$i]) AND !empty($_POST['ProdWeight_N'.$i]) AND !empty($_POST['ProdInfo_N'.$i])) {
			$my_data[$i]['MarketIcon'] 	= sanitize_text_field( $_POST['shop_image'.$i] );
			$my_data[$i]['MarketName'] 	= sanitize_text_field( $_POST['MarketName_N'.$i] );
			$my_data[$i]['ProdName'] 	= sanitize_text_field( $_POST['ProdName_N'.$i] );
			$my_data[$i]['ProdPrice'] 	= sanitize_text_field( $_POST['ProdPrice_N'.$i] );
			$my_data[$i]['ProdWeight'] 	= sanitize_text_field( $_POST['ProdWeight_N'.$i] );
			$my_data[$i]['ProdInfo'] 	= sanitize_text_field( $_POST['ProdInfo_N'.$i] );
			$my_data[$i]['InStock'] 	= sanitize_text_field( $_POST['InStock_N'.$i] );
			$counter_alt =   sanitize_text_field( $_POST['count_alt_N'.$i] );
			if ($counter_alt != 0) {
				for ($a=0; $a < $counter_alt; $a++) {
					if (!empty($_POST['ProdPrice_N'.$i.'_Alt'.$a]) AND !empty($_POST['ProdWeight_N'.$i.'_Alt'.$a]) AND !empty($_POST['ProdInfo_N'.$i.'_Alt'.$a])) {
						$my_data[$i]['Alt'][$a]['ProdPrice']  = sanitize_text_field( $_POST['ProdPrice_N'.$i.'_Alt'.$a] );
						$my_data[$i]['Alt'][$a]['ProdWeight'] = sanitize_text_field( $_POST['ProdWeight_N'.$i.'_Alt'.$a] );
						$my_data[$i]['Alt'][$a]['ProdInfo']   = sanitize_text_field( $_POST['ProdInfo_N'.$i.'_Alt'.$a] );
						$my_data[$i]['Alt'][$a]['InStock'] 	  = sanitize_text_field( $_POST['InStock_N'.$i.'_Alt'.$a] );
						$counter_sub =   sanitize_text_field( $_POST['count_subtype_N'.$i.'_Alt'.$a] );
						if ($counter_sub != 0) {
							for ($sub=0; $sub < $counter_sub; $sub++) {
								if (!empty($_POST['SubtypeName_N'.$i.'_Alt'.$a.'_Sub'.$sub])) {
									$my_data[$i]['Alt'][$a]['Subtype'][$sub]['SubtypeName'] = sanitize_text_field( $_POST['SubtypeName_N'.$i.'_Alt'.$a.'_Sub'.$sub] );
									$my_data[$i]['Alt'][$a]['Subtype'][$sub]['InStock'] 	= sanitize_text_field( $_POST['InStock_N'.$i.'_Alt'.$a.'_Sub'.$sub] );
								}
							}
						}




					}
				}
			}

		 } 
	}


	$data = serialize($my_data);
	// Обновляем данные в базе данных.
	update_post_meta( $post_id, '_my_meta_value_key', $data );
}
add_action( 'save_post', 'WoocomerceAdvanceWPSavePostdata' );

 ?>

 <?php 
/*
Code wp loader image
 */

    function my_add_upload_scripts() {  
        wp_enqueue_script('media-upload');  
        wp_enqueue_script('thickbox');  
        wp_register_script(  
                    'my-upload-script'  
                    /* Подключаем JS-код задающий поведение  
                     * загрузчика и указывающий, куда вставлять  
                     * ссылку после загрузки изображения 
                     * Его код будет приведен ниже. 
                     */  
                    ,plugins_url('/WoocomerceAdvanceWP/upload.js')  
                    /* Указываем скрипты, от которых  
                     * зависит наш JS-код 
                     */  
                    ,array('jquery','media-upload','thickbox')  
        );  
        wp_enqueue_script('my-upload-script');  
    }  
      
    // Запускаем функцию подключения загрузчика  
    if( is_admin() )  
    add_action('admin_print_scripts', 'my_add_upload_scripts');  

  ?>