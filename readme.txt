=== Slidebars ===
Contributors: webkinder
Tags: sidebar, slidebar, dynamic, slide-in, slide, panel, slide-panel, bar, widget, widget-area, widgetarea, widgets, custom, menu, menus, slidebars, sliding widget, sliding widgets, sliding Panel, off-canvas, reveal, sliding content, content, visibility, reveal content, slide content, slide widgets
Requires at least: 4.0
Requires PHP: 5.3
Tested up to: 4.9
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that allows you to create and customize slide-in sidebars which you can populate with widgets.

== Description ==

A plugin that allows you to create and customize slide-in sidebars which you can populate with widgets. These slide-in panels can be used as
custom menus or replace popups for a better user experience.

We would love to hear your feedback in a [review](https://wordpress.org/support/plugin/slidebars/reviews/). It helps us improve and expand the plugin according to your needs.

If you have any questions or feature requests, feel free to contact us via support@webkinder.ch.

== Installation ==

1. Upload the plugin files to the '/wp-content/plugins/slidebars' directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress.
1. Use the 'Settings->Slidebars' screen to configure your Slidebar.
1. Add content to your Slidebar like any other sidebar at 'Design->Widgets'.

== Frequently Asked Questions ==

= Is there a way to edit settings in my code? =

Yes, there is a developer mode.

To enable it use `add_filter('wksl_slidebars_dev_mode', '__return_true')` in your code. This will hide the plugins settings page. Then Slidebars will always use the default settings unless you modify them by using the filter `wksl_slidebars_settings`:

`
<?php

// Specifies icon color and uses default for everything else
function my_filter_function( $settings ) {
	$settings['icon_color'] = '#5d4a72';
	return $settings;
}

add_filter( 'wksl_slidebars_settings', 'my_filter_function' );
`

For a full list of plugin options and their default values, consult the `get_defaults()` method in [the settings class](https://plugins.svn.wordpress.org/slidebars/trunk/admin/Settings.php).

= Can I remove the icon completely? =

Yes, if you are using version 0.5.0 or higher there should be an option on the setting page ("Settings->Slidebars").
Please remember that you need to add the button shortcode somewhere on your page or the user will be unable the open the Slidebar.

= How can I add my own button to toggle the Slidebar? =

Just use the shortcode `[wksl_slidebar_button text="Some Text"]`.

= Can I use a self-made/custom icon? =

No, we do not officially support custom icons. We support FontAwesome and DashIcons, so you should have a big selection to choose from.
If you really need a custom icon you might be able to change it by using CSS rules in your theme.

= Can I add some custom styles to my Slidebar components? =

You can always change the style by using your own custom CSS rules in your theme.
The plugin itself does not allow custom CSS anymore.

= Where is the custom CSS field? =

If you used the plugin before version 1.0.0 you had the option to set custom CSS rules.
We decided remove custom CSS with version 1.0.0. Before updating to version 1.0.0 you should see a warning.
If you still need to add custom styles you should move them to your themes custom CSS.

== Screenshots ==

1. Default Slidebar in action
2. Customize your Slidebar easily with extensive style and functionality settings.

== Changelog ==

= 1.0.1 [12 Dec 2017] =

* (Documentation) Added FAQ for plugin website
* (Documentation) Removed commit hashes from changelog.
* (Documentation) Remove the settings table and reference source code instead. Fix php code snippet.

= 1.0.0 [28 Nov 2017] =

* (Breaking) Removed custom CSS option

* (Feature) Introduced developer mode

* (Bugfix) Fixed checkbox bug and added tests for it

* (Testing) Use lower percentage bounds in coverage report
* (Testing) Test settings register function to check if all fields are present
* (Testing) Use global mock to fully test shortcode class
* (Testing) Added test case for settings sanitization
* (Testing) Added tests for button shortcode and improved code stability.
* (Testing) Generate coverage report on successful test runs
* (Testing) CircleCI Testing setup with WP-CLI

* (Documentation) Extend documentation for developer mode and add release dates
* (Documentation) tested up to WordPress 4.9

* (Internal) Use a factory pattern instead of singleton for main class
* (Internal) First unit tests
* (Internal) Restore original plugin filename for backwards compatibility
* (Internal) Remove unneeded files from archives in releases
* (Internal) OOP refactor
* (Internal) Simplified shortcodes class into one file

= 0.5.0 [14 Nov 2017] =

* (Feature) New option to deactivate Slidebar icon completely.
* (Backend) Hide icon settings when icon disabled
* (Documentation) Add minimum PHP requirement of 5.3
* (Internal) Changed textdomain to be plugin slug.
* (Internal) Small code quality improvements
* (Compatibility) Added warning message for custom CSS

= 0.4.3 [14 Sep 2017] =
* Increased CSS compatibility with old Android browsers via the `-webkit-`-Prefix.

= 0.4.2 [4 Jan 2017] =
* Fixed color bug from 0.4.1

= 0.4.1 [4 Jan 2017] =
* Added shortcode for trigger button
* Supporting php versions all the way back to 5.3
* Included tooltips on the settings page

= 0.4 [7 Nov 2016] =
* Added content overlay option
* Updated font awesome dependency to 4.7

= 0.3 [5 Nov 2016] =
* Added preview mode option

= 0.2 [24 Oct 2016] =
* initial release on wordpress.org
