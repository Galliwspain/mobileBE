<?php

class MobileController extends CController
{
	public function actionIndex()
	{

	}
	
	public function actionMinicards()
	{
        date_default_timezone_set('Asia/Novosibirsk');
        echo $_GET['query'];
        $url = 'http://catalog.api.2gis.ru/search?what=пиво&where=Новосибирск&version=1.3&key=ruauaz4582';
        $json=file_get_contents($url, 0);
        $json1 = json_decode($json , true);
        $result = $json1['result'];
        $mh=curl_multi_init();
        $mcurlactive=null;
        
        foreach($result as $i=>$k)
        {
            $idtable[$k['id']]=curl_init();
            curl_setopt($idtable[$k['id']], CURLOPT_URL, "http://catalog.api.2gis.ru/profile?&version=1.3&key=ruauaz4582&id=".$k['id']);
            curl_setopt($idtable[$k['id']], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mh,$idtable[$k['id']]);
        }
        
        do
        {
            curl_multi_exec($mh,$mcurlactive);
        }
        while ($mcurlactive>0);
        
        foreach ($idtable as $key=>$val)
        {
            $mcrlresults[$key]=curl_multi_getcontent($val);
        }
        
        curl_multi_close($mh);
        foreach ($result as $i=>$k)
        {
            foreach ($k as $nm=>$y)
            {
                switch($nm) {
                    case 'rubrics':
                    $resultjson['result'][$i][$nm]=$y;
                    case 'name':
                    $resultjson['result'][$i][$nm]=$y;
                    case 'id':
                    $resultjson['result'][$i][$nm]=$y;
                    case 'reviews_count':
                    $resultjson['result'][$i][$nm]=$y;
                    case 'address':
                    $resultjson['result'][$i][$nm]=$y;
                    case 'lon':
                    $resultjson['result'][$i][$nm]=$y;
                    case 'lat':
                    $resultjson['result'][$i][$nm]=$y;
                }
            }
            
            $strres=json_decode($mcrlresults[$k['id']],true);
            $time=(int)substr(date('H:i'),0,2).substr(date('H:i'),3,2);
            $resultjson['result'][$i]['additional_info']=$strres['additional_info'];
            $resultjson['result'][$i]['rating']=$strres['rating'];

            foreach($strres['schedule'][date('D')] as $e=>$r)
            {
                $to=(int)substr($r['to'],0,2).substr($r['to'],3,2);
                $from=(int)substr($r['from'],0,2).substr($r['from'],3,2);
                if($to<$from) {
                    $to = $to + 2400;
                }

                if($time<$from||$time>=$to) {
                    $status=0;
                };
                if($to - $time >= 100 && $time >= $from) {
                    $status=60;
                    break;
                }
                if($to - $time < 100 &&  $time < $to) {
                    $status = $to - $time - 40;
                    break;
                }   
            }
            $resultjson['result'][$i]['status']=$status;
        }
        $this->render('minicards', array('data' => $resultjson));
//        var_dump($resultjson);
//        echo json_encode($resultjson);
	   
    }
}
