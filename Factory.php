<?php //-->
/*
 * This file is part of the LinkedIn package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
 
namespace Eden\Linkedin;

use Eden\Core\Base as CoreBase;

/**
 * LinkedIn API factory. This is a factory class with 
 * methods that will load up different tumblr classes.
 * LinkedIn classes are organized as described on their 
 * developer site: blog and user.
 *
 * @vendor Eden
 * @package Linkedin
 * @author Renandro Valparaiso valparaisoRenandro@gmail.com
 */
class Factory extends CoreBase
{
	
	const INSTANCE = 1;
	
	/**
	 * Returns tumblr auth method
	 *
	 * @param *string 
	 * @param *string 
	 * @return Oauth
	 */
	public function auth($key, $secret)
	{
		//Argument test
		Argument::i()
			//Argument 1 must be a string
			->test(1, 'string')
			//Argument 2 must be a string
			->test(2, 'string');
		
		return Oauth::i($key, $secret);
	}
	
	/**
	 * Returns tumblr blog method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return Blog
	 */
	public function blog($consumerKey, $consumerSecret, $accessToken, $accessSecret)
	{
		//argument test
		Argument::i()
			//Argument 1 must be a string
			->test(1, 'string')
			//Argument 2 must be a string
			->test(2, 'string')
			//Argument 3 must be a string
			->test(3, 'string')
			//Argument 4 must be a string
			->test(4, 'string');
		
		return Blog::i($consumerKey, $consumerSecret, $accessToken, $accessSecret);
	}
	
	/**
	 * Returns tumblr blog method
	 *
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @param *string 
	 * @return User
	 */
	public function user($consumerKey, $consumerSecret, $accessToken, $accessSecret)
	{
		//argument test
		Argument::i()
			//Argument 1 must be a string
			->test(1, 'string')
			//Argument 2 must be a string
			->test(2, 'string')
			//Argument 3 must be a string
			->test(3, 'string')
			//Argument 4 must be a string
			->test(4, 'string');
		
		return User::i($consumerKey, $consumerSecret, $accessToken, $accessSecret);
	}
}