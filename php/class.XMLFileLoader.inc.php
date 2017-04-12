<?php

	/**
	*	XML File Loader	
	* 
	*	Contains all the code for the XML File Loader class.
	* 
	*  	@package  php
	*  	@author  Harvey Lowndes
	*/

	/**
	*	XML File Loader Class 	
	* 
	*	An file loader class super class for xml files.
	* 
	* 	@abstract
	*  	@package  php
	*/
	abstract class XMLFileLoader {

		/**
        *   The XML file loaded as a DOMDocument.
        *   @access  protected
        *   @var DOMDocument
        */
		protected $xml;

		/**
        *   The XPath Object of the XML file.
        *   @access  protected
        *   @var DomXPath
        */
		protected $xpath;

		/**
		*	XML validation logic.
		* 	@access  public
		* 	@abstract
		*/ 
		public abstract function validateXML();

		/**
		*	Constructor for the XML File Loader object.
		* 
		* 	@throws  APIException if there is an error setting up the DOMDocument and XPath.
		* 
		* 	@param string $xml_file
		*/
		public function __construct($xml_file) {
			try {
				$this->xml = new DOMDocument();
				$this->xml->load($xml_file);
				$this->xpath = new DOMXPath($this->xml);
			} catch(Exception $e) {

			}
			if(!$this->validateXML()) {
				if($method == 'GET') {
					throw new APIException(ERROR_TITLE, ERROR_1400_MESSAGE, ERROR_1400);
				} else {
					throw new APIException(ERROR_TITLE, ERROR_2500_MESSAGE, ERROR_2500);
				}
			}
		}

		/**
		* 	__get
		* 
		*	Returns private variable in XMLFileLoader object.
		* 
		* 	@param string $name
		*   @return mixed
		*/
		public function __get($name) {
			return $this->$name;
		}

	}

?>