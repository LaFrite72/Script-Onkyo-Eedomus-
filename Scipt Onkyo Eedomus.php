<?php
    $command = $_GET['command'];
    $params = $_GET['params'];
    $host = $_GET['host'];
    $port = 60128;
 
    switch ($command)
    {
		
	// Power => Standby:00 - On:01
        case 'PWR':
            if ($params >= 0 && $params <= 1){$message = '!1' . $command . $params;break;}
            else {	print "Erreur de Commande <br>\nCommandes autorisées => Standby:00 - On:01<br>\n";break;}     

						
	// Mute AMT => MuteOff:00 - MuteOn:01
        case 'AMT':
            if ($params >= 0 && $params <= 1){$message = '!1' . $command . $params;break;}
            else {	print "Erreur de Commande <br>\nCommandes autorisées => MuteOff:00 - MuteOn:01<br>\n";break;}     
            
						
	// Volume => Commande autorisée => UP, DOWN, 0-100 (HEXA)
        case 'MVL':
            if ($params == "UP" || $params == "DOWN"){$message = '!1' . $command . $params;break;}
			else if ($params >= 0 && $params <= 70){$message = '!1' . $command . strtoupper(str_pad(dechex($params), 2, '0', STR_PAD_LEFT));break;}
            else {	print "     Erreur de Commande <br>\nCommandes autorisées => UP, DOWN, 0-100 <br>\n";break;}
						
			
	// Sleep => Commande autorisée => OFF, 01-90 Min (HEXA)	
        case 'SLP':
            if ($params == "OFF"){$message = '!1' . $command . $params;break;}
			else if ($params >= 1 && $params <= 90){$message = '!1' . $command . strtoupper(str_pad(dechex($params), 2, '0', STR_PAD_LEFT));break;}
            else {	print "Erreur de Commande <br>\nCommandes autorisées =>  OFF, 01-90<br>\n";break;}
            
            
	// NET Service => Commande autorisée => Network Serveice 00:Media Server (DLNA), 01:Favorite, 02:vTuner, 03:SIRIUS, 04:Pandora, 05:Rhapsody, 06:Last.fm, 07:Napster, 08:Slacker, 09:Mediafly, 0A:Spotify, 0B:AUPEO!, 0C:Radiko, 0D:e-onkyo, 0E:TuneIn Radio, 0F:mp3tunes, 10:Simfy, 11:Home Media, 12:Deezer, 13:iHeartRadio, 18:Airplay, F0;USB/USB(Front), F1:USB(Rear)
        case 'NSV':
            if ($params >= 0 && $params < 29){$message = '!1' . $command . strtoupper(str_pad(dechex($params), 2, '0', STR_PAD_LEFT));break;}
            else {	print "Erreur de Commande <br>\nCommandes autorisées => Network Serveice 00:Media Server (DLNA), 01:Favorite, 02:vTuner, 03:SIRIUS, 04:Pandora, 05:Rhapsody, 06:Last.fm, 07:Napster, 08:Slacker, 09:Mediafly, 0A:Spotify, 0B:AUPEO!, 0C:Radiko, 0D:e-onkyo, 0E:TuneIn Radio, 0F:mp3tunes, 10:Simfy, 11:Home Media, 12:Deezer, 13:iHeartRadio, 18:Airplay, F0;USB/USB(Front), F1:USB(Rear)<br>\n";break;} 
			
	
	// Internet Radio Preset Command => Commande autorisée => 01-28
     	case 'NPR':
            if ($params >= 1 && $params <= 28){$message = '!1' . $command . $params;break;}
            else {	print "Erreur de Commande <br>\nCommandes autorisées => 01-28<br>\n";break;}     	    

			
	// Input Selector Command => Commande autorisée => 00-33
     	case 'SLI':
            $message = '!1' . $command . $params;
            break;
			
	    default:
            print "Commandes autorisées =><br>\n<br>\n";
            print "PWR  :   Power => Standby=00 - On=01<br>\n<br>\n";
            print "AMT  :   Mute => MuteOff=00 - MuteOn=01<br>\n<br>\n";
            print "MVL  :   Volume => Commande autorisée => UP, DOWN, 0-100<br>\n<br>\n";
            print "SLP  :   Sleep => Commande autorisée => OFF, 01-90 Min<br>\n<br>\n";
            print "NSV  :   NET Service => Commande autorisée => Network Serveice 00:Media Server (DLNA), 01:Favorite, 02:vTuner, 03:SIRIUS, ...<br>\n<br>\n";
            print "NPR  :   Internet Radio Preset Command => Commande autorisée => 01-28<br>\n<br>\n";
            break;
    }
    print  "Message envoyé : ";
    print $message;
    print  "<br>\n";
                $package = "ISCP\x00\x00\x00\x10\x00\x00\x00" . chr(strlen($message) + 1) . "\x01\x00\x00\x00" . $message . "\x0D";
                $socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
                socket_connect($socket, $host, $port);
                socket_write($socket, $package);
                socket_close($socket);
?>
