<?php 
class OoyalaAPI{
	
	public function generateURL($HTTP_method, $api_key, $secret_key, $expires, $request_path, $request_body = "", $parameters=array())
	{
		$parameters["api_key"] = $api_key;
		$parameters["expires"] = $expires;
		$signature = $this->generateSignature($HTTP_method, $secret_key, $request_path, $parameters, $request_body);
		$base = "https://api.ooyala.com";
		$url = $base.$request_path."?";
		foreach ($parameters as $key => $value) {
			$url .=  $key . "=" . urlencode($value) . "&";
		}
		$url .= "signature=" . $signature;
		return $url;
	}

	
	private function generateSignature($HTTP_method, $secret_key, $request_path, $parameters, $request_body = "")
	{
		$to_sign = $secret_key . $HTTP_method . $request_path;
		$keys = $this->sortKeys($parameters);
		foreach ($keys as $key) {
			$to_sign .= $key . "=" . $parameters[$key];
		}
		$to_sign .= $request_body;
		$hash = hash("sha256", $to_sign,true);
		$base = base64_encode($hash);
		$base = substr($base,0,43);
		$base = urlencode($base);
		return $base;

	}

	private function sortKeys($array)
	{
		$keys = array();$ind=0;
		foreach ($array as $key => $val) {
			$keys[$ind++]=$key;
		}
		sort($keys);
		return $keys;
	}
}
?>