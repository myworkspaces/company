<?php
	import("@.Service.CompanyService");
	/**
	 * 
	 * 公司介绍板块
	 * @author liangzi 20130914
	 *
	 */
	class CompanyAction extends CommonAction{
		
		/**
		 * 
		 * 公司介绍前端页面
		 */
		public function aboutus(){
			$CompanyService=new CompanyService();
			$company=$CompanyService->getCompany();
			if($company!=null){
				$this->assign("company",$company);
			}
			$this->display(DEFAULT_DISPLAY);
		}
		
	/**
		 * 
		 * 添加或编辑公司介绍信息页面
		 */
		public function companyInfo(){
			$CompanyService=new CompanyService();
			$company=$CompanyService->getCompany();
			if($company!=null){
				$this->assign("company",$company);
			}
			$this->display(DEFAULT_DISPLAY);
		}
		
		/**
		 * 
		 * 保存公司介绍信息
		 */
		public function saveCompany(){
			if(isset($_POST['contact'])&&trim($_POST['contact'])!=""){
				$data['contact']=trim($_POST['contact']);
			}else{
				$this->displayErrorPage("请输入联系人！");
			}
			if(isset($_POST['tel'])&&trim($_POST['tel'])!=""){
				$data['tel']=trim($_POST['tel']);
			}else{
				$this->displayErrorPage("请输入联系电话！");
			}
			if(isset($_POST['address'])&&trim($_POST['address'])!=""){
				$data['address']=trim($_POST['address']);
			}else{
				$this->displayErrorPage("请输入联系地址！");
			}
			if(isset($_POST['description'])&&trim($_POST['description'])!=""){
				$data['description']=trim($_POST['description']);
			}else{
				$this->displayErrorPage("请输入公司介绍！");
			}
			if (isset($_POST['id'])){
				$data['id']=trim($_POST['id']);
				$CompanyService=new CompanyService();
				$result=$CompanyService->editCompany($data);
			}else{
				$CompanyService=new CompanyService();
				$result=$CompanyService->addCompany($data);
			}
			if($result)
				redirect(C('WWW')."/Company/aboutus");
			else 
				$this->displayErrorPage("修改公司介绍失败！");
			
		}
	}