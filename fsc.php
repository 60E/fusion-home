<?php
/******************************************************************************
	Wallet Configuration
******************************************************************************/
	$GLOBALS["wallet_ip"] = "127.0.0.1";
	$GLOBALS["wallet_port"] = "8088";
	$GLOBALS["wallet_user"] = "naituida";
	$GLOBALS["wallet_pass"] = "123";
	


require_once ("bc_daemon.php");
require_once ("bc_layout.php");
	
//	If a block hash was provided the block detail is shown
if (isset ($_REQUEST["block_hash"]))
  {
    site_header ("Block Detail Page");
		
    block_detail ($_REQUEST["block_hash"], TRUE);
  }
	
//	If a block height is provided the block detail is shown
elseif (isset ($_REQUEST["block_height"]))
  {
    site_header ("Block Detail Page");
		
    block_detail ($_REQUEST["block_height"]);
  }
	
//	If a TXid was provided the TX Detail is shown
elseif (isset ($_REQUEST["transaction"]))
  {
    site_header ("Transaction Detail Page");
		
    tx_detail ($_REQUEST["transaction"]);
  }
	
//	If there were no request parameters the menu is shown
else
  {
    site_header ();
    $network_info = getinfo ();
    $net_speed = getnetworkhashps ();
    $net_speed_scrypt = getnetworkhashps_scrypt ();
    site_home($network_info,$net_speed,$net_speed_scrypt);
  }
	
	
site_footer ();

/******************************************************************************
	This script is Copyright © 2013 Jake Paysnoe.
	I hereby release this script into the public domain.
	Jake Paysnoe Jun 26, 2013
******************************************************************************/
?>
