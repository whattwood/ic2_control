<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PHP Relay Control</title>
</head>
<body>
        <?php
        function zerificabinario( $rel )
        { //function to add a 0 to the beginning of the binary
                $caratteriBin = strlen( $rel );
                $diff = 4 - $caratteriBin;
                if ( $diff > 0 ) {
                        for ( $c = 1; $c <= $diff; $c++ ) {
                                $rel = "0" . $rel;
                        };
                };
                return ( $rel );
        }

        function caricastatorelays()
        { //function to load relays status
                global $arrRelays;
                $statorele = " ";
                $statorele .= shell_exec( 'sudo /usr/sbin/i2cget -y 1 0x10 0x01' );
                $statorele .= shell_exec( 'sudo /usr/sbin/i2cget -y 1 0x10 0x02' );
                $statorele .= shell_exec( 'sudo /usr/sbin/i2cget -y 1 0x10 0x03' );
                $statorele .= shell_exec( 'sudo /usr/sbin/i2cget -y 1 0x10 0x04' );
		echo( "<p>".$statorele."</p>" );
                if (empty($statorele)) {

                        die("<h1>Relay not found! Cannot start.</h1>");
                        }
//                $relays = zerificabinario( base_convert( $statorele, 16, 2 ) );
//		echo( "<p>".$relays."</p>" );
//                $arrRelays = str_split( $relays );
                $arrRelaysTemp = str_split( $statorele );
                $arrRelays = $arrRelaysTemp[1*5-1].$arrRelaysTemp[2*5-1].$arrRelaysTemp[3*5-1].$arrRelaysTemp[4*5-1];
		echo $arrRelays;
                return ( $arrRelays );
        }
        echo( "<br>" );
        caricastatorelays();
        if ( isset( $_POST[ "ID" ] ) )
        {
                $toggle = $_POST[ "ID" ];
                if ($toggle == "Relay1on") shell_exec( 'sudo /usr/sbin/i2cset -y 1 0x10 0x01 0x01' );
                if ($toggle == "Relay1off") shell_exec( 'sudo /usr/sbin/i2cset -y 1 0x10 0x01 0x00' );
                if ($toggle == "Relay2on") shell_exec( 'sudo /usr/sbin/i2cset -y 1 0x10 0x02 0x01' );
                if ($toggle == "Relay2off") shell_exec( 'sudo /usr/sbin/i2cset -y 1 0x10 0x02 0x00' );

//                if (($toggle != "OnAll") && ($toggle != "OffAll"))
//                {
//                $toggle = ( substr( $toggle, -1, 1 ) ) - 1;
//                $changedValue = ( 0 == $arrRelays[ $toggle ] ) ? '1' : '0';
//                $arrRelays = array_replace( [], $arrRelays, [ $toggle => $changedValue ] );
//                $newrelaystatus = base_convert(implode( $arrRelays ), 2, 16 );
//                shell_exec( '/usr/sbin/i2cset -y 1 0x10 0x' . $newrelaystatus );
//                }
                // !!!!! change 0x23 with I2C addres of your relays board
                caricastatorelays();
                header( 'Location: ' . $_SERVER[ 'PHP_SELF' ] ); // make a redirect to empty post data. in case of reload of the page i don't wont to re-toggle last action
        }
        ?>
        <br>
<table>
<tr>
        <td>

        <?php

        foreach ( $arrRelays as $key => $valore )
        {   //create a form for every relay and his button
                echo( "<p><form  method='post' style='width: 300px;margin: 0mx;'>" );
                $color = ( 0 == $valore ) ? '#f009' : '#fff';
                echo( '<input type="submit" name="ID" id="' . $key . '" style="background-color:' . $color . '" value="Relay ' . ( $key + 1 ) . '">' );
                echo( "</form></p>" );
        }
?>
</td>
<td>
<p><form  method='post' style='width: 300px;margin: 0mx;'>
<input type="submit" name="ID" id="" style="background-color:''" value="Relay1on">
</form></p>
<p><form  method='post' style='width: 300px;margin: 0mx;'>
<input type="submit" name="ID" id="" style="background-color:''" value="Relay1off">
</form></p>
<p><form  method='post' style='width: 300px;margin: 0mx;'>
<input type="submit" name="ID" id="" style="background-color:''" value="Relay2on">
</form></p>
<p><form  method='post' style='width: 300px;margin: 0mx;'>
<input type="submit" name="ID" id="" style="background-color:''" value="Relay2off">
</form></p>

</td>
</tr>
        <br>
</body>
</html>
