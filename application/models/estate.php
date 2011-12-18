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
class Estate extends MY_Controller{
    protected
        $table = 'estates'
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
        return range( 1, $max );
    }
    
    public function rooms_list( $max=6 ){
        return range( 1, $max );
    }
    
}