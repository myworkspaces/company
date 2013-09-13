<?php
	import("ORG.Util.Page");
	class CommonService{
		//默认值
		private static $default=array('condition'=>"",'page'=>1,'pageSize'=>DEFAULT_PAGE_SIZE);
		
		public static function setDefault($key,$value){
			static::$default[$key]=$value;
		}
		/**
		 * 
		 * 总条数
		 * @param array $options
		 */
		public static function count($options){
			return 0;
		}
		/**
		 * 
		 * 分页页码
		 * @param array $options
		 */
		public static function showPage($options){
			!isset($options['condition']) && $options['condition']=static::$default['condition'];
			!isset($options['page']) && $options['page']=static::$default['page'];
			!isset($options['pageSize']) && $options['pageSize']=static::$default['pageSize'];
			$count=static::count($options['condition']);
			$page=new Page($count,$options['pageSize']);
			$theme='%first% %upPage% %linkPage% %downPage% %end%';
			$page->setConfig("theme", $theme);
			$show=$page->show();
			return $show;
		}
	}
?>