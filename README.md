# WDS Shortcodes #
**Contributors:**      [WebDevStudios](https://github.com/WebDevStudios), [jtsternberg](https://github.com/jtsternberg), [JayWood](https://github.com/JayWood)   
**Donate link:**       http://webdevstudios.com  
**Tags:**              shortcode button, shortcodes, cmb2, utility   
**Requires at least:** 4.3  
**Tested up to:**      4.3  
**Stable tag:**        1.0.6  
**License:**           GPLv2  
**License URI:**       http://www.gnu.org/licenses/gpl-2.0.html  

## Description ##

WDS-Shortcodes gives developers the ability to easily register shortcodes with a corresponding button, so never again will your client ask, _What's that shortcode again?_ Not only can you easily handle the button and shortcode registration, this also supports self-closing and wrapping shortcodes with a simple config flag.

**Please note:** you will need to run `composer install` in order to fetch the dependenceis for this plugin/library, **or** you can [download the zip here](https://github.com/WebDevStudios/WDS-Shortcodes/blob/master/wds-shortcodes.zip?raw=true).
 
Additionally, there is also built-in [CMB2](http://wordpress.org/plugins/cmb2/) support so you can use all your favorite fields. 

For more info, [check out the wiki](https://github.com/WebDevStudios/WDS-Shortcodes/wiki).

To see a demo plugin, check out "[Cool Shortcode](https://github.com/jtsternberg/Cool-Shortcode)".

## Installation ##

### Manual Installation ###

1. Upload the entire `/wds-shortcodes` directory to the `/wp-content/plugins/` directory.
2. Activate WDS Shortcodes through the 'Plugins' menu in WordPress.

## Frequently Asked Questions ##

* None as of yet

## Screenshots ##
![](https://raw.githubusercontent.com/WebDevStudios/WDS-Shortcodes/master/screenshot1.png)

## Changelog ##

### 1.0.6 ###
* Update shortcode-button dependency. [See changelog](https://github.com/jtsternberg/Shortcode_Button#changelog).

### 1.0.5 ###
* Update shortcode-button dependency. [See changelog](https://github.com/jtsternberg/Shortcode_Button#changelog).

### 1.0.4 ###
* Update shortcode-button dependency to fix modal displaying before CSS loads.

### 1.0.3 ###
* `WDS_Shortcode_Instances::get()` now accepts a secondary argument, `$index`, for selecing the exact object instance under the shortcode namespace.

### 1.0.2 ###
* Add new method, `WDS_Shortcode::json_decode_att()`, for getting decoded json attribute values. Handles converting the pseudo-json format used when storing array field datat.

### 1.0.1 ###
* Add new method, `WDS_Shortcode::bool_att()`, for getting boolean attribute values. Handles converting "false" and "0" strings to false.
* Undefined notice fix: Check if attribute value is a string before checking if it is json.
* Fix issue where faux json_encoded arrays were not being properly translated back to a php array.

### 1.0.0 ###
* Update to be used as a library primarily (using [wp-lib-loader](https://github.com/jtsternberg/wp-lib-loader)). Will break back-compat for plugins extending the `WDS_Shortcode_Admin` class before the `'init'` hook.

### 0.1.3 ###
* Update composer lock file and zip file after updating Shortcode_Button dependency.

### 0.1.2 ###
* New method, `WDS_Shortcode::maybe_json()` which automatically converts attributes from the modifed JSON string [created by Shortcode_Button](https://github.com/jtsternberg/Shortcode_Button/commit/c186e98b2f94a1e565d85593033d9b2a499d9e8e#diff-6846d1b0c8144484af006af499cd053dR397) into a normal PHP array.

### 0.1.1 ###
* Fix issues with ajax hooks not working (as they get hooked too late)

### 0.1.0 ###
* First release
