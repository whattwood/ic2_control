<?php
//TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/
//This page is requested by the JavaScript, it updates the pin's status and then print it

if (isset ( $_GET["pic"] )) {
	$pic = strip_tags ($_GET["pic"]);
	//test if value is a number
	if ( (is_numeric($pic)) && ($pic <= 4) && ($pic >= 1) ) {
		//set the gpio's mode to output
		//reading pin's status
                $statusTemp = shell_exec( 'sudo /usr/sbin/i2cget -y 1 0x10 0x0'.$pic );
                $status = substr($statusTemp,-2);
		//set the gpio to high/low
		if ($status[0] == "0" ) { $status[0] = "1"; }
		else if ($status[0] == "1" ) { $status[0] = "0"; }
//		system("gpio write ".$pic." ".$status[0] );
		shell_exec( 'sudo /usr/sbin/i2cset -y 1 0x10 0x0'.$pic.' 0x0'.$status[0] );
		//reading pin's status
                $statusTemp = shell_exec( 'sudo /usr/sbin/i2cget -y 1 0x10 0x0'.$pic );
                $status = substr($statusTemp,-2);
		//print it to the client on the response
		echo($status[0]);
	}
	else { echo ("fail"); }
} //print fail if cannot use values
else { echo ("fail"); }
?>
