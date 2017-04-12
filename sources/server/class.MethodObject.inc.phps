<?php

	/**
	*	Method Object
	* 	
	*	Contains all the code for the Method Object class.
	* 
	*	@package  php
	*	@author  Harvey Lowndes
	*/

	/**
	*	Method Object Class 
	* 	
	*	Super class of request objects. Contains compulsary 
	*	implementation methods/functions and common methods/functions.
	* 
	*	@abstract
	*	@package  php
	*/
	abstract class MethodObject {

		/**
		*	Validate Parameters
		* 
		*	@access  public
		*	@abstract
		*/
	
		public abstract function validateParameters();


		/**
		*	Is Valid Rate
		* 
    	*	Checks the validity of a rate.
    	* 
    	*	@param float $rate
    	*	@return bool
    	*/
		public function isValidRate($rate) { 
			return preg_match("/^[0-9]+(?:\.[0-9]{1,6})?$/", $rate);
		}

		/**
		*	Is Currency
		* 
    	*	Checks the validity of a currency.
    	* 
    	*	@param float $amount
    	*	@return bool
    	*/
		public function isCurrency($amount) {
  			return preg_match("/^[0-9]+(?:\.[0-9]{1,2})?$/", $amount);
		}

		/**
		*	Is Valid Name
		* 
    	*	Checks the validity of a currency name.
    	* 
    	*	@param string $name
    	*	@return bool
    	*/
		public function isValidName($name) {
			$regex = preg_match("/^[a-zA-Z]+(?:[ '.-][a-zA-Z]+)*$/", $name);
			$length = strlen($name);
			if($regex == true && ($length > MIN_NAME_LENGTH && $length < MAX_NAME_LENGTH)) {
				return true;
			} else {
				return false;
			}
		}

		/**
		*	Is Valid Location Name
		*  
    	*	Checks the validity of a currency/location name.
    	* 
    	*	@param string $name
    	*	@return bool
    	*/
		public function isValidLocationName($name) {
			$regex = preg_match("/^[a-zA-Z]+(?:[ '.-][a-zA-Z]+)*$/", $name);
			$length = strlen($name);
			if($regex == true && ($length > MIN_NAME_LENGTH && $length < MAX_NAME_LENGTH)) {
				return true;
			} else {
				return false;
			}
		}

		/**
		*	Is Valid Code
		* 
    	*	Checks the validity of a currency code.
    	* 
    	*	@param string $code
    	*	@return bool
    	*/
		public function isValidCode($code) {
			return preg_match('/^[a-zA-Z]{3}$/', $code);
		}
	}

?>