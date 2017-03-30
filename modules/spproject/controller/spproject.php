<?php

defined('AFA') or die('No AFA PHP Framework!');

/**
 * spproject模型控制器
 * 
 * @author zhengshufa
 *         @date 2015-12-09 17:44:03
 */
class spproject_Controller extends Controller
{

    private $vdir = '';

    /**
     * 新增spproject
     */
    public function add_Action()
    {
        if (input::post()) {
            $post = input::post();
            $spproject = new spproject_Model();
            foreach ($post as $k => $v) {
                $spproject->$k = is_array($v) ? join(',', $v) : $v;
            }
            $spproject->create_time = date('Y-m-d H:i:s');
            
            $valid = Validation::instance($_FILES);
            $valid->rule('pic_url', 'Upload::type', array(
                ':value',
                array(
                    'jpg',
                    'png',
                    'gif'
                )
            ));
            if ($valid->check()) {
                if ($file = input::file('pic_url')) {
                    $spproject->pic_url = F::uploadPic($file, array(
                        array(
                            400,
                            400
                        )
                    ));
                }
            }
            $spproject->save();
            $this->echomsg('新增成功!', 'lists');
        }
        $view = &$this->view;
        $view->set_view($this->vdir . 'add');
        $view->render();
    }

    /**
     * 删除spproject
     */
//     public function delete_Action($id)
//     {
//         $spproject = new spproject_Model($id);
//         if ($spproject->id) {
//             $spproject->delete($id);
//             $this->echomsg('删除成功!', '../lists');
//         } else {
//             $this->echomsg('删除失败!', '../lists');
//         }
//     }

    /**
     * 修改spproject
     */
    public function edit_Action($id)
    {
        $spproject = new spproject_Model($id);
        if (input::post()) {
            $post = input::post();
            foreach ($post as $k => $v) {
                $spproject->$k = is_array($v) ? join(',', $v) : $v;
            }
            if(!empty(@$_FILES['pic_url']['name'])){
                $valid = Validation::instance($_FILES);
                $valid->rule('pic_url', 'Upload::type', array(
                    ':value',
                    array(
                        'jpg',
                        'png',
                        'gif'
                    )
                ));
                if ($valid->check()) {
                    if ($file = input::file('pic_url')) {
                        F::delUploadPic($spproject->pic_url);
                        $spproject->pic_url = F::uploadPic($file, array(
                            array(
                                400,
                                400
                            )
                        ));
                    }
                }
            }
            $spproject->save();
            $this->echomsg('修改成功!', '../lists');
        }
        $view = &$this->view;
        $view->set_view($this->vdir . 'edit');
        $view->spproject = $spproject;
        $view->render();
    }

    /**
     * 列表管理 spproject
     */
    public function lists_Action()
    {
        $spproject = new spproject_Model();
        $view = &$this->view;
        $view->set_view($this->vdir . 'lists');
        $view->lists = $spproject->lists('0,10');
        $view->list_fields_arr = array(
            'id',
            'name',
            'pic_url',
            'phone_or_400',
            'create_time'
        );
        $view->render();
    }

    /**
     * 展示spproject
     */
    public function show_Action($id)
    {
        $spproject = new spproject_Model($id);
        $view = &$this->view;
        $view->set_view($this->vdir . 'show');
        $view->spproject = $spproject;
        $view->render();
    }
}
