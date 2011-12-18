<?php

/**
 * Cities table model
 *
 * @version 1.0
 * @author Ibragimov "MpaK" Renat <info@mrak7.com>
 * @copyright Copyright (c) 2012, AOmega, http://aomega.ru
 */
class City extends MY_Model{
    protected $table = 'cities';
    
    public function __construct(){
        parent::__construct();
    }
    
}