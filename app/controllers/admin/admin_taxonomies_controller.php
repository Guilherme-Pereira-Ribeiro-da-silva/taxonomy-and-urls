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
 * AdminTaxonomiesController class
 *
 * Receives the request from the router, asks the model to save taxonomy
 * information and send info to the views
 *
 * @category Controllers
 * @package  Controllers
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */

class AdminTaxonomiesController extends MvcAdminController
{
    var $default_columns = array('taxonomy_name', 'label', 'is_hierarchical','id');

    /**
     * When the user enters the add taxonomy page, or tries to
     * create a new taxonomy, this function is called through the router. 
     * If the user wants to see the page, call the view, otherwise
     * verify if everything is ok and save
     * 
     * @return void
     */
    public function add() 
    {
        if (!empty($this->params["data"]["Taxonomy"])) {
            $message_success = "A taxonomia foi criada com sucesso";
            $message_failure = "Houve um erro e não foi possível criar a taxonomia.Tente novamente mais tarde";
            $this->_add_or_edit($message_success, $message_failure);
        }
    }

    /**
     * When the user enters the edit taxonomy page, or tries to
     * edit taxonomy, this function is called through the router. 
     * If the user wants to see the page, call the view, otherwise
     * verify if everything is ok and edit
     * 
     * @return void
     */
    public function edit()
    {
        if (!empty($this->params["data"]["Taxonomy"])) {
            $message_success = "A taxonomia foi editada com sucesso";
            $message_failure = "Houve um erro e não foi possível editar a taxonomia.Tente novamente mais tarde";
            $this->_add_or_edit($message_success, $message_failure);
        } else {
            $this->set_object();
        }
    }

    /**
     * When the user enters the delete taxonomy route, 
     * this function is called through the router.Tries
     * to get the given id and delete the corresponding
     * register through the model
     * 
     * @return void
     */
    public function delete() 
    {
        $params = $this->params;
        try{
            if (!empty($this->params["id"])) {
                $this->model->delete($params["id"]);
                $results = $this->model->find(
                    array(
                        'conditions' => array(
                            'id' => $params["id"]
                        )
                    )
                );
                if (count($results) > 0) {
                    throw new Exception('Não foi possível deletar a Taxonomia.Tente novamente mais tarde.');
                }
                $this->flash('notice', 'Taxonomia deletada com sucesso');
            } else {
                throw new Exception('O ID não da taxonomia não foi passado.Tente novamente.');
            }
        }catch(Exception $e){
            $this->flash('error', $e->getMessage());
        }finally{
            $url = MvcRouter::admin_url(array('controller' => $this->name, 'action' => 'index'));
            $this->redirect($url);
        }
    }

    /**
     * Verifies if the user is trying to create a new taxonomy or editing 
     * one that already exists and then save it through the model.
     * 
     * @param string $message_success Message to be displayed if sucessefully saves
     * @param string $message_failure Message to be displayed if it fails
     * 
     * @return void
     */
    private function _add_or_edit($message_success, $message_failure)
    {
        if (!empty($this->params["data"])) {
            $params = $this->params["data"]["Taxonomy"];
            try{
                $this->model->save($this->params["data"]);
                $results = $this->model->find(
                    array(
                        'conditions' => array(
                            'taxonomy_name' => $params["taxonomy_name"]
                        )
                    )
                );
                if (!count($results) > 0) {
                    throw new Exception($message_failure);
                }
                $this->_call_url_controller($params, $results[0]);
                $this->flash('notice', $message_success);
            }catch(Exception $e){
                $this->flash('error', $e->getMessage());
            }finally{
                $this->refresh();
            }
        }
    }

    /**
     * After creating a taxonomy, tries to create its corresponding urls
     * If successful, saves the urls, otherwise deletes the just created
     * taxonomy.
     * 
     * @param array  $params of the request
     * @param string $taxonomy taxonomy which parameters will be added to
     * 
     * @return void
     */
    private function _call_url_controller($params, $taxonomy) {
        $url_controller = new AdminUrlsController();
        if (!$url_controller->add_standard_permalinks($taxonomy)) {
            $this->model->delete_all(
                array(
                    'conditions' => array(
                        'taxonomy_name' => $params["taxonomy_name"]
                    )
                )
            );
            throw new Exception('Não foi possível salvar os permalinks padrões.Tente mais tarde.');
        };
    }
}
