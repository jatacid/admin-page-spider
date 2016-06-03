=== Admin Page Spider ===
Contributors: jatacid
Donate link: https://adminpagespider.com/admin-page-spider-pro-pack/
Tags: usability, admin, developer
Requires at least: 4.4.0
Tested up to: 4.5.2
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

View & Edit any page on your entire website from any location!

== Description ==

Navigating through pages in wordpress can be a major pain. If you're in a backend page and you want to get to a contact page it can take several clicks.

Now with Admin Page Spider you can crawl all over your pages from any point and you can access the Edit pages directly. From anywhere.

It adds several quick access link menus to your admin bar. To view any page, or directly edit a page.

See the [screenshots tab](http://wordpress.org/extend/plugins/admin-page-spider/screenshots/) for more details.

**You can save almost 30% of your editing time!**


[**Pro Pack Available**](https://adminpagespider.com/admin-page-spider-pro-pack/)


**Do You Do Any Of These?**

There's a new Pro Pack addon available for Admin Page Spider which extends support to a variety of other page editing interfaces in wordpress.

* You can edit POSTS and blog posts with a quick access menu
* Beaver Builder has direct access to the editing interface for Beaverbuilder
* CSS Hero can open up directly to the page you want to edit
* Microthemer will open up in its special admin window on your exact page

[Check It Out Now!](https://adminpagespider.com/admin-page-spider-pro-pack/)



== Installation ==

You can either install it automatically from the WordPress admin, or do it manually:

Unzip the archive and put the admin-page-spider folder into your plugins folder (/wp-content/plugins/).
Activate the plugin from the Plugins menu.

= Usage =

In your dashboard go to the Settings -> Admin Page Spider.  Set the desired menus to 'Display' and hit save. Now they will display in your admin bar and allow you to jump around between your pages easily.

**Install Beaver Builder For Additional Features**
If you use Beaver Builder there's a similar menu available to instantly jump into the editing interface for Beaver Builder pages.

If you don't know what beaver builder is - check it out [here](https://www.wpbeaverbuilder.com/?fla=215)



== Frequently Asked Questions ==

= Is it free? =

Yes, the base plugin which gives you a wordpress page navigation and edit menu is completely free and hosted on the wordpress plugin directory.

= What's avilable in the Pro Pack? =

Support for more developer friendly and intuitive working experiences. The CSS Editor interface plugins and various page builders as well as Wordpress Posts are supported.

[Read More Here](https://adminpagespider.com/admin-page-spider-pro-pack/)

== Screenshots ==

1. screenshot-1.png It adds navigation menus to your admin bar which display all the pages in your website & let you quickly jump to any page or quickly edit any page.

2. screenshot-2.png
Sits on top of your admin bar giving you an overview of all pages. Even if you have a membership site you can view hidden pages!

3. screenshot-3.png
Options to turn off and turn on.  Simple and turns itself on when activated and deletes its own records from your database when you deactivate.

4. screenshot-4.png
New update with clever interface to allow you to view and edit all from a single place. SUPER fast!

== Changelog ==

= 1.10 =
* Added quick access item to settings for people who don't realise there are settings.
* Added an icon to make it more apparent that the primary menu is clickable.
* Added a hook for additional styles to be added by each individual plugin without adding more bloat to the css.


= 1.09 =
* Made default min width a little larger
* Added a slight transparency so you can see underneath
* Removed String Length code which was causing weird characters
* Issues occuring with browsers and scroll bar hiding the submenu items so have moved all submenus into the main menu heirarchy with padding indentation. Should now work on all browsers.
* Added 'view' icons to simply view the page instead of edit.
* Added 'Title' tags to almost every menu item to provide more explanation.

= 1.08 =
* Critical fix of submenu edit links for wordpress pages taking you to edit for the primary page.

= 1.07 =
* Added hooks for adding support & new features.
* Moved various features around for code sustainability
* Cleaned up Admin Pages & added checks for administrator rights so non users don't see a weird thing in their menubar.
* Added link to settings in the plugin page
* Added activation/Deactivation & uninstall cleanup

= 1.06 =
* Fixed syntax error with get_option array variable

= 1.05 =
* Added CSS to handle really long lists of pages
* Added filter to remove now redundant edit links from menu
* Merged Pull request for handling urls which already have a parameter added (credit: badabingbreda)

= 1.04 =
* Added basic localisation (thanks badabingbreda) , updated readme a bunch of times and made code less conflict-risky with bbPress

= 1.00 =
* Initial Launch

== Upgrade Notice ==

= 1.10 =
New This Version: Combined Edit Link and menu - so now you can click on the menu to edit current page.