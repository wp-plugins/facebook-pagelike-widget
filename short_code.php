<?php
function fb_plugin_shortcode() {
    global $app_id,$select_lng;
    $widget_facebook_widget = get_option('widget_fbw_id');
    if (is_active_widget(false, '', 'fbw_id')) {
        foreach ($widget_facebook_widget as $facebook_widget) {

            $title = $facebook_widget['title'];
            $app_id = $facebook_widget['app_id'];
            $fb_url = $facebook_widget['fb_url'];
            $show_faces = $facebook_widget['show_faces'];
            $show_stream = $facebook_widget['data_stream'];
            $show_header = $facebook_widget['show_header'];
            $width = $facebook_widget['width'];
            $height = $facebook_widget['height'];
            $color_scheme = $facebook_widget['color_scheme'];
            $show_border            =	$facebook_widget['show_border'];
            $custom_css             =	$facebook_widget['custom_css'];
            $select_lng             =	$facebook_widget['select_lng'];
            echo $before_widget;
            if ($title)
                echo $before_title . $title . $after_title;

            wp_register_script('myownscript', FB_WIDGET_PLUGIN_URL . 'fb.js', array('jquery'));
            wp_enqueue_script('myownscript');
            $local_variables = array('app_id' => $app_id,'select_lng'=>$select_lng);
            wp_localize_script('myownscript', 'vars', $local_variables);
            echo '<div id="fb-root"></div>
            <div class="fb-like-box" data-href="'.$fb_url.'" data-width="'.$width.'" data-height="'.$height.'" data-colorscheme="'.$color_scheme.'" data-show-faces="'.$show_faces.'" data-header="'.$show_header.'" data-stream="'.$show_stream.'" data-show-border="'.$show_border.'" style="'.$custom_css.'"></div>';
            echo $after_widget;
        }
    }
    else {
        echo "Please configure Widget first..!!";
    }
}

add_shortcode('fb_widget','fb_plugin_shortcode');
?>