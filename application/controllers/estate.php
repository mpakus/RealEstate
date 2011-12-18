<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Realestate search controller
 *
 * @version 1.0
 * @author Ibragimov "MpaK" Renat <info@mrak7.com>
 * @copyright Copyright (c) 2012, AOmega, http://aomega.ru
 */
class Estate extends MY_Controller {
    /**
     * Views directory
     * 
     * @var string
     */
    protected $view = 'estate/';
    
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
        $this->template->render_to( 'content', $this->view.'index' )->show();
    }
    
    
    public function _ajax(){
        
    }

}