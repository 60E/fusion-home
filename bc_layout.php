<?php
	function site_header ()
	{
echo <<< HERE
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>FusionCoin - Official Site</title>
    <meta name="description" content="Open Security Exchange">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/docs.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="block_crawler.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<!--[if lt IE 7]>
     <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<!-- This code is taken and modified from http://twitter.github.com/bootstrap/examples/hero.html -->

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="ibrand" href="#">FusionCoin</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
	  <li><a href="index.html">Home</a></li>
	  <li class="dropdown">
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pools<b class="caret"></b></a>
	    <ul class="dropdown-menu">
	      <li><a href="fscbtc">Official Merged Mining Pool(BitCoin)</a></li>
	      <li><a href="fscltc">Official Merged Mining Pool(LiteCoin)</a></li>
	    </ul>
	  </li>
	  <li class="dropdown">
	    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Explorer<b class="caret"></b></a>
	    <ul class="dropdown-menu">
	      <li><a href="fsc.php">FusionCoin</a></li>
	      <li><a href="testnet.php">FusionCoin Testnet</a></li>
	    </ul>
	  </li>
	  <li><a href="#">Forum</a></li>
	  <li><a href="#">Support</a></li>

        </ul>
      </div>
    </div>
  </div>
  </div>
HERE;
	}
	
	function site_footer ()
	{

		
		echo "</body>\n";
		echo "</html>";
		exit;
	}

function show_hashrate($hashrate, $precision = 2)
{
    $unit = array('H/s','K H/s','M H/s','G H/s','T H/s','P H/s');

    return @round(
        $hashrate / pow(1024, ($i = floor(log($hashrate, 1024)))), $precision
    ).' '.$unit[$i];
}

function site_home($network_info,$net_speed,$net_speed_scrypt) {
  $blocklink =  "<a href=\"".$_SERVER["PHP_SELF"]."?block_height=".$network_info["blocks"]."\" title=\"View Block Details\">".$network_info["blocks"]."</a>\n";
  $hashrate = show_hashrate($net_speed);
  $hashrate_scrypt = show_hashrate($net_speed_scrypt);
  echo   "<div class=\"container\">";
  echo   "<h2  style=\"padding-bottom:10px\">FusionCoin Explorer</h2>";
  echo   "<div class=\"span6\"><table class=\"table table-striped\">";
  echo   "<tr>";
  echo   "<td>Block Count</td><td>".$blocklink."</td>";
  echo   "</tr>";
  echo   "<tr>";
  echo   "<td>Difficulty</td><td>".$network_info["difficulty"]."</td>";
  echo   "</tr>";
  echo   "<tr>";
  echo   "<td>Connections</td><td>".$network_info["connections"]."</td>";
  echo   "</tr>";
  echo   "<tr>";
  echo   "<td>Network(SHA256)</td><td>".$hashrate."</td>";
  echo   "</tr>";
  echo   "<tr>";
  echo   "<td>Network(Scrypt)</td><td>".$hashrate_scrypt."</td>";
  echo   "</tr>";
  echo   "</table>";
  echo   "</div>";

  echo "	<div class=\"span6\">\n";
  echo "\n";
		
  echo "		<div >\n";
  echo "			<span class=\"menu_desc\">Enter a Block Index / Height</span><br>\n";
  echo "			<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">\n";
  echo "				<input type=\"text\" name=\"block_height\" size=\"40\">\n";
  echo "				<input type=\"submit\" name=\"submit\" class=\"btn btn-default\" value=\"Jump To Block\">\n";
  echo "			</form>\n";
  echo "		</div>\n";
  echo "\n";

  echo "		<div >\n";
  echo "			<span class=\"menu_desc\">Enter A Block Hash</span><br>\n";
  echo "			<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">\n";
  echo "				<input type=\"text\" name=\"block_hash\" size=\"40\">\n";
  echo "				<input type=\"submit\" name=\"submit\" class=\"btn btn-default\" value=\"Jump To Block\">\n";
  echo "			</form>\n";
  echo "		</div>\n";
  echo "\n";

  echo "		<div>\n";
  echo "			<span class=\"menu_desc\">Enter A Transaction ID</span><br>\n";
  echo "			<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"post\">\n";
  echo "				<input type=\"text\" name=\"transaction\" size=\"40\">\n";
  echo "					<input type=\"submit\" name=\"submit\" class=\"btn btn-default\" value=\"Jump To TX\">\n";
  echo "			</form>\n";
  echo "		</div>\n";
  echo "\n";

  echo "	</div>\n";  
}

	function block_detail ($block_id, $hash=FALSE)
	{
	  global $raw_block;
	        if ($hash == TRUE)
		{
			$raw_block = getblock ($block_id);
		}
		
		else
		{	
			$block_hash = getblockhash (intval ($block_id));
			
			$raw_block = getblock ($block_hash);
		}

		global $hashlink;
		global $prevlink;
		global $nextlink;
		global $blocktime;
		global $kind;

		switch ($raw_block["version"]) {
		case 2:
		  $kind = "SHA256";
		  break;
		case 258:
		  $kind = "SHA256 Merged Mining";
		  break;
		case 4096:
		  $kind = "Scypt";
		    break;
		case 4354:
		  $kind = "Scypt Merged Mining";
		  break;
		}
		
		$hashlink = blockhash_link ($raw_block["hash"]);

		$nextlink = "<a href=\"".$_SERVER["PHP_SELF"]."?block_hash=".$raw_block["nextblockhash"]."\" title=\"View Block Details\">".$raw_block["nextblockhash"]."</a>\n";
		$prevlink = "<a href=\"".$_SERVER["PHP_SELF"]."?block_hash=".$raw_block["previousblockhash"]."\" title=\"View Previous Block\">".$raw_block["previousblockhash"]."</a>\n";
		$blocktime = date ("F j, Y, H:i:s", $raw_block["time"]);


echo <<< HERE
  <div class="container">
  <h2 style="padding-bottom:10px">Block #{$raw_block["height"]}</h1>
  <div class="row-fluid">
  <div class="span6">
  <table class="table table-striped">
  <tbody><tr>
  <th colspan="2">Summary</th>
  </tr>
  <tr>
  <td>PoW</td>
  <td>{$kind}</td>
  </tr>
  <tr>
  <td>Size</td>
  <td>{$raw_block["size"]}</td>
  </tr>
  <tr>
  <td>Confirmations</td>
  <td>{$raw_block["confirmations"]}</td>
  </tr>
  <tr>
  <td>Bits</td>
  <td>{$raw_block["bits"]}</td>
  </tr>
  <tr>
  <td>Difficulty</td>
  <td>{$raw_block["difficulty"]}</td>
  </tr>
  <tr>
  <td>Timestamp</td>
  <td>{$blocktime}</td>
  </tr>
				 
</tbody>
</table>
</div>
<div class="span6">
            <table class="table table-striped">
                <tbody><tr>
                    <th colspan="2">Hashes</th>
                </tr>
                <tr>
                    <td>Hash</td>
			      <td>{$hashlink}
                    </td>
                </tr>
                <tr>
                    
                    <td>Previous Block</td>
			<td>{$prevlink}</td>
                </tr>
                <tr>
                    <td>Next Block</td>
                     <td>{$nextlink}</td>
                </tr>
                <tr>
                    <td>Merkle Root</td>
			<td>{$raw_block["merkleroot"]}</td>
                </tr>
</tbody></table>
</div>
</div>							  
<div style="width:60%;">
<h2 style="padding-bottom:10px">Transactions</h1>

<table class="table table-striped">
HERE;

	
                global $txlink;
		
		foreach ($raw_block["tx"] as $index => $tx)
		  {
		$txlink = "<a href=\"".$_SERVER["PHP_SELF"]."?transaction=".$tx."\" title=\"View Block Details\">".$tx."</a>\n";
		    
echo <<< HERE
<tr>
  <td>
  {$txlink}
</td>
</tr>
HERE;
		  }
		echo "</table></div></div>";
	
		
	}
	
function tx_detail ($tx_id)
{
  global $raw_tx;
  $raw_tx = getrawtransaction ($tx_id);
  $tx_time = date ("F j, Y, H:i:s", $raw_tx["time"]);
  $blocklink = blockhash_link($raw_tx["blockhash"]);
echo <<< HERE
<div class="container">    
<h4 style="padding-bottom:10px">Transaction #{$tx_id}</h1>
  <table class="table table-striped" style="table-layout: fixed; word-wrap: break-word;">
  <colgroup>
  <col span="1" style="width: 15%;">
  <col span="1" style="width: 85%;">
  </colgroup>  
  <tbody>
  <tr>
  <th colspan="2">Detail</th>
  </tr>
  <tr>
  <td>Time</td>
  <td>{$tx_time}</td>
  </tr>
  <tr>
  <td>Lock Time</td>
  <td>{$raw_tx["locktime"]}</td>
  </tr>
  <tr>
  <td>Confirmations</td>
  <td>{$raw_tx["confirmations"]}</td>
  </tr>
  <tr>
  <td>Block</td>
  <td>{$blocklink}</td>
  </tr>
  <tr>
  <td>Hex Data</td>
  <td>{$raw_tx["hex"]}</td>
  </tr>
  </tbody>
  </table>
<table class="table table-striped">
<tbody>
<tr>
<th colspan="2">Inputs</th>
</tr>
<tr>
</tbody>
</table>
<table class="table">
  <colgroup>
  <col span="1" style="width: 15%;">
  <col span="1" style="width: 85%;">
  </colgroup>  
  <tbody>
HERE;
		
		foreach ($raw_tx["vin"] as $key => $txin)
		{
			section_subhead ("Input Transaction ".$key);

			if (isset ($txin["coinbase"]))
			{
				detail_display ("Coinbase", $txin["coinbase"]);
		
				detail_display ("Sequence", $txin["sequence"]);
			}
			
			else
			{
				detail_display ("TX ID", tx_link ($txin["txid"]));
		
				detail_display ("TX Output", $txin["vout"]);
		
				detail_display ("TX Sequence", $txin["sequence"]);
		
				detail_display ("Script Sig (ASM)", $txin["scriptSig"]["asm"], 50);
		
				detail_display ("Script Sig (HEX)", $txin["scriptSig"]["hex"], 50);
			}
		}

		
echo <<< HERE
</tbody>
</table>
<table class="table table-striped">
<tbody>
<tr>
<th colspan="2">Outputs
</tr>
<tr>
</tbody>
</table>		  
<table class="table">
  <colgroup>
  <col span="1" style="width: 15%;">
  <col span="1" style="width: 85%;">
  </colgroup>  
  <tbody>
HERE;
		
		foreach ($raw_tx["vout"] as $key => $txout)
		{
			section_subhead ("Output Transaction ".$key);
		
			detail_display ("TX Value", $txout["value"]);
		
			detail_display ("TX Type", $txout["scriptPubKey"]["type"]);
		
			detail_display ("Required Sigs", $txout["scriptPubKey"]["reqSigs"]);
		
			detail_display ("Script Pub Key (ASM)", $txout["scriptPubKey"]["asm"], 50);
		
			detail_display ("Script Pub Key (HEX)", $txout["scriptPubKey"]["hex"], 50);
		
			if (isset ($txout["scriptPubKey"]["addresses"]))
			{
				foreach ($txout["scriptPubKey"]["addresses"] as $key => $address);
				{
					detail_display ("Address ".$key, $address);
				}
			}
			
 		}
		echo "</tbody></table>";

		
		/* section_head ("Raw Transaction Detail"); */
		
		/* echo "	<div name=\"rawtrans\"class=\"container\">\n"; */
		/* print_r ($raw_tx); */
		/* echo "	\n</div><br><br>\n"; */
	}

	function detail_display ($title, $data, $wordwrap=0)
	{
	  if($wordwrap>0) {
	    $text = wordwrap ($data, $wordwrap, "<br>", TRUE);
	  } else {
	    $text = $data;
	  }
echo <<< HERE
<tr>
<td>
<span class='label label-inverse'>{$title}</span>
</td>
<td>
{$data}
</td>
  </tr>						  
HERE;
		/* if ($wordwrap > 0) */
		/* { */
		/* 	echo "		<div class=\"detail_data\">\n"; */
		/* 	echo "			".."\n"; */
		/* 	echo "		</div>\n"; */
		/* } */
		
		/* else */
		/* { */
		/* 	echo "		<div class=\"detail_data\">\n"; */
		/* 	echo "			".$data."\n"; */
		/* 	echo "		</div>\n"; */
		/* } */
		
		/* echo "	</div>\n"; */
	}

	function tx_link ($tx_id)
	{
		return "<a href=\"".$_SERVER["PHP_SELF"]."?transaction=".$tx_id."\" title=\"View Transaction Details\">".$tx_id."</a>\n";
	}

	function blockheight_link ($block_height)
	{
		return "<a href=\"".$_SERVER["PHP_SELF"]."?block_height=".$block_height."\" title=\"View Block Details\">".$block_height."</a>\n";
	}

	function blockhash_link ($block_hash)
	{
		return "<a href=\"".$_SERVER["PHP_SELF"]."?block_hash=".$block_hash."\" title=\"View Block Details\">".$block_hash."</a>\n";
	}

	function section_head ($heading)
	{
		echo "		<div class=\"section_head\">\n";
		echo "			".$heading."\n";
		echo "		</div>\n";
		echo "\n";
	}
	
	function section_subhead ($heading)
	{
		echo "		<div class=\"section_subhead\">\n";
		echo "			".$heading."\n";
		echo "		</div>\n";
		echo "\n";
	}
	
/******************************************************************************
	This script is Copyright © 2013 Jake Paysnoe.
	I hereby release this script into the public domain.
	Jake Paysnoe Jun 26, 2013
******************************************************************************/
?>