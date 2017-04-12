<?php

	/**
	*	Rate Update
	*  
	*	Contains all the code for the Rate Update class.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes
	*/

	require('class.Action.inc.php');

	/**
	*	Rate Update Action Object Class
	*  
	*	An Action sub-class to update the rate of an element in the XML file.
	* 
	* 	@package  php
	*/
	class RateUpdate extends Action {

		/**
        *   The POST Method Object containing the URI encoded query string parameter values.
        *   @access  protected
        *   @var PostObject
        */
		protected $postObject;

		/**
		*	Constructor
		*  
    	*   Constructor for the RateUpdate object.
    	* 
    	* 	@param PostObject $post_object
    	*/
		public function __construct($post_object) {
			$this->postObject = $post_object;
		}

		/**
		*	The processing logic.
		* 
		* 	Replaces the old rate value with the new rate value.
		* 
		* 	@access  public
		*/
		public function process() {
			global $rates_xml;
			$current_rate = $rates_xml->xpath->query(CURRENCY_ELEMENT_PATH . '[@' . CODE_ATTRIBUTE . '="'. $this->postObject->getCurrency()->getCode() . '"]/@' . RATE_ATTRIBUTE);
			$this->postObject->setPreviousRate($current_rate->item(0)->nodeValue);
			$current_rate->item(0)->nodeValue = $this->postObject->getNewRate();
			$rates_xml->xml->save(RATES_XML);
		}

		/**
		* 	Get Message
		* 
		*	The returned message.
		* 
		* 	@throws  APIException if unable to replace template variables.
		* 
		* 	@return string
		*/
		public function getMessage() {
			global $request;
			global $output_format;
			try {
				//NOT VERY EFFICIENT BUT FOR EASE OF CHANGE
				$message = constant(strtoupper($output_format->getFormat()) . '_POST_RESPONSE_TEMPLATE');
				$message = str_replace("{{request}}", $request->method, $message);
				$message = str_replace("{{timestamp}}", $request->timestamp, $message);
				$message = str_replace("{{previous_rate}}", $this->postObject->getPreviousRate(), $message);
				$message = str_replace("{{code}}", $this->postObject->getCurrency()->getCode(), $message);
				$message = str_replace("{{name}}", $this->postObject->getCurrency()->getName(), $message);
				$message = str_replace("{{locations}}", $this->postObject->getCurrency()->locationsAsString(), $message);
				$message = str_replace("{{new_rate}}", $this->postObject->getNewRate(), $message);
			} catch(Exception $e) {
				throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
			}
			return $message;
		}

	}

?>