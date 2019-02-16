<?php
/**
 * 框架核心
 */
class Framework
{
    protected $_config = array();

    public function __construct($config)
    {
        $this->_config = $config;
    }

    // 运行程序
    public function run()
    {
        spl_autoload_register(array($this, 'loadClass'));
        $this->removeMagicQuotes();
        $this->route();
    }

    // 路由处理
    public function route()
    {
        $controllerName = $this->_config['defaultController'];
        $actionName = $this->_config['defaultAction'];
        
        $route = !empty($_GET['route']) ? addslashes($_GET['route']) : '';
        if ($route) {
            // 使用“/”分割字符串，并保存在数组中
            $urlArray = explode('/', $route);
            // 删除空的数组元素
            $urlArray = array_filter($urlArray);
            
            // 获取控制器名
            $controllerName = ucfirst($urlArray[0]);
            
            // 获取动作名
            array_shift($urlArray);
            $actionName = $urlArray ? $urlArray[0] : $actionName;

        }

        // 判断控制器和操作是否存在
        $controller = $controllerName . 'Controller';
        
        if (!class_exists($controller)) {
            exit($controller . '控制器不存在');
        }
        if (!method_exists($controller, $actionName)) {
            exit($actionName . '方法不存在');
        }

        // 如果控制器和操作名存在，则实例化控制器，因为控制器对象里面
        // 还会用到控制器名和操作名，所以实例化的时候把他们俩的名称也
        // 传进去。结合Controller基类一起看
        $dispatch = new $controller($controllerName, $actionName,$this->_config['db']);

        // $dispatch保存控制器实例化后的对象，我们就可以调用它的方法，
        // 也可以像方法中传入参数，以下等同于：$dispatch->$actionName($param)
        //call_user_func_array(array($dispatch, $actionName),'');
        $dispatch->$actionName();
    }

    // 删除敏感字符
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    // 检测敏感字符并删除
    public function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET ) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST ) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    // 自动加载控制器和模型类 
    public static function loadClass($class)
    {
        $frameworks = dirname(__FILE__) . '/' . $class . '.php';
        $controllers = APP_PATH . 'application/controllers/' . $class . '.php';

        if (file_exists($frameworks)) {
            // 加载框架核心类
            include $frameworks;
        } elseif (file_exists($controllers)) {
            // 加载应用控制器类
            include $controllers;
        } else {
            // 错误代码
        }
    }
}
?>