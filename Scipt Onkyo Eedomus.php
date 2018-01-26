<?php
    $command = $_GET['command'];
    $params = $_GET['params'];
 
    $hostname = '192.168.1.15';
    $port = 60128;
 
    switch ($command)
    {
        case 'PWR':
		    $message = '!1' . $command . $params;
            break;
			
        case 'NSV':
			$message = '!1' . $command . $params;
            break;
		
        case 'TUN':
		
     	case 'NPR':
		     if ($params > 28){
		        print "Erreur variable supperieur a 28";
                return null;}
            $message = '!1' . $command . strtoupper(str_pad(dechex($params), 2, '0', STR_PAD_LEFT));
            break;
			
     	case 'SLI':
            $message = '!1' . $command . $params;
            break;
			
        case 'MVL':
            if ($params > 60)
            	print "Erreur variable supperieur a 60";
                return null;
            $message = '!1' . $command . strtoupper(str_pad(dechex($params), 2, '0', STR_PAD_LEFT));
            break;
			
        default:
            return null;
    }
    print $message;
 
 
 $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
 socket_bind($sock, $hostname);
 socket_connect($sock, '127.0.0.1', 80);
 $packet = "ISCP\x00\x00\x00\x10\x00\x00\x00" . chr(strlen($message) + 1) . "\x01\x00\x00\x00" . $message . "\x0D";
 socket_write($sock, $packet);    
 socket_close($sock);
 
     print "  ...envoyé : ";
     print  socket_last_error();
     print " octets";
?>