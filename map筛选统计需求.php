<?php

//6月版筛选统计需求

$andrlog = DQuery::input(array("date"=>0,"name"=>"v2_map_android"))
->select('getLog')->filter(array('os','match','/android/i'));

$iphonelog = DQuery::input(array("date"=>0,"name"=>"v2_map_iphone"))
->select('getLog')->filter(array('os','match','/iphone/i'));

function getLog($fields)
{
    $res = array();
    $res['act'] = $fields['_Key_ACT'];			//key
    $res['os'] = $fields['_Key_OS'];
    $res['cuid'] = $fields['_Key_CUID'];
    $res['cat'] = $fields['_Key_PARAMS']['CAT'];  //行业
    $res['index'] = $fields['_Key_PARAMS']['LISTITEM_INDEX'];

    return $res;
}

$keylist = array(
				'query' => array(
							'0' => array('scope_tab_click','范围tab点击'),
							'1' => array('category_tab_click','类别tab点击'),
							'2' => array('sort_tab_click','排序tab点击'),
							)				
			);
			

foreach($keylist as $cat => $keys)
{

  $andrlog2 = $andrlog->filter(array('act','match','/PoiListPG.filterBt/i'));
	$iphonelog2 = $iphonelog->filter(array('act','match','/PoiListPG.filterBt/i'));

	foreach($keys as $v1 => $v2)
	{
    $andrlog2->filter(array('index','==',$v1))
		           ->group('cat')
		           ->countEach('*','c')
				       ->select(array('cat','c'))
		         ->outputAsFlie('android_'.$v2[0].'_pv', 'android_'.$v2[1].'_pv');
		
		$andrlog2->filter(array('index','==',$v1))
             -> uniq(array('cuid','cat'))
	           -> group('cat')
             -> countEach('*','c')
             -> select(array('cat','c'))
		         ->outputAsFile('android_'.$v2[0].'_uv', 'android_'.$v2[1].'_uv');
		
		$iphonelog2->filter(array('index','==',$v1))
		           ->group('cat')
		           ->countEach('*','c')
				       ->select(array('cat','c'))
		           ->outputAsFile('iphone_'.$v2[0].'_pv', 'iphone_'.$v2[1].'_pv');
		
		$iphonelog2->filter(array('index','==',$v1))
		           ->uniq(array('cuid','cat'))
		           ->group('cat')
		           ->countEach('*','c')
		           ->select(array('cat','c'))
		           ->outputAsFile('iphone_'.$v2[0].'_uv', 'iphone_'.$v2[1].'_uv');
	}
}

			
?>
