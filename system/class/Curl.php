<?php 

/**
 * Create instance of Curl 
 * $query = Curl::instance('config_entry');
 * 
 * or even simply put parameters
 * $opts = array(OPTION1 => $value1, OPTION2 => $value2);
 * $query = Curl::instance($opts); 
 * 
 * then we can set some additional options
 * 
 * $query
 *     ->set_opt(OPTION, $value)
 *     ->set_opt(ANOTHER_OPTION, $another_value);
 * 
 * or do it using array
 * 
 * $query->set_opts($opts);
 * 
 * and execute stuff
 *  
 * $result = $query->execute();
 *
 * @package Curl
 * @author Matt Wells
 * @author Alexander Kupreyeu (Kupreev) (http://kupreev.com)
 **/
class Curl {
    
    protected $instance = NULL;
    
    /**
     * Factory Method
     * @param   array  $config options array (will be merged with default entry)   
     * @return  object  new Curl object
     */
    public static function instance($config = NULL)
    {
        return new Curl($config);
    }
    
    /**
     * Constructor
     * @param   string|array  $config_entry name of config entry or options array (will be merged with default entry)   
     */
    public function __construct($config = NULL)
    {
        $config_arr = F::config('curl');
        
        $this->instance = curl_init();

        if (is_array($config))
        {
            $config_arr =  $config + $config_arr;
        }

        curl_setopt_array($this->instance, $config_arr);
        
    }
                     
    /**
     * Set option
     * @param string	$key	Curl option to set
     * @param string    $value	Value for option
     * @return  object  Curl
     */
    public function set_opt($key, $value)
    {
        curl_setopt($this->instance, $key, $value);
        
        return $this;
    }
    
    /**
     * Set options from array
     * @param   array   $options    array of options
     * @return  object  Curl 
     */
    public function set_opts($options)
    {
        curl_setopt_array($this->instance, $options);
        
        return $this;
    }
                     
    /**
     * Execute the curl request and return the response
     * @return string   Returned output from the requested resource
     * @throws Kohana_Exception
     */
    public function execute()
    {
        $result = curl_exec($this->instance);
        
        //Wrap the error reporting in an exception
        if ($result === FALSE)
        { 
            throw new Exception("Curl error: ".ucfirst(curl_error($this->instance)));
        }
        else
        {
            return $result;
        }
    }
    
    /**
     * Get error
     * Returns any current error for the curl request
     * @return  string  The error
     */
    public function get_error()
    {
        return curl_error($this->instance);
    }
    
    /**
     * Destructor
     */
    function __destruct()
    {
        curl_close($this->instance);
    }
    
    
    /**
     * Get
     * Execute an HTTP GET request using curl
     * @param   string  $url    url to request
     * @param   array   $headers    additional headers to send in the request
     * @param   bool    $headers_only   flag to return only the headers
     * @param   array   $curl_options   Additional curl options to instantiate curl with
     * @return  string  result
     */
    public static function get($url, Array $headers = array(), $headers_only = FALSE, Array $curl_options = array())
    {
        $count = 0;
        curltag1:
        try {
            $ch = Curl::instance($curl_options);

            $ch->set_opt(CURLOPT_URL, $url)
                ->set_opt(CURLOPT_RETURNTRANSFER, TRUE)
                ->set_opt(CURLOPT_NOBODY, $headers_only);

            $ch->set_opt(CURLOPT_NOSIGNAL, 1);//处理毫秒级设置的的BUG
            $ch->set_opt(CURLOPT_FRESH_CONNECT, 1);//强制获取一个新的连接，而不是缓存中的连接
            $ch->set_opt(CURLOPT_CONNECTTIMEOUT_MS, 1000);//尝试连接等待的时间，以毫秒为单位。设置为0，则无限等待。
            $ch->set_opt(CURLOPT_TIMEOUT_MS, 2000);//设置cURL允许执行的最长毫秒数

            // Set any additional headers
            if (!empty($headers)) {
                $ch->set_opt(CURLOPT_HTTPHEADER, $headers);
            }
            $count++;
            return $ch->execute();
        }catch(Exception $e){
            if($count == 1) {
                goto curltag1;
            }
        }
    }
    
    
    /**
     * Post
     * Execute an HTTP POST request, posting the past parameters
     * @param   string  $url    url to request
     * @param   array   $data   past data to post to $url
     * @param   array   $headers    additional headers to send in the request
     * @param   bool    $headers_only   flag to return only the headers
     * @param   array   $curl_options   additional curl options to instantiate curl with
     * @return  string  result 
     */
    public static function post($url, Array $data = array(), Array $headers = array(), $headers_only = FALSE, Array $curl_options = array())
    {
        $count = 0;
        curltag2:
        try {
            $ch = Curl::instance($curl_options);

            $ch->set_opt(CURLOPT_URL, $url)
                ->set_opt(CURLOPT_NOBODY, $headers_only)
                ->set_opt(CURLOPT_RETURNTRANSFER, TRUE)
                ->set_opt(CURLOPT_POST, TRUE)
                ->set_opt(CURLOPT_POSTFIELDS, $data);

            $ch->set_opt(CURLOPT_NOSIGNAL, 1);//处理毫秒级设置的的BUG
            $ch->set_opt(CURLOPT_FRESH_CONNECT, 1);//强制获取一个新的连接，而不是缓存中的连接
            $ch->set_opt(CURLOPT_CONNECTTIMEOUT_MS, 1000);//尝试连接等待的时间，以毫秒为单位。设置为0，则无限等待。
            $ch->set_opt(CURLOPT_TIMEOUT_MS, 2000);//设置cURL允许执行的最长毫秒数

            //Set any additional headers
            if (!empty($headers)) {
                $ch->set_opt(CURLOPT_HTTPHEADER, $headers);
            }

            return $ch->execute();
        } catch (Exception $e) {
            if ($count == 1) {
                goto curltag2;
            }
        }
    }
} // End Curl class