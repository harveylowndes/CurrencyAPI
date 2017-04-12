<?php

	/**
	*	Currency
	* 
	* 	Contains all code for the Currency class.
	* 
	* 	@package  php
	* 	@author  Harvey lowndes
	*/

	/**
	*	Currency Object Class
	* 
	* 	A object class to manage a currency element as an object.
	* 
	* 	@package  php
	*/
	class Currency {

		/**
        *   The currency 3 digit code.
        *   @access  private
        *   @var string
        */
		private $code;

		/**
        *   The currency name.
        *   @access  private
        *   @var string
        */
		private $name;

		/**
        *   The currency rate.
        *   @access  private
        *   @var float
        */
		private $rate;

		/**
        *   The locations that use the currency.
        *   @access  private
        *   @var string[]
        */
		private $locations;

		/**
			Constructor 
		 
    	   Constructor for the Currency object.
    	 
    	   @param string $code
    	   @param string $name
    	   @param string $rate
    	   @param string[] $locations
    	*/
		public function __construct($code, $name, $rate, $locations) {
			$this->code = $code;
			$this->name = $name;
			$this->rate = $rate;
			$this->locations = $locations;
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
		*	Get Locations 
		* 
    	*   Returns the locations
    	* 
    	*	@return string[]
    	*/
		public function getLocations() {
			return $this->locations;
		}

		/**
		* 	Locations As String
		* 
    	*   Builds the location string from array items.
    	* 
    	*	@return string
    	*/
		public function locationsAsString() {
			$string = "";
			try {
				for($i = 0; $i < count($this->getLocations()); $i++) {
					$string .= $this->getLocations()[$i];
					if($i < count($this->getLocations()) - 1) {
						$string .= ", ";
					}
				}
			} catch(Exception $e) {
				throw new APIException(ERROR_TITLE, ERROR_1400_MESSAGE, ERROR_1400);
			}
			return $string;
		}
	}

?>