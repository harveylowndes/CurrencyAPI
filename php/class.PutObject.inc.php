<?php

	/**
	*	Put Object
	* 
	*	Contains all the code for the Put Object class.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes
	*/

	require('class.MethodObject.inc.php');

	/**
	*	Put Method Object CLass 
	* 
	*	A Method sub-class to handle the PUT request.
	* 
	* 	@package  php
	*/
	class PutObject extends MethodObject {
		
		/**
        *   The rate of the new currency.
        *   @access  private
        *   @var float
        */
		private $rate;

		/**
        *   The code of the new currency.
        *   @access  private
        *   @var string
        */
		private $code;

		/**
        *   The name of the new currency.
        *   @access  private
        *   @var string
        */
		private $name;

		/**
        *   The locations that use the new currency.
        *   @access  private
        *   @var string[]
        */
		private $locations;

		/**
		* 	Constructor
		* 
    	*   Constructor for the PutObject object.
    	*/
		public function __construct() {
			global $_INPUT;
			if($this->validateParameters()) {
				$this->setRate($_INPUT[RATE]);
				$this->setCode(strtoupper($_INPUT[CODE]));
				$this->setName($_INPUT[NAME]);
				if(isset($_INPUT[LOCATIONS]) && count($_INPUT[LOCATIONS]) > 0 && !empty($_INPUT[LOCATIONS])) {
					$this->setLocations($_INPUT[LOCATIONS]);
				} else {
					$this->locations = [];
				}
			}
		}

		/**
		*	Set Rate 
		* 
    	*   Sets the rate.
    	* 
    	*	@param float $rate
    	*/
		public function setRate($rate) {
			$this->rate = $rate;
		}

		/**
		*	Set Code
		* 
    	*   Sets the code.
    	* 
    	*	@param string $code
    	*/
		public function setCode($code) {
			$this->code = $code;
		}

		/**
		*	Set Name 
		* 
    	*   Sets the name.
    	* 
    	*	@param strng $name
    	*/
		public function setName($name) {
			$this->name = $name;
		}

		/**
		* 	Set Locations
		* 
    	*   Sets the locations and validates the names.
    	* 
    	*	@param string $locations
    	*/
		public function setLocations($locations) {
			$valid_names = true;
			$locations_array = explode(",", $locations);
			$trimmed_array=array_map('trim',$locations_array);
			if(count($trimmed_array > 0)) {
				foreach($trimmed_array as $location) {
					if(!$this->isValidLocationName($location)) {
						throw new APIException(ERROR_TITLE, ERROR_2300_MESSAGE, ERROR_2300);
					}
				}
			}
			$this->locations = $trimmed_array;
		}

		/**
		* 	Get Rate
		* 
    	*   Returns the rate.
    	* 
    	*	@return float
    	*/
		public function getRate() {
			return $this->rate;
		}

		/**
		*	Get Code 
		* 
    	*   Returns the code.
    	* 
    	*	@return string
    	*/
		public function getCode() {
			return $this->code;
		}

		/**
		* 	Get Name
		* 
    	*   Returns the name.
    	* 
    	*	@return string
    	*/
		public function getName() {
			return $this->name;
		}

		/**
		*	Get Locations
		*  
    	*   Returns the locations.
    	* 
    	*	@return string[]
    	*/
		public function getLocations() {
			return $this->locations;
		}

		/**
		*	Validate Parameters 
		* 
    	*   Validates the encoded URI parameters.
    	* 
    	* 	@throws  APIException the code parameter is not set or is not valid.
    	*   @throws  APIException the rate parameter is not set or is not valid.
    	*   @throws  APIException the name parameter is not set or is not valid.
    	* 
    	*   @return bool
    	*/
		public function validateParameters() {
			global $rates_xml;
			global $_INPUT;
			if(isset($_INPUT[RATE]) && $this->isValidRate($_INPUT[RATE])) {
				if(isset($_INPUT[CODE]) && $this->isValidCode($_INPUT[CODE])) {
					if(isset($_INPUT[NAME]) && $this->isValidName($_INPUT[NAME])) {
						return true;
					} else {
						throw new APIException(ERROR_TITLE, ERROR_2300_MESSAGE, ERROR_2300);
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