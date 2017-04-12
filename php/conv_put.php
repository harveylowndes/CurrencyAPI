<?php

	/**
	*	Conv Put
	* 	
	*	Processing the PUT method.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes	
	*/

	require('class.PutObject.inc.php');
	require('class.AddCurrency.inc.php');

	$put_object = new PutObject(); //Create method object.
	$add_currency = new AddCurrency($put_object); //Create action.
	$add_currency->process(); //Process action.
	ResponseFactory::send($add_currency->getMessage()); //Create response.

?>