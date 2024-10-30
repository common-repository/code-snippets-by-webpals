<?php
/**
 * Description of db_handler
 *
 * @author naty
 */

Define ( 'SHORTCODE_PLUGIN_TABLE_NAME' , 'HTML_code_snippets' );

class DB_handler {
    
    public function __construct() {
        $this->create_table();
    }
    
    public function create_table(){
        global $wpdb;
                        
        $sql = 'CREATE TABLE IF NOT EXISTS '.SHORTCODE_PLUGIN_TABLE_NAME.' (
                        id BIGINT(19) NOT NULL AUTO_INCREMENT,
                        post_id INT NOT NULL DEFAULT 0,                        
                        shortcode VARCHAR(32) NULL,
                        content_type VARCHAR(32) NULL,
                        content longtext NOT NULL,                        
                        PRIMARY KEY id (id)
                        )ENGINE = InnoDB;
                        ';
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
          $wpdb->query($sql);                         
    }
}
?>