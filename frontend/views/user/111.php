<?php
$str=file_get_contents('php://input');
$xml=simplexml_load_string('http://flash.weather.com.cn/wmaps/xml/sichuan.xml');
$request=[];
foreach ($xml as $key=>$value){
    if((string)$value['cityname']=='$str'){
        $request[$key]=(string)$value;
    }

}
$Content = $request['Content'];
require 'text.xml';













$str = file_get_contents('php://input');

//file_put_contents('request.xxx',$request);

//定义回复内容数组
$response = [];

//得到数组格式的xml
$xml = simplexml_load_string($str);

foreach ($xml as $k => $value) {
    $response[$k] = (string)$value;
}
//得到天气数据
$request = '';
$weather_xml = simplexml_load_file("http://flash.weather.com.cn/wmaps/xml/sichuan.xml");
$weather = json_decode(json_encode($weather_xml),true);
foreach ($weather['city'] as $city) {
    if($city["@attributes"]["cityname"]==$response['Content']){
        $request .= $city['@attributes']['cityname'].': ';
        $request .= $city['@attributes']['stateDetailed']."\n";
        $request .= '最低气温： '.$city['@attributes']['tem1'].'℃'."\n";
        $request .= '最低气温： '.$city['@attributes']['tem2'].'℃'."\n";
        $request .= '室外温度： '.$city['@attributes']['temNow'].'℃'."\n";
    }
}

if ($request == '') {
    $request = 'error';
}
$Content = $request['Content'];
require 'text.xml';