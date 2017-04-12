<?php
	
	/**
	*	Conversion
	* 
	*	Contains all the code for the Conversion class.
	* 
	*	@package php
   	*	@author Harvey Lowndes
	*/

	require('class.Action.inc.php');

	/**
	*	Conversion Action Object Class
	* 
	*	An Action sub-class to convert a value from one
	*	currency rate to another.
	* 
	*	@package php
	*/
	class Conversion extends Action {

		/**
        *	The GET Method Object containing the URI encoded query string parameter values.
        *	@access  private
        *	@var GetObject
        */
		private $getObject; 

		/**
        *	The rate the calculation was converter at.
        *	@access  private
        *	@var float
        */
		private $conversionRate;

		/**
        *	The total calculated.
        *	@access  private
        *	@var float
        */
		private $total;

		/**
		*	Constructor
		*  
    	*	Constructor for the Conversion object.
    	* 
    	*	@param MethodObject $get_object
    	*/
		public function __construct($get_object) {
			$this->getObject = $get_object;
		}

		/**
    	*	The processing logic.
    	* 
    	*	Calculates the total and the rate of conversion.
    	* 
    	*	@throws  APIException if there is a problem during the calculations.
    	*/
		public function process() {
			try {
				$from_rate = $this->getObject->getFrom()->getRate();
				$to_rate = $this->getObject->getTo()->getRate();
				$amount = $this->getObject->getAmount();
				$total = ($amount / $from_rate) * $to_rate; //Total/New rate calculation.
				$this->conversionRate = ($to_rate / $from_rate); //Rate of conversion calculation.
			} catch(Exception $e) {
				throw new APIException(ERROR_TITLE, ERROR_1400_MESSAGE, ERROR_1400);
			}
			$this->total = $total;
		}

		/**
		*	Get Message
		*  
    	*	The returned message.
    	* 
    	*	@throws  APIException if unable to replace template variables.
    	* 
    	*	@return string
    	*/
		public function getMessage() {
			global $output_format;
			global $request;
			try {
				//NOT VERY EFFICIENT BUT FOR EASE OF CHANGE
				$message = constant(strtoupper($output_format->getFormat()) . '_GET_RESPONSE_TEMPLATE');
				$message = str_replace("{{timestamp}}", $request->getTimestamp(), $message);
				$message = str_replace("{{conv_rate}}", $this->conversionRate, $message);
				$message = str_replace("{{from_code}}", $this->getObject->getFrom()->getCode(), $message);
				$message = str_replace("{{from_name}}", $this->getObject->getFrom()->getName(), $message);
				$message = str_replace("{{from_locations}}", $this->getObject->getFrom()->locationsAsString(), $message);
				$message = str_replace("{{amount}}", $this->getObject->getAmount(), $message);
				$message = str_replace("{{to_code}}", $this->getObject->getTo()->getCode(), $message);
				$message = str_replace("{{to_name}}", $this->getObject->getTo()->getName(), $message);
				$message = str_replace("{{to_locations}}", $this->getObject->getTo()->locationsAsString(), $message);
				$message = str_replace("{{total}}", $this->total, $message);
			} catch(Exception $e) {
				throw new APIException(ERROR_TITLE, ERROR_1400_MESSAGE, ERROR_1400);
			}
			return $message;
		}

	}
?>