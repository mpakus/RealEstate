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
    
    /**
     * List of stars
     * 
     * @param  integer $max
     * @return array
     */
    public function stars_list( $max=5 ){
        $list = range( 1, $max );
        array_unshift( $list, lang('select_everything') );  
        return $list;
    }
    
    /**
     * List of rooms
     * 
     * @param  integer $max
     * @return array 
     */
    public function rooms_list( $max=6 ){
        $list = range( 1, $max );
        array_unshift( $list, lang('select_everything') );  
        return $list;
    }
    
    /**
     * Search procedure
     * 
     * @param  array $params
     * @return array
     */
    public function search( $params=array() ){
        // @todo: $key = implode('-', $params) for cache
        
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
    
    /**
     * Find all cities by the Country_id
     * 
     * @param type $country_id
     * @return type 
     */
    public function find_cities( $country_id='' ){
        if( empty($country_id) ) return array();
        $key = 'city-find-'.$country_id;
        
        if( ! $list = $this->cache->get( $key ) ){
            $cities = $this->city->where( 'country_id', $country_id )->find();
            $this->cache->save( $key, $cities, QCACHE_TIME );
        }
            
        return $cities;
    }
    
    /**
     *
     * @param type $id
     * @return array
     */
    public function find_object( $id ){
        
        $key = 'estate-find_object-'.$id;
        
        // @todo: try to make variant with BIG JOINS
        if( ! $list = $this->cache->get( $key ) ){
            $object = $this->find( $id, 1 );  // select * from $this->table limit 1
            $object['city']    = $this->city->find( (int)$object['city_id'], 1 );
            $object['country'] = $this->country->find( (int)$object['city']['country_id'], 1 );
            // all photos for this object
            $object['photos']  = $this->photo->where( 'estate_id', (int)$object['id'] )->find();
            
            $this->cache->save( $key, $object, QCACHE_TIME );
        }
               
        return $object;
    }
    
}