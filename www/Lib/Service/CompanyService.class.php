<?php
import("@.Service.CommonService");
	/**
	 * 
	 * 公司信息数据持久化操作
	 * @author liangzi 20130914
	 *
	 */
	class CompanyService extends CommonService{
		
		/**
		 * 查询公司介绍
		 */
		public  function getCompany(){
			$Company=M('Company');
			$company=$Company->find();
			if(isset($company['id'])){
				return $company;
			}
			return null;
		}
		
		/**
		 * 
		 * 添加公司信息
		 */
		public function addCompany($company){
			$Company=M('Company');
			$result=$Company->add($company);
			if($result!==false)
				return true;
			return false;
		}
		
		/**
		 * 
		 * 编辑保存公司信息
		 */
		public function editCompany($company){
			$Company=M('Company');
			$result=$Company->save($company);
			if($result!==false)
				return true;
			return false;
		}
	}