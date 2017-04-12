<?php	

	/**
	*	Conv Post
	* 	
	*	Processing the POST method.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes	
	*/

	require('class.PostObject.inc.php');
	require('class.RateUpdate.inc.php');

	$post_object = new PostObject(); //Create method object.
	$rate_update = new RateUpdate($post_object); //Create new action.
	$rate_update->process(); //Process action.
	ResponseFactory::send($rate_update->getMessage()); //Create response.
	
?>