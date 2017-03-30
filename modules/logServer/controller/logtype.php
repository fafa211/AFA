<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * logtype模型控制器
 * @author zhengshufa
 * @date 2016-09-08 16:27:22
 */
class logtype_Controller extends Admin_Controller
{

    private $vdir = 'logtype/';

    /**
     * 新增logtype
     */
    public function add_Action()
    {
        if (input::post()) {
            $post = input::post();
            $logtype = new logtype_Model();
            foreach ($post as $k => $v) {
                $logtype->$k = is_array($v) ? join(',', $v) : $v;
            }
            $logtype->save();
            $this->echomsg('新增成功!', 'lists');
        }
        $view = &$this->view;
        $view->set_view($this->vdir . 'add');
        $view->render();
    }

    /**
     * 删除logtype
     */
    public function delete_Action($id)
    {
        $logtype = new logtype_Model($id);
        if ($logtype->id) {
            $logtype->delete($id);
            $this->echomsg('删除成功!', '../lists');
        } else {
            $this->echomsg('删除失败!', '../lists');
        }
    }

    /**
     * 修改logtype
     */
    public function edit_Action($id)
    {
        $logtype = new logtype_Model($id);
        if (input::post()) {
            $post = input::post();
            foreach ($post as $k => $v) {
                $logtype->$k = is_array($v) ? join(',', $v) : $v;
            }
            $logtype->save();
            $this->echomsg('修改成功!', '../lists');
        }
        $view = &$this->view;
        $view->set_view($this->vdir . 'edit');
        $view->logtype = $logtype;
        $view->render();
    }

    /**
     * 列表管理 logtype
     */
    public function lists_Action()
    {
        $logtype = new logtype_Model();
        $view = &$this->view;
        $view->set_view($this->vdir . 'lists');
        $view->lists = $logtype->lists('0,10');
        $view->list_fields_arr = array('id', 'type_name', 'description', 'records_count', 'created_time');
        $view->render();
    }

    /**
     * 展示logtype
     */
    public function show_Action($id)
    {
        $logtype = new logtype_Model($id);
        $view = &$this->view;
        $view->set_view($this->vdir . 'show');
        $view->logtype = $logtype;
        $view->render();
    }

}
