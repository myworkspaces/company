<?php
	import("@.Service.CommonService");
	class UserService extends CommonService{
		
		public function count($options){
			return 0;
		}
		public function createUser($user){
			return M("User")->add($user);
		}
		public function updateUser($user){
			return M("User")->save($user);
		}
		public function findUser($user){
			$ret=null;
			isset($user['id']) && $ret=M("User")->find($user['id']);
			!isset($user['id']) && isset($user['name']) 
				&& $ret=M("User")->where("name='".$user['name']."'")->find();
			!isset($user['id']) && isset($user['email']) 
				&& $ret=M("User")->where("email='".$user['email']."'")->find();
			return $ret;
		}
		public function findUsers($options){
			
		}
		public function deleteUser($user){
			$flag=false;
			(isset($user['id']) && $flag=M("User")->delete($user['id']))
				||	(isset($user['name']) && $flag=M("User")->where("name = '".$user['name']."'")->delete()) ;
			return $flag;
		}
		public function deleteUsers($options){
			$flag=false;
			(isset($options['ids']) && $flag=M("User")->where("id in (".$options['ids'].")")->delete())
				|| (isset($options['names']) && $flag=M("User")->where("name in (".$options['names'].")")->delete());
			return $flag;
		}
		public function isExisted($user){
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