<?php

defined('AFA') or die('No AFA PHP Framework!');

/**
 * blog模型控制器
 * 
 * @author zhengshufa
 *         @date 2015-10-19 14:56:59
 */
class blog_Controller extends Controller
{

    private $vdir = 'blog/';

    private $sex_arr = 'a:4:{i:1;s:15:"十足的男性";i:2;s:15:"十足的女性";i:3;s:33:"有时呈男性，有时呈女性";i:4;s:33:"既不呈男性，也不呈女性";}';

    private $love_arr = 'a:5:{i:1;s:15:"无尽的编程";i:2;s:15:"无尽的游玩";i:3;s:15:"无尽的睡觉";i:4;s:15:"无尽的发呆";i:5;s:15:"无尽的购物";}';

    private $salary_arr = 'a:3:{i:1;s:16:"月薪1000以下";i:2;s:18:"月薪1000 ~ 10000";i:3;s:17:"月薪10000以上";}';

    /**
     * 新增blog
     */
    public function add()
    {
        if (input::post()) {
            $post = input::post();
            $blog = new blog_Model();
            foreach ($post as $k => $v) {
                $blog->$k = is_array($v) ? join(',', $v) : $v;
            }
            $blog->save();
            $this->echomsg('新增成功!', 'lists');
        }
        $view = new View($this->vdir . 'add');
        $view->render();
    }

    /**
     * 删除blog
     */
    public function delete($id)
    {
        $blog = new blog_Model($id);
        if ($blog->id) {
            $blog->delete($id);
            $this->echomsg('删除成功!', '../lists');
        } else {
            $this->echomsg('删除失败!', '../lists');
        }
    }

    /**
     * 修改blog
     */
    public function edit($id)
    {
        $blog = new blog_Model($id);
        if (input::post()) {
            $post = input::post();
            foreach ($post as $k => $v) {
                $blog->$k = is_array($v) ? join(',', $v) : $v;
            }
            $blog->save();
            $this->echomsg('修改成功!', '../lists');
        }
        $view = new View($this->vdir . 'edit');
        $view->blog = $blog;
        $view->render();
    }

    /**
     * 列表管理 blog
     */
    public function lists()
    {
//         F::load('user', 'user_Model');
//         $user = new user_Model(5);
        $user = F::object('user', 'user_Model', 5);
        
        F::load('user', 'u');
        u::dot(1000);
        
        $blog = new blog_Model();
        $view = new View($this->vdir . 'lists');
        $view->lists = $blog->lists('0,10');
        $view->sex_arr = unserialize($this->sex_arr);
        $view->love_arr = unserialize($this->love_arr);
        $view->salary_arr = unserialize($this->salary_arr);
        $view->list_fields_arr = array(
            'id',
            'title',
            'author',
            'ctime',
            'email',
            'sex',
            'love',
            'salary'
        );
        $view->render();
    }

    /**
     * 展示blog
     */
    public function show($id)
    {
        $blog = new blog_Model($id);
        $view = new View($this->vdir . 'show');
        $view->blog = $blog;
        $view->sex_arr = unserialize($this->sex_arr);
        $view->love_arr = unserialize($this->love_arr);
        $view->salary_arr = unserialize($this->salary_arr);
        $view->render();
    }
}
