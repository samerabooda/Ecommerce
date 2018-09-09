<?php 
	
function lang($pharse){
	
	static $lang = [
		//  كلمات النافبار
		
		'ADMIN'		 	=> 	'المدير',
		'CATEGORIES'	=>	'الاصناف',
		'ITEMS'		 	=>	'العناصر',
		'MEMBERS'		=>	'الاعضاء',
		'STATICS'		=>	'الاستتك',
		'LOGS'			=>	'الدخول',
		'EDITPROFILE'	=>	'تعديل البروفايل',
		'SETTINGS'		=>	'الاعدادات',
		'LOGOUT'		=>	'الخروج',
		
	];
	return "$lang[$pharse]";
	
	
}

?>