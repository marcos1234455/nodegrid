<?php
namespace Node;
class NodeGrid {
    public static string $ip = "127.0.0.1";
    public static int $port = 64989; // change this (if needed)
    public static string $url = "roblox.com"; // change this 

   

   static function requestUrl($url, $xml, $action) {
        $ch = curl_init($url);
        // using backslashes so php doesnt scream at me
        curl_setopt_array($ch, [
            \CURLOPT_HTTPHEADER => ["Content-Type: text/xml", "SOAPAction: $action"], // Soap action because why not
            \CURLOPT_POST => true,
            \CURLOPT_POSTFIELDS => $xml,
            \CURLOPT_RETURNTRANSFER => true,
            \CURLOPT_SSL_VERIFYHOST => false,
            \CURLOPT_SSL_VERIFYPEER => false
        ]);
$xmlshit = [ 
    "<ns1:value>", 
    "</ns1:value>", 
    "</ns1:OpenJobResult>", 
    "<ns1:OpenJobResult>", 
    "<ns1:type>", 
    "</ns1:type>", 
    "<ns1:table>", 
    "</ns1:table>", 
    "</ns1:OpenJobResult>", 
    "</ns1:OpenJobResponse>", 
    "</SOAP-ENV:Body>", 
    "</SOAP-ENV:Envelope>"
 ]; // rcc vomit
$luashit = [ "LUA_TSTRING", "LUA_TNUMBER", "LUA_TBOOLEAN", "LUA_TTABLE" ]; // rcc vomit
         $result = str_replace($xmlshit, "", strstr(str_replace($luashit, "", curl_exec($ch)), "<ns1:value>"));


            $position = strpos($result, "<ns1:LuaValue>");
            if($position !== false) $result = substr($result, 0, $position);
        

        return $result;
    }

    static function OpenJob($script = 'print("Hello World!")', $jobId = "helloworld", $jobExpiration = 0.1) {
        $url = self::$url;
        $xml = <<<EOT
         <?xml version="1.0" encoding="UTF - 8"?>
        <SOAP-ENV:Envelope 
            xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
            xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" 
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
            xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
            xmlns:ns2="http://$url/RCCServiceSoap" 
            xmlns:ns1="http://$url/" 
            xmlns:ns3="http://$url/RCCServiceSoap12">
            <SOAP-ENV:Body>
                <ns1:OpenJob>
                    <ns1:job>
                        <ns1:id>$jobId</ns1:id>
                        <ns1:expirationInSeconds>$jobExpiration</ns1:expirationInSeconds>
                        <ns1:category>1</ns1:category>
                        <ns1:cores>321</ns1:cores>
                    </ns1:job>
                    <ns1:script>
                        <ns1:name>Script</ns1:name>
                        <ns1:script>
                         $script
                        </ns1:script>
                    </ns1:script>
                </ns1:OpenJob>
            </SOAP-ENV:Body>
        </SOAP-ENV:Envelope> 
        EOT;

        return self::requestUrl("http://".self::$ip.":".self::$port, $xml, __FUNCTION__);
    }

    static function helloWorld() {
        return self::execScript('print("Hello World!")', "helloworld", 0.1);
    }
	function Execute($script, $jobID) {
		$url = self::$url;
		$xml = <<<EOT
			<?xml version="1.0" encoding="UTF - 8"?>
			<SOAP-ENV:Envelope 
				xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
				xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
				xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
				xmlns:xsd="http://www.w3.org/2001/XMLSchema"
				xmlns:ns2="http://$url/RCCServiceSoap"
				xmlns:ns1="http://$url/" 
				xmlns:ns3="http://$url/RCCServiceSoap12">
				<SOAP-ENV:Body>
					<ns1:Execute>
						<ns1:jobID>$jobID</ns1:jobID>
						<ns1:script>
							<ns1:name>Script</ns1:name>
							<ns1:script>
								$script
							</ns1:script>
						</ns1:script>
					</ns1:Execute>
				</SOAP-ENV:Body>
			</SOAP-ENV:Envelope>
		EOT;
		
		return self::requestUrl("http://".self::$ip.":".self::$port, $xml, __FUNCTION__);
	}
    
    }
