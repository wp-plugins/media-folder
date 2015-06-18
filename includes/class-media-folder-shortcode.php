<?php

/**
 * Shortcode to render the list of attachements attached to a post
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    Media_Folder
 * @subpackage Media_Folder/includes
 */

/**
 * Shortcode to render the list of attachements attached to a post
 *
 * @since      1.0.0
 * @package    Media_Folder
 * @subpackage Media_Folder/includes
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class Media_Folder_Shortcode {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function shortcode( $atts ) {
		
		global $post;
		
		$defaults = array('id' => false, 'slug' => '');
		
        extract( shortcode_atts( $defaults, $atts ) );
		
		
		
        if( $slug != "" || is_numeric($id) ){

            
			$attachments = get_posts( array(
				'post_type' => 'attachment',
				'posts_per_page' => -1,
				'post_parent' => $id, //$post->ID,
				 //'exclude'     => get_post_thumbnail_id($post->ID)
			) );
		
		
			if ( $attachments ) {
				
				echo "<ul>";
				foreach ( $attachments as $attachment ) {?>
					
					<li><a href="<?php echo wp_get_attachment_url($attachment->ID) 
					  ?>" title="<?php echo $attachment->post_title ?>"><?php  echo $attachment->post_title ?></a></li><?php
				}
				echo "</ul>";
			
			}
        }
		
        if( WP_DEBUG )
		{
            return 	Media_Folder_Shortcode::make_shortcode($atts);
        }
		
        return '';
    }
	
	
	private static function make_shortcode($atts){
        
        $code = '[media_folder ';
        
        foreach( $atts as $key => $val )
		{
            $code.= $key.'="'.$val.'" ';	
        }
        
        return $code.']';
    }

}