<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * 微服务 父控制类, 全部微服务需继承此基类
 * @author zhengshufa
 * @date 2016-08-02 15:20:55
 */
class Server_Controller extends Controller
{

    /**
     * @var array 返回结果数组格式
     * errNum = 0 为成功, 非0为失败
     * errMsg 提示信息
     * retData  返回的结果数组
     */
    protected $ret = array('errNum'=>0, 'errMsg'=>'success', 'retData'=>array());

    /**
     * @var string 记录服务调用日志文件保存路径
     */
    public static $log_path = '';//

    /**
     * 执行前的准备与日志记录
     * @return boolean
     */
    public function before(){

        //忽略man方法
        if('man' == $this->request->method)  return;

        //验证是否通过标识
        $verify = false;
        //访问控制key
        $keyno = input::get('key');
        //授权帐号ID, 默认值为 0
        $this->account_id = 0;

        if(!empty($keyno)) {
            //账户key授权验证
            $keystr = F::authstr($keyno, 'DECODE');
            $keyarr = explode(',', $keystr);

            if (isset($keyarr[0]) && isset($keyarr[1]) && is_numeric($keyarr[0]) && $keyarr[0]) {
                $this->account_id = $keyarr[0];
                $verify = true;
            }
        }elseif($token = input::get('token')){
            //token授权验证
            if(is_array($this->use_token) && in_array($this->request->method, $this->use_token)) {
                //解密token
                $str = F::authstr($token, 'DECODE');
                if (!empty($str)) {
                    list($this->account_id, $time) = explode(',', $str);

                    if ($this->account_id && $time <= time()) {
                        $this->token = $token;
                        $this->token_time = $time;
                        $verify = true;
                    }
                }
            }
        }

        //客户端IP地址
        $this->client_ip = common::getIp();
        //接口调用唯一标识ID
        $this->uniqid =  md5(uniqid().$this->client_ip);
        self::$log_path = PROROOT.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'serverlog'.DIRECTORY_SEPARATOR;


        $logs = new Logs(self::$log_path, date('Y-m-d') . '.log');
        $logContent = array(
            'id' => $this->uniqid,
            'log_time' => date('Y-m-d H:i:s'),
            'acccount_id'=> $this->account_id,
            'ip' => $this->client_ip,
            'api' => $this->request->controller.'/'.$this->request->method,//接口名称
            'params' => $this->request->params,//接口参数
            'get_params' => input::get(),
            'post_parms' => input::post()
        );
        $logContent = F::json_encode($logContent);
        $logs->LogInfo($logContent);

        return $verify;

    }

    /**
     * 执行后的服务调用记录,调用前后可通过唯一ID($this->uniqid)识别
     */
    public function after(){

        //忽略man方法
        if('man' == $this->request->method)  return;

        $logs = new Logs(self::$log_path, date('Y-m-d') . '.log');

        $logContent = array(
            'id'=>$this->uniqid,
            'log_time'=>date('Y-m-d H:i:s'),
            'acccount_id'=> $this->account_id,
            'return'=>$this->ret
        );
        $logContent = F::json_encode($logContent);
        $logs->LogInfo($logContent);

    }


    /**
     * 取得回话token值
     */
    public function getToken_Action(){

        $time = time();
        $this->ret['retData'] = F::authstr($this->account_id.','.$time, 'ENCODE');

        return $this->echojson($this->ret);

    }


}
