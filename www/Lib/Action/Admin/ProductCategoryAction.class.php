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
				$this->assign("categoryList",$categoryList);
			}
			$this->display(DEFAULT_DISPLAY);			
		}
		
		/**
		 * 
		 * 新增分类保存
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
			$ProductCategoryService=new ProductCategoryService();
			$result=$ProductCategoryService->addCategory($data);
			if(!$result){
				$this->ajaxReturn(0,"新增分类失败！",0);
			}
			$this->ajaxReturn(1,"新增分类成功！",1);
		}
	}
?>