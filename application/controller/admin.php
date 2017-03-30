<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * Admin 微服务管理类, 管理员管理基础控制器
 * @author zhengshufa
 * @date 2016-09-13 15:20:55
 */
class Admin_Controller extends Controller
{

    /**
     * 执行前的准备与日志记录
     * @return boolean
     */
    public function before(){

        if($this->request->method == 'login' || $this->request->method == 'logout') return true;

        if(!Auth::instance()->logged_in()){
            common::redirect(input::uri('base').'admin/login');
        };

    }

    /**
     * 登录
     */
    public function login_Action(){

        if (input::post()) {

            $account = input::post('account');
            $passwd = input::post('passwd');

            if(Auth::instance()->login($account, $passwd)){
                common::redirect(input::uri('base').'admin/index', 302, $this->request->response);
            }else{
                $this->echomsg("登录失败,帐号或密码不正确.", (input::uri('base').'admin/login'), true);
            }
            return ;

        }
        $view = &$this->view;
        $view->set_view(APPPATH.'view/admin/login');
        $view->render();

    }

    /**
     * 退出
     */
    public function logout_Action(){
        Auth::instance()->logout(true, true);
        common::redirect(input::uri('base').'admin/login', 302, $this->request->response);
    }

    /**
     * 退出
     */
    public function index_Action(){
        $view = &$this->view;
        $view->set_view(APPPATH.'view/admin/index');
        $view->render();
    }

    /**
     * 左边菜单
     */
    public function left_Action(){
        $view = &$this->view;
        $view->set_view(APPPATH.'view/admin/left');
        $view->domain = input::uri('base');
        $view->render();
    }

    /**
     * 头部
     */
    public function head_Action(){
        $view = &$this->view;
        $view->set_view(APPPATH.'view/admin/head');
        $view->domain = input::uri('base');
        $view->render();
    }

    /**
     * 退出
     */
    public function home_Action(){
        $view = &$this->view;
        $view->set_view(APPPATH.'view/admin/home');
        $view->render();
    }



}
