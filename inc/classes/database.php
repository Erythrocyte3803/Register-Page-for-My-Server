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
        $res = $this->query("select * from pre_ucenter_members where username = '".$username."'");
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
    //检测邮箱是否存在//
    function isEmailExist($email) {
        $res = $this->query("select * from pre_ucenter_members where email = '".$email."'");
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
    //将注册数据写入数据库//
    function creUser($username,$password,$email,$regip,$salt,$userid,$uuid) {
        $this->query_change("insert into pre_ucenter_members (username, password, email, regip, regdate, salt, userid, uuid) values ('".$username."', '".$password."', '".$email."', '".$regip."', '".time()."', '".$salt."', '".$userid."', '".$uuid."')");
    }
    //创建正版用户数据//
    function creMojangUser($username,$password,$email,$regip,$salt,$userid,$uuid,$skin){
        $res = $this->query("select email from pre_ucenter_members where email = '".$email."'");
        if(!$res[0][0]){
            $this->query_change("insert into pre_ucenter_members (username, password, email, regip, regdate, salt, userid, uuid, texturedata, mojang) values ('".$username."', '".$password."', '".$email."', '".$regip."', '".time()."', '".$salt."', '".$userid."', '".$uuid."', '".$skin."', 'true')");
        }else{
            $this->query_change("update pre_ucenter_members set username = '".$username."', password= '".$password."', regip= '".$regip."', regdate = '".time()."', salt = '".$salt."', userid = '".$userid."', uuid = '".$uuid."', texturedata = '".$skin."', mojang = 'true' where email = '".$email."'");
        }
    }
    //验证是否已认证过//
    function isVerified($uuid){
        $res = $this->query("select * from pre_ucenter_members where uuid = '".$uuid."'");
        $verified = $res[0][16];
        if($verified == 'true'){
            return true;
        }else{
            return false;
        }
    }
}