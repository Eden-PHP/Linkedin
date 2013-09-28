<?php //-->
/*
 * This file is part of the Tumblr package of the Eden PHP Library.
 * (c) 2013-2014 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */

namespace Eden\Linkedin;

use Eden\Oauth\Factory as FactoryOauth;

/**
 * LinkedIn Oauth
 *
 * @vendor Eden
 * @package Linkedin
 * @author Renandro Valparaiso valpraisoRenandro@gmail.com
 */
class Oauth extends Base
{
	const AUTHORIZE_URL = 'https://www.linkedin.com/uas/oauth2/authorization';
	const ACCESS_URL = 'https://www.linkedin.com/uas/oauth2/accessToken';
	
	const SCOPE_PEOPLE = 'http://api.linkedin.com/v1/people';
	const SCOPE_PEOPLE_SEARCH = 'http://api.linkedin.com/v1/people-search';
	const SCOPE_GROUP = 'http://api.linkedin.com/v1/groups';
	const SCOPE_POSTS = 'http://api.linkedin.com/v1/posts';
	const SCOPE_COMPANIES = 'http://api.linkedin.com/v1/companies';
	const SCOPE_COMPANY_SEARCH = 'http://api.linkedin.com/v1/company-search';
	const SCOPE_JOBS = 'http://api.linkedin.com/v1/jobs';
	const SCOPE_JOB_SEARCH = 'http://api.linkedin.com/v1/job-search';
	
	protected $_apiKey 	= null;
	protected $secret = null;
	protected $_scopes = array(
		'companies' => self::SCOPE_PEOPLE,
		'company-search' => self::SCOPE_PEOPLE_SEARCH,
		'group' => self::SCOPE_GROUP,
		'posts' => self::SCOPE_POSTS,
		'companies' => self::SCOPE_COMPANIES,
		'company-search' => self::SCOPE_COMPANY_SEARCH,
		'jobs' => self::SCOPE_JOBS,
		'job-search' => self::SCOPE_JOB_SEARCH
	);
	
	public function __construct($clientId, $clientSecret, $redirect, $scope = null,  $apiKey = null)
	{
		//argument test
		Argument::i()
			//Argument 1 must be a string
			->test(
				1,
				'string')
			//Argument 2 must be a string
			->test(
				2,
				'string'
			)
			//Argument 3 must be a string
			->test(
				3,
				'string')
			//Argument 4 must be a string
			->test(
				4,
				'string', null)
			//Argument 5 must be a string
			->test(
				5,
				'string', null);
			
		$this->_apiKey = $apiKey;
		
		parent::__construct($clientId, $clientSecret, $redirect, self::AUTHORIZE_URL, self::ACCESS_URL);
	}
	
	
	
	/**
	 * Returns the URL used for login. 
	 * 
	 * @param string the request key
	 * @param string
	 * @return string
	 */
	public function getLoginUrl($scope = NULL, $display = NULL)
	{
		//Argument tests
		Argument::i()
			//Argument 1 must be a string
			->test(1, 'string')
			//Argument 2 must be a string
			->test(2, 'string');
		
		//if scope is a key in the scopes array
		if(is_string($scope) && isset($this->_scopes[$scope])) {
			$scope = $this->_scopes[$scope];
		//if it's an array
		} else if(is_array($scope)) {
			//loop through it
			foreach($scope as $i => $key) {
				//if this is a scope key
				if(is_string($key) && isset($this->_scopes[$key])) {
					//change it
					$scope[$i] = $this->_scopes[$key];
				}
			}
		}
		
		return parent::getLoginUrl($scope, $display);
	}
}