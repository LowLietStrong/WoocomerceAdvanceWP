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
	echo '<script type="text/javascript" src="'.plugins_url('/WoocomerceAdvanceWP/script.js').'"></script>';
	// Используем nonce для верификации
	//wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );
	echo "<div id='WoocomerceAdvanceWPShowMetaBox'>";
	// Поля формы для введения данных
	echo '<label for="myplugin_new_field">' . __("Description for this field", 'myplugin_textdomain' ) . '</label> ';

	$data  = unserialize(get_post_meta($post->ID,'_my_meta_value_key',true));

	print_r($data);
	echo "string";
	echo '<input type="text" id= "shop" name="shop" value="'.get_post_meta($post->ID,'_my_meta_value_key',true).'" size="25" />';
	echo '<input type="text" id= "myplugin_new_field" name="myplugin_new_field" value="'.get_post_meta($post->ID,'_my_meta_value_key',true).'" size="25" />';

	echo "<button onclick='add_market_meta(); return false;'>ADD</button>";
	echo "</div>";
}
?>

<?php 
/* Сохраняем данные, когда пост сохраняется */
function WoocomerceAdvanceWPSavePostdata( $post_id ) {
	// проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
	//if ( ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) ) )
	//	return $post_id;

	// проверяем, если это автосохранение ничего не делаем с данными нашей формы.
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	// проверяем разрешено ли пользователю указывать эти данные
	if ( 'page' == $_POST['post_type'] && ! current_user_can( 'edit_page', $post_id ) ) {
		  return $post_id;
	} elseif( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// Убедимся что поле установлено.
	if ( ! isset( $_POST['myplugin_new_field'] ) )
		return;

	// Все ОК. Теперь, нужно найти и сохранить данные
	// Очищаем значение поля input.
	$my_data[] = sanitize_text_field( $_POST['shop'] );
	$my_data[] = sanitize_text_field( $_POST['myplugin_new_field'] );


	$data = serialize($my_data);
	// Обновляем данные в базе данных.
	update_post_meta( $post_id, '_my_meta_value_key', $data );
}
add_action( 'save_post', 'WoocomerceAdvanceWPSavePostdata' );

//if (is_admin()) echo "<script>alert('ADMIN');</script>";

 ?>