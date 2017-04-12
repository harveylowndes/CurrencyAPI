<?php
	
	/**
	*	Update
	* 
	*	Updating the rates.
	* 
	*	@package  php
	*	@author Harvey Lowndes
	*/

	global $rates_xml;

	$timestamp = $rates_xml->xpath->query(TIMESTAMP_ELEMENT_PATH); //Adding [1] at the end of query will get 1st val
	$timestamp_content = $timestamp->item(0)->nodeValue; 
	$date = strtotime($timestamp_content);

	if($date < strtotime('-12 hours')) { //If more than 12 hours
		/* GET rates from API */
		try {
			global $API_URL;
			$content = file_get_contents($API_URL);
			$json = json_decode($content, true); //Try OOP way?
		} catch(Exception $e) {
			if($method == 'GET') {
				throw new APIException(ERROR_TITLE, ERROR_1400_MESSAGE, ERROR_1400);
			} else {
				throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
			}
		}

		/* Update the rates in XML document. */
		try {
			
			foreach ($rates_xml->xpath->query(CURRENCY_ELEMENT_PATH) as $currency) { //Loop through each currency element that is not GBP
				//Get new rate
				$code = $currency->getAttribute(CODE_ATTRIBUTE);
				if(isset($json['quotes'][BASE . $code])) {
					$newRate = $json['quotes'][BASE . $code];
					if($newRate != null) {
						$currency->setAttribute(RATE_ATTRIBUTE, $newRate); //Set attr value as new rate
					}
				}
			}
		} catch(Exception $e) {
			if($method == 'GET') {
				throw new APIException(ERROR_TITLE, ERROR_1400_MESSAGE, ERROR_1400);
			} else {
				throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
			}
		}

		$timestamp->item(0)->nodeValue = date("c", time()); //Set new timestamp
		$rates_xml->xml->save(RATES_XML);
	}

?>