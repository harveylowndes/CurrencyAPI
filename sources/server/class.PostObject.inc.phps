<?php

	/**
	*	Post Object
	* 
	*	Contains all the code for the Post Object class.
	* 
	*	@package  php
	*	@author  Harvey Lowndes
	*/

	require('class.MethodObject.inc.php');

	/**
	*	Post Method Object Class 
	* 
	*	A MethodObject sub-class to handle the POST request.
	* 
	*	@package  php
	*/
	class PostObject extends MethodObject {
		
		/**
        *	The Currency Object of the POST target.
        *	@access  private
        *	@var Currency
        */
		private $currency;

		/**
        *	The rate to be changed to.
        *	@access  private
        *	@var float
        */
		private $newRate;

		/**
        *	The rate prior to the change.
        *	@access  private
        *	@var float
        */
		private $previousRate;

		/**
		*	Constructor
		* 
    	*	Constructor for PostObject object.
    	*/
		public function __construct() {
			if($this->validateParameters()) {
				$this->setCurrency(strtoupper($_POST[CODE]));
				$this->setNewRate($_POST[RATE]);
			}
		}

		/**
		*	Get Currency
		* 
    	*	Returns the currency.
    	* 
    	*	@return Currency
    	*/
		public function getCurrency() {
			return $this->currency;	
		}

		/**
		*	Get New Rate
		* 
    	*	Returns the new rate.
    	* 
    	*	@return float
    	*/
		public function getNewRate() {
			return $this->newRate;
		}

		/**
		*	Get Previous Rate
		* 
    	*	Returns the original/previous rate.
    	* 
    	*	@return float
    	*/
		public function getPreviousRate() {
			return $this->previousRate;
		}

		/**
		*	Set Currency
		* 
    	*	Sets the currency object.
    	* 
    	*	@param string $code
    	*/
		public function setCurrency($code) {
			global $rates_xml;
			$this->currency = $rates_xml->getObjectByCode($code); //2. ... and here.
				
		}

		/**
		*	Set New Rate
		* 
    	*	Sets the new rate.
    	* 
    	*	@param float $new_rate
    	*/
		public function setNewRate($new_rate) {
				$this->newRate = $new_rate;
		}

		/**
		*	Set Previous Rate
		* 
    	*	Sets the previous rate.
    	* 
    	*	@param float $previous_rate
    	*/
		public function setPreviousRate($previous_rate) {
				$this->previousRate = $previous_rate;
		}

		/**
		*	Validate Parameters
		* 
    	*	Validates the encoded URI parameters.
    	* 
    	*	@throws  APIException the code parameter is not set or if the code does not exist.
    	*	@throws  APIException the rate parameter is not set or if the rate is invalid.
    	* 	
    	*	@return bool
    	*/
		public function validateParameters() {
			global $rates_xml;
			if(isset($_POST[RATE]) && $this->isValidRate($_POST[RATE])) {
				if(isset($_POST[CODE])) {
					if($rates_xml->codeExists(strtoupper($_POST[CODE]))) {
						return true;
					} else {
						throw new APIException(ERROR_TITLE, ERROR_2400_MESSAGE, ERROR_2400);
					}
				} else {
					throw new APIException(ERROR_TITLE, ERROR_2200_MESSAGE, ERROR_2200);
				}
			} else {
				throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
			}
		}

	}
?>