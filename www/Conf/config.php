<?php
return array(
	//'配置项'=>'配置值'
	'APP_DEBUG' => true,

	'DB_TYPE' => 'mysql', 
	
	'DB_HOST' => '127.0.0.1', 
	
	'DB_NAME' => 'company', 
	
	'DB_USER' => 'sampadm', 
	
	'DB_PWD' => 'secret', 

	'DB_PORT' => '3306', 
	
	'DB_PREFIX' => 'tbl_', 

	'APP_GROUP_LIST'=>'Admin,Www',

 	'DEFAULT_GROUP'=>'Www',

	'APP_SUB_DOMAIN_DEPLOY'=>1, // 开启子域名配置

	'APP_SUB_DOMAIN_RULES'=>array(  

        'admin'=>array('Admin/'),  

        'www'=>array('Www/')
		 
    ),

	'STATIC'=>'http://www.local-dev.cn:8001/Public',
	'WWW'=>'http://www.local-dev.cn:8001',
    'ADMIN'=>'http://admin.local-dev.cn:8001',
    
	'UPLOAD_PATH'=>'./Public/Upload',
	'UPLOAD_SIZE' =>  31457280 ,

	//自定义配置
	'COOKIE_EXPIRE'=>31104000,//Cookie有效期
	'COOKIE_DOMAIN'=>"local-dev.cn",//有效域名
	'COOKIE_PATH'=>'/',//Cookie前缀
	'COOKIE_PREFIX'=>'company_',//cookie前缀

);
?>