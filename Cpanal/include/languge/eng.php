<?php 
	
function lang($pharse){
	
	static $lang = [
		
		// CHAR TO NAVBAR
		'ADMIN'		 	=> 	'Adminstror',
		'CATEGORIES'	=>	'Categories',
		'ITEMS'		 	=>	'items',
		'MEMBERS'		=>	'Members',
		'STATICS'		=>	'Statics',
		'LOGS'			=>	'Logs',
		'EDITPROFILE'	=>	'EditProfile',
		'COMMENTS'		=>	'comments',
		'SETTINGS'		=>	'Setting',
		'LOGOUT'		=>	'Logout',
	];
	return "$lang[$pharse]";
	
	
}

?>