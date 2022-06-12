<?php

class TaxonomyAndUrlsLoader extends MvcPluginLoader {

    var $db_version = '1.0';
    var $tables = array();

    function activate() {
        global $wpdb;
        // This call needs to be made to activate this app within WP MVC

        $this->activate_app(__FILE__);

        // Perform any databases modifications related to plugin activation here, if necessary

        require_once ABSPATH.'wp-admin/includes/upgrade.php';

        add_option('taxonomy_and_urls_db_version', $this->db_version);

        // Use dbDelta() to create the tables for the app here
         $sql = 'CREATE TABLE IF NOT EXISTS `'.$wpdb->prefix.'taxonomy` (
            `id` int(11) NOT NULL auto_increment,
            `taxonomy_name` varchar(100) NOT NULL,
            `is_hierarchical` tinyint(1) NOT NULL,
            `label` varchar(100) NOT NULL,
            PRIMARY KEY  (id)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
         dbDelta($sql);

         $sql = 'CREATE TABLE IF NOT EXISTS `'.$wpdb->prefix.'urls` (
            `id` int(11) NOT NULL auto_increment,
            `taxonomy_id` int NOT NULL UNIQUE,
            `archive_permalink_suffix` varchar(250) NOT NULL UNIQUE,
            `single_permalink_suffix` varchar(250) NOT NULL UNIQUE,
            PRIMARY KEY  (id),
            FOREIGN KEY (taxonomy_id) REFERENCES '.$wpdb->prefix.'taxonomy(id)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
         dbDelta($sql);
    }

    function deactivate() {

        // This call needs to be made to deactivate this app within WP MVC

        $this->deactivate_app(__FILE__);

        // Perform any databases modifications related to plugin deactivation here, if necessary
        
    }

}
