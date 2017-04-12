<?php

    /**
    *   API Exception
    * 
    *   Contains all code for the API Exception class.
    * 
    *   @package  php
    *   @author  Harvey Lowndes
    */

    /**
    *   API Exception Class 
    * 
    *   An Exception sub-class to manage exceptions in
    *   the correct format.
    * 
    *   @package  php
    */
    class APIException extends Exception {
    	
        /**
        *   The title of the error.
        *   @access  private
        *   @var string
        */
    	private $title;
       
        /**
           Constructor
         
           Constructor for the API Exception object.
         
           @param string $title
           @param string $message
           @param string $code
           @param Exception $previous 
        */
        public function __construct($title, $message, $code, Exception $previous = null) {
            $this->title = $title;
            $message = $this->formatErrorMessage($code, $message);
            parent::__construct($message, $code, $previous);
           @set_exception_handler(array('APIException', 'exception_handler')); //Sets the exception handler.
        }

        /**
           Retrieves the correct error message format
           and template.
         
           @param string $code
           @param string $message
        */
        public function formatErrorMessage($code, $message) {
            global $output_format;
            global $method; //Using non-object as could be used before request object is created.
            if($method == 'GET') {
            	$formatted = constant(strtoupper($output_format->getFormat()) . "_GET_ERROR_TEMPLATE");
            } else { //All other formats
                $formatted = constant(strtoupper($output_format->getFormat()) . "_ERROR_TEMPLATE");
                $formatted = str_replace("{{request}}", $method, $formatted);
            }
            $formatted = str_replace("{{code}}", $code, $formatted);
            $formatted = str_replace("{{message}}", $message, $formatted);
            return $formatted;
        }

        /**
        *   Exception Handler 
        * 
        *   Passes the output of the exception message 
        *   to the response factory.
        * 
        *   @param string $exception
        */
        public static function exception_handler($exception) { 
            ResponseFactory::send($exception->getMessage()); //Send exception message as response.
        }

    }

?>