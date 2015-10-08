<?php
/**
 * 框架使用实例
 * @author zhengshufa
 * 
 *
 */

class Hello_Controller extends Controller{
    
    /**
     * hello world
     */
    public function index(){
        echo 'Hello World!';
    }
    
    /**
     * view test
     */
    public function view(){
        $view = new View('view');
        $view->name = 'it is view function';
        
        $view->render(true);
        
        //$this->template->content = $view;
        
        //$this->template->render();
    }
}