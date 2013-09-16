<?php
	import("@.Service.UserService");
	class UserAction extends CommonAction{
		
		public function login(){
			if(isset($_POST['account'])){
				$errMsg=array();
				empty($_POST['account']) && $errMsg[]="帐号不能为空！";
				empty($_POST['password']) && $errMsg[]="密码不能为空！";
				!empty($errMsg) && $this->displayErrorPage(implode("<br />", $errMsg));
				false===strpos($_POST['account'], "@")?
					$user['name']=$_POST['account']:$user['email']=$_POST['account'];
				$user['password']=md5($_POST['password']);
				$user['user_group_id']=1;
				$userService=new UserService();
				$flag=$userService->findUser($user);
				empty($flag) && $this->displayErrorPage("帐号密码错误或者您不具备系统管理员权限！");
				setLoginMsg(array("name"=>$flag['name'],"email"=>$flag['email'],"nickname"=>$flag['nickname']));
				redirect(C("Admin"));
			}
			$this->display();
		}
	}
?>