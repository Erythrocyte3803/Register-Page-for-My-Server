<?php
class database {
    public $mysqli;
    function __construct() {
        global $host,$port,$user,$pass,$data;
        $iscon = mysqli_connect($host.":".$port,$user,$pass,$data);
        if (!$iscon) {
            echo "无法连接至MySQL数据库：".mysqli_connect_error();
            header(Exceptions::$codes[500]);
            die();
        }
        $this->mysqli = new mysqli($host.":".$port,$user,$pass,$data);
    }
    function query($sql) {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt == false) {
            echo "MySQL查询出错：".$this->mysqli->error;
            header(Exceptions::$codes[500]);
            return -1;
        }
        $stmt->execute();
        $ret = $stmt->get_result();
        $result = $ret->fetch_all();
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    function query_change($sql) {
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt == false) {
            echo "MySQL查询出错：".$this->mysqli->error;
            header(Exceptions::$codes[500]);
            return -1;
        }
        $stmt->execute();
        $ret = $stmt->get_result();
        $result = $this->mysqli->affected_rows;
        if (empty($result)) {
            return false;
        } else {
            return $result;
        }
    }
    //检测用户名是否存在//
    function isUserExist($username) {
        $res = $this->query("select * from users where username = '".$username."'");
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
    //检测邮箱是否存在//
    function isEmailExist($email) {
        $res = $this->query("select * from users where email = '".$email."'");
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
    //将注册数据写入数据库//
    function creUser($username,$password,$email,$regip,$salt,$userid,$uuid) {
        $this->query_change("insert into users (username, password, email, regip, regdate, salt, userid, uuid) values ('".$username."', '".$password."', '".$email."', '".$regip."', '".time()."', '".$salt."', '".$userid."', '".$uuid."')");
    }
    //创建正版用户数据//
    function creMojangUser($username,$password,$email,$regip,$salt,$userid,$uuid,$skin){
        $res = $this->query("select email from users where email = '".$email."'");
        if(!$res[0][0]){
            $this->query_change("insert into users (username, password, email, regip, regdate, salt, userid, uuid, texturedata, mojang) values ('".$username."', '".$password."', '".$email."', '".$regip."', '".time()."', '".$salt."', '".$userid."', '".$uuid."', '".$skin."', 'true')");
        }else{
            $this->query_change("update users set username = '".$username."', password= '".$password."', regip= '".$regip."', regdate = '".time()."', salt = '".$salt."', userid = '".$userid."', uuid = '".$uuid."', texturedata = '".$skin."', mojang = 'true' where email = '".$email."'");
        }
    }
    //验证是否已认证过//
    function isVerified($uuid){
        $res = $this->query("select * from users where uuid = '".$uuid."'");
        $verified = $res[0][16];
        if($verified == 'true'){
            return true;
        }else{
            return false;
        }
    }
    //验证正版用户名和邮箱是否符合数据库//
    function isSameAsDatabase($username,$email){
        $uname = $this->query("select username from users where email = '".$email."'");
        $mail = $this->query("select email from users where email = '".$email."'");
        if($username == $uname[0][0] && $email == $mail[0][0]){
            return true;
        }else{
            return false;
        }
    }
    //创建用户名设置页面token//
    function creToken($token){
        $this->query_change("insert into vailtoken (token, vtime) values ('".$token."','".time()."')");
    }
    //检查token是否过期//
    function chkTokenVaild($time,$token){
        $res = $this->query("select * from vailtoken where token = '".$token."'");
        $tokentime = $res[0][2];
        if($time - $tokentime > 60*5){
            return false;
        }else {
            return true;
        }
    }
    //检查token是否存在//
    function chkToken($token){
        $res = $this->query("select * from vailtoken where token = '".$token."'");
        if(!$res){
            return false;
        }else{
            return true;
        }
    }
    //删除使用过的token//
    function delToken($token){
        $this->query_change("delete from vailtoken where token = '".$token."'");
    }
    //创建正版用户数据(不包含名字和验证结果)//
    function creMojangUserNoname($username,$password,$email,$regip,$salt,$userid,$uuid,$skin){
        $res = $this->query("select email from users where email = '".$email."'");
        if(!$res[0][0]){
            $this->query_change("insert into users (username, password, email, regip, regdate, salt, userid, uuid, texturedata, mojang) values ('".$username."', '".$password."', '".$email."', '".$regip."', '".time()."', '".$salt."', '".$userid."', '".$uuid."', '".$skin."', 'false')");
        }else{
            $this->query_change("update users set username = '".$username."', password= '".$password."', regip= '".$regip."', regdate = '".time()."', salt = '".$salt."', userid = '".$userid."', uuid = '".$uuid."', texturedata = '".$skin."', mojang = 'false' where email = '".$email."'");
        }
    }
    //更新剩余的正版用户登录信息//
    function updateData($username,$email){
        $this->query_change("update users set username = '".$username."', mojang = 'true' where email = '".$email."'");
    }
}