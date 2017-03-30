<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * phonearea 手机号区域模型控制器
 * @author zhengshufa
 * @date 2016-08-03 18:28:53
 */
class Phonearea_Controller extends Server_Controller
{

    /**
     * 读取手机所在地区与运营商
     * @param string $phone 手机号码
     * @return string json:
     * {
     * "errNum":0,//0表示成功,1表示失败
     * "errMsg":"success",//错误提示信息
     * "retData":{
     * "id":"自增ID",
     * "pref":"1811619",//电话号码前7位
     * "province":"身份",
     * "city":"城市",
     * "isp":"运营商",
     * "code":"区号",
     * "zip":"邮编"}
     * }
     */
    public function get_Action($phone){

        if(Valid::phone($phone, 11)){
            $pref = substr($phone, 0, 7);
            $phonearea = new phonearea_Model();
            $phonearea->getByPref($pref);

            if(!$phonearea->id){
                //淘宝免费接口
                $url = "https://tcc.taobao.com/cc/json/mobile_tel_segment.htm";
                $ret = common::curlExec($url, array('tel'=>$phone), false);
                $ret = $ret = iconv('gb2312', 'utf-8', $ret);
                $ret = funs::parseJsObjectString($ret);

                if(is_array($ret)){
                    $phonearea->pref = $pref;
                    $phonearea->province = $ret['province'];
                    $phonearea->city = @$ret['city'];
                    $phonearea->isp = $ret['carrier'];
                    $phonearea->code = 'none';
                    $phonearea->zip = 'none';

                    $phonearea->save();

                    $this->ret['retData'] = $phonearea;
                    return $this->echojson($this->ret);
                }

            }else{
                $this->ret['retData'] = $phonearea;
                return $this->echojson($this->ret);
            }
        }

        $this->ret['errNum'] = 1;
        $this->ret['errMsg'] = 'Can\'t get the ip information!';

        return $this->echojson($this->ret);
    }

}
