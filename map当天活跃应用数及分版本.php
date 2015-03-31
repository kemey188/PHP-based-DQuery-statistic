<?php
//[key迁移][地图SDK]当天活跃应用数及分版本
//功能:SDK当天活跃应用数
//应用分版本统计


function ip_filter($fields, $resource)
{
    //\Utils::trace($fields);
    return !isset($resource['iplist'][$fields['_LogFields']['uip']]);
}

DQuery::loadRelyFile('map', 'map_internal_iplist', 0, 'iplist');


function getFields($fields){
	$res=array();
	$m_sv=$fields['_LogFields']['sv'];
	$m_os=$fields['_LogFields']['os'];
	$m_name=$fields['_LogFields']['name'];
	$m_pcn=NULL;
	if($m_sv=='2.1.3'&&preg_match('/^android/i',$m_os))
	{
		$pcn_p=$fields['_LogFields']['mcode'];
		$tmp=explode(";",$pcn_p);
		$m_pcn=$tmp[1];
	}
	else if($m_sv=='2.2.0'&&preg_match('/^android/i',$m_os)&&$m_name=='车托帮')
	{
		$m_pcn="cn.safetrip.edog";
	}
	else
		$m_pcn=$fields['_LogFields']['pcn'];
	//fprintf(STDERR,$m_pcn);
	//$i=0;
	$m_condition=isset($fields['_LogFields']['appid'])&&preg_match('/^(01)|(02)$/',$fields['_LogFields']['resid']);
	fprintf(STDERR,$m_pcn);
	if($m_condition){
		//$i++;
		//fprintf(STDERR,$i);
		
			$res['sv'] = $fields['_LogFields']['sv'];
			$res['im'] = $fields['_LogFields']['im'];
			$res['appid'] = $fields['_LogFields']['appid';,
			$res['pcn'] = $m_pcn;
			$res['os'] = $fields['_LogFields']['os'];
			$res['error'] = $fields['_LogFields']['errno'];
			$res['name'] = $fields['_LogFields']['name'];						
			
			if(($res['sv'] == '2.4.1') || ($res['sv'] == '2.4.2') && (preg_match('/android/i',$res['os']))) {
					$res['from'] = $fields['_LogFields']['from_service'];	
					return $res; 					
			}
			
			if ((substr($res['sv'], 0, 3) > '2.4') && (preg_match('/android/i',$res['os']))){
					$res['from'] = $fields['_LogFields']['from_service'];	
					return $res; 	
			}	
			else{
					$res['from'] = $fields['_LogFields']['from'];
					return $res; 									
			}
			
      //\Utils::trace($res);
			return $res;  
							
	}
	//fprintf(STDERR,$i);
}
$osStatCond = array(
    array('name' => 'android',
        'condition' => array(
            array('from','==','lbs_androidsdk')
        ),
    ),
    array('name' => 'ios',
        'condition' => array(
            array('from','==','lbs_iossdk')
        )
    )
);
$data = DQuery::input(array("date" => 0, "name" => "api_sdkcs"))
->filter('ip_filter')
->select("getFields");

foreach($osStatCond as $osStatCondValue)
{
	$condition = $osStatCondValue["condition"];
	
	
	
	
	$pvList_ap= $osStatCondValue["name"].'_'.'SDK_ap_count_new';
	$pvCnList_ap = $osStatCondValue["name"].'_'.'当天活跃应用数_新';
	
	$pvList_ap_list =$osStatCondValue["name"].'_'.'SDK_ap_count_list_new';
	$pvCnList_ap_list= $osStatCondValue["name"].'_'.'当天活跃应用列表_新';
	

	$logData_ap = $data->filter($condition)
	->select(array('pcn'))
	->uniq('pcn');
	
	$logData_ap->count('*', 'total_ap_count')
	->select(array('total_ap_count'))
	->outputAsNumeric($pvList_ap,$pvCnList_ap,null,true);
	$logData_ap->outputAsFile($pvList_ap_list,$pvCnList_ap_list,null,true);
	
	//SDK_UV当天活跃应用数-分版本
	$pvList_ap_sv =$osStatCondValue["name"].'_'.'SDK_ap_count_sv_new';
	$pvCnList_ap_sv= $osStatCondValue["name"].'_'.'当天活跃应用数分版本_新';
	$data->filter($condition)
	//->uniq('pcn')
	->group(array("sv"))
	->uniqCountEach("pcn","ap_total_count_sv")
	->select(array('sv',"ap_total_count_sv"))
	->outputAsFile($pvList_ap_sv,$pvCnList_ap_sv,null,true);	
}

?>
