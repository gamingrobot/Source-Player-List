<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Player List</title>
	<link rel="stylesheet" href="bootstrap.min.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="tinydropdown.js"></script>

</head>


<body>
    <div class="container">
		<h1>Player List</h1>
    
      <div class="row">
				<table class="bordered-table zebra-striped">
					<thead>
						<tr id="menu" class="menu">
                <th style="text-align:center" id="kalt">
                <li><span class="main">CS:S</span>
                    <ul class="submenu" onclick="this.style.display='none'; return false;">
                        <li id="css_dust2"><span>24/7 =(eGO)= DUST2</span></li>
                        <li id="css_office"><span>24/7 =(eGO)= OFFICE</span></li>
                        <li id="css_italy"><span>24/7 =(eGO)= ITALY</span></li>
                        <li id="css_dedust"><span>24/7 =(eGO)= DE_DUST</span></li>
                        <li id="css_highschool"><span>24/7 =(eGO)= HIGHSCHOOL</span></li>
                    </ul>
                </li>
                </th>
                <th style="text-align:center" id="strand">
                <li><span class="main">DOD:S</span>
                    <ul class="submenu" onclick="this.style.display='none'; return false;">
                        <li id="dod_anzio"><span>24/7 =(eGO)= ANZIO</span></li>
                        <li id="dod_kalt"><span>24/7 =(eGO)= KALT</span></li>
                        <li id="dod_strand"><span>24/7 =(eGO)= CHARLIE AKA STRAND</span></li>
                        <li id="dod_ava"><span>24/7 =(eGO)= AVALANCHE</span></li>
                        <li id="dod_donner"><span>24/7 =(eGO)= DONNER</span></li>
                    </ul>
                </li>
                </th>
                <th style="text-align:center" id="ava">
                <li><span class="main">TF2</span>
                    <ul class="submenu" onclick="this.style.display='none'; return false;">
                        <li id="tf2_2fort"><span>24/7 =(eGO)= 2FORT</span></li>
                        <li id="tf2_valve"><span>24/7 =(eGO)= VALVE MAPS</span></li>
                        <li id="tf2_foundry"><span>24/7 =(eGO)= FOUNDRY</span></li>
                        <li id="tf2_dust"><span>24/7 =(eGO)= DUSTBOWL</span></li>
                    </ul>
                </li>
                </th>
            <!-- <th style="text-align:center" id="kalt">CS:S</th>
              <th style="text-align:center" id="strand">DOD:S</th>
              <th style="text-align:center" id="ava">TF2</th>-->
						</tr>
					</thead>
				</table>
		</div>
		<div style="display:none" class="row" id="player_div">
				<table class="bordered-table zebra-striped">
					<thead id="player_head">
          <tr>
							<th colspan="5" style="border-bottom:1px solid #DDD" id="servername"></th>
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
    $.ajaxSetup ({
		cache: false
	});
    var players;
    var serverinfo;
    //CSS SERVERS
    $("#css_dust2").click(function(){
        loadplayers("gaming_gameme_api.php?ip=174.36.42.204:27015");
    });
    $("#css_office").click(function(){
        loadplayers("gaming_gameme_api.php?ip=174.36.42.205:27015");
    });
    $("#css_italy").click(function(){
        loadplayers("gaming_gameme_api.php?ip=75.126.144.83:27015");
    });
    $("#css_dedust").click(function(){
        loadplayers("gaming_gameme_api.php?ip=75.126.144.82:27015");
    });
    $("#css_highschool").click(function(){
        loadplayers("gaming_gameme_api.php?ip=75.126.144.80:27015");
    });
    //DOD SERVERS
    $("#dod_anzio").click(function(){
        loadplayers("gaming_gameme_api.php?ip=72.233.123.6:27015");
    });
    $("#dod_kalt").click(function(){
        loadplayers("gaming_gameme_api.php?ip=72.233.123.5:27015");
    });
    $("#dod_strand").click(function(){
        loadplayers("gaming_gameme_api.php?ip=72.233.123.3:27015");
    });
    $("#dod_ava").click(function(){
        loadplayers("gaming_gameme_api.php?ip=67.228.175.242:27015");
    });
    $("#dod_donner").click(function(){
        loadplayers("gaming_gameme_api.php?ip=67.228.175.243:27015");
    });
    //TF2 SERVERS
    $("#tf2_2fort").click(function(){
        loadplayers("gaming_gameme_api.php?ip=69.64.95.111:27015");
    });
    $("#tf2_valve").click(function(){
        loadplayers("gaming_gameme_api.php?ip=64.150.183.207:27015");
    });
    $("#tf2_foundry").click(function(){
        loadplayers("gaming_gameme_api.php?ip=68.232.161.203:27015");
    });
    $("#tf2_dust").click(function(){
        loadplayers("gaming_gameme_api.php?ip=64.150.186.180:27015");
    });
    function loadplayers(loadURL){
        $("#player_div").show();
        $("#player_head").hide();
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

var dropdown=new TINY.dropdown.init("dropdown", {id:'menu', active:'menuhover'});

</script>

</body>
</html>
