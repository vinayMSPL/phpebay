<?php require_once('get-common/keys.php') ?>
<?php require_once('get-common/eBaySession.php') ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>GeteBayOfficialTime</TITLE>
</HEAD>
<BODY>

<?php    
    //SiteID must also be set in the Request's XML
    //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
    //SiteID Indicates the eBay site to associate the call with
    $siteID = 0;
    //the call being made:
    $verb = 'GeteBayOfficialTime';
    //Level / amount of data for the call to return (default = 0)
    $detailLevel = 0;

    $userToken="AgAAAA**AQAAAA**aAAAAA**bpVgTw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wJnY+lCpaLoAydj6x9nY+seQ**61UAAA**AAMAAA**sI7FyGQMpF2sSiRnarXjBfEefiolJU5iQiVFOHcOsSZs28bMucNrUeVa/A8n2C0YIPk1vxdjW9EoNHabYXaSE/rIVc52aK8C1jDH9H4bAr8d1v+o+QdxbaJGzigHCyabiXO3wXdID9mo/NiBuGf3s9XaeYKpUvW2Ps/py7quUd3RLDkvKmscSpDMZd9TEcpzzj6teJIf2vIg+nlwNyAERIYrD9dm3VF3x/+/wQodSW3QdnvV/tWLzDaw+xWjglxicqPhV+l5KEW8YPrZlwLfjfv1lWPCLBCJHXHRVd3PUZUekhHavC6MCTudoHpkp/3VlFrF0Kc9L7Wgv63gxhoKYgIUZJuJRvsd/kRQIlY0souzzDy+y0P6dOUWYqHdfRrMrzrMFCOi/hYVarBYQnAdtwRvcp3frfym7SoU2mpVImr/F6Nfa1QP1uiIHgRmWljNPcvY9wExC4A9lSNIWmWc+HEY8c48R0C59rzT3Gj1bH6HPTX1z6v6qjFMfAz6Dr488ds2tRgEzybl+gwaNx1BovZKf4IuKdud0Y9dVm2W+3GXjhcBnXoWcM3MddHMGe/zHOq9J043NULoZb5KOKXenDS9tsnDHk2yKKIdOoWWhVlYcEizqBd5H7XjB1+vZgFYWQfJph7qS/Hxj0leg9PrVKOHqBUAtXU8EHJg8uZX+B3GjCshuMc3LGk0J//7JEWwrq5+T/APnDojVC3LIhYDO0MH+VRHUiZ6aH+HpU4ZcahWGTkBuT7cFLINcrs/YOxv";
    ///Build the request Xml string
    $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
    $requestXmlBody .= '<GeteBayOfficialTimeRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
    $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
    $requestXmlBody .= '</GeteBayOfficialTimeRequest>';
    
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
        //get the node containing the time and display its contents
        $eBayTime = $responseDoc->getElementsByTagName('Timestamp');
        echo '<P><B>The Official eBay Time is ', $eBayTime->item(0)->nodeValue, ' GMT</B>';
    }
?>

</BODY>
</HTML>
