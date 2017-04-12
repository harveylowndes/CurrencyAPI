<?php 

    /**
    *   Reponse Factory
    *  
    *   Contains all the code for the Response Factory class.
    * 
    *   @package  php
    *   @author  Harvey Lowndes
    */
   
    require("class.Response.inc.php");

    /**
    *   Response Object Factory Class
    * 
    *   A Factory class for response.
    *   Currently only used to echo out the Response Object's __toString.
    * 
    *   @package  php
    */
    class ResponseFactory {
    	/**
    	*  RETURN NEW OBJECT INSTANCE.
        *   EXAMPLE FOR FUTURE EXTENDABILITY.
    	*/
    	/*public static function create($message)
        {
            return new Response($message);
        }*/

        /**
        *   Send 
        *	
        *   Returns the __toString of the response object to the client.
        * 
        *   @param string $message
        */
        public static function send($message) {
            echo new Response($message);
        }
    }

?>