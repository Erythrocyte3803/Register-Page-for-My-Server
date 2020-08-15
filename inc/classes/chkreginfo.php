<?php
class chkreginfo {
    //判断用户名是否合法//
    static function chkname($name) {
        $preg = '/^([A-Za-z0-9_\x{0080}-\x{d7ff}]{1,16}+)$/u';
        $res = preg_match($preg,$name);
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
    //判断密码是否合法//
    static function chkpass($pass) {
        $preg = "/^[A-Za-z0-9_~!@#$%^&*()=\[\]{}|;\',.:+-]{7,32}$/";
        $res = preg_match($preg,$pass);
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
    //判断密码是否相同//
    static function chkpass_s($pass1,$pass2) {
        $res = ($pass1 == $pass2);
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }
}