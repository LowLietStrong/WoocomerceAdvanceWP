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

/* HTML код блока */
function WoocomerceAdvanceWPShowMetaBox($post) {

	$data  = unserialize(get_post_meta($post->ID,'_my_meta_value_key',true));
	print_r($data);


	echo "<div id='WoocomerceAdvanceWPShowMetaBox'>";
	echo "";
	$i = 0;
	foreach ($data as $key => $market) {
		echo "<div id='MarkeID".$i."'>";
		echo 'MarketName <input type="text" 	name="MarketName_N'.$i.'" value="'.$market['MarketName'].'"><br>';
		echo 'ProdName 	 <input type="text" 	name="ProdName_N'.$i.'"   value="'.$market['ProdName'].'"><br>';
		echo 'ProdPrice  <input type="number" 	name="ProdPrice_N'.$i.'"  value="'.$market['ProdPrice'].'"><br>';
		echo 'ProdWeight <input type="number" 	name="ProdWeight_N'.$i.'" value="'.$market['ProdWeight'].'"><br>';
		echo 'ProdInfo 	 <input type="text" 	name="ProdInfo_N'.$i.'"   value="'.$market['ProdInfo'].'"><br>';
		echo 'InStock 	 <input type="checkbox"	name="InStock_N'.$i.'"	  value="'.$market['InStock'].'"><br>';
		echo "<input type='button' onclick='remove_market_meta(\"MarkeID".$i."\")' value='Remove'>";
		echo '<hr>';
		echo "</div>";
		$i++;	
	}

	echo "<script>var i =".$i.";</script>";

	
	echo "</div>";

	echo '<script type="text/javascript" src="'.plugins_url('/WoocomerceAdvanceWP/script.js').'"></script>';

	
	echo '<input type="hidden" name="count_markets" id="count_markets" value="'.$i.'">';
	echo "<input type='button' onclick='add_market_meta(i)' value='ADD'>";

}

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
		$my_data[$i]['MarketName'] 	= sanitize_text_field( $_POST['MarketName_N'.$i] );
		$my_data[$i]['ProdName'] 	= sanitize_text_field( $_POST['ProdName_N'.$i] );
		$my_data[$i]['ProdPrice'] 	= sanitize_text_field( $_POST['ProdPrice_N'.$i] );
		$my_data[$i]['ProdWeight'] 	= sanitize_text_field( $_POST['ProdWeight_N'.$i] );
		$my_data[$i]['ProdInfo'] 	= sanitize_text_field( $_POST['ProdInfo_N'.$i] );
		$my_data[$i]['InStock'] 	= sanitize_text_field( $_POST['InStock_N'.$i] );

	}


	$data = serialize($my_data);
	// Обновляем данные в базе данных.
	update_post_meta( $post_id, '_my_meta_value_key', $data );
}
add_action( 'save_post', 'WoocomerceAdvanceWPSavePostdata' );


 ?>