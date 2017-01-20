<?php
//toggle button CSS
wp_enqueue_style('awl-em-css', plugin_dir_url( __FILE__ ) . 'css/toogle-button.css');
wp_enqueue_style('awl-go-top-css', plugin_dir_url( __FILE__ ) . 'css/go-to-top.css');
wp_enqueue_style('awl-bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.css');
wp_enqueue_style('awl-styles-css', plugin_dir_url( __FILE__ ) . 'css/styles.css');
//js
wp_enqueue_script('jquery');
wp_enqueue_script( 'awl-bootstrap-js',  plugin_dir_url( __FILE__ ) .'js/bootstrap.js', array( 'jquery' ), '', true  );
wp_enqueue_script( 'awl-go-top-js', plugin_dir_url( __FILE__ ) .'js/go-to-top.js', array( 'jquery' ), '', true  );


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//load settings
$gallery_settings = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_vg_settings_'.$post->ID, true)));
//print_r($gallery_settings);
$video_gallery_id = $post->ID;

//css
wp_enqueue_style( 'vg-font-awesome-css', plugin_dir_url( __FILE__ ).'css/font-awesome.min.css' );
wp_enqueue_style( 'wp-color-picker' );

//js
wp_enqueue_script('jquery');
wp_enqueue_script( 'vg-color-picker-js',  plugin_dir_url( __FILE__ ).'js/vg-color-picker.js', array( 'jquery', 'wp-color-picker' ), '', true  );
?>
<!-- Return to Top -->
<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<!--Thumbnail Settings-->
	<div class="panel panel-default">
		<div class="panel-heading panel-heading-theme-1 icon-right" role="tab" id="heading1" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-controls="collapse1">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1"><i class="fa fa-chevron-down"></i>
				  A. Columns & Thumbnail Settings
				</a>
			</h4>
		</div>
		<div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">
			<div class="panel-body">
			
				<p class="">
					<p class="bg-title">1. Gallery Thumbnail Size</p></br>
					<?php if(isset($gallery_settings['gal_thumb_size'])) $gal_thumb_size = $gallery_settings['gal_thumb_size']; else $gal_thumb_size = "thumbnail"; ?>
					<select id="gal_thumb_size" name="gal_thumb_size" class="selectbox_settings">
						<option value="thumbnail" <?php if($gal_thumb_size == "thumbnail") echo "selected=selected"; ?>>Thumbnail – 150 × 150</option>
						<option value="medium" <?php if($gal_thumb_size == "medium") echo "selected=selected"; ?>>Medium – 300 × 169</option>
						<option value="large" <?php if($gal_thumb_size == "large") echo "selected=selected"; ?>>Large – 840 × 473</option>
						<option value="full" <?php if($gal_thumb_size == "full") echo "selected=selected"; ?>>Full Size – 1280 × 720</option>
					</select></br></br>
					<p class="video_cmnt_setting"><?php _e('Select gallery thumnails size to display into gallery', VGP_TXTDM); ?></p>
				</p>

				<p class="">
					<p class="bg-title">2. Colums On Large Desktops</p>
					<?php if(isset($gallery_settings['col_large_desktops'])) $col_large_desktops = $gallery_settings['col_large_desktops']; else $col_large_desktops = "col-lg-2"; ?>
					<select id="col_large_desktops" name="col_large_desktops" class="selectbox_settings">
						<option value="col-lg-12" <?php if($col_large_desktops == "col-lg-12") echo "selected=selected"; ?>>1 Column</option>
						<option value="col-lg-6" <?php if($col_large_desktops == "col-lg-6") echo "selected=selected"; ?>>2 Column</option>
						<option value="col-lg-4" <?php if($col_large_desktops == "col-lg-4") echo "selected=selected"; ?>>3 Column</option>
						<option value="col-lg-3" <?php if($col_large_desktops == "col-lg-3") echo "selected=selected"; ?>>4 Column</option>
						<option value="col-lg-2" <?php if($col_large_desktops == "col-lg-2") echo "selected=selected"; ?>>6 Column</option>
						<option value="col-lg-1" <?php if($col_large_desktops == "col-lg-1") echo "selected=selected"; ?>>12 Column</option>
					</select></br></br>
					<p class="video_cmnt_setting"><?php _e('Select gallery column layout for large desktop devices', VGP_TXTDM); ?></p>
				</p>

				<p class="">
					<p class="bg-title">3. Colums On Desktops</p>
					<?php if(isset($gallery_settings['col_desktops'])) $col_desktops = $gallery_settings['col_desktops']; else $col_desktops = "col-md-3"; ?>
					<select id="col_desktops" name="col_desktops" class="selectbox_settings">
						<option value="col-md-12" <?php if($col_desktops == "col-md-12") echo "selected=selected"; ?>>1 Column</option>
						<option value="col-md-6" <?php if($col_desktops == "col-md-6") echo "selected=selected"; ?>>2 Column</option>
						<option value="col-md-4" <?php if($col_desktops == "col-md-4") echo "selected=selected"; ?>>3 Column</option>
						<option value="col-md-3" <?php if($col_desktops == "col-md-3") echo "selected=selected"; ?>>4 Column</option>
						<option value="col-md-2" <?php if($col_desktops == "col-md-2") echo "selected=selected"; ?>>6 Column</option>
						<option value="col-md-1" <?php if($col_desktops == "col-md-1") echo "selected=selected"; ?>>12 Column</option>
					</select></br></br>
					<p class="video_cmnt_setting"><?php _e('Select gallery column layout for desktop devices', VGP_TXTDM); ?></p>
				</p>

				<p class="">
					<p class="bg-title">4. Colums On Tablets</p>
					<?php if(isset($gallery_settings['col_tablets'])) $col_tablets = $gallery_settings['col_tablets']; else $col_tablets = "col-sm-4"; ?>
					<select id="col_tablets" name="col_tablets" class="selectbox_settings">
						<option value="col-sm-12" <?php if($col_tablets == "col-sm-12") echo "selected=selected"; ?>>1 Column</option>
						<option value="col-sm-6" <?php if($col_tablets == "col-sm-12") echo "selected=selected"; ?>>2 Column</option>
						<option value="col-sm-4" <?php if($col_tablets == "col-sm-4") echo "selected=selected"; ?>>3 Column</option>
						<option value="col-sm-3" <?php if($col_tablets == "col-sm-3") echo "selected=selected"; ?>>4 Column</option>
						<option value="col-sm-2" <?php if($col_tablets == "col-sm-2") echo "selected=selected"; ?>>6 Column</option>
					</select></br></br>
					<p class="video_cmnt_setting"><?php _e('Select gallery column layout for tablet devices', VGP_TXTDM); ?></p>
				</p>

				<p class="">
					<p class="bg-title">5. Colums On Phones</p>
					<?php if(isset($gallery_settings['col_phones'])) $col_phones = $gallery_settings['col_phones']; else $col_phones = "col-xs-6"; ?>
					<select id="col_phones" name="col_phones" class="selectbox_settings">
						<option value="col-xs-12" <?php if($col_phones == "col-xs-12") echo "selected=selected"; ?>>1 Column</option>
						<option value="col-xs-6" <?php if($col_phones == "col-xs-6") echo "selected=selected"; ?>>2 Column</option>
						<option value="col-xs-4" <?php if($col_phones == "col-xs-4") echo "selected=selected"; ?>>3 Column</option>
						<option value="col-xs-3" <?php if($col_phones == "col-xs-3") echo "selected=selected"; ?>>4 Column</option>
					</select></br></br>
					<p class="video_cmnt_setting"><?php _e('Select gallery column layout for phone devices', VGP_TXTDM); ?></p>
				</p>
			</div>
		</div>
	</div>
	
	<!-- Width & Height -->
	<div class="panel panel-default">
		<div class="panel-heading panel-heading-theme-1 icon-right" role="tab" id="heading2" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-controls="collapse2">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2"><i class="fa fa-chevron-down"></i>
				  B. Width & Height Settings
				</a>
			</h4>
		</div>
		<div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
			<div class="panel-body">
				<p class="video-settings">
					<p class="bg-title">1. Width</p>
					<?php if(isset($gallery_settings['width'])) $width = $gallery_settings['width']; else $width = 700; ?>	
					<input type="number" class="selectbox_settings" id="width" name="width" placeholder="" value="<?php echo $width; ?>"></br></br>
					<p class="video_cmnt_setting"><?php _e('Set the video frame preview width. Default is 700.', VGP_TXTDM); ?></p>
				</p>

				<p class="video-settings">
					<p class="bg-title">2. Height</p>
					<?php if(isset($gallery_settings['height'])) $height = $gallery_settings['height']; else $height = 480; ?>	
					<input type="number" class="selectbox_settings" id="height" name="height" placeholder="" value="<?php echo $height; ?>"></br></br>
					<p class="video_cmnt_setting"><?php _e('Set the video frame preview height. Default is 480.', VGP_TXTDM); ?></p>
				</p>
			</div>
		</div>
	</div>
	
	<!-- Auto play -->
	<div class="panel panel-default">
		<div class="panel-heading panel-heading-theme-1 icon-right" role="tab" id="heading3" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-controls="collapse2">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3"><i class="fa fa-chevron-down"></i>
				  C. Auto play/Close Settings
				</a>
			</h4>
		</div>
		<div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
			<div class="panel-body">
				<p class="video-settings">
					<p class="bg-title">1. Auto Play</p>
					<p class="switch-field em_size_field">
						<?php if(isset($gallery_settings['auto_play'])) $auto_play = $gallery_settings['auto_play']; else $auto_play = "true"; ?>
						<input type="radio" class="form-control" id="auto_play1" name="auto_play" value="true" <?php if($auto_play == "true") echo "checked" ; ?>>
						<label for="auto_play1"><?php _e('Yes', VGP_TXTDM); ?></label>
						<input type="radio" class="form-control" id="auto_play2" name="auto_play" value="false" <?php if($auto_play == "false") echo "checked" ; ?>>
						<label for="auto_play2"><?php _e('No', VGP_TXTDM); ?></label>
						<p class="video_cmnt_setting"><?php _e('Start playback immediately once the element is clicked (true,false)', VGP_TXTDM); ?></p>
					</p>
				</p>

				<p class="video-settings">
					<p class="bg-title">2. Auto Close</p>
					<p class="switch-field em_size_field">
						<?php if(isset($gallery_settings['auto_close'])) $auto_close = $gallery_settings['auto_close']; else $auto_close = "true"; ?>
						<input type="radio" class="form-control" id="auto_close1" name="auto_close" value="true" <?php if($auto_close == "true") echo "checked" ; ?>>
						<label for="auto_close1"><?php _e('Yes', VGP_TXTDM); ?></label>
						<input type="radio" class="form-control" id="auto_close2" name="auto_close" value="false" <?php if($auto_close == "false") echo "checked" ; ?>>
						<label for="auto_close2"><?php _e('No', VGP_TXTDM); ?></label>
						<p class="video_cmnt_setting"><?php _e('When video will complete than lightbox / popover automatic video is close (true,false)', VGP_TXTDM); ?></p>
					</p>
				</p>
			</div>
		</div>
	</div>			
	
	
	
	<!-- Other -->
	<div class="panel panel-default">
		<div class="panel-heading panel-heading-theme-1 icon-right" role="tab" id="heading9" data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-controls="collapse10">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="true" aria-controls="collapse10"><i class="fa fa-chevron-down"></i>
				  D. Extra Other Settings
				</a>
			</h4>
		</div>
		<div id="collapse10" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
			<div class="panel-body">		
				<p class="range-slider">
					<p class="bg-title">1. Z index</p>
					<p class="switch-field em_size_field">
						<?php 
						if(isset($gallery_settings['z_index'])) $z_index = $gallery_settings['z_index']; else $z_index = "default"; 
						if($z_index == "default") { $z_index_custom_value = 2100; } else  {
							if(isset($gallery_settings['z_index_custom_value'])) $z_index_custom_value = $gallery_settings['z_index_custom_value']; else $z_index_custom_value = 2100; 
						}
						?>		
						<input type="radio" class="form-control" id="z_index1" name="z_index" value="default" <?php if($z_index == "default") echo "checked"; ?>> 
						<label for="z_index1"><?php _e('Default', VGP_TXTDM); ?></label>
						<input type="radio" class="form-control" id="z_index2" name="z_index" value="custom" <?php if($z_index == "custom") echo "checked"; ?>>
						<label for="z_index2"><?php _e('Custom', VGP_TXTDM); ?></label>
						<br><br><br>
						<input id="z_index_custom_value" name="z_index_custom_value" class="range-slider__range" type="range" value="<?php echo $z_index_custom_value; ?>" min="0" max="9999" step="10" style="width: 300px !important; margin-left: 10px;">
						<span class="range-slider__value">0</span>
						<p class="video_cmnt_setting"><?php _e('Set the Z-index of video frame preview page overlay. Default is 2100.', VGP_TXTDM); ?></p>
					</p>
				</p>

				<p class="video-settings">
					<p class="bg-title"><?php _e('8. Custom CSS', VGP_TXTDM); ?></p>
					<?php if(isset($gallery_settings['custom-css'])) $custom_css = $gallery_settings['custom-css']; else $custom_css = ""; ?>
					<textarea name="custom-css" id="custom-css" style="width: 100%; height: 120px;" placeholder="Type direct CSS code here. Don't use <style>...</style> tag."><?php echo $custom_css; ?></textarea><br><br>
					<p class="video_cmnt_setting"><?php _e('Apply own css on video gallery and dont use style tag', VGP_TXTDM); ?></p>
				</p>
			</div>
		</div>
	</div>	
</div>
<input type="hidden" name="vg-settings" id="vg-settings" value="vg-save-settings">
<style>
.setting-toggle-div {
	background-color: #FFFFFF;
	padding: 10px;
	margin-bottom: 15px;
	border: 2px solid #CCCCCC;
	border-radius: 3px;
}

.be-right {
	float: right !important;
}

.wp-picker-container input.wp-color-picker[type="text"] {
	width: 80px !important;
	height: 25px !important;
	float: left;
	font-size: 11px !important;
}
		
.selectbox_settings {
	width: 300px;
	margin-left: 20px;
} 
.video_cmnt_setting {
	font-size: 15px !important;
	padding-left: 4px;
	font: initial;
	margin-top: 5px;
	padding-left:14px;
}

</style>
<script>
//color-picker
(function( jQuery ) {
	jQuery(function() {
		// Add Color Picker to all inputs that have 'color-field' class
		jQuery('#cibc').wpColorPicker();
	});
})( jQuery );

// title size range settings.  on change range value
function updateRange(val, id) {
	jQuery("#" + id).val(val);
	jQuery("#" + id + "_value").val(val);	  
}	

// start pulse on page load
function pulseEff() {
   jQuery('#shortcode').fadeOut(600).fadeIn(600);
};
var Interval;
Interval = setInterval(pulseEff,1500);

// stop pulse
function pulseOff() {
	clearInterval(Interval);
}
// start pulse
function pulseStart() {
	Interval = setInterval(pulseEff,2000);
}

///on load zinx hide show
var zindex = jQuery('input[name="z_index"]:checked').val();
if(zindex == "default") {
	jQuery("#z_index_custom").val(2100);
	jQuery("#z_index_custom_value").val(2100);
}

// description font size hide show
jQuery(document).ready(function() {
	jQuery('#z_index').change(function(){
		var zindex = jQuery('input[name="z_index"]:checked').val();
		if(zindex == "default") {
			jQuery("#z_index_custom").val(2100);
			jQuery("#z_index_custom_value").val(2100);
		}
	});
});

	//new editing setting page Start .....
		//dropdown toggle on change effect
		jQuery(document).ready(function() {
			//accordion icon
			jQuery(function() {
				function toggleSign(e) {
					jQuery(e.target)
					.prev('.panel-heading')
					.find('i')
					.toggleClass('fa fa-chevron-down fa fa-chevron-up');
				}
				jQuery('#accordion').on('hidden.bs.collapse', toggleSign);
				jQuery('#accordion').on('shown.bs.collapse', toggleSign);

				});
			});

		//range slider
			var rangeSlider = function(){
			  var slider = jQuery('.range-slider'),
				  range = jQuery('.range-slider__range'),
				  value = jQuery('.range-slider__value');
				
			  slider.each(function(){

				value.each(function(){
				  var value = jQuery(this).prev().attr('value');
				  jQuery(this).html(value);
				});

				range.on('input', function(){
				  jQuery(this).next(value).html(this.value);
				});
			  });
			};
			rangeSlider();	
	//new editing setting page end....	
</script>