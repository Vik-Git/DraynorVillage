<?php

  $url = "https://poker.draynorvillage.com:8087/api";  // put your API path here
  $pw = "UHGoej54FWItnx37";                  // put your API password here

  function Poker_API($params)
  {
    global $url, $pw;
    $params['Password'] = $pw;
    $params['JSON'] = 'Yes';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_VERBOSE, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    if (curl_errno($curl)) $obj = (object) array('Result' => 'Error', 'Error' => curl_error($curl)); 
    else if (empty($response)) $obj = (object) array('Result' => 'Error', 'Error' => 'Connection failed'); 
    else $obj = json_decode($response);
    curl_close($curl);
    return $obj;
  }

?>