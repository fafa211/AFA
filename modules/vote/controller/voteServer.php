<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * vote模型控制器
 * @author zhengshufa
 * @date 2017-04-07 21:17:22
 */
class voteServer_Controller extends Server_Controller
{

    /**
     * @var array $use_token 允许使用token进行授权访问的方法
     */
    protected $use_token = array('add','delete','lists','listCount','edit','show',
        'listOptions','addOption','editOption','delOption','operateOption','selectOption','doneVotes','viewRecords','myDoneVotes');


    public function __construct(Request $request)
    {
        parent::__construct($request);

        //支持JS跨域上传文件,IE10以下浏览器不支持
        header('Access-Control-Allow-Origin：* ');
    }

    /**
     * 投票: 发起投票 vote
     * -
     * GET 方式提交的参数为
     * key        授权访问key
     * -
     * 其他参数提交方式  POST
     * 需要传的参数为
     *
     * qiye_id    企业(支队)ID
     * uid        发起人ID
     * type       投票类型: 文字类型,图文类型
     * title      投票标题
     * title_pic  投票配图 file文件上传
     * about      投票说明
     * start_time 开始时间
     * end_time   结束时间
     * option_setting   投票选项
     * rate       投票频率
     * -
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功
     *  "errMsg":"success",
     *  "retData":[{
     *      'id': 10 //投票ID
     *   }]
     * }
     *
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

            $vote->account_id = $this->account_id;

            $vote->title_pic = input::post('title_pic');

//            if($_FILES['title_pic'] && $_FILES['title_pic']['tmp_name']) {
//                $valid = Validation::instance($_FILES);
//                $valid->rule('title_pic', 'Upload::type', array(':value', array('jpg', 'png', 'gif')));
//                if ($valid->check()) {
//                    if ($file = input::file('title_pic')) {
//                        $vote->title_pic = F::uploadPic($file, array(array(600, 600)));
//                    }
//                }
//            }
            $vote->save();

            $this->ret['errMsg'] = '操作成功';
            $this->ret['retData']['id'] = $vote->id;

            $this->echojson($this->ret);
        }

    }

    /**
     * 投票: 删除发起的投票
     * -
     * GET 方式提交的参数为
     * key        授权访问key
     * qiye_id    企业ID
     * vote_id    投票ID
     * -
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功, 500为没有权限
     *  "errMsg":"success",
     *  "retData":[{}]
     * }
     *
     */
    public function delete_Action()
    {
        $qiye_id = input::get('qiye_id');

        $vote = new vote_Model(input::get('vote_id'));


        if($vote->account_id != $this->account_id || $qiye_id != $vote->qiye_id){
            $this->ret['errNum'] = 500;
            $this->ret['errMsg'] = '没有权限';
            $this->echojson($this->ret);
            return;
        }

        if ($vote->id) {
            $vote->delete();

            $this->echojson($this->ret);
        } else {
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = '操作失败';
            $this->echojson($this->ret);
        }
    }

    /**
     * 投票: 编辑发起的投票 vote
     * -
     * GET 方式提交的参数为
     * key        授权访问key
     * -
     * 其他参数提交方式  POST
     * 需要传的参数为
     *
     * vote_id    投票ID
     * qiye_id    企业(支队)ID
     * uid        发起人ID
     * type       投票类型: 文字类型,图文类型
     * title      投票标题
     * title_pic  投票配图 file文件上传
     * about      投票说明
     * start_time 开始时间
     * end_time   结束时间
     * option_setting   投票选项
     * rate       投票频率
     * -
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功, 500为没有权限
     *  "errMsg":"success",
     *  "retData":[{
     *      'id': 10 //投票ID
     *   }]
     * }
     *
     */
    public function edit_Action()
    {

        $vote_id = input::post('vote_id');
        $qiye_id = input::post('qiye_id');

        $vote = new vote_Model($vote_id);

        if($vote->account_id != $this->account_id || $qiye_id != $vote->qiye_id){
            $this->ret['errNum'] = 500;
            $this->ret['errMsg'] = '没有权限';
            $this->echojson($this->ret);
            return;
        }

        if (input::post()) {
            $post = input::post();
            foreach ($post as $k => $v) {
                $vote->$k = is_array($v) ? join(',', $v) : $v;
            }

            $start_time = input::post('start_time');
            $end_time = input::post('end_time');
            $vote->start_time = is_numeric($start_time)?$start_time:strtotime($start_time);
            $vote->end_time = is_numeric($end_time)?$end_time:strtotime($end_time);

            $vote->title_pic = input::post('title_pic')?input::post('title_pic'):$this->title_pic;

//            if($_FILES['title_pic'] && $_FILES['title_pic']['tmp_name']) {
//                $valid = Validation::instance($_FILES);
//                $valid->rule('headpic', 'Upload::type', array(':value', array('jpg', 'png', 'gif')));
//                if ($valid->check()) {
//                    if ($file = input::file('title_pic')) {
//                        $vote->title_pic = F::uploadPic($file, array(array(600, 600)));
//                    }
//                }
//            }
            $vote->save();
            $this->echojson($this->ret);
        }
    }

    /**
     * 投票: 查询投票列表 vote
     *
     * 参数提交方式  GET
     * 需要传的参数为
     *
     * key        授权访问key
     * qiye_id    企业(支队)ID
     * result_num 读取结果条数
     * page       当前页数
     * flag       = all 全部, doing 进行中的, done 已结束
     *
     * @return 返回投票结果,格式如下
     * {
     * "errNum":0,  //成功标识, 0 为成功
     * "errMsg":"success",
     *  "retData":[
     * {"id":"5",                       投票ID
     * "account_id":"4",
     * "uid":"yyyyyy",                  //用户ID
     * "qiye_id":"wqeuriopeqwiopru",
     * "type":"1",                      //投票类型
     * "title":"测试标题",               //投票标题
     * "title_pic":"图片url地址",        //投票图片地址
     * "about":"",                      //投票描述
     * "start_time":"1491621976",       //开始时间
     * "end_time":"1492226776",         //结束时间
     * "option_setting":"2",            //投票规则设置
     * "rate":"1",                      //投票频率设置
     * "add_time":"1491621976",         //创建时间
     * "status":"进行中",                //状态
     * "vote_num":0                     //投票总数
     *  },{...}
     * ]
     * }
     *
     */
    public function lists_Action()
    {

        $vote = new vote_Model();

        $qiye_id = input::get('qiye_id');  //企业(支队)ID
        $result_num = input::get('result_num')?input::get('result_num'):5;//读取条数
        $page = input::get('page')?input::get('page'):1;//起始位置
        $position = ($page-1)*$result_num;
        $flag = input::get('flag');

        $where = array();
        $time = time();
        if($flag == 'doing'){
            $where = array(array('start_time','<', $time),array('end_time','>', $time));
        }elseif($flag == 'done'){
            $where = array(array('end_time','<', $time));
        }elseif($flag == 'doing,done'){
            $where = array(array('start_time','<', $time));
        }

        $result = $vote->search($this->account_id, $qiye_id, $where, 'id desc', "{$position},{$result_num}");

        $resultRtn = array();
        $now = time();
        $vote_option = new vote_option_Model();
        foreach($result as $k=>$v) {
            //状态信息
            if ($now < $v['start_time']) $v['status'] = "未开始";
            elseif ($now > $v['end_time']) $v['status'] = "已结束";
            else $v['status'] = "进行中";
            //总票数
            $v['vote_num'] = $vote_option->getVoteNum($v['id']);
            $resultRtn[$k] = $v;
        }

        $this->ret['retData'] = $resultRtn;

        $this->echojson($this->ret);
    }

    /**
     * 投票: 发起的投票总数统计 vote
     *
     * 参数提交方式  GET
     * 需要传的参数为
     *
     * key        授权访问key
     * qiye_id    企业(支队)ID
     * flag       = all 全部, doing 进行中的, done 已结束
     *
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功
     *  "errMsg":"success",
     *  "retData":10 //结果条数
     * }
     *
     */
    public function listCount_Action()
    {

        $vote = new vote_Model();

        $qiye_id = input::get('qiye_id');  //企业(支队)ID
        $flag = input::get('flag');

        $where = array();
        $time = time();
        if($flag == 'doing'){
            $where = array(array('start_time','<', $time),array('end_time','>', $time));
        }elseif($flag == 'done'){
            $where = array(array('end_time','<', $time));
        }

        $this->ret['retData']['result_num'] = $vote->search($this->account_id, $qiye_id, $where, false);

        $this->echojson($this->ret);
    }

    /**
     * 投票: 查询单个投票信息
     * -
     * GET 方式提交的参数为
     * key        授权访问key
     * vote_id    投票ID
     * -
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功, 500为没有权限
     *  "errMsg":"success",
     *  "retData":{
     * "id":"5",                       投票ID
     * "account_id":"4",
     * "uid":"yyyyyy",                  //用户ID
     * "qiye_id":"wqeuriopeqwiopru",
     * "type":"1",                      //投票类型
     * "title":"测试标题",               //投票标题
     * "title_pic":"图片url地址",        //投票图片地址
     * "about":"",                      //投票描述
     * "start_time":"1491621976",       //开始时间
     * "end_time":"1492226776",         //结束时间
     * "option_setting":"2",            //投票规则设置
     * "rate":"1",                      //投票频率设置
     * "add_time":"1491621976",         //创建时间
     * "status":"进行中",                //状态
     * "vote_num":0                     //投票总数
     *  }
     * }
     *
     */
    public function show_Action()
    {
        $vote_id = input::get('vote_id');
        $vote = new vote_Model($vote_id);

        if($vote->account_id != $this->account_id){
            $this->ret['errNum'] = 500;
            $this->ret['errMsg'] = '没有权限';
            $this->echojson($this->ret);
            return;
        }

        $now = time();
        if($now < $vote->start_time) $vote->status = "未开始";
        elseif($now > $vote->end_time) $vote->status = "已结束";
        else $vote->status = "进行中";

        $vote_option = new vote_option_Model();
        $vote->vote_num = $vote_option->getVoteNum($vote->id);

        $this->ret['retData'] = $vote;
        $this->echojson($this->ret);
    }

    /**
     * 投票选项: 查询投票全部选项 vote
     *
     * 参数提交方式  GET
     * 需要传的参数为
     *
     * key        授权访问key
     * qiye_id    企业(支队)ID
     * vote_id    读取结果条数
     *
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功 ,500为没有权限
     *  "errMsg":"success",
     *  "retData":[{
     * "id":"1",       //投票选项ID
     * "vote_id":"2",  //投票ID
     * "option_title":"选项描述",
     * "option_pic":"",//选项图片地址
     * "option_text":"选项详细描述",
     * "votes":"0",   //投票数
     * "add_time":"0"
     *  },{...}]
     * }
     *
     */
    public function listOptions_Action()
    {

        $qiye_id = input::get('qiye_id');  //企业(支队)ID
        $vote_id = input::get('vote_id');//读取条数

        $vote = new vote_Model($vote_id);
        if($vote->account_id != $this->account_id || $qiye_id != $vote->qiye_id){
            $this->ret['errNum'] = 500;
            $this->ret['errMsg'] = '没有权限';
            $this->echojson($this->ret);
            return;
        }

        $vote_option = new vote_option_Model();
        $this->ret['retData'] = $vote_option->search($vote_id);

        $this->echojson($this->ret);
    }

    /**
     * 投票选项: 添加投票选项 vote_option
     * -
     * GET 方式提交的参数为
     * key        授权访问key
     * -
     * 其他参数提交方式  POST
     * 需要传的参数为
     *
     * qiye_id    企业(支队)ID
     * vote_id    投票ID
     * option_title      投票选项标题
     * option_pic  投票选项配图 file文件上传
     * option_text      投票选项说明
     * -
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功
     *  "errMsg":"success",
     *  "retData":[{
     *      'id': 10 //投票ID
     *   }]
     * }
     *
     */
    public function addOption_Action()
    {
        if (input::post()) {
            $post = input::post();

            $vote = new vote_Model(input::post('vote_id'));
            if($vote->account_id != $this->account_id || input::post('qiye_id') != $vote->qiye_id){
                $this->ret['errNum'] = 500;
                $this->ret['errMsg'] = '没有权限';
                $this->echojson($this->ret);
                return;
            }


            $vote_option = new vote_option_Model();
            foreach ($post as $k => $v) {
                $vote_option->$k = is_array($v) ? join(',', $v) : $v;
            }
            $vote_option->add_time = time();

            $vote_option->option_pic = input::post('option_pic');

//            if(isset($_FILES['option_pic']) && $_FILES['option_pic'] && $_FILES['option_pic']['tmp_name']) {
//                $valid = Validation::instance($_FILES);
//                $valid->rule('option_pic', 'Upload::type', array(':value', array('jpg', 'png', 'gif')));
//                if ($valid->check()) {
//                    if ($file = input::file('option_pic')) {
//                        $vote_option->option_pic = F::uploadPic($file, array(array(600, 600)));
//                    }
//                }
//            }
            $vote_option->save();

            $this->ret['errMsg'] = '操作成功';
            $this->ret['retData']['id'] = $vote_option->id;

            $this->echojson($this->ret);
        }

    }

    /**
     * 投票选项: 编辑投票选项 vote_option
     * -
     * GET 方式提交的参数为
     * key        授权访问key
     * -
     * 其他参数提交方式  POST
     * 需要传的参数为
     *
     * qiye_id    企业(支队)ID
     * vote_id    投票ID
     * option_title      投票选项标题
     * option_pic  投票选项配图 file文件上传
     * option_text      投票选项说明
     * -
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功, 500表示没有权限
     *  "errMsg":"success",
     *  "retData":[{
     *      'id': 10 //投票ID
     *   }]
     * }
     *
     */
    public function editOption_Action()
    {
        $post = input::post();
        if (!empty($post)) {

            $option_id = input::post('option_id');

            $vote = new vote_Model(input::post('vote_id'));
            $vote_option = new vote_option_Model($option_id);

            if($vote->account_id != $this->account_id || input::post('qiye_id') != $vote->qiye_id || $vote_option->vote_id != $vote->id){
                $this->ret['errNum'] = 500;
                $this->ret['errMsg'] = '没有权限';
                $this->echojson($this->ret);
                return;
            }

            $vote_option->option_title = input::post('option_title');
            $vote_option->option_text = input::post('option_text');

            $vote_option->option_pic = input::post('option_pic')?input::post('option_pic'):$vote_option->option_pic;


//            if(isset($_FILES['option_pic']) && $_FILES['option_pic'] && $_FILES['option_pic']['tmp_name']) {
//                $valid = Validation::instance($_FILES);
//                $valid->rule('option_pic', 'Upload::type', array(':value', array('jpg', 'png', 'gif')));
//                if ($valid->check()) {
//                    if ($file = input::file('option_pic')) {
//                        $vote_option->option_pic = F::uploadPic($file, array(array(600, 600)));
//                    }
//                }
//            }
            $vote_option->save();

            $this->ret['errMsg'] = '操作成功';
            $this->ret['retData']['id'] = $vote_option->id;

            $this->echojson($this->ret);
        }

    }

    /**
     * 投票选项: 投票选项修改表单提交 vote_option
     * -
     * GET 方式提交的参数为
     * key        授权访问key
     * -
     * 其他参数提交方式  POST
     * 需要传的参数为
     *
     * qiye_id    企业(支队)ID
     * vote_id    投票ID
     * option_arr 投票选项修改JSON数组,[{"option_id":2,"option_title":"测试标题1"},{"option_id":3,"option_title":"测试标题3"}]
     * option_del_ids    删除的option id,多个ID逗号分割
     * -
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功, 500表示没有权限
     *  "errMsg":"success",
     *  "retData":[{
     *      'id': 10 //投票ID
     *   }]
     * }
     *
     */
    public function operateOption_Action()
    {
        $post = input::post();
        if (!empty($post)) {

            $option_arr = input::post('option_arr');  //新增/编辑投票选项
            $option_del_ids = input::post('option_del_ids'); //删除投票选项

            $vote = new vote_Model(input::post('vote_id'));

            if($vote->account_id != $this->account_id || input::post('qiye_id') != $vote->qiye_id){
                $this->ret['errNum'] = 500;
                $this->ret['errMsg'] = '没有权限';
                $this->echojson($this->ret);
                return;
            }

            if($option_arr){
                $option_arr = json_decode(input::post('option_arr'));
                if(is_array($option_arr)){
                    //文字投票类型时生效
                    foreach($option_arr as $v){
                        if(!isset($v->option_title) || empty($v->option_title)) continue; //忽略为空的选项

                        if($v->option_id) {
                            //编辑
                            $vote_option = new vote_option_Model($v->option_id);
                            if($vote_option->vote_id != $vote->id) continue; //无权限
                        }else{
                            //新增
                            $vote_option = new vote_option_Model();
                            $vote_option->vote_id = $vote->id;
                            $vote_option->add_time = time();
                        }

                        $vote_option->option_title = $v->option_title;
                        $vote_option->option_text = isset($v->option_text)?$v->option_text:'';


                        $vote_option->save();
                    }
                }
            }

            if($option_del_ids){
                $option_del_ids = explode(',', $option_del_ids);
                foreach($option_del_ids as $option_id){
                    $vote_option = new vote_option_Model(intval($option_id));
                    if($vote_option->vote_id == $vote->id){
                        $vote_option->delete();
                    }
                }
            }

            $this->ret['errMsg'] = '操作成功';

            $this->echojson($this->ret);
        }

    }

    /**
     * 投票选项: 删除投票选项
     * -
     * GET 方式提交的参数为
     * key        授权访问key
     * vote_id    投票ID
     * option_id  选项ID
     * -
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功, 500为没有权限
     *  "errMsg":"success",
     *  "retData":[{}]
     * }
     *
     */
    public function delOption_Action()
    {
        $vote_id = input::get('vote_id');
        $option_id = input::get('option_id');

        $vote = new vote_Model(input::get('vote_id'));
        $vote_option = new vote_option_Model($option_id);


        if($vote->account_id != $this->account_id || $vote_option->vote_id != $vote_id){
            $this->ret['errNum'] = 500;
            $this->ret['errMsg'] = '没有权限';
            $this->echojson($this->ret);
            return;
        }

        if ($vote_option->id) {

            $vote_option->delete();
            $this->echojson($this->ret);
        } else {
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = '操作失败';
            $this->echojson($this->ret);
        }
    }

    /**
     * 投票动作: 执行投票
     * -
     * GET 方式提交的参数为
     * key        授权访问key
     *
     * POST 提交的参数
     * vote_id    投票ID
     * option_id  选项ID, 多项用逗号分割
     * uid        参与投票用户ID
     * -
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功, 500-505为没有权限或其他限制
     *  "errMsg":"success",
     *  "retData":[{}]
     * }
     *
     */
    public function selectOption_Action()
    {
        $vote_id = input::post('vote_id');
        $option_id = input::post('option_id');
        $uid = input::post('uid');
        $now = time();

        $vote = new vote_Model($vote_id);

        if($vote->account_id != $this->account_id || empty($uid)){
            $this->ret['errNum'] = 500;
            $this->ret['errMsg'] = '没有权限';
            $this->echojson($this->ret);
            return;
        }

        if($vote->start_time > $now){
            $this->ret['errNum'] = 501;
            $this->ret['errMsg'] = '投票尚未开始';
            $this->echojson($this->ret);
            return;
        }

        if($vote->end_time < $now){
            $this->ret['errNum'] = 502;
            $this->ret['errMsg'] = '投票已经结束';
            $this->echojson($this->ret);
            return;
        }

        $vote_record = new vote_record_Model();
        $option_arr = array_unique(explode(',', $option_id));
        if(in_array($vote->option_setting, array(1,2,3))){
            //检查投票限制与频率限制
            $option_count = count($option_arr);
            if($option_count >=1 && $option_count <= $vote->option_setting){
                if( $vote->rate == 1 ){
                    $vote_num = $vote_record->search($vote_id, array('uid'=>$uid), false);
                    if($vote_num){
                        $this->ret['errNum'] = 504;
                        $this->ret['errMsg'] = "你已经投过票了";
                        $this->echojson($this->ret);
                        return;
                    }
                }elseif( $vote->rate == 2 ){
                    $vote_num = $vote_record->search($vote_id, array('uid'=>$uid, array('add_time','>',strtotime(date('Y-m-d', $now)))), false);
                    if($vote_num){
                        $this->ret['errNum'] = 505;
                        $this->ret['errMsg'] = "你今天已经投过票了";
                        $this->echojson($this->ret);
                        return;
                    }
                }

            }else {
                $this->ret['errNum'] = 503;
                $this->ret['errMsg'] = "最对只能投 {$vote->option_setting} 票";
                $this->echojson($this->ret);
                return;
            }
        }

        //组装选项数组
        $vote_option = new vote_option_Model();
        $options = $vote_option->search($vote_id);
        $option_ids = array();
        foreach($options as $ov){
            $option_ids[] = $ov['id'];
        }

        //保存投票记录
        foreach($option_arr as $v){
            $option_id = intval($v);
            if(!in_array($option_id, $option_ids)) continue;
            $vote_record = new vote_record_Model();
            $vote_record->uid = $uid;
            $vote_record->vote_id = $vote_id;
            $vote_record->option_id = $option_id;

            $vote_record->add_time = $now;
            $vote_record->save();

            $vote_option = new vote_option_Model($option_id);
            $vote_option->votes++;
            $vote_option->save();
        }

        if ($vote_record->id) {
            $this->ret['errMsg'] = '投票成功';
            $this->echojson($this->ret);
        } else {
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = '操作失败';
            $this->echojson($this->ret);
        }
    }


    /**
     * 投票选项: 我参与的投票 vote
     *
     * 参数提交方式  GET
     * 需要传的参数为
     *
     * key        授权访问key
     * uid        用户ID
     * result_num 读取结果条数
     * position   读取起始位置
     *
     * @return 返回投票结果,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功 ,500为没有权限
     *  "errMsg":"success",
     *  "retData":[
     * {"id":"5",                       投票ID
     * "account_id":"4",
     * "uid":"yyyyyy",                  //用户ID
     * "qiye_id":"wqeuriopeqwiopru",
     * "type":"1",                      //投票类型
     * "title":"测试标题",               //投票标题
     * "title_pic":"图片url地址",        //投票图片地址
     * "about":"",                      //投票描述
     * "start_time":"1491621976",       //开始时间
     * "end_time":"1492226776",         //结束时间
     * "option_setting":"2",            //投票规则设置
     * "rate":"1",                      //投票频率设置
     * "add_time":"1491621976",         //创建时间
     * "status":"进行中",                //状态
     * "vote_num":0                     //投票总数
     *  },{...}]
     * }
     *
     */
    public function doneVotes_Action()
    {

        $uid = input::get('uid');  //企业(支队)ID
        $result_num = input::get('result_num');
        $position = input::get('position');

        $vote_record = new vote_record_Model();
        $result = $vote_record->searchMyVotes($uid, 'id desc', "{$position},{$result_num}");

        $resultRtn = array();
        $now = time();
        $vote_option = new vote_option_Model();
        foreach($result as $k=>$v) {
            //状态信息
            if ($now < $v['start_time']) $v['status'] = "未开始";
            elseif ($now > $v['end_time']) $v['status'] = "已结束";
            else $v['status'] = "进行中";
            //总票数
            $v['vote_num'] = $vote_option->getVoteNum($v['id']);
            $resultRtn[$k] = $v;
        }

        $this->ret['retData'] = $resultRtn;

        $this->echojson($this->ret);
    }

    /**
     * 投票记录: 查看投票记录 vote_record
     *
     * 参数提交方式  GET
     * 需要传的参数为
     *
     * key        授权访问key
     * vote_id    读取结果条数
     * option_id  查看投票记录
     * result_num 读取结果条数
     * page       当前页数
     *
     * @return 返回投票记录,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功 ,500为没有权限
     *  "errMsg":"success",
     *  "retData":[{
     * "id":"1",        //投票记录ID
     * "uid":"qqqq",    //投票人ID
     * "vote_id":"14",  //投票ID
     * "option_id":"2", //投票选项ID
     * "add_time":"1491906436"  //投票时间
     *  },{...}]
     * }
     *
     */
    public function viewRecords_Action()
    {
        $vote_id = input::get('vote_id');
        $option_id = input::get('option_id');
        $result_num = input::get('result_num')?input::get('result_num'):5;//读取条数
        $page = input::get('page')?input::get('page'):1;//起始位置
        $position = ($page-1)*$result_num;

        $vote = new vote_Model($vote_id);

        if($vote->account_id != $this->account_id){
            $this->ret['errNum'] = 500;
            $this->ret['errMsg'] = '没有权限';
            $this->echojson($this->ret);
            return;
        }

        $vote_recod = new vote_record_Model();

        $result = $vote_recod->search($vote_id, array('option_id'=>$option_id),'id desc',"{$position},{$result_num}");

        $this->ret['retData'] = $result;

        $this->echojson($this->ret);
    }

    /**
     * 投票记录: 查看我参与的投票 vote_record
     *
     * 参数提交方式  GET
     * 需要传的参数为
     *
     * key        授权访问key
     * result_num 读取结果条数
     * page       当前页数
     * uid        用户ID
     *
     * @return 返回投票记录,格式如下
     * {
     *  "errNum":0,  //成功标识, 0 为成功 ,500为没有权限
     *  "errMsg":"success",
     *  "retData":[
     * {"id":"5",                       投票ID
     * "account_id":"4",
     * "uid":"yyyyyy",                  //用户ID
     * "qiye_id":"wqeuriopeqwiopru",
     * "type":"1",                      //投票类型
     * "title":"测试标题",               //投票标题
     * "title_pic":"图片url地址",        //投票图片地址
     * "about":"",                      //投票描述
     * "start_time":"1491621976",       //开始时间
     * "end_time":"1492226776",         //结束时间
     * "option_setting":"2",
     * "rate":"1",
     * "add_time":"1491621976",         //创建时间
     * "status":"进行中",                //状态
     * "vote_num":0                     //投票总数
     *  },{...}]
     * }
     *
     */
    public function myDoneVotes_Action()
    {

        $uid = input::get('uid');
        $result_num = input::get('result_num')?input::get('result_num'):5;//读取条数
        $page = input::get('page')?input::get('page'):1;//起始位置
        $position = ($page-1)*$result_num;

        $vote_recod = new vote_record_Model();

        $result = $vote_recod->searchMyVotes($uid, "{$position}, {$result_num}");

        $this->ret['retData'] = $result;

        $this->echojson($this->ret);
    }


}
