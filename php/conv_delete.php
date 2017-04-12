<?php

	/**
	*	Conv Delete 
	* 	
	*	Processing the DELETE method.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes	
	*/

	require('class.DeleteObject.inc.php');
	require('class.DeleteCurrency.inc.php');

	$delete_object = new DeleteObject(); //Create new method object.
	$delete_currency = new DeleteCurrency($delete_object); //Create new action.
	$delete_currency->process(); //Process action.
	ResponseFactory::send($delete_currency->getMessage()); //Create response.

?>