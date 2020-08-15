<?php
/**
 * PHP生成随机字符串
 * @param	Int		$length			字符串长度
 * @weburl	url						学习地址：http://www.ijquery.cn/?p=1027
 */
class salt {
    static function generatsalt($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}