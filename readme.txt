=== Woocommerce Compare Products ===
Contributors: a3rev, A3 Revolution Software Development team
Tags: WooCommerce, WooCommerce Plugins, WooCommerce compare products, compare products plugin, compare products
Requires at least: 2.92
Tested up to: 3.5
Stable tag: 2.0.3

Add a Compare Products Feature to all of your products on you WooCommerce site today with the WooCommerce Compare Products plugin..

== Description ==

WooCommerce Compare Products instantly adds the <strong>cutting edge Compare products feature</strong> to your WooCommerce store in just minutes.

[youtube http://www.youtube.com/watch?v=g8__ZFxKSRA] 

WooCommerce Compare Products uses your existing WooCommerce Product Categories and WooCommerce Product Attributes to create Compare Features for each and every product that can then be compared – side-by-side, feature by feature, price-by-price (if you show prices) in a single on-page pop-up screen.  
 
= Key Features =

* Professional front end compare products presentation, buttons, links, sidebar widget and Compare pop-up window.
* Works with any Theme that has WooCommerce plugin installed and activated.
* Existing Product Categories, Attributes and Terms are auto created as Compare Categories, Features and Feature values. Compare features are auto added the Compare Master Category.
* Add an additional unlimited number of custom Compare categories and features - very flexible.

<strong>Online shoppers love the compare products feature</strong> and giving customers more of what they love leads to <strong>more sales.</strong>. Boost your sales today by installing WooCommerce Compare Products on your WooCommerce store.

= Comprehensive Documentation =

Find comprehensive plugin documentation [here](http://docs.a3rev.com/user-guides/woocommerce/compare-products/)

= Premium Upgrade =

When you install WooCommerce Compare Products you will see all the added functionality that the Premium Version offers. The plugin is designed so that the upgrade is completely seamless. Nothing changes except all the features of Compare Products you see on the lite version are activated. This means you can activate, set up and use the free version completely risk free.  


[Pro Version Upgrade](http://a3rev.com/shop/woocommerce-compare-products/) |
[Documentation](http://docs.a3rev.com/user-guides/woocommerce/compare-products/) |
[Support](http://a3rev.com/shop/woocommerce-compare-products/#tab-reviews)

= Localization =
* English (default) - always include.
* Turkish - added thanks to ManusH
* .pot file (woo_cp.pot) in languages folder for translations.
* Your translation? Please [send it to us](http://www.a3rev.com/contact/) We'll acknowledge your work and link to your site.
Please [Contact us](http://www.a3rev.com/contact/) if you'd like to provide a translation or an update. 


== Screenshots ==
1. screenshot-1.png

2. screenshot-2.png

3. screenshot-3.png

4. screenshot-4.png

5. screenshot-5.png


== Installation ==
1. Upload the folder woocommerce-compare-products to the /wp-content/plugins/ directory

2. Activate the plugin through the Plugins menu in WordPress

== Usage ==

1. Open WooCommerce > Compare Settings

2. Opens to the SETTINGS tab

* Style your Compare Products Fly-Out screen - upload header image and set screen dimensions.
* Select to show Compare Feature on Product Pages as Button or Hyperlink Text.
* Set text to show in Button or Link.
* Set Compare Products Tab to show in WooCommerce Product Page Navigation Tabs.
* Save Settings to save your work. You are now ready to add the Compare features data for each product.

3. Click the FEATURES tab 

4. Click the dropdown arrow at the end of the Master Category tab. You'll see that all of your parent product Attributes have been auto created as Compare Features.

5. Add any Custom Compare categories or features you require.

6  Edit or deactivate the Compare feature for any products edit page.

Celebrate the extra sales Compare Products brings you !  

== Frequently Asked Questions ==

= 
When can I use this plugin? =

You can use this plugin when you have installed the WooCommerce plugin.

 
== Support ==
All support requests, questions or suggestions should be posted to the [HELP tab](http://a3rev.com/shop/woocommerce-compare-products/#tab-reviews) WooCommerce Compare Products Home page on the a3rev site.

== Changelog ==

= 2.0.3 - 2013/01/08 = 

* Feature: Added support for Chinese Characters* Tweak: UI tweak - changed the order of the admin panel tabs so that the most used Features tab is moved to first tab.* Tweak: Added links to all other a3rev wordpress.org plugins from the Features tab
* Tweak: Updated Support and Pro Version link URL's on wordpress.org description, plugins and plugins dashboard. Links were returning 404 errors since the launch of the all new a3rev.com mobile responsive site as the base e-commerce permalinks is changed.


= 2.0.2 - 2012/12/14 =

* Fixed: Updated depreciated custom database collator $wpdb->supports_collation() with new WP3.5 function $wpdb->has_cap( 'collation' ). ÊSupports backward version compatibility.
* Fixed: When Product attributes are auto created as Compare Features, if the Attribute has no terms then the value input field is created as Input Text - Single line instead of a Checkbox.
* Fixed: On Compare Products admin tab, ajax not able to load the products list again after saving a product edit


= 2.0.1 - 2012/08/14 =

* Changed - attributes terms where auto created as Compare Feature input type 'dropdown' (single select). Changed to input type 'check box' (multi-select)
* Documentation - Added comprehensive extension documentation to the [a3rev wiki](http://docs.a3rev.com/user-guides/woocommerce/compare-products/).
* Localization - Added Turkish translation (thanks to ManusH & Keremidi)
* Video - Added demo video to extensions home page
* Tweak: Set database table name to be created the same as WordPress table type
* Tweak - Change localization file path from actual to base path
* Tweak - Corrected typo on Compare pop-up window

= 2.0 - 2012/08/03 =

MAJOR UPGRADE

* Feature - All Product Categories and Sub Categories are auto created as Compare Categories when plugin is activated. Feature is activated on upgrade.
* Feature - All Product Parent Variations auto added to Master Category as Compare Features when the plugin is first activated.
* Feature - When Product Categories or Sub categories are created they are auto created as Compare categories. The plugin only listens to Create new so edits to Product categories are ignored.
* Feature: When parent product variations are created they are auto created as Compare Features. Child product variations and edits are ignored. 
* Feature - Complete rework of admin user interface - Combined Features and Categories tabs into a single tab - Added Products Tab. Greatly enhanced user experience and ease of use.
* Feature - Moved Create New Categories and Features to a single edit on-page assessable from an 'add new' button on Features tab.
* Feature - Added Features search facility for ease of finding and editing Compare Features.
* Feature - Added support for use of special characters in Feature Fields.
* Feature - Added support for use of Cyrillic Symbols in Feature Fields.
* Feature - Added support for use of sup tags in Feature Fields.
* Feature - Language file added to support localization – looking for people to do translations.
* Feature - Created plugin documents on a3rev wiki.
* Fixed - Can't create Compare Feature if user does not have a default value set in SQL. Changed INSERT INTO SQL command output to cater for this relatively rare occurrence.
* Tweak - Replaced all Category Edit | Delete icons with WordPress link text. Replace edit icon on Product Update table with text link.
* Tweak - Edited Product update table to fit 100% wide on page so that the horizontal scroll bar does not auto show.
* Tweak - Edited the way that Add Compare Features shows on product edit page - now same width as the page content.
* Tweak - Show Compare Featured fields on products page - added support for theme table css styling.
* Tweak - Adding padding between Product name and the Clear All - Compare button in sidebar widget.
* Tweak - Added yellow Pro update frame and dialogue box so its clear what features are activated on upgrade.
* Other - Create script to facilitate seamless upgrade from Version 1.04 to Major upgrade Version 2.0
* Other - Created and added WooCommerce Compare Products video to Wordpress plugins page


= 1.0.5 - 2012/05/22 =

* Feature: Set Compare Button position above or below and padding from the WooCommerce Add to Cart Button. 
* Fix: This feature is a workaround for site owners who use the WooCommerce Premium Catalog Visibility extension that removes the WooCommerce hook that Compare needs to show the button. Set the Compare button to show below the Add to Cart button in your theme and it will still show when that plugin removes the cart functionality.

= 1.0.4 - 2012/04/17 =

* Fixed: Print this page feature not working on Fly-Out screen
* Fixed: Column alignment problem on Features admin panel on smaller screens.
* Tweak: Re-designed admin panel style for improve UX and in line with the PRO version
* Tweak: Changed blue border in pop-up screen to square corners and gray colour.
* Tweak: Change alignment of Compare button to 'align right' in sidebar widget.
* Tweak: Code re-organized into folders with all files commented on and appropriate names as per WordPress Coding standards.

= 1.0.3 - 2012/04/05 =

* Tweak: Compare Settings page now on 2 tabs - SETTINGS | FEATURES in the same style as WooCommerce setting page for familiarity and greater ease of use.


= 1.0.2 - 2012/04/04 =

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

= 1.0.1 - 2012/03/22 =
* Tweak: Remove validation script never use for this plugin 

= 1.0.0 - 2012/03/15 =
* First working release of the modification

== Upgrade Notice ==

= 1.0.0 - 2012/03/15 =
This first version.
