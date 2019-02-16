<?php
class CommonController extends Controller
{
    public function registerform()
    {
        $this->render(false);
    }
    public function loginform()
    {
        $this->render(false);
    }
    public function doregister()
    {
        $key = require("config/key.php");
        require("core/encrypt.php");
        $query      = $this->db->query("select * from zibbs_setting where id=1");
        $settingarr = $query->fetch();
        $username   = addslashes($_POST['username']);
        if (mb_strlen($username,'utf-8') < 3 || mb_strlen($username,'utf-8') > 12) {
            echo '0';
            exit;
        }
        if (!preg_match_all("/^[\x{4e00}-\x{9fa5}a-zA-Z0-9_]+$/u", $username, $tmp)) {
            echo '0';
            exit;
        }
        $email    = addslashes($_POST['email']);
        $password = addslashes($_POST['password']);
        $query    = $this->db->query("select * from zibbs_user where username='" . $username . "' or email='" . $email . "'");
        $rs       = $query->fetch();
        if ($rs) {
            echo '0';
        } else {
            $str  = "abcdefghijklmnopqrstuvwxyz0123456789";
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= substr($str, mt_rand(0, 35), 1);
            }
            $this->db->exec("insert into zibbs_user set username='" . $username . "',email='" . $email . "',password='" . cc_encrypt($password, $key) . "',avatar='static/images/default.jpg',code='" . $code . "',time=now()");
            $lastid = $this->db->lastInsertId();
            $this->dousercount();
            if (empty($settingarr['smtphost']) || empty($settingarr['smtpuser']) || empty($settingarr['smtppsw'])) {
                $subject = !empty($settingarr['smtpsubject']) ? $settingarr['smtpsubject'] : '梓论坛用户激活邮件';
                $body    = (!empty($settingarr['smtpcontent']) ? $settingarr['smtpcontent'] : '欢迎您的注册，请体验此论坛的魅力') . "<br><a href='" . $settingarr['siteurl'] . "/index.php?route=common/mailactive&id=" . $lastid . "&code=" . $code . "'>点此激活</a>";
                $from    = !empty($settingarr['smtpemail']) ? $settingarr['smtpemail'] : 'system@zibbs.youyax.com';
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=utf-8\r\n";
                $headers .= "From: 梓论坛" . "<" . $from . ">";
                if (!mail($email, $subject, $body, $headers)) {
                    echo '3';
                    exit;
                }
            } else {
                require_once("./static/phpmailer/class.phpmailer.php");
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host     = $settingarr['smtphost'];
                $mail->SMTPAuth = true;
                $mail->Username = $settingarr['smtpuser'];
                $mail->Password = $settingarr['smtppsw'];
                $mail->From     = !empty($settingarr['smtpemail']) ? $settingarr['smtpemail'] : 'system@zibbs.youyax.com';
                $mail->FromName = '梓论坛';
                $mail->AddAddress($email);
                $mail->IsHTML(true);
                $mail->CharSet  = "UTF-8";
                $mail->Encoding = "base64";
                $mail->Subject  = !empty($settingarr['smtpsubject']) ? $settingarr['smtpsubject'] : '梓论坛用户激活邮件';
                $mail->Body     = (!empty($settingarr['smtpcontent']) ? $settingarr['smtpcontent'] : '欢迎您的注册，请体验此论坛的魅力') . "<br><a href='" . $settingarr['siteurl'] . "/index.php?route=common/mailactive&id=" . $lastid . "&code=" . $code . "'>点此激活</a>";
                if (!$mail->Send()) {
                    echo '2';
                    exit;
                }
            }
            echo '1';
        }
    }
    public function dologin()
    {
        $key = require("config/key.php");
        require("core/encrypt.php");
        $account  = addslashes($_POST['account']);
        $password = addslashes($_POST['password']);
        $query    = $this->db->query("select * from zibbs_user where status=1 and (username='" . $account . "' or email='" . $account . "') and password='" . cc_encrypt($password, $key) . "'");
        $rs       = $query->fetch();
        if ($rs) {
            $_SESSION['zibbs_user']   = $rs['username'];
            $_SESSION['zibbs_userid'] = $rs['id'];
            echo true;
        } else {
            echo false;
        }
    }
    public function mailactive()
    {
        $id    = intval($_GET['id']);
        $code  = addslashes($_GET['code']);
        $query = $this->db->query("select * from zibbs_user where status=0 and id=" . $id . " and code='" . $code . "'");
        $rs    = $query->fetch();
        if ($rs) {
            $this->db->exec("update zibbs_user set status=1 where id=" . $id);
            $this->assign('info', '激活成功');
            $this->assign('icon', '1');
        } else {
            $this->assign('info', '操作错误，激活失败！');
            $this->assign('icon', '2');
        }
        $this->render(false);
    }
    public function logout()
    {
        unset($_SESSION['zibbs_user']);
        unset($_SESSION['zibbs_userid']);
        header("location:./");
    }
    private function dousercount()
    {
        $userscount = require("./config/users.count.php");
        $month      = date("Ym", time());
        $d          = cal_days_in_month(CAL_GREGORIAN, date("m", time()), date("Y", time()));
        $day        = date("j", time());
        if (empty($userscount[$month])) {
            $userscount[$month] = array();
            for ($i = 1; $i <= $d; $i++) {
                if ($i == $day) {
                    $userscount[$month][$day] = 1;
                } else {
                    $userscount[$month][$i] = 0;
                }
            }
        } else {
            if (empty($userscount[$month][$day])) {
                $userscount[$month][$day] = 1;
            } else {
                $userscount[$month][$day] += 1;
            }
        }
        file_put_contents("./config/users.count.php", "<?php\r\nreturn " . var_export($userscount, true) . "\r\n?>");
    }
}
?>