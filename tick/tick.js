
var system = require('system');
var args = system.args;


var FancyWebSocket = function(url)
{
	var callbacks = {};
	var ws_url = url;
	var conn;

	this.bind = function(event_name, callback){
		callbacks[event_name] = callbacks[event_name] || [];
		callbacks[event_name].push(callback);
		return this;// chainable
	};

	this.send = function(event_name, event_data){
		this.conn.send( event_data );
		return this;
	};

	this.connect = function() {
		if ( typeof(MozWebSocket) == 'function' )
			this.conn = new MozWebSocket(url);
		else
			this.conn = new WebSocket(url);

		// dispatch to the right handlers
		this.conn.onmessage = function(evt){
			dispatch('message', evt.data);
		};

		this.conn.onclose = function(){dispatch('close',null)}
		this.conn.onopen = function(){dispatch('open',null)}
	};

	this.disconnect = function() {
		this.conn.close();
	};

	var dispatch = function(event_name, message){
		var chain = callbacks[event_name];
		if(typeof chain == 'undefined') return; // no callbacks for this event
		for(var i = 0; i < chain.length; i++){
			chain[i]( message )
		}
	}
};


var Server;

function log( text ) {
	console.log(text);
}

function send( text ) {
	Server.send( 'message', text );
}

function keypress(key)
{
	jstring = {"command": "keypress", "argument": key};
	send(JSON.stringify(jstring));
}

function name(message)
{
	if(connected == false)
	{
		connect(message);
	} else {
		jstring = {"command": "chat", "argument": message};
		send(JSON.stringify(jstring));
	}
}


connect(args[1]);
setTimeout(function(){
	name("___tick");
	setInterval(function() {
		keypress('VK_H'); //Just press any key to trigger a tick. In this case we're opening and closing the settings menu.
	}, 300);
}, 1000);


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

	//Disconnection. Kill the tick.
	Server.bind('close', function( data ) {
		phantom.exit();
	});

	Server.connect();


}

