<?php
$token = $_GET['token'];
$email = $_GET['email'];
echo '<!DOCTYPE html>
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <title>设置用户名</title>
        <link href="css/login.css" type="text/css" rel="stylesheet">
        <script src="https://static.zhjlfx.cn/js/jquery-1.11.0.min.js" type="text/javascript"></script>
        <script src="https://static.zhjlfx.cn/src/jquery.dialog.js"></script>
        <link rel="stylesheet" href="https://static.zhjlfx.cn/css/demo.css">
        <link rel="stylesheet" href="https://static.zhjlfx.cn/src/css/dialog.css">
    </head>
    
    <body>
        <div class="login">
            <div class="message">设置用户名(请在5分钟内完成)</div>
            <div id="darkbannerwrap"></div>
            <form action="newname.php" method="post" target="result">
                <input name="action" value="login" type="hidden">
                <input name="token" placeholder="Token" required="" type="text" value="'.$token.'" readonly="readonly" style="display:none">
                <hr class="hr15">
                <input name="email" placeholder="邮箱" required="" type="email" value="'.$email.'" readonly="readonly" style="display:none">
                <hr class="hr15">
                <input name="username" placeholder="用户名" required="" type="text">
                <hr class="hr15">
                <!--<input name="password" placeholder="密码" required="" type="password">

		<hr class="hr15">-->
                <input value="提交" style="width:100%;" type="submit">
                <hr class="hr20">
                <!--<hr class="hr20">
                <a href="https://user.zhjlfx.cn/repass.html">忘记密码</a>-->
            </form>
            <iframe id="result" name="result" style = "display:none">result</iframe>
        </div>
        <div class="copyright">© 2020 综合资源分享网 by <a href="https://www.zhjlfx.cn" target="_blank">综合资源分享网</a>
        </div>
    </body>

</html>';