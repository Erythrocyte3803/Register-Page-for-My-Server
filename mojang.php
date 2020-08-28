<?php
require_once($_SERVER['DOCUMENT_ROOT'] ."/inc/include.php");
if (cmethod::isPost() == false) {
    exceptions::doErr(405,'HTTP/1.1 405 Method not allowed','不支持该请求方法');
    exit;
}
$email = $_POST['email'];
$pass = $_POST['pass'];
//判断是否验证成功//
if (!mojangreg::getacc($email,$pass)) {
    echo '<script>alert("无法进行正版验证！\\n\\n可能的原因：\\n1. 没有正确输入正版邮箱和密码；\\n2. Mojang正版认证服务器出现故障；\\n3. 您的网络环境可能出现了问题。")</script>';
} else {
    $verified_data = mojangreg::getacc($email,$pass);
    $pid = $verified_data[0];
    $puuid = $verified_data[1];
    $pname = $verified_data[2];
    $salt = salt::generatsalt(6);
    $saltedpass = md5(md5($pass).$salt);
    $regip = $_SERVER['REMOTE_ADDR'];
    $skindata = mojangreg::getskin($puuid);
    if ($db->isVerified($puuid)) {
        echo '<script>alert("阁下，这个账号 '.$email.'\\n已经被认证过了，不能再重复认证哦！");parent.location.href="https://user.zhjlfx.cn/url.html"</script>';
        exit;
    } else if ($skindata == '') {
        echo '<script>alert("正版皮肤信息获取失败，请稍后重试！")</script>';
        exit;
    } else if ($db->isSameAsDatabase($pname,$email)) {
        $db->creMojangUser($pname,$saltedpass,$email,$regip,$salt,$pid,$puuid,$skindata);
        echo '<script>alert("正版验证成功！点击 “确定” 继续");parent.location.href="https://user.zhjlfx.cn/url.html"</script>';
        exit;
    } else if ($db->isUserExist($pname)) {
        $token_salt = salt::generatsalt(16);
        $token = md5(md5(md5($pass).$salt).$email);
        $noname = 'Player_'.$token_salt;
        $db->creToken($token);
        $db->creMojangUserNoname($noname,$saltedpass,$email,$regip,$salt,$pid,$puuid,$skindata);
        echo '<script>alert("阁下，这个名字 '.$pname.'\\n已经被其它小伙伴抢注了哦(’∇’)シ┳━┳！\\n\\n赶紧换一个更好一些的名字吧ヾ(◍°∇°◍)ﾉﾞ，或者和ID主人进行交♂易，也许会和你换一下φ(>ω<*) ！\\n\\n请点击“确定”在新页面设置名字");parent.location.href="https://reg.zhjlfx.cn/setname.php?email='.$email.'&token='.$token.'";</script>';

        exit;
    } else {
        $db->creMojangUser($pname,$saltedpass,$email,$regip,$salt,$pid,$puuid,$skindata);
        echo '<script>alert("正版验证成功！点击 “确定” 继续");parent.location.href="https://user.zhjlfx.cn/url.html"</script>';
        exit;
    }
}