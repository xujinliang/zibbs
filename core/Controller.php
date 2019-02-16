<?php 
/**
 * 控制器基类
 */
class Controller
{
    protected $_controller;
    protected $_action;
    protected $_view;
    protected $db;
    protected $_config;
 
    // 构造函数，初始化属性，并实例化对应模型
    public function __construct($controller, $action, $config)
    {
    	   try {
            $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $config['host'], $config['dbname']);
            $option = array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
            $this->db = new PDO($dsn, $config['username'], $config['password'], $option);
            $this->db->exec("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary");
            $this->db->exec("SET sql_mode=''");
            $this->db->exec("SET NAMES utf8");
            date_default_timezone_set('PRC');
        } catch (PDOException $e) {
            exit('错误: ' . $e->getMessage());
        }
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_config = $config;
        $this->_view = new View($controller, $action ,$config);
    }

    // 分配变量
    public function assign($name, $value)
    {
        $this->_view->assign($name, $value);
    }

    // 渲染视图
    public function render($append=true)
    {
        $this->_view->render($append);
    }
    
    //获取配置项
    public function getCfg($key=''){
    		$query = $this->db->query("select * from zibbs_setting where id=1");
  		$settingarr = $query->fetch();
  		if(empty($key)){
  			return $settingarr;
  		}else{
    			return $settingarr[$key];
    		}
    }
    
}
?>