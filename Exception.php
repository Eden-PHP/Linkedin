<?php //-->
/*
 * This file is part of the Tumblr package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Linkedin;

use Eden\Core\Exception as CoreException;

/**
 * The base class for any class handling exceptions. Exceptions
 * allow an application to custom handle errors that would
 * normally let the system handle. This exception allows you to
 * specify error levels and error types. Also using this exception
 * outputs a trace (can be turned off) that shows where the problem
 * started to where the program stopped.
 *
 * @vendor Eden
 * @package Linkedin
 * @author Renandro Valparaiso valparaisoRenandro@gmail.com
 */
class Exception extends CoreException
{
	/**
     * One of the hard thing about instantiating classes is
     * that design patterns can impose different ways of
     * instantiating a class. The word "new" is not flexible.
     * Authors of classes should be able to control how a class
     * is instantiated, while leaving others using the class
     * oblivious to it. All in all its one less thing to remember
     * for each class call. By default we instantiate classes with
     * this method.
     *
     * @param [mixed[,mixed..]]
     * @return object
     */
	public static function i($message = NULL, $code = 0)
	{
		$class = __CLASS__;
		return new $class($message, $code);
	}
}