//jQuery(document).ready(function(){
            jQuery('.shortcode_container input').on('keyup',function(){
               var shortcode = '[' + jQuery(this).val() + ' shortcode="'+jQuery(this).val()+'"]';
              // console.log(shortcode);
               jQuery(this).parent().find('.shortcode_output').html(shortcode);
            });

    var snippet_plugin_counter = 1;
    jQuery('.snippet_code_add a').on('click',function(){
        //Change hidden input id
        var new_obj_warp = jQuery(this).parents('.postbox').clone(); 
        new_obj_warp.attr('id',snippet_plugin_counter);
        new_obj_warp.children().find('.hidden_id').attr('id',snippet_plugin_counter);
        
        
        //change 2 input fields "name" attribute
        new_obj_warp.children().find('input.code_snippet_plugin_input').attr('name','code_snippet_plugin['+snippet_plugin_counter+'][shortcode]');
        new_obj_warp.children().find('input.code_snippet_plugin_input').attr('value','');
        new_obj_warp.children().find('textarea.code_snippet_plugin_input').attr('name','code_snippet_plugin['+snippet_plugin_counter+'][content]');
        
        //Add new meta box
        new_obj_warp.children().find('textarea.code_snippet_plugin_input').attr('value','');       
         jQuery(this).parents('.postbox').after(new_obj_warp); 
        snippet_plugin_counter ++;
    });
    
    jQuery('.snippet_code_remove').on('click',function(){
       jQuery(this).parents('.postbox').hide();
       jQuery(this).parent().children('.hidden_id_remove').attr('value','true');       
    });
    
//});