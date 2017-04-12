<?php

	/**
	*	Get Object
	*  
	*	Contains all the code for the GetObject class.
	* 
	*	@package  php
	*	@author  Harvey Lowndes
 	*/

	require('class.MethodObject.inc.php');

	/**
	*	Get Method Object Class
	*  
	*	A MethodObject sub-class to handle the GET request.
	* 
	*	@package  php
 	*/
	class GetObject extends MethodObject {
		
		/**
        *	The GET URI encoded query string parameters passed through.
        *	@access  private
        *	@var string[]
        */
		private $parameters;

		/**
        *	The valid parameters allowed in the query string.
        *	@access  private
        *	@var string[]
        */
		private $validParameters;

		/**
        *	The amount URI query string parameter value.
        *	@access  private
        *	@var float
        */
		private $amount;

		/**
        *	The Currency Object of the amount to be converted.
        *	@access  private
        *	@var Currency
        */
		private $from;

		/**
        *	The Currency Object the amount to be converted to. 
        *	@access  private
        *	@var Currency
        */
		private $to;

		/**
		*	Constructor
		* 	 
    	*	Constructor for the GetObject object.
    	*/
		public function __construct() {
			global $rates_xml;
			$this->parameters = array_keys($_GET);
			$this->validParameters = [AMOUNT, FROM, TO, FORMAT]; //MAKE A CONST?
			if($this->validateParameters()) {
				$this->setAmount($_GET[AMOUNT]);
				$this->from = $rates_xml->getObjectByCode(strtoupper($_GET[FROM]));
				$this->to = $rates_xml->getObjectByCode(strtoupper($_GET[TO]));
			}
		}

		/**
		*	Set Amount
		* 
    	*	Sets the amount.
    	* 
    	*	@param float $amount
    	*/
		public function setAmount($amount) {
			$this->amount = $amount;
		}

		/**
		*	Get Amount
		* 
    	*	Returns the amount.
    	* 
    	*	@return float
    	*/
		public function getAmount() {
			return $this->amount;
		}

		/**
		*	Get From
		* 
    	*	Returns the 'from' currency object.
    	* 
    	*	@return Currency
    	*/
		public function getFrom() {
			return $this->from;
		}

		/**
		*	Get To
		* 
    	*	Returns the 'to' currency object.
    	* 
    	*	@return Currency
    	*/
		public function getTo() {
			return $this->to;
		}

		/**
		*	Validate Parameters
		* 
    	*	Validates the encoded URI parameters.
    	* 
    	*	@throws  APIException if a required parameter is missing.
    	*	@throws  APIException if an addition parameter is present.
    	*	@throws  APIException if the currency parameter value is not valid.
    	*	@throws  APIException if either of the currencies do not exist.
    	* 
    	*	@return bool
    	*/
		public function validateParameters() { 
			global $rates_xml;
			$allReqParamsExist = !array_diff($this->validParameters, $this->parameters);	
			if($allReqParamsExist) {
				$onlyReqParamsExist = !array_diff($this->parameters, $this->validParameters);
				if($onlyReqParamsExist) {
					if($this->isCurrency($_GET[AMOUNT])) {
						if($rates_xml->codeExists(strtoupper($_GET[FROM])) && $rates_xml->codeExists(strtoupper($_GET[TO])))  {
							return true;
						} else {
							throw new APIException(ERROR_TITLE, ERROR_1000_MESSAGE, ERROR_1000);
						}
					} else {
						throw new APIException(ERROR_TITLE, ERROR_1300_MESSAGE, ERROR_1300);
					}
				} else {
					throw new APIException(ERROR_TITLE, ERROR_1200_MESSAGE, ERROR_1200);
				}
			} else {
				throw new APIException(ERROR_TITLE, ERROR_1100_MESSAGE, ERROR_1100); //check if right code.
			}
		}

	}

?>