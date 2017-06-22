<?php
require_once '../../../../wp-load.php';
if (current_user_can('manage_options')) {
	header("Content-type: application/force-download"); 
	header('Content-Disposition: inline; filename="new_sku'.date('YmdHis').'.csv"'); 
$results = $wpdb->get_results("SELECT s1.w_id, s1.w_title, s2.w_letter, s2.w_year, s2.w_item FROM {$wpdb->prefix}woo_sku1 AS s1 INNER JOIN {$wpdb->prefix}woo_sku2 AS s2 ON s1.id=s2.id" );		
	if (count($results))  {
		foreach($results as $row) {
			 echo $row->w_id.','.$row->w_title.','.$row->w_letter.''.$row->w_year.''.$row->w_item."\r\n";
}
}
}
?>





