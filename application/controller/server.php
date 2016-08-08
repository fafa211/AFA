<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * man 手册模型控制器
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
     */
    public function before(){
        //客户端IP地址
        $this->client_ip = common::getIp();
        //接口调用唯一标识ID
        $this->uniqid =  md5(uniqid().$this->client_ip);
        self::$log_path = PROROOT.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'serverlog'.DIRECTORY_SEPARATOR;


        $logs = new Logs(self::$log_path, date('Y-m-d') . '.log');
        $logContent = array(
            'id' => $this->uniqid,
            'log_time' => date('Y-m-d H:i:s'),
            'ip' => $this->client_ip,
            'api' => $this->request->controller.'/'.$this->request->method,//接口名称
            'params' => $this->request->params,//接口参数
            'get_params' => input::get(),
            'post_parms' => input::post()
        );
        $logContent = json_encode($logContent);
        $logs->LogInfo($logContent);

    }

    /**
     * 执行后的服务调用记录,调用前后可通过唯一ID($this->uniqid)识别
     */
    public function after(){

        $logs = new Logs(self::$log_path, date('Y-m-d') . '.log');

        $logContent = array(
            'id'=>$this->uniqid,
            'log_time'=>date('Y-m-d H:i:s'),
            'return'=>$this->ret
        );
        $logContent = json_encode($logContent);
        $logs->LogInfo($logContent);

    }


}
