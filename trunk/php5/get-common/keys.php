<?php
    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = false;   // toggle to true if going against production
    $compatabilityLevel = 771;    // eBay API version
    
    if ($production) {
        $devID = 'DDD';   // these prod keys are different from sandbox keys
        $appID = 'AAA';
        $certID = 'CCC';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        $userToken = 'YOUR_PROD_TOKEN';          
    } else {  
        // sandbox (test) environment
        $devID = 'W992MQE7Z1OG27661DNI2C1F29D1SI';         // insert your devID for sandbox
        $appID = 'PETERH521TE1H87E34C6HGYHGEKOU7';   // different from prod keys
        $certID = 'A36491V5D32$Y8A631S81-776K74L1';  // need three 'keys' and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**bpVgTw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wJnY+lCpaLoAydj6x9nY+seQ**61UAAA**AAMAAA**sI7FyGQMpF2sSiRnarXjBfEefiolJU5iQiVFOHcOsSZs28bMucNrUeVa/A8n2C0YIPk1vxdjW9EoNHabYXaSE/rIVc52aK8C1jDH9H4bAr8d1v+o+QdxbaJGzigHCyabiXO3wXdID9mo/NiBuGf3s9XaeYKpUvW2Ps/py7quUd3RLDkvKmscSpDMZd9TEcpzzj6teJIf2vIg+nlwNyAERIYrD9dm3VF3x/+/wQodSW3QdnvV/tWLzDaw+xWjglxicqPhV+l5KEW8YPrZlwLfjfv1lWPCLBCJHXHRVd3PUZUekhHavC6MCTudoHpkp/3VlFrF0Kc9L7Wgv63gxhoKYgIUZJuJRvsd/kRQIlY0souzzDy+y0P6dOUWYqHdfRrMrzrMFCOi/hYVarBYQnAdtwRvcp3frfym7SoU2mpVImr/F6Nfa1QP1uiIHgRmWljNPcvY9wExC4A9lSNIWmWc+HEY8c48R0C59rzT3Gj1bH6HPTX1z6v6qjFMfAz6Dr488ds2tRgEzybl+gwaNx1BovZKf4IuKdud0Y9dVm2W+3GXjhcBnXoWcM3MddHMGe/zHOq9J043NULoZb5KOKXenDS9tsnDHk2yKKIdOoWWhVlYcEizqBd5H7XjB1+vZgFYWQfJph7qS/Hxj0leg9PrVKOHqBUAtXU8EHJg8uZX+B3GjCshuMc3LGk0J//7JEWwrq5+T/APnDojVC3LIhYDO0MH+VRHUiZ6aH+HpU4ZcahWGTkBuT7cFLINcrs/YOxv';                 
    }
    
    
?>