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


<body>
    <div class="container">
        <!--<h1>This is a testbed for player list find the full version <a href="http://playerlist.gamingrobot.net">here</a></h1>
        --><h1>Player List</h1>
      <div class="row">
				<table class="bordered-table zebra-striped">
					<thead>
					<tr id="menu" class="menu">
                    <th style="text-align:center" id="kalt">
                    <li><span class="main">CS:S</span>
                        <ul class="submenu" onclick="this.style.display='none'; return false;">
                            <li id="css_dust2"      onclick="window.location.hash='css_dust2';"><span>24/7 =(eGO)= DUST2</span></li>
                            <li id="css_office"     onclick="window.location.hash='css_office';"><span>24/7 =(eGO)= OFFICE</span></li>
                            <li id="css_italy"      onclick="window.location.hash='css_italy';"><span>24/7 =(eGO)= ITALY</span></li>
                            <li id="css_dedust"     onclick="window.location.hash='css_dedust';"><span>24/7 =(eGO)= DE_DUST</span></li>
                            <li id="css_highschool" onclick="window.location.hash='css_highschool';"><span>24/7 =(eGO)= HIGHSCHOOL</span></li>
                        </ul>
                    </li>
                    </th>
                    <th style="text-align:center" id="strand">
                    <li><span class="main">DOD:S</span>
                        <ul class="submenu" onclick="this.style.display='none'; return false;">
                            <li id="dod_anzio"  onclick="window.location.hash='dod_anzio';"><span>24/7 =(eGO)= ANZIO</span></li>
                            <li id="dod_kalt"   onclick="window.location.hash='dod_kalt';"><span>24/7 =(eGO)= KALT</span></li>
                            <li id="dod_strand" onclick="window.location.hash='dod_strand';"><span>24/7 =(eGO)= CHARLIE AKA STRAND</span></li>
                            <li id="dod_ava"    onclick="window.location.hash='dod_ava';"><span>24/7 =(eGO)= AVALANCHE</span></li>
                            <li id="dod_donner" onclick="window.location.hash='dod_donner';"><span>24/7 =(eGO)= DONNER</span></li>
                        </ul>
                    </li>
                    </th>
                    <th style="text-align:center" id="ava">
                    <li><span class="main">TF2</span>
                        <ul class="submenu" onclick="this.style.display='none'; return false;">
                            <li id="tf2_2fort"      onclick="window.location.hash='tf2_2fort';"><span>24/7 =(eGO)= 2FORT</span></li>
                            <li id="tf2_valve"      onclick="window.location.hash='tf2_valve';"><span>24/7 =(eGO)= VALVE MAPS</span></li>
                            <li id="tf2_foundry"    onclick="window.location.hash='tf2_foundry';"><span>24/7 =(eGO)= FOUNDRY</span></li>
                            <li id="tf2_dust"       onclick="window.location.hash='tf2_dust';"><span>24/7 =(eGO)= DUSTBOWL</span></li>
                            <li id="tf2_black"      onclick="window.location.hash='tf2_black';"><span>24/7 =(eGO)= BLACKMESA</span></li>
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
    var serverport = "27015";
    var apiurl = "gaming_gameme_api.php"
    var servers = new Array();
    //CSS SERVERS
    servers['css_dust2']        = '174.36.42.204';
    servers['css_office']       = '174.36.42.205';
    servers['css_italy']        = '75.126.144.83';
    servers['css_dedust']       = '75.126.144.82';
    servers['css_highschool']   = '75.126.144.80';
    //DOD SERVERS
    servers['dod_anzio']        = '72.233.123.6';
    servers['dod_kalt']         = '72.233.123.5';
    servers['dod_strand']       = '72.233.123.3';
    servers['dod_ava']          = '67.228.175.242';
    servers['dod_donner']       = '67.228.175.243';
    //TF2 SERVERS
    servers['tf2_2fort']        = '69.64.95.111';
    servers['tf2_valve']        = '64.150.183.207';
    servers['tf2_foundry']      = '68.232.161.203';
    servers['tf2_dust']         = '64.150.186.180';
    servers['tf2_black']        = '68.232.160.125';


    //do page load stuff
    //if(window.location.hash) {
    //    var hashserver = window.location.hash.substring(1);
    //    loadplayers(apiurl + "?ip=" + servers[hashserver] + ":" + serverport, hashserver);
    //} 

    $(window).hashchange( function(){
        if(window.location.hash) {
            var hash = location.hash;       
            // Set the page title based on the hash.
            hashserver = hash.replace( /^#/, '' );
            loadplayers(apiurl + "?ip=" + servers[hashserver] + ":" + serverport, hashserver);
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
    function loadplayers(loadURL, servertag){
        //window.location.hash = servertag;
        $("#player_div").show();
        $("#player_head").hide();
        $("#welcome").hide();
        $("#player_table").html("<h2>Loading...</h2>");
        $.getJSON(
                loadURL,
                function(json) {
                    //alert(json.addr);
                    serverinfo = json.serverinfo;
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
