<?php
require_once($_SERVER['DOCUMENT_ROOT'] ."/inc/include.php");
if (cmethod::isPost() == false) {
    exceptions::doErr(405,'HTTP/1.1 405 Method not allowed','不支持该请求方法');
    exit;
}
$username = $_POST['username'];
$email = $_POST['email'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
if (!chkreginfo::chkname($username)) {
    echo '<script>alert("您输入的用户名 '.$username.' 不合法！\\n\\n提示：\\n1. 请确保用户名长度在 1~16 字符以内；\\n2. 请确保用户名里面没有 emoji表情 或 特殊符号。")</script>';
} else if (!chkreginfo::chkpass($pass1)) {
    echo '<script>alert("您输入的密码不合法！\\n\\n提示：\\n请确保密码长度在 7~32 字符以内。")</script>';
} else if (!chkreginfo::chkpass_s($pass1,$pass2)) {
    echo '<script>alert("密码和确认密码不相同，请检查！")</script>';
} else if ($db->isUserExist($username)) {
    echo '<script>alert("阁下，这个名字 '.$username.'\\n已经被其它小伙伴抢注了哦(’∇’)シ┳━┳！\\n\\n赶紧换一个更好一些的名字吧ヾ(◍°∇°◍)ﾉﾞ，或者和ID主人进行交♂易，也许会和你换一下φ(>ω<*) ！")</script>';
} else if ($db->isEmailExist($email)) {
    echo '<script>alert("阁下，这个邮箱 '.$email.' 已经有其它小伙伴用了\\n\\n阁下难道把其它小伙伴的邮箱拿来用了(;￢＿￢)？")</script>';
} else {
    $salt = salt::generatsalt(6);
    $saltedpass = md5(md5($pass1).$salt);
    $userid = UUID::getUserUuid(md5($email));
    $uuid = UUID::getUserUuid($username);
    $regip = $_SERVER['REMOTE_ADDR'];
    $db->creUser($username,$saltedpass,$email,$regip,$salt,$userid,$uuid);
    echo '<script>alert("注册成功！点击 “确定” 继续");window.open("https://user.zhjlfx.cn/url.html")</script>';
}