<?php

return array(

	'driver'       => 'file',
	'hash_method'  => 'sha256',
	'hash_key'     => '_fa321!@#',
	'lifetime'     => 1209600,
	'session_type' => Session::$default,
	'session_key'  => 'auth_user',

	// Username/password combinations for the Auth File driver
	'users' => array(
		'admin' => 'a2c61e9f5698bff97e771bb59010fa790b829b2fff1a106130bb958f6fd008a9',
	),

);