<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Recent_media widget class
 *
 * @since 2.8.0
 */

class BP_Media_Recent_Media extends WP_Widget {

    function __construct() {
		$widget_ops = array('classname' => 'widget_recent_media', 'description' => __( "The most recent media uploaded on your site") );
		parent::__construct('recent-media', __('Recent Media'), $widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
        
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Media') : $instance['title'], $instance, $this->id_base);
		
        if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
                
            echo $before_widget;
            echo $before_title . $title . $after_title;
        ?>
            <div id="recent-media-tabs" class="media-tabs-container">
                <ul>
                    <li><a href="#recent-media-tabs-all"><?php _e('All','bp-media'); ?></a></li>
                    <li><a href="#recent-media-tabs-videos"><?php _e('Videos','bp-media'); ?></a></li>                        
                    <li><a href="#recent-media-tabs-music"><?php _e('Music','bp-media'); ?></a></li>
                    <li><a href="#recent-media-tabs-photos"><?php _e('Photos','bp-media'); ?></a></li>                        
                </ul>
                <div id="recent-media-tabs-all">                    
                    <?php 
                    // All Media
                        $args = array( 'post_type' => 'attachment', 
                                        'post_status' => 'any',                                        
                                        'posts_per_page' => $number,
                                        'meta_key' => 'bp-media-key',    
                                        'meta_value' => 0,
                                        'meta_compare' => '>' );                       
                                    
                        $bp_media_widget_query = new WP_Query($args);                        
                       
                        if($bp_media_widget_query->have_posts()){   ?>
                    
                            <ul class="widget-item-listing"><?php 
                                while ($bp_media_widget_query->have_posts()) {  $bp_media_widget_query->the_post(); 
                                
                                    $entry = new BP_Media_Host_Wordpress( get_the_ID() );?>

                                    <?php echo $entry -> get_media_gallery_content();?><?php 
                                    
                                } ?>
                                    
                            </ul><!-- .widget-item-listing --><?php 
                            
                        }                        
                        wp_reset_query();   ?>
                    
                </div><!-- #recent-media-tabs-all -->
                
                <div id="recent-media-tabs-videos">
                    <?php 
                        // Rescent Video
                        $args = array( 'post_type' => 'attachment', 
                                        'post_status' => 'any',
                                        'post_mime_type' => 'video',
                                        'posts_per_page' => $number,
                                        'meta_key' => 'bp-media-key',    
                                        'meta_value' => 0,
                                        'meta_compare' => '>' );
                        
                        $bp_media_widget_query = new WP_Query($args);
                        
                        if($bp_media_widget_query->have_posts()){   ?>
                    
                            <ul class="widget-item-listing"><?php 
                                while ($bp_media_widget_query->have_posts()) {  $bp_media_widget_query->the_post(); 
                                
                                    $entry = new BP_Media_Host_Wordpress( get_the_ID() );?>

                                    <?php echo $entry -> get_media_gallery_content();?><?php 
                                    
                                } ?>
                                    
                            </ul><!-- .widget-item-listing --><?php 
                            
                        }                        
                        wp_reset_query();   ?>
                    
                </div><!-- #media-tabs-videos -->
                
                <div id="recent-media-tabs-music">
                    <?php 
                        // Rescent Audio
                        $args = array( 'post_type' => 'attachment', 
                                        'post_status' => 'any',
                                        'post_mime_type' => 'audio',
                                        'posts_per_page' => $number,
                                        'meta_key' => 'bp-media-key',    
                                        'meta_value' => 0,
                                        'meta_compare' => '>' );
                        
                        $bp_media_widget_query = new WP_Query($args);
                        
                        if($bp_media_widget_query->have_posts()){   ?>
                    
                            <ul class="widget-item-listing"><?php 
                                while ($bp_media_widget_query->have_posts()) {  $bp_media_widget_query->the_post(); 
                                
                                    $entry = new BP_Media_Host_Wordpress( get_the_ID() );?>

                                    <?php echo $entry -> get_media_gallery_content();?><?php 
                                    
                                } ?>
                                    
                            </ul><!-- .widget-item-listing --><?php  
                            
                        }                        
                        wp_reset_query();   ?>
                    
                </div><!-- #recent-media-tabs-music -->
                
                <div id="recent-media-tabs-photos">
                    <?php 
                        // Rescent photos
                         $args = array( 'post_type' => 'attachment', 
                                        'post_status' => 'any',
                                        'post_mime_type' => 'image',
                                        'posts_per_page' => $number,
                                        'meta_key' => 'bp-media-key',    
                                        'meta_value' => 0,
                                        'meta_compare' => '>' );

                        
                        $bp_media_widget_query = new WP_Query($args);
                        
                        if($bp_media_widget_query->have_posts()){   ?>
                    
                            <ul class="widget-item-listing"><?php 
                                while ($bp_media_widget_query->have_posts()) {  $bp_media_widget_query->the_post(); 
                                
                                    $entry = new BP_Media_Host_Wordpress( get_the_ID() );?>

                                    <?php echo $entry -> get_media_gallery_content();?><?php 
                                    
                                } ?>
                                    
                            </ul><!-- .widget-item-listing --><?php 
                            
                        }
                        wp_reset_query();   ?>
                    
                </div><!-- #media-tabs-photos -->
            </div>
        <?php
            echo $after_widget; 
            
            
        }

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		return $instance;
	}
    
	function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 10;
        ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
        <?php
		
	}
    
}




/**
 * Popular_media widget class
 *
 * @since 2.8.0
 */

class BP_Media_Popular_Media extends WP_Widget {

    function __construct() {
		$widget_ops = array('classname' => 'BP_Media_Popular_Media', 'description' => __( "The most popular media uploaded on your site") );
		parent::__construct('popular-media', __('Popular Media'), $widget_ops);
	}

	function widget($args, $instance) {
		extract( $args );
        
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Media') : $instance['title'], $instance, $this->id_base);
		
        if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
                
            echo $before_widget;
            echo $before_title . $title . $after_title;
        ?>
            <div id="popular-media-tabs" class="media-tabs-container">
                <ul>
                    <li><a href="#popular-media-tabs-comments"><?php _e('comments','bp-media'); ?></a></li>
                    <li><a href="#popular-media-tabs-views"><?php _e('Views','bp-media'); ?></a></li>                    
                </ul>
                <div id="popular-media-tabs-comments">                    
                    <?php 
                        $args = array( 'post_type' => 'attachment', 
                                        'post_status' => 'any',                                        
                                        'posts_per_page' => $number,
                                        'meta_key' => 'bp-media-key',    
                                        'meta_value' => 0,
                                        'meta_compare' => '>',
                                        'orderby' => 'comment_count');
                        
                        $bp_media_widget_query = new WP_Query($args);
                        
                        if($bp_media_widget_query->have_posts()){   ?>
                    
                            <ul class="widget-item-listing"><?php 
                                while ($bp_media_widget_query->have_posts()) {  $bp_media_widget_query->the_post(); 
                                
                                    $entry = new BP_Media_Host_Wordpress( get_the_ID() );?>

                                    <?php echo $entry -> get_media_gallery_content();?><?php 
                                    
                                } ?>
                                    
                            </ul><!-- .widget-item-listing --><?php     
                            
                        }                        
                        wp_reset_query();   ?>
                    
                </div><!-- #popular-media-tabs-comments -->
                
                <div id="popular-media-tabs-views">
                    <?php 
                    
                        $args = array( 'post_type' => 'attachment', 
                                        'post_status' => 'any',
                                        'posts_per_page' => $number,
                                        'meta_key' => 'bp-media-key',    
                                        'meta_value' => 0,
                                        'meta_compare' => '>',
                                        'orderby' => 'comment_count');
                        
                        $bp_media_widget_query = new WP_Query($args);
                        
                        if($bp_media_widget_query->have_posts()){   ?>
                    
                            <ul class="widget-item-listing"><?php 
                                while ($bp_media_widget_query->have_posts()) {  $bp_media_widget_query->the_post(); 
                                
                                    $entry = new BP_Media_Host_Wordpress( get_the_ID() );?>

                                    <?php echo $entry -> get_media_gallery_content();?><?php 
                                    
                                } ?>
                                    
                            </ul><!-- .widget-item-listing --><?php 
                            
                        }                        
                        wp_reset_query();   ?>
                    
                </div><!-- #popular-media-tabs-views -->
            </div>
        <?php
            echo $after_widget; 
        }

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		return $instance;
	}
    
	function form( $instance ) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 10;
        ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
        <?php
		
	}
    
}


function bp_media_widgets_init(){
    register_widget('BP_Media_Recent_Media');
    register_widget('BP_Media_Popular_Media');
}

add_action('widgets_init', 'bp_media_widgets_init', 1);


add_action( 'admin_bar_menu', 'bp_media_my_account_menu', 100 );

function bp_media_my_account_menu(){
    
    global $bp, $wp_admin_bar;
    
	// Bail if this is an ajax request
	if ( defined( 'DOING_AJAX' ) )
		return;
    
    
	// Logged in user
	if ( is_user_logged_in() ) {

		// Stored in the global so we can add menus easily later on
		$bp->my_account_menu_id = 'my-account-buddypress';

		// Create the main 'My Account' menu
		$wp_admin_bar->add_menu( array(
            'parent' => 'my-account',
			'id'     => 'media-setings',
			'group'  => true,
			'title'  => __( 'Media Settings' ),
			'meta'   => array(
                'class'  => 'ab-sub-secondary'
		) ) );

	// Show login and sign-up links
	}
}

?>