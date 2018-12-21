<?php
/**
 * Simple SKU Generator
 *
 * Plugin Name: Simple SKU Generator
 * Plugin URI: https://wordpress.org/plugins/simple-sku-generator/
 * Description: Generate SKU for products.
 * Version: 1.2.0
 * Author: H.P. Gong
 * Author URI: https://github.com/hp-gong/
 * GitHub Plugin URI: https://github.com/hp-gong/hp-sku-generator
 * GitHub Branch: master
 * License: GPL-3.0+
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 *
 */

// Exit if accessed directly.
if(! defined('ABSPATH')){exit;}

// Define urls
define('hp_sku_gen_var_url_p', plugin_dir_url( __FILE__ ));

// Check is HP_Simple_SKU exists
if(!class_exists('HP_Simple_SKU')){

// Class HP Simple SKU
  class HP_Simple_SKU{

	 // Function __construct
     public function __construct(){
	  add_action('admin_menu', array($this, 'add_admin_menu'));
	  add_action('admin_init', array($this, 'create_sku_scripts'));
	  add_action('init', array($this, 'check_if_woo_install'));
	  add_action('init', array($this, 'check_versions'));
	  add_action('init', array($this, 'validate_form'));
	  }

	  // Activation Function & installed woo_sku tables
	  public function activate_hp_sku_var_generator(){
	   global $wpdb;

	   $charset_collate = $wpdb->get_charset_collate();
	   $table_name1 = $wpdb->prefix . 'woo_sku1';
	   $table_name2 = $wpdb->prefix . 'woo_sku2';

	   $sql1 = "CREATE TABLE $table_name1 (
	   `id` INT(9) NOT NULL AUTO_INCREMENT,
	   `w_id` INT(10) NOT NULL,
	   `w_title` VARCHAR(200) NOT NULL,
	   `w_item` VARCHAR(200) NOT NULL,
	   PRIMARY KEY (id)
	   ) $charset_collate;";

	   $sql2 = "CREATE TABLE $table_name2 (
	   `id` INT(9) NOT NULL AUTO_INCREMENT,
	   `w_day` VARCHAR(50) NOT NULL,
	   `w_month` VARCHAR(50) NOT NULL,
	   `w_year` VARCHAR(50) NOT NULL,
	   `w_item` VARCHAR(200) NOT NULL,
	   PRIMARY KEY (id)
	   ) $charset_collate;";

	   require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
	   dbDelta($sql1);
	   dbDelta($sql2);
	   }

	  // Deactivation Function
	  public function deactivate_hp_sku_var_generator(){
	   global $wpdb;
	   }

	  // Uninstall Function & Remove woo_sku tables from the databases
	  public function uninstall_hp_sku_var_generator(){
	   global $wpdb;
	   $woo_sku1 = $wpdb->prefix."woo_sku1";
	   $woo_sku2 = $wpdb->prefix."woo_sku2";
	   $sql1 = "DROP TABLE IF EXISTS $woo_sku1;";
	   $sql2 = "DROP TABLE IF EXISTS $woo_sku2;";
	   $wpdb->query($sql1);
	   $wpdb->query($sql2);
	   }

	  // Check if WooCommerce plugin is install and activated
	  // in order for Simple SKU Generator plugin to run
	  public function check_if_woo_install(){
	   if (! class_exists('WooCommerce')){
	   $url = admin_url('/plugins.php');
	   require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	   deactivate_plugins( plugin_basename( __FILE__ ));
	   wp_die( __('Simple SKU Generator requires WooCommerce to run. <br>Please install WooCommerce and activate before attempting to activate again.<br><a href="'.$url.'">Return to the Plugins section</a>'));
	   }
       }

       // Check if WooCommerce plugin has the current version and
	   // activated in order for Simple SKU Generator plugin to run
	   public function check_versions(){
	    global $woocommerce;
	    if (version_compare($woocommerce->version, '3.5.3', '<')){
	    $url = admin_url('/plugins.php');
	    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	    deactivate_plugins( plugin_basename( __FILE__ ));
	    wp_die( __('Simple SKU Generator is disabled.<br>Simple SKU Generator requires a minimum of WooCommerce v3.5.3.<br><a href="'.$url.'">Return to the Plugins section</a>'));
	    }
	    }

	   // Add Menu Button/Menu Page & Submenu Buttons/Submenu Pages
	   public function add_admin_menu(){
		add_menu_page('SKU Generator', 'SKU Generator', 'administrator', 'hp_sku_var_generator', array($this, 'plugin_settings'), hp_sku_gen_var_url_p . 'img/icon.png', 59);
		add_submenu_page('hp_sku_var_generator', 'SKU Generator', 'SKU Generator', 'manage_options', 'hp_sku_var_generator', 'hp_sku_var_generator', 'hp_sku_var_generator1');
		add_submenu_page('hp_sku_var_generator', 'Display SKU', 'Display SKU', 'manage_options', 'hp_sku_var_display', 'hp_sku_var_display', 'hp_sku_var_display2');
		}

		// Only Administrator have permissions to access this page
	   public function plugin_settings() {
	    if (!current_user_can('administrator')){
	    wp_die('You do not have sufficient permissions to access this page.');
	    }
	    }

		// Verify Nonce Form
	   public function validate_form() {
        if(isset($_POST['btn_grey1'])){
        if (!isset($_POST['hp_display_sku_var_nonce1']) || !wp_verify_nonce($_POST['hp_display_sku_var_nonce1'], 'hp_sku_var_generator_s2')){
        wp_die('You do not have access to this page.');
        }
		else {
		   $w_day = sanitize_text_field(trim($_POST['w_day']));
	       $w_month = sanitize_text_field(trim($_POST['w_month']));
           $w_year = sanitize_text_field(trim($_POST['w_year']));
           $stock = sanitize_text_field(trim($_POST['stock']));
		}
		}
		if(isset($_POST['btn_gray1'])){
        if (!isset($_POST['hp_display_sku_var_nonce2']) || !wp_verify_nonce($_POST['hp_display_sku_var_nonce2'], 'hp_sku_var_generator_s1')){
        wp_die('You do not have access to this page.');
        }
		else {
		   $w_day = sanitize_text_field(trim($_POST['w_day']));
	       $w_month = sanitize_text_field(trim($_POST['w_month']));
           $w_year = sanitize_text_field(trim($_POST['w_year']));
           $stock = sanitize_text_field(trim($_POST['stock']));
		}
		}
	    }

	   // Register the jQuery & CSS scripts and link the files
	   public function create_sku_scripts(){
	   // jQuery
	    wp_enqueue_script('jquery');
	   // jQuery scripts for sku
	    wp_register_script('export_sku', hp_sku_gen_var_url_p .'/js/export_sku.js', array('jquery'));
		wp_register_script('bundle', hp_sku_gen_var_url_p .'js/bundle.js', array('jquery'));
	    wp_register_script('valida.2.1.7', hp_sku_gen_var_url_p .'js/valida.2.1.7.js', array('jquery'));
	    wp_enqueue_script('export_sku');
		wp_enqueue_script('bundle');
	    wp_enqueue_script('valida.2.1.7');

		// CSS scripts for sku
	    wp_register_style('sku', hp_sku_gen_var_url_p . 'css/sku.css');;
	    wp_enqueue_style('sku');
	    }
        }
	
	   // The hp_sku_var_generator function will create SKU for the products
       function hp_sku_var_generator(){
        if ($_SERVER['REQUEST_METHOD']== "POST"){
		$_POST = filter_input(INPUT_POST, FILTER_SANITIZE_STRING);
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	    $w_day = filter_input(INPUT_POST, 'w_day', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
		$w_month = filter_input(INPUT_POST, 'w_month', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
		$w_year = filter_input(INPUT_POST, 'w_year', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
		$stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
			

		$w_day = intval( $_POST['w_day']);
		if(! $w_day) {$w_day = '';}
		$w_month = intval( $_POST['w_month']);
		if(! $w_month) {$w_month = '';}
		$w_year = intval( $_POST['w_year']);
		if(! $w_year) {$w_year = '';}
		$stock = intval( $_POST['$stock']);
		if(! $stock) {$stock = '';}


	    $w_day = sanitize_text_field(trim($_POST['w_day']));
		$w_month = sanitize_text_field(trim($_POST['w_month']));
	    $w_year = sanitize_text_field(trim($_POST['w_year']));
		$stock = sanitize_text_field(trim($_POST['stock']));
			
			
		if($_POST){
		$args = array('post_type' => array('product'), 'posts_per_page' => -1);
		$posts = get_posts($args);
		$w_item = -1;
        foreach ($posts as $post) {
        $w_item++;
        if ($w_item == $stock){
		break;
		}
		global $wpdb;
		$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}woo_sku1 (w_id, w_title, w_item) VALUES (%s, %s, %s)", $post->ID, $post->post_title, $w_item));
		}
		}

		if($_POST){
		for($w_item = 0; $i < $stock; $w_item++) {
		$w_item = sprintf("%04d", $w_item);
		if ($w_item == $stock){
		break;
		}
		global $wpdb;
		$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}woo_sku2 (w_day, w_month, w_year, w_item) VALUES (%s, %s, %s, %s)", $w_day, $w_month, $w_year, $w_item));
		}
		}
		wp_redirect(admin_url('admin.php?page=hp_sku_var_display'));
		exit;
		}

	    $args = array('post_type' => array('product'), 'posts_per_page' => -1);
	    $posts = get_posts( $args );
	    echo '<br>';
	    echo '<h2>All Products</h2>';
	    echo '<p style="font-size: 14px;"><strong> Total Numbers of Products:<span style="margin: 0px 0px 0px 6px;">'.sanitize_text_field($post = count($posts)).'</span></strong> </p>';
	    echo '<div style="width: 90%; height: 100%; border: 1px dashed #8e24aa; padding: 4px 4px 4px 4px;">';
	    echo "<ol id='ol-tag' type='decimal'>";
	    foreach($posts as $post) {
	    echo '<li>'.sanitize_text_field($post->post_title).'</li>';
	    }
	    echo '</ol>';
	    echo '</div><br>';
	    echo '<form id="valida" name="valida" class="valida" action="" method="POST">';
		echo '<table style="border-collapse: collapse; border: dashed 1px #8e24aa; font-size: 14px;" cellspacing="15" cellpadding="15">
	    <tbody>
	    <tr>
	    <td style="border: dashed 1px #8e24aa;">Barcode Digits: </td>
		<td style="border: dashed 1px #8e24aa;">Max: 13  |  Min:  8</td>
		</tr>
	    <tr>
		<td style="border: dashed 1px #8e24aa;">UPC-A, EAN-13: </td>
		<td style="border: dashed 1px #8e24aa;">13 digits</td>
	    </tr>
	    <tr>
		<td style="border: dashed 1px #8e24aa;">EAN-8: </td>
		<td style="border: dashed 1px #8e24aa;">8 digits</td>
	    </tr>
	    <tr>
		<td style="border: dashed 1px #8e24aa;">CODE-39, CODE-93,<br> 
							EAN-128, CODE-128,<br>  
							ITF, QR, DMTX: </td>
	    <td style="border: dashed 1px #8e24aa;">12 or 13 digits</td>
	    </tr>
        </tbody>
	    </table>';
	    wp_nonce_field('hp_sku_var_generator_s1', 'hp_display_sku_var_nonce2');
	    echo '<script type="text/javascript">$(document).ready(function() {$("#valida").valida();});</script><br>';
        echo '<fieldset>';
	    echo '<div class="w_month">';
	    echo '<label for="w_month">Select a Month/Number/Letter or Blank: </label>';
	    echo '<select name="w_month" required id="w_month" data-required="Please select a Month or Blank or a Letter." require class="at-required">';
		echo '<optgroup label="  -- Blank  --  ">'; 
	    echo "<option value=' '></option>";
		echo '</optgroup>';
	    echo '<optgroup label=" - Month - ">'; 
	    $c0 = array("01","02","03","04","05","06","07","08","09","10","11","12");
	    foreach($c0 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" - Number(1) - ">'; 
		$c2 = array("0","1","2","3","4","5");
	    foreach($c2 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';	   
	    echo '<optgroup label=" - Number(3) - ">'; 
	    $c3 = array("101","202","303","404","505","606");
	    foreach($c3 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" - Letter - ">'; 
		$c3 = array("A","B","C","D","E","F");
	    foreach($c3 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '</select>';
	    echo '</div>';
		echo '<br>';
	    echo '<div class="w_year">';
	    echo '<label for="w_year">Select a Year:</label>';
	    echo '<select name="w_year" required id="w_year" data-required="Please enter a Year." require class="at-required">';
		echo '<optgroup label=" -- Blank  -- ">'; 
	    echo "<option value=' '></option>";
		echo '</optgroup>';
	    echo '<optgroup label=" -- Year -- ">'; 
	    $c4 = array("2019","2020","2021","2022","2023","2024","2025","2026","2027","2028","2029","2030");
	    foreach($c4 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '</select>';
	    echo '</div>';
	    echo '<br>';
	    echo '<div class="w_day">';
	    echo '<label for="w_day">Select a Date:</label>';
	    echo '<select name="w_day" required id="w_day" data-required="Please enter a Day." require class="at-required">';
		echo '<optgroup label=" -- Blank  -- ">'; 
	    echo "<option value=' '></option>";
		echo '</optgroup>';
		echo '<optgroup label=" -- Day -- ">'; 
	    $c5 = array(" ","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
	    foreach($c5 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '</select>';
	    echo '</div>';
	    echo '<br>';
	    echo '<div class="stock">';
	    echo '<label for="stock">Select a number of products:</label>';
	    echo '<select name="stock" required id="stock" data-required="Please enter a Number." require class="at-required">';
	    echo '<option selected value=""></option>';
	    echo '<optgroup label=" -- 50 Number -- ">'; 
	    $c6 = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50");
	    foreach($c6 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 100 Number -- ">'; 
	    $c7 = array("51","52","53","54","55","56","57","58","59","60","61","62","63","64","65","66","67","68","69","70","71","72","73","74","75","76","77","78","79","80","81","82","83","84","85","86","87","88","89","90","91","92","93","94","95","96","97","98","99","100");
	    foreach($c7 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 150 Number -- ">'; 
	    $c8 = array("101","102","103","104","105","106","107","108","109","110","111","112","113","114","115","116","117","118","119","120","121","122","123","124","125","126","127","128","129","130","131","132","133","134","135","136","137","138","139","140","141","142","143","144","145","146","147","148","149","150");
	    foreach($c8 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 200 Number -- ">'; 
	    $c9 = array("151","152","153","154","155","156","157","158","159","160","161","162","163","164","165","166","167","168","169","170","171","172","173","174","175","176","177","178","179","180","181","182","183","184","185","186","187","188","189","190","191","192","193","194","195","196","197","198","199","200");
	    foreach($c9 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 250 Number -- ">'; 
	    $c8 = array("201","202","203","204","205","206","207","208","209","210","211","212","213","214","215","216","217","218","219","220","221","222","223","224","225","226","227","228","229","230","231","232","233","234","235","236","237","238","239","240","241","242","243","244","245","246","247","248","249","250");
	    foreach($c8 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 300 Number -- ">'; 
	    $c9 = array("251","252","253","254","255","256","257","258","259","260","261","262","263","264","265","266","267","268","269","270","271","272","273","274","275","276","277","278","279","280","281","282","283","284","285","286","287","288","289","290","291","292","293","294","295","296","297","298","299","300");
	    foreach($c9 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
		echo '<optgroup label=" -- 350 Number -- ">'; 
	    $c8 = array("301","302","303","304","305","306","307","308","309","310","311","312","313","314","315","316","317","318","319","320","321","322","323","324","325","326","327","328","329","330","331","332","333","334","335","336","337","338","339","340","341","342","343","344","345","346","347","348","349","350");
	    foreach($c8 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 400 Number -- ">'; 
	    $c9 = array("351","352","353","354","355","356","357","358","359","360","361","362","363","364","365","366","367","368","369","370","371","372","373","374","375","376","377","378","379","380","381","382","383","384","385","386","387","388","389","390","391","392","393","394","395","396","397","398","399","400");
	    foreach($c9 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 450 Number -- ">'; 
	    $c8 = array("401","402","403","404","405","406","407","408","409","410","411","412","413","414","415","416","417","418","419","420","421","422","423","424","425","426","427","428","429","430","431","432","433","434","435","436","437","438","439","440","441","442","443","444","445","446","447","448","449","450");
	    foreach($c8 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 500 Number -- ">'; 
	    $c9 = array("451","452","453","454","455","456","457","458","459","460","461","462","463","464","465","466","467","468","469","470","471","472","473","474","475","476","477","478","479","480","481","482","483","484","485","486","487","488","489","490","491","492","493","494","495","496","497","498","499","500");
	    foreach($c9 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 550 Number -- ">'; 
	    $c8 = array("501","502","503","504","505","506","507","508","509","510","511","512","513","514","515","516","517","518","519","520","521","522","523","524","525","526","527","528","529","530","531","532","533","534","535","536","537","538","539","540","541","542","543","544","545","546","547","548","549","550");
	    foreach($c8 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 600 Number -- ">'; 
	    $c9 = array("551","552","553","554","555","556","557","558","559","560","561","562","563","564","565","566","567","568","569","570","571","572","573","574","575","576","577","578","579","580","581","582","583","584","585","586","587","588","589","590","591","592","593","594","595","596","597","598","599","600");
	    foreach($c9 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 650 Number -- ">'; 
	    $c8 =array("601","602","603","604","605","606","607","608","609","610","611","612","613","614","615","616","617","618","619","620","621","622","623","624","625","626","627","628","629","630","631","632","633","634","635","636","637","638","639","640","641","642","643","644","645","646","647","648","649","650");
	    foreach($c8 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '<optgroup label=" -- 700 Number -- ">'; 
	    $c9 = array("651","652","653","654","655","656","657","658","659","660","661","662","663","664","665","666","667","668","669","670","671","672","673","674","675","676","677","678","679","680","681","682","683","684","685","686","687","688","689","690","691","692","693","694","695","696","697","698","699","700");
	    foreach($c9 as $c){
	    echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	    }
	    echo '</optgroup>';
	    echo '</select>';
	    echo '</div>';
	    echo '<br>';

	    echo '</fieldset><br>';
	    wp_nonce_field('hp_sku_var_generator_s2', 'hp_display_sku_var_nonce1');
	    echo '<input type="submit" class="btn_grey1" name="btn_grey1" value="Create">';
	    echo '<input type="reset" class="btn_gray1" name="btn_gray1" value="Reset">';
	    echo '</form>';
        }

	  // The hp_sku_var_display function will display the SKU for the products and also export the sku in csv file
	  function hp_sku_var_display(){
	   echo '<br>';
	   echo '<h2>Display SKU</h2>';
	   global $wpdb;
	   $result1 = $wpdb->get_results("SELECT s1.w_id, s1.w_title, s1.w_item, s2.w_day, s2.w_month, s2.w_year, s2.w_item FROM {$wpdb->prefix}woo_sku1 AS s1 INNER JOIN {$wpdb->prefix}woo_sku2 AS s2 WHERE s1.id=s2.id");
	   echo '<p style="font-size: 14px;"><strong> Total Numbers of Sku:<span style="margin: 0px 0px 0px 6px;">'.esc_js(esc_html(count($result1))).'</span></strong> </p>';
	   echo '<br>';
	   echo '<form method="POST" action="">';
	   wp_nonce_field('hp_sku_var_generator_s1', 'hp_display_sku_var_nonce2');
	   if($_SERVER['REQUEST_METHOD']=="POST") {
	   if($_POST['remove_sku']) {
	   global $wpdb;
	   $wpdb->query("DELETE {$wpdb->prefix}woo_sku1,{$wpdb->prefix}woo_sku2 FROM {$wpdb->prefix}woo_sku1 INNER JOIN {$wpdb->prefix}woo_sku2 WHERE {$wpdb->prefix}woo_sku1.id={$wpdb->prefix}woo_sku2.id");
	   } 
	   }
       echo '<div id="dvData">';
	   echo '<table style="border-collapse: collapse; width: 40%; border: 1px solid black; background-color: white;">
	   <thead>
	   <tr>
	   <th class="check-column" scope="col" checked="checked" style="border: 1px solid black;"><input type="checkbox" disabled="disabled" checked="checked"></th>
	   <th style="border: 1px solid black;" class="col">ID</th>
	   <th style="border: 1px solid black;" scope="col">Title</th>
	   <th style="border: 1px solid black;" class="col">SKU</th>
	   </tr>
	   </thead>
	   <tbody>';
	   global $wpdb;
	   $result2 = $wpdb->get_results("SELECT s1.w_id, s1.w_title, s1.w_item, s2.w_day, s2.w_month, s2.w_year, s2.w_item FROM {$wpdb->prefix}woo_sku1 AS s1 INNER JOIN {$wpdb->prefix}woo_sku2 AS s2 WHERE s1.id=s2.id");
	   if(count($result2)){
	   foreach($result2 as $row2){
	   echo '<tr>
	   <td style="border: 1px solid black;" align="center"><input type="checkbox" name="remove_sku" disabled="disabled" checked="checked" value="'.sanitize_text_field($row2->w_id).'"></td>
	   <td style="border: 1px solid black;" align="center">'.sanitize_text_field($row2->w_id).'</td>
	   <td style="border: 1px solid black;" align="center">'.sanitize_text_field($row2->w_title).'</td>
	   <td style="border: 1px solid black;" align="center">'.sanitize_text_field($row2->w_month).''.sanitize_text_field($row2->w_year).''.sanitize_text_field($row2->w_day).''.sanitize_text_field($row2->w_item).'</td>
	   </tr>';
	   }
	   }
	   echo'</tbody>
	   </table>
	   </div>
	   <br>';
	   wp_nonce_field('hp_sku_var_generator_s2', 'hp_display_sku_var_nonce1');
	   global $wpdb;
	   $result3 = $wpdb->get_results("SELECT s1.w_id, s1.w_title, s1.w_item, s2.w_day, s2.w_month, s2.w_year, s2.w_item FROM {$wpdb->prefix}woo_sku1 AS s1 INNER JOIN {$wpdb->prefix}woo_sku2 AS s2 ON s1.id=s2.id");
	   if(count($result3)){
	   foreach($result3 as $row3){
	   echo '<input type="hidden" name="remove_sku" value="'.sanitize_text_field($row3->w_id).'" />';
	   }
	   }
	   echo '<input type="submit" class="btn_grey1" name="remove_sku" value="Remove" />';
	   echo '<a id="export" style="display:inline-block;box-sizing:border-box;margin:5px;text-align:center;text-decoration:none;cursor:pointer;background-color:transparent;-webkit-transition:all .25s ease;-moz-transition:all .25s ease;-ms-transition:all .25s ease;-o-transition:all .25s ease;transition:all .25s ease;font-size:10px;font-size:0.9rem;line-height:35px;line-height:0.1rem;min-width:50px;min-width:5rem;padding:17px 15px;border-color:#666;border-width:1px;border-style:solid;border-radius:2.5px; border-color:#737373;background-color:#5b5b5b;color:#f5f5f5;" href="#">Export as CSV</a>';
	   echo '</form>';
       }
       }

	   // Check if HP_Simple_SKU exists then
	   // the plugin will activate or deactivate
	   if(class_exists('HP_Simple_SKU')){
		register_activation_hook( __FILE__, array('HP_Simple_SKU', 'activate_hp_sku_var_generator'));
		register_deactivation_hook( __FILE__, array('HP_Simple_SKU', 'deactivate_hp_sku_var_generator'));
		register_uninstall_hook(__FILE__, array('HP_Simple_SKU', 'uninstall_hp_sku_var_generator'));
		$HP_Simple_SKU = new HP_Simple_SKU();
	   }
?>
