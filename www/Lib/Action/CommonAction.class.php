<?php
	class CommonAction extends Action{
		//默认值
		protected $default=array(
			'subDir'=>"default",//子目录
			'maxSize'=>31457280,//允许上传文件的最大限制
			'type'=>array ('jpg', 'gif', 'png', 'jpeg' ),//允许上传文件类型
			'thumb'=>false,//是否生成缩略图
			'thumbWidth'=>"40,80,200",//缩略图的宽
			'thumbHeight'=>"40,80,200",//缩略图的高	
			
			'domain'=>""//当前访问的域名
		);
		
		protected $loginUser=null;
		
		public function __construct(){
			parent::__construct();
			$this->setDefault("domain", "http://".$_SERVER['HTTP_HOST']);
			$this->loginUser=getLoginMsg();
			if(!empty($this->loginUser)){
				$this->assign("loginUser",$this->loginUser);
			}
		}
		public function setDefault($key,$value){
			$this->default[$key]=$value;
		}
		
		public function displayErrorPage($message){
			redirect($this->default['domain']."/error?message=".urlencode($message));
		}
		
		public function displaySuccessPage($message,$href){
			redirect($this->default['domain']."/success?message=".urlencode($message)."&href=".urlencode($href));
		}
		
		public function displayLoginPage($callback){
			$url=$this->default['domain']."/User/login";
			if(!empty($callback)){
				$url.="?callback=".urlencode($callback);
			}
			redirect($url);
		}
		/**
		 * 
		 * 下载文件
		 */
		public function readFile(){
			$file=$_GET['file'];
			if(empty($file)){
				$this->displayErrorPage("文件名不能为空！");
			}
			$file=C("UPLOAD_PATH")."/".$file;
			$file=mb_convert_encoding($file,"gbk","utf-8");
			if (file_exists($file)) {
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename='.basename($file));
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    ob_clean();
			    flush();
			    readfile($file);
			}else{
				$this->displayErrorPage("文件不存在！");
			}
		}
		/**
		 *
		 * 文件上传
		 * @param array $options 参考$this->default
		 */
		public function saveFile($options) {
			import ( "ORG.Net.UploadFile" );
			$upload = new UploadFile (); // 实例化上传类
				
			//赋值
			!isset($options['subDir']) && $options['subDir']=$this->default['subDir'];
			!isset($options['maxSize']) && $options['maxSize']=$this->default['maxSize'];
			!isset($options['type']) && $options['type']=$this->default['type'];
			//缩略图设置
			!isset($options['thumb']) && $options['thumb']=$this->default['thumb'];
			if($options['thumb']){
				!isset($options['thumbWidth']) && $options['thumbWidth']=$this->default['thumbWidth'];
				!isset($options['thumbHeight']) && $options['thumbHeight']=$this->default['thumbHeight'];
				$upload->thumb = $options['thumb'];
				$upload->thumbMaxWidth = $options['thumbWidth'];
				$upload->thumbMaxHeight = $options['thumbHeight'];
				$thumbWidths=explode(",", $options['thumbWidth']);
				$thumbHeights=explode(",", $options['thumbHeight']);
				if(count($thumbWidths)!==count($thumbHeights)){
					echo "缩略图的长宽个数不一样！";
					return false;
				}
				$upload->thumbPrefix = "";
				for($i=0;$i<count($thumbWidths);$i++){
					$upload->thumbPrefix .= ",thumb_".$thumbWidths[$i]."X".$thumbHeights[$i]."_";
				}
				$upload->thumbPrefix = substr($upload->thumbPrefix, 1);
			}
				
			$upload->maxSize = $options['maxSize']; // 设置附件上传大小
			$upload->allowExts = $options['type']; // 设置附件上传类型
				
			$date = date ( "Y/m/d" );
			$upload->savePath = C ( 'UPLOAD_PATH' ) . '/' . $options['subDir'] . '/' . $date . '/'; // 设置附件上传目录
				
			if(!is_dir($upload->savePath)){
				mkdir ( $upload->savePath ,0777,true); //创建目录
			}
			$upload->saveRule = "uniqid"; //文件名生成规则
		
				
			if (! $upload->upload ()) { // 上传错误提示错误信息
				$msg=$upload->getErrorMsg();
				//echo mb_detect_encoding($msg);
				$msg=mb_convert_encoding($msg, "gbk","utf-8");
				echo $msg;
				return false;
			} else { // 上传成功获取上传文件信息
				$info = $upload->getUploadFileInfo ();
		
				$start = strlen ( C ( 'UPLOAD_PATH' ) ) + 1;
				for($i = 0; $i < count ( $info ); $i ++) {
					$str = $info [$i] ['savepath'];
					$picPath = msubstr ( $str, $start, (strlen ( $str ) - $start - 1) );
					$picSaveName = msubstr ( $info [$i] ['savename'], 0, 13 );
		
					//保存上传文件信息至DB
					$info [$i] ['saveContent'] = "folder=" . $picPath . ",uid=" . $picSaveName . ",ext=" . $info [$i] ['extension'] . ",name=" . $info [$i] ['name'] . ",size=" . $info [$i] ['size'];
				}
				return $info;
			}
		}
	}
?>