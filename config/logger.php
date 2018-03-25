<?php
 class SMSLogger{


 	public function log($logLevel,$msg){

 		if(!empty($msg)){

 			$prefixString = date("Y-m-d H:i:s")." :: ".strtoupper($logLevel);

 			$file = dirname(__FILE__).'/logger.txt';

 			$content = $prefixString."::".$msg;

 			if(file_put_contents($file, $content,FILE_APPEND)){
 				return true;
 			}	

 		}

 	}
 }


 $logger = new SMSLogger();
?>