=== Simple SKU Generator ===

Contributors: hpgong
Donate link: N/A
Tags: sku, product sku, sku generator, sku id, sku numbers, woocommerce, inventory, items
Version: 1.2.0
Requires at least: 5.0.0
Tested up to: 5.0.0
Stable tag: 1.2.0
Author: H.P. Gong
Author URI: https://github.com/hp-gong
GitHub Plugin URI: https://github.com/hp-gong/hp-sku-generator
GitHub Branch: master
License: GPL-3.0+
License URI: https://www.gnu.org/licenses/gpl-3.0.txt

== Description ==

The purpose of Simple SKU Generator plugin is to create SKU for the products. 
Read the instructions on the sku-overview.pdf file for more in detail how to keep the old SKU and create the new SKU at once.

== Installation ==

1. Download and activate WooCommerce plugin which is required for Simple SKU Generator plugin to work.
2. Upload the plugin from your WordPress Plugins section.
3. Activate the plugin through the 'Plugins' menu in WordPress.

== Changelog ==

= Version 1.2.0 - 12-20-2018 =
* Fixed discrepancy / errors.
* Modify & Update & Add codes on the plugin.
* Update README file.
* Update Instructions for the sku-overview.pdf.
* TEST: Wordpress 5.0.0 - PASS
* TEST: WooCommerce 3.5.2 - PASS
* Maintenance.

= Version 1.1.1 - 01-01-2018 =
* Maintenance.

= Version 1.1.0 - 07-30-2017  =
* Maintenance.
* Update codes on the plugin.

= Version 1.0.0 - 07-02-2017 =
* First release.

== Upgrade Notice ==

N/A

== Screenshots ==

N/A

== Instructions ==

Click here <a href="https://github.com/hp-gong/hp-sku-generator/raw/master/sku-overview.pdf">sku-overview.pdf</a> to download the instructions

Read the sku-overview.pdf for more details how the plugin works

These are the 4 current browsers that currently support/display this plugin correctly:

1. FireFox (Current Version: 64 and up)
2. Chrome (Current Version: 71 and up)
3. Opera (Current Version: 56 and up)
4. Microsoft Edge (Current Version: 42 and up)

== Frequently Asked Questions ==

Q. How many SKU can the Simple SKU Generator plugin create?

A. The total numbers of SKU that Simple SKU Generator plugin can create is varies between 6 to 12 digits/letters.

Q. What are the 4 options to used to created the SKU?

A. (1) Month: 2 dights/Number(1): 1 dight/Number(3): 3 dight/Letter: 1 dight or Blank. (2) Year: 4 dight. (3) Date: 2 dight. (4) The amount of products you have: 4 dights.

Q. What are the digits base on?

A. The digits can be used to create barcode digits for EAN-8, UPC-A, EAN-13, CODE-39, CODE-93, EAN-128, CODE-128, ITF, QR, DMTX

Q. What is a Blank?

A. The Blank purpose is to shorten the digits for EAN-8 (& UPC-C) or for your own preference. There are Blank for Month/Number(1)/Number(3)/Letter, Year, Date. Letter, Year, Date. 

I wouldn't advise shorten less than 8 digits. 

It's hard to read and follow which sku is assign to which product once scan the barcode.   

Q. The sku display page has 2 buttons what are their function?

A. The Remove button will ONLY remove/delete all the SKU from the SKU table not from the Wordpress database. It won’t delete the products on your websites. It’s best to remove the SKU list after you export the CSV that contain the SKU. 
The Export CSV button will export the CSV. There will be no header on the CSV file.

Q. How do I upload the CSV file that contain the SKU for the products and keep the old SKU?

A. Before you upload the CSV file, you have to backup database or export your current products because if you are not sure if you are uploading the CSV file correctly or make a mistake. You can always import the current products CSV file and redo this again correctly. You can used WooCommerce products (CSV) importer, which is offer by WooCommerce plugin to upload the CSV file. Everytime you open a CVS file it will ask you to save the file twice, just save it twice.

<b>Reminder</b>: 

<b>***  Before you upload the the new CSV file, you have to backup database or export your current products ***</b> 

Q. What happened if I deactivate the plugin or delete the plugin?

A. If you deactivate the plugin it will stay on the plugin page and the SKU tables will be still on wordpress database. But if you delete/remove the plugin it will delete the folders, files and also the tables from the
wordpress database.
