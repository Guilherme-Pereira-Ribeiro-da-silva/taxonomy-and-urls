<?php
/**
 * Taxonomy model class file
 *
 * @category Models
 * @package  Models
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */
 
/**
 * Taxonomy model class
 *
 * Defines it's relations with the other models and set validations for saving
 *
 * @category Models
 * @package  Models
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */

class Taxonomy extends MvcModel
{
    var $table = "{prefix}taxonomy";
    var $has_many = array(
        'url' => array(
          'dependent' => true
        )
      );

    var $validate = array(
        'taxonomy_name' => array(
          'pattern' => '/^[a-z]{1,32}$/',
          'message' => 'O nome da taxonomia deve conter apenas letras 
          minúsculas e deve possuir entre 1 e 32 letras',
        ),
        'label' => array(
            'pattern' => '/^[a-zA-Z]{1,32}$/',
            'message' => 'O título da taxonomia deve possuir entre 1 e 32 letras',
        ),
    );
}
