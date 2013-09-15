<?php
	class IndexAction extends CommonAction{
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