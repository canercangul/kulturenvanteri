=== User Role Editor Pro ===
Contributors: Vladimir Garagulya (https://www.role-editor.com)
Tags: user, role, editor, security, access, permission, capability
Requires at least: 4.4
Tested up to: 5.3.2
Stable tag: 4.55
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

User Role Editor Pro WordPress plugin makes user roles and capabilities changing easy. Edit/add/delete WordPress user roles and capabilities.

== Description ==

User Role Editor Pro WordPress plugin allows you to change user roles and capabilities easy.
Just turn on check boxes of capabilities you wish to add to the selected role and click "Update" button to save your changes. That's done. 
Add new roles and customize its capabilities according to your needs, from scratch of as a copy of other existing role. 
Unnecessary self-made role can be deleted if there are no users whom such role is assigned.
Role assigned every new created user by default may be changed too.
Capabilities could be assigned on per user basis. Multiple roles could be assigned to user simultaneously.
You can add new capabilities and remove unnecessary capabilities which could be left from uninstalled plugins.
Multi-site support is provided.

== Installation ==

Installation procedure:

1. Deactivate plugin if you have the previous version installed.
2. Extract "user-role-editor-pro.zip" archive content to the "/wp-content/plugins/user-role-editor-pro" directory.
3. Activate "User Role Editor Pro" plugin via 'Plugins' menu in WordPress admin menu. 
4. Go to the "Settings"-"User Role Editor" and adjust plugin options according to your needs. For WordPress multisite URE options page is located under Network Admin Settings menu.
5. Go to the "Users"-"User Role Editor" menu item and change WordPress roles and capabilities according to your needs.

In case you have a free version of User Role Editor installed: 
Pro version includes its own copy of a free version (or the core of a User Role Editor). So you should deactivate free version and can remove it before installing of a Pro version. 
The only thing that you should remember is that both versions (free and Pro) use the same place to store their settings data. 
So if you delete free version via WordPress Plugins Delete link, plugin will delete automatically its settings data. Changes made to the roles will stay unchanged.
You will have to configure lost part of the settings at the User Role Editor Pro Settings page again after that.
Right decision in this case is to delete free version folder (user-role-editor) after deactivation via FTP, not via WordPress.

== Changelog ==

= [4.55] 03.02.2020 =
* Core version: 4.53
* New: custom filter 'ure_hide_fe_menu_if_content_view_prohibited' allows to not hide front-end menu item, if linked page is prohibited for view to current user.
* Update: Other roles access add-on: It's possible to use this add-on against 'administrator' role under WordPress multisite. Return FALSE from 'ure_not_block_other_roles_for_local_admin' filter for this purpose.
* Fix: Other roles access add-on: 
*   - Users with blocked role(s) were shown for "Block not selected" model.
*   - Users quantity at the top roles links/filters were counted wrong way.
* * Core version was updated to 4.53:
* Update: "Add role", "Delete role", "Rename role", "Add capability", "Delete capability" do not reload full page on completion, but use AJAX for data exchange with server and refresh parts of the page via JavaScript.
* Update: Multisite: "Allow non super administrators to create, edit, and delete users" option: priority for 'map_meta_cap' filter priority was raised from 1 to 99, in order make possible to overwrite changes made by other plugins, like WooCommerce.
* Fix: Some English grammar mistakes.

= [4.54.1] 27.12.2019 =
* Core version: 4.52.2
* New: Other roles access add-on: Use custom 'ure_other_roles_access' filter to change restrictions for user dynamically. Filter takes 2 input parameters: 1) $blocked (array) - restrictions for current user; 2) $user (WP_User) - current user.
* Fix: Other roles access add-on: 
* - It was not possible to edit user from the users list, when "Not selected" model is turned ON.
* - There was a bug in processing roles with similar role IDs, like 'customer', 'wholesaler_customer'. When you blocked 'customer' role, script automatically blocked similar role 'wholesaler_customer'.  
* Core version was updated to 4.52.2:
* Fix: Custom capabilities for custom post types was not created by URE automatically since version 4.52.1.
* Fix: 'administrator' role protection did not show to power users roles with 'administrator' word inside, like 'shop_administrator', etc.

= [4.54] 25.11.2019 =
* Core version: 4.52.1
* New: Multisite: "Network Admin->Users->User Role Editor->Network Update" URE Pro uses by default the main blog as a source of add-ons settings to replicate for all network. New custom filter 'ure_get_addons_source_blog' allows to use as a source blog any other existing subsite. Filter accepts single parameter - main blog ID by default. User this filter to return ID of blog/subsite which you wish to use as a source of add-ons settings for all other subsites.
* Fix: PHP Notice: Undefined variable: post_id in /wp-content/plugins/user-role-editor-pro/pro/includes/classes/content-view-restrictions-editor.php on line 150


Full list of changes is available in changelog.txt file.
