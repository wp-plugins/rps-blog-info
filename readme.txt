=== RPS Blog Info ===
Contributors: redpixelstudios
Donate link: http://redpixel.com/
Tags: toolbar, blog id, post id, page id, attachment id, blog information, post information, status, date modified, date created
Requires at least: 3.3
Tested up to: 3.4.1
Stable tag: 1.0.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Adds menus to the WordPress Toolbar to display blog, page, post and attachment IDs along with other related information.

== Description ==

The RPS Blog Info plugin uncovers previously obscured but valuable information about blogs, posts, pages and attachments, and places it in the WordPress Toolbar for convenience. The Toolbar displays the blog ID (for multisite configurations) and post ID for pages, posts and attachments; hovering over those items reveals menus with the following information:

= For blogs: =
* Updated: Date and Time
* Domain
* Search Engines: Index/No Index

= For posts/pages: =
* Updated: Date and Time
* Status: Published/Pending/Draft
* Password: Yes/No
* Comments: Closed/Open; and Count
* Pings: Open/Closed
* Slug
* Author

= For attachments: =
* Updated: Date and Time
* Slug
* Author

RPS Blog Info menus are available to users that have permission to edit pages or posts.

== Installation ==

1. Upload the `rps-blog-info` directory and its containing files to the `/wp-content/plugins/` directory.
1. Activate the plugin through the "Plugins" menu in WordPress.

== Screenshots ==

1. The blog and post info menus as they appear in the toolbar in a multisite configuration.
2. The blog info menu extended.
3. The post info menu extended.
4. The menus appear within the admin screens as well.

== Changelog ==

= 1.0.2 =
* Now getting post type names as defined within the post type object.

= 1.0.1 =
* Replaced underscore with space in post type names and transformed to uppercase.

= 1.0 =
* First official release version.

== Upgrade Notice ==

= 1.0.2 =
* Revision to adjustment of presentation of custom post type names in menu to use custom post label as set by author.

= 1.0.1 =
* Minor adjustment to presentation of custom post type names in menu.