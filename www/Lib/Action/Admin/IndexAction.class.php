<?php
	class IndexAction extends CommonAction{
		
		public function __construct(){
			parent::__construct();
			if(empty($this->loginUser))
				$this->displayLoginPage("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			if(1!=$this->loginUser['usergroup'])//暂时方案，等用户组完善后，再做进一步处理
				$this->displayErrorPage("您无权访问此页面！");
		}
		public function index(){
			
			$this->display(DEFAULT_DISPLAY);
		}
		
		
		/**
		 * 
		 * 例子
		 */
		public function listPage(){
			$this->display(DEFAULT_DISPLAY);
		}
		public function createPage(){
			$this->display(DEFAULT_DISPLAY);
		}
		
	}
?>