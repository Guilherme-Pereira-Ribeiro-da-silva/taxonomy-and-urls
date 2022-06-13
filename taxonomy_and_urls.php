<?php
/**
 * Main file
 *
 * @category App
 * @package  App
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */
 
/* 
Plugin Name: Taxonomy and urls
Plugin URI: https://github.com/Guilherme-Pereira-Ribeiro-da-silva/
Description: This plugin will be responsible for allowing you to create a new taxonomy and rewriting the urls of the posts
Author: Guilherme Pereira
Version: 0.0.2
Author URI: https://github.com/Guilherme-Pereira-Ribeiro-da-silva/
*/
require_once 'vendor/autoload.php';

use Loader\TaxonomiesLoader;
use Loader\UrlsLoader;

register_activation_hook(__FILE__, 'taxonomy_and_urls_activate');
register_deactivation_hook(__FILE__, 'taxonomy_and_urls_deactivate');

/**
 * Makes the activation configurations when it's time
 * 
 * @return void
 */
function taxonomy_and_urls_activate() 
{
    global $wp_rewrite;
    require_once dirname(__FILE__).'/taxonomy_and_urls_loader.php';
    $loader = new TaxonomyAndUrlsLoader();
    $loader->activate();
    $wp_rewrite->set_permalink_structure('%postname%');
    $wp_rewrite->flush_rules(true);
}

/**
 * Makes the deactivation configurations when it's time
 * 
 * @return void
 */
function taxonomy_and_urls_deactivate() 
{
    global $wp_rewrite;
    require_once dirname(__FILE__).'/taxonomy_and_urls_loader.php';
    $loader = new TaxonomyAndUrlsLoader();
    $loader->deactivate();
    $wp_rewrite->flush_rules(true);
}

if (class_exists('Loader\TaxonomiesLoader') && class_exists('Loader\UrlsLoader')) {
    new TaxonomiesLoader(new UrlsLoader());
} else {
    die;
}
