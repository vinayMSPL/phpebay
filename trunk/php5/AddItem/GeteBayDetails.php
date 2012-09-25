<?php require_once('../get-common/keys.php') ?>
<?php require_once('../get-common/eBaySession.php') ?>
<?php

	ini_set('magic_quotes_gpc', false);    // magic quotes will only confuse things like escaping apostrophe
	
	//SiteID must also be set in the Request's XML
	//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
	//SiteID Indicates the eBay site to associate the call with
	$siteID = 0;
	//the call being made:
$verb = 'GeteBayDetails';
	$detailLevel ='ReturnAll';
	$errorLanguage ='en_US';
   
 
	///Build the request Xml string
	$requestXmlBody  = '<?xml version="1.0" encoding="utf-8" ?>';
	$requestXmlBody .= '<GeteBayDetailsRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
	$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
	$requestXmlBody .= "<DetailLevel>$detailLevel</DetailLevel>";
	$requestXmlBody .= "<ErrorLanguage>$errorLanguage</ErrorLanguage>";
	$requestXmlBody .= "<Version>$compatabilityLevel</Version>";
	$requestXmlBody .= '<DetailName>ShippingServiceDetails</DetailName>';
	$requestXmlBody .= '</GeteBayDetailsRequest>';
	
	//Create a new eBay session with all details pulled in from included keys.php
	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
	
	//send the request and get response
	$responseXml = $session->sendHttpRequest($requestXmlBody);
	if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
		die('<P>Error sending request');
	
	//Xml string is parsed and creates a DOM Document object
	$responseDoc = new DomDocument();
	$responseDoc->loadXML($responseXml);

//save the tree to local file
$responseDoc->save('geteBayDetails.xml');
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
		
		//get results nodes
	$responses = $responseDoc->getElementsByTagName("GeteBayDetailsResponse");
		foreach ($responses as $response) {
			$acks = $response->getElementsByTagName("Ack");
			$ack   = $acks->item(0)->nodeValue;
			echo "Ack = $ack <BR />\n";   // Success if successful
			
		$shippingServices   = $response->getElementsByTagName("ShippingService");
		
		foreach ($shippingServices as $shippingService) {
		echo "ShippingService = $shippingService->nodeValue <BR />\n";
			}
		

			

		} // foreach response
		
	} // if $errors->length > 0

?>