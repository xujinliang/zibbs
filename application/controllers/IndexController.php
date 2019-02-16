<?php
class IndexController extends Controller
{
    public function index()
    {
        $this->showtags();
        $query      = $this->db->query("select * from zibbs_setting where id=1");
        $settingarr = $query->fetch();
        $this->assign("settingarr", $settingarr);
        require('static/Fenye.class.php');
        $count = $this->db->query("select count(*) from zibbs_posts p left join zibbs_user u on p.userid=u.id order by p.newtime desc")->fetchColumn();
        $fenye = new Fenye($count, 10);
        $show  = $fenye->show();
        $sql   = $fenye->listcon("select p.*,u.username from zibbs_posts p left join zibbs_user u on p.userid=u.id order by p.newtime desc");
        $query = $this->db->query($sql);
        if ($query) {
            $allposts = $query->fetchAll();
            $this->assign("show", $show);
            $this->assign("allposts", $allposts);
        }
        $_SESSION['zibbs_visit'] = 1; //浏览标记
        $this->render();
    }
    public function tag()
    {
        $t     = intval($_GET['t']);
        $query = $this->db->query("select * from zibbs_tags where id='" . $t . "'");
        $rs    = $query->fetch();
        $this->assign("tagdesc", $rs);
        $this->showtags();
        require('static/Fenye.class.php');
        $count = $this->db->query("select count(*) from zibbs_posts p left join zibbs_user u on p.userid=u.id where p.tagid='" . $t . "' order by p.newtime desc")->fetchColumn();
        $fenye = new Fenye($count, 10);
        $show  = $fenye->show();
        $sql   = $fenye->listcon("select p.*,u.username from zibbs_posts p left join zibbs_user u on p.userid=u.id where p.tagid='" . $t . "' order by p.newtime desc");
        $query = $this->db->query($sql);
        if ($query) {
            $allposts = $query->fetchAll();
            $this->assign("show", $show);
            $this->assign("allposts", $allposts);
            $query    = $this->db->query("select * from zibbs_posts where tagid=" . $t . " and answers>0 and DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(time)  order by answers desc limit 15");
            $hotposts = $query->fetchAll();
            $this->assign("hotposts", $hotposts);
        }
        $this->render();
    }
    public function post()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $this->showtags();
        $query    = $this->db->query("select * from zibbs_posts where answers>0 and DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(time)  order by answers desc limit 15");
        $hotposts = $query->fetchAll();
        $this->assign("hotposts", $hotposts);
        $this->assign("zibbs_userid", $_SESSION['zibbs_userid']);
        $this->render();
    }
    public function viewpost()
    {
        $this->showtags();
        $query = $this->db->query("select * from zibbs_posts p left join zibbs_tags t on t.id = p.tagid where p.id='" . intval($_GET['pid']) . "'");
        $rs    = $query->fetch();
        if ($rs) {
            $this->assign("tagdesc", $rs);
        }
        require('static/Fenye.class.php');
        $count = $this->db->query("select count(*) from zibbs_posts p left join zibbs_replies r on p.id=r.pid left join zibbs_user u on p.userid=u.id where p.id='" . intval($_GET['pid']) . "' order by r.rtime asc")->fetchColumn();
        $fenye = new Fenye($count, 5);
        $show  = $fenye->show();
        $sql   = $fenye->listcon("select * from zibbs_posts p left join zibbs_replies r on p.id=r.pid where p.id='" . intval($_GET['pid']) . "' order by r.rtime asc");
        $query = $this->db->query($sql);
        $post  = $query->fetchAll();
        $this->assign("show", $show);
        require_once("static/Parsedown.php");
        $parser = new Parsedown();
        foreach ($post as $key => $p) {
            $post[$key]['content'] = $parser->text($p['content']);
            if (!empty($p['rcontent'])) {
                $post[$key]['rcontent'] = $parser->text($p['rcontent']);
            }
        }
        $this->assign("post", $post);
        $query    = $this->db->query("select * from zibbs_posts where id !='".intval($_GET['pid'])."' and userid=(select userid from zibbs_posts where id='".intval($_GET['pid'])."') order by id desc limit 15");
        $userpostlist = $query->fetchAll();
        $this->assign("userpostlist", $userpostlist);
        $query    = $this->db->query("select * from zibbs_user where id =(select userid from zibbs_posts where id='".intval($_GET['pid'])."')");
        $userpostinfo = $query->fetch();
        $this->assign("userpostinfo", $userpostinfo);
        if ($_SESSION['zibbs_visit'] == 1) {
            $this->db->exec("update zibbs_posts set views=views+1 where id='" . intval($_GET['pid']) . "'");
            $_SESSION['zibbs_visit'] = 0;
        }
        $this->assign("zibbs_userid", $_SESSION['zibbs_userid']);
        $this->render();
    }
    public function showtags()
    {
        $query = $this->db->query("select * from zibbs_tags order by sort desc,id desc");
        $rs    = $query->fetchAll();
        $this->assign("showtags", $rs);
        $setting = $this->getCfg();
        $this->assign("setting", $setting);
        if (!empty($_SESSION['zibbs_userid'])) {
            $userinfoquery = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
            $userinfo      = $userinfoquery->fetch();
            $this->assign("avatar", $userinfo['avatar']);
            $this->assign("msgmark", $userinfo['msgmark']);
        }
    }
    public function upload()
    {
        if (!$this->doverify()) {
            echo '未登录用户不能上传图片！';
            exit;
        }
        $path   = "./static/images/uploads/";
        $extArr = array(
            "jpg",
            "png",
            "gif",
            "jpeg",
            "pdf"
        );
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            $name = $_FILES['file']['name'];
            $size = $_FILES['file']['size'];
            if (empty($name)) {
                echo '请选择要上传的文件';
                exit;
            }
            $ext = $this->extend($name);
            if (!in_array($ext, $extArr)) {
                echo '图片格式错误！';
                exit;
            }
            if ($size > (2 * 1024 * 1024)) {
                echo '图片大小不能超过2M';
                exit;
            }
            $image_name = time() . rand(100, 999) . "." . $ext;
            $tmp        = $_FILES['file']['tmp_name'];
            if (move_uploaded_file($tmp, $path . $image_name)) {
                echo $path . $image_name;
            } else {
                echo '上传出错了！';
            }
            exit;
        }
    }
    public function extend($file_name)
    {
        $extend = pathinfo($file_name);
        $extend = strtolower($extend["extension"]);
        return $extend;
    }
    public function dopost()
    {
        if (!$this->doverify()) {
            echo false;
            exit;
        }
        $title   = addslashes(htmlspecialchars($_POST['title']));
        $tagid   = intval($_POST['tag']);
        $content = addslashes(htmlspecialchars($_POST['content']));
        if (mb_strlen($title,'utf-8') < 10 || mb_strlen($content,'utf-8') < 20) {
            echo false;
            exit;
        }
        if (!empty($title) && !empty($tagid) && !empty($content)) {
            $this->db->exec("insert into zibbs_posts set 
				userid='" . $_SESSION['zibbs_userid'] . "',
				title='" . $title . "',
				content='" . $content . "',
				tagid='" . $tagid . "',
				time=now(),
				newtime=now()");
            $this->dopostcount();
            echo true;
        } else {
            echo false;
        }
    }
    public function doviewpost()
    {
        if (!$this->doverify()) {
            echo false;
            exit;
        }
        ob_clean();
        $content = addslashes(htmlspecialchars($_POST['content']));
        if (mb_strlen($content,'utf-8') < 20) {
            echo false;
            exit;
        }
        $pid = intval($_POST['pid']);
        if (!empty($pid) && !empty($content)) {
            $this->db->exec("insert into zibbs_replies set 
				ruserid='" . $_SESSION['zibbs_userid'] . "',
				rcontent='" . $content . "',
				pid='" . $pid . "',
				rtime=now()");
            $this->db->exec("update zibbs_posts set newtime=now(),answers=answers+1 where id='" . $pid . "'");
            $this->dopostcount();
            
            //系统通知向发帖人发送通知
            $query      = $this->db->query("select userid from zibbs_posts where id=" . $pid);
            $queryarr   = $query->fetch();
            $touserid   = $queryarr['userid'];
            $query      = $this->db->query("select id from zibbs_user where status='-1'");
            $queryarr   = $query->fetch();
            $fromuserid = $queryarr['id'];
            if ($touserid == $_SESSION['zibbs_userid']) {
                echo true;
                exit;
            }
            $msg = new MsgController('', '', $this->_config);
            $rel = $msg->sysmsgsend($fromuserid, $touserid, $_SESSION['zibbs_userid'], $pid);
            if ($rel) {
                echo true;
            }
        } else {
            echo false;
        }
    }
    public function mycenter()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $this->showtags();
        $siteurl = $this->getCfg("siteurl");
        $this->assign("siteurl", $siteurl);
        $userinfoquery = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
        $userinfo      = $userinfoquery->fetch();
        $this->assign("avatar", $userinfo['avatar']);
        $this->render();
    }
    public function doavatar()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $userinfoquery = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
        $userinfo      = $userinfoquery->fetch();
        @unlink("./" . $userinfo['avatar']);
        $avatar = addslashes($_POST['avatar']);
        $avatar = preg_replace("/\/images\/\.\./", "", $avatar);
        $rel    = $this->db->exec("update zibbs_user set avatar='" . $avatar . "' where id=" . $_SESSION['zibbs_userid']);
        echo $rel;
    }
    public function mypub()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $this->showtags();
        require('static/Fenye.class.php');
        $count = $this->db->query("select count(*) from zibbs_posts p left join zibbs_user u on p.userid=u.id where u.id=" . $_SESSION['zibbs_userid'] . " order by p.id desc")->fetchColumn();
        $fenye = new Fenye($count, 10);
        $show  = $fenye->show();
        $sql   = $fenye->listcon("select p.*,u.username from zibbs_posts p left join zibbs_user u on p.userid=u.id where u.id=" . $_SESSION['zibbs_userid'] . " order by p.id desc");
        $query = $this->db->query($sql);
        if ($query) {
	        $mypubs  = $query->fetchAll();
	        $this->assign("show", $show);
	        $this->assign("mypubs", $mypubs);
	    }
        $this->render();
    }
    public function myrep()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $this->showtags();
        require('static/Fenye.class.php');
        $count = $this->db->query("select count(*) from (select * from zibbs_replies group by pid) r left join zibbs_user u on r.ruserid=u.id 
  	left join zibbs_posts p on p.id=r.pid where u.id=" . $_SESSION['zibbs_userid'] . " order by r.rid desc")->fetchColumn();
        $fenye = new Fenye($count, 10);
        $show  = $fenye->show();
        $sql   = $fenye->listcon("select p.*,u.username from (select * from zibbs_replies group by pid) r left join zibbs_user u on r.ruserid=u.id 
  	left join zibbs_posts p on p.id=r.pid where u.id=" . $_SESSION['zibbs_userid'] . " order by r.rid desc");
        $query = $this->db->query($sql);
        if ($query) {
	        $myreps  = $query->fetchAll();
	        $this->assign("show", $show);
	        $this->assign("myreps", $myreps);
	    }
        $this->render();
    }
    public function mypsw()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $this->showtags();
        $this->render();
    }
    public function domypsw()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $oldpsw = addslashes($_POST['oldpsw']);
        $newpsw = addslashes($_POST['newpsw']);
        $key    = require("config/key.php");
        require("core/encrypt.php");
        $queryuser = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid'] . " and password='" . cc_encrypt($oldpsw, $key) . "'");
        $u         = $queryuser->fetch();
        if ($u) {
            $this->db->exec("update zibbs_user set password='" . cc_encrypt($newpsw, $key) . "' where id=" . $u['id']);
            echo true;
        } else {
            echo false;
        }
    }
    public function whoami()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $this->showtags();
        $queryuser = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
        $u         = $queryuser->fetch();
        $this->assign("whoamidesc", $u['whoami']);
        $this->render();
    }
    public function dowhoami()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $whoamidesc = addslashes(htmlspecialchars($_POST['whoamidesc']));
        $rel        = $this->db->exec("update zibbs_user set whoami='" . $whoamidesc . "' where id=" . $_SESSION['zibbs_userid']);
        if ($rel) {
            echo true;
        } else {
            echo false;
        }
    }
    public function querywhoami()
    {
        $queryuser        = $this->db->query("select * from zibbs_user where id=" . intval($_POST['uid']));
        $u                = $queryuser->fetch();
        $json             = array();
        $json['username'] = $u['username'];
        $json['time']     = $u['time'];
        $json['whoami']   = !empty($u['whoami']) ? $u['whoami'] : '无';
        echo json_encode($json);
    }
    private function doverify()
    {
        if (empty($_SESSION['zibbs_userid'])) {
            return false;
        } else {
            $queryuser = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
            $u         = $queryuser->fetch();
            if ($u['status'] != '1') {
                unset($_SESSION['zibbs_user']);
                unset($_SESSION['zibbs_userid']);
                return false;
            } else {
                return true;
            }
        }
    }
    private function dopostcount()
    {
        $postscount = require("./config/posts.count.php");
        $month      = date("Ym", time());
        $d          = cal_days_in_month(CAL_GREGORIAN, date("m", time()), date("Y", time()));
        $day        = date("j", time());
        if (empty($postscount[$month])) {
            $postscount[$month] = array();
            for ($i = 1; $i <= $d; $i++) {
                if ($i == $day) {
                    $postscount[$month][$day] = 1;
                } else {
                    $postscount[$month][$i] = 0;
                }
            }
        } else {
            if (empty($postscount[$month][$day])) {
                $postscount[$month][$day] = 1;
            } else {
                $postscount[$month][$day] += 1;
            }
        }
        file_put_contents("./config/posts.count.php", "<?php\r\nreturn " . var_export($postscount, true) . "\r\n?>");
    }
}
?>