<?php
    
    function activate_db_handler(){
        $db_handler = new DB_handler();
    }
    
    function get_shortcode_array_by_post_id( $post_id='' ){
        global $wpdb;
        
        if ( empty ($post_id ) && !empty($_GET['post']) ){
            $post_id = $_GET['post'];;
        }
        if (!empty ($post_id) ){
            $sql = 'SELECT * From '.SHORTCODE_PLUGIN_TABLE_NAME.' WHERE post_id ='.$post_id;
            $post_shortcode_array = $wpdb->get_results($sql);
            return $post_shortcode_array;
        }
    }
    
    function get_shortcode_array_by_id( $id ){
        global $wpdb;
       
        $sql = 'SELECT * From '.SHORTCODE_PLUGIN_TABLE_NAME.' WHERE id ="'.$id.'"';
        $post_shortcode_array = $wpdb->get_results($sql);
        return $post_shortcode_array;
    }
       
    function code_snippet_update_DB_by_id( $row_array ){
        global $wpdb;
        
        if ( empty ($post_id)){
            $post_id = $_POST['post_ID'];;
        }
        if (!empty ($row_array)){
            $id = $row_array['id'];
            $shortcode = $row_array['shortcode'];
            $content = $row_array['content'];
            $remove_instance = $row_array['remove_instance'];

            if ( $remove_instance == 'true'){
                $sql = 'DELETE FROM '.SHORTCODE_PLUGIN_TABLE_NAME.' WHERE id="'.$id.'"';
                $wpdb->query($sql);
            }
            //Check if we need to insert a new row on DB or update an old one
            else if ( $id == 0 ){
                $sql = 'INSERT INTO '.SHORTCODE_PLUGIN_TABLE_NAME.' (post_id, shortcode, content) VALUES ( "'.$post_id.'","'.$shortcode.'","'.$content.'")';
                $wpdb->query($sql);
            }else{
                $sql = 'UPDATE '.SHORTCODE_PLUGIN_TABLE_NAME.' SET shortcode = "'.$shortcode.'", content = "'.$content.'" WHERE id ='.$id;
                $wpdb->query($sql);
            }
        }
    } 
    
     function get_shortcode_by_post_id_and_shortcode( $post_id, $shortcode ){
        global $wpdb;
       
        $sql = 'SELECT * From '.SHORTCODE_PLUGIN_TABLE_NAME.' WHERE post_id ="'.$post_id.'" AND shortcode="'.$shortcode.'" LIMIT 1';
        $post_shortcode_array = $wpdb->get_results($sql);
        return $post_shortcode_array;
    }
?>