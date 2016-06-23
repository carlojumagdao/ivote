<?php

namespace App;

 class SmartCounter {

	public function smartcounter($strLatestCode){
		if(empty($strLatestCode) || $strLatestCode == " "){
			return "CODE001";
		}
		$chNumValue = str_split($strLatestCode);
		$intStrLength = strlen($strLatestCode);
		$blnProof = 0;

		try {
			for($intCounter = $intStrLength-1; $intCounter > -1; $intCounter--){
				if(is_numeric($chNumValue[$intCounter]) && $chNumValue[$intCounter] != '9'){
					$chNumValue[$intCounter]++;
					$blnProof = 1;
					break;
				} elseif (is_numeric($chNumValue[$intCounter])) {
					$chNumValue[$intCounter] = '0';
				} elseif (!(is_numeric($chNumValue[$intCounter])) && $blnProof == 1) {
					break;
			}
		}
		$strNewCode = implode("", $chNumValue);	
		} catch (Exception $e) {
			echo "ERROR:". $e.getMessage();
		}
		if($strLatestCode == $strNewCode){
			$strNewCode = $strNewCode."0";
		}
		return $strNewCode;
	}
}