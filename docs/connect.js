		var Server;
		var chatstring = "";
		var chatmode = false;
		var chatmodeflag2 = false;
		var chatmessages = [];
		var chatinterval;
		var newmessage = 0;
		var chatmessages = [];
		var inRequest = false;
		var inLobby = false;
		var mapwidth = 250;
		var mapheight = 250;
		var connected = false;

		function log( text ) {
			console.log(text);
		}

		function send( text ) {
			Server.send( 'message', text );
		}

		function map(map)
		{
			console.log("Sending mapdata...");
			// Modify this to send all mapdata.

		  	/*map1 = {};
		  	for (var i = 0; i < 50; i++) {
		  		for (var iy = 0; iy <= 100; iy++) {
		  			map1[i + "," + iy] = map[i + "," + iy];
		  		}
		  	}
		  	map1part = {"part":1,"endpart":4,"map":map1};
			jstring = {"command": "mapPart", "argument": map1part};
			send(JSON.stringify(jstring));
		  	map2 = {};
		  	for (var i = 50; i < 100; i++) {
		  		for (var iy = 0; iy <= 100; iy++) {
		  			map2[i + "," + iy] = map[i + "," + iy];
		  		}
		  	}
		  	map2part = {"part":2,"endpart":4,"map":map2};
			jstring = {"command": "mapPart", "argument": map2part};
			send(JSON.stringify(jstring));
		  	map3 = {};
		  	for (var i = 100; i < 150; i++) {
		  		for (var iy = 0; iy <= 100; iy++) {
		  			map3[i + "," + iy] = map[i + "," + iy];
		  		}
		  	}
		  	map3part = {"part":3,"endpart":4,"map":map3};
			jstring = {"command": "mapPart", "argument": map3part};
			send(JSON.stringify(jstring));
		  	map4 = {};
		  	for (var i = 150; i <= 200; i++) {
		  		for (var iy = 0; iy <= 100; iy++) {
		  			map4[i + "," + iy] = map[i + "," + iy];
		  		}
		  	}
		  	map4part = {"part":4,"endpart":4,"map":map4};
			jstring = {"command": "mapPart", "argument": map4part};
			send(JSON.stringify(jstring));*/
		}

		function keypress(key)
		{
			jstring = {"command": "keypress", "argument": key};
			send(JSON.stringify(jstring));
		}

		function chat(message)
		{
			if(connected == false)
			{
				connect(message);
			} else {
				jstring = {"command": "chat", "argument": message};
				send(JSON.stringify(jstring));
			}
		}

		$(document).ready(function(){
			enterChatmode();
		});

		function connect(ip)
		{
			port = ip.split(':')[1];
			ip = ip.split(':')[0];
			if(port == undefined)
			{
				port = 9300;
			}
			log('Connecting...');
			Server = new FancyWebSocket('ws://'+ip+':'+port);

			//Let the user know we're connected
			Server.bind('open', function() {
				log( "Connected." );
				connected = true;
			});

			//OH NOES! Disconnection occurred.
			Server.bind('close', function( data ) {
				log( "Disconnected." );
				Game.display.drawText(5, 20, "No server found at IP.");
			});

			//Log any messages sent from server
			Server.bind('message', function( payload ) {
				payload = JSON.parse(payload);
				/*console.log(payload);*/
				if(inRequest != true)
				{
					if(payload['type'] == "message")
					{
						queueMessage("<span class='message'><span class='username'>" + payload['name'] + ":</span> <span class='chatmessage'>" + payload['message'] + "</span><br></span>");
					} else if (payload['type'] == "status")
					{
						queueMessage("<span class='message'><span class='chatmessage' style='color:" + payload['color'] + " !important;'>" + payload['status'] + "</span><br></span>");
						if(payload['expectresponse'] == true)
						{
							enterChatmode();
						}
					} else if (payload['type'] == "state")
					{
						drawFromData(payload['map']);
						setPlayerInfo(payload['player']);
					} else if (payload['type'] == "keybindings")
					{
						updateKeybindings(payload['keybindings']);
					}else if (payload['type'] == "lobby")
					{
						if(inLobby == false)
						{
							//clearChat();
						}
						inLobby = true;
						iter = 9;
						Game.display.clear();
						Game.display.drawText(1, 3, "Waiting for all players..");
						Game.display.drawText(1, 5, "Press enter and type \"startgame\" to begin. Press \"H\" to open settings.");
						Game.display.drawText(1, 8, "Players:");
						$.each(payload['players'], function(index, value)
							 {
							 	if((value['name'] != "___tick") && (value['name'] != "null"))
							 	{
							 		Game.display.drawText(1, iter, value['name']);
							 	}
							 	iter = iter + 1;
							 });
					} else if(payload['type'] == "settings")
					{
						Game.display.clear();
						iter = 3;
						$.each(payload['line'], function(index, value)
						{
							Game.display.drawText(1, iter, value['text']);
							iter = iter + 1;
						});
					}
				}/* else if(inLobby)
				{
					if (payload['type'] == "lobby")
					{
						inLobby = true;
						iter = 9;
						Game.display.clear();
						Game.display.drawText(1, 3, "Waiting for all players..");
						Game.display.drawText(1, 5, "Press enter and type \"startgame\" to begin.");
						Game.display.drawText(1, 8, "Players:");
						$.each(payload['players'], function(index, value)
							 {
							 	Game.display.drawText(1, iter, value['name']);
							 	iter = iter + 1;
							 });
					} else if (payload['type'] == "unsetLobby")
					{
						Game.display.clear();
						inLobby = false;
					}
				}*/
			});

			Server.connect();
		}

function enterChatmode()
{
	if(chatmode != true)
	{
						chatmode = true;
						chatmodeflag2 = true;
				    	$(".chatcursor").addClass("blink");
						$('.blink').each(function() {
						    var elem = $(this);
						    chatinterval = setInterval(function() {
						        if (elem.css('visibility') == 'hidden') {
						            elem.css('visibility', 'visible');
						        } else {
						            elem.css('visibility', 'hidden');
						        }    
						    }, 400)});
					}
}
