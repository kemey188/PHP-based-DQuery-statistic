<? php

\\酒店组件离线统计
function getLog($fields)
{
    $res = array();
    $res['act'] = $fields['_Key_ACT'];			//key
    $res['os'] = $fields['_Key_OS'];
    $res['sv'] = $fields['_Key_SV'];
    if ($res['os'] == 'android' && $res['sv'] == '')
        $res['sv'] = '3.2.0';
    $res['im'] = $fields['_Key_IM'];
    $res['cat'] = $fields['_Key_PARAMS']['CAT'];
    $res['da_model'] = $fields['_Key_PARAMS']['DA_MODEL'];

    \Utils::trace($res);
    return $res;
}

$keylist = array(
				'hotel' => array(
							
							// 酒店检索频道页离线统计项
					    'MCHotelSearchChannel.showCount' => array('SearchChannelPG_show','检索页展现量'),		
					    'MCHotelSearchChannelPage.cityClk' => array('SearchChannelPG_city_choose','检索页城市选择'),
              'MCHotelSearchChannelPage.checkTimeClk' => array('SearchChannelPG_checkTime','检索页入店时间'),								
					    'MCHotelSearchChannelPage.leaveTimeClk' => array('SearchChannelPG_city_choose','检索页离店时间'),	
					    'MCHotelSearchChannelPage.priceClk' => array('SearchChannelPG_price','检索页价格'),						    
					    'MCHotelChooseCityPage.currentCityClk' => array('ChooseCityPG_currentCity','城市选择页定位城市'),						    
					    'MCHotelChooseCityPage.historyCityClk' => array('ChooseCityPG_historyCity','城市选择页历史城市'),						    
					    'MCHotelChooseCityPage.hotCityClk' => array('ChooseCityPG_hotCity','城市选择页热门城市'),						    
					    'MCHotelChoosePricePage.startPrice不限' => array('ChoosePricePG_allPrice','价格选择页价格不限'),						    
					    'MCHotelChoosePricePage.startPrice0' => array('ChoosePricePG_Price0_150','价格选择页0_150'),						    
					    'MCHotelChoosePricePage.startPrice150' => array('ChoosePricePG_Price150_300','价格选择页150_300'),						    
					    'MCHotelChoosePricePage.startPrice300' => array('ChoosePricePG_Price300_500','价格选择页300_500'),					    
					    'MCHotelChoosePricePage.startPrice500' => array('ChoosePricePG_PriceBeyond500','价格选择页大于500'),
					    'MCHotelChoosePricePage.customPriceClk' => array('ChoosePricePG_customPrice','价格选择页自定义价格'),						    
					    'MCHotelKeyWordPage.confirmClk' => array('KeyWordPG_confirmBt','关键词页确定按钮'),	
					    'MCHotelKeyWordPage.hotBusinessClk' => array('KeyWordPG_hotBusiness','关键词页热门商圈'),						    
					    'MCHotelKeyWordPage.hotBrandClk' => array('KeyWordPG_hotBrand','关键词页热门品牌'),						    
					    'MCHotelHotBrandPage.如家' => array('HotBrandPG_rujia','热门品牌页_如家'),						    
					    'MCHotelHotBrandPage.汉庭' => array('HotBrandPG_hanting','热门品牌页_汉庭'),	
					    'MCHotelHotBrandPage.7天' => array('HotBrandPG_qitian','热门品牌页_7天'),
					    'MCHotelHotBrandPage.速8' => array('HotBrandPG_suba','热门品牌页_速8'),
					    'MCHotelHotBrandPage.莫泰' => array('HotBrandPG_motai','热门品牌页_莫泰'),
					    'MCHotelHotBrandPage.格林豪泰' => array('HotBrandPG_gelinhaotai','热门品牌页_格林豪泰'),
					    'MCHotelHotBrandPage.锦江之星' => array('HotBrandPG_jinjiangzhixing','热门品牌页_锦江之星'),
					    'MCHotelHotBrandPage.布丁' => array('HotBrandPG_buding','热门品牌页_布丁'),					    
					    'MCHotelPoiListPage.fromNearby' => array('PoiListPG_fromNearbybt1','列表页来自查看附近按钮1'),								    
					    'MCHotelPoiListPage.fromSearch' => array('PoiListPG_fromSearchbt1','列表页来自查询按钮1'),
					    								    
					    //酒店现付预订服务项目统计需求_OCEAN
					    'MCHotelOrderPage.enter' => array('OrderPG_enter','订单填写页'),					   
					    'MCHotelOrderPage.back' => array('OrderPG_backbt','订单填写页_返回按钮点击'),
					    'MCHotelOrderPage.inputCheckinPerson' => array('OrderPG_inputCheckin','订单填写页_入住人输入框点击'),
					    'MCHotelOrderPage.otherDemand' => array('OrderPG_otherDemand','订单填写页_其他要求点击'),	
					    'MCHotelOrderPage.inputContactPerson' => array('OrderPG_inputContactPerson','订单填写页_联系人输入框点击'),
					    'MCHotelOrderPage.inputContactPhone' => array('OrderPG_inputContactPhone','订单填写页_联系人手机输入框点击'),	
					    'MCHotelOrderPage.inputContactHistory' => array('OrderPG_inputContactHistory','订单填写页_历史联系人按钮点击'),	
					    'MCHotelOrderPage.inputCheckinHistory' => array('OrderPG_inputCheckinHistory','订单填写页_历史入住人按钮点击'),	
					    'MCHotelOrderPage.jumpToGuaranteePage' => array('OrderPG_jumpToGuaranteePage','订单填写页_跳担保页面'),	
					    'MCHotelOrderPage.priceChange' => array('OrderPG_priceChange','订单填写页_变价通知浮层展现'),						    
					    'MCHotelUnbookablePage.enter' => array('UnbookablePG_enter','不可预订提示页'),	
					    'MCHotelUnbookablePage.back' => array('UnbookablePG_back','不可预订提示页_返回按钮点击'),						    
					    'MCHotelUnbookablePage.clickBackBtn' => array('UnbookablePG_clickbt','不可预订提示页_返回重新预订按钮点击'),						    
				  /*  'MCHotelStatusPage.enter' => array('StatusPG_enter','预订状态页_返回按钮点击'),	 // key貌似有问题	*/				    
					    'MCHotelStatusPage.checkRule' => array('StatusPG_checkRule','预订状态页_查看规则按钮点击'),						    
					    'MCHotelStatusPage.back' => array('StatusPG_back','预订状态页_满房_返回重新预订点击'),						    
					    					    					        					    			    					    							
							)
				
			);
			
$andrlog = DQuery::input(array("date"=>0,"name"=>"v2_map_android"))
->select('getLog')->filter(array('os','match','/android/i'));

$iphonelog = DQuery::input(array("date"=>0,"name"=>"v2_map_iphone"))
->select('getLog')->filter(array('os','match','/iphone/i'));

foreach($keylist as $cat => $keys)
{

    $andrlog2 = $andrlog->filter(array('da_model','==','plugin_hotel'));
	$iphonelog2 = $iphonelog->filter(array('da_model','==','plugin_hotel'));

	foreach($keys as $v1 => $v2)
	{
    $andrlog2->filter(array('act','match','/'.$v1.'/i'))->count('*','c')->select(array('c'))
		->outputAsNumeric('plugin_android_'.$v2[0].'_pv', 'plugin_android_'.$v2[1].'_pv');
		
		$andrlog2->filter(array('act','match','/'.$v1.'/i'))->uniq(array('im'))->count('*','c')
		->select(array('c'))->outputAsNumeric('plugin_android_'.$v2[0].'_uv', 'plugin_android_'.$v2[1].'_uv');
		
		$iphonelog2->filter(array('act','match','/'.$v1.'/i'))->count('*','c')->select(array('c'))
		->outputAsNumeric('plugin_iphone_'.$v2[0].'_pv', 'plugin_iphone_'.$v2[1].'_pv');
		
		$iphonelog2->filter(array('act','match','/'.$v1.'/i'))->uniq(array('im'))->count('*','c')
		->select(array('c'))->outputAsNumeric('plugin_iphone_'.$v2[0].'_uv', 'plugin_iphone_'.$v2[1].'_uv');
	}
}



>


			
			
			
