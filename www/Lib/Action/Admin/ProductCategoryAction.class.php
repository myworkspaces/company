<?php
	import("@.Service.ProductCategoryService");
	class ProductCategoryAction extends CommonAction{
		
		/**
		 * 
		 * 分类列表
		 */
		public function categoryList(){
			$ProductCategoryService=new ProductCategoryService();
			$categoryList=$ProductCategoryService->getCategoryList();
			if(!empty($categoryList)){
				$categoryMap=array();
				foreach($categoryList as $key=>$val){
					if($val['type']==1){
						$categoryFirst[$key]=$val['id'];
					}
					switch($val['type']){
						case '1':$categoryFirst[$key]=$val['id'];
						case '2':$categorySecond[$key]=$val['id'];
						case '3':$categoryThird[$key]=$val['id'];
						default:;
					}
					$categoryMap[$val['id']]=$val['name'];
				}
				$this->assign("categoryList",$categoryList);
				$this->assign("categoryMap",$categoryMap);
			}
			$this->display(DEFAULT_DISPLAY);			
		}
		
		/**
		 * 
		 * ajax新增分类保存
		 */
		public function saveCategory(){
			//todo--权限判断
			if(isset($_POST['name'])&&trim($_POST['name'])!=""){
				$data['name']=trim($_POST['name']);
			}else{
				$this->ajaxReturn(0,"请输入分类名称！",0);
			}
			if(isset($_POST['type'])&&trim($_POST['type'])!=""){
				$data['type']=trim($_POST['type']);
			}else{
				$this->ajaxReturn(0,"请选择分类级别！",0);
			}
			if(isset($_POST['parent_id'])&&trim($_POST['parent_id'])!=""){
				$data['parent_id']=trim($_POST['parent_id']);
			}else{
				if($data['type']>1){
					$this->ajaxReturn(0,"请选择所属分类！",0);
				}
			}
			if(isset($_POST['is_show'])&&trim($_POST['is_show'])!=""){
				$data['is_show']=$_POST['is_show'];
			}
			$time=getDatetime();
			$data['create_time']=$time;
			$data['update_time']=$time;
			$ProductCategoryService=new ProductCategoryService();
			$result=$ProductCategoryService->addCategory($data);
			if(!$result){
				$this->ajaxReturn(0,"新增分类失败！",0);
			}
			$this->ajaxReturn(1,"新增分类成功！",1);
		}
		
		/**
		 * 
		 * ajax编辑分类
		 */
		public function editCategory(){
			if(isset($_POST['id'])&&intval($_POST['id'])>0){
				$data['id']=intval($_POST['id']);
			}else{
				$this->ajaxReturn(0,"请选择要编辑的分类！",0);
			}
			if(isset($_POST['name'])&&trim($_POST['name'])!=""){
				$data['name']=trim($_POST['name']);
			}else{
				$this->ajaxReturn(0,"请输入分类名称！",0);
			}
			if(isset($_POST['type'])&&trim($_POST['type'])!=""){
				$data['type']=trim($_POST['type']);
			}else{
				$this->ajaxReturn(0,"请选择分类级别！",0);
			}
			if(isset($_POST['parent_id'])&&trim($_POST['parent_id'])!=""){
				$data['parent_id']=trim($_POST['parent_id']);
			}else{
				if($data['type']>1){
					$this->ajaxReturn(0,"请选择所属分类！",0);
				}
			}
			if(isset($_POST['is_show'])&&trim($_POST['is_show'])!=""){
				$data['is_show']=$_POST['is_show'];
			}
			$data['update_time']=getDatetime();
			$ProductCategoryService=new ProductCategoryService();
			$result=$ProductCategoryService->editCategory($data);
			if(!$result){
				$this->ajaxReturn(0,"编辑分类失败！",0);
			}
			$this->ajaxReturn(1,"编辑分类成功！",1);
		}
		
		/**
		 * 
		 * ajax删除分类
		 */
		public function delCategory(){
			if(isset($_POST['ids'])&&trim($_POST['ids'])!=""){
				$ids=trim($_POST['ids']);
			}else{
				$this->ajaxReturn(0,"请选择要删除的分类！",0);
			}
			$ProductCategoryService=new ProductCategoryService();
			$result=$ProductCategoryService->delCategory($ids);
			if(!$result){
				$this->ajaxReturn(0,"删除分类失败！",0);
			}
			$this->ajaxReturn(1,"删除分类成功！",1);
		}
	}
?>