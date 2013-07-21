<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <title>Player List</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="tinydropdown.js"></script>
    <script type="text/javascript" src="jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="jquery.ba-hashchange.min.js"></script>
    
</head>

<?php
    $file = file_get_contents('serverinfo.json');
    $serverinfo = json_decode($file, true);
    $trimlength = 35;
?>

<body>
    <div class="container">
    <h1>Player List</h1>
        <div class="row">
            <table class="bordered-table zebra-striped">
                <thead>
                <tr id="menu" class="menu">
                <th style="text-align:center">
                <li><span class="main">CS:S</span>
                    <ul class="submenu" onclick="this.style.display='none'; return false;">
                        <?php
                            foreach($serverinfo['css'] as $server){
                                $address = $server['addr'] . ":" . $server['port'];
                                echo "<li id='". $address ."' onclick='window.location.hash=\"". $address ."\";'><span>". substr($server['name'], 0, $trimlength) ."</span></li>";
                            }
                        ?>
                    </ul>
                </li>
                </th>
                <th style="text-align:center">
                <li><span class="main">DOD:S</span>
                    <ul class="submenu" onclick="this.style.display='none'; return false;">
                        <?php
                            foreach($serverinfo['dods'] as $server){
                                $address = $server['addr'] . ":" . $server['port'];
                                echo "<li id='". $address ."' onclick='window.location.hash=\"". $address ."\";'><span>". substr($server['name'], 0, $trimlength) ."</span></li>";
                            }
                        ?>
                    </ul>
                </li>
                </th>
                <th style="text-align:center">
                <li><span class="main">TF2</span>
                    <ul class="submenu" onclick="this.style.display='none'; return false;">
                        <?php
                            foreach($serverinfo['tf'] as $server){
                                $address = $server['addr'] . ":" . $server['port'];
                                echo "<li id='". $address ."' onclick='window.location.hash=\"". $address ."\";'><span>". substr($server['name'], 0, $trimlength) ."</span></li>";
                            }
                        ?>
                    </ul>
                </li>
                </th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="row" id="welcome">
            <table class="bordered-table zebra-striped">
                <thead>
                <tr>
                    <th><span id="welcome_message">Use the menu above to select a server to view players on the server</th>
                </tr>
                </thead>
            </table>
        </div>
        <div style="display:none" class="row" id="player_div">
            <table class="bordered-table zebra-striped" id="data_table">
                <thead id="player_head">
                <tr>
                    <th colspan="5" style="border-bottom:1px solid #DDD"><span id="servername"></span> <a style="float:right; cursor: pointer" onclick="$(window).hashchange();">Refresh</a></th>
                </tr>
                <tr id="player_titles">
                    <th>Name</th>
                    <th>Steam ID</th>
                    <th>Location</th>
                    <th>View Profile</th>
                    <th>Add Friend</th>
                    </tr>
                </thead>
                <tbody id="player_table">
                </tbody>
            </table>
        </div>
    </div>
    
    <script type="text/javascript">
    //var serverport = "27015";
    var apiurl = "playerlist_gameme_api.php"

    $(window).hashchange( function(){
        if(window.location.hash) {
            var hash = location.hash;       
            // Set the page title based on the hash.
            hashserver = hash.replace( /^#/, '' );
            loadplayers(apiurl + "?ip=" + hashserver);
        }
        else {

            $("#player_div").hide();
            $("#welcome").show();
        }
        
    })
    $(window).hashchange();

    $.ajaxSetup ({
        cache: false
    });
    var players;
    var serverinfo;
    var tablebackup;
    function loadplayers(loadURL){
        $("#player_div").show();
        $("#player_head").hide();
        $("#welcome").hide();
        $("#player_table").html("<h2>Loading...</h2>");
        $.getJSON(
                loadURL,
                function(json) {
                    //alert(json.addr);
                    serverinfo = json.serverinfo;
                    console.log(serverinfo);
                    players = json.players;
                    $("#player_table").html("");
                    $("#servername").html(serverinfo.name);
                    $("#player_div").show();
                    if(players != 0){
                        $("#player_head").show();
                        $("#player_titles").show();
                        $("#player_table").show();
                        $.each(players,function(i,player){        
                            $("#player_table").append(
                                '<tr>'+
                                    '<td><img src="'+player.steamavatar+'" width=20px height=20px"/> '+player.name+'</td>'+
                                    '<td>'+player.steamid+'</td>'+
                                    '<td>'+player.location+'</td>'+
                                    '<td><a href="http://www.steamcommunity.com/profiles/'+player.comid+'" target="_blank">View Profile</a></td>'+
                                    '<td><a href="steam://friends/add/'+player.comid+'">Add to Friends</a></td>'+
                                '</tr>'
                            )
                        });
                        tablebackup = $("#data_table").clone();
                        resetTable();

                    }
                    else{
                        $("#player_head").show();
                        $("#player_titles").hide();
                        $("#player_table").append(
                            '<tr>'+
                                '<td colspan="5">No Players on Server</td>'+
                            '</tr>'
                        )
                    }
                }
            );
    }

    </script>
    <script type="text/javascript">
    //when updating the table call this function to clear the tablesorter data
    function resetTable() {
      $("#data_table").hide();
      tablebackup.clone().insertAfter("#data_table");
      $("#data_table").remove();
      $.tablesorter.defaults.sortList = [[0,0]]; 
      $("#data_table").tablesorter({
            headers: {
                0: {
                    sorter: false
                },
                4: {
                    sorter: false
                },
                5: {
                    sorter: false
                }
            }
        });
    }


    var dropdown=new TINY.dropdown.init("dropdown", {id:'menu', active:'menuhover'});

    </script>

</body>
</html>
