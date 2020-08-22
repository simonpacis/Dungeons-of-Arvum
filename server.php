<?php
ini_set('memory_limit', '-1');
ini_set('log_errors', 'off');
include('config.php');
if(!$reporting)
{
	error_reporting(0);
} else {
	error_reporting(E_ALL);
}
include('helpers.php');
include('classes/bootstrap.php');

// prevent the server from timing out
set_time_limit(0);
// include the web sockets server script (the server is started at the far bottom of this file)
require 'class.PHPWebSocket.php';

// Call this at each point of interest, passing a descriptive string
function prof_flag($str)
{
    global $prof_timing, $prof_names;
    $prof_timing[] = microtime(true);
    $prof_names[] = $str;
}

// Call this when you're done and want to see the results
function prof_print()
{
    global $prof_timing, $prof_names, $profiling;
    $size = count($prof_timing);
    for($i=0;$i<$size - 1; $i++)
    {
    	if($profiling)
    	{
        	echo "{$prof_names[$i]}\n";
        	echo sprintf("   %f\n", $prof_timing[$i+1]-$prof_timing[$i]);
    	}
    }
    if($profiling)
    {
    	echo "{$prof_names[$size-1]}\n";
	}
}

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