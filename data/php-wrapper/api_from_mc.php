<?php
  //echo "el valor de data es: ".$_POST["data"];
  //echo "value: ".$_POST["value"];
  function do_request_to_api(){
    $curl_h = curl_init('http://192.168.0.10:3000/api/v1/data_mc');

    $values = array ("data"=>$_POST["data"],"value"=>$_POST["value"]);
    $params = http_build_query($values);
    $options = array(
              CURLOPT_RETURNTRANSFER => true,         // return web page
              CURLOPT_AUTOREFERER    => true,         // set referer on redirect
              CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
              CURLOPT_TIMEOUT        => 120,          // timeout on response
              CURLOPT_POST            => 1,            // i am sending post data
              CURLOPT_POSTFIELDS     => $params,
                    CURLOPT_VERBOSE       => 1,
    );

    curl_setopt_array($curl_h,$options);
    echo curl_exec($curl_h);  
  }
  do_request_to_api();
?>
