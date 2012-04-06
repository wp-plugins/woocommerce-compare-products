=== Woocommerce Compare Products ===


Contributors: A3 Revolution Software Development team

Tags: WooCommerce, WooCommerce Plugins, WooCommerce compare products, WooCommerce plugins, compare products plugin, compare products


Requires at least: 2.92
Tested up to: 3.3.1
Stable tag: 1.0.3

Add a Compare Products Feature to all of your products on you WooCommerce site with the FREE WooCommerce Compare Products plugin. It is plug and play.

== Description ==


WooCommerce Compare Products is is the one and only Compare Products plugin for WooCommerce. Ever seen or used one of those excellent Compare Products features on another ecommerce platform? You will agree they are a brilliant feature. WooCommerce Compare Products has very every feature of the best of those and it is plug-and-play.

WooCommerce Compare Products allows you to add a professional product Comparison feature to any product on your woocommerce site. Site users click a button or a link to add products to their compare list in the sidebar widget area.

When you install and activate WooCommerce Compare Products Lite it auto adds a Compare Button to every product page and the Compare Products sidebar widget to your active products page sidebar. It also adds a Compare Settings link to your WooCommerce sidebar admin panel. On the Compare Products settings page you will find detailed and comprehensive instructions on how to set up and manage your WooCommerce Compare Products feature. 

= WooCommerce Compare Products Lite Key Features =

* Users don't have to be logged or even registered to use the Compare Products feature.
* Users can add any number of products to the Compare Widget in the sidebar.
* Products are added to the sidebar widget by Ajax - meaning that the page does not reload any time items added or removed to the Compare sidebar widget.
* Add products to compare from the Product Category Pages or from the single Product page.
* Remove unwanted selections right from the sidebar Compare widget or clear all and start again.
* Products are compared side by side in a beautiful mac like fly out window.
* Product images shown in proportion in the Fly-Out window.
* Remove discarded selections from the Fly-Out window and they are auto removed from the sidebar widget.
* In the compare Fly-Out window users can narrow their choice down to 3 products and print them.
* The plugin auto adds a Compare TAB to the woocommerce main tabs. You can choose the position of the tab.  
* Works with any theme.
* White Label.

= Easy Admin Features = 

* You set up your Compare Product Features Set via the simple 1 page admin panel complete with full instructions.
* The plugin when activated auto adds a Compare Settings link to your Woocommerce Products Menu
* Once you have added your Compare Features Fields they auto show on each products editing screen.
* Set to show the Compare Products feature as a Button or Hyper Linked Text.
* Set the text that shows in the button or the hyper link.
* Clear and detailed instructions on how to manually set the Compare Button position on product Pages and the Button style and color.
* Select if you want the Compare features to also show under a TAB on the WooCommerce products page.
* Set position of TAB on Woocommerce product nav bar and set name for the TAB.
* Add your sites logo / graphic to the Compare Fly-Out window.
* Set the size and height that the Compare Fly-Out window opens in.
* When adding or editing a product all you have to do is just fill in the Compare Features Fields that auto show on the Products editing screen.
* Publish or update a product and the Products Comparable Features auto show when the Compare button is clicked.

= Pro Version Features =

PRO version available soon from the WooCommerce official Extensions site.

* Seamless upgrade - you do not lose any of the Compare Features you have set up on the Lite Version when you upgrade. 
* Add to Cart Functionality from Compare Fly-Out Window.
* Create Unlimited Compare Product Categories
* Assign Compare Features to Multiple categories.
* Fly-Out Window only shows Compare Features for that Product - Not All.
* Create Compare Features for Product 'Variants' (Models)
* Variants allows users to compare Model features side-by-side
* Neat and tidy Compare Feature on Product edit screen instead of a big long list of features.

= Localization =
* English (default) - always include.
* .pot file (woo_cp.pot) in languages folder for translations.
* Your translation? Please [send it to us](http://www.a3rev.com/contact/) We'll acknowledge your work and link to your site.
Please [Contact us](http://www.a3rev.com/contact/) if you'd like to provide a translation or an update.
 
[Documentation](http://a3rev.com/products-page/woocommerce/woocommerce-compare-products/) |
[Support](http://a3rev.com/products-page/woocommerce/woocommerce-compare-products/#help)



== Screenshots ==


1. screenshot-1.png

2. screenshot-2.png

3. screenshot-3.png

4. screenshot-4.png

5. screenshot-5.png

6. screenshot-6.png

7. screenshot-7.png





== Installation ==


1. Upload the folder woocommerce-compare-products to the /wp-content/plugins/ directory

2. Activate the plugin through the Plugins menu in WordPress



== Usage ==


1. Open WooCommerce > Compare Settings

2. Opens to the SETTINGS tab

3. Follow the detailed set up instructions on Compare setting dashboard which show you how to

4. Style you Compare Products Fly-Out screen - upload header image and set screen dimensions.

5. Select to show Compare Feature on Product Pages as Button or Hyperlink Text.

6. Set text to show in Button or Link.

7. Set Compare Products Tab to show in WooCommerce Product Page Navigation Tabs.

8. Save Settings to save your work. You are now ready to add the Compare features data for each product.

9. Click the FEATURES tab add your Master Category Feature Fields

10. Follow the instructions on adding and managing Compare Features to the master category.

11. Visit Product edit pages to where you (i) Deactivate the feature for that Product or (ii) Add Compare Feature Fields data for that Products. Update (or publish) and your compare features for that product is published.

Celebrate the extra sales Compare Products brings you !  

== Frequently Asked Questions ==

= 
When can I use this plugin? =

You can use this plugin when you have installed the WooCommerce plugin.

= How do I change the Color of the Button to match my theme? = It is an easy task to change the color of the button - but you will need some coding knowledge.

All objects in the plugin have a class so you can style for them. Using an ftp client open the style.css in your theme.

Look for the style of your themes buttons below is an example - it will look something like this

#wrap input[type="submit"], #wrap input[type="button"] {
background: url('images/bg-button.png') no-repeat scroll right top transparent;
border: 1px solid #153B94;
border-radius: 5px 5px 5px 5px;
box-shadow: 1px 1px 2px #333333;
color: #FFFFFF;
cursor: pointer;
font-size: 12px;
padding: 9px 27px 7px 10px;
}

Once you have found that in themes style.css directory then add that style into your themes style.css under the class name 'bt_compare_this' which is for the Compare button on the product pages and class name 'compare_button_go' for the Compare button in the sidebar widget. This is how it would look using the example above as the style for the button.

input.bt_compare_this {
background: url('images/bg-button.png') no-repeat scroll right top transparent;
border: 1px solid #153B94;
border-radius: 5px 5px 5px 5px;
box-shadow: 1px 1px 2px #333333;
color: #FFFFFF;
cursor: pointer;
font-size: 12px;
padding: 9px 27px 7px 10px;
}

This will then mean that style will apply for all input tag in div that has the class compare_button_container to change the sidebar widget button you do the same but use the class 'compare_button_go'

== Support ==


All support requests, questions or suggestions should be posted to the [HELP tab](http://a3rev.com/products-page/woocommerce/woocommerce-compare-products/#help) WooCommerce Compare Products Home page on the a3rev site.
  



== Changelog ==

= 1.0.3 - 05/04/2012 =

* Tweak: Compare Settings page now on 2 tabs - SETTINGS | FEATURES in the same style as WooCommerce setting page for familiarity and greater ease of use.


= 1.0.2 - 04/04/2012 =

* Feature: Add default WooCommerce Fancybox  Fly-Out screen option. Retained Lightbox and now have option to use Fancybox or Lightbox to power Fly-Out window.
* Feature: Greatly improved the layout and ease of use of the single page admin panel.
* Feature: Added comprehensive admin page plugin setup instructions and added Tool Tips
* Fix : Auto add Compare Widget to sidebar when plugin is activated.
* Fix: Feature Unit of Measurement is added in brackets after Feature Name and if nothing added it does not show.
* Fix: Use $woocommerce->add_inline_js for inline javascript to add it to the footer (after scripts/fancybox are loaded) to prevent errors
* Tweak: Changed Fly-Out window from - include( '../../../wp-config.php') to show content using wp_ajax
* Tweak: Run WP_DEBUG and fix plugins 'undefined...' errors
* Tweak: Removed fading update messages and animation and replaced with default wordpress 'updated' messages.
* Tweak: Replace custom ajax handlers  with wp_ajax and wp_ajax_nopriv 
* Tweak: Add pop up window when deleting feature fields to ask you to check if you are sure? 

= 1.0.1 - 22/03/2012 =
* Tweak: Remove validation script never use for this plugin 

= 1.0.0 - 15/03/2012 =
* First working release of the modification

== Upgrade Notice ==

= 1.0.0 - 15/03/2012 =
This first version.
