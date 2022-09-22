<?php
function do_request_to_servertap_exec($commando){
  $curl_h = curl_init('http://192.168.6.22:4567/v1/server/exec');
  $options = array(
            CURLOPT_RETURNTRANSFER => true,         // return web page
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_POST            => 1,            // i am sending post data
            CURLOPT_POSTFIELDS     => "command=".$commando,
                  CURLOPT_VERBOSE       => 1,
            CURLOPT_HTTPHEADER    => array ("Content-Type: application/x-www-form-urlencoded","accept: */*","key:eca3e94a3537d25269174d84d750e178")
  );

  curl_setopt_array($curl_h,$options);
  echo curl_exec($curl_h);
}

function do_request_to_servertap_sendmsg($msg){
  $curl_h = curl_init('http://192.168.6.22:4567/v1/chat/broadcast');
  $options = array(
            CURLOPT_RETURNTRANSFER => true,         // return web page
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_POST            => 1,            // i am sending post data
            CURLOPT_POSTFIELDS     => "message=".$msg,
                  CURLOPT_VERBOSE       => 1,
            CURLOPT_HTTPHEADER    => array ("Content-Type: application/x-www-form-urlencoded","accept: */*","key:eca3e94a3537d25269174d84d750e178")
  );

  curl_setopt_array($curl_h,$options);
  echo curl_exec($curl_h);  
}

$json = file_get_contents('php://input');
$data = json_decode($json);
if ($data->cmd=="exec_comando"){
  if ($data->data=="do_rain_on"){
    echo "Hago llover";
    do_request_to_servertap_exec("weather%20rain");
  }elseif ($data->data=="do_rain_off"){
    echo "Hago Parar de llover";
    do_request_to_servertap_exec("weather%20clear");
  }  
} elseif ($data->cmd=="send_msg"){
  do_request_to_servertap_sendmsg($data->data);
}

//echo "va";


?>
