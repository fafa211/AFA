<?php if (!defined('AFA')) die();

/**
 * 控制器类
 *
 */
class Controller {
	
	/**
	 * 默认模板地址
	 *
	 */
	protected $template = 'template';
	public $isLogin =false;
	public function __construct(){
		$this->template = View::instance($this->template);
	}
	
	public function __call($method = '', $params = ''){
		common::go404();
	}
	
	public function echojson(){
	    
	}
	
	public function echomsg($message, $url = false){
        header("HTTP/1.1 200 OK");
        header("Status: 200");
        header("Content-Type: text/html; charset=UTF-8");
        if ($url){
            header("refresh:3;url=$url");
        }
        if (preg_match('/MSIE/i', input::server('HTTP_USER_AGENT'))) {
            echo str_repeat(" ", 512);
        }
        echo $message;
        exit();
	}
	
	public function echoerror(){
	    
	}
	
	public function echo404($message){
	    header("HTTP/1.1 404 Not Found");
	    header("Status: 404 Not Found");
	    header("Content-Type: text/html; charset=UTF-8");
	    if (preg_match('/MSIE/i',input::server('HTTP_USER_AGENT'))){
	        echo str_repeat(" ",512);
	    }
	    echo 'this 404 page <br />';
	    echo $message;
	    exit;
	}
	
}

/**
 * 模型类
 *
 */
class Model {
	//数据库链接对象
	public $db;
	//数据表名称
	protected $table;
	//主键字段，通常为自增ID字段
	protected $primary = 'id';
	public function __construct($id = null){
		$this->db = db::instance();
		if ($id){
		    $sql = sql::select('*', $this->table, array("$this->primary"=>$id));
			$orm = $this->db->getOneResult($sql);
			if ($orm){
                foreach ($orm as $k => $v) {
                    $this->$k = $v;
                }
            }
			unset($orm);
		}
	}
	
	/**
	 * 更新与插入  ORM
	 * @return Ambigous <boolean, number>
	 */
	public function save(){
	    $fieldsArr = array();
	    $insert = false;
	    foreach ($this->fileds as $f=>$v){
	        if ($f == $this->primary) continue;
	        $fieldsArr[$f] = isset($this->$f)?$this->$f:$v;
	    }
	    if ($this->{$this->primary}){
	        $sql = sql::update($fieldsArr, $this->table, array("{$this->primary}"=>$this->{$this->primary}));
	    }else{
	        $insert = true;
	        $sql = sql::insert($fieldsArr, $this->table);
	    }
	    
	    $flag = $this->db->exec($sql);
	    if ($flag && $insert){
	        //插入数据后更新当前数据的ID
	        $this->{$this->primary} = $this->db->getId(); 
	    }
	    return $flag;
	}
	
	/**
	 * 删除 ORM
	 */
	public function delete(){
	    if ($this->{$this->primary}){
	        $sql = sql::delete($this->table, array("{$this->primary}"=>"{$this->{$this->primary}}"));
	        return $this->db->exec($sql);
	    }
	    return false;
	}
	/**
	 * 基础查询
	 * @param string $limit
	 * @param array $where
	 * @param string $orderby
	 * @return multitype: 查询结果
	 */
	public function lists($limit = "0,10", $where = array(), $orderby = ''){
	    $sql = sql::select('*', $this->table)
	    ->where($where)
	    ->orderby($orderby?$orderby:"{$this->primary} DESC")
	    ->limit($limit)->render();
	    return $this->db->query($sql);
	}
	
	public function __get($name){
	    return isset($this->$name)?$this->$name:'';
	}
	
	public function __set($name, $value){
	    $this->$name = $value;
	}
}

/**
 * 视图类
 */
class View {
	/**
	 * 视图文件
	 */
	private $file = '';
	
	/**
	 * 视图变量存放
	 */
	private $params = array();
	
	/**
	 * 全局变量存放
	 */
	public static $global_params = array();
	
	/**
	 * 构造函数
	 *
	 * @param $file 视图文件名
	 */
	public function __construct($file){
		$this->set_file($file);
	}
	
	/**
	 * @param 静态方法
	 */
	public static function instance($file){
		return new View($file);
	}

	/**
	 * Magically sets a view variable.
	 *
	 * @param   string   variable key
	 * @param   string   variable value
	 * @return  void
	 */
	public function __set($key, $value)
	{
		$this->params[$key] = $value;
	}
	
	/**
	 * @param $file 视图文件名
	 */
	public function set_file($file)
	{
		$this->file = VIEPATH.$file.EXT;
	}

	/**
	 * Magically gets a view variable.
	 *
	 * @param  string  variable key
	 * @return mixed   variable value if the key is found
	 * @return void    if the key is not found
	 */
	public function &__get($key)
	{
		if (isset($this->params[$key]))
			return $this->params[$key];

		if (isset(View::$global_params[$key]))
			return View::$global_params[$key];

		if (isset($this->$key))
			return $this->$key;
	}
	
	/**
	 * 自动设置变量
	 */
	public function __call($func, $args = NULL){
		return $this->__get($func);
	}
    
	/**
	 * 自动设置变量
	 */
	public function render($render = true){
		if (!file_exists($this->file)){
			throw new Exception('view file not exit');
			exit();
		}
		$data = array_merge(View::$global_params, $this->params);
		// Buffering on
		ob_start();
		// Import the view variables to local namespace
		extract($data, EXTR_SKIP);
		
		include $this->file;

		// Fetch the output and close the buffer
		$str = ob_get_clean();
		if ($render) echo $str;
		return $str;
	}
	
	public function __toString(){
	    return $this->render(false);
	}
}

/**
 * 自动载入类
 */
class Load {
	
	static function loadClass($class_name)
	{
		if (strpos($class_name, '_') === false){
			if (($c = substr($class_name,0,1)) === strtolower($c)){
				$file = APPPATH.'helper'.DIRECTORY_SEPARATOR.$class_name.EXT;
				if (file_exists($file))	return include(APPPATH.'helper'.DIRECTORY_SEPARATOR.$class_name.EXT);
				else return include(CLASSPATH.$class_name.EXT);
			}else {
				return include(CLASSPATH.$class_name.EXT);
			}
		}else{
			$lastpos = strrpos($class_name, '_');
			$suffix = substr($class_name, $lastpos+1);
			$file = '';
			if ($suffix == 'Model'){
				$file = MODPATH.strtolower(substr($class_name, 0, $lastpos)).EXT;
			}elseif ($suffix == 'Controller'){
				$file = CONPATH.strtolower(substr($class_name, 0, $lastpos)).EXT;
			}
			
			if ($file && file_exists($file)) return include($file);
			common::go404('page not exist.--'.$class_name.' not exist。');
		}
	}
}

/**
* 设置对象的自动载入
*/
spl_autoload_register(array('Load', 'loadClass'));

/**
 * $_GET, $_POST, $_SERVER 控制 HTTP vars
 *
 */
class input{

	/**
     * Returns an array with all the variables in the GET header, fetching them
     * @static
     */
	public static function get($key = '', $value = '')
	{
		if ($value !== '') $_GET[$key] = $value;
		if ($key) return @$_GET[$key];
		return $_GET;
	}

	/**
     * Returns an array with all the variables in the POST header, fetching them
     */
	public static function post($key = '', $value = '')
	{
		if ($value !== '') $_POST[$key] = $value;
		if ($key) return @$_POST[$key];
		return $_POST;
	}


	/**
     * Returns an array with all the variables in the session, fetching them
     */
	public static function session($key = '', $value = '')
	{
		if ($value !== '') $_SESSION[$key] = $value;
		if ($key) return @$_SESSION[$key];
		return $_SESSION;
	}

	/**
     * Returns an array with the contents of the $_COOKIE global variable
     */
	public static function cookie($key = '', $value = '', $time = 3600)
	{
		if ($value !== '') {
			$_COOKIE[$key] = $value;
			setcookie($key, $value, time() + $time, '/');
		}
		if ($key) return @$_COOKIE[$key];
		return $_COOKIE;
	}

	/**
     * Returns the value of the $_REQUEST array. In PHP >= 4.1.0 it is defined as a mix
     * of the $_POST, $_GET and $_COOKIE arrays, but it didn't exist in earlier versions.
     */
	public static function request($key = '', $value = '')
	{
		if ($value !== '') $_REQUEST[$key] = $value;
		if ($key) return @$_REQUEST[$key];
		return $_REQUEST;
	}

	/**
     * Returns the $_SERVER array, otherwise known as $HTTP_SERVER_VARS in versions older
     * than PHP 4.1.0
     */
	public static function server($key = '', $value = '')
	{
		if ($value !== '') $_SERVER[$key] = $value;
		if ($key) return @$_SERVER[$key];
		return $_SERVER;
	}

	/**
     * Returns the $_SERVER array, otherwise known as $HTTP_SERVER_VARS in versions older
     * than PHP 4.1.0
     */
	public static function file($key = '')
	{
		if ($key) return @$_FILES[$key];
		return $_FILES;
	}
	

	/**
     * Returns the base URLs of the script
     * base/path/request/query/self
     */
	public static function uri($key = '')
	{
		switch ($key){
			case 'base': {
				return 'http://'.self::server('HTTP_HOST').'/';
			}
			case 'path': return self::server('PATH_INFO');
			case 'request': return self::server('REQUEST_URI');
			case 'query': return self::server('QUERY_STRING');
			case 'self': return self::server('PHP_SELF');
			default:	return '';
		}
	}

}