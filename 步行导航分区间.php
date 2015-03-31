<? php

$data = DQuery::input(array("date"=>0,"name"=>"moserver_phpui2"));
$queryData = $data -> select('getData');

function getData($fields) {
	$res = array();
	$res['distance'] = $fields[_LogFields]['p_route_first_distance'];
	$res['cuid']= $fields[_LogFields]['cuid'];
	$url = $fields[_LogFields]['url'];
    $url = urldecode($url);
    parse_str($url, $urlArr);  	
	$res['os']= $urlArr['os'];		
	
	if($res['distance'] < 50 ){
		$res['distance'] = '[0 , 50m)';}
	else if($res['distance'] >= 50 &&  $res['distance'] < 100){
		$res['distance'] = '[50m , 100m)';}
	else if($res['distance'] >= 100 &&  $res['distance'] < 3000){
		$res['distance'] = '[100m , 3km)';}
	else if($res['distance'] >= 3000 &&  $res['distance'] < 15000){
		$res['distance'] = '[3km , 15km)';}
	else if($res['distance'] >= 15000 &&  $res['distance'] < 30000){
		$res['distance'] = '[15km , 30km)';}
	else if($res['distance'] >= 30000){
		$res['distance'] = '[30km , )';}
		
	\Utils::trace($res);
     return $res;
			
}


$all_os = array(
    '1' => 'android',
    '2' => 'iphone'
);

foreach($all_os as $key => $value){
$queryData -> filter(array(array('os','match',"/^".$value."/i")))
    -> group('distance')
	-> each(
	         DQuery::count('distance', 'CountPerDistance'))
    -> select(array('distance','CountPerDistance'))  	
	-> outputAsFile($value.'_walkPlan_by_distance_search_pv',$value.'步行路线距离分区间检索pv');

$queryData -> filter(array(array('os','match',"/^".$value."/i")))
    -> group('distance')
	-> each(
	         DQuery::count('distance', 'CountPerDistance'),
	         DQuery::uniqCount('cuid', 'UniqCuidDistance'))
    -> select(array('distance','UniqCuidDistance'))  
	-> outputAsFile($value.'_walkPlan_by_distance_search_uv',$value.'步行路线距离分区间检索uv');
}	
	
	
	
//偏航

$data = DQuery::input(array("date"=>0,"name"=>"api_lighttpd_log"));
$queryData = $data -> select('getData');

function getData($fields) {
	$res = array();
	$res['from_navi'] = $fields[_UrlFields]['from_navi'];
	//$res['cuid'] = $fields[_UrlFields]['cuid'];
	$res['os'] = $fields[_UrlFields]['os'];
	$url = $fields[_UrlFields]['url'];
        $url = urldecode($url);
        parse_str($url, $urlArr);  	
       if (!isset($urlArr['appid']) && isset($urlArr['channel']) && !isset($urlArr['prod']) && isset($urlArr['resid']) && ($urlArr['resid'] == '01')){
        $res['cuid'] = @$urlArr['cuid'];
        \Utils::trace($res);
        return $res;    
	
}


$all_os = array(
    '1' => 'android',
    '2' => 'iphone'
);

foreach($all_os as $key => $value) {

$queryData -> filter(array(array('os','match',"/^".$value."/i"),	
	                   array('from_navi','==','1')))
	   -> count('*','c')
	   -> select(array('c'))
	   -> outputAsNumeric($value.'_walkPlan_from_navi_pv',$value.'偏航状态重新规划的量pv');

$queryData -> filter(array(array('os','match',"/^".$value."/i"),
	               array('from_navi','==','1')))
	   -> uniq('cuid')
	   -> count('*','c')
	   -> select(array('c'))
	   -> outputAsNumeric($value.'_walkPlan_from_navi_uv',$value.'偏航状态重新规划的量uv');
}	
	
	
	
	
	
?>
