<?php
	class EmptyAction extends Action{
		public function index(){
			$message=$_GET['message'];
			$modelName=MODULE_NAME;
			if(!empty($message)){
				$this->assign("msg",$message);
			}
			if(isset($_GET['href'])&&!empty($_GET['href'])){
				$this->assign("href",$_GET['href']);
			}
			$this->display("Public:".$modelName);
		}
	}
?>