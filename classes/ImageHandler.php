<?php
	/**
	 * 下面是图片处理类，用来处理上传的图片
	 * 原本上传图片也可以算是User功能的一种，但是为了方便代码复用，这里抽象出ImageHandler进行处理
	 */
	class ImageHandler{
		/**
		 * 下面的程序将在富文本编辑器中加入的图片上传到服务器的文件夹中
		 */
		function uploadImage(){
			$fileName=$_FILES['file']['tmp_name']??"";
			$realName=$_FILES['file']['name']??"";
			$newPath="../UploadImages/".$realName;			
			if(is_uploaded_file($fileName)){							
				move_uploaded_file($fileName, $newPath);				
			}
			//返回的地址是html页面对应的地址
			return $newPath;
		}
		
	}
	
	$imageHandler=new ImageHandler();
	echo $imageHandler->uploadImage();
	//print_r($_FILES['file']);
?>