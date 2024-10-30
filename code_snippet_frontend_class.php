<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of code_snippet_frontend_class
 *
 * @author naty
 */
class code_snippet_frontend_class {
    private $shortcode;
    
    //We use attribute 'shortcode' for transfering data from DB to frontend for supporting multipile shortcodes on one page
    static function code_snippet_display_code( $atts ){
        $shortcode = $atts['shortcode'];
        $post_id = get_the_ID();
        $shortcode_array = get_shortcode_by_post_id_and_shortcode ($post_id,$shortcode );
        return $shortcode_array[0]->content;
    }
    
    //Gets all post shortcode than register each one
    static function code_snippets_register_shortcodes(){
        $post_shortcodes = get_shortcode_array_by_post_id( get_the_ID() );
        if (!empty ($post_shortcodes) ){
            foreach ($post_shortcodes as $shortcode_object ){
                add_shortcode($shortcode_object->shortcode, array('code_snippet_frontend_class','code_snippet_display_code'));
            }
        }
    }        
}

?>