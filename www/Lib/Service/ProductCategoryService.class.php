<?php
	import("@.Service.CommonService") ;
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
		 * 分类添加
		 */
		public function addCategory($category){
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
		 * 分类删除--todo,与之关联的产品分类关联表对应的数据也要删除
		 */
		public function delCategory($ids){
			$ProductCategory=M('ProductCategory');
			$ProductCategory->startTrans();
			$result=$ProductCategory->where('id in ('.$ids.')')->delete();
			if($result!==false){
				$ProductCategory->commit();
				return true;
			}
			$ProductCategory->rollback();
			return false;
		}
	}
