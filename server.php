<?php
error_reporting(0);
ini_set('memory_limit', '-1');
$predefinedClasses = get_declared_classes();
//error_reporting(E_ALL & ~E_NOTICE);
//require_once( 'libs/Thread.php' );
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include('config.php');
include('helpers.php');
include('classes/bootstrap.php');
include('population.php');
include('gamestate.php');
include('gamefunctions.php');
// prevent the server from timing out
set_time_limit(0);

// include the web sockets server script (the server is started at the far bottom of this file)
require 'class.PHPWebSocket.php';

// when a client sends data to the server
function wsOnReceive($clientID, $message, $messageLength, $binary) {
	global $Server;

	$message = json_decode($message, true);
	$command = $message['command'];
	$argument = $message['argument'];

	// check if message length is 0
	if ($messageLength == 0) {
		$Server->wsClose($clientID);
		return;
	}
	$command($clientID, $argument);

	//The speaker is the only person in the room. Don't let them feel lonely.
	/*foreach ( $Server->wsClients as $id => $client )
		if ( $id != $clientID )
			$Server->wsSend($id, "Visitor $clientID ($ip) said \"$message\"");
	*/
}

// when a client connects
function wsOnOpen($clientID)
{
	global $Server, $bigbroadcast, $t1, $ready;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	echo "$ip ($clientID) has connected.\n" ;
	newPlayer($clientID);
	if($ready)
	{
		sleep(1);
		bigBroadcast();
	}
	
	//Send a join notice to everyone but the person who joined
	/*foreach ( $Server->wsClients as $id => $client )
		if ( $id != $clientID )
			$Server->wsSend($id, "Visitor $clientID ($ip) has joined the room.");*/
}

// when a client closes or lost connection
function wsOnClose($clientID, $status) {
	global $Server, $players;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	echo $players[$clientID]->name . " has disconnected.\n" ;

	//Send a user left notice to everyone in the room
	foreach ( $Server->wsClients as $id => $client )
		$Server->wsSend($id, "Visitor $clientID ($ip) has left the room.");
}

// start the server
newMap();
$Server = new PHPWebSocket();
$Server->bind('message', 'wsOnReceive');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');


$Server->wsStartServer($ip, $port);

?>