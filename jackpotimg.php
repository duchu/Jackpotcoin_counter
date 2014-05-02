<?php
	// Set the content-type
	header('Content-Type: image/png');

        $request_array["method"] = "getcurrentjackpot";

        $request = json_encode ($request_array);

	$coind = curl_init();

	curl_setopt($coind, CURLOPT_URL,  "127.0.0.1");
	curl_setopt($coind, CURLOPT_PORT, "15372");
	curl_setopt($coind, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($coind, CURLOPT_USERPWD, "user:pass");
	curl_setopt($coind, CURLOPT_HTTPHEADER, array ("Content-type: application/json"));
	curl_setopt($coind, CURLOPT_POST, TRUE);
	curl_setopt($coind, CURLOPT_POSTFIELDS, $request); 
	curl_setopt($coind, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($coind, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($coind, CURLOPT_SSL_VERIFYHOST, FALSE);

	$response_data = curl_exec($coind);

	curl_close($coind);

	$info = json_decode ($response_data, TRUE);
		
	if (isset($info["error"]) || $info["error"] != "") {
	   $result = $info["error"]["message"]."(Error Code: ".$info["error"]["code"].")";
                  echo "<pre> Error =  $result </pre>";
	}
	else {
			$result = $info["result"];
   
		         // Create the image
			/*$im = imagecreatetruecolor(1000, 159);

			// Create some colors
			$white   = imagecolorallocate($im, 255, 255, 255);
			$yellow = imagecolorallocate($im, 255, 255, 39);
			$black   = imagecolorallocate($im, 0, 0, 0);
			imagefilledrectangle($im, 0, 0, 9999, 159, $black);
			*/
			$im = imagecreatetruecolor(520, 99);

			// Create some colors
			$white   = imagecolorallocate($im, 255, 255, 255);
			$yellow = imagecolorallocate($im, 255, 255, 39);
			$black   = imagecolorallocate($im, 0, 0, 0);
			imagefilledrectangle($im, 0, 0, 1000, 159, $black);


			// The text to draw
			$text = $result;
			$len  = strlen($result);
			for($i = 0; $i < (9 - $len); $i++) $text="0".$text;

			// Replace path by your own font path
			$font = '/var/www/matrix.ttf';

			// Add some shadow to the text
			//imagettftext($im, 20, 0, 11, 21, $grey, $font, $text);

			// Add the text
			imagettftext($im, 60, 0, 11, 80, $yellow, $font, $text);

			// Using imagepng() results in clearer text compared with imagejpeg()
			imagepng($im);
			imagedestroy($im);

	}

?>