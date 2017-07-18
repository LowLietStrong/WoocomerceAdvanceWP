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
	print_r($data);

	echo "<script>var product = []; var sub = [[]];var submain = [];</script>";
	
	echo "<div id='WoocomerceAdvanceWPShowMetaBox'>";
	echo "";
	$i = 0;
	if (!empty($data)) {
		foreach ($data as $key => $market) {
			echo "<div id='MarkeID".$i."'>";

			echo ' Вставте Url логотипа: <input id="shop_image'.$i.'" type="text" size="90" name="shop_image'.$i.'" value="'.$market['MarketIcon'].'" /> ИЛИ ';
			echo '<input type="button" class="button" value="Загрузить" onclick="image_upload('.$i.')" /><br>';
			echo ' Url Магазина: 		 <input type="text"     name="MarketUrl_N'.$i.'"  value="'.$market['MarketUrl'].'" size="90">';
			echo ' Наименование продукта: <input type="text"     name="ProdName_N'.$i.'"   value="'.$market['ProdName'].'"><br><br>';
			echo ' Цена: 				 <input type="number"   name="ProdPrice_N'.$i.'"  value="'.$market['ProdPrice'].'">';
			echo ' Вес:  				 <input type="number"   name="ProdWeight_N'.$i.'" value="'.$market['ProdWeight'].'">';
			echo ' Описание: 		     <input type="text"     name="ProdInfo_N'.$i.'"   value="'.$market['ProdInfo'].'">';
			echo ' Наличие:	   			 <input type="checkbox" name="InStock_N'.$i.'"	'.checkboxstatus($market['InStock']).' value="1"> ';
			echo " <input type='button' onclick='add_mainsubtupe_meta(".$i.")' value='Добавить вкус' class='button button-small'><br>";

			echo "<div id='MarkeID_SubtypeMain".$i."'>";
			$submain = 0;
			if (!empty($market['SubtypeMain'])) {
				foreach ($market['SubtypeMain'] as $SubtypeMain) {
					echo "<div id='MarkeID".$i."_SubMain".$submain."'>";
					echo "&nbsp;";
					echo ' Вкус: <input type="text" 	  name="SubtypeName_N'.$i.'_SubMain'.$submain.'" 		    value="'.$SubtypeMain['SubtypeName'].'">';
					echo ' Наличие: <input type="checkbox" name="InStock_N'.$i.'_SubMain'.$submain.'"   			    value="1" '.checkboxstatus($SubtypeMain['InStock']).'>';
					echo " <input type='button' onclick='remove_market_meta(\"MarkeID".$i."_SubMain".$submain."\")' value='Удалить вкус' class='button button-small'><br>";
					echo '</div>';
					$submain++;
				}
			}
			echo '</div>';
			echo '<input type="hidden" name="count_subtypemain_N'.$i.'" id="count_subtypemain_N'.$i.'" value="'.$submain.'">';
			echo "<script>submain[".$i."] =".$submain.";</script>";



			echo "<br>";

			$a = 0;
			echo "<div id='MarkeID_ShowAlt".$i."'>";
			if (!empty($market['Alt'])) {
				foreach ($market['Alt'] as $altprod) {
					echo "<div id='MarkeID".$i."_Alt".$a."'>";
					echo ' Цена:  	 <input type="number" 	 name="ProdPrice_N'.$i.'_Alt'.$a.'"  value="'.$altprod['ProdPrice'].'">';
					echo ' Вес:	 	 <input type="number" 	 name="ProdWeight_N'.$i.'_Alt'.$a.'" value="'.$altprod['ProdWeight'].'">';
					echo ' Описание: <input type="text" 	 name="ProdInfo_N'.$i.'_Alt'.$a.'"   value="'.$altprod['ProdInfo'].'">';
					echo ' Наличие:  <input type="checkbox"  name="InStock_N'.$i.'_Alt'.$a.'"	'.checkboxstatus($altprod['InStock']).' value="1">';

					echo " <input type='button' onclick='add_subtupe_meta(".$i.",".$a.")' value='Добавить вкус' class='button button-small'>";
					echo " <input type='button' onclick='remove_market_meta(\"MarkeID".$i."_Alt".$a."\")' value='Удалить продукт' class='button button-small'><br>";

					$sub = 0;
					if (!empty($altprod['Subtype'])) {
						foreach ($altprod['Subtype'] as $Subtype) {
							echo "<div id='MarkeID".$i."_Alt".$a."_Sub".$sub."'>";
							echo "&nbsp;";
							echo ' Вкус:  <input type="text" 	  name="SubtypeName_N'.$i.'_Alt'.$a.'_Sub'.$sub.'" value="'.$Subtype['SubtypeName'].'">';
							echo ' Наличие: <input type="checkbox" name="InStock_N'.$i.'_Alt'.$a.'_Sub'.$sub.'"   value="1" '.checkboxstatus($Subtype['InStock']).'>';
							echo " <input type='button' onclick='remove_market_meta(\"MarkeID".$i."_Alt".$a."_Sub".$sub."\")' value='Удалить вкус' class='button button-small'><br>";
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
			echo "<input type='button' onclick='remove_market_meta(\"MarkeID".$i."\")' value='Удалить магазин' class='button'>";
			echo " <input type='button' onclick='add_product_meta(".$i.")' value='Добавить продукт' class='button'>";
			echo '<br><br><hr><hr><br>';
			echo "</div>";
			$i++;	
		}
	}

	echo "<script>var i =".$i.";</script>";

	
	echo "</div>";

	echo '<script type="text/javascript" src="'.plugins_url('/WoocomerceAdvanceWP/script.js').'"></script>';

	
	echo '<input type="hidden" name="count_markets" id="count_markets" value="'.$i.'">';
	echo "<input type='button' onclick='add_market_meta(i)' value='Добавить магазин' class='button'>";

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
		if (!empty($_POST['shop_image'.$i]) AND !empty($_POST['MarketUrl_N'.$i]) AND !empty($_POST['ProdName_N'.$i]) AND !empty($_POST['ProdPrice_N'.$i]) AND !empty($_POST['ProdWeight_N'.$i]) AND !empty($_POST['ProdInfo_N'.$i])) {
			$my_data[$i]['MarketIcon'] 	= sanitize_text_field( $_POST['shop_image'.$i] );
			$my_data[$i]['MarketUrl'] 	= sanitize_text_field( $_POST['MarketUrl_N'.$i] );
			$my_data[$i]['ProdName'] 	= sanitize_text_field( $_POST['ProdName_N'.$i] );
			$my_data[$i]['ProdPrice'] 	= sanitize_text_field( $_POST['ProdPrice_N'.$i] );
			$my_data[$i]['ProdWeight'] 	= sanitize_text_field( $_POST['ProdWeight_N'.$i] );
			$my_data[$i]['ProdInfo'] 	= sanitize_text_field( $_POST['ProdInfo_N'.$i] );
			$my_data[$i]['InStock'] 	= sanitize_text_field( $_POST['InStock_N'.$i] );
			

			$count_subtypemain  = sanitize_text_field( $_POST['count_subtypemain_N'.$i] );
			if ($count_subtypemain != 0) {
				for ($s=0; $s < $count_subtypemain; $s++) {
					if (!empty($_POST['SubtypeName_N'.$i.'_SubMain'.$s])) {
						$my_data[$i]['SubtypeMain'][$s]['SubtypeName'] = sanitize_text_field( $_POST['SubtypeName_N'.$i.'_SubMain'.$s] );
						$my_data[$i]['SubtypeMain'][$s]['InStock'] 	   = sanitize_text_field( $_POST['InStock_N'.$i.'_SubMain'.$s] );
					}
				}
			}

			$counter_alt = sanitize_text_field( $_POST['count_alt_N'.$i] );
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
	

<?php 

function register_my_widgets(){
	register_sidebar( array(
		'name'          => 'WoocomerceAdvanceWPBar',
		'id'            => "WoocomerceAdvanceWPBar",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => "</li>\n",
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => "</h2>\n",
	) );
}

add_action( 'widgets_init', 'register_my_widgets' );
 ?>

 <?php 

class My_Widget extends WP_Widget {

	function __construct() {
		// Запускаем родительский класс
		parent::__construct(
			'WoocomerceAdvanceWP', 
			'WoocomerceAdvanceWP',
			array('description' => 'WoocomerceAdvanceWP')
		);

		// стили скрипты виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_my_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_my_widget_style' ) );
		}
	}

	// Вывод виджета
	function widget( $args, $instance ){

		
		function taste_stock_class($InStock){
			if ($InStock == 1) echo 'stock-prod';
			else echo 'stock-prod-out';
		}
		function stock_class($InStock){
			if ($InStock == 1) echo 'stock-prod-in';
			else echo 'stock-prod-out';
		}
		function stock_text($InStock){
			if ($InStock == 1) echo 'В наличии';
			else echo 'Нет в наличии';
		}
		if (!empty(get_post_meta(get_the_ID(),'_my_meta_value_key',true))) {

			$data  = unserialize(get_post_meta(get_the_ID(),'_my_meta_value_key',true));
		    echo	'<div class="title-avalible">Стоимость, наличие товара в интернет-магазинах</div>';

			foreach ($data as $i => $market) { 
			?>
		     		<div class="tab-accardion-price">
		     			<input id="tab-<?php echo $i; ?>" type="checkbox" name="tabs">     
				    <div class="col-sm-12 col-xs-12 tab">
					  <label for="tab-<?php echo $i; ?>">
						  <div class="col-sm-1 col-xs-4 plus"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>
						  <div class="col-sm-3 col-xs-8 image"><img src="<?php echo $market['MarketIcon']; ?>"></div>
						   <div class="clearfix visible-xs"></div>
						  <div class="col-sm-5 col-xs-6 title"><span class="title-acc"><?php wp_title(''); ?></span></div>
						  <div class="col-sm-3 col-xs-6 title"><span class="product-preice-acc">от <?php echo $market['ProdPrice']; ?>р.</span><div class="<?php stock_class($market['InStock']);?>"><?php stock_text($market['InStock']);?></div></div>
					  </label>
					  </div>
					  <div class="tab-content-price">
					    <div class="col-sm-12 col-xs-12 p-w-desc">
							<div class="col-sm-2 col-xs-6 weight"><?php echo $market['ProdWeight']; ?> г</div>
							<?php if ($market['InStock']==1) $row = 4; else $row = 6; ?>
							<div class="col-sm-<?php echo $row; ?> col-xs-6 portions"><?php echo $market['ProdInfo']; ?></div>
							<div class="clearfix visible-xs"></div>
							<div class="col-sm-4 col-xs-6 price-product"><?php echo $market['ProdPrice']; ?>р.
								<div class="<?php stock_class($market['InStock']);?>"><?php stock_text($market['InStock']);?></div>
							</div>
							<?php if ($market['InStock']==1) echo '<div class="col-sm-2 col-xs-6 link"><a href="'.$market['MarketUrl'].'"  target="_blank">Перейти на сайт</a></div>'; ?>
						</div>
					        

						<?php 
						if (!empty($market['SubtypeMain'])) {
							echo '<div class="tastes-product">';
							foreach ($market['SubtypeMain'] as $SubtypeMain) {
							?>
							<div class="col-sm-12 col-xs-12 product-from-market">
								<div class="col-sm-8 col-xs-6 taste-of-product"><?php echo $SubtypeMain['SubtypeName']; ?></div>
								<div class="col-sm-4 col-xs-6 <?php taste_stock_class($SubtypeMain['InStock']);?>"><?php stock_text($SubtypeMain['InStock']);?></div>
							</div>
							<?php
							}
							echo '<div></div></div>';
						}
						if (!empty($market['Alt'])) {
							foreach ($market['Alt'] as  $altprod) {
								?>
								<div class="col-sm-12 col-xs-12 p-w-desc">
									<div class="col-sm-2 col-xs-6 weight"><?php echo $altprod['ProdWeight']; ?> г</div>
									<?php if ($altprod['InStock']==1) $row = 4; else $row = 6; ?>
									<div class="col-sm-<?php echo $row; ?> col-xs-6 portions"><?php echo $altprod['ProdInfo']; ?></div>
									<div class="clearfix visible-xs"></div>
									<div class="col-sm-4 col-xs-6 price-product"><?php echo $altprod['ProdPrice']; ?> р.
										<div class="<?php stock_class($altprod['InStock']);?>"><?php stock_text($altprod['InStock']);?></div>
									</div>
									<?php if ($altprod['InStock']==1) echo '<div class="col-sm-2 col-xs-6 link"><a href="'.$market['MarketUrl'].'"  target="_blank">Перейти на сайт</a></div>'; ?>
								</div>
								<?php
								if (!empty($altprod['Subtype'])) {
									echo '<div class="tastes-product">';
									foreach ($altprod['Subtype'] as $Subtype) {
									?>
										<div class="col-sm-12 col-xs-12 product-from-market">
											<div class="col-sm-8 col-xs-6 taste-of-product"><?php echo $Subtype['SubtypeName']; ?></div>
											<div class="col-sm-4 col-xs-6 <?php taste_stock_class($Subtype['InStock']);?>"><?php stock_text($Subtype['InStock']);?></div>
										</div>
									<?php
									}
									echo '</div>';
								}
							}
						}
						?>
				        
				     </div>
				</div>


			<?php
			}//foreach data
		} // if data
	}

	// Сохранение настроек виджета (очистка)
	function update( $new_instance, $old_instance ) {
	}

	// html форма настроек виджета в Админ-панели
	function form( $instance ) {
	}

	// скрипт виджета
	function add_my_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_my_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style>
			.my_widget a{ display:inline; }

.col-sm-12.tab {

    position: relative;

    display: block;

    background: rgba(234, 234, 234, 0.6);

    font-weight: bold;

    line-height: 2;

    cursor: pointer;

    border-left: 3px solid #5e9633;

    margin: 0 0 5px;

    border-top: 1px solid rgba(94, 150, 51, 0.42);

    border-right: 3px solid #5e9633;

    border-bottom: 1px solid rgba(94, 150, 51, 0.42);

    padding: 0;

}

.title-avalible{

	

	text-transform: uppercase;

    padding: 0 0 25px 0;

    font-weight: bold;

    font-size: 16px;

}

.fa.fa-plus-circle{

	padding: 30px 0 0 13px;

    color: #454547;

}



.tab-accardion-price label{

		cursor:pointer;

}



.tab-accardion-price input {

  position: absolute;

  opacity: 0;

  z-index: -1;

}

/*.tab-accardion-price label {

  position: relative;

  display: block;

  padding: 0 0 0 1em;

    background: rgba(234, 234, 234, 0.5);

  font-weight: bold;

  line-height: 3;

  cursor: pointer;

  border-left:3px solid #5e9633;

}*/



.blue label {

  background: #2980b9;

}

.tab-content-price {

    max-height: 0;

    overflow: hidden;

    -webkit-transition: max-height .35s;

    -o-transition: max-height .35s;

    transition: max-height .35s;

    background-image: url(http://www.gymon.ru/wp-content/uploads/2014/03/bg3.png);

    border: 1px solid #ececec;

	    margin-bottom: 10px;

		-webkit-box-shadow: 0px 3px 9px -1px rgba(0,0,0,0.35);

    -moz-box-shadow: 0px 3px 9px -1px rgba(0,0,0,0.35);

    box-shadow: 0px 3px 9px -1px rgba(0,0,0,0.35);

}

}

.blue .tab-content-price {

  background: #3498db;

}

.tab-content-price p {

  margin: 1em;

}

/* :checked */

.tab-accardion-price input:checked ~ .tab-content-price {

  max-height: 5000em;

}

/* Icon */

.tab-accardion-price label::after {

  position: absolute;

  right: 0;

  top: 0;

  display: block;

  width: 3em;

  height: 3em;

  line-height: 3;

  text-align: center;

  -webkit-transition: all .35s;

  -o-transition: all .35s;

  transition: all .35s;

}

.tab-accardion-price input[type=checkbox] + .tab-accardion-price label::after {

  content: "+";

}

.tab-accardion-price input[type=radio] + .tab-accardion-price label::after {

  content: "\25BC";

}

.tab-accardion-price input[type=checkbox]:checked  + .tab-accardion-price label::after {

  transform: rotate(315deg);

}

.tab-accardion-price input[type=radio]:checked  + .tab-accardion-price label::after {

  transform: rotateX(180deg);

}

span.title-acc {

    padding: 12px;

    color: #5e9633;

}

span.product-preice-acc {

    /* text-align: right; */

    padding: 0px 0px 0px 25px;

    font-size: 18px;

    color: #424447;

    /* background: whitesmoke; */

}

.col-sm-2.weight {

    font-size: 16px;

    font-weight: bold;

    text-transform: uppercase;

    color: black;

    padding: 25px 20px;

}

.col-sm-4.portions {

    padding: 25px 10px;

    font-size: 11px;

    text-transform: uppercase;

    color: #4e4e4e;

    font-weight: 600;

}

.col-sm-6.portions {

    padding: 25px 10px;

    font-size: 11px;

    text-transform: uppercase;

    color: #4e4e4e;

    font-weight: 600;

}

.col-sm-5.title

{

	text-transform: uppercase;

    font-size: 16px;

	padding: 18px 0px 0 15px;

	

}

.col-sm-3.image{

	width: 140px;

	padding: 20px 0 0 0;

}

.col-sm-4.price-product {

    padding: 12px;

    font-size: 18px;

    font-weight: bold;

    color: #150000;

	text-align: right;

}



.col-sm-3.title{

	    text-align: right;

    /* font-size: 18px; */

    padding: 5px 0 0 0;

	

}

.col-sm-2.link{

    padding: 22px 11px;

    font-size: 11px;

    text-align: right;

    text-transform: uppercase;

    color: green;

    font-weight: bold;

    text-decoration: underline;

}



.col-sm-12.tab:hover{

	 background: rgba(234, 234, 234, 0.1);

	-webkit-transition: all .4s ease;

    -moz-transition: all .4s ease;

    -o-transition: all .4s ease;

    transition: all .4s ease;

}

.col-sm-12.tab:active{

	 background: rgba(200, 200, 200, 0.2);

	-webkit-transition: all .4s ease;

    -moz-transition: all .4s ease;

    -o-transition: all .4s ease;

    transition: all .4s ease;

}





.col-sm-12.tab label{

	width:100%;

	margin:0px;

}
.product-from-market .col-sm-4.stock-prod-out {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: bold;
    padding: 0 11px;
    text-align: right;
}

.stock-prod-out {

    font-size: 11px;

}

.stock-prod-in {

    font-size: 11px;

    color: green;

    text-transform: uppercase;

}



.col-sm-4.stock-prod {

    font-size: 11px;

    text-transform: uppercase;

    font-weight: bold;

    color: green;

	padding: 0 11px;

	text-align:right;

}

.col-sm-8.taste-of-product {

    color: #505050;

    font-weight: 600;

    padding: 0 0 0 40px;

}

.col-sm-12.product-from-market {

    border-bottom: 2px groove #ffffff !important;

    padding: 10px;

}

.col-sm-12.product-from-market:last-child

{border-bottom: none;}

.col-sm-12.product-from-market:first-child

{border-top: none;}

.col-sm-12.p-w-desc {

    border-bottom: 2px groove #ffffff;

}
@media screen and (max-width: 750px) {
	.col-sm-2.weight{
		padding: 10px 20px;
	}
	.col-sm-4.portions{
		padding: 10px 0px;
	}
	.col-sm-4.price-product {
		text-align: left;
		padding: 0px 12px;
	}
	.col-sm-2.link{
		text-align: left;
		padding: 0px;
	}
	.col-sm-8.taste-of-product{
		padding: 0 0 0 10px;
	}
}
		</style>
		<?php
	}
}

// Регистрация класса виджета
add_action( 'widgets_init', 'my_register_widgets' );
function my_register_widgets() {
	register_widget( 'My_Widget' );
}



  ?>