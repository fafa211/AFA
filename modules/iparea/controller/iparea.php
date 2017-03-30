<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * iparea模型控制器
 * @author zhengshufa
 * @date 2016-08-02 15:20:55
 */
class Iparea_Controller extends Server_Controller
{

    /**
     * 读取IP所在地区与运营商
     * @param string $ip
     * @return string json:
     * {
     * "errNum":0,//0表示成功,1表示失败
     * "errMsg":"success",//错误提示信息
     * "retData":{
     * "ip":"IP地址",
     * "country":"国家",
     * "province":"省份",
     * "city":"城市",
     * "county":"地区",
     * "isp":"运营商",
     * "the_time":"更新时间"}
     * }
     */
    public function get_Action($ip){

        //本地数据库(MYSQL)查找
        $iparea = new iparea_Model($ip);
        if($iparea->ip){
            $this->ret['retData'] = $this->getRetData($iparea);
            return $this->echojson($this->ret);
        }

        //本地IP数据看解析优先
        $ipret = ipdata::convertip($ip);
        $ipret = ipdata::parseCityAndLan($ipret);
        if($ipret['flag'] == -1){
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = 'The ip is invalid!';

            return $this->echojson($this->ret);
        }
        if($ipret['flag'] == 1){
            //不能精准到城市时, 放弃返回结果, 走第三方接口
            if($ipret['data']['city'] && $ipret['data']['city'] != 'none') {
                $this->ret['retData'] = $this->getRetData($ipret['data']);
                return $this->echojson($this->ret);
            }
        }

        //百度免费接口
        $url = "http://apis.baidu.com/apistore/iplookupservice/iplookup?ip=".$ip;
        $ipret = common::curlExec($url, array('ip'=>$ip), false, array('apikey:7be89f59581e634eedd0b62072e83267'));

        $ipret = json_decode($ipret);

        if($ipret->errNum == 0) {
            $ipret = $ipret->retData;
            $iparea->ip = $ip;//设置IP值, IP值为主键
            $iparea->country = $ipret->country;
            $iparea->province = $ipret->province;
            $iparea->city = $ipret->city;
            $iparea->county = $ipret->district;
            $iparea->isp = $ipret->carrier;

            $iparea->insert();


            $this->ret['retData'] = $this->getRetData($iparea);
            return $this->echojson($this->ret);
        }

        //淘宝免费接口
        $ipret = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);
        $ipret = json_decode($ipret,true);

        if($ipret['code'] == 0) {
            $ipret = $ipret['data'];
            $iparea->ip = $ip;//设置IP值, IP值为主键
            $iparea->country = $ipret['country'];
            $iparea->province = $ipret['region'];
            $iparea->city = $ipret['city'];
            $iparea->county = $ipret['county'];
            $iparea->isp = $ipret['isp'];

            $iparea->insert();

            $this->ret['retData'] = $this->getRetData($iparea);
            $this->echojson($this->ret);
        }

        $this->ret['errNum'] = 1;
        $this->ret['errMsg'] = 'Can\'t get the ip information!';

        return $this->echojson($this->ret);
    }


    /**
     *
     * 返回需要的数据格式数组
     *
     * @param $data  数组或对象
     */
    private function getRetData($data){
        if(is_array($data)){
            return array(
                'country'=>$data['country'],
                'province'=>@$data['province'],
                'city'=>@$data['city'],
                'county'=>@$data['county'],
                'isp'=>@$data['isp']
            );
        }elseif(is_object($data)){
            return array(
                'country'=>$data->country,
                'province'=>@$data->province,
                'city'=>@$data->city,
                'county'=>@$data->county,
                'isp'=>@$data->isp
            );
        }

    }

}
