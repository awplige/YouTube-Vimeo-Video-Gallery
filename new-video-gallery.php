<?php
/*
Plugin Name: 	New Video Gallery
Plugin URI: 	http://awplife.com/
Description: 	Create YouTube Vimeo Video Galleries Into WordPress Blog
Version: 		0.1.2
Author: 		A WP Life
Author URI: 	http://awplife.com/
License: 		GPL2
License URI:	https://www.gnu.org/licenses/gpl-2.0.html
Domain Path:	/languages
Text Domain:	VGP_TXTDM
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'New_Video_Gallery' ) ) {

	class New_Video_Gallery {
		
		protected $protected_plugin_api;
		protected $ajax_plugin_nonce;
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}		
		
		protected function _constants() {
			//Plugin Version
			define( 'VG_PLUGIN_VER', '0.1.1' );
			
			//Plugin Text Domain
			define("VGP_TXTDM","awl-video-gallery" );

			//Plugin Name
			define( 'VG_PLUGIN_NAME', __( 'Video Gallery', VGP_TXTDM ) );

			//Plugin Slug
			define( 'VG_PLUGIN_SLUG', 'video_gallery' );

			//Plugin Directory Path
			define( 'VG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			//Plugin Directory URL
			define( 'VG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			/**
			 * Create a key for the .htaccess secure download link.
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define( 'VG_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function
		
		
		/**
		 * Setup the default filters and actions
		 * @uses      add_action()  To add various actions
		 * @access    private
		 * @since     0.0.5
		 * @return    void
		 */
		protected function _hooks() {
			
			//Load text domain
			add_action( 'plugins_loaded', array( $this, '_load_textdomain' ) );
			
			//add Video gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, '_srgallery_menu' ), 101 );
			
			//Create Video Gallery Custom Post
			add_action( 'init', array( $this, '_New_Video_Gallery' ));
			
			//Add meta box to custom post
			add_action( 'add_meta_boxes', array( $this, '_admin_add_meta_box' ) );
			 
			//loaded during admin init 
			add_action( 'admin_init', array( $this, '_admin_add_meta_box' ) );
			
			add_action('wp_ajax_video_gallery_js', array(&$this, '_ajax_video_gallery'));
		
			add_action('save_post', array(&$this, '_vg_save_settings'));

			//Shortcode Compatibility in Text Widgets
			add_filter('widget_text', 'do_shortcode');

		} // end of hook function
		
		
		public function _load_textdomain() {
			load_plugin_textdomain( 'VGP_TXTDM', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );		
		}		
		
		public function _srgallery_menu() {
			$help_menu = add_submenu_page( 'edit.php?post_type='.VG_PLUGIN_SLUG, __( 'Docs', VGP_TXTDM ), __( 'Docs', VGP_TXTDM ), 'administrator', 'sr-doc-page', array( $this, '_vg_doc_page') );
		}
		
		/**
		 * video Gallery Custom Post
		 * Create gallery post type in admin dashboard.
		 * @access    private
		*/
		public function _New_Video_Gallery() {
			$labels = array(
				'name'               => _x( 'Video Gallery', 'Post Type General Name', VGP_TXTDM ),
				'singular_name'      => _x( 'Video Gallery', 'Post Type Singular Name', VGP_TXTDM ),
				'menu_name'          => _x( 'Video Gallery', VGP_TXTDM ),
				'name_admin_bar'     => _x( 'Video Gallery', VGP_TXTDM ),
				'add_new'            => _x( 'Add Video Gallery',VGP_TXTDM ),
				'add_new_item'       => __( 'Add New Video Gallery', VGP_TXTDM ),
				'new_item'           => __( 'New Video Gallery ', VGP_TXTDM ),
				'edit_item'          => __( 'Edit Video Gallery', VGP_TXTDM ),
				'view_item'          => __( 'View Video Gallery', VGP_TXTDM ),
				'all_items'          => __( 'All Video Gallery', VGP_TXTDM ),
				'search_items'       => __( 'Search Video Gallery', VGP_TXTDM ),
				'parent_item_colon'  => __( 'Parent Video Gallery:', VGP_TXTDM ),
				'not_found'          => __( 'Video Gallery Not found.', VGP_TXTDM ),
				'not_found_in_trash' => __( 'Video Gallery Not found in Trash.', VGP_TXTDM )
			);

			$args = array(
				'label'               => __( 'Video Gallery', VGP_TXTDM ),
				'description'         => __( 'Custom Post Type For Video Gallery', VGP_TXTDM ),
				'labels'              => $labels,
				'supports'            => array( 'title'),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 65,
				'menu_icon'           => 'dashicons-images-alt2',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,		
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);

			register_post_type( 'video_gallery', $args );
		}// end of post type function
		
		/**
		 * Adds Meta Boxes
		 */
		public function _admin_add_meta_box() {
			// Syntax: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
			add_meta_box( '', __('Add Video', VGP_TXTDM), array(&$this, 'vg_upload_multiple_images'), 'video_gallery', 'normal', 'default' );
		}
		
		public function vg_upload_multiple_images($post) {
				wp_enqueue_script('media-upload');
				wp_enqueue_script('awl-vg-uploader.js', VG_PLUGIN_URL . 'js/awl-vg-uploader.js', array('jquery'));
				wp_enqueue_style('awl-vg-uploader-css', VG_PLUGIN_URL . 'css/awl-vg-uploader.css');
				wp_enqueue_media();
				
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'awl-vg-color-picker-js', plugins_url('js/vg-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
				?>
				<div id="slider-gallery">
					<h3><span class="dashicons dashicons-editor-help"></span> Tips: <a href="http://awplife.com/how-to-get-youtube-or-vimeo-video-id/" target="_blank">How to get YouTube / Vimeo video id?</a></h3>
					<h3><span class="dashicons dashicons-editor-help"></span> Tips: <a href="http://awplife.com/capture-youtube-vimeo-video-poster-like-a-pro/" target="_blank">Capture YouTube / Vimeo Video Poster Like A Pro</a></h3>
					<input type="button" id="remove-all-slides" name="remove-all-slides" class="button button-large remove-all-slides" rel="" value="<?php _e('Delete All Images', VGP_TXTDM); ?>">
					<ul id="remove-slides" class="sbox">
					<?php
					$allimagesetting = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_vg_settings_'.$post->ID, true)));
					if(isset($allimagesetting['slide-ids'])) {
						$count = 0;
					foreach($allimagesetting['slide-ids'] as $id) {
						$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
						$attachment = get_post( $id );
						$image_link =  $allimagesetting['slide-link'][$count];
						$image_type =  $allimagesetting['slide-type'][$count];
						?>
						<li class="slide">
							<img class="new-slide" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
							<input type="hidden" id="slide-ids[]" name="slide-ids[]" value="<?php echo $id; ?>" />
							<!-- Image Title, Caption, Alt Text-->
							<select id="slide-type[]" name="slide-type[]" class="form-control" style="width: 100%;" value="<?php echo $image_type; ?>" >
								<option value="y" <?php if($image_type == "y") echo "selected=selected"; ?>>YouTube</option>
								<option value="v" <?php if($image_type == "v") echo "selected=selected"; ?>>Vimeo</option>
							</select>
							<input type="text" name="slide-link[]" id="slide-link[]" style="width: 100%;" placeholder="Enter YouTube / Vimeo Video ID" value="<?php echo $image_link; ?>">
							<input type="text" name="slide-title[]" id="slide-title[]" style="width: 100%;" placeholder="Video Title" value="<?php echo get_the_title($id); ?>">
							<input type="button" name="remove-slide" id="remove-slide" class="button remove-single-slide button-danger" style="width: 100%;" value="Delete">
						</li>
					<?php $count++; } // end of foreach
					} //end of if
					?>
					</ul>
				</div>
				
				<!--Add New Image Button-->
				<div name="add-new-slider" id="add-new-slider" class="new-slider" style="height: 205px; width: 192px; border-radius: 8px;">
					<div class="menu-icon dashicons dashicons-format-image"></div>
					<div class="add-text"><?php _e('Add Image', VGP_TXTDM); ?></div>
				</div>
				<div style="clear:left;"></div>
				<br>
				<br>
				<h1>Copy Video Gallery Shortcode</h1>
				<hr>
				<p class="input-text-wrap">
					<p><?php _e('Copy & Embed shotcode into any Page/ Post / Text Widget to display your video gallery on site.', VGP_TXTDM); ?><br></p>
					<input type="text" name="shortcode" id="shortcode" value="<?php echo "[VDGAL id=".$post->ID."]"; ?>" readonly style="height: 60px; text-align: center; font-size: 24px; width: 25%; border: 2px dashed;" onmouseover="return pulseOff();" onmouseout="return pulseStart();">
				</p>
				<br>
				<br>
				<h1><?php _e('Video Gallery Setting', VGP_TXTDM); ?></h1>
				<hr>
				<?php
				require_once('video-gallery-settings.php');
		}
		public function _vg_ajax_callback_function($id) {
			//wp_get_attachment_image_src ( int $attachment_id, string|array $size = 'thumbnail', bool $icon = false )
			//thumb, thumbnail, medium, large, post-thumbnail
			$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
			$attachment = get_post( $id ); // $id = attachment id
			?>
			<li class="slide">
				<img class="new-slide" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
				<input type="hidden" id="slide-ids[]" name="slide-ids[]" value="<?php echo $id; ?>" />
				<select id="slide-type[]" name="slide-type[]" class="form-control" style="width: 100%;" placeholder="Image Title" value="<?php echo $image_type; ?>" >
					<option value="y" <?php if($image_type == "y") echo "selected=selected"; ?>>YouTube</option>
					<option value="v" <?php if($image_type == "v") echo "selected=selected"; ?>>Vimeo</option>
				</select>
				<input type="text" name="slide-link[]" id="slide-link[]" style="width: 100%;" placeholder="Enter YouTube / Vimeo Video ID">
				<input type="text" name="slide-title[]" id="slide-title[]" style="width: 100%;" placeholder="Video Title" value="<?php echo get_the_title($id); ?>">
				<input type="button" name="remove-slide" id="remove-slide" style="width: 100%;" class="button" value="Delete">
			</li>
			<?php
		}
		
		public function _ajax_video_gallery() {
			echo $this->_vg_ajax_callback_function($_POST['slideId']);
			die;
		}
		
		public function _vg_save_settings($post_id) {
			if (isset($_POST['vg-settings'] ) == "vg-save-settings") {
				$image_ids = $_POST['slide-ids'];
				$image_titles = $_POST['slide-title'];
				$image_types = $_POST['slide-type'];
				$i = 0;
				foreach($image_ids as $image_id) {
					$single_image_update = array(
						'ID'           => $image_id,
						'post_title'   => $image_titles[$i],
					);
					wp_update_post( $single_image_update );
					$i++;
				}				
				$awl_video_gallery_shortcode_setting = "awl_vg_settings_".$post_id;
				update_post_meta($post_id, $awl_video_gallery_shortcode_setting, base64_encode(serialize($_POST)));
			}
		}// end save setting
		
		/**
		 * video Gallery Docs Page
		 * Create doc page to help user to setup plugin
		 * @access    private
		 * @since     3.0
		 * @return    void.
		 */
		public function _vg_doc_page() {
			require_once('docs.php');
		}
	}
	$vg_gallery_object = new New_Video_Gallery();
	require_once('shortcode.php');
}
?>