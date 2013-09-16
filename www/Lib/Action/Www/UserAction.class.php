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
				$userService=new UserService();
				$flag=$userService->findUser($user);
				empty($flag) && $this->displayErrorPage("帐号密码错误！");
				$this->setLogin(array("name"=>$flag['name'],"email"=>$flag['email'],"nickname"=>$flag['nickname']));
				redirect(C("WWW"));
			}
			$this->display(DEFAULT_DISPLAY);
		}
		/**
		 * 
		 * @todo:email格式验证
		 */
		public function registe(){
			if(isset($_POST['username'])){
				$errMsg=array();
				empty($_POST['username']) && $errMsg[]="用户名不能为空！";
				empty($_POST['email']) && $errMsg[]="邮箱地址不能为空！";
				empty($_POST['password']) && $errMsg[]="密码不能为空！";
				empty($_POST['repassword']) && $errMsg[]="确认密码不能为空！";
				$password=$_POST['password'];
				$repassword=$_POST['repassword'];
				$password!==$repassword && $errMsg[]="两次输入密码不一样！";
				!empty($errMsg) && $this->displayErrorPage(implode("<br />", $errMsg));
				$user['name']=$_POST['username'];
				$user['nickname']=$_POST['username'];//昵称暂时不让用户输入
				$user['password']=md5($_POST['password']);
				$user['email']=$_POST['email'];
				$user['tel']=$_POST['tel'];
				$user['address']=$_POST['address'];
				$user['create_time']=getDatetime();
				$user['update_time']=getDatetime();
				$user['user_group_id']=0;//用户组暂时未创建
				$userService=new UserService();
				$isExisted=$userService->isExisted($user) && $this->displayErrorPage("该用户已经存在！");
				$flag=$userService->createUser($user);
				false===$flag && $this->displayErrorPage("注册失败！请联系客服人员！");
				$this->displaySuccessPage("注册成功！", C("WWW"));
			}
			$this->display(DEFAULT_DISPLAY);
		}
		
		public function logout(){
			Cookie::delete("name");
			Cookie::delete("email");
			Cookie::delete("nickname");
			redirect(C("WWW"));
		}
		private function setLogin($user){
			foreach ($user as $key => $value){
				Cookie::set($key, $value);
			}
		}
		
		public function edit(){
			if(empty($this->loginUser)){
				$this->displayErrorPage("无权进行此操作");
			}
			if(isset($_POST['username'])){
				$errMsg=array();
				empty($_POST['username']) && $errMsg[]="用户名不能为空！";
				empty($_POST['email']) && $errMsg[]="邮箱地址不能为空！";
				empty($_POST['name']) && $errMsg[]="非法操作！";
				!empty($errMsg) && $this->displayErrorPage(implode("<br />", $errMsg));
				$userService=new UserService();
				$user['name']=$_POST['name'];//编辑前的用户名
				$user=$userService->findUser($user);
				empty($user) && $this->displayErrorPage("非法操作！！");
				$user['name']=$_POST['username'];
				$user['nickname']=$_POST['username'];//昵称暂时不让用户输入
				$user['email']=$_POST['email'];
				$user['tel']=$_POST['tel'];
				$user['address']=$_POST['address'];
				$user['update_time']=getDatetime();
				
				$isExisted=$userService->isExisted($user) && $this->displayErrorPage("该用户已经存在！");
				$flag=$userService->updateUser($user);
				false===$flag && $this->displayErrorPage("编辑个人信息失败！请联系客服人员！");
				
				$this->displaySuccessPage("编辑个人信息成功！", C("WWW"));
			}
			
			$userService=new UserService();
			$user=$userService->findUser($this->loginUser);
			empty($user) && $this->displayErrorPage("链接地址错误！");
			$this->assign("user",$user);
			$this->display(DEFAULT_DISPLAY);
		}
	}
?>