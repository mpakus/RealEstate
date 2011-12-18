<?php

/**
 * Countries table model
 *
 * @version 1.0
 * @author Ibragimov "MpaK" Renat <info@mrak7.com>
 * @copyright Copyright (c) 2012, AOmega, http://aomega.ru
 */
class Country extends MY_Model{
    protected $table = 'countries';
    
    public function __construct(){
        parent::__construct();
    }
    
}