<?php
/*
Plugin Name: Code Injection For WYSIWYG 
Description: Adds a code snippet or an image to front-end. Can be used for rich media such as JS object, flash game, Utub code or HTML.
Author: Naty Haber
Version: 3.3
*/
    
    include_once 'plugin_functions.php';
    include_once 'db_handler.php';
    include_once 'code_snippet_backend_class.php';
    include_once 'code_snippet_frontend_class.php';
     
    //Creates a table if not exist for this plugin data (The name is set in db_handler.php as SHORTCODE_PLUGIN_TABLE_NAME
    register_activation_hook(__FILE__, array('DB_handler', 'create_table'));
    
    //Using 3 hooks for interacting with the plugins functions (add meta box on admin, save backend data and registering the shortcode 
    add_action( 'add_meta_boxes', array('code_snippet_backend_class', 'add_plugin_meta_box')); 
    add_action( 'save_post', array('code_snippet_backend_class', 'save_to_DB')); 
    add_action( 'the_post', array('code_snippet_frontend_class','code_snippets_register_shortcodes'));
    //add_action( 'the_content_by_customField', array('code_snippet_frontend_class','code_snippets_register_shortcodes'));
    
    //Register the shortcode to "work with" excerpt boxes as well as content boxes
    add_filter( 'the_excerpt', 'do_shortcode');
    
                
?>
