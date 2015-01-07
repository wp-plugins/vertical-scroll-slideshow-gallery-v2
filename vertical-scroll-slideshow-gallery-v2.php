<?php
/*
Plugin Name: Vertical scroll slideshow gallery v2
Plugin URI: http://www.gopiplus.com/work/2010/07/18/vertical-scroll-slideshow-gallery-v2/
Description:  Vertical scroll slideshow gallery plugin will create the vertical scrolling image slideshow gallery on the wordpress widget.
Author: Gopi Ramasamy
Version: 7.5
Author URI: http://www.gopiplus.com/work/2010/07/18/vertical-scroll-slideshow-gallery-v2/
Donate link: http://www.gopiplus.com/work/2010/07/18/vertical-scroll-slideshow-gallery-v2/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function vssg2_slideshow() 
{
	$vs2_str = "";
	$vssg2_siteurl = get_option('siteurl');
	$vssg2_pluginurl = $vssg2_siteurl . "/wp-content/plugins/vertical-scroll-slideshow-gallery-v2/";
	$vssg2_xml = get_option('vssg2_xml');
	if($vssg2_xml=="")
	{
		$vssg2_xml = "widget.xml";
	}
	?>
	<script language="JavaScript1.2">
	var vs2_scrollerwidth='<?php echo get_option('vssg2_width'); ?>';
	var vs2_scrollerheight='<?php echo get_option('vssg2_height'); ?>';
	var vs2_pausebetweenimages=<?php echo get_option('vssg2_time'); ?>;
	var vs2_slideimages=new Array();
	<?php
	$doc = new DOMDocument();
	$doc->load( $vssg2_pluginurl . 'gallery/'.$vssg2_xml );
	$images = $doc->getElementsByTagName( "image" );
	$vs2_count = 0;
	foreach( $images as $image )
	{
	  $paths = $image->getElementsByTagName( "path" );
	  $path = $paths->item(0)->nodeValue;
	  $targets = $image->getElementsByTagName( "target" );
	  $target = $targets->item(0)->nodeValue;
	  $titles = $image->getElementsByTagName( "title" );
	  $title = $titles->item(0)->nodeValue;
	  $links = $image->getElementsByTagName( "link" );
	  $link = $links->item(0)->nodeValue;
	  $vs2_str = $vs2_str . "vs2_slideimages[$vs2_count]='<a href=\'$link\' target=\'$target\'><img src=\'$path\' title=\'$title\' alt=\'$title\' border=\'0\'></a>'; ";
	  $vs2_count++;
	}
	echo $vs2_str;
	?>
	</script>
	<script src="<?php echo $vssg2_pluginurl; ?>script.js"></script>
	<ilayer id="vs2_main" width=&{vs2_scrollerwidth}; height=&{vs2_scrollerheight}; visibility=hide>
	<layer id="vs2_first" width=&{vs2_scrollerwidth};>
	<script language="JavaScript1.2">
	if (document.layers)
	document.write(vs2_slideimages[0])
	</script>
	</layer>
	<layer id="vs2_second" width=&{vs2_scrollerwidth}; visibility=hide>
	<script language="JavaScript1.2">
	if (document.layers)
	document.write(vs2_slideimages[dyndetermine=(vs2_slideimages.length==1)? 0 : 1])
	</script>
	</layer>
	</ilayer>
	<script language="JavaScript1.2">
	if (ie||dom)
	{
		document.writeln('<div style="padding:8px 0px 8px 0px;">')
		document.writeln('<div id="vs2_main2" style="position:relative;width:'+vs2_scrollerwidth+';height:'+vs2_scrollerheight+';overflow:hidden;">')
		document.writeln('<div style="position:absolute;width:'+vs2_scrollerwidth+';height:'+vs2_scrollerheight+';clip:rect(0 '+vs2_scrollerwidth+' '+vs2_scrollerheight+' 0);">')
		document.writeln('<div id="vs2_first2" style="position:absolute;width:'+vs2_scrollerwidth+';left:0px;top:1px;">')
		document.write(vs2_slideimages[0])
		document.writeln('</div>')
		document.writeln('<div id="vs2_second2" style="position:absolute;width:'+vs2_scrollerwidth+';visibility:hidden">')
		document.write(vs2_slideimages[dyndetermine=(vs2_slideimages.length==1)? 0 : 1])
		document.writeln('</div>')
		document.writeln('</div>')
		document.writeln('</div>')
		document.writeln('</div>')
	}
	</script>
	<?php
}

function vssg2_install() 
{
	add_option('vssg2_title', "Slide Show");
	add_option('vssg2_width', "100px");
	add_option('vssg2_height', "85px");
	add_option('vssg2_time', "3000");
	add_option('vssg2_xml', "widget.xml");
}

function vssg2_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('vssg2_title');
	echo $after_title;
	vssg2_slideshow();
	echo $after_widget;
}

function vssg2_control()
{
	echo '<p><b>';
	_e('Vertical scroll slideshow', 'vertical-scroll-slideshow');
	echo '.</b> ';
	_e('Check official website for more information', 'vertical-scroll-slideshow');
	?> <a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/vertical-scroll-slideshow-gallery-v2/"><?php _e('click here', 'vertical-scroll-slideshow'); ?></a></p><?php
}

function vssg2_option() 
{
	?>
	<div class="wrap">
	  <div class="form-wrap">
		<div id="icon-edit" class="icon32 icon32-posts-post"></div>
		<h2><?php _e('Vertical scroll slideshow gallery v2', 'vertical-scroll-slideshow'); ?></h2>
		<?php
		$vssg2_title = get_option('vssg2_title');
		$vssg2_width = get_option('vssg2_width');
		$vssg2_height = get_option('vssg2_height');
		$vssg2_time = get_option('vssg2_time');
		$vssg2_xml = get_option('vssg2_xml');
			
		if (isset($_POST['vssg2_form_submit']) && $_POST['vssg2_form_submit'] == 'yes')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('vssg2_form_setting');
			
			$vssg2_title = stripslashes($_POST['vssg2_title']);
			$vssg2_width = stripslashes($_POST['vssg2_width']);
			$vssg2_height = stripslashes($_POST['vssg2_height']);
			$vssg2_time = stripslashes($_POST['vssg2_time']);
			$vssg2_xml = stripslashes($_POST['vssg2_xml']);
			
			update_option('vssg2_title', $vssg2_title );
			update_option('vssg2_width', $vssg2_width );
			update_option('vssg2_height', $vssg2_height );
			update_option('vssg2_time', $vssg2_time );
			update_option('vssg2_xml', $vssg2_xml );
			
			?>
			<div class="updated fade">
				<p><strong><?php _e('Details successfully updated.', 'vertical-scroll-slideshow'); ?></strong></p>
			</div>
			<?php
		}
		?>
		<h3><?php _e('Plugin setting', 'vertical-scroll-slideshow'); ?></h3>
		<form name="vssg2_form" method="post" action="#">
		
			<label for="tag-title"><?php _e('Title', 'vertical-scroll-slideshow'); ?></label>
			<input name="vssg2_title" type="text" value="<?php echo $vssg2_title; ?>"  id="vssg2_title" size="70" maxlength="200">
			<p><?php _e('Please enter your widget title.', 'vertical-scroll-slideshow'); ?></p>
			
			<label for="tag-title"><?php _e('Width', 'vertical-scroll-slideshow'); ?></label>
			<input name="vssg2_width" type="text" value="<?php echo $vssg2_width; ?>"  id="vssg2_width" maxlength="5">
			<p><?php _e('Set the scroller width and scroller height to the width/height of the largest image in your slideshow.', 'vertical-scroll-slideshow'); ?> (Example: 100px)</p>
			
			<label for="tag-title"><?php _e('Height', 'vertical-scroll-slideshow'); ?></label>
			<input name="vssg2_height" type="text" value="<?php echo $vssg2_height; ?>"  id="vssg2_height" maxlength="5">
			<p><?php _e('Set the scroller width and scroller height to the width/height of the largest image in your slideshow.', 'vertical-scroll-slideshow'); ?> (Example: 85px)</p>
			
			<label for="tag-title"><?php _e('Timeout', 'vertical-scroll-slideshow'); ?></label>
			<input name="vssg2_time" type="text" value="<?php echo $vssg2_time; ?>"  id="vssg2_time" maxlength="5">
			<p><?php _e('Please enter slideshow timeout.', 'vertical-scroll-slideshow'); ?> (Example: 3000)</p>
			
			<label for="tag-title"><?php _e('Enter XML filename', 'vertical-scroll-slideshow'); ?></label>
			<input name="vssg2_xml" type="text" value="<?php echo $vssg2_xml; ?>"  id="vssg2_xml" size="40" maxlength="200">
			<p><?php _e('Please enter slideshow XML filename.', 'vertical-scroll-slideshow'); ?> (Example: widget.xml)</p>
			
			<div style="height:10px;"></div>
			<input type="hidden" name="vssg2_form_submit" value="yes"/>
			<input name="vssg2_submit" id="vssg2_submit" class="button" value="<?php _e('Submit', 'vertical-scroll-slideshow'); ?>" type="submit" />
			<a class="button" target="_blank" href="http://www.gopiplus.com/work/2010/07/18/vertical-scroll-slideshow-gallery-v2/"><?php _e('Help', 'vertical-scroll-slideshow'); ?></a>
			<?php wp_nonce_field('vssg2_form_setting'); ?>
		</form>
		</div>
		<h3><?php _e('Plugin configuration option', 'vertical-scroll-slideshow'); ?></h3>
		<ol>
			<li><?php _e('Drag and drop the widget to your sidebar.', 'vertical-scroll-slideshow'); ?></li>
			<li><?php _e('Add directly in to the theme using PHP code.', 'vertical-scroll-slideshow'); ?></li>
		</ol>
	<p class="description"><?php _e('Check official website for more information', 'vertical-scroll-slideshow'); ?> 
	<a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/vertical-scroll-slideshow-gallery-v2/"><?php _e('click here', 'vertical-scroll-slideshow'); ?></a></p>
	</div>
	<?php	
}

function vssg2_widget_init() 
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget('Vertical-Scroll-Slideshow-Gallery-V2', 
					__('Vertical Scroll Slideshow Gallery V2', 'vertical-scroll-slideshow'), 'vssg2_widget');
	}
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control('Vertical-Scroll-Slideshow-Gallery-V2', 
					array( __('Vertical Scroll Slideshow Gallery V2', 'vertical-scroll-slideshow'), 'widgets'), 'vssg2_control');
	} 
}

function vssg2_deactivation() 
{
	delete_option('vssg2_title');
	delete_option('vssg2_width');
	delete_option('vssg2_height');
	delete_option('vssg2_time');
	delete_option('vssg2_xml');
}

function vssg2_add_to_menu() 
{
	add_options_page( __('Vertical Scroll Slideshow Gallery V2', 'vertical-scroll-slideshow'), 
			__('Vertical Scroll Slideshow Gallery V2', 'vertical-scroll-slideshow'), 'manage_options', 'vertical-scroll-slideshow-gallery-v2', 'vssg2_option' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'vssg2_add_to_menu');
}

function vssg2_textdomain() 
{
	  load_plugin_textdomain( 'vertical-scroll-slideshow', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'vssg2_textdomain');
add_action("plugins_loaded", "vssg2_widget_init");
register_activation_hook(__FILE__, 'vssg2_install');
register_deactivation_hook(__FILE__, 'vssg2_deactivation');
add_action('init', 'vssg2_widget_init');
?>