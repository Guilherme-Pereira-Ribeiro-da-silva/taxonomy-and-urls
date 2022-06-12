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
 * Loader class
 *
 * Sets a model of what a model should have so it's children can inherit it's
 * methods and properties
 *
 * @category Loader
 * @package  Loader
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */

abstract class Loader
{
    public $data;
    
    /**
     * Loads all data from the given tabel
     * 
     * @param string $table The name of the table
     * 
     * @return array
     */
    protected function load_all($table)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}$table");
    }

    /**
     * Children classes will use it for seeting the rewrite rules
     * 
     * @param string $values the taxonomies
     * 
     * @return array
     */
    public function create_custom_data($values=null)
    {
        
    }
}