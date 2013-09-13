<?php
	class CommonAction extends Action{
		public function displayErrorPage($message,$domain){
			if(empty($domain)){
				$domain=C("WWW");
			}
			redirect($domain."/error?message=".urlencode($message));
		}
		public function displaySuccessPage($message,$href,$domain){
			if(empty($domain)){
				$domain=C("WWW");
			}
			redirect($domain."/success?message=".urlencode($message)."&href=".urlencode($href));
		}
		public function displayLoginPage($callback,$domain){
			if(!isset($domain) || empty($domain)){
				$domain=C("WWW");
			} 
			$url=$domain."/User/login";
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
			$domain=C("WWW");
			if(!empty($_SERVER['HTTP_REFERER'])){//为了区别错误页面
				$domain=substr($_SERVER['HTTP_REFERER'],0,strpos($_SERVER['HTTP_REFERER'], "/",7));
			}
			$file=$_GET['file'];
			if(empty($file)){
				$this->displayErrorPage("文件名不能为空！",$domain);
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
				$this->displayErrorPage("文件不存在！",$domain);
			}
		}
	}
?>