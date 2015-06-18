<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    Media_Folder
 * @subpackage Media_Folder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Media_Folder
 * @subpackage Media_Folder/admin
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class Media_Folder_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Media_Folder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Media_Folder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/media-folder-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Media_Folder_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Media_Folder_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		 
		if( $this->is_folder_screen() )
		{
			wp_enqueue_script('plupload-handlers');
			wp_enqueue_script('wp-ajax-response' );
			wp_enqueue_script('jquery-ui-draggable' );
			wp_enqueue_script('media');
		}
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/media-folder-admin.js', array( 'jquery' ), $this->version, false );
		

	}
	
	private function is_folder_screen(){
		
		$screen = get_current_screen();
		
		if( $screen->post_type == 'folder' && $screen->action != 'add' )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	/**
	 * Add the upload meta box the the folder screeen
	 *
	 * @since    1.0.0
	 */
	public function add_meta_boxes(){
	
		if( $this->is_folder_screen() )
		{
			foreach ( array('folder') as $type ) 
			{
				add_meta_box('upload_files', __('Upload New Media'), array($this,'upload_meta_box'), $type, 'side','high');
			}   
		}
    }
    
	
	/**
	 * Returns the right post id
	 *
	 * @since    1.0.0
	 */
	private function get_post_id( $post_id )
	{
		// set post_id to global
		if( !$post_id )
		{
			global $post;
			
			if( $post )
			{
				$post_id = intval( $post->ID );
			}
		}
        
        /*
		*  Override for preview
		*  
		*  If the $_GET['preview_id'] is set, then the user wants to see the preview data.
		*  There is also the case of previewing a page with post_id = 1, but using get_field
		*  to load data from another post_id.
		*  In this case, we need to make sure that the autosave revision is actually related
		*  to the $post_id variable. If they match, then the autosave data will be used, otherwise, 
		*  the user wants to load data from a completely different post_id
		*/
		
		if( isset($_GET['preview_id']) )
		{
			$autosave = wp_get_post_autosave( $_GET['preview_id'] );
			if( $autosave->post_parent == $post_id )
			{
				$post_id = intval( $autosave->ID );
			}
		}
        
        return $post_id;
    }
	
    /**
	 * Add the upload form as a meta box
	 *
	 * @since    1.0.0
	 */
    public function upload_meta_box() {
        
		if( $this->is_folder_screen() )
		{
			
        global $post; 

        //$post_id = (isset($_GET['post'])) ? $_GET['post'] : 0;
        //$post_id = (isset($post)) ? $post->ID : $post_id;

        $post_id  = $this->get_post_id($_GET['post']);
        
        $form_class = 'media-upload-form type-form validate';

        if ( get_user_setting('uploader') || isset( $_GET['browser-uploader'] ) )
            $form_class .= ' html-uploader';
        ?>

        <p>

        <form id="file-form" enctype="multipart/form-data" method="post" action="<?php 
			echo admin_url('media-new.php?post_type=folder&post_id='.$post_id); ?>" class="<?php 
			echo $form_class; ?> ">
            <?php 
            $_REQUEST['post_id'] = $post_id;
            media_upload_form(); 
			?>
            <script type="text/javascript">
            var post_id = <?php echo $post_id; ?>, shortform = 3;
            </script>
            <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>" />
            <?php wp_nonce_field('media-form'); ?>
            <input type="hidden" name="redirect_to" value="<?php 
            	echo admin_url('post.php?post='.$post_id.'&action=edit'); ?>" />
            <div id="media-items" class="hide-if-no-js"></div>
        </form>

        </p>

        <?php
		}
    }
	

	/**
	 * Displays a list of attachements based on the media list
	 *
	 * @since    1.0.0
	 */
    public function media_list(){
		
		if( $this->is_folder_screen() )
		{
			
			global $post, $post_id, $post_type;
	
			$wp_list_table = new MediaFolders_List_Table();
	
			$_post = $post;
			
			$_post_type = $post_type;
	
			$pagenum = $wp_list_table->get_pagenum();
	
			$wp_list_table->prepare_items();
			
			// Handle bulk actions
			
			//$doaction = $wp_list_table->current_action();
			
			//$wp_list_table->views();
			
			//$wp_list_table->search_box( __( 'Search Media' ), 'media' );
			
			$wp_list_table->display();
			
			$post = $_post;
			
			$post_type = $_post_type;
		}
    }
    
	/**
	 * Retreives the post id of the folder and links the attachements to it
	 *
	 * @since    1.0.0
	 */
    function save_post($post_id) 
    {
		global $wpdb;
		
        if( ! current_user_can('edit_post', $post_id) ) 
        {
        	return $post_id;
        }
		
        $files = $wpdb->get_results( 
            "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND 'post_parent' = ".$post_id
        );

        foreach ( $files as $file ) 
        {
            $id = $file->ID;

            $current_data = get_post_meta($id , '_folder', TRUE);  

            if ($current_data) 
            {
                update_post_meta($id,'_folder','folder');
            }
            else
            {
                add_post_meta($id,'_folder','folder',TRUE);
            }

        }

        return $post_id;
    }
    
    /**
	 * Add css style to the admin head for the media list
	 *
	 * @since    1.0.0
	 */
	 public function media_list_style(){
		if( $this->is_folder_screen() )
		{
		?>
		<style>
		.column-parent{
			width:20% !important;
		}
		
		#media-items{
			width:100%;
		}
		</style>
		<?php
		}
    }
	
	/**
	 * Close an open form
	 *
	 * @since    1.0.0
	 */
    public function close_form(){
		if( $this->is_folder_screen() )
		{
        	echo '</form>';
		}
    }
    
}
