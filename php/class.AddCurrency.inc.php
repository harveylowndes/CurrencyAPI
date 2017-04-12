<?php

    /**
    *   Add Currency
    *  
    *   Contains all code for the Add Currency Class.
    * 
    *   @package  php
    *   @author  Harvey Lowndes
    */
   
    require('class.Action.inc.php');
    
    /**
    *   Add Currency Action Object Class
    *  
    *   An Action sub-class to add a new currency to the XML file.
    * 
    *   @package  php
    */
    class AddCurrency extends Action {

        /**
        *   The PUT Method Object containing the URI encoded query string parameter values.
        *   @access  private
        *   @var PutObject
        */
        private $putObject;

        /**
        *   Constructor  
        * 
        *   The constructor for the AddCurrency object.
        * 
        *   @param MethodObject $put_object
        */
        public function __construct($put_object) {
            $this->putObject = new Currency($put_object->getCode(), $put_object->getName(), $put_object->getRate(), $put_object->getLocations());
        }

        /**
        *   The processing logic
        * 
        *   Creates a new currency entry in the XML file.
        * 
        *   @throws  APIException if there is a problem creating the new currency.
        */
        public function process() {
            try {
                global $rates_xml;

                //Overwrite currency if it exists.
                if($rates_xml->codeExists($this->putObject->getCode())) {
                    $rates_xml->deleteCurrency($this->putObject->getCode());
                }

                $root = $rates_xml->xml->getElementsByTagName(ROOT_NODE)->item(0);
                $curr = $rates_xml->xml->createElement(CURRENCY_NODE);

                $code = $rates_xml->xml->createAttribute(CODE_ATTRIBUTE);
                $code->value = $this->putObject->getCode();
                $curr->appendChild($code);

                $rate = $rates_xml->xml->createAttribute(RATE_ATTRIBUTE);
                $rate->value = $this->putObject->getRate();
                $curr->appendChild($rate);

                $name = $rates_xml->xml->createAttribute(NAME_ATTRIBUTE);
                $name->value = $this->putObject->getName();
                $curr->appendChild($name);

                $locations = $this->putObject->getLocations();

                foreach($locations as $location) {
                    $loc = $rates_xml->xml->createElement(LOCATION_NODE, $location);
                    $curr->appendChild($loc);
                }
                $root->appendChild($curr);

                $rates_xml->xml->save(RATES_XML);
            } catch(Exception $e) {
                throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
            }
        }

        /**
        *    Get Message
        * 
        *    The returned message.
        * 
        *    @throws  APIException if unable to replace template variables.
        * 
        *    @return string
        */
        public function getMessage() {
            global $request;
            global $output_format;
            try {
                //NOT VERY EFFICIENT BUT FOR EASE OF CHANGE
                $message = constant(strtoupper($output_format->getFormat()) . '_PUT_RESPONSE_TEMPLATE');
                $message = str_replace("{{request}}", $request->method, $message);
                $message = str_replace("{{timestamp}}", $request->timestamp, $message);
                $message = str_replace("{{rate}}", $this->putObject->getRate(), $message);
                $message = str_replace("{{code}}", $this->putObject->getCode(), $message);
                $message = str_replace("{{name}}", $this->putObject->getName(), $message);
                $message = str_replace("{{locations}}", $this->putObject->locationsAsString(), $message);
            } catch(Exception $e) {
                throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
            }
            return $message;
        }

    }
?>