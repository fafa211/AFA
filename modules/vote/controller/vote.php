<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * vote模型控制器
 * @author zhengshufa
 * @date 2017-04-07 21:17:22
 */
class Vote_Controller extends Controller
{

    private $vdir = '';

    /**
     * 新增vote
     */
    public function add_Action()
    {
        if (input::post()) {
            $post = input::post();
            $vote = new vote_Model();
            foreach ($post as $k => $v) {
                $vote->$k = is_array($v) ? join(',', $v) : $v;
            }
            $start_time = input::post('start_time');
            $end_time = input::post('end_time');
            $vote->start_time = is_numeric($start_time)?$start_time:strtotime($start_time);
            $vote->end_time = is_numeric($end_time)?$end_time:strtotime($end_time);

            $vote->add_time = time();

            $vote->account_id = 4;
            $vote->uid = 'yyyyyy';

            if($_FILES['title_pic'] && $_FILES['title_pic']['tmp_name']) {
                $valid = Validation::instance($_FILES);
                $valid->rule('title_pic', 'Upload::type', array(':value', array('jpg', 'png', 'gif')));
                if ($valid->check()) {
                    if ($file = input::file('title_pic')) {
                        $vote->title_pic = F::uploadPic($file, array(array(600, 600)));
                    }
                }
            }
            $vote->save();

            $this->echomsg('新增成功!', 'lists');
        }
        $view = &$this->view;
        $view->set_view($this->vdir . 'add');
        $view->render();
    }

    /**
     * 删除vote
     */
    public function delete_Action($id)
    {
        $vote = new vote_Model($id);
        if ($vote->id) {
            $vote->delete($id);
            $this->echomsg('删除成功!', '../lists');
        } else {
            $this->echomsg('删除失败!', '../lists');
        }
    }

    /**
     * 修改vote
     */
    public function edit_Action($id)
    {
        $vote = new vote_Model($id);
        if (input::post()) {
            $post = input::post();
            foreach ($post as $k => $v) {
                $vote->$k = is_array($v) ? join(',', $v) : $v;
            }

            $start_time = input::post('start_time');
            $end_time = input::post('end_time');
            $vote->start_time = is_numeric($start_time)?$start_time:strtotime($start_time);
            $vote->end_time = is_numeric($end_time)?$end_time:strtotime($end_time);

            if($_FILES['title_pic'] && $_FILES['title_pic']['tmp_name']) {
                $valid = Validation::instance($_FILES);
                $valid->rule('title_pic', 'Upload::type', array(':value', array('jpg', 'png', 'gif')));
                if ($valid->check()) {
                    if ($file = input::file('title_pic')) {
                        $vote->title_pic = F::uploadPic($file, array(array(600, 600)));
                    }
                }
            }
            $vote->save();


            $this->echomsg('修改成功!', '../lists');
        }
        $view = &$this->view;
        $view->set_view($this->vdir . 'edit');
        $view->vote = $vote;
        $view->render();
    }

    /**
     * 列表管理 vote
     */
    public function lists_Action()
    {
        $vote = new vote_Model();
        $view = &$this->view;
        $view->set_view($this->vdir . 'lists');
        $view->lists = $vote->lists('0,10');
        $view->list_fields_arr = array('id', 'qiye_id', 'type', 'title', 'start_time', 'end_time', 'option_setting', 'rate');
        $view->render();
    }

    /**
     * 展示vote
     */
    public function show_Action($id)
    {
        $vote = new vote_Model($id);
        $view = &$this->view;
        $view->set_view($this->vdir . 'show');
        $view->vote = $vote;
        $view->render();
    }


}
