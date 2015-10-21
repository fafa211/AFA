<?php
/**
 * 图片处理类
 * /********************* Image类使用注释
 * 用法
 *   $image = new Image();
 *   $image->ResizeImage("F:/picture/1.jpg");
 *
 * @author     alfa
 * @version    1.0
 */

class image
{
	/**
	 * 图片宽度
	 */
	private $bigWidth;
	
	/**
	 * 图片高度
	 */
	private $bigHeight;
	
	/**
	 * 是否由宽度决定缩放
	 */
	private $isOnlyWidth = true;
	
	/**
	 * 大图地址
	 */
	private $bgImageUrl;
	
	private function __construct($width, $height, $isOnlyWidth)
	{
		$this->bigWidth = $width;
		$this->bigHeight = $height;
		$this->isOnlyWidth = $isOnlyWidth;
	}
	
	/**
	  * 创建对象
	  */
	 public static function instance($width = 100, $height = 100, $isOnlyWidth = true){
	 	return new image($width, $height, $isOnlyWidth);
	 }
	
	/**
	 * 缩放图片
	 *
	 * @param upload file $file
	 * @return unknown
	 */
	public function resizeImage($file)
	{
		$tmpImageInfo = @getimagesize($file);
		$W = $tmpImageInfo[0];
		$H = $tmpImageInfo[1];

		if ($this->bigWidth >= $W) {
		    return true;
		}
		
		$resizedW = $this->bigWidth;
		$resizedH = $H/$W*$resizedW;
		if ($resizedH > $this->bigHeight && !$this->isOnlyWidth)
		{
			$resizedH = $this->bigHeight;
			$resizedW = $W/$H*$resizedH;
		}
		$this->resize($file, $resizedW, $resizedH, $file);
	}
	
	/**
	 * 缩放图片
	 * @param string $imagePath 需缩放图片路径
	 * @param string $width 要求缩放的宽度
	 * @param string $height 要求缩放的告诉
	 * @param string $destPath 缩放后的图片路径
	 * @return boolean 
	 */
	public function resize($imagePath, $width, $height, $destPath)
	{
		
		$tmpImageInfo = @getimagesize($imagePath);
		switch ($tmpImageInfo[2]) {
			case 1:
			//return true;
			$im = @ImageCreateFromGIF($imagePath);
			break;
			case 2:
			$im = @ImageCreateFromJPEG($imagePath);
			break;
			case 3:
			$im = @ImageCreateFromPNG($imagePath);
			break;
		}
		if (@function_exists("ImageCreateTruecolor"))
		{
			$ni =@ImageCreateTruecolor($width,$height);
		}
		else{
			$ni =@ImageCreate($width,$height);
		}
		if (function_exists("imagecopyresampled")){
			@imagecopyresampled($ni, $im, 0, 0, 0, 0, $width, $height, $tmpImageInfo[0], $tmpImageInfo[1]);
		} else	{
			@ImageCopyResized ($ni, $im, 0, 0, 0, 0, $width, $height, $tmpImageInfo[0], $tmpImageInfo[1]);
		}
		if(!@imagejpeg($ni,$destPath)) {
			return false;
		}
		@ImageDestroy ($ni);
		@ImageDestroy ($im);
		return true;
	}
	
	/**
	 * 新建指定大小的图片
	 * @param string $w 图片width
	 * @param string $h 图片height
	 * @param string $dstPath 图片路径
	 */
	public function createImage($w, $h, $dstPath)
	{
		$d_im = imagecreate($w, $h);
		@imagecolorallocate($d_im , 255 , 255 , 255);
		@imagejpeg($d_im, $dstPath);
		@ImageDestroy($d_im);
	}
	
	/**
	 * 把图片$imageUrl，$bgPicPath粘合，该系统目的是把缩小的图片放置到指定大小的背景图片上。
	 * @param string $imageUrl 
	 * @param string $destPath
	 * @param string $bgPicPath
	 * @return  boolean 
	 */
	public function combineImage($imageUrl, $destPath, $bgPicPath)
	{
		$s_imageInfo = @getimagesize($imageUrl);
		switch ($s_imageInfo[2]) 
		{
			case 1:
			$s_im = @ImageCreateFromGIF($imageUrl);
			break;
			case 2:
			$s_im = @ImageCreateFromJPEG($imageUrl);
			break;
			case 3:
			$s_im = @ImageCreateFromPNG($imageUrl);
			break;
		}
		$s_im_w = $s_imageInfo[0];
		$s_im_h = $s_imageInfo[1];
		$b_imageInfo = @getimagesize($bgPicPath);
		$w = $b_imageInfo[0];
		$h = $b_imageInfo[1];
		$d_im = @ImageCreateFromJPEG($bgPicPath);
		$d_im_x_pos = ($w-$s_im_w)/2;
		$d_im_y_pos	= ($h-$s_im_h)/2;
		$bgcolor = @imagecolorallocate($d_im ,100 , 100 , 100);
		@imagecopy($d_im, $s_im, $d_im_x_pos, $d_im_y_pos, 0, 0, $s_im_w, $s_im_h);
		@ImageDestroy($s_im);
		if (@imagejpeg($d_im, $destPath))
		{
			@ImageDestroy($d_im);
			return true;
		}		
		@ImageDestroy($d_im);
		return false;
	}
	
	/**
	 * 自动读取
	 */
	public function __get($name){
		if (isset($this->$name)) return $name;
	}
	
	/**
	 * 自动调用
	 */
	public function __call($name, $args = null){
		return $this->__get($name);
	}
	
}