<?php require_once('./get-common/keys.php') ?>
<?php require_once('./get-common/eBaySession.php') ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>FindProducts</TITLE>
</HEAD>
<BODY>
<FORM action="FindProducts.php" method="post">
<TABLE cellpadding="2" border="0">
	<TR>
		<TD>ProductReferenceID(EPID):</TD>
		<TD><INPUT type="text" name="EPID"></TD>
	</TR>
	<TR>
		<TD>categoryID:</TD>
		<TD><INPUT type="text" name="Category"></TD>
	</TR>
	<TR>
		<TD colspan="2" align="right"><INPUT type="submit" name="submit"></TD>
	</TR>
</TABLE>
</FORM>

<?php
if(isset($_POST['Category']))
{
	//Get the query inputted
	$EPID = $_POST['EPID'];
	$category =$_POST['Category'];
	$serverUrl="http://open.api.sandbox.ebay.com/shopping";
	 $compatabilityLevel =517;
	
	//SiteID must also be set in the Request's XML
	//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
	//SiteID Indicates the eBay site to associate the call with
	$siteID = 0;
	//the call being made:
	$verb = 'FindProducts';
	
	///Build the request Xml string
	$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
	$requestXmlBody .= '<FindProductsRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
	$requestXmlBody .= "<CategoryID> $category </CategoryID>";
	//<ProductID type="ProductIDCodeType"> $EPID</ProductID>
	$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
	$requestXmlBody .= '</FindProductsRequest>';
	
	//Create a new eBay session with all details pulled in from included keys.php
	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
	
	//send the request and get response
	$responseXml = $session->sendHttpRequest($requestXmlBody);
	if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
		die('<P>Error sending request');
	
	//Xml string is parsed and creates a DOM Document object
	$responseDoc = new DomDocument();
	$responseDoc->loadXML($responseXml);

	$responseDoc->save('FindProducts.xml');
	
	//get any error nodes
	$errors = $responseDoc->getElementsByTagName('Errors');
	
	//if there are error nodes
	if($errors->length > 0)
	{
		echo '<P><B>eBay returned the following error(s):</B>';
		//display each error
		//Get error code, ShortMesaage and LongMessage
		$code = $errors->item(0)->getElementsByTagName('ErrorCode');
		$shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
		$longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
		//Display code and shortmessage
		echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
		//if there is a long message (ie ErrorLevel=1), display it
		if(count($longMsg) > 0)
			echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
		
	}
	else //no errors
	{
		
	}
}
?>

</BODY>
</HTML>
