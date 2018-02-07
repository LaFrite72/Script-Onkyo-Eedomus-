<?php
    $command = $_GET['command'];
    $params = $_GET['params'];
    $host = $_GET['host'];
    $port = 60128;
 
    switch ($command)
    {
		
	// Power => Standby:00 - On:01
        case 'PWR':
		    $message = '!1' . $command . $params;
            break;
			
						
	// Mute => MuteOff:00 - MuteOn:01
        case 'AMT':
		    $message = '!1' . $command . $params;
            break;
			
						
	// Volume => Commande autorisée => UP, DOWN, 0-100		
        case 'MVL':
            if ($params == "UP" || $params == "DOWN" || $params < 100){
            $message = '!1' . $command . strtoupper(str_pad(dechex($params), 2, '0', STR_PAD_LEFT));
            break;}
			else {           
			print "Erreur de Commande - Commande autorisée => UP, DOWN, 0-100"
            return null;}
						
			
	// Sleep => Commande autorisée => OFF, 01-90	
        case 'SLP':
            if ($params <> "OFF" || $params > 90)
            	print "Erreur de Commande - Commande autorisée => OFF , 01-90";
                return null;
            $message = '!1' . $command . strtoupper(str_pad(dechex($params), 2, '0', STR_PAD_LEFT));
            break;
			
			
	// NET Service => Commande autorisée => ss -> Network Serveice 00:Media Server (DLNA), 01:Favorite, 02:vTuner, 03:SIRIUS, 04:Pandora, 05:Rhapsody, 06:Last.fm, 07:Napster, 08:Slacker, 09:Mediafly, 0A:Spotify, 0B:AUPEO!, 0C:Radiko, 0D:e-onkyo, 0E:TuneIn Radio, 0F:mp3tunes, 10:Simfy, 11:Home Media, 12:Deezer, 13:iHeartRadio, 18:Airplay, F0;USB/USB(Front), F1:USB(Rear)
        case 'NSV':
			$message = '!1' . $command . $params;
            break;
			
	
	// Internet Radio Preset Command => Commande autorisée => 01-28
     	case 'NPR':
		     if ($params > 28){
		        print "Erreur variable supperieur a 28";
                return null;}
            $message = '!1' . $command . strtoupper(str_pad(dechex($params), 2, '0', STR_PAD_LEFT));
            break;
			
			
	// Input Selector Command => Commande autorisée => 00-33
     	case 'SLI':
            $message = '!1' . $command . $params;
            break;
			
		
        default:
            return null;
    }
    print  "   Message : ";
    print $message;
 
                $package = "ISCP\x00\x00\x00\x10\x00\x00\x00" . chr(strlen($message) + 1) . "\x01\x00\x00\x00" . $message . "\x0D";
                $socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
                socket_connect($socket, $host, $port);
                socket_write($socket, $package);
                socket_close($socket);
?>
