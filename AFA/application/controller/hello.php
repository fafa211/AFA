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
        //$view->name = 'it is view function';
        $view->name = 'GIT Test!';
        $view->value = 'Github update!';
        
        $view->render(true);
        
        //$this->template->content = $view;
        
        //$this->template->render();
    }
    
    /**
     * view test template
     */
    public function template($name = ''){
        $view = new View('view');
        $view->name = $name?$name:'it is view function';
        $view->value = 'Github update!';
    
        $this->template->content = $view;
        $this->template->render();
    }
    
    /**
     * model test
     */
    public function model(){
        //添加新用户
//         $user = new User_Model();
//         $user->account = 'admin';
//         $user->passwd = md5($user->account.'123456');
//         $user->regtime = date('Y-m-d H:i:s');
//         $user->save();
        $user = new User_Model(1);
        echo $user->account;
        echo '<br />';
        
        $user2 = new User_Model();
        $user2->get('admin');
        
        echo $user2->passwd;
        echo '<br />';
        
    }
    
    /**
     * sql build test
     */
    public function sql(){
        
        $sql = new sql('UPDATE');
        
        $arr = array('passwd'=>md5('fafa654321'));
        echo $sql->table('user')->set($arr)->where(array('account'=>'fafa'));
        echo '<br />';
        echo sql::select('account,passwd,regtime,id', 'user', array('id'=>1))->limit(0,2)->groupby('account')->orderby('id desc');
        echo '<br />';
        echo sql::update()->table('user')->set(array('regtime'=>date('Y-m-d H:i:s')))->where(array('id'=>1));
        echo '<br />';
        echo sql::select('*', 'user');
        echo '<br />';
        echo sql::select('*', 'user as u')->in('u.id', array(1,3,'rtew'))->innerjoin('user_textinfo as ut', 'u.id = ut.user_id');
        echo '<br />';
        echo sql::select('*', 'user as u')->in('u.id', array(1))->innerjoin('user_textinfo as ut', 'u.id = ut.user_id')->limit(1)->or_c('id','=',3)->orderby('id desc');
        
        echo '<br />';
        echo sql::select('*', 'user as u')->where('id','>',1)->innerjoin('user_textinfo as ut', 'u.id = ut.user_id')->limit(1)->or_c('id','=',3)->and_c(array('id'=>1))->orderby('id desc');
        echo '<br />';
        echo sql::delete('user')->where('id','>',3)->orderby('id desc')->limit(1);
        
    }
}