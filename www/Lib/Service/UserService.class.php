<?php
	import("@.Service.CommonService");
	class UserService extends CommonService{
		
		public function count($options = array()){
			$sql="";
			!isset($options['user_group_id']) && $options['user_group_id']=0;
			false===strpos($options['user_group_id'], ",")?
				$sql="user_group_id=".$options['user_group_id']:$sql="user_group_id in (".$options['user_group_id'].")";
			!isset($options['status']) && $options['status']=0
				&& $sql.=" and status=".$options['status'];
			isset($options['condition']) && !empty($options['condition']) && $sql.=$options['condition'];
			$count=M("User")->where($sql)->count();
			return $count;
		}
		public function createUser($user){
			return M("User")->add($user);
		}
		public function updateUser($user){
			return M("User")->save($user);
		}
		public function findUser($user = array()){
			!isset($user['user_group_id']) && $user['user_group_id']=0;
			!isset($user['status']) && $user['status']=0;
			$sql="user_group_id=".$user['user_group_id']." and status=".$user['status'];
			isset($user['id']) && $sql.=" and id=".$user['id'];
			isset($user['name']) && $sql.=" and name='".$user['name']."'";
			isset($user['email']) && $sql.=" and email='".$user['email']."'";
			$ret=M("User")->where($sql)->find();
			return $ret;
		}
		/**
		 * 
		 * @todo:搜索条件待完成
		 * @param array $options
		 * @return array
		 */
		public function findUsers($options = array()){
			!isset($options['condition']) && $options['condition']=$this->default['condition'];
			!isset($options['page']) && $options['page']=$this->default['page'];
			!isset($options['pageSize']) && $options['pageSize']=$this->default['pageSize'];
			
			$ret=null;
			!isset($options['user_group_id']) && $options['user_group_id']=0;
			!isset($options['status']) && $options['status']=0;
			$sql="user_group_id=".$options['user_group_id']." and status=".$options['status'];
			$ret=M("User")->where($sql)->page($options['page'].",".$options['pageSize'])->order("id desc")->select();
			return $ret;
		}
		/**
		 * 逻辑删除
		 * @param unknown_type $user
		 * @return unknown
		 */
		public function deleteUser($user = array()){
			$flag=false;
			$sql="";
			isset($user['id'])? $sql="id=".$user['id']:
				(isset($user['name']) && $sql="name = '".$user['name']."'");
			!empty($sql) && $flag=M("User")->where($sql)->setField("status",1);
			return $flag;
		}
		public function deleteUsers($options = array()){
			$flag=false;
			$sql="";
			isset($options['ids'])? $sql="id in (".$options['ids'].")":
				( isset($options['names']) && $sql="name in (".$options['names'].")" );
			!empty($sql) && $flag=M("User")->where($sql)->setField("status",1);
			return $flag;
		}
		public function isExisted($user = array()){
			$sql="";
			isset($user['name']) && !isset($user['email']) && $sql=" name ='".$user['name']."'";
			isset($user['email']) && !isset($user['name']) && $sql=" email ='".$user['email']."'";
			isset($user['name']) && isset($user['email']) 
				&& $sql=" (name = '".$user['name']."' || email = '".$user['email']."')";
			isset($user['id']) && $sql.=" and id !=".$user['id'];
			return M("User")->where($sql)->count();
		}
	}
?>