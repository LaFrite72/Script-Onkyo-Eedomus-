<?php
    $command = $_GET['command'];
    $params = $_GET['params'];
    $host = $_GET['host'];
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
    print  "   Message : ";
    print $message;
 
                $package = "ISCP\x00\x00\x00\x10\x00\x00\x00" . chr(strlen($message) + 1) . "\x01\x00\x00\x00" . $message . "\x0D";
                $socket = socket_create( AF_INET, SOCK_STREAM, SOL_TCP );
                socket_connect($socket, $host, $port);
                socket_write($socket, $package);
                socket_close($socket);
?>
