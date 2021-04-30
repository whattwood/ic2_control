<!DOCTYPE html>
<!--TheFreeElectron 2015, http://www.instructables.com/member/TheFreeElectron/ -->

<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="refresh" content="10" > //refresh page every 10 seconds
        <title>Pi i2c Relay Control</title>
    </head>
 
    <body style="background-color: black;">
    <!-- On/Off button's picture -->
	<?php
	$val_array = array(0);
	//this php script generate the first page in function of the file
	for ( $i= 1; $i<5; $i++) {
		//set the pin's mode to output and read them
//                $statusTemp = shell_exec( 'sudo /usr/sbin/i2cget -y 1 0x10 0x0'.$i );
		$val_array[$i-1] = substr(shell_exec( 'sudo /usr/sbin/i2cget -y 1 0x10 0x0'.$i ),-2);
//		system("gpio mode ".$i." out");
//		exec ("gpio read ".$i, $val_array[$i], $return );
	}
	//for loop to read the value
//	$i = 0;
	for ($i = 1; $i < 5; $i++) {
		//if off
		if ($val_array[$i-1][0] == 0 ) {
			echo ("<img id='button_".$i."' src='data/img/red/red_".$i.".jpg' onclick='change_pin (".$i.");'/>");
		}
		//if on
		if ($val_array[$i-1][0] == 1 ) {
			echo ("<img id='button_".$i."' src='data/img/green/green_".$i.".jpg' onclick='change_pin (".$i.");'/>");
		}
	}
	?>

	<!-- javascript -->
	<script src="script.js"></script>
    </body>
</html>
