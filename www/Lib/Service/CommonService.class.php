<?php
	import("ORG.Util.Page");
	class CommonService{
		//默认值
		protected $default=array('condition'=>"",'page'=>1,'pageSize'=>DEFAULT_PAGE_SIZE);
		
		public function setDefault($key,$value){
			$this->default[$key]=$value;
		}
		/**
		 * 
		 * 总条数
		 * @param array $options
		 */
		public function count($options){
			return 0;
		}
		/**
		 * 
		 * 分页页码
		 * @param array $options
		 */
		public function showPage($options){
			!isset($options['condition']) && $options['condition']=$this->default['condition'];
			!isset($options['page']) && $options['page']=$this->default['page'];
			!isset($options['pageSize']) && $options['pageSize']=$this->default['pageSize'];
			$count=$this->count($options['condition']);
			$page=new Page($count,$options['pageSize']);
			$theme='%first% %upPage% %linkPage% %downPage% %end%';
			$page->setConfig("theme", $theme);
			$show=$page->show();
			return $show;
		}
	}
?>