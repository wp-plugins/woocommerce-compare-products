=== Woocommerce Compare Products ===
Contributors: a3rev, A3 Revolution Software Development team
Tags: WooCommerce, WooCommerce Plugins, WooCommerce compare products, compare products plugin, compare products
Requires at least: 2.92
Tested up to: 3.4.1
Stable tag: 2.0

Add a Compare Products Feature to all of your products on you WooCommerce site today with the WooCommerce Compare Products plugin..

== Description ==

WooCommerce Compare Products instantly adds the <strong>cutting edge Compare products feature</strong> to your WooCommerce store in just minutes.

[youtube http://www.youtube.com/watch?v=g8__ZFxKSRA] 
 
= Key Features =

* Professional front end compare products presentation, buttons, links, sidebar widget and compare pop-up
* Works with any Theme that has WooCommerce plugin installed and activated.
* Takes just minutes to set up on your site.
* Product variants auto created as Compare features and added to the master category.
* Add unlimited custom features to compare.

<strong>Online shoppers love the compare products feature</strong> and giving customers more of what they love leads to <strong>more sales.</strong>. Boost your sales today by installing WooCommerce Compare Products on your WooCommerce store.

= Premium Upgrade =

When you install WooCommerce Compare Products you will see all the added functionality that the Premium Version offers. The plugin is designed so that the upgrade is completely seamless. Nothing changes except all the features of Compare Products you see on the lite version are activated. This means you can activate, set up and use the free version completely risk free.  

PRO Version upgrade features:

* Compare Categories - is activated - Categories are important to delivering your customers easy to read compare features in the pop-up window.
* Create unlimited number of custom Compare Categories allows you to customize the compare results to meet your exact requirements. 
* Compare Express Products Manager  - is activated - makes setting up and managing the Compare feature across you entire catalogue at least 50 times faster. 
 
TRY WooCommerce Compare Products FREE version today. <strong>Your customers will love you for it.</strong>

[Pro Version Upgrade](http://a3rev.com/products-page/woocommerce/woocommerce-compare-products/) |
[Read Documentation](http://docs.a3rev.com/user-guides/woocommerce/compare-products/) |
[Support](http://a3rev.com/products-page/woocommerce/woocommerce-compare-products/#help)

= Localization =
* English (default) - always include.
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

3. Follow the detailed set up instructions on Compare setting dashboard.

* Style your Compare Products Fly-Out screen - upload header image and set screen dimensions.
* Select to show Compare Feature on Product Pages as Button or Hyperlink Text.
* Set text to show in Button or Link.
* Set Compare Products Tab to show in WooCommerce Product Page Navigation Tabs.
* Save Settings to save your work. You are now ready to add the Compare features data for each product.

4. Click the FEATURES tab 

5. Click the dropdown arrow at the end of the Master Cateory tab. You'll see that all of your sites Parent variations have been auto created as Compare Features.

6. Edit each Master category comapre feature to add the required feature fields.

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
