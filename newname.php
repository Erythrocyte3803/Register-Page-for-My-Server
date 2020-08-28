<?php
require_once($_SERVER['DOCUMENT_ROOT'] ."/inc/include.php");
if (cmethod::isPost() == false) {
    exceptions::doErr(405,'HTTP/1.1 405 Method not allowed','不支持该请求方法');
    exit;
}
$token = $_POST['token'];
$email = $_POST['email'];
$username = $_POST['username'];
$time = time();
if(!$db->chkToken($token)){
    echo '<script>alert("Token不存在或已失效，请点击“确定”返回上一页");parent.location.href="https://reg.zhjlfx.cn/mojang.html"</script>';
}else if(!$db->chkTokenVaild($time,$token)){
    echo '<script>alert("Token已过期，请点击“确定”返回上一页");parent.location.href="https://reg.zhjlfx.cn/mojang.html"</script>';
}else if(!chkreginfo::chkname($username)){
    echo '<script>alert("您输入的用户名 '.$username.' 不合法！\\n\\n提示：\\n1. 请确保用户名长度在 1~16 字符以内；\\n2. 请确保用户名里面没有 emoji表情 或 特殊符号。")</script>';
}else if($db->isUserExist($username)){
    echo '<script>alert("阁下，这个名字 '.$username.'\\n已经被其它小伙伴抢注了哦(’∇’)シ┳━┳！\\n\\n赶紧换一个更好一些的名字吧ヾ(◍°∇°◍)ﾉﾞ，或者和ID主人进行交♂易，也许会和你换一下φ(>ω<*) ！")</script>';
}else{
    $db->updateData($username,$email);
    echo '<script>alert("正版验证成功！点击 “确定” 继续");parent.location.href="https://user.zhjlfx.cn/url.html"</script>';
    $db->delToken($token);//销毁当前Token
    exit;
}