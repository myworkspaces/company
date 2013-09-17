<?php
	import("@.Service.CommonService");
	class RegcodeService extends CommonService{
		
		public function count($options = array()){
			!isset($options['status']) && $options['status']=0;
			is_array($options['status'])?
				$sql="status in (".implode(",", $options['status']).")" : $sql=" status=".$options['status'];
			isset($options['condition']) && !empty($options['condition']) && $sql.=$options['condition'];
			$count=M("Regcode")->where($sql)->count();
			return $count;
		}
		public function createRegcode($regcode){
			return M("Regcode")->add($regcode);
		}
		public function updateRegcode($regcode){
			return M("Regcode")->save($regcode);
		}
		
		public function findRegcode($regcode = array()){
			!isset($regcode['status']) && $regcode['status']=0;
			$sql=" status=".$regcode['status'];
			isset($regcode['id']) && $sql.=" and id=".$regcode['id'];
			isset($regcode['code']) && $sql.=" and code='".$regcode['code']."'";
			$ret=M("Regcode")->where($sql)->find();
			return $ret;
		}
		/**
		 * 
		 * @todo:搜索条件待完成
		 * @param array $options
		 * @return array
		 */
		public function findRegcodes($options = array()){
			!isset($options['condition']) && $options['condition']=$this->default['condition'];
			!isset($options['page']) && $options['page']=$this->default['page'];
			!isset($options['pageSize']) && $options['pageSize']=$this->default['pageSize'];
			
			$ret=null;
			!isset($options['status']) && $options['status']=0;
			is_array($options['status'])?
				$sql="status in (".implode(",", $options['status']).")":$sql=" status=".$options['status'];
			$ret=M("Regcode")->where($sql)->page($options['page'].",".$options['pageSize'])->order("status,id desc")->select();
			return $ret;
		}
		/**
		 * 删除
		 * @param unknown_type $regcode
		 * @return unknown
		 * @todo:删除注册码的时候是否应该关联删除已经关联产品的注册码,暂时的方案是不去删除关联表
		 */
		public function deleteRegcode($regcode = array()){
			$flag=false;
			$sql="";
			isset($regcode['id'])? $sql="id=".$regcode['id']:
				(isset($regcode['code']) && $sql="code = '".$regcode['code']."'");
			!empty($sql) && $flag=M("Regcode")->where($sql)->delete();
			return $flag;
		}
		public function deleteRegcodes($options = array()){
			$flag=false;
			$sql="";
			isset($options['ids'])? $sql="id in (".$options['ids'].")":
				( isset($options['codes']) && $sql="code in (".$options['codes'].")" );
			!empty($sql) && $flag=M("Regcode")->where($sql)->delete();
			return $flag;
		}
		public function isExisted($regcode = array()){
			isset($regcode['code']) && $sql=" code ='".$regcode['name']."'";
			isset($regcode['id']) && $sql.=" and id !=".$regcode['id'];
			return M("Regcode")->where($sql)->count();
		}
		
		//RegcodeProductRelation
		/**
		 * 要先判断注册码是否有效后才能添加
		 * @param array $productRegcodeRelation
		 * @return boolean
		 */
		public function createProductRegcodeRelation($productRegcodeRelation){
			$trans=M("ProductRegcodeRelation");
			$trans->startTrans();
			$flag=$trans->add($productRegcodeRelation);
			if(empty($flag)){
				$trans->rollback();
				return false;
			}
			$regcode=$this->findRegcode(array("code"=>$productRegcodeRelation['regcode'],"status"=>0));
			if(empty($regcode)){
				$trans->rollback();
				return false;
			}
			$regcode['status']=1;
			$regcode['update_time']=getDatetime();
			$flag=$this->updateRegcode($regcode);
			if(empty($flag)){
				$trans->rollback();
				return false;
			}	
			$trans->commit();
			return true;
		}
	}
?>