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
        $this->template->add_js( '/assets/js/waypoints.min.js' );
                
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
            'cctv', 'internet', 'tv', 'parking', 'page'
        ));
        $data['results'] = $this->estate->search( $params );
        if( empty($data['results']) ){
            $response['status'] = 'info';
            $response['html']   = lang('msg_no_data');
        }else{
            $response['status'] = 'ok';
            $page = empty($params['page']) ? 0 : $params['page'];
            $page++;
            $response['page']   = $page;
            $data['page']       = $page;
            $response['html']   = $this->template->render( $this->view.'ajax_search', $data );
        }
        echo json_encode( $response );
    }
    
    /**
     * Get cities results for country
     */
    public function ajax_cities(){
        error_reporting( E_ALL ^ E_NOTICE );
        $this->output->enable_profiler( FALSE );

        $data = array();        

        $country_id = param( 'country' );
        
        if( !empty( $country_id) ){
            // load models if we need them
            $this->load->model( array('estate', 'city') );
            
            // find all cities
            $data['cities'] = $this->estate->find_cities( $country_id );
        
            if( empty($data['cities']) ){
                $response['status'] = 'error';
                $response['html']   = lang('err_no_cities');
            }else{
                $response['status'] = 'ok';
                $response['html']   = $this->template->render( $this->view.'ajax_cities', $data );
            }
        }else{
            $response['status'] = 'ok';
            $response['html']   = $this->template->render( $this->view.'ajax_cities_empty', $data );
        }
        echo json_encode( $response );        
    }
    
    /**
     * Show object's full information
     * 
     * @param integer $id 
     */
    public function show( $id='' ){
        $data = array();
        if( empty($id) ) show_404 ();
        
        $this->load->model( array('estate', 'photo', 'city', 'country') );
        
        $data['object'] = $this->estate->find_object( $id );
        if( empty($data['object']) ) show_404();
        
        $this->template->add_css( '/assets/fancybox/jquery.fancybox.css' );
        $this->template->add_js ( '/assets/fancybox/jquery.fancybox.pack.js' );
        $this->template->add_js ( '/assets/js/show.js' );
        
        $this->template->render_to( 'content', $this->view.'show', $data )->show();        
    }

}