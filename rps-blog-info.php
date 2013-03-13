<?php
/*
Plugin Name: RPS Blog Info
Plugin URI: http://redpixel.com/
Description: Adds menus to the WordPress Toolbar to display blog, page, post and attachment IDs along with other related information.
Version: 1.0.3
Author: Red Pixel Studios
Author URI: http://redpixel.com/
License: GPL3
*/

/* 	Copyright © 2013  Red Pixel Studios  (email : support@redpixel.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * Adds menus to the WordPress Toolbar to display blog, page, post and attachment IDs along with other related information.
 *
 * @package rps-blog-info
 * @author Red Pixel Studios
 * @version 1.0.3
 */

/**
 * @todo Add ability to navigate among parent, children and sibling posts.
 */

if ( ! class_exists( 'RPS_Blog_Info', false ) ) :

class RPS_Blog_Info {

	public function __construct() {
		add_action( 'admin_bar_menu', array( &$this, 'rps_blog_info' ), 999 );
		add_filter( 'attachment_fields_to_edit', array( &$this, 'f_media_cache_post_object' ), 10, 2 );
	}

	public function rps_blog_info() {
		global $wp_admin_bar, $post, $pagenow;
		if ( ! isset( $post ) || empty( $post ) )
			$post = $this->media_post_object;
		
		if ( !is_admin_bar_showing() && ( !current_user_can( 'edit_pages' ) || !current_user_can( 'edit_posts' ) )  )
			return;
		
		if ( is_multisite() ) :
			$blog_id = get_current_blog_id();
			$blog_details = get_blog_details( $blog_id );
			
			$blog_domain = $blog_details->domain;
			$blog_updated = date( "F j, Y, g:i a", strtotime( $blog_details->last_updated ) );
			$blog_public = ( $blog_details->public == 0 ) ? 'No Index' : 'Index';
			
			$wp_admin_bar->add_node( array(
				'id' => 'rps-blog-info',
				'title' => 'Blog ' . $blog_id . ' ',
				'meta' => array( 'tabindex' => 0 )
			) );
			
			$wp_admin_bar->add_group( array(
				'id' => 'rps-blog-group-1',
				'parent' => 'rps-blog-info',
			) );
		
			$wp_admin_bar->add_node( array(
				'id' => 'rps-blog-group-1-updated',
				'parent' => 'rps-blog-group-1',
				'title' => 'Updated: ' . $blog_updated
			) );
		
			$wp_admin_bar->add_node( array(
				'id' => 'rps-blog-info-domain',
				'parent' => 'rps-blog-info',
				'title' => 'Domain: ' . $blog_domain
			) );
		
			$wp_admin_bar->add_node( array(
				'id' => 'rps-blog-info-search-engines',
				'parent' => 'rps-blog-info',
				'title' => 'Search Engines: ' . $blog_public
			) );
		endif;
		
		if ( is_singular() || ( is_admin() && ( isset( $pagenow ) && $pagenow == 'post.php' || isset( $pagenow ) && $pagenow == 'media.php' ) ) ) :
			$post_type_obj = get_post_type_object( $post->post_type );
			$post_type = $post_type_obj->labels->singular_name;
			$post_modified = date( "F j, Y, g:i a", strtotime( $post->post_modified ) );
			$post_created = date( "F j, Y, g:i a", strtotime( $post->post_date ) );
			$post_name = $post->post_name;
			$post_author = get_the_author_meta( 'display_name', $post->post_author );
			$post_status = ucfirst( $post->post_status );
			if ( $post_status == 'Publish' ) $post_status = 'Published';
			$post_password = ( $post->post_password != '' ) ? 'Yes' : 'No';
			$comment_status = ucfirst( $post->comment_status );
			$comment_count = $post->comment_count;
			$ping_status = ucfirst( $post->ping_status );
	
			$wp_admin_bar->add_node( array(
				'id' => 'rps-post-info',
				'title' => $post_type . ' ' . $post->ID,
				'meta' => array( 'tabindex' => 0 )
			) );
			
			$wp_admin_bar->add_group( array(
				'id' => 'rps-post-group-1',
				'parent' => 'rps-post-info',
			) );
			
			$wp_admin_bar->add_node( array(
				'id' => 'rps-post-group-1-updated',
				'parent' => 'rps-post-group-1',
				'title' => 'Updated: ' . $post_modified
			) );
			
			$wp_admin_bar->add_node( array(
				'id' => 'rps-post-info-slug',
				'parent' => 'rps-post-info',
				'title' => 'Slug: ' . $post_name
			) );

			$wp_admin_bar->add_node( array(
				'id' => 'rps-post-info-author',
				'parent' => 'rps-post-info',
				'title' => 'Author: ' . $post_author
			) );

			if ( $post->post_type != 'attachment' ) :
				$wp_admin_bar->add_group( array(
					'id' => 'rps-post-group-2',
					'parent' => 'rps-post-info',
				) );
				
				$wp_admin_bar->add_node( array(
					'id' => 'rps-post-group-2-status',
					'parent' => 'rps-post-group-2',
					'title' => 'Status: ' . $post_status
				) );
	
				$wp_admin_bar->add_node( array(
					'id' => 'rps-post-group-2-password',
					'parent' => 'rps-post-group-2',
					'title' => 'Password: ' . $post_password
				) );
	
				$wp_admin_bar->add_node( array(
					'id' => 'rps-post-group-2-comments',
					'parent' => 'rps-post-group-2',
					'title' => 'Comments: ' . $comment_status . ' (' . $comment_count . ')'
				) );
	
				$wp_admin_bar->add_node( array(
					'id' => 'rps-post-group-2-pings',
					'parent' => 'rps-post-group-2',
					'title' => 'Pings: ' . $ping_status
				) );
			endif;
			
		endif;
		
	}
	
	// method to grab the post object on the media.php page and cache it.
	public function f_media_cache_post_object( $fields, $post ) {
		global $pagenow;
		if ( is_admin() && isset( $pagenow ) && $pagenow == 'media.php' ) {
			$this->media_post_object = (object) $post;
		}
		
		return $fields;
	}
	
	// object to cache post information on the edit media page.
	private $media_post_object = null;
}

if ( ! isset( $rps_blog_info ) ) $rps_blog_info = new RPS_Blog_Info;

endif;

?>