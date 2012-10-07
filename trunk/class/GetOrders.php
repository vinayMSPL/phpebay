<?php require_once('get-common/Utilities.php') ?>
<?php require_once('get-common/keys.php') ?>
<?php require_once('get-common/eBaySession.php') ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>GetOrders</TITLE>
</HEAD>
<BODY>
<FORM action="ebay_GetOrders.php" method="post">
<TABLE cellpadding="2" border="0">
	<TR>
		<TD>item modification time from:</TD>
		<TD>

         <?php 
         echo  gmDate("Y-m-d\TH:i:s\Z",time()-3*24*60*60); 
         ?>
        </TD>
	</TR>
    <TR>
		<TD>item modification time to:</TD>
		<TD>

		<?php echo gmDate("Y-m-d\TH:i:s\Z"); ?>
        </TD>
	</TR>

	<TR>

		<TD colspan="2" align="right"><INPUT type="submit" name="submit" value="GetOrders"></TD>
	</TR>
</TABLE>
</FORM>


<?php
if(isset($_POST['submit']))
{
	ini_set('magic_quotes_gpc', false);    // magic quotes will only confuse things like escaping apostrophe

	
	//SiteID must also be set in the Request's XML
	//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
	//SiteID Indicates the eBay site to associate the call with
	$siteID = 0;
	//the call being made:
	$verb = 'GetOrders';
	$detailLevel ='ReturnAll';
	$errorLanguage ='en_US';

	$site="US";
	$currency="USD";
	$country ="US";
	$modTimeTo=gmDate("Y-m-d\TH:i:s\Z");
	$modTimeFrom =gmDate("Y-m-d\TH:i:s\Z",time()-3*24*60*60);

	///Build the request Xml string
	$requestXmlBody  = '<?xml version="1.0" encoding="utf-8" ?>';
	$requestXmlBody .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
	$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
	$requestXmlBody .= "<DetailLevel>$detailLevel</DetailLevel>";
	$requestXmlBody .= "<ErrorLanguage>$errorLanguage</ErrorLanguage>";
	$requestXmlBody .= "<Version>$compatabilityLevel</Version>";
	$requestXmlBody .= "<ModTimeFrom>$modTimeFrom</ModTimeFrom>";
	$requestXmlBody .= "<ModTimeTo>$modTimeTo</ModTimeTo>";
	$requestXmlBody .= '</GetOrdersRequest>';

	//Create a new eBay session with all details pulled in from included keys.php
	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
	
	//send the request and get response
	$responseXml = $session->sendHttpRequest($requestXmlBody);
	if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
		die('<P>Error sending request');
	
	//Xml string is parsed and creates a DOM Document object
	$responseDoc = new DomDocument();
	$responseDoc->loadXML($responseXml);
	
	//get any error nodes
	$errors = $responseDoc->getElementsByTagName('Errors');
	
	//if there are error nodes
	if($errors->length > 0)
	{
		echo '<P><B>eBay returned the following error(s):</B>';
		//display each error
		//Get error code, ShortMesaage and LongMessage
		$code     = $errors->item(0)->getElementsByTagName('ErrorCode');
		$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
		$longMsg  = $errors->item(0)->getElementsByTagName('LongMessage');
		//Display code and shortmessage
		echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
		//if there is a long message (ie ErrorLevel=1), display it
		if(count($longMsg) > 0)
			echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
		
	} else { //no errors
		//save the tree to local file
		$responseDoc->save('GetOrders.xml');

		echo   " <meta   http-equiv=refresh   content=0;url=GetOrders.xml> "; 
		//get results nodes
		$responses = $responseDoc->getElementsByTagName("GetOrdersResponse");
		foreach ($responses as $response) {
			$acks = $response->getElementsByTagName("Ack");
			$ack   = $acks->item(0)->nodeValue;
			echo "Ack = $ack <BR />\n";   // Success if successful
			
			
			$itemArrays  = $response->getElementsByTagName("ItemArray")->item(0);
			
			
			//print conditions
			//$items = $itemArrays->getElementsByTagName("Item");
			//foreach($items as $item) {
			//	//ItemId
			//	$id =$item->getElementsByTagName('ItemID')->item(0)->nodeValue;
			//	echo "ItemID =$id  <BR />\n";
			//	//ListingDetails
			//	$listingDetails =$item->getElementsByTagName('ListingDetails')->item(0);
			//	$startTime =$listingDetails->getElementsByTagName('StartTime')->item(0)->nodeValue;
			//	$endTime =$listingDetails->getElementsByTagName('EndTime')->item(0)->nodeValue;
			//	echo "StartTime =$startTime  <BR />\n";
			//	echo "EndTime = $endTime <BR />\n";
			//	
			//	//SellingStatus
			//	$sellingStatus =$item->getElementsByTagName('SellingStatus')->item(0);
			//	$bidCount =$sellingStatus->getElementsByTagName('BidCount')->item(0)->nodeValue;
			//	$currentPrice =$sellingStatus->getElementsByTagName('CurrentPrice')->item(0)->nodeValue;
			//	$quantitySold =$sellingStatus->getElementsByTagName('QuantitySold')->item(0)->nodeValue;
			//	$listingStatus =$sellingStatus->getElementsByTagName('ListingStatus')->item(0)->nodeValue;
			//	echo "BidCount =$bidCount  <BR />\n";
			//	echo "CurrentPrice = $currentPrice <BR />\n";
			//	echo "QuantitySold = $quantitySold <BR />\n";
			//	echo "ListingStatus = $listingStatus <BR />\n";
			//	//Quantity
			//	$quantity =$item->getElementsByTagName('Quantity')->item(0)->nodeValue;
			//	echo "Quantity = $quantity <BR />\n";
			//	//Available Quantity
			//	$avb =($quantity-$quantitySold);
			//	echo "Available Quantity =$avb  <BR />\n";
			//	echo "<BR />\n";
			//	echo "<BR />\n";
			//}
			
			
		} // foreach response
		
	} // if $errors->length > 0
}
?>

</BODY>
</HTML>
