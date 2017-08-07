<?php
/**
 * Easy Export
 *
 * Plugin Name: Easy Export
 * Plugin URI: https://github.com/hp-gong/hp-easy-export
 * Description: Easy Export export reports.
 * Version: 1.0.0
 * Author: H.P. Gong
 * Author URI: https://github.com/hp-gong/
 * GitHub Plugin URI: https://github.com/hp-gong/hp-easy-export
 * GitHub Branch: master
 * License: GPL-3.0+
 * License URI: https://www.gnu.org/licenses/gpl-3.0.txt
 *
 */

// Exit if accessed directly.
if(! defined('ABSPATH')){exit;}

// Define urls
define('hp_easy_ex_url_p', plugin_dir_url( __FILE__ ));
//define('hp_easy_ex_url_i', includes_url( __FILE__ ));

// Check is HP_Easy_Export exists
if(!class_exists('HP_Easy_Export')){

// Class HP Easy Export
  class HP_Easy_Export{

	 // Function __construct
     public function __construct(){
	  add_action('admin_menu', array($this, 'add_admin_menu'));
	  add_action('admin_init', array($this, 'create_export_scripts'));
	  add_action('init', array($this, 'check_if_woo_install'));
	  add_action('init', array($this, 'check_versions'));
	  add_action('init', array($this, 'validate_form'));
	  }

	  // Activation Function
	  public function activate_hp_easy_export(){
	   }

	  // Deactivation Function
	  public function deactivate_hp_easy_export(){
	   }

	 // Uninstall Function
	  public function uninstall_hp_easy_export(){
	   }

	  // Check if WooCommerce plugin is install and activated
	  // in order for Easy Export plugin to run
	  public static function check_if_woo_install(){
	   if (! class_exists('WooCommerce')){
	   $url = admin_url('/plugins.php');
	   require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	   deactivate_plugins( plugin_basename( __FILE__ ));
	   wp_die( __('Easy Export requires WooCommerce to run. <br>Please install WooCommerce and activate before attempting to activate again.<br><a href="'.$url.'">Return to the Plugins section</a>'));
	   }
       }

       // Check if WooCommerce plugin has the current version and
	   // activated in order for Easy Export plugin to run
	   public static function check_versions(){
	    global $woocommerce;
	    if (version_compare($woocommerce->version, '3.0.7', '<')){
	    $url = admin_url('/plugins.php');
	    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	    deactivate_plugins( plugin_basename( __FILE__ ));
	    wp_die( __('Easy Export is disabled.<br>Easy Export requires a minimum of WooCommerce v3.0.7.<br><a href="'.$url.'">Return to the Plugins section</a>'));
	    }
	    }

	   // Add Menu Button/Menu Page & Submenu Buttons/Submenu Pages
	   public static function add_admin_menu(){
		add_menu_page('Easy Export', 'Easy Export', 'administrator', 'hp_easy_export', array($this, 'plugin_settings'), hp_easy_ex_url_p . 'img/icon.png', 59);
		add_submenu_page('hp_easy_export', 'Order List', 'Order List', 'manage_options', 'hp_easy_export', 'hp_easy_export', 'hp_easy_export1');
		add_submenu_page('hp_easy_export', 'Billing List', 'Billing List', 'manage_options', 'hp_easy_billing_list', 'hp_easy_billing_list', 'hp_easy_export2');
        add_submenu_page('hp_easy_export', 'Shipping List', 'Shipping List', 'manage_options', 'hp_easy_shipping_list', 'hp_easy_shipping_list', 'hp_easy_export3');
        add_submenu_page('hp_easy_export', 'Product List', 'Product List', 'manage_options', 'hp_easy_product_list', 'hp_easy_product_list', 'hp_easy_export4');
        add_submenu_page('hp_easy_export', 'Mailing List', 'Mailing List', 'manage_options', 'hp_easy_mailing_list', 'hp_easy_mailing_list', 'hp_easy_export5');
		}

		// Only Administrator have permissions to access this page
	   public static function plugin_settings() {
	    if (!current_user_can('administrator')){
	    wp_die('You do not have sufficient permissions to access this page.');
	    }
	    }

		// Verify Nonce Form
	   public static function validate_form() {
        if(isset($_POST['btn_greys'])){
        if (!isset($_POST['hp_display_export_nonce1']) || !wp_verify_nonce($_POST['hp_display_export_nonce1'], 'hp_easy_export_e2')){
        wp_die('You do not have access to this page.');
        }
        }
		if(isset($_POST['btn_greys'])){
        if (!isset($_POST['hp_display_export_nonce2']) || !wp_verify_nonce($_POST['hp_display_export_nonce2'], 'hp_easy_export_e1')){
        wp_die('You do not have access to this page.');
        }
        }
	    }

	    // Register the jQuery & CSS scripts and link the files
	   public static function create_export_scripts(){
	    // jQuery
	    wp_enqueue_script('jquery');
		// jQuery scripts for Easy Export
	    wp_register_script('export', hp_easy_ex_url_p .'js/export.js', array('jquery'));
	    wp_register_script('easy_export', hp_easy_ex_url_p .'/js/easy_export.js', array('jquery'));
	    wp_register_script('jq.tablesort', hp_easy_ex_url_p .'js/jq.tablesort.js', array('jquery'));
	    wp_register_script('jspdf.debug', hp_easy_ex_url_p .'js/jspdf.debug.js', array('jquery'));
        wp_register_script('jspdf.plugin.autotable', hp_easy_ex_url_p .'js/jspdf.plugin.autotable.js', array('jquery'));
		wp_enqueue_script('easy_export');
		wp_enqueue_script('export');
	    wp_enqueue_script('jq.tablesort');
		wp_enqueue_script('jspdf.debug');
		wp_enqueue_script('jspdf.plugin.autotable');
		// CSS scripts for export
	    wp_register_style('export', hp_easy_ex_url_p . 'css/export.css');
	    wp_enqueue_style('export');
	    }
  }

	// The hp_easy_export function will export the Order List in PDF, CSV and Print
    function hp_easy_export(){

	  echo '<h2>Order List</h2>
	  <form method="POST" action="">';
	  echo wp_nonce_field('hp_easy_export_e1', 'hp_display_export_nonce2');
	  echo '<div id="dvData1"> 
	  <table style="border-collapse: collapse; width: 100%; border: 1px solid black; background-color: white; text-align: center;" cellspacing="0" cellpadding="0" id="printReport">
	  <thead>
	  <tr>
	  <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">ID</th>
	  <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Order Date</th>
	  <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">First Name</th>
	  <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Last Name</th>
	  <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Phone Number</th>
	  <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Email</th>
	  <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Status</th>
	  <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Order Total</th>
	  </tr>
	  </thead>
	  <tbody>';
	  global $woocommerce;
	  $query1 = array('post_type' => 'shop_order', 'post_status' => array('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-pending'), 'posts_per_page' => -1); 
	  $loop1 = new WP_Query($query1);
	  if($loop1->have_posts()){
	  while ($loop1->have_posts() ){ 
	  $loop1->the_post();
	  $order_id1 = $loop1->post->ID;
	  $order1 = new WC_Order($order_id1);
	  echo '<tr>
	  <td style="border: 1px solid black;">'.sanitize_text_field($order1->ID).'</td>
	  <td style="border: 1px solid black;">'.sanitize_text_field($order1->paid_date).'</td>
	  <td style="border: 1px solid black;">'.sanitize_text_field($order1->billing_first_name).'</td>
	  <td style="border: 1px solid black;">'.sanitize_text_field($order1->billing_last_name).'</td>
	  <td style="border: 1px solid black;">'.sanitize_text_field($order1->billing_phone).'</td>
	  <td style="border: 1px solid black;">'.sanitize_text_field($order1->billing_email).'</td>
	  <td style="border: 1px solid black;">'.sanitize_text_field(ucfirst(str_replace("wc-","", $order1->post_status))).'</td>
	  <td style="border: 1px solid black;">'.sanitize_text_field(wc_price($order1->order_total)).'</td>
	  </tr>';
	  }
	  }
	  echo '</tbody>
	  </table> 
	  </div>
	  <br>';
	  include 'pdf/pdf1.php';
	  echo wp_nonce_field('hp_easy_export_e2', 'hp_display_export_nonce1'); 
	  echo '<a id="export1" style="display:inline-block;box-sizing:border-box;margin:5px;text-align:center;text-decoration:none;cursor:pointer;background-color:transparent;-webkit-transition:all .25s ease;-moz-transition:all .25s ease;-ms-transition:all .25s ease;-o-transition:all .25s ease;transition:all .25s ease;font-size:10px;font-size:0.9rem;line-height:35px;line-height:0.1rem;min-width:50px;min-width:5rem;padding:16px 15px;border-color:#666;border-width:1px;border-style:solid;border-radius:2.5px; border-color:#a794a7;background-color:#a794a7;color:#ffffff; href="#">Export as CSV</a>';
	  echo '<input type="button" class="btn_grey" name="btn_grey" value="Print Out">
	  </form>';
    }
// The hp_easy_billing_list function will export the Billing List in PDF, CSV and Print
 function hp_easy_billing_list(){

   echo '<h2>Billing List</h2>
   <form method="POST" action="">';
   echo wp_nonce_field('hp_easy_export_e2', 'hp_display_export_nonce1'); 
   echo'
   <div id="dvData2">
   <table style="border-collapse: collapse; width: 100%; border: 1px solid black; background-color: white; text-align: center;" cellspacing="0" cellpadding="0" id="printReport">
   <thead>
   <tr>
   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">First Name</th>
   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Last Name</th>
   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Email</th>
   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Phone Number</th>
   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Address</th>
   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">City</th>
   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">State</th>
   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Zip</th>
   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Country</th>
   </tr>
   </thead>
   <tbody>';
	global $woocommerce;
	$query2 = array('post_type' => 'shop_order', 'post_status' => array('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-pending'), 'posts_per_page' => -1); 
	$loop2 = new WP_Query($query2);
	if($loop2->have_posts()){
	while ($loop2->have_posts() ){ 
	$loop2->the_post();
	$order_id2 = $loop2->post->ID;
	$order2 = new WC_Order($order_id2);
	echo '<tr>
	<td style="border: 1px solid black;">'.sanitize_text_field($order2->billing_first_name).'</td>
	<td style="border: 1px solid black;">'.sanitize_text_field($order2->billing_last_name).'</td>
	<td style="border: 1px solid black;">'.sanitize_text_field($order2->billing_email).'</td>
	<td style="border: 1px solid black;">'.sanitize_text_field($order2->billing_phone).'</td>
	<td style="border: 1px solid black;">'.sanitize_text_field($order2->billing_address_1).'</td>
	<td style="border: 1px solid black;">'.sanitize_text_field($order2->billing_city).'</td>
	<td style="border: 1px solid black;">'.sanitize_text_field($order2->billing_state).'</td>
	<td style="border: 1px solid black;">'.sanitize_text_field($order2->billing_postcode).'</td>
	<td style="border: 1px solid black;">'.sanitize_text_field($order2->billing_country).'</td>
	</tr>';
	}
	}
	echo '</tbody>
	</table>
	</div>
	<br>';
	include 'pdf/pdf2.php';
    echo wp_nonce_field('hp_easy_export_e1', 'hp_display_export_nonce2');
	  echo '<a id="export2" style="display:inline-block;box-sizing:border-box;margin:5px;text-align:center;text-decoration:none;cursor:pointer;background-color:transparent;-webkit-transition:all .25s ease;-moz-transition:all .25s ease;-ms-transition:all .25s ease;-o-transition:all .25s ease;transition:all .25s ease;font-size:10px;font-size:0.9rem;line-height:35px;line-height:0.1rem;min-width:50px;min-width:5rem;padding:16px 15px;border-color:#666;border-width:1px;border-style:solid;border-radius:2.5px; border-color:#a794a7;background-color:#a794a7;color:#ffffff; href="#">Export as CSV</a>';
	  echo '<input type="button" class="btn_grey" name="btn_grey" value="Print Out">
    </form>';
    }

    // The hp_easy_shipping_list function will export the Shipping List in PDF, CSV and Print
     function hp_easy_shipping_list(){

       echo '<h2>Shipping List</h2>
       <form method="POST" action="">';
       echo wp_nonce_field('hp_easy_export_e1', 'hp_display_export_nonce2');
	   echo'
       <div id="dvData3">
       <table style="border-collapse: collapse; width: 100%; border: 1px solid black; background-color: white; text-align: center;" cellspacing="0" cellpadding="0" id="printReport">
       <thead>
       <tr>
	   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">First Name</th>
	   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Last Name</th>
	   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Address</th>
	   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">City</th>
	   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">State</th>
	   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Zip</th>
	   <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Country</th>
       </tr>
       </thead>
       <tbody>';
		global $woocommerce;
		$query3 = array('post_type' => 'shop_order', 'post_status' => array('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-pending'), 'posts_per_page' => -1); 
		$loop3 = new WP_Query($query3);
		if($loop3->have_posts()){
		while ($loop3->have_posts() ){ 
		$loop3->the_post();
		$order_id3 = $loop3->post->ID;
		$order3 = new WC_Order($order_id3);
		echo '<tr>
       <td style="border: 1px solid black;">'.sanitize_text_field($order3->shipping_first_name).'</td>
       <td style="border: 1px solid black;">'.sanitize_text_field($order3->shipping_last_name).'</td>
       <td style="border: 1px solid black;">'.sanitize_text_field($order3->shipping_address_1).'</td>
       <td style="border: 1px solid black;">'.sanitize_text_field($order3->shipping_city).'</td>
       <td style="border: 1px solid black;">'.sanitize_text_field($order3->shipping_state).'</td>
       <td style="border: 1px solid black;">'.sanitize_text_field($order3->shipping_postcode).'</td>
       <td style="border: 1px solid black;">'.sanitize_text_field($order3->shipping_country).'</td>
       </tr>';
	   }
     }
	  echo '</tbody>
	   </table>
	   </div>
	   <br>';
	   include 'pdf/pdf3.php';
        echo wp_nonce_field('hp_easy_export_e2', 'hp_display_export_nonce1');
	  echo '<a id="export3" style="display:inline-block;box-sizing:border-box;margin:5px;text-align:center;text-decoration:none;cursor:pointer;background-color:transparent;-webkit-transition:all .25s ease;-moz-transition:all .25s ease;-ms-transition:all .25s ease;-o-transition:all .25s ease;transition:all .25s ease;font-size:10px;font-size:0.9rem;line-height:35px;line-height:0.1rem;min-width:50px;min-width:5rem;padding:16px 15px;border-color:#666;border-width:1px;border-style:solid;border-radius:2.5px; border-color:#a794a7;background-color:#a794a7;color:#ffffff; href="#">Export as CSV</a>';
	  echo '<input type="button" class="btn_grey" name="btn_grey" value="Print Out">
        </form>';
        }

        // The hp_easy_product_list function will export the Product List in PDF, CSV and Print
         function hp_easy_product_list(){

           echo '<h2>Product List</h2>
           <form method="POST" action="">';
		   echo wp_nonce_field('hp_easy_export_e2', 'hp_display_export_nonce1');
		   echo'
           <div id="dvData4">
           <table style="border-collapse: collapse; width: 100%; border: 1px solid black; background-color: white; text-align: center;" cellspacing="0" cellpadding="0" id="printReport">
           <thead>
           <tr>
	       <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">SKU</th>
	       <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Product Name</th>
	       <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Regular Price</th>
	       <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Total Stock</th>
	       <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Total Sales</th>
           </tr>
           </thead>
           <tbody>';
           global $wpdb;
           $query4 = $wpdb->get_results("SELECT p4.id, sk.meta_value AS sku, st.meta_value AS stock, p4.post_name AS post_name, pr.meta_value AS price, p4.post_title AS product, ts.meta_value AS total_sales
			  FROM
				  {$wpdb->prefix}posts AS p4
			  INNER JOIN {$wpdb->prefix}postmeta AS sk ON (p4.id = sk.post_id)
			  INNER JOIN {$wpdb->prefix}postmeta AS st ON (p4.id = st.post_id)
			  INNER JOIN {$wpdb->prefix}postmeta AS pr ON (p4.id = pr.post_id)
			  INNER JOIN {$wpdb->prefix}postmeta AS ts ON (p4.id = ts.post_id AND ts.meta_key LIKE 'total_sales')
			  WHERE 
			  sk.meta_key = '_sku'
			  AND st.meta_key = '_stock'
			  AND pr.meta_key = '_price'
			  AND p4.post_type LIKE 'product' AND p4.post_status LIKE 'publish'");
          if(count($query4)){
           foreach($query4 as $row4){
           echo '<tr>
           <td style="border: 1px solid black;">'.sanitize_text_field($row4->sku).'</td>
           <td style="border: 1px solid black;">'.sanitize_text_field(ucwords(str_replace("-"," ", $row4->post_name))).'</td>
		   <td style="border: 1px solid black;">'.sanitize_text_field($row4->price).'</td>
           <td style="border: 1px solid black;" class="st">'.sanitize_text_field($row4->stock).'</td>
           <td style="border: 1px solid black;" class="ts">'.sanitize_text_field($row4->total_sales).'</td>
           </tr>';
           }
           }
          echo ' </tbody>
           </table>
           </div>
           <br>';
		   include 'pdf/pdf4.php';
            echo wp_nonce_field('hp_easy_export_e1', 'hp_display_export_nonce2');
	  echo '<a id="export4" style="display:inline-block;box-sizing:border-box;margin:5px;text-align:center;text-decoration:none;cursor:pointer;background-color:transparent;-webkit-transition:all .25s ease;-moz-transition:all .25s ease;-ms-transition:all .25s ease;-o-transition:all .25s ease;transition:all .25s ease;font-size:10px;font-size:0.9rem;line-height:35px;line-height:0.1rem;min-width:50px;min-width:5rem;padding:16px 15px;border-color:#666;border-width:1px;border-style:solid;border-radius:2.5px; border-color:#a794a7;background-color:#a794a7;color:#ffffff; href="#">Export as CSV</a>';
	  echo '<input type="button" class="btn_grey" name="btn_grey" value="Print Out">
            </form>';
            }

          // The hp_easy_mailing_list function will export the Mailing List in PDF, CSV and Print
          function hp_easy_mailing_list(){
            echo '<h2>Mailling List</h2>
            <form method="POST" action="">';
			echo wp_nonce_field('hp_easy_export_e1', 'hp_display_export_nonce2');
			echo'
            <div id="dvData5">
            <table style="border-collapse: collapse; width: 100%; border: 1px solid black; background-color: white; text-align: center;" cellspacing="0" cellpadding="0" id="printReport">
            <thead>
            <tr>
	        <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">First Name</th>
	        <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Last Name</th>
	        <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Email</th>
	        <th style="border: 1px solid black; background-color: #e8e5fa;" scope="col" class="sortStyle">Country</th>
            </tr>
            </thead>
            <tbody>';
			global $woocommerce;
			$query5 = array('post_type' => 'shop_order', 'post_status' => array('wc-completed', 'wc-processing', 'wc-on-hold', 'wc-pending'), 'posts_per_page' => -1); 
			$loop5 = new WP_Query($query5);
			if($loop5->have_posts()){
			while ($loop5->have_posts() ){ 
			$loop5->the_post();
			$order_id5 = $loop5->post->ID;
			$order5 = new WC_Order($order_id5);
            echo '<tr><style>td { text-align: center; }td * { display: inline; }</style>
            <td style="border: 1px solid black;">'.sanitize_text_field($order5->billing_first_name).'</td>
            <td style="border: 1px solid black;">'.sanitize_text_field($order5->billing_last_name).'</td>
            <td style="border: 1px solid black;">'.sanitize_text_field($order5->billing_email).'</td>
            <td style="border: 1px solid black;">'.sanitize_text_field($order5->billing_country).'</td>
            </tr>';
            }
            }
         echo '</tbody>
          </table>
          </div>
          <br>';
          include 'pdf/pdf5.php';
          echo wp_nonce_field('hp_easy_export_e2', 'hp_display_export_nonce1');
	  echo '<a id="export5" style="display:inline-block;box-sizing:border-box;margin:5px;text-align:center;text-decoration:none;cursor:pointer;background-color:transparent;-webkit-transition:all .25s ease;-moz-transition:all .25s ease;-ms-transition:all .25s ease;-o-transition:all .25s ease;transition:all .25s ease;font-size:10px;font-size:0.9rem;line-height:35px;line-height:0.1rem;min-width:50px;min-width:5rem;padding:16px 15px;border-color:#666;border-width:1px;border-style:solid;border-radius:2.5px; border-color:#a794a7;background-color:#a794a7;color:#ffffff; href="#">Export as CSV</a>';	  
	  echo '<input type="button" class="btn_grey" name="btn_grey" value="Print Out">
             </form>';
          }
       }
     // Check if HP_Easy_Export exists then
	  // the plugin will activate or deactivate
	  if(class_exists('HP_Easy_Export')){
		register_activation_hook( __FILE__, array('HP_Easy_Export', 'activate_hp_easy_export'));
		register_deactivation_hook( __FILE__, array('HP_Easy_Export', 'deactivate_hp_easy_export'));
		register_uninstall_hook(__FILE__, array('HP_Easy_Export', 'uninstall_hp_easy_export'));
		$HP_Easy_Export = new HP_Easy_Export();
	  }
  ?>
