<?php 
// // header('Content-type:text/html;charsrt=utf-8');
// $html = file_get_contents("./15052011.docx");
// print_r(utf8_encode($html));
// // print_r( $http_response_header );



function simplexml_obj2array($obj){
	if(count($obj) >= 1){
		$result = $keys = array();
		foreach ($obj as $key => $value) {
			isset($keys[$key]) ? ($keys[$key] += 1) : ($keys[$key]);
			if($keys[$key] == 1)
				$result[$key] = simplexml_obj2array($value);
			else if($keys[$key] == 2)
				$result[$key] = array($result[$key], simplexml_obj2array($value));
			if($keys[$key] > 2)
				$result[$key][] = simplexml_obj2array($value);

		}
	}else if(count($obj) == 0){
		return (string)$obj;
	}
}

echo "<pre>";
if(file_exists(file_get_contents("http://www.w3school.com.cn/example/xdom/books.xml")))
	echo "12";
	$obj = simplexml_load_file(file_get_contents("http://www.w3school.com.cn/example/xdom/books.xml"));
print_r(simplexml_obj2array($obj));
echo "</pre>";
?>