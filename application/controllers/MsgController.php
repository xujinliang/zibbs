<?php
class MsgController extends Controller
{
    //消息关闭API
    private function api_closepmb($email, $mid)
    {
        $sql_tmp       = "select * from `zibbs_master_pmb` where t_num=" . intval($mid);
        $query_sql_tmp = $this->db->query($sql_tmp);
        $arr_tmp       = $query_sql_tmp->fetch();
        if ($email == $arr_tmp['email']) {
            $sql = "update `zibbs_slave_pmb` set status='closed' where t_num=" . intval($mid);
            $this->db->exec($sql);
            $sql = "update `zibbs_master_pmb` set status='closed' where r_num=" . intval($mid);
            $this->db->exec($sql);
        } else {
            $sql_tmp       = "select * from `zibbs_slave_pmb` where t_num=" . intval($mid);
            $query_sql_tmp = $this->db->query($sql_tmp);
            $arr_tmp       = $query_sql_tmp->fetch();
            if ($email == $arr_tmp['email']) {
                $sql = "update `zibbs_master_pmb` set status='closed' where t_num=" . intval($mid);
                $this->db->exec($sql);
                $sql = "update `zibbs_master_pmb` set status='closed' where r_num=" . intval($mid);
                $this->db->exec($sql);
            }
        }
        return true;
    }
    //消息列表
    private function api_listspmb($uid, $uemail, $pagesize)
    {
        $msgarr    = array();
        $resultset = array();
        $sql       = "select * from (
			   select num,createdDate,createdByUserNum,updatedDate,updatedByUserNum,message_read,r_num,fullname,email,message,subject,t_num,status from `zibbs_master_pmb` where createdByUserNum='" . $uid . "' and r_num is null and (status is null or status='open')
					union all 
			   select num,createdDate,createdByUserNum,updatedDate,updatedByUserNum,message_read,r_num,fullname,email,message,subject,t_num,status from `zibbs_slave_pmb` where createdByUserNum='" . $uid . "'  and r_num is null and (status is null or status='open'))tmp  order by tmp.t_num*1 desc";
        $query     = $this->db->query($sql);
        $num       = count($query->fetchAll());
        if ($num > 0) {
            $fenye = new Fenye($num, $pagesize);
            $show  = $fenye->show();
            $sql   = $fenye->listcon($sql);
            $query = $this->db->query($sql);
            if ($num > 0) {
                $number = 0;
                while ($arr = $query->fetch()) {
                    $number++;
                    $msgarr[$number]['mid'] = $arr['t_num'];
                    if ($arr['message_read'] == '0') {
                        $msgarr[$number]['message_read'] = 1;
                    }
                    //sender
                    $lasttime      = '';
                    $sql_tmp_1_1   = "select * from zibbs_master_pmb where (t_num=" . $arr['t_num'] . " or r_num=" . $arr['t_num'] . ") order by num desc";
                    $query_tmp_1_1 = $this->db->query($sql_tmp_1_1);
                    $arr_tmp_1_1   = $query_tmp_1_1->fetch();
                    $lasttime      = $arr_tmp_1_1['createdDate']; //get time
                    $num_tmp_1_1   = $this->db->query("select count(*) from zibbs_master_pmb where createdByUserNum=" . $uid . "  and (t_num=" . $arr['t_num'] . " or r_num=" . $arr['t_num'] . ") order by num desc")->fetchColumn();
                    if ($num_tmp_1_1 >= 1) {
                        $sql_tmp_1_1   = "select * from zibbs_master_pmb where (t_num=" . $arr['t_num'] . " or r_num=" . $arr['t_num'] . ") order by num desc";
                        $query_tmp_1_1 = $this->db->query($sql_tmp_1_1);
                        $arr_tmp_1_1   = $query_tmp_1_1->fetch();
                        if ($arr_tmp_1_1['email'] == $uemail) {
                            $msgarr[$number]['sender'] = '我';
                        } else {
                            $msgarr[$number]['sender'] = $arr['email'];
                        }
                    } else {
                        $sql_tmp_1_1   = "select * from zibbs_slave_pmb where  t_num=" . $arr['t_num'] . " order by num desc";
                        $query_tmp_1_1 = $this->db->query($sql_tmp_1_1);
                        $num_tmp_1_1   = $this->db->query("select count(*) from zibbs_slave_pmb where  t_num=" . $arr['t_num'] . " order by num desc")->fetchColumn();
                        if ($num_tmp_1_1 > 0) {
                            $arr_tmp_1_1 = $query_tmp_1_1->fetch();
                            if ($arr_tmp_1_1['updatedByUserNum'] == 0) {
                                $msgarr[$number]['sender'] = '我';
                            } else {
                                $msgarr[$number]['sender'] = $arr['email'];
                            }
                        }
                    }
                    //receiver
                    $lasttime      = '';
                    $sql_tmp_1_1   = "select * from zibbs_master_pmb where (t_num=" . $arr['t_num'] . " or r_num=" . $arr['t_num'] . ") order by num desc";
                    $query_tmp_1_1 = $this->db->query($sql_tmp_1_1);
                    $arr_tmp_1_1   = $query_tmp_1_1->fetch();
                    $lasttime      = $arr_tmp_1_1['createdDate']; //get time
                    $num_tmp_1_1   = $this->db->query("select count(*) from zibbs_master_pmb where createdByUserNum=" . $uid . "  and (t_num=" . $arr['t_num'] . " or r_num=" . $arr['t_num'] . ") order by num desc")->fetchColumn();
                    if ($num_tmp_1_1 >= 1) {
                        $sql_tmp_1_1   = "select * from zibbs_master_pmb where (t_num=" . $arr['t_num'] . " or r_num=" . $arr['t_num'] . ") order by num desc";
                        $query_tmp_1_1 = $this->db->query($sql_tmp_1_1);
                        $arr_tmp_1_1   = $query_tmp_1_1->fetch();
                        if ($arr_tmp_1_1['email'] == $uemail) {
                            $msgarr[$number]['receiver'] = $arr['email'];
                        } else {
                            $msgarr[$number]['receiver'] = '我';
                        }
                    } else {
                        $sql_tmp_1_1   = "select * from zibbs_slave_pmb where t_num=" . $arr['t_num'] . " order by num desc";
                        $query_tmp_1_1 = $this->db->query($sql_tmp_1_1);
                        $num_tmp_1_1   = $this->db->query("select count(*) from zibbs_slave_pmb where t_num=" . $arr['t_num'] . " order by num desc")->fetchColumn();
                        if ($num_tmp_1_1 > 0) {
                            $arr_tmp_1_1 = $query_tmp_1_1->fetch();
                            if ($arr_tmp_1_1['updatedByUserNum'] != 0) {
                                $msgarr[$number]['receiver'] = '我';
                            } else {
                                $msgarr[$number]['receiver'] = $arr['email'];
                            }
                        }
                    }
                    //subject
                    $msgarr[$number]['subject']     = $arr['subject'] . " (ID:" . $arr['t_num'] . ")";
                    $msgarr[$number]['lastupdated'] = date("Y-m-d H:i:s", $lasttime);
                }
            }
        } else {
            $show = '';
        }
        $resultset['results'] = $msgarr;
        $resultset['show']    = $show;
        return $resultset;
    }
    //回复消息API
    private function api_replypmb($mid, $ufrom, $msg, $attachfile = '')
    {
        $msql   = "select * from zibbs_master_pmb  where t_num='" . intval($mid) . "'";
        $mquery = $this->db->query($msql);
        $mnum   = $this->db->query("select count(*) from zibbs_master_pmb  where t_num='" . intval($mid) . "'")->fetchColumn();
        if ($mnum > 0) {
            $result   = $mquery->fetch();
            $result_2 = '';
            if ($ufrom['id'] != $result['createdByUserNum']) {
                $msql_2   = "select * from zibbs_slave_pmb  where t_num='" . intval($mid) . "'";
                $mquery_2 = $this->db->query($msql_2);
                $mnum_2   = $this->db->query("select count(*) from zibbs_slave_pmb  where t_num='" . intval($mid) . "'")->fetchColumn();
                if ($mnum_2 > 0) {
                    $result_2 = $mquery_2->fetch();
                    if ($ufrom['id'] != $result_2['createdByUserNum']) {
                        exit('无权限!');
                    }
                } else {
                    exit('无权限!');
                }
            }
        } else {
            exit('无记录!');
        }
        if (!empty($result_2)) {
            $toemail = $result_2['email'];
            $toname  = $result_2['fullname'];
            $this->db->exec("update zibbs_user set msgmark=1 where email='" . $result_2['email'] . "'");
            $sql = "update zibbs_master_pmb set message_read=0 where t_num='" . intval($mid) . "'";
            $this->db->exec($sql);
        } else {
            $toemail = $result['email'];
            $toname  = $result['fullname'];
            $this->db->exec("update zibbs_user set msgmark=1 where id='" . $result['updatedByUserNum'] . "'");
            $sql = "update zibbs_slave_pmb set message_read=0 where t_num='" . intval($mid) . "'";
            $this->db->exec($sql);
        }
        
        $sql = "update `zibbs_slave_pmb` set status='open' where t_num=" . intval($mid);
        $this->db->exec($sql);
        $sql = "update `zibbs_master_pmb` set status='open' where t_num=" . intval($mid) . " or r_num=" . intval($mid);
        $this->db->exec($sql);
        
        if (!empty($attachfile)) {
            $atta         = '<div style="border-top:1px dashed #ddd;height:2px;"></div><ul class="file-icons">';
            $attaches_pmb = explode("attach::attach", $attachfile);
            foreach ($attaches_pmb as $m) {
                $m_tmp = substr($m, strrpos($m, ".") + 1);
                if (in_array($m_tmp, array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png',
                    'bmp'
                ))) {
                    $m_tmp = "img";
                }
                $atta .= "<li class='" . $m_tmp . "'><a target='_blank' href='./imap/example/attachments/" . intval($mid) . "/" . $m . "'>" . $m . "</a></li>";
            }
            $atta .= '</ul>';
        } else {
            $atta = '';
        }
        $tmp_sql   = "select * from `zibbs_slave_pmb` where t_num='" . intval($mid) . "'";
        $tmp_query = $this->db->query($tmp_sql);
        $tmp_num   = $this->db->query("select count(*) from `zibbs_slave_pmb` where t_num='" . intval($mid) . "'")->fetchColumn();
        if ($tmp_num <= 0) {
            $sql = "insert into `zibbs_master_pmb`(createdDate,createdByUserNum,email,message,r_num)  values('" . time() . "','" . $ufrom['id'] . "','" . addslashes($ufrom['email']) . "','" . addslashes(nl2br(htmlspecialchars($msg)) . $atta) . "','" . intval($mid) . "')";
            $this->db->exec($sql);
            $createdByUserNum_copy = $ufrom['id'];
            $updatedByUserNum_copy = $ufrom['id'];
            $email_copy            = $ufrom['email'];
            $message_copy          = nl2br(addslashes(htmlspecialchars($msg)));
            $fullname_copy         = @$ufrom['fullname'];
            $subject_copy          = $result['subject'];
            $this->db->exec("INSERT INTO `zibbs_slave_pmb` SET             
	                      createdDate               = '" . time() . "',
	                      updatedDate               = '" . time() . "',
	                      createdByUserNum          = '" . $createdByUserNum_copy . "',
	                      updatedByUserNum          = '" . $updatedByUserNum_copy . "',
	                      message_read				='0',
	                      email						='" . $email_copy . "',
	                      message					='" . $message_copy . "',
	                      fullname				='" . $fullname_copy . "',
	                      subject           		='" . $subject_copy . "',
	                      t_num						='" . intval($mid) . "'");
        } else {
            $arr_sql = $tmp_query->fetch();
            if ($arr_sql['email'] == $ufrom['email']) {
                $sql = "update zibbs_slave_pmb set updatedByUserNum=" . $ufrom['id'] . " where t_num='" . intval($mid) . "'";
                $this->db->exec($sql);
            } else {
                $sql = "update zibbs_slave_pmb set updatedByUserNum=0 where t_num='" . intval($mid) . "'";
                $this->db->exec($sql);
            }
            $sql = "insert into `zibbs_master_pmb`(createdDate,createdByUserNum,email,message,r_num)  values('" . time() . "','" . $ufrom['id'] . "','" . addslashes($ufrom['email']) . "','" . addslashes(nl2br(htmlspecialchars($msg)) . $atta) . "','" . intval($mid) . "')";
            $this->db->exec($sql);
        }
        return true;
    }
    //发送消息API
    private function api_sendpmb($ufrom, $uto, $title, $msg, $attachfile = '')
    {
        $this->db->exec("INSERT INTO `zibbs_master_pmb` SET             
	                      createdDate               = '" . time() . "',
	                      updatedDate               = '" . time() . "',
	                      createdByUserNum          = '" . @$uto['id'] . "',
	                      updatedByUserNum          = '" . @$ufrom['id'] . "',
	                      message_read				='0',
	                      email						='" . @$ufrom['email'] . "',
	                      message					='" . nl2br(addslashes(htmlspecialchars($msg))) . "',
	                      fullname					='" . @$ufrom['fullname'] . "',
	                      subject           		='" . addslashes(htmlspecialchars($title)) . "'");
        $mid = $this->db->lastInsertId();
        $this->db->exec("update `zibbs_master_pmb` SET t_num=" . $mid . " where num=" . $mid);
        $this->db->exec("INSERT INTO `zibbs_slave_pmb` SET             
	                      createdDate               = '" . time() . "',
	                      updatedDate               = '" . time() . "',
	                      createdByUserNum          = '" . @$ufrom['id'] . "',
	                      updatedByUserNum          = '',
	                      message_read				='1',
	                      email						='" . addslashes(@$uto['email']) . "',
	                      message					= '',
	                      fullname					='" . @$uto['fullname'] . "',
	                      subject           		='" . addslashes(htmlspecialchars($title)) . "',
	                      t_num						='" . $mid . "'");
        if (!empty($attachfile)) {
            $atta         = '<div style="border-top:1px dashed #ddd;height:2px;"></div><ul class="file-icons">';
            $attaches_pmb = explode("attach::attach", $attachfile);
            foreach ($attaches_pmb as $m) {
                $m_tmp = substr($m, strrpos($m, ".") + 1);
                if (in_array($m_tmp, array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png',
                    'bmp'
                ))) {
                    $m_tmp = "img";
                }
                $atta .= "<li class='" . $m_tmp . "'><a target='_blank' href='./imap/example/attachments/" . intval($mid) . "/" . $m . "'>" . $m . "</a></li>";
            }
            $atta .= '</ul>';
            $mcon = nl2br(addslashes($msg . $atta));
            $this->db->exec("update `zibbs_master_pmb` SET message='" . $mcon . "' where num=" . $mid);
        }
        return $mid;
    }
    //消息浏览API
    private function api_viewpmb($uid, $mid)
    {
        $msgarr = array();
        $msql   = "select * from zibbs_master_pmb where t_num='" . intval($mid) . "'";
        $mquery = $this->db->query($msql);
        $mnum   = $this->db->query("select count(*) from zibbs_master_pmb where t_num='" . intval($mid) . "'")->fetchColumn();
        if ($mnum > 0) {
            $result   = $mquery->fetch();
            $result_2 = '';
            if ($uid != $result['createdByUserNum']) {
                $msql_2   = "select * from zibbs_slave_pmb where t_num='" . intval($mid) . "'";
                $mquery_2 = $this->db->query($msql_2);
                $mnum_2   = $this->db->query("select count(*) from zibbs_slave_pmb where t_num='" . intval($mid) . "'")->fetchColumn();
                if ($mnum_2 > 0) {
                    $result_2 = $mquery_2->fetch();
                    if ($uid != $result_2['createdByUserNum']) {
                        exit('无权限!');
                    }
                    if ($result_2['message_read'] == '0') {
                        $this->db->exec("update zibbs_slave_pmb set message_read=1 where t_num='" . intval($mid) . "'");
                        $this->db->exec("update zibbs_user set msgmark=0 where id='" . $result_2['createdByUserNum'] . "'");
                    }
                } else {
                    exit('无权限!');
                }
            }
            if (empty($result_2)) {
                if ($result['message_read'] == '0') {
                    $this->db->exec("update zibbs_master_pmb set message_read=1 where t_num='" . intval($mid) . "'");
                    $this->db->exec("update zibbs_user set msgmark=0 where id='" . $result['createdByUserNum'] . "'");
                }
            } else {
                if ($result['message_read'] == '0') {
                    $this->db->exec("update zibbs_slave_pmb set message_read=1 where t_num='" . intval($mid) . "'");
                }
            }
        } else {
            exit('无记录!');
        }
        $marr    = array();
        $msql2   = "select * from zibbs_master_pmb where r_num='" . intval($mid) . "' order by num desc";
        $mquery2 = $this->db->query($msql2);
        $mnum2   = $this->db->query("select count(*) from zibbs_master_pmb where r_num='" . intval($mid) . "' order by num desc")->fetchColumn();
        if ($mnum2 > 0) {
            while ($result2 = $mquery2->fetch()) {
                $marr[] = $result2;
            }
        }
        if (!empty($marr)) {
            foreach ($marr as $k => $v) {
                $k++;
                $msgarr[$k]['sender']  = $v['email'];
                $msgarr[$k]['message'] = preg_replace('/<([^@<>\s]*@[^\.\s]*\.[^<>\s]*)>/', '&lt;$1&gt;', $v['message']);
                $msgarr[$k]['time']    = date("Y-m-d H:i:s", $v['createdDate']);
            }
        }
        if (!empty($result)) {
            $msgarr[0]['sender']  = $result['email'];
            $msgarr[0]['message'] = preg_replace('/<([^@<>\s]*@[^\.\s]*\.[^<>\s]*)>/', '&lt;$1&gt;', $result['message']);
            $msgarr[0]['time']    = date("Y-m-d H:i:s", $result['createdDate']);
        }
        $msgarr = array_values($msgarr);
        return $msgarr;
    }
    
    /****  实战  ****/
    //发送消息
    public function sendmsg()
    {
        $lid = intval($_GET['lid']);
        $set = intval($_GET['set']);
        $this->assign('lid', $lid);
        $this->assign('set', $set);
        $this->render(false);
    }
    public function dosendmsg()
    {
        if (!$this->doverify()) {
            echo false;
            exit;
        }
        $lid        = intval($_POST['lid']);
        $set        = intval($_POST['set']);
        $title      = addslashes($_POST['title']);
        $msgcontent = addslashes($_POST['msgcontent']);
        $ufromarr   = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
        $ufrom      = $ufromarr->fetch();
        if ($set == 1) {
            $utoarr = $this->db->query("select u.* from zibbs_user u left join zibbs_posts p on p.userid=u.id where p.id=" . $lid);
            $uto    = $utoarr->fetch();
        }
        if ($set == 2) {
            $utoarr = $this->db->query("select u.* from zibbs_user u left join zibbs_replies r on r.ruserid=u.id where r.rid=" . $lid);
            $uto    = $utoarr->fetch();
        }
        if ($ufrom['id'] == $uto['id']) {
            echo false;
            exit;
        }
        $ufrom['fullname'] = $ufrom['username'];
        $uto['fullname']   = $uto['username'];
        $attachfile        = '';
        $rel               = $this->api_sendpmb($ufrom, $uto, $title, $msgcontent, $attachfile);
        $this->db->exec("update zibbs_user set msgmark=1 where id='" . $uto['id'] . "'");
        echo $rel;
    }
    //系统通知
    public function sysmsgsend($fromuserid, $touserid, $rid, $pid)
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $userfromquery        = $this->db->query("select * from zibbs_user where id=" . $fromuserid);
        $userfrom             = $userfromquery->fetch();
        $userfrom['fullname'] = $userfrom['username'];
        $usertoquery          = $this->db->query("select * from zibbs_user where id=" . $touserid);
        $userto               = $usertoquery->fetch();
        $userto['fullname']   = $userto['username'];
        $userrequery          = $this->db->query("select * from zibbs_user where id=" . $rid);
        $userre               = $userrequery->fetch();
        $mid                  = $this->api_sendpmb($userfrom, $userto, '您有一个系统通知，请注意查收！', $userre['username'] . ' 回答了你的主题，点击<a style="font-size:16px;" target="_blank" href="./index.php?route=index/viewpost&pid=' . $pid . '">此处</a>查看', '');
        $rel1                 = $this->db->exec("update zibbs_user set msgmark=1 where id='" . $userto['id'] . "'");
        $rel2                 = $this->db->exec("update zibbs_slave_pmb set status='closed' where t_num='" . $mid . "'");
        if ($mid) {
            return true;
        }
    }
    //显示消息
    public function showmsg()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $this->showtags();
        require("static/Fenye.class.php");
        $ufromarr = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
        $ufrom    = $ufromarr->fetch();
        $uid      = $ufrom['id'];
        $uemail   = $ufrom['email'];
        $pagesize = 10;
        $arr      = $this->api_listspmb($uid, $uemail, $pagesize);
        $this->assign('arr', $arr);
        $this->render();
    }
    //消息浏览
    public function viewmsg()
    {
        if (!$this->doverify()) {
            header("location:./");
            exit;
        }
        $this->showtags();
        $ufromarr = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
        $ufrom    = $ufromarr->fetch();
        $mid      = intval($_GET['mid']);
        $arr      = $this->api_viewpmb($ufrom['id'], $mid);
        $this->assign("arr", $arr);
        $this->assign("mid", $mid);
        $this->render();
    }
    //回复消息
    public function doviewmsg()
    {
        if (!$this->doverify()) {
            echo false;
            exit;
        }
        $mid        = intval($_POST['mid']);
        $msgcontent = addslashes($_POST['msgcontent']);
        $ufromarr   = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
        $ufrom      = $ufromarr->fetch();
        $rel        = $this->api_replypmb($mid, $ufrom, $msgcontent, '');
        echo $rel;
    }
    //删除消息
    public function dodelmsg()
    {
        if (!$this->doverify()) {
            echo false;
            exit;
        }
        $midarr   = $_POST['mid'];
        $ufromarr = $this->db->query("select * from zibbs_user where id=" . $_SESSION['zibbs_userid']);
        $ufrom    = $ufromarr->fetch();
        foreach ($midarr as $mid) {
            $rel = $this->api_closepmb($ufrom['email'], $mid);
        }
        echo $rel;
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
}
?>