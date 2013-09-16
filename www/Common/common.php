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
 * 上传文件所在位置
 * @param string $msg
 */
function getFileUri($msg) {
	if (null == $msg || "" == trim ( $msg )) {
		return "";
	}
	$array = explode ( ",", $msg );
	if (count ( $array ) > 1) {
		$folder = msubstr ( $array [0], 7, strlen ( $array [0] ) );
		return $folder;
	} else {
		return "";
	}
}

/**
 *
 * 上传文件保存后的名称
 * @param string $msg
 */
function getFileName($msg) {
	if (null == $msg || "" == trim ( $msg )) {
		return "";
	}
	$array = explode ( ",", $msg );
	if (count ( $array ) > 1) {
		
		$uid = msubstr ( $array [1], 4, strlen ( $array [1] ) );
		$ext = msubstr ( $array [2], 4, strlen ( $array [2] ) );
		return $uid . "." . $ext;
	} else {
		return "";
	}
}
/**
 *
 * 上传文件保存后的后缀名
 * @param string $msg
 */
function getFileExt($msg) {
	if (null == $msg || "" == trim ( $msg )) {
		return "";
	}
	$array = explode ( ",", $msg );
	if (count ( $array ) > 1) {
		
		$ext = msubstr ( $array [2], 4, strlen ( $array [2] ) );
		return  $ext;
	} else {
		return "";
	}
}
/**
 *
 * 上传的文件的大小
 * @param string $msg 上传文件信息
 */
function getFileSize($msg){
	if(null==$msg||""==trim($msg)){
		return "";
	}
	$array = explode ( ",", $msg );
	$size= msubstr ( $array [6], 5, strlen ( $array [6] ) );
	return $size;
}

/**
 *
 * 获取上传以前的文件名
 * @param string $msg
 */
function getFilePrevName($msg){
	if(null==$msg||""==trim($msg)){
		return "";
	}
	$array = explode ( ",", $msg );
	$name= msubstr ( $array [3], 5, strlen ( $array [3] ) );
	return $name;
}
/**
 * 删除单个文件
 */
function delFile($msg){
	$folder = getFileUri ( $msg );
	$name = getFileName ( $msg );
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
	$format = "%Y-%m-%d %H:%M:%S";
	$date=time()+$differ;
	return strftime($format, $date);
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
 * 设置登录用户信息
 * @param unknown_type $user
 */
function setLoginMsg($user){
	foreach ($user as $key => $value){
		Cookie::set($key, $value);
	}
}
/**
 * 
 * 获取登录用户信息
 * @return array
 */
function getLoginMsg(){
	$user['name']=Cookie::get("name");
	$user['email']=Cookie::get("email");
	$user['nickname']=Cookie::get("nickname");
	if(empty($user['name'])||empty($user['email'])||empty($user['nickname'])){
		return "";
	}
	return $user;
}
/**
 * 
 * 清除登录用户信息
 */
function clearLoginMsg(){
	if(Cookie::is_set('name')){
		Cookie::delete('name');
		Cookie::delete('email');
		Cookie::delete('nickname');
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