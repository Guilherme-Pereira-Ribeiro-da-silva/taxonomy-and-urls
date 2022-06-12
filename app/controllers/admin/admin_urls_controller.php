<?php
/**
 * Urls controller class file
 *
 * @category Controllers
 * @package  Controllers
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */
 
/**
 * AdminUrlsController class
 *
 * Receives the request from the router, asks the model to save url information and 
 * send info to the views
 *
 * @category Controllers
 * @package  Controllers
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */

class AdminUrlsController extends MvcAdminController
{

    var $default_columns = array('id', 'single_permalink', 'archive_permalink');

    /**
     * Loads all taxonomies and sends it to the index view 
     * 
     * @return void
     */
    public function index() 
    {
        $this->load_model('taxonomy');
        $taxonomies = $this->taxonomy->find();
        $this->set('taxonomies', $taxonomies);
        $this->set_objects();
    }

    /**
     * Tests if it's a request for edition or if it's just for showing the edit page,
     * if it's a request: validates it and if sucessful save; if it fails send message.
     * if ask for showing page: calls view and sends information
     * 
     * @return void
     */
    public function edit() 
    {
        $params = $this->params["data"]["Url"];
        if (!empty($params)) {
            try{
                $already_exists = count(
                    $this->model->find(
                        array(
                            'conditions' => array(
                                'OR' => array(
                                    'single_permalink_suffix' => $params["single_permalink_suffix"],
                                    'archive_permalink_suffix' => $params["archive_permalink_suffix"]
                                )
                            )
                        )
                    )
                ) > 0;

                if ($already_exists) {
                    throw new InvalidArgumentException("Não pode existir nenhum outro permalink com esta mesma estrutura, tente com outro ainda não usado.");
                }

                $this->model->save($this->params["data"]);

                $this->flash('notice', 'Urls Editadas com sucesso');
            }catch(Exception $e){
                $this->flash('error', $e->getMessage());
            }finally{
                $this->refresh();
            }
        } else {
            $this->set_object();
        }
    }

    /**
     * Creates one standard urls register in this model for the given taxonomy
     * Returns true if sucessfully registers, false otherwise
     * 
     * @param array $taxonomy The taxonomy information
     * 
     * @return bool
     */
    public function add_standard_permalinks($taxonomy)
    {
        $this->model->save(
            array(
            'taxonomy_id' => $taxonomy->id,
            'single_permalink_suffix' => 'noticias',
            'archive_permalink_suffix' => 'noticias'
            )
        );

        $results = $this->model->find(
            array(
                'conditions' => array(
                    'taxonomy_id' => $taxonomy->id
                )
            )
        );

        return count($results) > 0;
    }
}
