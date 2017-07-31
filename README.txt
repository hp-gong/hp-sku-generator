=== Simple SKU Generator ===

Contributors: hpgong
Donate link: N/A
Tags: sku, create sku, sku products
Version: 1.0.0
Requires at least: 4.8
Tested up to: 4.8 
Stable tag: 1.0.0
Author: H.P. Gong
Author URI: https://github.com/hp-gong
GitHub Plugin URI: https://github.com/hp-gong/hp-sku-generator
GitHub Branch: master
License: GPL-3.0+
License URI: https://www.gnu.org/licenses/gpl-3.0.txt

== Description ==

The purpose of Simple SKU Generator plugin is to create SKU for the products. This will also keep the old SKU and also create new SKU for products that doesn’t have SKU. Read the instructions on the sku-overview.pdf file for more in detail how to keep the old SKU and create the new SKU at once. 

== Installation ==
 
1. Upload the plugin from your WordPress Plugins section
2. Activate the plugin through the 'Plugins' menu in WordPress 

== Changelog == 

= Version 1.0.0 - 07-02-2017 = 
* First release.

== Upgrade Notice ==

N/A

== Screenshots == 

N/A

== Instructions ==

Click here <a href="https://github.com/hp-gong/hp-sku-generator/raw/master/sku-overview.pdf">sku-overview.pdf</a> to download the instructions

Read the sku-overview.pdf for more details how the plugin works

These are the 4 current browsers that currently support/display this plugin correctly

1. FireFox (Current Version: 53.0.3 and up)
2. Chrome (Current Version: 58.0 and up)
3. Opera (Current Version: 45.0 and up)
4. Internet Explorer (Last Version: 11)

== Frequently Asked Questions == 

Q. How many SKU can the Simple SKU Generator plugin create?

A. The total numbers of SKU that Simple SKU Generator plugin can create is 4,500.

Q. What are the Letter, Year, Start, End and Stop?

A. There are 5 Letters (A-E).

Each Letter has an option to choose 1 of 5 Years (2016-2020).

There are 3 Start option to choose from (1000-3000).

Each Start has 3 option to choose from 3 set of End: (1100,1200,1300), (2100,2200,2300), (3100,3200,3300).

If you choose 1000 as Start and 1200 as End, it is equal to 200 products. 1200-1000 = 200.

If you have less than 200 products then you have to enter the Stop number or enter 0 if you have 200.

For example, you choose 2000 as Start and 2300 as End, it is equal to 300 products. 2300-2000 = 300.

But you only have 213 products on your website. 

You have to enter 2213 as Stop number. At 2213, it will stop creating SKU(s). If you dont do that it will keep generating SKU for no products assign to it.

The Letters, Years, Start & End will create the SKU.

For the Stop, as a reminder you have to enter the total amount of products you have on your website. 

This will let the Simple SKU Generator know how many products you have on the website, the Stop number will stop creating SKU.

Q. The sku display page has 2 buttons what are their function?

A. The Remove button will ONLY remove/delete all the SKUfrom the SKU table not from the Wordpress database. It won’t delete the products on your websites. It’s best to remove the SKU list after you export the CSV that contain th SKU. 

The Export CSV button will export the CSV. There will be no header on the CSV file.

Q. How do I upload the CSV file that contain the SKU for the products and keep the old SKU?

A. Before you upload the CSV file, you have to backup or export your current products because if you are not sure if you are uploading the CSV file correctly or make a mistake. You can always import the current products CSV file and redo this again correctly. You have to download a import plugin to upload the SKU CSV file. There are alot of import plugins for woocommerce to choose. I would download and try this import plugin: <a href=”https://wordpress.org/plugins/woocommerce-csvimport/”>Woocommerce CSV Import</a>. It’s simple to used and understand. <b>Everytime you open a CVS file it will ask you to save the file twice, just save it twice.</b> 

Q. What happened if I deactivate the plugin or delete the plugin?

A. If you deactivate the plugin it will stay on the plugin page and the SKU tables will be still on wordpress database. But if you delete/remove the plugin it will delete the folders, files and also the tables from the
wordpress database.
