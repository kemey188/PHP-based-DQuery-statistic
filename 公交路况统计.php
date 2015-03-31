<? php

$data = DQuery::input(array("date"=>0,"name"=>"moserver_phpui2"));
$queryData = $data -> select('getData');

function getData($fields) {
		
	$res = array();
	
	$res['qt'] = $fields['_LogFields']['q_qt'];	
	$time = $fields['_LogFields']['optime'];
	$time = date('H:i:s',$time);
  $res['ctNum'] = $fields['_LogFields']['p_traffic_type_10'];	
	$res['hxNum'] = $fields['_LogFields']['p_traffic_type_20'];
	$res['ydNum'] = $fields['_LogFields']['p_traffic_type_30'];
	$res['showNum'] = $fields['_LogFields']['p_bus_legs_num'];
	$res['tagStatus'] ="";
	$res['nonTagNum'] ="";
 //	$res['cityid'] = $fields['_LogFields']['p_res_cc'];
	$res['cuid']= $fields['_LogFields']['cuid'];
	$url = $fields['_LogFields']['url'];
    $url = urldecode($url);
    parse_str($url, $urlArr);  	
	$res['os']= $urlArr['os'];		

	if ( $time >= '07:00:00' &&  $time <= '09:00:00'){
        $res['time'] = "morningPeak";}
    else if ( $time >= '17:00:00' &&  $time <= '20:00:00'){
        $res['time'] = "afternoonPeak";}
    else {
        $res['time'] = "normal";}
		

	if (($res['ctNum'] > 0 ) || ($res['ydNum'] > 0) || ($res['hxNum'] > 0)){

		   if (($res['ctNum'] + $res['ydNum'] + $res['hxNum']) == $res['showNum']){	   
		   
			   if ($res['hxNum'] == $res['showNum']){
				   $res['tagStatus'] = "hx_all";}	  
			   else if ($res['ydNum'] == $res['showNum']){
				   $res['tagStatus'] = "yd_all";}	   
			   else{
				   $res['tagStatus'] = "tag_all"; } 
		   }
		   
		   else{
			   $res['tagStatus'] = "exist_tag"; }
		} 
	else{  $res['tagStatus'] = "none" ;} 
		   
	$res['nonTagNum'] = ($res['showNum'] -  ($res['ctNum'] + $res['ydNum'] + $res['hxNum']));	
		
	
    \Utils::trace($res);
	return $res;
	
}	

//android pv
$queryData
    ->filter(array(array('qt','match','/^(bt|bus|bse)$/i'),array('tagStatus','==','tag_all')))
	->filter(array('os','match','/android/i'))
    ->select(array('time'))
    ->group('time')
	->countEach('*','count')
	->outputAsFile('android_bus_roadStatus_tag_all_pv','android公交路况检索结果全有标签pv');

$queryData
    ->filter(array(array('qt','match','/^(bt|bus|bse)$/i'),array('tagStatus','==','hx_all')))
	->filter(array('os','match','/android/i'))
    ->select(array('time'))
    ->group('time')
	->countEach('*','count')
	->outputAsFile('android_bus_roadStatus_hx_all_pv','android公交路况检索结果全有[缓行]标签pv');
	
$queryData
    ->filter(array(array('qt','match','/^(bt|bus|bse)$/i'),array('tagStatus','==','yd_all')))
	->filter(array('os','match','/android/i'))
    ->select(array('time'))
    ->group('time')
	->countEach('*','count')
	->outputAsFile('android_bus_roadStatus_yd_all_pv','android公交路况检索结果全有[拥堵]标签pv');

$queryData
    ->filter(array(array('qt','match','/^(bt|bus|bse)$/i'),array('tagStatus','==','exist_tag')))
	->filter(array('os','match','/android/i'))
    ->select(array('time'))
    ->group('time')
	->countEach('*','count')
	->outputAsFile('android_bus_roadStatus_exist_tag_pv','android公交路况检索结果有标签pv');	

$queryData
    ->filter(array('qt','match','/^(bt|bus|bse)$/i'))
	->filter(array('os','match','/android/i'))
    ->select(array('time','nonTagNum'))
    ->group('time')
	->sumEach('nonTagNum','sum')
	    ->select(array('time','sum'))
	->outputAsFile('android_bus_roadStatus_non_tag_num','android公交路况检索结果没有标签条数');		
	
			
//ios pv	
$queryData
    ->filter(array(array('qt','match','/^(bt|bus|bse)$/i'),array('tagStatus','==','tag_all')))
	->filter(array('os','match','/iphone/i'))
    ->select(array('time'))
    ->group('time')
	->countEach('*','count')
	->outputAsFile('iphone_bus_roadStatus_tag_all_pv','iphone公交路况检索结果全有标签pv');

$queryData
    ->filter(array(array('qt','match','/^(bt|bus|bse)$/i'),array('tagStatus','==','hx_all')))
	->filter(array('os','match','/iphone/i'))
    ->select(array('time'))
    ->group('time')
	->countEach('*','count')
	->outputAsFile('iphone_bus_roadStatus_hx_all_pv','iphone公交路况检索结果全有[缓行]标签pv');
	
$queryData
    ->filter(array(array('qt','match','/^(bt|bus|bse)$/i'),array('tagStatus','==','yd_all')))
	->filter(array('os','match','/iphone/i'))
    ->select(array('time'))
    ->group('time')
	->countEach('*','count')
	->outputAsFile('iphone_bus_roadStatus_yd_all_pv','iphone公交路况检索结果全有[拥堵]标签pv');	

$queryData
    ->filter(array(array('qt','match','/^(bt|bus|bse)$/i'),array('tagStatus','==','exist_tag')))
	->filter(array('os','match','/iphone/i'))
    ->select(array('time'))
    ->group('time')
	->countEach('*','count')
	->outputAsFile('iphone_bus_roadStatus_exist_tag_pv','iphone公交路况检索结果有标签pv');	
	
$queryData
    ->filter(array('qt','match','/^(bt|bus|bse)$/i'))
	->filter(array('os','match','/iphone/i'))
    ->select(array('time','nonTagNum'))
    ->group('time')
	->sumEach('nonTagNum','sum')
    ->select(array('time','sum'))
	->outputAsFile('iphone_bus_roadStatus_non_tag_num','iphone公交路况检索结果没有标签条数');	

/*	
//android uv		
$queryData ->filter(array(array('qt','==','bus'),array('tagStatus','==','tag_all')))
     ->filter(array('os','match','/android/i'))
     -> uniq('cuid')
    -> group('time')
    -> countEach('*','uniqCnt')
    -> select(array('time','uniqCnt')) 
    ->outputAsFile('android_bus_roadStatus_tag_all_uv','android公交路况检索结果全有标签uv');
	
$queryData ->filter(array(array('qt','==','bus'),array('tagStatus','==','hx_all')))
     ->filter(array('os','match','/android/i'))
     -> uniq('cuid')
    -> group('time')
    -> countEach('*','uniqCnt')
    -> select(array('time','uniqCnt')) 
    ->outputAsFile('android_bus_roadStatus_hx_all_uv','android公交路况检索结果全有[缓行]标签uv');

$queryData ->filter(array(array('qt','==','bus'),array('tagStatus','==','yd_all')))
     ->filter(array('os','match','/android/i'))
     -> uniq('cuid')
    -> group('time')
    -> countEach('*','uniqCnt')
    -> select(array('time','uniqCnt')) 
    ->outputAsFile('android_bus_roadStatus_yd_all_uv','android公交路况检索结果全有[拥堵]标签uv');	

$queryData ->filter(array(array('qt','==','bus'),array('tagStatus','==','exist_tag')))
     ->filter(array('os','match','/android/i'))
     -> uniq('cuid')
    -> group('time')
    -> countEach('*','uniqCnt')
    -> select(array('time','uniqCnt')) 
    ->outputAsFile('android_bus_roadStatus_exist_tag_uv','android公交路况检索结果有标签uv');	
	
//ios uv

$queryData ->filter(array(array('qt','==','bus'),array('tagStatus','==','tag_all')))
     ->filter(array('os','match','/iphone/i'))
     -> uniq('cuid')
    -> group('time')
    -> countEach('*','uniqCnt')
    -> select(array('time','uniqCnt')) 
    ->outputAsFile('iphone_bus_roadStatus_tag_all_uv','iphone公交路况检索结果全有标签uv');
	
$queryData ->filter(array(array('qt','==','bus'),array('tagStatus','==','hx_all')))
     ->filter(array('os','match','/iphone/i'))
     -> uniq('cuid')
    -> group('time')
    -> countEach('*','uniqCnt')
    -> select(array('time','uniqCnt')) 
    ->outputAsFile('iphone_bus_roadStatus_hx_all_uv','iphone公交路况检索结果全有[缓行]标签uv');

$queryData ->filter(array(array('qt','==','bus'),array('tagStatus','==','yd_all')))
     ->filter(array('os','match','/iphone/i'))
     -> uniq('cuid')
    -> group('time')
    -> countEach('*','uniqCnt')
    -> select(array('time','uniqCnt')) 
    ->outputAsFile('iphone_bus_roadStatus_yd_all_uv','iphone公交路况检索结果全有[拥堵]标签uv');	

$queryData ->filter(array(array('qt','==','bus'),array('tagStatus','==','exist_tag')))
     ->filter(array('os','match','/iphone/i'))
     -> uniq('cuid')
    -> group('time')
    -> countEach('*','uniqCnt')
    -> select(array('time','uniqCnt')) 
    ->outputAsFile('iphone_bus_roadStatus_exist_tag_uv','iphone公交路况检索结果有标签uv');		
	
*/	
	
>
