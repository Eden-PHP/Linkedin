<?php //-->
/*
 * This file is part of the LinkedIn package of the Eden PHP Library.
 * (c) 2012-2013 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE
 * distributed with this package.
 */
//echo __DIR__.'../vendor/eden/core/Eden/Core/';

require_once __DIR__.'/../../Core/Loader.php';
Eden\Core\Loader::i()
	->addRoot(
		true,
		'Eden\\Core'
	)
	->addRoot(
		realpath(__DIR__.'/../..'),
		'Eden\\Linkedin'
	)
	->addRoot(
		realpath(__DIR__.'/../..'),
		'Eden\\Curl'
	)
	->addRoot(
		realpath(__DIR__.'/../..'),
		'Eden\\Oauth'
	)
	->register()
	->load(
		'Eden\\Core\\Controller'
	);