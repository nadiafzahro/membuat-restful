<?php
	function get_web_page($url) {
		$options = [
			CURLOPT_CUSTOMREQUEST =>"GET", // atur type request
			CURLOPT_RETURNTRANSFER => 1
		];
		$ch = curl_init($url);
		if ($ch === false){
			return "error : ".curl_error($ch);
		}else{
			curl_setopt_array( $ch, $options);
			$data["content"] = curl_exec( $ch );
			$data["info"]=curl_getinfo($ch);
			curl_close($ch);
			return $data;
		}
	}
	$data= get_web_page("http://localhost/12161528/produk_json.php");
	$response = json_decode($data["content"],false);
	echo "<pre>";print_r($response);
	?>