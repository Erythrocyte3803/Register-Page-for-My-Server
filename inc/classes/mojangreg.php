<?php
class MojangReg {
    static function getacc($email,$pass) {
        global $authserver;
        $data = '{
	                "username":"'.$email.'",
	                "password":"'.$pass.'",
	                "requestUser":true,
	                "agent":{
		                "name":"Minecraft",
		                "version":1
	               }
                 }';
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'content-type:application/json;charset=utf8',
                'content' => $data,
                'timeout' => 15*60
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($authserver,false,$context);
        $data_json = json_decode($result,true);
        $pid = $data_json['user']['id'];
        $puuid = $data_json['selectedProfile']['id'];
        if ($pid != '' && $puuid != '') {
            return array($pid,$puuid);
        } else {
            return false;
        }
    }
    static function getskin($uuid) {
        global $profile;
        $json = file_get_contents($profile.'/'.$uuid);
        $data = json_decode($json,true);
        $skinjson = base64_decode($data['properties'][0]['value']);
        return $skinjson;
    }
}