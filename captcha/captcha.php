<?php /*alternative captcha class  firepages.com.au*/
DEFINE('CAPTCHA_TIMEOUT',3600);//an hour, way too much ?
DEFINE('CIF','jpg');                            //CaptchaImageFormat
DEFINE('CIM','image/jpeg');               //                     MimeType
DEFINE('CONVERT','convert');           //Path to imagemagick convert library

class captcha{
	var $search = array('{Q_WHAT}','{Q_WHAT_IMG}','{Q_INAME}');
	var $im_num;   #how many images to use from repository
	var $complex;  #how many images to show altogether
	var $img_path; #path to image repository

	function captcha($img_path,$im_num=3,$complex=6,$num_questions=3){
		$ims=glob("$img_path/*.".CIF);
		$x=0;while($x<$im_num){
			$this->ims[]=$ims[$x];++$x;
		}
		$this->complex=$complex;
		$this->im_num=$im_num;
		$this->img_path=$img_path;
		$this->num_questions=$num_questions;
		/*image path relative to calling HTML*/
		$this->rel = str_replace(array(getcwd(),basename(__FILE__)),'',__FILE__);
	}

	function set_session($hash,$answers){
		unset($_SESSION['fpa_captcha']);
		$_SESSION['fpa_captcha']['start'] = mktime();
		$_SESSION['fpa_captcha']['hash'] = $hash;
		$_SESSION['fpa_captcha']['a'] = $answers;
		$_SESSION['fpa_captcha']['CIF']=CIF;
		$_SESSION['fpa_captcha']['CIM']=CIM;
	}

	function start_captcha(){
		$ims_used=array();$x=0;$a=array();
		while($x < $this->complex){
			$r=rand(0,($this->im_num-1));
			array_push($ims_used,str_replace('.'.CIF,'',basename($this->ims[$r])));
			@$a[str_replace('.'.CIF,'',basename($this->ims[$r]))]++;
			$str[] = $this->ims[$r];
			++$x;
		}
		$ims_used=array_unique($ims_used);
		shuffle($ims_used);
		$this->ims_used = $ims_used;
		$str = implode(' ',$str);
		$hash = MD5($str);
		$this->set_session($hash,$a);
		exec(CONVERT." $str  +append {$this->img_path}/out/{$hash}.".CIF);
		return '<img src=".'.$this->rel.'out.php?r='.mktime().'" />';
	}

	function get_questions($format=''){
		$format = empty($format) ? #default format if not passed
			'How many {Q_WHAT}\'s ? &nbsp; <input type="text" name="{Q_INAME}" value="" /><br />' : 
			$format ;
		$arr=array_slice($this->ims_used,0,$this->num_questions);
		foreach($arr as $im){
			$replace['{Q_WHAT}']=$im;
			$replace['{Q_WHAT_IMG}']='.'.$this->rel.$im.'.'.CIF;
			$replace['{Q_INAME}']=MD5($_SESSION['fpa_captcha']['hash'].$im);
			$str[] = str_replace($this->search,$replace,$format);
			$_SESSION['fpa_captcha']['q'][]=$im;
		}
		return implode("\n",$str);
	}

/*
optional call to keep your code neat, wraps start_captcha and get_questions according to $format
$format must include {IMG} and {QUESTIONS} replacers !!
*/
	function get_captcha($format="{IMG}<br />\n{QUESTIONS}", $q_format=''){
		return str_replace(
			array('{IMG}','{QUESTIONS}'),
			array($this->start_captcha(),$this->get_questions($q_format)),
			$format
		);
	}

/*validation can be static & MUST be called before start_captcha() if form is posting to itself !!*/
	function validate($req){
		$time=mktime();$valtime = $_SESSION['fpa_captcha']['start'];
		if(empty($_SESSION['fpa_captcha']) || (($time - $valtime) > CAPTCHA_TIMEOUT)){
			return false;
		}
		foreach($_SESSION['fpa_captcha']['q'] as $q){
			if( $req[MD5($_SESSION['fpa_captcha']['hash'].$q)] != $_SESSION['fpa_captcha']['a'][$q] ){
				return false;
			}
		}
		return true;
	}
}
?>
