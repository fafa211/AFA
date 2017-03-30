<?php defined('AFA') or die('No AFA PHP Framework!');

/**
 * idcarea模型控制器
 * @author zhengshufa
 * @date 2016-07-26 16:51:59
 */
class Idcarea_Controller extends Server_Controller
{

    //private $vdir = '';

    //private $the_level_arr = 'a:3:{i:1;s:18:"省份或直辖市";i:2;s:6:"市级";i:3;s:7:"区/县";}';


    /**
     * 列表管理 idcarea
     * @return html page
     */
//    public function lists_Action()
//    {
//        $idcarea = new idcarea_Model();
//        $view = &$this->view;
//        $view->set_view($this->vdir . 'lists');
//        $view->lists = $idcarea->lists('0,10');
//        $view->the_level_arr = unserialize($this->the_level_arr);
//        $view->list_fields_arr = array('id', 'address', 'the_level', 'name');
//        $view->render();
//    }

    /**
     * 展示idcarea
     * @param $id int 区域ID
     * @return html page
     */
//    public function show_Action($id)
//    {
//        $idcarea = new idcarea_Model($id);
//        $view = &$this->view;
//        $view->set_view($this->vdir . 'show');
//        $view->idcarea = $idcarea;
//        $view->the_level_arr = unserialize($this->the_level_arr);
//        $view->render();
//    }

    /**
     * 解析身份证所在地址
     * @param $idcard 身份证号码
     * @param $format 返回数据格式,详细说明如下:
     * simple:简单返回区域地址;
     * json:返回json数组;
     * jsonp:返回JS的脚本 json;
     * 需要(get方式)传递接受函数参数callback
     */
    public function parse_Action($idcard, $format='simple')
    {
        $id = substr($idcard, 0, 6);
        if(!is_numeric($id)) return;

        $this->getArea_Action($id, $format);

    }

    /**
     * api 根据区域ID读取区域信息
     * 测试解析地址
     * @param int $id 区域ID
     * @param $format 返回数据格式,详细说明如下:
     * simple:简单返回区域地址;
     * json:返回json数组;
     * jsonp:返回JS的脚本 json;
     * 需要(get方式)传递接受函数参数callback
     *
     * @return string string/json/jsonp, 返回结果事例说明如下:
     * string : 直接返回文本
     * json: {"errNum":0,"errMsg":"success","retData":{"id":"630000","address":"青海省","name":"青海省"}}
     * jsonp: jqueryTest({"errNum":0,"errMsg":"success","retData":{"id":"630000","address":"青海省","name":"青海省"}})  jqueryTest为callback所传值
     *
     */
    public function getArea_Action($id, $format='simple')
    {
        $idcarea = new idcarea_Model($id);

        if('simple' == $format || empty($format)){
            $data =  $idcarea->address;
            $this->ret['retData'] =  $data;
            return $this->echojson($data, $format);
        }else{
            $data = array(
                'id' => $idcarea->id,
                'address' => $idcarea->address,
                //'the_level' => $idcarea->the_level,
                'name' => $idcarea->name
            );
        }
        $this->ret['retData'] =  $data;

        $this->echojson($this->ret, $format);
    }

    /**
     * api 读取省市区列表数据
     * @param $parentId int 父区域ID,为0时读取1级省份级数据
     * @param $format 返回数据格式,详细说明如下:
     * json:返回json数组
     * jsonp:返回JS的脚本 json,
     * 需要(get方式)传递接受函数参数callback
     * @return string json/jsonp
     *
     */
    public function listAreas_Action($parentId = 0, $format='json')
    {
        $idcarea = new idcarea_Model();

        if(0 == $parentId){
            $sql = sql::select('id, name', $idcarea->table)->where('the_level','=',1);
            $this->ret['retData'] = $idcarea->db->query($sql);

        }else{
            $idcarea = new idcarea_Model($parentId);
            if(isset($idcarea->id) && $idcarea->id){
                if(1 == $idcarea->the_level){
                    $sql = sql::select('id, name')->
                    from($idcarea->table)->
                    where('id',' like ', substr($idcarea->id,0,2).'%')->
                    and_c('the_level','=',2);
                    $this->ret['retData'] = $idcarea->db->query($sql);
                }elseif(2 == $idcarea->the_level){
                    if(460200 == $idcarea->id){
                        $sql = sql::select('id, name')->
                        from($idcarea->table)->
                        where('id',' like ', '460%')->
                        and_c('the_level','=',3);
                    }else {
                        $sql = sql::select('id, name')->
                        from($idcarea->table)->
                        where('id', ' like ', substr($idcarea->id, 0, 4) . '%')->
                        and_c('the_level', '=', 3);
                    }
                    $this->ret['retData'] = $idcarea->db->query($sql);
                }
            }else{
                $this->ret['errNum'] = 1;
                $this->ret['errMsg'] = '区域ID不存在';
            }
        }
        $this->echojson($this->ret, $format);

    }


    /**
     * 验证并解析身份证号
     * @param $vStr 身份证号码
     * @return json string array
     */
    public function parseIdCard_Action($vStr)
    {
        $flag = true;

        if (preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) {
            $idcareaNo = substr($vStr, 0, 6);
            $idcarea = new idcarea_Model($idcareaNo);
            if(isset($idcarea->address) && $idcarea->address){

                $this->ret['retData']['address'] = $idcarea->address;

                $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
                $vLength = strlen($vStr);

                if ($vLength == 18)
                {
                    $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
                } else {
                    $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
                }

                if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) {
                    $this->ret['errMsg'] = '身份证号码不正确:生日错误';
                    $this->ret['errNum'] = 3;
                }else{
                    $this->ret['retData']['birthday'] = $vBirthday;
                }

                $sexNo = substr($vStr, 14, 3);
                $this->ret['retData']['sex'] = $sexNo%2==0?'女':'男';

                if ($vLength == 18)
                {
                    //验证校验码
                    $vSum = 0;

                    for ($i = 17 ; $i >= 0 ; $i--)
                    {
                        $vSubStr = substr($vStr, 17 - $i, 1);
                        $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
                    }

                    if($vSum % 11 != 1) {
                        if($flag) {
                            $this->ret['errMsg'] = '身份证号码不正确:校验码错误';
                            $this->ret['errNum'] = 4;
                        }
                    }
                }

            }else{
                $this->ret['errMsg'] = '身份证号码不正确:区域码错误';
                $this->ret['errNum'] = 2;
            }


        }else{
            $this->ret['errNum'] = 1;
            $this->ret['errMsg'] = '身份证格式不合法';
        }

        $this->echojson($this->ret);
    }

}