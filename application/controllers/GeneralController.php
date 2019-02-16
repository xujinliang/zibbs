<?php
//用于在模版文件中调用函数功能
class GeneralController extends Controller
{
    public function getname($args)
    {
        $userquery = $this->db->query("select * from zibbs_user where email='" . $args[0] . "'");
        $user      = $userquery->fetch();
        return $user['username'];
    }
    public function getavatar($args)
    {
        $userquery = $this->db->query("select * from zibbs_user where email='" . $args[0] . "'");
        $user      = $userquery->fetch();
        return $user['avatar'];
    }
    public function getnamebyuid($args)
    {
        $userquery = $this->db->query("select * from zibbs_user where id='" . $args[0] . "'");
        $user      = $userquery->fetch();
        return $user['username'];
    }
    public function getavatarbyuid($args)
    {
        $userquery = $this->db->query("select * from zibbs_user where id='" . $args[0] . "'");
        $user      = $userquery->fetch();
        return $user['avatar'];
    }
    public function gettagname($args)
    {
        $tagquery = $this->db->query("select * from zibbs_tags where id='" . $args[0] . "'");
        $tag      = $tagquery->fetch();
        return $tag['name'];
    }
    public function getuserstatus($args)
    {
        $userquery = $this->db->query("select * from zibbs_user where email='" . $args[0] . "'");
        $user      = $userquery->fetch();
        return ($user['status'] == '-1' ? true : false);
    }
}
?>