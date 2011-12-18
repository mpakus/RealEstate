<?php
define( 'QCACHE_TIME', 600 );   // 10 min.

/**
 * Our front-end controller
 *
 * @version 1.0
 * @author Ibragimov "MpaK" Renat <info@mrak7.com>
 * @copyright Copyright (c) 2009-2012, AOmega, http://aomega.ru
 */
class MY_Controller extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        date_default_timezone_get( 'Asia/Bangkok' );    // timezone (default: php.ini date.timezone)
        mb_internal_encoding( 'UTF-8' );  // everythin in UTF-8
        ini_set( 'default_charset', 'UTF-8' );
        // load cache driver, cache to file system
        $this->load->driver( 'cache', array('adapter' => 'file') );
        // load russian default language file
        $this->lang->load( 'default', 'russian' );
    }
    
}