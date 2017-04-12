<?php

	/**
	* 	Delete Object
	* 
	*	Contains all the code for the Delete Object class.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes
	*/

	require('class.MethodObject.inc.php');

	/**
	* 	Delete Method Object Class
	* 
	*	A MethodObject sub-class to handle the DELETE request.
	* 
	* 	@package  php
	*/
	class DeleteObject extends MethodObject {
		
		/**
        *   The Currency to be deleted.
        *   @access  private
        *   @var Currency
        */
		private $currency;

		/**
		*	Constructor
		*  
    	*   Constructor for the DeleteObject object.
    	*/
		public function __construct() {
			global $_INPUT;
			if($this->validateParameters()) {
				$this->setCurrency(strtoupper($_INPUT[CODE]));
			}
		}

		/**
		*	Get Currency
		*  
    	*   Returns the set currency object.
    	*   
    	*	@return Currency
    	*/
		public function getCurrency() {
			return $this->currency;	
		}

		/**
		* 	Set Currency
		* 
    	*   Sets the currency object.
    	* 
    	*	@param string $code
    	*/
		public function setCurrency($code) {
			global $rates_xml;
			$this->currency = $rates_xml->getObjectByCode($code); 
		}

		/**
		* 	Validate Parameters
		* 
    	*   Validates the encoded URI parameters.
    	* 
    	* 	@throws  APIException the code parameter is not set or if the code does not exist.
    	* 
    	*	@return bool
    	*/
		public function validateParameters() {
			global $_INPUT;
			global $rates_xml;
			if(isset($_INPUT[CODE])) { 
				if($rates_xml->codeExists(strtoupper($_INPUT[CODE]))) {
					return true;
				} else {
					throw new APIException(ERROR_TITLE, ERROR_2400_MESSAGE, ERROR_2400);
				}
			} else {
				throw new APIException(ERROR_TITLE, ERROR_2200_MESSAGE, ERROR_2200);
			}
		}
		

	}

?>