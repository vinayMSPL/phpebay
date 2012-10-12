<?php require_once('get-common/Utilities.php') ?>
<?php require_once('get-common/keys.php') ?>
<?php require_once('get-common/eBaySession.php') ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>Revise CheckoutStatus</TITLE>
</HEAD>
<BODY>
<FORM action="ebay_ReviseCheckoutStatus.php" method="post">
<TABLE cellpadding="2" border="0">
<tr>
<td colspan="2">
step 1: <a href="http://tim7.thehub56.com/ebay_additem.php">Add an item(retrieve itemID)</a><br/>
setp 2:  simulate  as a buyer to login and purchase this item(manually)<br/>
setp 3:<a href="http://tim7.thehub56.com/ebay_getOrders.php">Get the Orders(retrieve OrderLineItemID)</a><br>
setp 4: revise CheckoutStatus in the form below<br>
</td>
</tr>
    <TR>
		<TD>Order LineItem ID </TD>
		<TD><INPUT type="text" name="orderLineItemID"  value="110106730975-26981292001" size=30/></TD>

       <TR>
		<TD>Adjust mentAmount</TD>
		<TD><INPUT type="text" name="adjustmentAmount"  value="2.00"/></TD>
	</TR>
    <TR>
		<TD>Amount Paid</TD>
		<TD><INPUT type="text" name="amountPaid" /></TD>
	</TR>
	  <TR>
		<TD>Checkout Status:</TD>
		<TD>set completed</TD>
	</TR>
	<TR>
		<TD colspan="2" align="right"><INPUT type="submit" name="submit" value="Revise CheckoutStatus(Completed)"></TD>
	</TR>
</TABLE>
</FORM>


<?php
if(isset($_POST['orderLineItemID']))
{
	ini_set('magic_quotes_gpc', false);    // magic quotes will only confuse things like escaping apostrophe
	//Get the item entered
	$orderLineItemID     = $_POST['orderLineItemID'];
	$adjustmentAmount     = $_POST['adjustmentAmount'];
	$amountPaid     = $_POST['amountPaid'];
	
	
	
	//SiteID must also be set in the Request's XML
	//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
	//SiteID Indicates the eBay site to associate the call with
	$siteID = 0;
	//the call being made:
	$verb = 'ReviseCheckoutStatus';
	$detailLevel ='ReturnAll';
	$errorLanguage ='en_US';

	$site="US";
	$currency="USD";
	$country ="US";


	///Build the request Xml string
	$requestXmlBody  = '<?xml version="1.0" encoding="utf-8" ?>';
	$requestXmlBody .= '<ReviseCheckoutStatusRequest   xmlns="urn:ebay:apis:eBLBaseComponents">';
	$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
	$requestXmlBody .= "<DetailLevel>$detailLevel</DetailLevel>";
	$requestXmlBody .= "<ErrorLanguage>$errorLanguage</ErrorLanguage>";
	$requestXmlBody .= "<Version>$compatabilityLevel</Version>";


	$requestXmlBody .= "<AdjustmentAmount>$adjustmentAmount</AdjustmentAmount> ";
	$requestXmlBody .= "<AmountPaid currencyID =\"USD\">$amountPaid</AmountPaid> ";
	$requestXmlBody .= "<OrderLineItemID>$orderLineItemID</OrderLineItemID>";
	$requestXmlBody .= "<OrderID>$orderLineItemID</OrderID>";
	$requestXmlBody .= "<PaymentMethodUsed>MOCC</PaymentMethodUsed>";

 	$requestXmlBody .= "<CheckoutStatus>Complete</CheckoutStatus> ";

	$requestXmlBody .= '</ReviseCheckoutStatusRequest>';
	
	


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
		
		
		//get results nodes
		$responses = $responseDoc->getElementsByTagName("ReviseCheckoutStatusResponse");
		foreach ($responses as $response) {
			$acks = $response->getElementsByTagName("Ack");
			$ack   = $acks->item(0)->nodeValue;
			echo "Ack = $ack <BR />\n";   // Success if successful
		
			
		} // foreach response
		

		
	} // if $errors->length > 0
}
?>

</BODY>
</HTML>
