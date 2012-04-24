<?php
require("gameme_api_sdk.php");
$gameME_sdk_object = new gameMEAPI("http://edgegamers.gameme.com/api");

function getFriendId($steamId)
{
    //Example SteamID: "STEAM_X:Y:ZZZZZZZZ"
    $gameType = 0; //This is X.  It's either 0 or 1 depending on which game you are playing (CSS, L4D, TF2, etc)
    $authServer = 0; //This is Y.  Some people have a 0, some people have a 1
    $clientId = ''; //This is ZZZZZZZZ.

    //Remove the "STEAM_"
    $steamId = str_replace('STEAM_', '' ,$steamId);

    $parts = explode(':', $steamId);
    $gameType = $parts[0];
    $authServer = $parts[1];
    $clientId = $parts[2];
	
    $result = bcadd((bcadd('76561197960265728', $authServer)), (bcmul($clientId, '2')));
    return $result;
}
$tempserver_info = array();
$return_info = array();

if(!isset( $_GET['ip'])){ die("ip GET var not set. \n"); }
try {
    $tempserver_info = $gameME_sdk_object->client_api_serverinfo($_GET['ip'],GAMEME_DATA_PLAYERS);
    //print_r($server_list);
} catch (Exception $e) {
    die ("Client API Serverinfo Error: ".$e->getMessage()."\n");
}

$server_info = $tempserver_info['serverinfo'][0];

$return_serverinfo['addr']  = $server_info['addr'];
$return_serverinfo['port']  = $server_info['port'];
$return_serverinfo['game']  = $server_info['game'];
$return_serverinfo['name']  = $server_info['name'];
$return_serverinfo['map']   = $server_info['map'];
$return_info['serverinfo'] = $return_serverinfo;

$players = array();
if(!empty($server_info['players'])){
    foreach($server_info['players'] as $player){
        $tempplayer = array();
        $tempplayer['id']           = $player['id'];
        $tempplayer['name']         = $player['name'];
        $tempplayer['steamid']      = $player['uniqueid'];
        $tempplayer['comid']        = getFriendId($player['uniqueid']);
        $tempplayer['steamavatar']  = str_replace("_full","",$player['steamavatar']);
        $tempplayer['location']     = $player['cn'];
        array_push($players,$tempplayer);
    }
    $return_info['players'] = $players;
}
else{
    $return_info['players'] = 0;
}
//print_r($return_info);

$serverjson = json_encode($return_info);
print $serverjson;

?>