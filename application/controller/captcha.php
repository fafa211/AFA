<?php
/**
 * captcha 验证码图生成
 * @author zhengshufa
 * 
 */

class captcha_Controller extends Controller{

    public function index_Action(){
    
        echo Captcha::instance()->render(true);
    
    }
    public function default_Action($group = 'default'){
        
        Captcha::instance('default')->render(false);
        
    }
    
}