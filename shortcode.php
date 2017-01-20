<?php
/**
 * video Gallery Premium Shortcode
 *
 * @access    public
 * @since     3.0
 *
 * @return    Create Fontend Gallery Output
 */
add_shortcode('VDGAL', 'awl_video_gallery_shortcode');
function awl_video_gallery_shortcode($post_id) {
	ob_start();
		
	//output code file
	require("video-gallery-code.php");
	
	return ob_get_clean();
}
?>