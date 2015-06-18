<?php

/**
 * Defines the folder custom post type
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    Media_Folder
 * @subpackage Media_Folder/includes
 */

/**
 * Defines the folder custom post type
 *
 * This type is used as a parent folder to group multiple 
 * media files (attachements). You can the use it to list
 * the attachements that have the folder as a common parent
 * post and list the content anywhere on the site for reuse 
 * and quick maintenance. You can also use the folder to make
 * manageable sliders, carousels, banner rotators and download
 * files lists.
 *
 * @since      1.0.0
 * @package    Media_Folder
 * @subpackage Media_Folder/includes
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class Media_Folder_Type {
	
	/*
	 * Register a content_holder post type
	 *
	 * @since    1.0.0
	 */
	public static function register() {
		
		$labels = array(
            'name'                => _x( 'Media Folders', 'media-folder' ),
            'singular_name'       => _x( 'Media Folder', 'media-folder' ),
            'add_new'             => _x( 'Add Folder', 'media-folder' ),
            'add_new_item'        => _x( 'Add Folder', 'media-folder' ),
            'edit_item'           => _x( 'Edit Folder', 'media-folder' ),
            'new_item'            => _x( 'New Folder', 'media-folder' ),
            'view_item'           => _x( 'View Folder', 'media-folder' ),
            'search_items'        => _x( 'Search', 'media-folder' ),
            'not_found'           => _x( 'No folder found', 'media-folder' ),
            'not_found_in_trash'  => _x( 'No folder found in Trash', 'media-folder' ),
            'parent_item_colon'   => '',
            'menu_name'           => _x( 'Media Folders', 'media-folder' ),
            //'all_items'         => __( 'Media Folders', 'media-folder' ),
            //'update_item'       => __( 'Update Folder', 'media-folder' ), 
        );
        
        $args = array(
            'labels'              => $labels,
          //'capabilities'        => $capabilities,
            'capability_type'     => 'post',
            'menu_icon'           => 'dashicons-category',
            'hierarchical'        => true,
            'supports'            => array('title','thumbnail'),
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => false,
            'show_in_admin_bar'   => false,
            'menu_position'       => 50,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => true,
            'publicly_queryable'  => false,
            'capability_type'     => 'post',
            'description'         => 
            
            _x('Group of attachements as Media Folders', 'media-folder' ),
            
            'taxonomies'          => array( 'category' ),
          //'register_meta_box_cb'=>'media-folder_meta_box_cb',
        );
       
        register_post_type( 'folder', $args );
	}

}
