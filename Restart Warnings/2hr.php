<?php
include("config.php");
	$text = 'say -1 ';
	if(isset($argv[1]))
	{
		$text .= $argv[1];
	} else {
		$text .= "Server Restart in 2 Hours.";
	}
	
	//Settings
	$pass = password;
	$ip = address;
	$port = port;
	
	//Dont touch
	$msgseq = 0;
	
	//Generate CRC32 for pass and msg
        $authCRC = crc32(chr(255).chr(00).trim($pass));
	$authCRC = sprintf("%x", $authCRC);
	$msgCRC = crc32(chr(255).chr(01).chr(hexdec(sprintf('%01b',$msgseq))).$text);
	$msgCRC = sprintf("%x", $msgCRC);
	//Reverse the CRCs and put into array
	$authCRC = array(substr($authCRC,-2,2),substr($authCRC,-4,2),substr($authCRC,-6,2),substr($authCRC,0,2));
	$msgCRC = array(substr($msgCRC,-2,2),substr($msgCRC,-4,2),substr($msgCRC,-6,2),substr($msgCRC,0,2));
	
        //Socket comm
        $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
	
	if(!$sock)
	{
		die("Socket create failed: ".socket_last_error()."\n");
	} else {
		echo "Got Socket!\n";
	}
	
	//header
        $loginmsg = "BE".chr(hexdec($authCRC[0])).chr(hexdec($authCRC[1])).chr(hexdec($authCRC[2])).chr(hexdec($authCRC[3]));
	//Add payload
	$loginmsg .= chr(hexdec('ff')).chr(hexdec('00')).$pass;
        $len = strlen($loginmsg);
        
	echo "Attempting Login\n";
        $sent = socket_sendto($sock, $loginmsg, $len, 0, $ip, $port);
	
	if($sent == false)
	{
		die("failed to send login ".socket_last_error()."\n");
	} else {
		//echo "Login sent: ".$sent." bytes\n";
	}
	
        socket_recvfrom($sock, $buf, 64, 0, $ip, $port);
	//var_dump($buf);
	if(ord($buf[strlen($buf)-1]) == 1)
	{
		echo "Login Successful!\n";
	} else if(ord($buf[strlen($buf)-1]) == 0) {
		echo "Login Failed!\n";
	} else {
		echo "Unknown result from login!\n";
		exit;
	}
	
	$recv = socket_recvfrom($sock, $buf, 64, 0, $ip, $port);
        if($recv == false)
	{
		die("failed to recv ".socket_last_error()."\n");
	} else {
		//echo "Recieved: ".$recv." bytes\n\n";
	}
        //var_dump($buf);
	echo substr($buf,9)."\n";
	
	
	//Send a heartbeat packet
	$statusmsg = "BE".chr(hexdec("7d")).chr(hexdec("8f")).chr(hexdec("ef")).chr(hexdec("73"));
	$statusmsg .= chr(hexdec('ff')).chr(hexdec('02')).chr(hexdec('00'));
	$len = strlen($statusmsg);
	socket_sendto($sock, $statusmsg, $len, 0, $ip, $port);

	
	//header
	$saymsg = "BE".chr(hexdec($msgCRC[0])).chr(hexdec($msgCRC[1])).chr(hexdec($msgCRC[2])).chr(hexdec($msgCRC[3]));
	//msg
	$saymsg .= chr(hexdec('ff')).chr(hexdec('01')).chr(hexdec(sprintf('%01b',$msgseq))).$text;
	$len = strlen($saymsg);

	$sent = socket_sendto($sock, $saymsg, $len, 0, $ip, $port);
	$msgseq++;
	if($sent == false)
	{
		die("failed to send msg ".socket_last_error()."\n");
	} else {
		echo $text."\n";
	}


	//socket_recvfrom($sock, $buf, 64, 0, $ip, $port);
        //var_dump($buf);
        
        socket_close($sock);
?>
