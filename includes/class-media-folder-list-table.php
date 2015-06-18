<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    DCM
 * @subpackage DCM/includes
 */

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
require_once( ABSPATH . 'wp-admin/includes/class-wp-media-list-table.php' );

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    DCM
 * @subpackage DCM/includes
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class MediaFolders_List_Table extends WP_Media_List_Table{
	var $wp_query;
		
	 function __construct($args = array() ) {
		 parent::__construct( array(
			'singular'=> 'media_folder', //Singular label
			'plural' => 'media_folders', //plural label, also this well be one of the table css class
			'screen' => 'upload',
			'ajax'	=> false //We won't support Ajax for this table
		) );
		
		add_filter('parse_query', array( $this, 'parse_query' ) );
	 }
	 
	 function extra_tablenav($which){
		 // Removes extra table nav
	 }
	 
	 function get_bulk_actions(){
		 // Removes bulk actions
		 return array();
	 }
	 
	 function get_columns() {
		$posts_columns = parent::get_columns();
		unset($posts_columns['author']);
		unset($posts_columns['comments']);
		unset($posts_columns['date']);
		
		return $posts_columns;
	}
	
	function display_tablenav($which){
		
	}
	
	function parse_query( $wp_query ) {
		global $post;
		$wp_query->set( 'post_parent',  $post->ID );	
	}
}
