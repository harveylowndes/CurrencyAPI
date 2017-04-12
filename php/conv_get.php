<?php

	/**
	*	Conv Get
	* 	
	*	Processing the GET method.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes	
	*/



	require('class.GetObject.inc.php');
	require('class.Conversion.inc.php');

	$get_object = new GetObject(); //Create new method object.
	$conversion = new Conversion($get_object); //Create new action.
	$conversion->process(); //Process action.
	ResponseFactory::send($conversion->getMessage()); //Create response.
	
?>