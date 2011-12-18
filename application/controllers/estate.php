<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Realestate search controller
 *
 * @version 1.0
 * @author Ibragimov "MpaK" Renat <info@mrak7.com>
 * @copyright Copyright (c) 2012, AOmega, http://aomega.ru
 */
class EstateController extends MY_Controller {
    /**
     * Views directory
     * 
     * @var string
     */
    protected $view = 'estate/';
    
    public function __construct(){
        parent::__construct();
        //$this->output->enable_profiler( TRUE );
        #$this->type->type = $this->type;
    }
    
    /**
     * Show search form on the main page
     */
    public function index(){
        $this->load->model( array('estate','type', 'country', 'city') );
        // list of object types
        $this->template->set( 'types', $this->estate->types_list() );
        // list of countries
        $this->template->set( 'countries', $this->estate->countries_list() );
        // list of rooms
        $this->template->set( 'rooms', $this->estate->rooms_list() );
        // list of stars
        $this->template->set( 'stars', $this->estate->stars_list() );
        // add JS script to layout
        $this->template->add_js( '/assets/js/search.js' );
        $this->template->add_js( '/assets/js/scrollpagination.js' );
                
        // render template and show layout
        $this->template->render_to( 'content', $this->view.'index' )->show();
    }
    
    /**
     * Get search results
     */
    public function ajax_search(){
        // @todo: delete in production
        error_reporting( E_ALL ^ E_NOTICE );
        $this->output->enable_profiler( FALSE );
        
        $data = array();        
        $this->load->model( array('estate') );
        
        $params = params( array(
            'country', 'city', 'type', 'rooms', 'stars', 'bar', 'pool', 'bath', 'shower',
            'cctv', 'internet', 'tv', 'parking'
        ));
        $data['results'] = $this->estate->search( $params );
        if( empty($data['results']) ){
            $response['status'] = 'info';
            $response['html']   = lang('msg_no_data');
        }else{
            $response['status'] = 'ok';
            $response['page']   = $params['page'];
            $response['html']   = $this->template->render( $this->view.'ajax_search', $data );
        }
        echo json_encode( $response );
    }
    
    /**
     * Get cities results for country
     */
    public function ajax_cities(){
        $country_id = param( 'country' );
    }
    
    /**
     * Show object's full information
     * 
     * @param integer $id 
     */
    public function object( $id ){
        
    }

}