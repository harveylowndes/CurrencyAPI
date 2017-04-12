<?php
	
	/**
	*	The API index page.
	* 
	*	@author  Harvey Lowndes
	*/

	$method = $_SERVER['REQUEST_METHOD']; //Before others as required for error message.

	/*
	*	Universally required classes and files.
	*	In a specific order.
	*/
	require('config.php');
	require('php/class.APIException.inc.php');
	require('php/class.Request.inc.php');
	require('php/class.ResponseFactory.inc.php');
	require('php/class.Format.inc.php'); //After response factory as can throw APIExceptions which require the response.
	require('php/class.RatesXMLFileHandler.inc.php');
	require('php/update.php');

	$request = null; 

	switch($method) {
		case "GET":
		case "PUT":
		case "POST":
		case "DELETE":
			$request = Request::getInstance($method);
			$request->process();
			break;
		default:
			$method = NULL;
			throw new APIException(ERROR_TITLE, ERROR_2000_MESSAGE, ERROR_2000); 
			break;
	}

	


?>