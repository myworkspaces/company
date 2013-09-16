<?php
	/**
	 * 
	 * 产品分类数据操作
	 * @author Liangzi 20130916
	 *
	 */
	class ProductCategoryService extends CommonService{
		
		/**
		 * 
		 * 分类列表
		 */
		public function getCategoryList(){
			$ProductCategory=M('ProductCategory');
			$categoryList=$ProductCategory->select();
			if(!empty($categoryList))
				return $categoryList;
			return null;
		}
		
		/**
		 * 
		 * 分类保存
		 */
		public function saveCategory($category){
			$ProductCategory=M('ProductCategory');
			$result=$ProductCategory->add($category);
			if($result!==false){
				return true;
			}
			return false;
		}
		
		/**
		 * 
		 * 分类编辑
		 */
		public function editCategory($category){
			$ProductCategory=M('ProductCategory');
			$result=$ProductCategory->save($category);
			if($result!==false){
				return true;
			}
			return false;
		}
		
		/**
		 * 
		 * 分类删除
		 */
		public function delCategory(){
			$ProductCategory=M('ProductCategory');
			$result=$ProductCategory->save($category);
			if($result!==false){
				return true;
			}
			return false;
		}
	}
