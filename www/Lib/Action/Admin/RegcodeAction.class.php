<?php
	import("@.Service.RegcodeService");
	class RegcodeAction extends CommonAction{
		
		public function regcodes(){
			$page=1;
			if(isset($_GET['p'])&&1<(int)$_GET['p']){
				$page=(int)$_GET['p'];
			}
			$regcodeService=new RegcodeService();
			$status=array(0,1);
			$regcodes=$regcodeService->findRegcodes(array("page"=>$page,"status"=>$status));
			if(!empty($regcodes)){
				$this->assign("regcodes",$regcodes);
				$showPage=$regcodeService->showPage(array("status"=>$status));
				$this->assign("page",$showPage);
			}
			$this->display(DEFAULT_DISPLAY);
		}
		
		public function create(){
			if(isset($_POST['code'])){
				$errMsg=array();
				empty($_POST['code']) && $errMsg[]="注册码不能为空！";
				!empty($errMsg) && $this->displayErrorPage(implode("<br />", $errMsg));
				$regcode['code']=$_POST['code'];
				$regcode['create_time']=getDatetime();
				$regcode['update_time']=getDatetime();
				$regcodeService=new RegcodeService();
				$isExisted=$regcodeService->isExisted($regcode) && $this->displayErrorPage("该注册码已经存在！");
				$flag=$regcodeService->createRegcode($regcode);
				false===$flag && $this->displayErrorPage("添加注册码失败！请联系客服人员！");
				$this->displaySuccessPage("添加注册码成功！", C("ADMIN")."/Regcode/regcodes");
			}
			$this->display(DEFAULT_DISPLAY);
		}
		
		public function edit(){
			if(isset($_POST['code'])){
				$errMsg=array();
				empty($_POST['code']) && $errMsg[]="注册码不能为空！";
				!empty($errMsg) && $this->displayErrorPage(implode("<br />", $errMsg));
				$regcodeService=new RegcodeService();
				$regcode['code']=$_POST['name'];//编辑前的注册码
				$regcode=$regcodeService->findRegcode($regcode);
				empty($regcode) && $this->displayErrorPage("非法操作！！");
				$regcode['code']=$_POST['code'];
				$regcode['update_time']=getDatetime();
		
				$isExisted=$regcodeService->isExisted($regcode) && $this->displayErrorPage("该注册码已经存在！");
				$flag=$regcodeService->updateRegcode($regcode);
				false===$flag && $this->displayErrorPage("编辑注册码失败！请联系客服人员！");
				$this->displaySuccessPage("编辑注册码成功！", C("ADMIN")."/Regcode/regcodes");
			}
				
			$regcodeService=new RegcodeService();
			$regcode['code']=trim($_GET['code']);
			$regcode=$regcodeService->findRegcode($regcode);
			empty($regcode) && $this->displayErrorPage("链接地址错误！");
			$this->assign("regcode",$regcode);
			$this->display(DEFAULT_DISPLAY);
		}
		
		public function deleteRegcode(){
			$regcode['code']=$_GET['code'];
			if(empty($regcode['code'])){
				$this->displayErrorPage("请选择要删除的注册码！");
			}
			$regcodeService=new RegcodeService();
			$flag=$regcodeService->deleteRegcode($regcode);
			if(false===$flag){
				$this->displayErrorPage("删除注册码操作失败！");
			}
			$this->displaySuccessPage("删除注册码".$regcode['code']."成功！");
		}
	}
?>