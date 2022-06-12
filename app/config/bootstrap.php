<?php 
/**
 * Config file
 *
 * @category Config
 * @package  Config
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */

MvcConfiguration::set(
    array(
      'Debug' => false
    )
);

MvcConfiguration::append(
    array(
      'AdminPages' => array(
        'taxonomies' => array(
          'label' => 'Taxonomias',
          'index' => array('label' => 'Ver taxonomias'),
          'add' => array('label' => 'Nova taxonomia'),
          'edit' => array('in_menu' => false),
          'delete' => array('in_menu' => false),
        ),
        'urls' => array(
          'label' => 'Permalinks',
          'index' => array('label' => 'Ver Permalinks'),
          'edit' => array('in_menu' => false),
          'delete' => array('in_menu' => false),
        )
      )
    )
);

add_action('mvc_admin_init', 'enqueue_styles');

/**
 * Enqueue the css styles so they can be used later
 * 
 * @return void
 */
function enqueue_styles() 
{
    wp_register_style('main', mvc_css_url('taxonomy-and-urls', 'main'));
    wp_enqueue_style('main');
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');
}