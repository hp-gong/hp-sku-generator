# simple-sku-generator

Creating SKU for products

<b>== Wordpress Page ==</b>

https://wordpress.org/plugins/simple-sku-generator/

<b>== Description ==</b>

The purpose of Simple SKU Generator plugin is to create SKU for the products. 
Read the instructions on the sku-overview.pdf file for more in detail how to keep the old SKU and create the new SKU at once.

<b>== Installation ==</b>

1. Download and activate WooCommerce plugin which is required for Simple SKU Generator plugin to work.
2. Upload the plugin from your WordPress Plugins section.
3. Activate the plugin through the 'Plugins' menu in WordPress.

<b>== Instructions ==</b>

The instructions is in the master zip file

Read the sku-overview.pdf for more details how the plugin works 

These are the 4 current browsers that currently support/display this plugin correctly:

1. FireFox (Current Version: 64 and up)
2. Chrome (Current Version: 71 and up)
3. Opera (Current Version: 56 and up)
4. Microsoft Edge (Current Version: 42 and up)

<b>== Frequently Asked Questions ==</b> 

<b>Q. How many SKU can the Simple SKU Generator plugin create?</b>

<b>A.</b> The total numbers of SKU that Simple SKU Generator plugin can create is varies between 6 to 13 digits/letters.

<b>Q. What are the 4 options to used to created the SKU?</b>

<b>A.</b> (1) Month: 2 dights/Number(1): 1 dight/Number(3): 3 dight/Letter: 1 dight or Blank. 
          (2) Year: 4 dight. 
          (3) Date: 2 dight. 
          (4) The amount of products you have: 4 dights.

<b>Q. What are the digits base on?</b>

<b>A.</b> The digits can be used to create barcode digits for EAN-8, UPC-A, EAN-13, CODE-39, CODE-93, EAN-128, CODE-128, ITF, QR, DMTX.

<b>Q. What is a Blank?</b>

<b>A.</b> The Blank purpose is to shorten the digits for EAN-8 (& UPC-C) or for your own preference. There are Blank for Month/Number(1)/Number(3)/Letter, Year, Date. Letter, Year, Date. 

I wouldn't advise shorten less than 8 digits. 

It's hard to read and follow which sku is assign to which product once scan the barcode.  

<b>Q. The Display SKU page has 2 buttons what are their function?</b>

<b>A.</b> The Remove button will ONLY remove/delete all the SKU from the SKU table not from the Wordpress database. It won’t delete the products on your websites. It’s best to remove the SKU list after you export the CSV that contain the SKU. 
The Export CSV button will export the CSV. There will be no header on the CSV file.

<b>Q. How do I upload the CSV file that contain the SKU for the products and keep the old SKU?</b>

<b>A.</b> Before you upload the CSV file, you have to backup database or export your current products because if you are not sure if you are uploading the CSV file correctly or make a mistake. You can always import the current products CSV file and redo this again correctly. You can used WooCommerce products (CSV) importer, which is offer by WooCommerce plugin to upload the CSV file. Everytime you open a CVS file it will ask you to save the file twice, just save it twice.

<b>Reminder</b>: 

<b>***  Before you upload the the new CSV file, you have to backup database or export your current products ***</b> 

<b>Q. What happened if I deactivate the plugin or delete the plugin?</b>

<b>A.</b> If you deactivate the plugin it will stay on the plugin page and the SKU tables will be still on wordpress database. But if you delete/remove the plugin it will delete the folders, files and also the tables from the wordpress database.

<b>== Languages and Software ==</b>

I used Indesign to create the sku-overview.pdf file.

These are the languages and software I used for the Simple SKU Generator plugin:

Language: HTML, CSS, JQuery, OOP PHP, Wordpress Codex

Software: Atom, Photoshop and Indesign

-- HP Gong
