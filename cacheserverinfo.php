<?php
require("gameme_api_sdk.php");
$gameME_sdk_object = new gameMEAPI("http://edgegamers.gameme.com/api");

$serverlist = array();

try {
    $serverlist = $gameME_sdk_object->client_api_serverlist(GAMEME_FILTER_NONE);
} catch (Exception $e) {
    die ("Client API Serverinfo Error: ".$e->getMessage()."\n");
}

$serverlist = $serverlist["serverlist"];


$servers = array();
if(!empty($serverlist)){
    foreach($serverlist as $server){
        if($server['game'] == "css" || $server['game'] == "dods" || $server['game'] == "tf"){
            $tempserver = array();
            $tempserver['addr'] = $server['addr'];
            $tempserver['port'] = $server['port'];
            $tempserver['name'] = trim($server['name']);
            if(!array_key_exists($server['game'], $servers)){
                $servers[$server['game']] = array();
            }
            array_push($servers[$server['game']], $tempserver);
        }
    }
    $response = json_encode($servers);
    $fp = fopen('serverinfo.json', 'w');
    fwrite($fp, $response);
    fclose($fp);

    echo "Succeeded in caching server info for PlayerList";

}
else{
    echo "Failed in caching server info for PlayerList, GameMe serverlist is empty";
}

?>