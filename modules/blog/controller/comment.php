<?php

defined('AFA') or die('No AFA PHP Framework!');

/**
 * comment模型控制器
 * 
 * @author zhengshufa
 *         @date 2015-10-20 14:49:53
 */
class comment_Controller extends Controller
{

    private $vdir = 'comment/';

    /**
     * 新增comment
     */
    public function add()
    {
        if (input::post()) {
            $post = input::post();
            $comment = new comment_Model();
            foreach ($post as $k => $v) {
                $comment->$k = is_array($v) ? join(',', $v) : $v;
            }
            $comment->addtime = date('Y-m-d H:i:s');
            $comment->ip = F::getIp();
            $comment->save();
            $this->echomsg('新增成功!', 'lists');
        }
        $view = new View($this->vdir . 'add');
        $view->render();
    }

    /**
     * 删除comment
     */
    public function delete($id)
    {
        $comment = new comment_Model($id);
        if ($comment->id) {
            $comment->delete($id);
            $this->echomsg('删除成功!', '../lists');
        } else {
            $this->echomsg('删除失败!', '../lists');
        }
    }

    /**
     * 修改comment
     */
    public function edit($id)
    {
        $comment = new comment_Model($id);
        if (input::post()) {
            $post = input::post();
            foreach ($post as $k => $v) {
                $comment->$k = is_array($v) ? join(',', $v) : $v;
            }
            $comment->save();
            $this->echomsg('修改成功!', '../lists');
        }
        $view = new View($this->vdir . 'edit');
        $view->comment = $comment;
        $view->render();
    }

    /**
     * 列表管理 comment
     */
    public function lists($arg1 = '__1', $arg2 = '__2', $arg3 = '__3')
    {
        $comment = new comment_Model();
        $view = new View($this->vdir . 'lists');
        $view->lists = $comment->lists('0,10');
        $view->list_fields_arr = array(
            'id',
            'blog_id',
            'content',
            'addtime',
            'ip'
        );
        $view->render();
    }

    /**
     * 展示comment
     */
    public function show($id)
    {
        $comment = new comment_Model($id);
        $view = new View($this->vdir . 'show');
        $view->comment = $comment;
        $view->render();
    }
}
