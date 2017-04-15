<?php
require_once (SCRIPTS_PATH . '/phpthumb/ThumbLib.inc.php');

/**
 *
 * @name My_File_Image
 * @property Tool for image
 * @example $uploadDir = ROOT_PATH.'/public/files';
 *          $thumbsDir = ROOT_PATH.'/public/files/thumbs';
 *          $options = array ('upload-dir' => $uploadDir, 'thumbs-dir' =>
 *          $thumbsDir, 'thumbs' => array (array ('width' => 200, 'height' =>
 *          200, 'type' => 'absolute', 'watermark' => false ), array ('width' =>
 *          400, 'height' => 400, 'type' => 'absolute', 'watermark' => false ),
 *          array ('width' => 600, 'height' => 600, 'type' => 'absolute',
 *          'watermark' => false ) ) );
 *          $test = new My_File_Image();
 *          $test->resizeImage('test.jpg',$options);
*/
class My_File_Image extends PhpThumbFactory {
	 
	/**
	 *
	 * @name resizeImage
	 * @property resize an image to multi thumbs
	 * @param
	 *           filename: name of image
	 * @param
	 *           options:
	 * @param
	 *           + upload-dir: path to image
	 * @param
	 *           + thumb-dir: path to thumbs
	 * @param
	 *           + thumbs: multi thumbs
	 *           (width,height,type(absolute|relative),watermark(true|false))
	 */
	public function resizeImage($filename, $options) {
		if (! empty ( $options ['thumbs'] )) {
			foreach ( $options ['thumbs'] as $k => $v ) {
				$target = $options ['upload-dir'] . '/' . $v ['width'] . 'x' . $v ['height'];
					
				if ($v ['type'] == 'absolute') {
					if(self::makeDir($target)){
						// Lay kich thuoc cua tam hinh duoc upload
						$imageSize = self::getImageDimensions ( $options ['upload-dir'] . '/' . $filename );
						 
						// Xac dinh kich thuoc theo tieu chuan
						$newSize = self::getStandardSize ( array ('width' => $v ['width'], 'height' => $v ['height'] ), $imageSize );
						 
						// Crop giua tam hinh theo kich thuoc moi
						$img = self::create ( $options ['upload-dir'] . '/' . $filename );
						$img->cropFromCenter ( $newSize ['width'], $newSize ['height'] );
						 
						// resize ve kich thuoc theo yeu cau
						$img->resize ( $v ['width'], $v ['height'] );
						 
						//$thumbname = substr_replace ( $filename, '_'.$v ['width'] . 'x' . $v ['height'], strlen ( $filename ) - 4, 0 );
						$img->save ( $target . '/' . $filename );
					}
				} else {
					if(self::makeDir($target)){
						// Crop giua tam hinh theo kich thuoc moi
						$img = self::create ( $options ['upload-dir'] . '/' . $filename );
						$img->resize ( $v ['width'], $v ['height'] );
						 
						//$thumbname = substr_replace ( $filename, '_'.$v ['width'] . 'x' . $v ['height'], strlen ( $filename ) - 4, 0 );
						$img->save ( $target . '/' . $filename );
					}
				}
			}
		}
	}
	 
	/**
	 *
	 * @name getImageDimensions
	 * @property Lay thong tin kich thuoc hinh anh
	 * @param
	 *           image path $imgUrl
	 * @return array(width, height);
	 */
	private function getImageDimensions($imgUrl) {
		list ( $width, $height ) = @getimagesize ( $imgUrl );
		return array ('width' => $width, 'height' => $height );
	}
	 
	/**
	 *
	 * @name getStandardSize
	 * @property Tinh toan kich thuoc hinh anh dat tieu chuan khi resize tam
	 *           hinh theo lua chon absolute
	 * @param
	 *           kich thuoc tieu chuan array(width, height) $standardSize
	 * @param
	 *           kich thuoc cua tan hinh hien tai array(width, height)
	 *           $currentSize
	 */
	private function getStandardSize($standardSize, $currentSize) {
		$x1 = $standardSize ['width'] / $standardSize ['height'];
		$x2 = $currentSize ['width'] / $currentSize ['height'];

		/**
		 * TH1: neu x1 lon hon x2
		 * vd:
		 * standardWidth = 110, standardHeight = 220
		 * currentWidth = 200, currentHeight = 800,
		 * => Kich thuoc uoc doan la currentWidth = 200, currentHeight = 400
		 * => currentHeight phai dc xac dinh lai
		 *
		 * x1 = 110/220 = 0.5
		 * x2 = 200/800 = 0.25
		 * => currentHeight = (currentWidth*standardHeight)/standardWidth
		 */
		if ($x1 > $x2) {
			$x = ($currentSize ['width'] * $standardSize ['height']) / $standardSize ['width'];
			return array ('width' => $currentSize ['width'], 'height' => $x );
		} /**
		* TH1: neu x1 == x2
		* vd:
		* standardWidth = 110, standardHeight = 220
		* currentWidth = 200, currentHeight = 400
		* => Voi ti le ngang bang nhau thi khong phai tinh toan
		*/
		elseif ($x1 == $x2) {
			return $currentSize;
		} /**
		* TH1: neu x1 nho hon x2
		* vd:
		* standardWidth = 110, standardHeight = 220
		* currentWidth = 800, currentHeight = 200
		* => Kich thuoc uoc doan la currentWidth = 400, currentHeight = 200
		* => currentWidth phai dc xac dinh lai
		*
		* x1 = 110/220 = 0.5
		* x2 = 800/200 = 4
		* => currentWidth = (currentHeight*standardWidth)/standardHeight
		*/
		else {
			$x = ($currentSize ['height'] * $standardSize ['width']) / $standardSize ['height'];
			return array ('width' => $x, 'height' => $currentSize ['height'] );
		}
	}
	
	private function makeDir($target) {
		// from php.net/mkdir user contributed notes
		$target = str_replace( '//', '/', $target );
		if ( file_exists( $target ) )
			return @is_dir( $target );
	
		// Attempting to create the directory may clutter up our display.
		if ( @mkdir( $target ) ) {
			$stat = @stat( dirname( $target ) );
			$dir_perms = $stat['mode'] & 0007777;  // Get the permission bits.
			@chmod( $target, $dir_perms );
			return true;
		} elseif ( is_dir( dirname( $target ) ) ) {
			return false;
		}
	
		// If the above failed, attempt to create the parent node, then try again.
		if ( ( $target != '/' ) && ( self::makeDir( dirname( $target ) ) ) )
			return self::makeDir( $target );
	
		return false;
	}
	
	public static function getThumbs($path){
		$image = $path;
		$info = getimagesize($image);
		 
		header("Content-type: ".$info['mime']) ;
		echo file_get_contents($image);
		exit(0);
	}
}