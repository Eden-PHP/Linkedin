<?php //-->
/*
 * This file is part of the Tumblr package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Linkedin;

use Eden\Core\Base as CoreBase;
use Eden\Curl\Base as Curl;
use Eden\Oauth\Oauth2\Consumer;

/**
 * LinkedIn base
 *
 * @vendor Eden
 * @package Linkedin
 * @author Renandro Valparaiso valparaisoRenandro@gmail.com
 */
class Base extends CoreBase
{
	const API_KEY = 'api_key';
	protected $responseType = null;
	protected $clientId = null;
	protected $accessToken = null;
	protected $accessSecret	= null;
	protected $query = array();
	
	/**
	 * Constructs the base class
	 * @param string The Consumer Key
	 * @param string The Consumer Secret
	 * @param string The Access Token
	 * @param string The Access Secret
	 * @return void
	 */
	public function __construct($consumerKey, $consumerSecret, $accessToken, $accessSecret)
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
		
		$this->consumerKey = $consumerKey; 
		$this->consumerSecret = $consumerSecret; 
		$this->accessToken = $accessToken; 
		$this->accessSecret = $accessSecret;
	}

	/**
	 * Returns the meta of the last call
	 *
	 * @return array
	 */
	public function getMeta($key = NULL)
	{
		Argument::i()->test(1, 'string', 'null');
		
		if(isset($this->meta[$key])) {
			return $this->meta[$key];
		}
		
		return $this->meta;
	}
	
	/**
	 * Returns the access key
	 * 
	 * @param array
	 * @return array
	 */
	protected function accessKey($array)
	{
		foreach($array as $key => $val) {
			if(is_array($val)) {
				$array[$key] = $this->accessKey($val);
			}
			//if value is null
			if(is_null($val) || empty($val)) {
				//remove it to query
				unset($array[$key]);
			} else if($val === false) {
				$array[$key] = 0;
			} else if($val === true) {			
				$array[$key] = 1;
			}
			
		}
		
		return $array;
	}
	
	/**
	 * Resets all protected variables that are being used
	 *
	 * @return Eden\Tumblr\Base
	 */
	protected function reset()
	{
		//foreach this as key => value
		foreach ($this as $key => $value) {
			//if the value of key is not array
			if(!is_array($this->$key)) {
				//if key name starts at underscore, probably it is protected variable
				if(preg_match('/^_/', $key)) {
					//if the protected variable is not equal to token
					//we dont want to unset the access token
					if($key != '_token') {
						//reset all protected variables that currently use
						$this->$key = NULL;
					}
				}
			} 
        } 
		
		return $this;
	}
	
	/**
	 * Returns the respone
	 *
	 * @param string
	 * @param array
	 * @return array
	 */
	protected function getResponse($url, array $query = array())
	{
		//if needed, add developer id to the query
		if(!is_null($this->consumerKey)) {
			$query[self::API_KEY] = $this->consumerKey;
		}
		
		//prevent sending fields with no value
		$query = $this->accessKey($query);
		//build url query
		$url = $url.'?'.http_build_query($query);
		//set curl
		$curl =  Curl::i()
			->setUrl($url)
			->verifyHost(false)
			->verifyPeer(false)
			->setTimeout(60);
		//get response from curl
		$response = $curl->getJsonResponse();
		//get curl infomation
		$this->meta['url']			= $url;
		$this->meta['query']		= $query;
		$this->meta['curl']		= $curl->getMeta();
		$this->meta['response']	= $response;
		
		//reset variables
		unset($this->query);
		
		return $response;
	} 
	
	/**
	 * Returns Authentication Response
	 *
	 * @param string
	 * @param array
	 * @return array
	 */
	protected function getAuthResponse($url, array $query = array())
	{
		//prevent sending fields with no value
		$query = $this->accessKey($query); 
		//make oauth signature
		$rest =  Oauth::i()
			->consumer($url, $this->consumerKey, $this->consumerSecret)
			->useAuthorization()
			->setToken($this->accessToken, $this->accessSecret)
			->setSignatureToHmacSha1();
		//get response from curl
		$response = $rest->getJsonResponse($query);
			
		//get curl infomation
		$this->meta['url']			= $url;
		$this->meta['query']		= $query;
		$this->meta['response']	= $response;
		
		//reset variables
		unset($this->query);
		
		return $response;
	}
	
	/**
	 * Returns Post
	 *
	 * @param string
	 * @param array
	 * @return array
	 */
	protected function post($url, array $query = array())
	{
		//prevent sending fields with no value
		$query = $this->accessKey($query);
		//set headers
		$headers = array();
		$headers[] = Consumer::POST_HEADER;
		//make oauth signature
		$rest = Oauth::i()
			->consumer($url, $this->consumerKey, $this->consumerSecret)
			->setMethodToPost()
			->setToken($this->accessToken, $this->accessSecret)
			->setSignatureToHmacSha1();
		
		//get the authorization parameters as an array
		$signature 		= $rest->getSignature($query);
		$authorization 	= $rest->getAuthorization($signature, false);
		$authorization 	= $this->buildQuery($authorization);
		//if query is in array
		if(is_array($query)) {
			//build a http query
			$query 	= $this->buildQuery($query);
		}
		
		//determine the conector
		$connector = NULL;
		
		//if there is no question mark
		if(strpos($url, '?') === false) {
			$connector = '?';
		//if the redirect doesn't end with a question mark
		} else if(substr($url, -1) != '?') {
			$connector = '&';
		}
		
		//now add the authorization to the url
		$url .= $connector.$authorization;
		
		//set curl
		$curl = Curl::i()
			->verifyHost(false)
			->verifyPeer(false)
			->setUrl($url)
			->setPost(true)
			->setPostFields($query)
			->setHeaders($headers);
		
		//get the response
		$response = $curl->getJsonResponse();
	
		$this->meta = $curl->getMeta();
		$this->meta['url'] = $url;
		$this->meta['authorization'] = $authorization;
		$this->meta['headers'] = $headers;
		$this->meta['query'] = $query;
		
		//reset variables
		unset($this->query);
		
		return $response;
	}
}