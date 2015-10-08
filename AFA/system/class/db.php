<?php if (!defined('AFA')) die();

/**
 * 数据库操作类 db 使用->PDO 接口
 * @author    alfa
 * @version    1.0
 */

class db
{   
	protected static $_this; //存储自身对象 
    private $db;
    private $dsn = "";
    private $user = "";
    private $pass = "";
    private $fetch_mode = PDO::FETCH_ASSOC;//读取数据方式FETCH_ASSOC \FETCH_NUM \FETCH_BOTH \FETCH_OBJ
	
    private static $write_db;
	private static $read_db;
	
    /**
     * 私有构造函数
     * @return  void
     */
    private function __construct() 
    {
    	$dbconfig = & $GLOBALS['config']['master'];
        $this->dsn = "mysql:host={$dbconfig['host']};dbname={$dbconfig['dbname']}";
        $this->user = $dbconfig['user'];
        $this->pass = $dbconfig['password'];

        $this->db = new PDO($this->dsn, $this->user, $this->pass, array(PDO::ATTR_PERSISTENT => $dbconfig['conmode']));
        self::$write_db=$this->db;
        $this->db->exec('SET NAMES '.$dbconfig['charset']);
      
    }
   
    /**
     * create database instance
     * @return pdoquery class object
     */
    public static function instance()
    {
    	if (!is_object(self::$_this)) {
    		self::$_this = new db();
    	}
    	return self::$_this;
    } 
    
    /**
     * 查询
     * @param  string $sql
     * @return  array 查询得到的数据数组
     */
    public function query($sql)
    {	
    	$this->OperationData($sql);
        $this->db->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $rs = $this->db->query($sql);
        $rs->setFetchMode($this->fetch_mode);
        return $rs->fetchAll();
    }
    
   
    /**
     * 更新/插入数据
     * @param  string $sql
     * @return  boolean 成功true
     */
    public function exec($sql)
    {
    	$this->OperationData($sql);
        return $this->db->exec($sql);
    }
   
    /**
     * @return  最新插入的数据ID
     */
    public function getId()
    {
    	$this->OperationData('update');
        return $this->db->lastInsertId();
    }

    /**
     * 得到查询结果中的第一行第一列数据
     *
     * @param  string $sql
     * @return  string
     */
    public function getOne($sql)
    {
    	$this->OperationData($sql);
        $rs = $this->db->query($sql);
        return $rs->fetchColumn();
    } 
    
    /**
     * 得到查询结果中的第一行数据
     *
     * @param  string $sql
     * @return  string
     */
    public function getOneResult($sql)
    {
    	$this->OperationData($sql);
        $rs = $this->db->query($sql);
		
        $rs->setFetchMode($this->fetch_mode);
        return $rs->fetch();
    }
    
    /**
     * 事务处理，执行一系列更新或插入语句
     */
    public function transaction($sqlQueue)
    {
        if(count($sqlQueue)>0)
        {
            //$this->result->closeCursor();
            try
            {
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
                $this->db->beginTransaction();
                foreach ($sqlQueue as $sql)
                {
                    $this->db->exec($sql);
                }
                $this->db->commit();
                return true;
            } catch (Exception $e) {
                $this->db->rollBack();
                return false;
            }
        }else{
            return false;
        }
    }
    
    /**
     * 处理mysql读写分离
     */
     private function OperationData($sql)
    {	
    	if (trim($sql) == '')
    		return ;
    		
    	$sql = trim(strtolower($sql));
    	$is_select = substr($sql, 0, 6);

    	if ($is_select == 'select'){

    		//file_put_contents('check_sql.txt','从机：'.$sql."\t".date("Y-m-d H:i:s")."\n",FILE_APPEND);
			if(is_object(self::$read_db)){
				return $this->db = self::$read_db;
			}
			$this->connectData();
    	}
    	else {
    		//file_put_contents('check_sql.txt','主机操作读写删：'.$sql."\t".date("Y-m-d H:i:s")."\n",FILE_APPEND);
			if(is_object(self::$write_db)){
				return $this->db = self::$write_db;
			}
			new db();
    	}
    }
    /**
     * 处理mysql连接
     */
    private function connectData(){
    					
		if (isset($GLOBALS['config']['slave']))
			$dbconfig =  $GLOBALS['config']['slave'];
		else 
			$dbconfig = & $GLOBALS['config']['master'];	
    
		$this->dsn = "mysql:host={$dbconfig['host']};dbname={$dbconfig['dbname']}";
		$this->user = $dbconfig['user'];
		$this->pass = $dbconfig['password'];
			    		
		self::$read_db = new PDO($this->dsn, $this->user, $this->pass, array(PDO::ATTR_PERSISTENT => $dbconfig['conmode']));
		$this->db =self::$read_db;
		$this->db->exec('SET NAMES '.$dbconfig['charset']);

       }
       
       
}