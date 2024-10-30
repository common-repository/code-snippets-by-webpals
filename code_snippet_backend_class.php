<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of code_snippet_backend_class
 *
 * @author naty
 */

class code_snippet_backend_class {
   private $post_id;  
  
    static function add_plugin_meta_box() {
        // provide a list of usernames who can edit custom field definitions here
        $admins = array('admin','Webadmin');
        // get the current user
        $current_user = wp_get_current_user();
        // ONLY Admin should get the plugin
        if( in_array( $current_user->user_login, $admins ) ){
                $current_page_type = 'page';
                //$current_page_type will be used for adding meta box
                if ( !empty( $_REQUEST['post']) ){
                    $current_page_type = ( get_post_type ( $_REQUEST['post'] )  == 'post' ? 'post' : 'page');
                }
                $index =0;
                $post_shortcode_array = get_shortcode_array_by_post_id();
                wp_enqueue_script( 'code_snippets.js', plugins_url('code_snippets.js',__FILE__ ) );
                if (count( $post_shortcode_array ) == 0 ){
                    add_meta_box( 'code_snippets_display_backend_'.$index,'Code Snippets Plugin',array('code_snippet_backend_class','code_snippets_display_backend'),$current_page_type, 'normal','high');
                }else {
                    foreach ($post_shortcode_array as $short_code_instance){
                        $id = $short_code_instance->id;
                        add_meta_box( 'code_snippets_display_backend_'.$id,'Code Snippets Plugin',array('code_snippet_backend_class','code_snippets_display_backend'),$current_page_type, 'normal','high',$short_code_instance);
                        $index++;
                    }
                }
        }
    }
    
    static function code_snippets_display_backend( $post, $short_code_instance_args ){
        $shortcode ='';
        $content ='';
        if (!empty ($short_code_instance_args['args'])){
            $short_code_instance = $short_code_instance_args['args'];
            $id = $short_code_instance->id;
            $shortcode = $short_code_instance->shortcode;
            $content_type = $short_code_instance->content_type;
            $content = $short_code_instance->content;
        }

        //Adding a new meta box should be with id=0 (used on code_snippet_update_DB_by_id())
        if (empty ($id)){
            $id = 0;
        }       
    ?>           
        <div class="wrap">
            <div class="start_of_shortcode_widget">     
                    <?//2 Hidden fields: 1st for attaching ID to meta box (for saving in DB), 2nd for removing the meta box from DB ?>
                    <input class="hidden_id" type="hidden" name="code_snippet_plugin[<?=$id?>][id]" id="code_snippet_plugin[<?=$id?>][id]" value="<?=$id?>"/>
                    <input class="hidden_id_remove" type="hidden" name="code_snippet_plugin[<?=$id?>][remove_instance]" id="code_snippet_plugin[<?=$id?>][remove_instance]" value="false"/>	
                    
                <h4>
                    <label for="code_snippet_plugin[<?=$id?>][shortcode]">
                        Enter The Shortcode, Than 'Copy-Paste' The Generated Code To The Editor
                    </label>
                </h4>
                <span class="shortcode_container">  
                    <b>Short Code Name (without spaces):</b><br>
                    <input class="code_snippet_plugin_input" name="code_snippet_plugin[<?=$id?>][shortcode]" id="code_snippet_plugin[<?=$id?>][shortcode]" type="text" value="<?=$shortcode?>">			
                    <span class="shortcode_output">
                        <?
                            //Adds the shortcode format to be used in the "wysiwyg box" before JS activated (dynamically)
                            if (!empty ($shortcode) ){
                                echo '['.$shortcode.' shortcode="'.$shortcode.'"]';
                            }
                        ?>                        
                    </span>
                </span>                                                                    
                <h4>
                    <label for="code_snippet_plugin[<?=$id?>][content]">
                        <b>HTML code / Iframe / any kind of code:</b><br>
                    </label>
                </h4>
                <textarea class="code_snippet_plugin_input" style="width:520px;height:120px" name="code_snippet_plugin[<?=$id?>][content]" ><?=$content?></textarea>
                <br><br>
                <span class="snippet_code_add"><a class="button">Add Code Snippet</a></span>
                <span class="snippet_code_remove"><a class="button" title="Remove">Remove</a></span>
            </div>
        </div>      
        <span class="end_of_shortcode_widget"><div class="clear"></div></span>
    <?php

    }
    
    //Save each meta box data to DB by for each loop
    static function save_to_DB(){
        if (!empty ($_POST['code_snippet_plugin'])){
            foreach( $_POST['code_snippet_plugin'] as $short_code_elment ){
                code_snippet_update_DB_by_id($short_code_elment);
            }
        }
    }
}
?>