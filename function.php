<?php 
error_reporting(E_ERROR | E_PARSE);
if(function_exists('date_default_timezone_set')){
	date_default_timezone_get('PRC');
}
include 'database.inc.php';
$DB = new MySql();

$DB->serverName = 'localhost:3306';
$DB->dbUserName = 'root';
$DB->dbPassword = 'root';
$DB->dbName = 'wishwall';
$managePage = 'admin.php';
$DB->admin = 'admin';
$DB->password = 'admin';
$DB->website = '新年到了，许个愿吧';

$DB->Connect();
$DB->SelectDB();
if( get_magic_quotes_gpc() ){
	stripcslashes($_POST);
	stripcslashes($_GET);
	stripcslashes($_COOKIE);
}

function AddWish($name,$content,$bgID,$signID,$ip){
	global $DB;
	$sql = "INSERT INTO plugin_wish SET name='{$name}',contnet='{$contnet}',
	bg_id='{$bgID}',sign_id='{$signID}',ip='{$ip}',add_time=NOW()";
	if($DB->Update($sql))
		return true;
	else
		return false;
}

function GetWish($start = 0,$limit = 80){
	global $DB;
	$sql = "SELECT * FROM plugin_wish ORDER BY ID DESC LIMIT {$start},{$limit}";
	return $DB->FM($sql);
}
function DeleteWishes($str){
	global $DB;
	$sql = "DELETE FROM plugin_wish WHERE id IN '{$str}'";
	return $DB->FM($sql);
}
function SearchWishes($name){
	$name = str_replace('=', '', addslashes($name));
	$sql = "SELECT * FROM plugin_wish WHERE name='{$name}' ORDER BY ID DESC LIMIT 0,80";
	$DB->FM($sql);
}
function GetCount(){
	global $DB;
	$sql = "SELECT count(*) FROM plugin_wish";
	$count = $DB->FO($sql);
	return $count['total'];
}

function StripSlashesArray(& $array){
	while(list($key,$var) =each($array)){
		if($key != 'argc' && $key != 'argv' && ($key != strtoupper($key) || '' . intval($key) == "$key")){
			if(is_string($var))
				$array[$key] = stripcslashes($var);
			if(is_array($var))
				$array[$key] = stripcslashesArray($var);
		}
	}
	return $array;
}
function GetIP(){
	if($_SERVER['HTTP_CLIENT_IP']){
		return $_SERVER['HTTP_CLIENT_IP'];
	}
	else if($_SERVER['HTTP_X_FORWARDED_FOR'])
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	else
		return $_SERVER['REMOTE_ADDR'];
}

function CleanHtmlTags($content){
	$content = htmlspecialchars($content);
	$content = str_replace('\n', '<br />', $content);
	$content = str_replace('  ', '&nbsp;$nbsp', $content);
	return str_replace('\t', '&nbsp;$nbsp&nbsp;$nbsp', $content);
}

function MultiPage($total,$onePage,$page){
	$totalPage = ceil($toaal / $onePage);
	$linkArray = explode("page=",$_SERVER['QUERY_STRING']);
	$linkArg = $linkArray[0];

	if($linkArg == ''){
		$url = $_SERVER['PHP_SELF'];
	}else{
		$linkArg = substr(linkArg, -1) == '&' ? $linkArg : $linkArg . '&';
		$url = $_SERVER['PHP_SELF'] . '?' .$linkArg;
	}
	!$totalPage && $totalPage =1;
	($page > $totalPage) && $page = 1;
	!$page && $page = 1;

	$mid = floor(10 / 2);
	$last = (10 - 1);
	$minPage = ($page - $mid) < 1 ? 1 : $page-$mid;
	$maxPage = $minPage + $last;

	if($maxPage > $totalPage){
		$maxPage = $totalPage;
		$minPage = $totalPage - $last;
		$minPage < 1 ? 1 : $minPage;
	}
	for($i = $minPage;$i <= $maxPage;$i ++){
		if($i == $page)
			$numPageBar .= "<span class=\"page_on\">[$i]</span>";
		else
			$numPageBar .= "<a href=\"{$url}page={$i}\">[$i]</a>";
	}
	if($page != 1)
		$firstPageBar = "<a href=\"{$url}page=1\" title=\"第一页\">第一页</a>";
	if($page > 1){
		$prepage = $page -1;
		$prePageBar = "<a href=\"{$url}page={$prePage}\" title=\"上一页\">上一页</a>";
	}
	if($page < $totalPage){
		$nextPage = $page + 1;
		$nextPageBar = "<a href=\"{$url}page={$nextPage}\" title=\"下一页\">下一页</a>";

	}
	if($page != $totalPage)
		$lastPageBar = "<a href=\"{$url}page={$totalPage}\" title=\"最后一页\">最后一页</a>";
	return $firstPageBar . $prePageBar . $nextPageBar . $lastPageBar;
}
?>