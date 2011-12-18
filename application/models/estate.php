<?php

/**
 * Realestate data model
 *
 * @version 1.0
 * @author Ibragimov "MpaK" Renat <info@mrak7.com>
 * @copyright Copyright (c) 2012, AOmega, http://aomega.ru
 * @property string $table 
 * @property Type   $type
 */
class Estate extends MY_Model{
    protected
        $table = 'estates',
        $limit = 30
     ;
    
    
    public function __construct(){
        parent::__construct();
        //$this->type = get_instance()->type;
    }
    
    /**
     * Get cached list of realestate types
     * 
     * @return array
     */
    public function types_list(){
        if( ! $list = $this->cache->get( 'type-find' ) ){
            $list = $this->type->order_by( 'type', 'ASC' )->find();
            $list = up_array( $list, 'type' );        
            $this->cache->save( 'type-find', $list, QCACHE_TIME );
        }
        $list[0] = lang('select_all');
        return $list;
    }

    /**
     * Get cached list of countries
     * 
     * @return type 
     */
    public function countries_list(){
        if( ! $list = $this->cache->get( 'country-find' ) ){
            $list = $this->country->order_by( 'country', 'ASC' )->find();
            $list = up_array( $list, 'country' );        
            $this->cache->save( 'country-find', $list, QCACHE_TIME );
        }
        $list[0] = lang('select_all');
        return $list;        
    }
    
    public function stars_list( $max=5 ){
        $list = range( 1, $max );
        array_unshift( $list, lang('select_everything') );  
        return $list;
    }
    
    public function rooms_list( $max=6 ){
        $list = range( 1, $max );
        array_unshift( $list, lang('select_everything') );  
        return $list;
    }
    
    public function search( $params=array() ){
        // relations
        if( !empty($params['type']) ) $this->db->where( 'type_id', $params['type'] );
        if( !empty($params['city']) ) $this->db->where( 'city_id', $params['city'] );
                
        // equals
        if( !empty($params['rooms']) ) $this->db->where( 'rooms', $params['rooms'] );
        if( !empty($params['stars']) ) $this->db->where( 'stars', $params['stars'] );
        
        // flags
        if( !empty($params['bar']) )      $this->db->where( 'bar', 1 );
        if( !empty($params['pool']) )     $this->db->where( 'pool', 1 );
        if( !empty($params['bath']) )     $this->db->where( 'bath', 1 );
        if( !empty($params['shower']) )   $this->db->where( 'shower', 1 );
        if( !empty($params['cctv']) )     $this->db->where( 'cctv', 1 );
        if( !empty($params['internet']) ) $this->db->where( 'intertnet', 1 );
        if( !empty($params['tv']) )       $this->db->where( 'tv', 1 );
        if( !empty($params['parking']) )  $this->db->where( 'parking', 1 );
        
        $page = isset($params['page']) ? $params['page'] * $this->limit : 0;
        
        return $this->find( NULL, $this->limit, $page );
    }
    
}