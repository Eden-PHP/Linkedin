<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-20 at 08:38:01.
 */
class Linkedin_Tests_Linkedin_OauthTest extends \PHPUnit_Framework_TestCase
{
	public function setUp()
    {
        $this->key = '8hyp5euojxiu';
        $this->secret = 'UcdC6YBWHnmJeZWV';
    }

    public function testGetAccessToken()
    {
        //Paramaters are string / String
		$token = eden('linkedin')
			->auth(
				$this->key,
				$this->secret
				
			)
            ->getAccessToken(
            	'something',
            	'someone',
            	'noone'
			);        
    }
	/*
    public function testGetLoginUrl()
    {
        //Paramaters are string / String
        $login = eden('linkedin')
        	->auth(
        		$this->key,
        		$this->secret
			)
            ->getLoginUrl(
            	'something',
            	'someone'
			);
    }

    public function testGetRequestToken()
    {
        $token = eden('linkedin')->auth(
	        	$this->key,
	        	$this->secret
			)
            ->getRequestToken();
    }
	*/
}
