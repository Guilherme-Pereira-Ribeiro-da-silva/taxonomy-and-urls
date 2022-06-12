<?php
/**
 * Url model class file
 *
 * @category Models
 * @package  Models
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */
 
/**
 * Url model class
 *
 * Defines it's relations with the other models and set validations for saving
 *
 * @category Models
 * @package  Modelss
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */

class Url extends MvcModel
{

    var $table = "{prefix}urls";
    var $belongs_to = array(
        'taxonomies' => array(
          'foreign_key' => 'taxonomy_id'
        )
    );
}
