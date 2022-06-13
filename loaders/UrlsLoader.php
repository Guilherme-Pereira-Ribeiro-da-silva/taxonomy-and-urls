<?php
/**
 * Urls Loader class file
 *
 * @category Loader
 * @package  Loader
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */
 
namespace Loader;

/**
 * Urls Loader class
 *
 * Creates all rewrite rules and redirects for the given urls
 *
 * @category Loader
 * @package  Loader
 * @author   Guilherme Pereira <guinovembro43@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     no link
 */

class UrlsLoader extends Loader
{
    private $taxonomies;

    /**
     * Loads all the urls and adds an action to set the rewrite rules
     * when it's time
     * 
     * @return void
     */
    public function __construct()
    {
        $this->data = $this->load_all('urls');
        add_action('template_redirect', array($this, 'set_standard_pages_redirects'));
    }

    /**
     * Loads all the urls and adds an action to set the rewrite rules
     * when it's time
     * 
     * @return void
     */
    public function create_custom_data($values=null)
    {
        $taxonomies = $values;
        $this->taxonomies = $taxonomies;

        if (!empty($taxonomies) && empty($this->data)) {
            throw new InvalidArgumentException('Erro ao carregar o plugin.Tente reativa-lo.');
        } 

        for ($i = 0;$i < count($taxonomies);$i++) {
            $this->_set_custom_rewrite_rules($taxonomies[$i], $this->data[$i]);
        }
        flush_rewrite_rules();
    }

    /**
     * Creates the rewrites rules for each taxonomy
     * 
     * @param array $taxonomy The taxonomy info
     * @param array $suffix The url info
     * 
     * @return void
     */
    private function _set_custom_rewrite_rules($taxonomy, $suffix) {
        $single_suffix_rule = !empty($suffix->single_permalink_suffix) ? 
            '.*?/?([a-z0-9_-]+)/'.$suffix->single_permalink_suffix.'/([a-z0-9_-]+)/?$':
            '.*?/?([a-z0-9_-]+)/([a-z0-9_-]+)/?$';
        $archive_suffix_rule = !empty($suffix->archive_permalink_suffix) ? 
            '.*?/?([a-z0-9_-]+)/'.$suffix->archive_permalink_suffix.'/?$' : '.*?/?([a-z0-9_-]+)/?$';

        
        add_rewrite_rule($single_suffix_rule, 'index.php?name=$matches[2]', 'top');
        add_rewrite_rule($archive_suffix_rule, 'index.php?taxonomy='.$taxonomy->taxonomy_name.'&term=$matches[1]', 'top');
        $single_without_taxonomy_rule = '/?['.implode('|', wp_list_pluck($this->data, 'single_permalink_suffix')).']+'.
        '/([a-z0-9_-]+)/?$';
        add_rewrite_rule($single_without_taxonomy_rule, 'index.php?name=$matches[1]', 'top');
    }

    /**
     * Create the redirects for each taxonomy
     * 
     * @return void
     */
    public function set_standard_pages_redirects() 
    {
        global $wp;
        $current_url = home_url($wp->request);
        for ($i = 0;$i < count($this->taxonomies);$i++) {
            $suffix = $this->data[$i];
            //$terms = get_terms(array('taxonomy' => $this->taxonomies[$i]->taxonomy_name, 'hide_empty' => false));
            if (is_archive()) {
                global $wp_query;
                $tax = $wp_query->get_queried_object();

                $this->_archives_redirect($i, $current_url, $suffix, $tax->name);
            } else if (is_single()) {
                $terms = get_the_terms(get_the_ID(), $this->taxonomies[$i]->taxonomy_name);
                if (has_term('', $this->taxonomies[$i]->taxonomy_name)) {
                    $this->_singles_with_taxonomy_redirect($wp->request, $current_url, $suffix, $terms);
                } else {
                    $this->_singles_without_taxonomy_redirect($suffix);
                }
            }
        }
        flush_rewrite_rules();
    }

    /**
     * Redirects to the correct archive page url if the old archive page url
     * is given
     * 
     * @param int $i the current taxonomy index 
     * @param string $current_url the current url
     * @param array $suffix the url info
     * @param array $terms the current taxonomy terms
     * 
     * @return void
     */
    private function _archives_redirect($i, $current_url, $suffix, $term)
    {
        $archive_suffix_rule = "/".$this->taxonomies[$i]->taxonomy_name.'\/.*?\/?';
        $archive_suffix_rule .= "(".$term.")\/?/";
        $archive_suffix_rule_redirect = $this->_get_parent_taxonomies($term)
        . $suffix->archive_permalink_suffix;
        //throw new \Exception($archive_suffix_rule_redirect);
        if (preg_match($archive_suffix_rule, $current_url)) {
            wp_redirect(home_url($archive_suffix_rule_redirect));
            die;
        }
    }

    /**
     * Redirects to the correct single page with taxonomies url if 
     * the old single page urls given
     * 
     * @param string $relative_permalink the current url without teh root domain
     * @param string $current_url the current url
     * @param array $suffix the url info
     * @param array $terms the current taxonony taxonomy terms 
     * 
     * @return void
     */
    private function _singles_with_taxonomy_redirect($relative_permalink, $current_url, $suffix, $terms) {
        $current_permalink = get_option('permalink_structure');
        $current_permalink_array = array_values(array_filter(explode('/', $relative_permalink)));
        $standard_permalink = array_values(array_filter(explode('/', $current_permalink)));
        if (count($current_permalink_array) !== count($standard_permalink)) {
            return;
        }

        $post_name_position = array_search('%postname%', $standard_permalink);
        $single_suffix_rule = [];
        for ($j = 0;$j < count($standard_permalink);$j++) {
            $single_suffix_rule[] = '([a-z0-9_-]+)'; 
        }
        $single_suffix_rule = '/'.implode('\/', $single_suffix_rule).'/';
        $post_name = $current_permalink_array[$post_name_position];
        $suffix_without_taxonomies = "$suffix->single_permalink_suffix/$post_name";
        $single_suffix_rule_redirect = $this->_get_parent_taxonomies($terms[0]).$suffix->single_permalink_suffix."/$post_name";
        
        if (preg_match($single_suffix_rule, $current_url)) {
            wp_redirect(home_url($single_suffix_rule_redirect));
            die;
        }
    }

    /**
     * Redirects to the correct single page without taxonomies url if 
     * the old single page urls given
     * 
     * @param array $suffix the url info
     * 
     * @return void
     */
    private function _singles_without_taxonomy_redirect($suffix) {
        global $post;
        $page_name = $post->post_name;
        global $wp;
        $relative_url = "$suffix->single_permalink_suffix/$page_name";
        if ($relative_url !== $wp->request) {
            wp_redirect(home_url($relative_url));
            die;
        }
    }

    /**
     * Get the hierarchical url for the given term
     * 
     * @param array $term the taxonomy term name
     * 
     * @return string
     */
    private function _get_parent_taxonomies($term=null) 
    {
        if (empty($term)) {
            return '';
        }

        $path = "$term->slug/";
        while ($term->parent != 0) {
            $term = get_term($term->parent);
            $path = "$term->slug/$path";
        }
        return $path;
    }
}