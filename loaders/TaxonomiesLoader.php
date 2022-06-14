<?php
/**
 * Loader class file
 *
 * @category Loader
 * @package  Loader
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */
 
namespace Loader;

/**
 * Taxonomy Loader class
 *
 * Creates all stored taxonomies and class the urls loader to set the
 * rewrite rules
 *
 * @category Loader
 * @package  Loader
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */

class TaxonomiesLoader extends Loader
{
    private $_urls_loader;

    /**
     * Loads all taxonomies from database and creates an action
     * to call for their creation when it's time
     * 
     * @param UrlsLoader $urls_loader The UrlLoader class instance
     * 
     * @return void
     */
    public function __construct($urls_loader)
    {
        global $wpdb;
        $table_already_exists = $wpdb->get_results("SELECT COUNT(1) as table_exists FROM information_schema.tables WHERE table_schema='{$wpdb->dbname}' AND table_name='{$wpdb->prefix}taxonomy';")[0]->table_exists;

        if ($table_already_exists) {
            $this->data = $this->load_all('taxonomy');
            $this->_urls_loader = $urls_loader;
            add_action('init', array($this,'create_custom_data'));
        }
    }

    /**
     * Creates all taxonomies so the user can see and use them
     * 
     * @param $values the taxonomies
     * 
     * @return void
     */
    public function create_custom_data($values=null) 
    {
        try{
            foreach ($this->data as $taxonomy) {
                $args = array(
                    'hierarchical' => $taxonomy->is_hierarchical,
                    'label' => $taxonomy->label,
                    'show_ui'           => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
                    'show_in_rest' => true,
                    "show_in_menu" => true,
                    "show_in_nav_menus" => true,
                    "rewrite" => array( 'slug' => "$taxonomy->label", 'with_front' => false, 'hierarchical' => true),
                );
                register_taxonomy($taxonomy->taxonomy_name, array( 'post' ), $args);
            }
            $this->_urls_loader->create_custom_data($this->data);
        }catch(Exception $e){
            die($e->getMessage());
        }
        
    }
}
