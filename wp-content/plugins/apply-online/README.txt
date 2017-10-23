=== Apply Online ===
Contributors: farhan.noor
Donate link: http://wpreloaded.com
Tags: ads, job board, career page, form, job manager, application, cv, courses, class, admission, job listing, career plugin,
Requires at least: 4.5
Tested up to: 4.8
Stable tag: 1.8.3
License: GPLv2 or later

Powerful & intuitive plugin to post ads and start receiving applications online.

== Description ==
= Are you looking for a page on your website to start receiving applications? =
Focused on stability and simplicity, with this plugin you can create a job board, advertisement board or open online registration of courses & classes and start receiving applications right from your website.

= Powerful Features =
* Beautifully integrates into your existing website without worrying for design.
* Form builder with all HTML form fields to create a stunning application form. 
* Standard Wordpress interface to add, categorize and manage ads.
* List all ads or selected ads on any web page of your website.
* Alternatively add default ads link *yourwebsite.com/ads* in your website navigation.
* Categories based URLs for different type of ads i.e. yourwebsite.com/careers , yourwebsite.com/admissions
* Show description, features and application form on ad detail page.
* Packed with wordpress user role *AOL Manager* for people who handle applications.
* After login, each user can write his own comments for the received applications to evaluate the candidate.
* Get email notifications when an application is received.
* Multiple file attachment fields.
* Hooks and functions for advancements and customization.
* Clear and well formed documentation for developers and non-developers.
* [Add-ons](http://wpreloaded.com/shop "wpreloaded.com") to extend the plugin to next level. 

For demo, please check [AOL Demo](http://wpreloaded.com/plugins/apply-online "Your favorite plugin"). Your suggestions and error reports can really help to improve this plugin.

= Simplest Implementation =
1. After activation, locate the menu **Apply Online** in admin panel and create few ads.
1. Now open link on your website with **ads** slug i.e. yourdomain.com/**ads**.

= Or =
1. After installations, locate the menu **Apply Online** in admin panel and create few ads there.
1. From Wordpress admin panel, add a page i. e. **Careers** or **New Admissions**
1. Place **[aol]** shortcode into this page and let the magic begin.

* Created with love by [Spider Teams](http://spiderteams.com "We create the web!")

== Installation ==
1. Download plugin.
1. Upload downloaded zip file to the /wp-content/plugins/ directory of your web server.
1. Activate plugin through the 'Plugins' menu in WordPress dashboard.
1. Locate the menu **Apply Online** in admin panel and create few ads here.
1. Now open link of your website similar to **yourdomain.com/ads**.

= Method 2 =
1. After installations, locate the menu **Apply Online** in admin panel and create few ads there.
1. From Wordpress admin panel, add a page i. e. **Careers** or **New Admissions**
1. Place **[aol]** shortcode into this page and let the magic begin.

== Screenshots ==

1. Write shortcode in a page editor. 
2. Ads listing.
3. Ad edit/add page. 
4. All received applications.
5. A received application detailed page.
6. Plugin's Settings page.
7. Front-end detailed single page of an ad.
8. Front-end view of Ads listing on "Careers" page.

== Frequently Asked Questions ==

= How to create an ad? =
In your WordPress admin panel, go to "Apply Online" menu and add a new ad listing.

= How to show ad listings on the front-end? =
Add [aol] shortcode in an existing page or add a new page and write shortcode anywhere in the page editor. Now click on VIEW to see all of your ads on front-end.

= Can I show few ads on front-end? =
Yes, you can show any number of ads on your website by using shortcode with "ads" attribute. Ad ids must be separated with commas i.e. [aol ads="1,2,3"].

= Can I show ads from particular category only? =
Yes, you can show ads from any category / categories using "categories" attribute. Categories' ids must be separated with commas i.e. [aol categories="1,2,3"].

= Can I show ads without excerpt/summary? =
Yes, use shortcode with "excerpt" attribute i.e. [aol excerpt="no"]

= What attributes can i use in the shortcode? =
Default shortcode with all attributes is [aol categories="1,2,3" ads="1,2,3" excerpt="no"]. Use only required attributes.

= How can i get the id of a category or ad? =
In admin panel, move your mouse pointer on an item in categories or ads table. Now you can view item ID in the info bar of the browser.

= Does this plugin have hooks and functions for customization of plugin behavior? =
Yes, please check plugin reference at [WP Reloaded](http://wpreloaded.com/plugins/apply-online/reference)

== Changelog ==

= 1.8.3 =
* Fixed: jquery-ui-sortable library attachment.

= 1.8.2 =
* Fixed: Application form fields sorting.

= 1.8.1 =
* Fixed: Apply Online Metabox hook.

= 1.8 =
* New: Thumbnail support for ads.
* New: More hooks to extend the plugin for [add-ons](http://wpreloaded.com/shop)
* Fixed: Compulsory fields default notice.
* Fixed: Language issues.

= 1.7.2 =
* Fixed: Form submitted but unexpected form submission failed message.
* Fixed: Required form field option for newly generated field in ad editor.

= 1.7.1 =
* Fixed: Required form fields notice.
* Fixed: Date format for date form fields.

= 1.7 =
* New: Application Print facility. 
* New: [aol_ad] shortcode to show single ad anywhere in the website.
* New: [aol_form] shortcode to show form anywhere in the website.
* New: Add-on support.
* Fixed: Warnings on custom template page single-aol_ad.php
* Fixed: Translation issues.

= 1.6.3 =
* Fixed: Underscores between words of form fields names.
* New: Application removal option.

= 1.6.2 =
* Fixed: Salient Features heading when no feature is provided on single ad page.

= 1.6.1 =
* Fixed: Hidden items of AOL Menu.

= 1.6 =
* New: AOL Manager user role.
* New: Comments system for hiring staff to discuss an application.
* New: Email validation for form input field.
* New: More hooks and functions to extend the plugin.
* Fixed: Improved search of applications in admin panel.


= 1.5.1 =
* Fixed: Removed odd alert at the time of application submission.

= 1.5 =
* Fixed: Default file field issue in settings. 
* New: aol_content filter hook introduced to control the output of [aol] shortcode.
* New: aol_features function added to show application featres in custom template.
* New: aol_application function added to show application form in custom template.

= 1.4 =
* Fixed: Email issue. 
* New: Custom file upload field in ad editor introduced.
* Overall enhancement.

= 1.3 =
* Fixed: Application Form Fields delete issue. 
* Fixed: Delete button disappears in application form fields in post editor.
* New: Templates/Default Fields introduced.


= 1.2.1 =
* Fixed: Link to new application in email alert.

= 1.2 =
* **Plugin Settings** introduced.
* Add emails to get application alerts.
* Overall enhancement. 

= 1.1 =
* **Categories** introduced.
* **Shortcode** updated.
* Bug fixed for CV / resume attachment in application form.

= 1.0 =
* Plugin launched.

== Upgrade Notice ==

= 1.8.3 =
Bug Fixes and patches. Upgrade recommended.

= 1.8.1 =
Bug Fixes and patches. Upgrade recommended.

= 1.8 =
New features, Bug Fixes and patches. Upgrade recommended.

= 1.6.2 =
Bug Fixes and patches. Upgrade recommended.

= 1.6.1 =
Bug Fixes and patches. Upgrade immediately.

= 1.6 =
Bug Fixes, patches and new features. Upgrade is recommended.

= 1.5.1 =
Bug Fixes, patches and new features. Upgrade is recommended.

= 1.4 =
Bug Fixes, patches and new features. Upgrade immediately.

= 1.3 =
Fixes, patches and new features. Upgrade immediately.

= 1.2.1 =
Link to new application in email alert fixed. Upgrade is recommended.

= 1.2 =
New hot features added. Upgrade immediately.

= 1.1 =
This version fixes bugs in shortcode, and file attachment with application form. Upgrade immediately.

= 1.0 =
Plugin launched.