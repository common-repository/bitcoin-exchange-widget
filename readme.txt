=== Bitcoin Exchange Widget ===
Contributors: bradmkjr
Donate link: http://iphods.com/
Tags: btc, bitcoin, exchange, widget
Requires at least: 3.6.1
Tested up to: 3.7.1
Stable tag: 1.15
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Show realtime BTC exchange rates in sidebar widgets.

== Description ==

This is a basic plugin to show BTC exchange rates from blockchain.info public API, as a sidebar widget on your wordpress site. No configuration options are available at this time, but maybe added in future, including which exchange rates to show and other minor changes. Plugin uses native WP caching, to minimize server load improve user experience.

To donate to support plugin, please send donations to this wallet: 195jHGYxZyYxxHAYgLVGY2H9DEoGMHGQTx to support futher development efforts 

== Installation ==

This plugin is a standard widget. 

1. Install the plugin from the Wordpress Repository or by uploading the zip.
2. Drag the widget to the desired sidebar on the appearance panel of the wordpress dashboard.
3. Enter in the desired title, leave blank for no title.
4. Select which currencies will be displayed in widget on front of site.
5. Save, and view it on the frontend of site.
6. Enjoy.


== Frequently Asked Questions ==

= Where does the BTC Values come from? =

They are using blockchain.info ticker api, with a 15 minute delay. To view json file, you can visit: http://blockchain.info/ticker or to read more about the api here: http://blockchain.info/api/exchange_rates_api

== Screenshots ==

1. This is the widget inside of the dashboard
2. This is the widget on the frontpage of the website

== Changelog ==

= 1.0 =
* Setup Widget Class, to have basic WP Widget.
* Setup API Calls, to get BTC Values.

= 1.14 =
* Added in WP standard caching, to minimize load on API.

= 1.15 =
* Added donation information into readme.txt and plugin description
* Added checkboxes to choose which Currencies will be displayed in Widget+

== Upgrade Notice ==

= 1.14 =
No previous version was released, no upgrade actions required.

= 1.15 =
Addition of instance storage of display data, should be 100% painless upgrade.