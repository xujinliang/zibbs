<?php
/**
 * 视图基类
 */
class View
{
    protected $variables = array();
    protected $_controller;
    protected $_action;
    protected $_config;

    function __construct($controller, $action, $config)
    {
        $this->_controller = strtolower($controller);
        $this->_action = strtolower($action);
        $this->_config = $config;
    }
 
    // 分配变量
    public function assign($name, $value)
    {
        $this->variables[$name] = $value;
    }
    
    //重要，加载外部函数，用于模版中调用函数！！！
    public function general()
    {
    	$args = func_get_args();
    	$general = new GeneralController('General',$args[0],$this->_config);
    	$func = array_shift($args);
    	return $general->$func($args);
    }
 
    // 渲染显示
    public function render($append)
    {
        extract($this->variables);
        
        if($append){
	        $defaultHeader = APP_PATH . 'application/views/header.php';
	        $defaultFooter = APP_PATH . 'application/views/footer.php';
	
	        $controllerHeader = APP_PATH . 'application/views/' . $this->_controller . '/header.php';
	        $controllerFooter = APP_PATH . 'application/views/' . $this->_controller . '/footer.php';

	        // 页头文件
	        if (file_exists($controllerHeader)) {
	            include ($controllerHeader);
	        } else {
	            include ($defaultHeader);
	        }
        }
        
        $controllerLayout = APP_PATH . 'application/views/' . $this->_controller . '/' . $this->_action . '.php';

        //判断视图文件是否存在
        if (file_exists($controllerLayout)) {
            include ($controllerLayout);
        } else {
            echo "<h1>无法找到视图文件</h1>";
        }
        
        if($append){
	        // 页脚文件
	        if (file_exists($controllerFooter)) {
	            include ($controllerFooter);
	        } else {
	            include ($defaultFooter);
	        }
	      }
    }
}
?>