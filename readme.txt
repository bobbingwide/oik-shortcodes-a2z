=== oik-shortcodes-a2z ===
Contributors: bobbingwide
Donate link: https://www.oik-plugins.com/oik/oik-donate/
Tags: shortcodes, smart, lazy
Requires at least: 5.0.3
Tested up to: 6.4-beta3
Stable tag: 0.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

== Description ==
Letter taxonomies for oik-shortcodes.

Automatic setting of the API letter taxonomy terms for post types from the oik shortcodes and API server.

Depends upon: oik-a2z, oik-shortcodes, oik-fields, oik

Use in your theme, in conjunction with the [bw_terms] shortcode or 'oik_a2z_display' action
to display letter taxonomies as required. 


== Installation ==
1. Upload the contents of the oik-shortcodes-a2z plugin to the `/wp-content/plugins/oik-shortcodes-a2z' directory
1. Activate the oik-shortcodes-a2z plugin through the 'Plugins' menu in WordPress

For a site that is already populated with content

1. Visit oik options > Letter taxonomies and choose 'Set letters' set the letter taxonomy terms for all posts in the Defined taxonomies. 

== Frequently Asked Questions ==

== Screenshots ==
1. oik-shortcodes-a2z in action

== Upgrade Notice ==
= 0.2.1 =
Upgrade for PHP 8.1 and PHP 8.2 support

= 0.2.0 =
Upgrade for a new Block letters taxonomy for Blocks and Block examples

= 0.1.0 = 
Updates for new CPTs for WordPress 5.0 - block and block_example. Change letter taxonomy for oik_shortcodes and shortcode_example.
 
= 0.0.1 =
Associates Letters and API Letters taxonomies to appropriate post types 

= 0.0.0 =
New plugin, available from oik-plugins and GitHub.

== Changelog == 
= 0.2.1 =
* Changed: Support PHP 8.1 and PHP 8.2,[github bobbingwide oik-shortcodes-a2z issues 2]
* Tested: With WordPress 6.4-beta3 and WordPress Multisite
* Tested: With PHP 8.0, PHP 8.1 and PHP 8.2
* Tested: With PHPUnit 9.6

= 0.2.0 = 
* Changed: Add block_letters taxonomy for blocks and block examples, [github bobbingwide oik-shortcodes-a2z issues 1]

= 0.1.0 = 
* Changed: Added new CPTs, block and block_example, using letter taxonomy [github bobbingwide oik-shortcodes-a2z issues 1]
* Changed: oik_shortcodes and shortcode_example now also using letter taxonomy [github bobbingwide oik-shortcodes-a2z issues 1]

= 0.0.1 = 
* Added: More associations [github bobbingwide oik-shortcodes-a2z issues 1]

= 0.0.0 =
* Added: New plugin for oik-plugins, WP-a2z and bobbingwide

== Further reading ==
If you want to read more about the oik plugins then please visit the
[oik plugin](https://www.oik-plugins.com/oik) 
**"the oik plugin - for often included key-information"**

