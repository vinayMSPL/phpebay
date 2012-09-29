<?php require_once('get-common/Utilities.php') ?>
<?php require_once('get-common/keys.php') ?>
<?php require_once('get-common/eBaySession.php') ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>AddItem</TITLE>
</HEAD>
<BODY>
<FORM action="AddItem.php" method="post">
<TABLE cellpadding="2" border="0">
	<TR>
		<TD>listingType</TD>
		<TD>
          <select name="listingType">
            <option value="Chinese">Chinese</option>
            <option value="FixedPriceItem">Fixed Price Item</option>
			  <option value="StoresFixedPrice">Fixed Price Item(GTC)</option>

          </select>
        </TD>
	</TR>
    <TR>
		<TD>primaryCategory</TD>
		<TD>
          <select name="primaryCategory">
	    <option value="14111">Test Category</option>
		  <option value="171166">171166</option>
            <option value="57889">Boys Athletic Pants</option>
            <option value="57890">Boys Corduroys Pants</option>
            <option value="57891">Boys Jeans Pants</option>
            <option value="57892">Boys Khakis Pants</option>
          </select>
        </TD>
	</TR>
    <TR>
		<TD>itemTitle</TD>
		<TD><INPUT type="text" name="itemTitle" value="TEST IN SANDBOX BEFORE PROD - DO NOT BID" size=30></TD>
	</TR>
    <TR>
		<TD>itemDescription</TD>
		<TD><INPUT type="text" name="itemDescription" value="TEST IN SANDBOX BEFORE PROD - DO NOT BID - This will incur prod listing fees" size=30></TD>
	</TR>
    <TR>
	  <TD>listingDuration</TD>
		<TD>
          <select name="listingDuration">
            <option value="Days_3">3 days</option>
			  <option value="Days_1">1 day</option>
            <option value="Days_5">5 days</option>
            <option value="Days_7">7 days</option>
			  <option value="Days_10">10 days</option>
			  <option value="Days_13">13 days</option>
			  <option value="Days_30">30 days</option>
			  <option value="GTC">GTC</option>
          </select>
          (defaults to GTC = 30 days for Store)
        </TD>
	</TR>
    <TR>
		<TD>startPrice</TD>
		<TD><INPUT type="text" name="startPrice" value="<?php echo rand(1,200) / 100 ?>"></TD>
	</TR>
    <TR>
		<TD>buyItNowPrice</TD>
		<TD><INPUT type="text" name="buyItNowPrice" value="<?php echo rand(299,599) / 100; ?>"> (set to 0.0 for Store)</TD>
	</TR>
	    <TR>
		<TD>reversePrice</TD>
		<TD><INPUT type="text" name="reversePrice" value="<?php echo rand(299,599) / 100; ?>"> (set to 0.0 for Store)</TD>
	</TR>
    <TR>
		<TD>quantity</TD>
		<TD><INPUT type="text" name="quantity" value="1"> (must be 1 for Auctions)</TD>
	</TR>
	<TR>
		<TD colspan="2" align="right"><INPUT type="submit" name="submit" value="AddItem"></TD>
	</TR>
</TABLE>
</FORM>


<?php
if(isset($_POST['listingType']))
{
	ini_set('magic_quotes_gpc', false);    // magic quotes will only confuse things like escaping apostrophe
	//Get the item entered
	$listingType     = $_POST['listingType'];
	$primaryCategory = $_POST['primaryCategory'];
	$secondCategory="";
	$title       = $_POST['itemTitle'];
	$subTitle = "SubTitle needs fees";
	if(get_magic_quotes_gpc()) {
		// print "stripslashes!!! <br>\n";
		$itemDescription = stripslashes($_POST['itemDescription']);
	} else {
		$itemDescription = $_POST['itemDescription'];
	}
	$itemDescription = $_POST['itemDescription'];
	$listingDuration = $_POST['listingDuration'];
	$startPrice      = $_POST['startPrice'];
	$buyItNowPrice   = $_POST['buyItNowPrice'];
	$reversePrice   = $_POST['reversePrice'];
	$quantity        = $_POST['quantity'];
	
	if ($listingType == 'StoresFixedPrice') {
		$buyItNowPrice = 0.0;   // don't have BuyItNow for SIF
		$listingDuration = 'GTC';
		$listingType="FixedPriceItem";
	}
	
	if ($listingType == 'Dutch') {
		$buyItNowPrice = 0.0;   // don't have BuyItNow for Dutch
	}
	
	//SiteID must also be set in the Request's XML
	//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
	//SiteID Indicates the eBay site to associate the call with
	$siteID = 0;
	//the call being made:
	$verb = 'AddItem';
	$detailLevel ='ReturnAll';
	$errorLanguage ='en_US';

    $site="US";
    $currency="USD";
	$country ="US";
	$location="San Jose, CA";
	$paymentMethod="PayPal";
	$paypalEmailAddress="magicalbookseller@yahoo.com";
	$shippingTermsInDescription =true;

	///Build the request Xml string
	$requestXmlBody  = '<?xml version="1.0" encoding="utf-8" ?>';
	$requestXmlBody .= '<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
	$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
	$requestXmlBody .= "<DetailLevel>$detailLevel</DetailLevel>";
	$requestXmlBody .= "<ErrorLanguage>$errorLanguage</ErrorLanguage>";
	$requestXmlBody .= "<Version>$compatabilityLevel</Version>";
	$requestXmlBody .= '<Item>';
	$requestXmlBody .= "<Site>$site</Site>";
	$requestXmlBody .= '<PrimaryCategory>';
	$requestXmlBody .= "<CategoryID>$primaryCategory</CategoryID>";
	$requestXmlBody .= '</PrimaryCategory>';
	
	//SecondaryCategory
	//$requestXmlBody .= '<SecondaryCategory>';
	//$requestXmlBody .= "<CategoryID>$secondCategory</CategoryID>";
	//$requestXmlBody .= '</SecondaryCategory>';
	
	//Custom  ItemSpecifics
		$requestXmlBody .= " <ItemSpecifics> ";
     $requestXmlBody .= " <NameValueList> ";
      $requestXmlBody .= "  <Name>Gender</Name> ";
      $requestXmlBody .= "  <Value>Women's</Value> ";
     $requestXmlBody .= " </NameValueList> ";
    $requestXmlBody .= "  <NameValueList> ";
    $requestXmlBody .= "   <Name>Metal</Name> ";
     $requestXmlBody .= "   <Value>14k Gold</Value> ";
    $requestXmlBody .= " </NameValueList> ";
   $requestXmlBody .= "   <NameValueList> ";
      $requestXmlBody .= "  <Name>Chain Style</Name> ";
     $requestXmlBody .= "   <Value>Figaro</Value> ";
    $requestXmlBody .= " </NameValueList> ";

     $requestXmlBody .= " <NameValueList> ";
    $requestXmlBody .= "    <Name>Chain Length</Name> ";
     $requestXmlBody .= "   <Value>7 in.</Value> ";
    $requestXmlBody .= "  </NameValueList> ";
    $requestXmlBody .= "  <NameValueList> ";
    $requestXmlBody .= "    <Name>Clasp</Name> ";
    $requestXmlBody .= "    <Value>Lobster</Value> ";
   $requestXmlBody .= "  </NameValueList> ";
	$requestXmlBody .= " </ItemSpecifics> ";


	//ListingEnhancement
	$requestXmlBody .= "<ListingEnhancement>BoldTitle</ListingEnhancement>";
	$storeCategoryID="12";
	$storeCategory2ID="11";
	//Storefront
    $requestXmlBody .= '<Storefront>';
	$requestXmlBody .= "<StoreCategoryID>$storeCategoryID</StoreCategoryID>";
	$requestXmlBody .= "<StoreCategory2ID>$storeCategory2ID</StoreCategory2ID>";
	$requestXmlBody .= '</Storefront>';

	if($listingType =="Chinese")
	{
		$requestXmlBody .= "<BuyItNowPrice currencyID=\"$currency\">$buyItNowPrice</BuyItNowPrice>";
	}
		if($listingType =="Chinese")
	{
		$requestXmlBody .= "<ReservePrice currencyID=\"$currency\">$reversePrice</ReservePrice>";
	}
	
	$requestXmlBody .= "<Country>$country</Country>";
	$requestXmlBody .= "<Currency>$currency</Currency>";
	$requestXmlBody .= "<ListingDuration>$listingDuration</ListingDuration>";
	$requestXmlBody .= "<ListingType>$listingType</ListingType>";
	$requestXmlBody .= "<Location><![CDATA[$location]]></Location>";
	$requestXmlBody .= "<PaymentMethods>$paymentMethod</PaymentMethods>";

	$requestXmlBody .= "<PayPalEmailAddress>$paypalEmailAddress</PayPalEmailAddress>";
	
	$requestXmlBody .= "<Quantity>$quantity</Quantity>";
	$requestXmlBody .= "<StartPrice>$startPrice</StartPrice>";
	$requestXmlBody .= "<ShippingTermsInDescription>$shippingTermsInDescription</ShippingTermsInDescription>";
	$requestXmlBody .= "<Title><![CDATA[$title]]></Title>";
	$requestXmlBody .= "<SubTitle><![CDATA[$subTitle]]></SubTitle>";
	
	$requestXmlBody .= "<Description><![CDATA[$itemDescription]]></Description>";
	
	//BuyerRequirement
	
	 $requestXmlBody .= "             <BuyerRequirementDetails>";
     $requestXmlBody .= "               <ShipToRegistrationCountry>false</ShipToRegistrationCountry>";
      $requestXmlBody .= "              <ZeroFeedbackScore>false</ZeroFeedbackScore>";
      $requestXmlBody .= "              <LinkedPayPalAccount>false</LinkedPayPalAccount>";
      $requestXmlBody .= "              <VerifiedUserRequirements>";
      $requestXmlBody .= "                  <VerifiedUser>false</VerifiedUser>";
     $requestXmlBody .= "                   <MinimumFeedbackScore>5</MinimumFeedbackScore>";
    $requestXmlBody .= "                </VerifiedUserRequirements>";
     $requestXmlBody .= "               <MaximumUnpaidItemStrikesInfo>";
   $requestXmlBody .= "                     <Count>2</Count>";
     $requestXmlBody .= "                   <Period>Days_30</Period>";
    $requestXmlBody .= "                </MaximumUnpaidItemStrikesInfo>";
    $requestXmlBody .= "               <MaximumBuyerPolicyViolations>";
      $requestXmlBody .= "                  <Count>4</Count>";
     $requestXmlBody .= "                   <Period>Days_30</Period>";
     $requestXmlBody .= "               </MaximumBuyerPolicyViolations>";
	$requestXmlBody .= "           </BuyerRequirementDetails>";
	
	//PictureDetails
	
	$GalleryType ="Plus";
	$GalleryURL ="http://i1.sandbox.ebayimg.com/03/i/00/3e/5f/cc_12.JPG";
	$PictureURL ="http://i1.sandbox.ebayimg.com/03/i/00/3d/9b/37_1.JPG?set_id=8800005007";
	
	 $requestXmlBody .= "      <PictureDetails>";
	$requestXmlBody .= "     <GalleryType>$GalleryType</GalleryType>";
	$requestXmlBody .= "     <GalleryURL>$GalleryURL</GalleryURL>";
	$requestXmlBody .= "    <PictureURL>$PictureURL</PictureURL>";
	$requestXmlBody .= "    </PictureDetails>";

	$returnsAcceptedOption ="ReturnsAccepted";
	$refundOption ="MoneyBack";
	$returnsWithinOption ="Days_30";
	$returnPolicyDescription ="Text description of return policy details";
	$shippingCostPaidByOption ="Buyer";
	
	
	$requestXmlBody .= "<ReturnPolicy>";
	$requestXmlBody .=	"<ReturnsAcceptedOption>$returnsAcceptedOption</ReturnsAcceptedOption>";
	$requestXmlBody .=	"<RefundOption>$refundOption</RefundOption>";
	$requestXmlBody .=	"<ReturnsWithinOption>$returnsWithinOption</ReturnsWithinOption>";
	$requestXmlBody .=	 "<Description>$returnPolicyDescription</Description>";
	$requestXmlBody .=	 "<ShippingCostPaidByOption>$shippingCostPaidByOption</ShippingCostPaidByOption>";
	$requestXmlBody .="</ReturnPolicy>";
	
	
	
	//flat shipping service
	 $requestXmlBody .=	    "<ShippingDetails>";
    $requestXmlBody .=	   "<ShippingType>Flat</ShippingType>";
    $requestXmlBody .=	   "<ShippingServiceOptions>";
    $requestXmlBody .=	     "<ShippingServicePriority>1</ShippingServicePriority>";
    $requestXmlBody .=	   "<ShippingService>USPSMedia</ShippingService>";
    $requestXmlBody .=	    "<ShippingServiceCost>2.50</ShippingServiceCost>";
	$requestXmlBody .=	    "<ShippingServiceAdditionalCost>1.50</ShippingServiceAdditionalCost>";
    $requestXmlBody .=	   "</ShippingServiceOptions>";
    $requestXmlBody .="</ShippingDetails>";
	//calculate shipping service
	 //<ShippingDetails>
  //    <CalculatedShippingRate>
  //      <OriginatingPostalCode>95125</OriginatingPostalCode>
  //      <PackageDepth unit="inches">2</PackageDepth>
  //      <PackageLength unit="inches">10</PackageLength>
  //      <PackageWidth unit="inches">7</PackageWidth>
  //      <PackagingHandlingCosts currencyID="USD">0.0</PackagingHandlingCosts>
  //      <ShippingPackage>PackageThickEnvelope</ShippingPackage>
  //      <WeightMajor unit="lbs">2</WeightMajor>
  //      <WeightMinor unit="oz">0</WeightMinor>
  //    </CalculatedShippingRate>
  //    <ShippingServiceOptions>
  //      <ShippingService>USPSMedia</ShippingService>
  //      <ShippingServicePriority>1</ShippingServicePriority>
  //    </ShippingServiceOptions>
  //    <ShippingServiceOptions>
  //      <ShippingService>USPSPriority</ShippingService>
  //      <ShippingServicePriority>2</ShippingServicePriority>
  //    </ShippingServiceOptions>
  //  </ShippingDetails>
	
	
	   // <ShippingDetails>
    //  <CalculatedShippingRate>
    //    <OriginatingPostalCode>95125</OriginatingPostalCode>
    //    <PackageDepth measurementSystem="English" unit="inches">6</PackageDepth>
    //    <PackageLength measurementSystem="English" unit="inches">7</PackageLength>
    //    <PackageWidth measurementSystem="English" unit="inches">7</PackageWidth>
    //    <PackagingHandlingCosts currencyID="USD">0.0</PackagingHandlingCosts>
    //    <ShippingIrregular>false</ShippingIrregular>
    //    <ShippingPackage>PackageThickEnvelope</ShippingPackage>
    //    <WeightMajor measurementSystem="English" unit="lbs">2</WeightMajor>
    //    <WeightMinor measurementSystem="English" unit="oz">0</WeightMinor>
    //  </CalculatedShippingRate>
    //  <PaymentInstructions>Payment must be received within 7 business days of purchase.</PaymentInstructions>
    //  <SalesTax>
    //    <SalesTaxPercent>8.75</SalesTaxPercent>
    //    <SalesTaxState>CA</SalesTaxState>
    //    <ShippingIncludedInTax>false</ShippingIncludedInTax>
    //  </SalesTax>
    //  <ShippingServiceOptions>
    //    <ShippingService>USPSPriority</ShippingService>
    //    <ShippingServicePriority>1</ShippingServicePriority>
    //    <ExpeditedService>false</ExpeditedService>
    //    <ShippingTimeMin>2</ShippingTimeMin>
    //    <ShippingTimeMax>3</ShippingTimeMax>
    //    <FreeShipping>true</FreeShipping>
    //  </ShippingServiceOptions>
    //  <ShippingServiceOptions>
    //    <ShippingService>UPSGround</ShippingService>
    //    <ShippingServicePriority>2</ShippingServicePriority>
    //    <ExpeditedService>false</ExpeditedService>
    //    <ShippingTimeMin>1</ShippingTimeMin>
    //    <ShippingTimeMax>6</ShippingTimeMax>
    //  </ShippingServiceOptions>
    //  <ShippingServiceOptions>
    //    <ShippingService>UPSNextDay</ShippingService>
    //    <ShippingServicePriority>3</ShippingServicePriority>
    //    <ExpeditedService>true</ExpeditedService>
    //    <ShippingTimeMin>1</ShippingTimeMin>
    //    <ShippingTimeMax>1</ShippingTimeMax>
    //  </ShippingServiceOptions>
    //  <ShippingType>Calculated</ShippingType>
    //  <ThirdPartyCheckout>false</ThirdPartyCheckout>
    //  <TaxTable />
	//  <InternationalShippingServiceOption>
    //  <ShippingService>UK_RoyalMailAirmailInternational</ShippingService>
    //  <ShippingServiceCost currencyID="GBP">5.00</ShippingServiceCost>
    //  <ShippingServiceAdditionalCost currencyID="GBP">0</ShippingServiceAdditionalCost>
    //  <!-- You need to begin the count from 1 for international shipping services -->
    //  <ShippingServicePriority>1</ShippingServicePriority>
    //  <ShipToLocation>Worldwide</ShipToLocation>
      //</InternationalShippingServiceOption>
    //</ShippingDetails>
	
	
	$requestXmlBody .="<DispatchTimeMax>3</DispatchTimeMax>";
	//UUID
	$UUID =$Facet_Utility->gen_uuid();
	$requestXmlBody .="<UUID>$UUID</UUID>";

//$ProductID="228742";
	$ProductReferenceID="62923188";
	//ProductListingDetails
	//$requestXmlBody .="<ProductListingDetails>";

   	//$requestXmlBody .=" <IncludeStockPhotoURL>true</IncludeStockPhotoURL>";
   	//$requestXmlBody .=" <ProductReferenceID>$ProductReferenceID</ProductReferenceID>";
    //$requestXmlBody .="  <ProductID>$ProductID</ProductID>";
	//$requestXmlBody .="  </ProductListingDetails>";
	
	//DiscountPriceInfo
//	$requestXmlBody .="<DiscountPriceInfo>";
  // 	$requestXmlBody .="<MinimumAdvertisedPrice currencyID=\"USD\">0.1</MinimumAdvertisedPrice>";
//	$requestXmlBody .="<MinimumAdvertisedPriceExposure>PreCheckout</MinimumAdvertisedPriceExposure>";
//	$requestXmlBody .="<OriginalRetailPrice currencyID=\"USD\">0.2</OriginalRetailPrice>";
//	$requestXmlBody .="<PricingTreatment>MAP</PricingTreatment>";
 //  	$requestXmlBody .="</DiscountPriceInfo>";
	
	$requestXmlBody .= '</Item>';
	$requestXmlBody .= '</AddItemRequest>';
	
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
		$responses = $responseDoc->getElementsByTagName("AddItemResponse");
		foreach ($responses as $response) {
			$acks = $response->getElementsByTagName("Ack");
			$ack   = $acks->item(0)->nodeValue;
			echo "Ack = $ack <BR />\n";   // Success if successful
			
			$endTimes  = $response->getElementsByTagName("EndTime");
			$endTime   = $endTimes->item(0)->nodeValue;
			echo "endTime = $endTime <BR />\n";
			
			$itemIDs  = $response->getElementsByTagName("ItemID");
			$itemID   = $itemIDs->item(0)->nodeValue;
			echo "itemID = $itemID <BR />\n";
			
			$linkBase = "http://cgi.sandbox.ebay.com/ws/eBayISAPI.dll?ViewItem&item=";
			echo "<a href=$linkBase" . $itemID . ">$title</a> <BR />";
			
			$feeNodes = $responseDoc->getElementsByTagName('Fee');
			foreach($feeNodes as $feeNode) {
				$feeNames = $feeNode->getElementsByTagName("Name");
				if ($feeNames->item(0)) {
					$feeName = $feeNames->item(0)->nodeValue;
					$fees = $feeNode->getElementsByTagName('Fee');  // get Fee amount nested in Fee
					$fee = $fees->item(0)->nodeValue;
					if ($fee > 0.0) {
						if ($feeName == 'ListingFee') {
							printf("<B>$feeName : %.2f </B><BR>\n", $fee); 
						} else {
							printf("$feeName : %.2f <BR>\n", $fee);
						}      
					}  // if $fee > 0
				} // if feeName
			} // foreach $feeNode
			
		} // foreach response
		
	} // if $errors->length > 0
}
?>

</BODY>
</HTML>
