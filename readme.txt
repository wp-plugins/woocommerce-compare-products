=== Woocommerce Compare Products ===


Contributors: A3 Revolution Software Development team

Tags: WooCommerce, WooCommerce Plugins, WooCommerce compare products, woocommerce plugins, e-commerce, shop, cart, ecommerce, compare products plugin, compare products


Requires at least: 2.92
Tested up to: 3.3.1
Stable tag: 1.0.0

Add a Compare Products Feature to all of your products on you WooCommerce site with the FREE Woo Comapre Products plugin. It is plug and play.

== Description ==


Woo Compare Products will take you just minutes to set up and be ready to start entering your products features and giving your customers the ultimate in product comparison features. 

Woo Compare Products adds an ultimately professional product Comparison feature to any product on your woocommerce site. Site users click a button or a link to add products to their compare list in the sidebar widget area. 

Once products are added to the Compare sidebar widget users click the Compare button and the products they have added show side-by-side with all features in a beautiful mac like Fly-out screen. In that screen they can compare products and features. They can narrow their choices down by removing products. From the pop up screen they, print the results or return to the product page and continue to add other products.

= Key Features =
* Users don't have to be logged or even registerd to use the Compare Products feature.
* Users can add any number of products to the Compare Wiget in the sidebar.
* Products are added to the sidebar widget by Ajax - meaning that the page does not reload any time items added or removed to the Compare sidebar widget.
* Add products to compare from the Product Category Pages or from the single Product page.
* Remove unwanted selections right from the sidebar Compare widget or clear all and start again.
* Products are compared side by side in a beatiful mac like fly out window that has your logo / header graphic.
* Product images shown in proportion in the fly out window.
* Remove discarded selections from the fly out window and they are auto removed from the sidebar widget.
* In the compare fly out window users can narrow their choice down to 3 products and print them.
* Integrates with WooCommerce Shortcodes. Use WooCommerce shortcode to embed a product on any Post or page on your site and if that Product has Compare Features activated the Compare feature shows and works.
* The plugin allows you to auto add, name and position a Comapre TAB to the woocommerce main product page Nav Tabs. You can also choose not to show.  
* Works with any theme that has the appropiate Hook. You'll find instructions on the single page admin panel on how to manually set the Button if your theme does not support. You will know if it doesn't when you install because the Compare button won't auto show on the product pages.
* White Label.

= Easy Admin Features = 
* You set up your Compare Product Features Set via the simple 1 page admin panel.
* The plugin when activated auto adds a Comparable Settings link to your Woocommerce Products Menu
* Plugin auto adds Compare button to every product page.
* Plugin auto adds Compare Sidebar widget to your theme.
* Once you have added your Master Category Compare Features Fields they auto show on each products editing screen.
* Deactivate the feature manually from each Products editing screen.
* Select if you want the Compare features to also show under a TAB on the products page.
* Set position of TAB on Woocommerce product nav bar and set name for the TAB.
* Set to show the Compare Products feature as a Button or Hyper Linked Text on each product page.
* Set the text that shows in the button or the hyper link.
* Add your sites logo / graphic to the Compare Pop up window.
* Set the size and height that the compare pop up window opens in.
* When adding or editing a product all you have to do is just fill in the Compare Features Fields that auto show on the Products editing screen.
* Publish or update a product and the Products Comparable Features auto show when the Compare button is clicked.

= Pro Version Features =
Coming Soon with these extra features!
* The FREE version of Woo Compare Products has 1 Master Features Category set. This is fine for small sites or sites that have one type of product.The PRO version allows you to create and easily manage unlimited Featured Category sets.
* PRO version does not auto add the Compare Button to ALL products. This allows you to progressively roll out the Feature accross your site.
* PRO version allows users to add products to their cart from the Fly-out screen.
* PRO version allows you to add product variants. Great for when you have a product that has Models - allows users to compare the each Models Features side-by-side with each other and against other products features.
* PRO lets you choose the Category Feature set you want to use for the product on the products edit screen. 
 
[Documentation](http://www.a3rev.com/products-page/woocommerce/woo-compare-products/) |
[Support](http://www.a3rev.com/products-page/woocommerce/woo-compare-products/)



== Screenshots ==


1. screenshot-1.jpg
2. screenshot-2.jpg
3. screenshot-3.jpg
4. screenshot-4.jpg
5. screenshot-5.jpg
6. screenshot-6.jpg
7. screenshot-7.jpg




= Localization =
Please [Contact us](http://www.a3rev.com/contact/) if you'd like to provide a translation or an update.

== Installation ==


1. Upload the folder woo-compare-products to the /wp-content/plugins/ directory

2. Activate the plugin through the Plugins menu in WordPress



== Usage ==


1. Open WooCommerce > Comparable Settings



2. Add your Master Category Feature Fields

3. Style you Compare Products Fly out screen - upload header image and set screen dimensions.

4. Select to show Compare Feature on Product Pages as Button or Hyperlink Text.

5. Set text to show in Button or Link.

6. Set Compare Products Tab to show in WooCommerce Product Page Navigation Tabs.

7. Save Settings and Comapre Products Features is activated on every product on your site. You are now ready to add the Compare features data for each product.

8. Visit Product edit pages to where you (i) Deactivate the feature for that Product or (ii) Add Compare Feature Fields data for that Products. Update (or publish) and your compare features for that product is published.

9. Celebrate !  

== Frequently Asked Questions ==

= 
When can I use this plugin? =

You can use this plugin when you have installed the WooCommerce plugin.

= How do I change the Colour of the Button to match my theme? = It is an easy task to change the colour of the button - but you will need some coding knowledge.

All objects in the plugin have a class so you can style for them. Using an ftp client open the style.css in your theme.

Look for the style of your themes buttons – below is an example - it will look something like this

#wrap input[type="submit"], #wrap input[type="button"] {
background: url(“images/bg-button.png”) no-repeat scroll right top transparent;
border: 1px solid #153B94;
border-radius: 5px 5px 5px 5px;
box-shadow: 1px 1px 2px #333333;
color: #FFFFFF;
cursor: pointer;
font-size: 12px;
padding: 9px 27px 7px 10px;
}

Once you have found that in themes style.css directory then add that style into your themes style.css under the class name “bt_compare_this” which is for the Compare button on the product pages and class name “compare_button_go” for the Compare button in the sidebar widget. This is how it would look using the example above as the style for the button.

input.bt_compare_this {
background: url(“images/bg-button.png”) no-repeat scroll right top transparent;
border: 1px solid #153B94;
border-radius: 5px 5px 5px 5px;
box-shadow: 1px 1px 2px #333333;
color: #FFFFFF;
cursor: pointer;
font-size: 12px;
padding: 9px 27px 7px 10px;
}

This will then mean that style will apply for all input tag in div that has the class compare_button_container – to change the sidebar widget button you do the same but use the class “compare_button_go”

== Support ==


If you have any problems, questions or suggestions please post your request to the [HELP tab] (

http://www.a3rev.com/products-page/woocommerce/woo-compare-products/#comments) on the a3rev site.
  



== Changelog ==

= 

= 1.0.0 - 15/03/2012 =
* First working release of the modification



== Upgrade Notice ==

= 

= 1.0.0 - 15/03/2012 =
This first version.
