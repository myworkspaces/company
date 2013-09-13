<?php

//默认输出模板定义
define ( 'DEFAULT_DISPLAY', "Layout:index" );
define ( 'NO_LEFT_DISPLAY', "Layout:index_no_left" );
define ( 'NO_RIGHT_DISPLAY', "Layout:index_no_right");

define ( 'DEFAULT_ERROR', "Public:error" );

define ( 'DEFAULT_PAGE_SIZE',24);//默认一页显示条数24

load ( "extend" );
/**
 *
 * 文件上传
 * @param string $domain	指定上传文件的主目录
 * @param string $thumb  是否生成缩略图,如果有就传入缩略图的尺寸
 * @param string $maxSize 可上传的最大尺寸
 * @param $type 上传文件的类型
 */
function saveFile($domain, $subDir = false, $maxSize = false, $type = false) {
	import ( "ORG.Net.UploadFile" );
	$upload = new UploadFile (); // 实例化上传类
	$upload->maxSize = C ( 'UPLOAD_SIZE' ); // 设置附件上传大小
	if ($maxSize !== false) {
		$upload->maxSize = $maxSize;
	}
	$upload->allowExts = array ('jpg', 'gif', 'png', 'jpeg', 'swf', 'max', 'skp', 'zip', 'rar' ); // 设置附件上传类型
	if (false !== $type) {
		$upload->allowExts = $type;
	}
	$date = date ( "Y/m/d" );
	$upload->savePath = C ( 'UPLOAD_PATH' ) . '/' . $domain . '/' . $date . '/'; // 设置附件上传目录
	if(false!==$subDir){//子目录，为了防止重名问题的发生
		$upload->savePath.=$subDir."/";
	}
	mkdir ( $upload->savePath ,0777,true); //创建目录
	$upload->saveRule = "uniqid"; //文件名生成规则

	if (! $upload->upload ()) { // 上传错误提示错误信息
// 		print_r($upload);
		$msg=$upload->getErrorMsg();
// 		echo mb_detect_encoding($msg);
		$msg=mb_convert_encoding($msg, "gbk","utf-8");
		echo $msg;
// 		exit ( $upload->getErrorMsg () . "  " );
		//$this->error($upload->getErrorMsg());
		return false;
	} else { // 上传成功获取上传文件信息
		$info = $upload->getUploadFileInfo ();
// 		print_r($info);
		

		//print "上传信息：" . $info [0] ['savepath'];
		$start = strlen ( C ( 'UPLOAD_PATH' ) ) + 1;
		for($i = 0; $i < count ( $info ); $i ++) {
			$str = $info [$i] ['savepath'];
			//print "path---" . $str;
			$picPath = msubstr ( $str, $start, (strlen ( $str ) - $start - 1) );
//			$picSaveName = msubstr ( $info [$i] ['savename'], 0, 13 );

			//保存上传文件信息至DB
			//$info [$i] ['saveContent'] = "folder=" . $picPath . ",uid=" . $picSaveName . ",ext=" . $info [$i] ['extension'] . ",name=" . $info [$i] ['name'] . ",size=" . $info [$i] ['size'];
//			$info[$i]['saveContent']=C("IMG")."/".$picPath."/".$picSaveName.".".$info[$i]['extension'];

			$info[$i]['saveContent']=C("IMG")."/".$picPath."/".$info[$i]['savename'];
		}
		//print "real====".$info[0]['realsavepath'];
		return $info;
	}
}
/**
 *
 * 上传文件所在位置
 * @param string $msg
 * note:由于上传文件已存为绝对路径,此方法作废
 */
//function getFileUri($msg) {
//	if (null == $msg || "" == trim ( $msg )) {
//		return "";
//	}
//	$array = explode ( ",", $msg );
//	if (count ( $array ) > 1) {
//		$folder = msubstr ( $array [0], 7, strlen ( $array [0] ) );
//		return $folder;
//	} else {
//		return "";
//	}
//}

/**
 *
 * 上传文件保存后的名称
 * @param string $msg
 * note:由于上传文件已存为绝对路径,此方法作废
 */
//function getFileName($msg) {
//	if (null == $msg || "" == trim ( $msg )) {
//		return "";
//	}
//	$array = explode ( ",", $msg );
//	if (count ( $array ) > 1) {
//		
//		$uid = msubstr ( $array [1], 4, strlen ( $array [1] ) );
//		$ext = msubstr ( $array [2], 4, strlen ( $array [2] ) );
//		return $uid . "." . $ext;
//	} else {
//		return "";
//	}
//}
/**
 *
 * 上传文件保存后的后缀名
 * @param string $msg
 * note:由于上传文件已存为绝对路径,此方法作废
 */
//function getFileExt($msg) {
//	if (null == $msg || "" == trim ( $msg )) {
//		return "";
//	}
//	$array = explode ( ",", $msg );
//	if (count ( $array ) > 1) {
//		
//		$ext = msubstr ( $array [2], 4, strlen ( $array [2] ) );
//		return  $ext;
//	} else {
//		return "";
//	}
//}
/**
 *
 * 上传的文件的大小
 * @param string $msg 上传文件信息
 * note:由于上传文件已存为绝对路径,此方法作废
 */
//function getFileSize($msg){
//	if(null==$msg||""==trim($msg)){
//		return "";
//	}
//	$array = explode ( ",", $msg );
//	$size= msubstr ( $array [6], 5, strlen ( $array [6] ) );
//	return $size;
//}

/**
 *
 * 获取上传以前的文件名
 * @param string $msg
 * note:由于上传文件已存为绝对路径,此方法作废
 */
//function getFilePrevName($msg){
//	if(null==$msg||""==trim($msg)){
//		return "";
//	}
//	$array = explode ( ",", $msg );
//	$name= msubstr ( $array [3], 5, strlen ( $array [3] ) );
//	return $name;
//}
/**
 * 
 * $url http://img.local-dev.cn/Model/2013/07/17/51e64753c8568.jpg(13个数字)
 * @return Model/2013/07/17
 */
function getFileUri($url){
	$url=substr($url, 7);
	$index1=strpos($url, "/");
	$index2=strrpos($url, "/");
	return substr($url, $index1+1,$index2-$index1-1);
}
/**
 * 
 * $url http://img.local-dev.cn/Model/2013/07/17/51e64753c8568.jpg(13个数字)
 * @return 51e64753c8568.jpg
 */
function getFileName($url){
	$index=strrpos($url, "/");
	return substr($url, $index+1);
}
/**
 * 删除单个文件
 * $url http://img.local-dev.cn/Model/2013/07/17/51e64753c8568.jpg
 */
function delFile($url){
	$folder = getFileUri ( $url );
	$name = getFileName ( $url );
	$project=C('UPLOAD_PATH');
	$path = $project . "/" . $folder . "/" . $name;
	$path=mb_convert_encoding($path,"gbk","utf-8");
	unlink($path);
}
/**
 *
 * 批量删除文件
 * @param $files
 */
function delFiles($files) {
	if (! empty ( $files )) {
		foreach($files as $file){
			if(file_exists($file)){
				unlink($file);
			}
		}
	}
}

/**
 * 默认获取当前时间
 * 格式为：1970-01-01 11:30:45
 * $differ 单位秒，距离现在的时间，
 * 		        负数表示多少秒之前的时间
 * 		        正数表示多少秒之后的时间
 */
function getDatetime($differ=0) {
	//import ( "ORG.Util.Date" );
	//$date = new Date ();
	$format = "%Y-%m-%d %H:%M:%S";
	$date=time()+$differ;
	return strftime($format, $date);
	//return $date->format ( $format = "%Y-%m-%d %H:%M:%S" );
}
/**
 * 
 * 
 * @param string $date 2013-07-20 00:00:00
 * @return 2013/07/20
 */
function dateFormat($date){
	$arr=explode(" ", $date);
	$ret=preg_replace("/-/", "/", $arr[0]);
	return $ret;
}

function getMonth($date){
	$arr=explode(" ", $date);
	$arr1=explode("-", $arr[0]);
	$arr2=explode(":", $arr[1]);
	$time=mktime($arr2[0],$arr2[1],$arr2[2],$arr1[1],$arr1[2],$arr1[0]);
	$dateArr=getdate($time);
	return $dateArr['month'];
}

function getDay($date){
	$arr=explode(" ", $date);
	$arr1=explode("-", $arr[0]);
	$arr2=explode(":", $arr[1]);
	$time=mktime($arr2[0],$arr2[1],$arr2[2],$arr1[1],$arr1[2],$arr1[0]);
	$dateArr=getdate($time);
	return $dateArr['mday'];
}

/**
 *
 * 设置登陆用户的SESSION
 * @param $user
 */
function setLoginUser($user) {
	//用户登录
	Session::set ( "nick", $user ['nick'] );
	Session::set ( "uid", $user ['id'] );
}
/**
 * 
 * 获取登录用户的SESSION
 */
function getLoginUser(){
	$user['nick']=Session::get("nick");
	$user['uid']=Session::get("uid");
	if(empty($user['nick'])){
		return "";
	}
	return $user;
}
function getCookie($name){
	//return Cookie::get($name);
	return $_COOKIE['fc_'.$name];
}
function getLoginUserCookie(){
	$user['nick']=$_COOKIE['fc_nick'];
	$user['uid']=$_COOKIE['fc_uid'];
	$user['name']=$_COOKIE['fc_name'];
// 	$user['nick']=Cookie::get("nick");
// 	$user['uid']=Cookie::get("uid");
	if(empty($user['nick'])||empty($user['uid'])||empty($user['name'])){
		return "";
	}
	return $user;
}
/**
 * 
 * 清除登录用户信息
 */
function clearLoginUser(){
	if(Session::is_set('nick')){
		unset($_SESSION['nick']);
		unset($_SESSION['uid']);
		//unset($_SESSION['name']);//管理后台暂时不加入name
	}
}
function clearLoginUserCookie(){
	if(Cookie::is_set('nick')){
		Cookie::delete('nick');
		Cookie::delete('uid');
		Cookie::delete('name');
	}
}
/**
 * 
 * 获取上传文件后缀名
 */
function getUploadFileExt($msg){
	return strtolower(substr($msg, strrpos($msg, ".")+1));
}
/**
 * 
 * 获取可上传的图片类型
 */
function getImgExtArr(){
	return array("jpg", "gif", "png", "jpeg");
}
function getImgExtStr(){
	return ".jpg,.gif,.png,.jpeg";
}
/**
 * 
 * 使名字唯一
 * @param unknown_type $filename
 */
function uniqidFileName($filename){
	$ext=getUploadFileExt($filename);
	return uniqid().".".$ext;
}
?>