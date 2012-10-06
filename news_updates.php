<?php
/**
 * @package ESPN News and Updates Widget
 * @version 1.0
 */
/*
Plugin Name: ESPN News & Updates Widget
Plugin URI: http://patelmilap.wordpress.com/
Description: This widget adds a ESPN News and Updates Widget into your wordpress website sidebar.
Author: Milap Patel
Version: 1.0
Author URI: http://patelmilap.wordpress.com/
*/

/**
 * ESPN News & Updates Widget Class
 */

define('ESPN_UPDATES_WIDGET_PLUGIN_URL', plugin_dir_url( __FILE__ ));

class espn_updates_widget extends WP_Widget {

    /** constructor */
    function espn_updates_widget() {
        parent::WP_Widget(false, $name = 'ESPN News & Updates');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
    	
    	global $api_key;
        extract( $args );
        
		$title 			=	apply_filters('widget_title', $instance['title']);
		$api_key        =   $instance['api_key'];
		$news_type        =   $instance['news_type'];
		
		wp_register_script( 'myownscript',ESPN_UPDATES_WIDGET_PLUGIN_URL . 'news.js' ,array('jquery'));
        wp_enqueue_script( 'myownscript' );
        $local_variables = array('api_key' => $api_key , "news_type" => $news_type);
        wp_localize_script( 'myownscript', 'vars', $local_variables );
        echo $before_widget;
        if ( $title )
        echo $before_title . $title . $after_title;?>
        <div id="news"></div>
        <?php echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		
    	$instance	=	$old_instance;
		$instance	=	array();
		foreach ( $instance as $field => $val ) {
			if ( isset($new_instance[$field]) )
				$instance[$field] = 1;
		}
		$instance['title']			=	strip_tags($new_instance['title']);
		$instance['api_key']		=	strip_tags($new_instance['api_key']);
		$instance['news_type']		=	strip_tags($new_instance['news_type']);
		
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	

    	/**
    	 * Set Default Value for widget form
    	 */
    	
    	$default_value	=	array();
    	$instance		=	wp_parse_args((array)$instance,$default_value);
        $title			=	esc_attr($instance['title']);
        $api_key			=	esc_attr($instance['api_key']);
        $news_type			=	esc_attr($instance['news_type']);
        
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
        <p>
			<label for="<?php echo $this->get_field_id('api_key'); ?>"><?php _e('ESPN API Key:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('api_key'); ?>" name="<?php echo $this->get_field_name('api_key'); ?>" type="text" value="<?php echo $api_key; ?>" />
			<small>
			<?php _e('Get Your ESPN API Key');?>
          		<a href="http://developer.espn.com/member/register" target="_blank">
	          		<?php _e('Here');?>
          		</a>
          	</small>
        </p>
		
        <p>
        	<label for="<?php echo $this->get_field_id('news_type'); ?>"><?php _e('Choose News:'); ?></label>
    		<select name="<?php echo $this->get_field_name('news_type'); ?>" id="<?php echo $this->get_field_id('news_type'); ?>">
    			<option value="http://api.espn.com/v1/sports/news/headlines/top"<?php selected( $instance['news_type'], 'http://api.espn.com/v1/sports/news/headlines/top' ); ?>><?php _e('ESPN.com home page news'); ?></option>
    			<option value="http://api.espn.com/v1/sports/news/headlines"<?php selected( $instance['news_type'], 'http://api.espn.com/v1/sports/news/headlines' ); ?>><?php _e('Editorially-curated News'); ?></option>
    			<option value="http://api.espn.com/v1/sports/basketball/nba/news/headlines"<?php selected( $instance['news_type'], 'http://api.espn.com/v1/sports/basketball/nba/news/headlines' ); ?>><?php _e('Top editorially-curated NBA news'); ?></option>
    			<option value="http://api.espn.com/v1/sports/basketball/nba/news"<?php selected( $instance['news_type'], 'http://api.espn.com/v1/sports/basketball/nba/news' ); ?>><?php _e('Fire hose of NBA-related news'); ?></option>
    			<option value="http://api.espn.com/v1/sports/basketball/nba/news?dates=20100219"<?php selected( $instance['news_type'], 'http://api.espn.com/v1/sports/basketball/nba/news?dates=20100219' ); ?>><?php _e('NBA news published on a specific date'); ?></option>
    			<option value="http://api.espn.com/v1/sports/soccer/fifa.olympics/news"<?php selected( $instance['news_type'], 'http://api.espn.com/v1/sports/soccer/fifa.olympics/news' ); ?>><?php _e('Olympics soccer news from current day'); ?></option>
    			<option value="http://api.espn.com/v1/sports/soccer/eng.1/news/headlines"<?php selected( $instance['news_type'], 'http://api.espn.com/v1/sports/soccer/eng.1/news/headlines' ); ?>><?php _e('Barclays Premier League News'); ?></option>
    			<option value="http://api.espn.com/v1/fantasy/football/news"<?php selected( $instance['news_type'], 'http://api.espn.com/v1/fantasy/football/news' ); ?>><?php _e("Current day's Fantasy Football news"); ?></option>
    			<option value="http://api.espn.com/v1/sports/news/6277112"<?php selected( $instance['news_type'], 'http://api.espn.com/v1/sports/news/6277112' ); ?>><?php _e('Full text for a specific story'); ?></option>
        	</select>
        </p>
        
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("espn_updates_widget");'));
?>