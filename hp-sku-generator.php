<?php
/**
 * Simple SKU Generator
 *
 * Plugin Name: Simple SKU Generator
 * Plugin URI: https://wordpress.org/plugins/simple-sku-generator/
 * Description: Generate SKU for products.
 * Version: 1.1.0
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
define('hp_sku_gen_url_p', plugin_dir_url( __FILE__ ));
//define('hp_sku_gen_url_i', includes_url( __FILE__ ));

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
	  public static function activate_hp_sku_generator(){
	  global $wpdb;

	  $charset_collate = $wpdb->get_charset_collate();
	  $table_name1 = $wpdb->prefix . 'woo_sku1';
	  $table_name2 = $wpdb->prefix . 'woo_sku2';

	  $sql1 = "CREATE TABLE $table_name1 (
	   `id` INT(9) NOT NULL AUTO_INCREMENT,
	   `w_id` INT(10) NOT NULL,
	   `w_title` VARCHAR(200) NOT NULL,
	   PRIMARY KEY (id)
	   ) $charset_collate;";

	  $sql2 = "CREATE TABLE $table_name2 (
	   `id` INT(9) NOT NULL AUTO_INCREMENT,
	   `w_letter` VARCHAR(200) NOT NULL,
	   `w_year` VARCHAR(200) NOT NULL,
	   `w_item` VARCHAR(200) NOT NULL,
	   PRIMARY KEY (id)
	   ) $charset_collate;";

	   require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
	   dbDelta($sql1);
	   dbDelta($sql2);
	   }

	  // Deactivation Function
	  public static function deactivate_hp_sku_generator(){
	   global $wpdb;
	   }

	 // Uninstall Function & Remove woo_sku tables from the databases
	  public static function uninstall_hp_sku_generator(){
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
	  public static function check_if_woo_install(){
	   if (! class_exists('WooCommerce')){
	   $url = admin_url('/plugins.php');
	   require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	   deactivate_plugins( plugin_basename( __FILE__ ));
	   wp_die( __('Simple SKU Generator requires WooCommerce to run. <br>Please install WooCommerce and activate before attempting to activate again.<br><a href="'.$url.'">Return to the Plugins section</a>'));
	   }
       }

       // Check if WooCommerce plugin has the current version and
	   // activated in order for Simple SKU Generator plugin to run
	   public static function check_versions(){
	    global $woocommerce;
	    if (version_compare($woocommerce->version, '3.1.1', '<')){
	    $url = admin_url('/plugins.php');
	    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	    deactivate_plugins( plugin_basename( __FILE__ ));
	    wp_die( __('Simple SKU Generator is disabled.<br>Simple SKU Generator requires a minimum of WooCommerce v3.1.1.<br><a href="'.$url.'">Return to the Plugins section</a>'));
	    }
	    }

	   // Add Menu Button/Menu Page & Submenu Buttons/Submenu Pages
	   public static function add_admin_menu(){
		add_menu_page('SKU Generator', 'SKU Generator', 'administrator', 'hp_sku_generator', array($this, 'plugin_settings'), hp_sku_gen_url_p . 'img/icon.png', 59);
		add_submenu_page('hp_sku_generator', 'SKU Generator', 'SKU Generator', 'manage_options', 'hp_sku_generator', 'hp_sku_generator', 'hp_sku_generator1');
		add_submenu_page('hp_sku_generator', 'Display SKU', 'Display SKU', 'manage_options', 'hp_sku_display', 'hp_sku_display', 'hp_sku_display2');
		}

		// Only Administrator have permissions to access this page
	   public static function plugin_settings() {
	    if (!current_user_can('administrator')){
	    wp_die('You do not have sufficient permissions to access this page.');
	    }
	    }

		// Verify Nonce Form
	   public static function validate_form() {
        if(isset($_POST['btn_grey1'])){
        if (!isset($_POST['hp_display_sku_nonce1']) || !wp_verify_nonce($_POST['hp_display_sku_nonce1'], 'hp_sku_generator_s2')){
        wp_die('You do not have access to this page.');
        }
		else {
	       $w_letter = sanitize_text_field(trim($_POST['w_letter']));
           $w_year = sanitize_text_field(trim($_POST['w_year']));
           $start = sanitize_text_field(trim($_POST['start']));
           $end = sanitize_text_field(trim($_POST['end']));
           $wcount = sanitize_text_field(trim($_POST['wcount']));
		}
		}
		if(isset($_POST['btn_grey1'])){
        if (!isset($_POST['hp_display_sku_nonce2']) || !wp_verify_nonce($_POST['hp_display_sku_nonce2'], 'hp_sku_generator_s1')){
        wp_die('You do not have access to this page.');
        }
		else {
	       $w_letter = sanitize_text_field(trim($_POST['w_letter']));
           $w_year = sanitize_text_field(trim($_POST['w_year']));
           $start = sanitize_text_field(trim($_POST['start']));
           $end = sanitize_text_field(trim($_POST['end']));
           $wcount = sanitize_text_field(trim($_POST['wcount']));
		}
		}
	    }

	    // Register the jQuery & CSS scripts and link the files
	   public static function create_sku_scripts(){
	    // jQuery
	    wp_enqueue_script('jquery');
		// jQuery scripts for sku
	    wp_register_script('sku', hp_sku_gen_url_p .'js/sku.js', array('jquery'));
		wp_register_script('bundle', hp_sku_gen_url_p .'js/bundle.js', array('jquery'));
	    wp_register_script('valida.2.1.7', hp_sku_gen_url_p .'js/valida.2.1.7.js', array('jquery'));
	    wp_register_script('export_sku', hp_sku_gen_url_p .'/js/export_sku.js', array('jquery'));
		wp_enqueue_script('export_sku');
		wp_enqueue_script('sku');
		wp_enqueue_script('bundle');
	    wp_enqueue_script('valida.2.1.7');
		// CSS scripts for sku
	    wp_register_style('sku', hp_sku_gen_url_p . 'css/sku.css');;
	    wp_enqueue_style('sku');
	    }
  }
	// The hp_sku_generator function will create SKU for the products
    function hp_sku_generator(){
    if ($_SERVER['REQUEST_METHOD']== "POST"){
		$_POST = filter_input(INPUT_POST, FILTER_SANITIZE_STRING);
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		$w_letter = filter_input(INPUT_POST, 'w_letter', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
		$w_year = filter_input(INPUT_POST, 'w_year', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
		$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
		$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);
		$wcount = filter_input(INPUT_POST, 'wcount', FILTER_SANITIZE_STRING);
		$w_letter = intval( $_POST['w_letter']);
		
		if(! $w_letter) {$w_letter = '';}
		$w_year = intval( $_POST['w_year']);
		if(! $w_year) {$w_year = '';}
		$wcount = intval( $_POST['$wcount']);
		if(! $wcount) {$wcount = '';}
		$start = intval( $_POST['start']);
		if(! $start) {$start = '';}
		$end = intval( $_POST['end']);
		if(! $end) {$end = '';}
		
		$w_letter = sanitize_text_field(trim($_POST['w_letter']));
	    $w_year = sanitize_text_field(trim($_POST['w_year']));
		$start = sanitize_text_field(trim($_POST['start']));
		$end = sanitize_text_field(trim($_POST['end']));
		$wcount = sanitize_text_field(trim($_POST['wcount']));

		if($_POST){
		$args = array('post_type' => array('product'), 'posts_per_page' => -1);
		$posts = get_posts($args);
		foreach($posts as $post) {
		global $wpdb;
		$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}woo_sku1 (w_id, w_title) VALUES (%s, %s)", $post->ID, $post->post_title));
		}
		}
		
		if($_POST){
		for($w_item = $start; $i < $end; $w_item++) {
		if ($w_item == $wcount){
		break;
		}
		global $wpdb;
		$wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}woo_sku2 (w_letter, w_year, w_item) VALUES (%s, %s, %s)", $w_letter, $w_year, $w_item));
		}
		}
		wp_redirect(admin_url('admin.php?page=hp_sku_display'));
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
	   echo '</div>';
	   echo '<form id="valida" name="valida" class="valida" action="" method="POST">';
	   wp_nonce_field('hp_sku_generator_s1', 'hp_display_sku_nonce2');
	   echo '<script type="text/javascript">$(document).ready(function() {$("#valida").valida();});</script><br>';
       echo '<fieldset>';
	   echo '<div class="w_letter">';
	   echo '<label for="w_letter">Select a Letter:</label>';
	   echo '<select name="w_letter" required id="w_letter" data-required="Please Enter a Letter." require class="at-required">';
	   echo '<option selected value=""></option>';
	   $c1 = array("A","B","C","D","E");
	   foreach($c1 as $c){
	   echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	   }
	   echo '</select>';
	   echo '</div>';
	   echo '<br>';
	   echo '<div class="w_year">';
	   echo '<label for="w_year">Select a Year:</label>';
	   echo '<select name="w_year" required id="w_year" data-required="Please Enter a Year." require class="at-required">';
	   echo '<option selected value=""></option>';
	   $c2 = array("2016","2017","2018","2019","2020");
	   foreach($c2 as $c){
	   echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	   }
	   echo '</select>';
	   echo '</div>';
	   echo '<br>';
	   echo '<div class="start">';
	   echo '<label for="start">Select a Starting Number:</label>';
	   echo '<select name="start" required id="start" data-required="Please Enter a Starting Number." require class="at-required">';
	   echo '<option selected value=""></option>';
	   $c3 = array("1000","2000","3000");
	   foreach($c3 as $c){
	   echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	   }
	   echo '</select>';
	   echo '</div>';
	   echo '<br>';
	   echo '<div class="end">';
	   echo '<label for="end">Select a Ending Number:</label>';
	   echo '<select name="end" required id="end" data-required="Please Enter a Ending Number." require class="at-required" value="0">';
	   echo '<option selected value=""></option>';
	   $c4 = array("1100","1200","1300","2100","2200","2300","3100","3200","3300");
	   foreach($c4 as $c){
	   echo "<option value='".esc_attr($c)."'>".esc_attr($c)."</option>";
	   }
	   echo '</select>';
	   echo '</div>';
	   echo '<br>';
	   echo '<div class="wcount">';
	   echo '<label for="wcount">Enter a Stop Number:</label>';
       echo '<input type="text" name="wcount" required id="wcount" data-required="Please Enter a Stop Number for products that are less than the number you selected." maxlength="4" style="width: 48px;" require class="at-required">';
	   echo '</div>';
	   echo '</fieldset><br>';
	   wp_nonce_field('hp_sku_generator_s2', 'hp_display_sku_nonce1');
	   echo '<input type="submit" class="btn_grey1" name="btn_grey1" value="Create">';
	   echo '<input type="reset" class="btn_gray1" name="btn_gray1" value="Reset">';
	   echo '</form>';
       }

	 // The hp_sku_display function will display the SKU for the products and also export the sku in csv file
	 function hp_sku_display(){
	  echo '<br>';
	  echo '<h2>Display SKU</h2>';
	  global $wpdb;
	  $result1 = $wpdb->get_results("SELECT s1.w_id, s1.w_title, s2.w_letter, s2.w_year, s2.w_item FROM {$wpdb->prefix}woo_sku1 AS s1 INNER JOIN {$wpdb->prefix}woo_sku2 AS s2 ON s1.id=s2.id");
	  echo '<p style="font-size: 14px;"><strong> Total Numbers of Sku:<span style="margin: 0px 0px 0px 6px;">'.esc_js(esc_html(count($result1))).'</span></strong> </p>';
	  echo '<br>';
	  echo '<form method="POST" action="">';
	  wp_nonce_field('hp_sku_generator_s2', 'hp_display_sku_nonce1');
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
	  <th style="border: 1px solid black;" scope="col">ID</th>
	  <th style="border: 1px solid black;" scope="col">Title</th>
	  <th style="border: 1px solid black;" scope="col">SKU</th>
	  </tr>
	  </thead>
	  <tfoot>
	  <tr>
	  <th class="check-column" scope="col" checked="checked" style="border: 1px solid black;"><input type="checkbox" disabled="disabled" checked="checked"></th>
	  <th style="border: 1px solid black;" scope="col">ID</th>
	  <th style="border: 1px solid black;" scope="col">Title</th>
	  <th style="border: 1px solid black;" scope="col">SKU</th>
	  </tr>
	  </tfoot>
	  <tbody>';
	  global $wpdb;
	  $result2 = $wpdb->get_results("SELECT s1.w_id, s1.w_title, s2.w_letter, s2.w_year, s2.w_item FROM {$wpdb->prefix}woo_sku1 AS s1 INNER JOIN {$wpdb->prefix}woo_sku2 AS s2 ON s1.id=s2.id");
	  if(count($result2)){
	  foreach($result2 as $row2){
	  echo '<tr>
	  <th class="check-column" style="padding:5px 0px 2px 0px; border: 1px solid black;"><input type="checkbox" name="remove_sku" disabled="disabled" checked="checked" value="'.sanitize_text_field($row2->id).'"></th>
	  <td style="border: 1px solid black;" align="center">'.sanitize_text_field($row2->w_id).'</td>
	  <td style="border: 1px solid black;" align="center">'.sanitize_text_field($row2->w_title).'</td>
	  <td style="border: 1px solid black;" align="center">'.sanitize_text_field($row2->w_letter).''.sanitize_text_field($row2->w_year).''.sanitize_text_field($row2->w_item).'</td>
	  </tr>';
	  }
	  }
	  echo'</tbody>
	  </table>
	  </div>
	  <br>';
	  wp_nonce_field('hp_sku_generator_s1', 'hp_display_sku_nonce2');
	  global $wpdb;
	  $result3 = $wpdb->get_results("SELECT s1.w_id, s1.w_title, s2.w_letter, s2.w_year, s2.w_item FROM {$wpdb->prefix}woo_sku1 AS s1 INNER JOIN {$wpdb->prefix}woo_sku2 AS s2 ON s1.id=s2.id");
	  if(count($result3)){
	  foreach($result3 as $row3){
	  echo '<input type="hidden" name="remove_sku" value="'.sanitize_text_field($row3->w_id).'" />';
	  	  }
	  }
	  echo '<input type="submit" class="btn_grey1" name="btn_grey1" value="Remove Selected" />';
	  echo '<a id="export" style="display:inline-block;box-sizing:border-box;margin:5px;text-align:center;text-decoration:none;cursor:pointer;background-color:transparent;-webkit-transition:all .25s ease;-moz-transition:all .25s ease;-ms-transition:all .25s ease;-o-transition:all .25s ease;transition:all .25s ease;font-size:10px;font-size:0.9rem;line-height:35px;line-height:0.1rem;min-width:50px;min-width:5rem;padding:17px 15px;border-color:#666;border-width:1px;border-style:solid;border-radius:2.5px; border-color:#737373;background-color:#5b5b5b;color:#f5f5f5;" href="#">Export as CSV</a>';
	  echo '</form>';
        }
}
	  // Check if HP_Simple_SKU exists then
	  // the plugin will activate or deactivate
	  if(class_exists('HP_Simple_SKU')){
		register_activation_hook( __FILE__, array('HP_Simple_SKU', 'activate_hp_sku_generator'));
		register_deactivation_hook( __FILE__, array('HP_Simple_SKU', 'deactivate_hp_sku_generator'));
		register_uninstall_hook(__FILE__, array('HP_Simple_SKU', 'uninstall_hp_sku_generator'));
		$HP_Simple_SKU = new HP_Simple_SKU();
	  }
?>
