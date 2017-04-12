<?php
	/**
	*	Action
	*
	*	Contains all code for the Action Class.
	* 
	*	@package php
	*	@author Harvey Lowndes
	*/

	/**
	*	Action Class 
	* 
	*	An abstract class to define uniform functionality and
	*	provide implementation details to child classes.
	*  	
	*	@abstract
	*	@package  php
	*/
	abstract class Action {
		
		/**
		*	The main logic of the action.
		* 
		*	Required function within any Action sub-class.
		*	This should contain the processing logic of the action.
		* 
		*	@access public
		*	@abstract
		*/
		public abstract function process();

		/**
		*	The response message generated as a
		*	result of sucessful processing.
		* 
		*	Required function within any Action sub-class. 
		*	This should contain the desired response string.
		* 
		*	@access public
		*	@abstract
		*/
		public abstract function getMessage();

	}
?>