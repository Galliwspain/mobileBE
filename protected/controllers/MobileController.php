<?php

class MobileController extends CController
{
	public function actionIndex()
	{

	}
	
	public function actionMinicards()
	{
	$url = 'http://catalog.api.2gis.ru/search?what='.$_REQUEST['query'].'&page='.$_REQUEST['page'].'&version=1.3&key='.API_KEY;
        $url = $url.'&point='.$_REQUEST['long'].','.$_REQUEST['lati'].'&radius='.$_REQUEST['radius'].'&version=1.3';
	$json=file_get_contents($url, 0);
        $json1 = json_decode($json , true);
        if(!isset($json1['result']))
        {
                echo $_GET['callback'].'({"error_message"="'.$json1['error_message'].'","error_code"="'.$json1['error_code'].'"});';
        }
	else
	{
        $result = $json1['result'];
        $mh=curl_multi_init();
        $mcurlactive=null;

        foreach($result as $i=>$k)
        {
            $idtable[$k['id']]=curl_init();
            curl_setopt($idtable[$k['id']], CURLOPT_URL, "http://catalog.api.2gis.ru/profile?&version=1.3&key=".API_KEY."&id=".$k['id']);
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
/*                    case 'lon':
                    $resultjson['result'][$i][$nm]=$y;
                    case 'lat':
                    $resultjson['result'][$i][$nm]=$y;
*/  
              }
            }
            $strres=json_decode($mcrlresults[$k['id']],true);
            $time=(int)substr(date('H:i'),0,2).substr(date('H:i'),3,2);
            if(isset($strres['additional_info']))
		{
	            $resultjson['result'][$i]['additional_info']=$strres['additional_info'];
		}
            if(isset($strres['rating'])) 
                {
	            $resultjson['result'][$i]['rating']=$strres['rating'];
                }
            if(isset($strres['schedule']))
		{
			foreach($strres['schedule'][date('D')] as $e=>$r)
			{
 	                	$to=(int)substr($r['to'],0,2).substr($r['to'],3,2);
	         	        $from=(int)substr($r['from'],0,2).substr($r['from'],3,2);
	           	        if($to<$from) 
				{
	        	            $to = $to + 2400;
	               		}
		                if($time<$from||$time>=$to) 
				{
	                	    $status=0;
		                };
		                if($to - $time >= 100 && $time >= $from) 
				{
		                    $status=60;
		                    break;
		                }
		                if($to - $time < 100 &&  $time < $to) 
				{
		                    $status = $to - $time - 40;
		                    break;
		                }   
	            	}
	 	}
            $resultjson['result'][$i]['status']=$status;
        }
	header('Content-Type: application/javascript');
	if(isset($_GET['callback']))
	{
	        echo $_GET['callback'];
	        echo '(';
	        echo json_encode($resultjson);
	        echo ');';
	}
	else
	{
		echo json_encode($resultjson);
    	}
	}
	}
// ===========================================================================================================

	public function actionMarkers()
	{
	$url = 'http://catalog.api.2gis.ru/search?what='.$_REQUEST['query'].'&pagesize=50&version=1.3&key='.API_KEY;
        $url = $url.'&point='.$_REQUEST['long'].','.$_REQUEST['lati'].'&radius='.$_REQUEST['radius'];
	$json=file_get_contents($url, 0);
	$json1 = json_decode($json , true);
        if(!isset($json1['result']))
        {
                echo $_GET['callback'].'({"error_message"="'.$json1['error_message'].'","error_code"="'.$json1['error_code'].'"});';
        }
	else
	{
	$result = $json1['result'];
	foreach ($result as $i=>$k)
		{
			foreach($k as $a=>$b)
			{
				$resultjson['result'][$i]['id']=$result[$i]['id'];
				$resultjson['result'][$i]['coord']=$result[$i]['lon'].';'.$result[$i]['lat'];
			}
		}
	if($json1['total']>50)
	{
	$num=floor($json1['total']/50)+1;
	$mch=curl_multi_init();
	$mcurlactive=null;
	for($ii=2;$ii<$num+1;$ii++)
	{
		$idtable[$ii]=curl_init();
		curl_setopt($idtable[$ii], CURLOPT_URL, "$url"."&page=$ii");
		curl_setopt($idtable[$ii], CURLOPT_RETURNTRANSFER, true);
		curl_multi_add_handle($mch,$idtable[$ii]);
	}
	do
	{
		curl_multi_exec($mch,$mcurlactive);
	}
	while ($mcurlactive>0);
		foreach ($idtable as $key=>$val)
		{
			$mcrlresults[$key]=curl_multi_getcontent($val);
		}
	curl_multi_close($mch);
	foreach ($mcrlresults as $a=>$b)
	{	
		$result=json_decode($b,true);
	        $result = $result['result'];
	        foreach ($result as $i=>$k)
	        {	
        	        foreach($k as $aa=>$bb)
               		{
				$resultjson['result'][$i+50*($a-1)]['id']=$result[$i]['id'];
                                $resultjson['result'][$i+50*($a-1)]['coord']=$result[$i]['lon'].';'.$result[$i]['lat'];
                	}
        	}
	}}
	header('Content-Type: application/javascript');
        if(isset($_GET['callback']))
        {
                echo $_GET['callback'];
                echo '(';
                echo json_encode($resultjson);
                echo ');';
        }
        else
        {
                echo json_encode($resultjson);
        }
	}
	}
	public function actionMinicompany()
	{
//        date_default_timezone_set('Asia/Novosibirsk');
        $url = 'http://catalog.api.2gis.ru/profile?&version=1.3&key='.API_KEY.'&id='.$_REQUEST['cid'];
        $json=file_get_contents($url, 0);
        if(isset($json1['error_code']))
        {
                echo $_GET['callback'].'({"error_message"="'.$json1['error_message'].'","error_code"="'.$json1['error_code'].'"});';
        }
	else
        $result = json_decode($json , true);
//        echo $result['additional_info']['avg_price'];
	foreach ($result as $nm=>$y)
	{
        	switch($nm) {
                    case 'rubrics':
                    $resultjson['result'][$nm]=$y;
                    case 'name':
                    $resultjson['result'][$nm]=$y;
                    case 'id':
                    $resultjson['result'][$nm]=$y;
                    case 'reviews_count':
                    $resultjson['result'][$nm]=$y;
                    case 'address':
                    $resultjson['result'][$nm]=$y;
		    case 'firm_group':
                    $resultjson['result'][$nm]=$y;
		    case 'payoptions':
                    $resultjson['result'][$nm]=$y;
                    case 'schedule':
                    $resultjson['result'][$nm]=$y;
                    case 'contacts':
                    $resultjson['result'][$nm]=$y;
                    case 'rating':
                    $resultjson['result'][$nm]=$y;
		}
                if(isset($result['additional_info']['office']))
                {
                    $resultjson['result']['additional_info']['office']=$result['additional_info']['office'];
                }
                if(isset($result['additional_info']['avg_price']))
                {
                    $resultjson['result']['additional_info']['avg_price']=$result['additional_info']['avg_price'];
                }

	}
        $time=(int)substr(date('H:i'),0,2).substr(date('H:i'),3,2);
        if(isset($result['schedule']))
        {
		foreach($result['schedule'][date('D')] as $e=>$r)
                {
                	$to=(int)substr($r['to'],0,2).substr($r['to'],3,2);
	                $from=(int)substr($r['from'],0,2).substr($r['from'],3,2);
	                if($to<$from) 
	                {
        		        $to = $to + 2400;
	                }
        	        if($time<$from||$time>=$to) 
	                {
		                $status=0;
	                };
	                if($to - $time >= 100 && $time >= $from) 
	                {
		                $status=60;
		                break;
	                }
	                if($to - $time < 100 &&  $time < $to) 
	                {
		                $status = $to - $time - 40;
		                break;
	                }   
               }
	}
        $resultjson['result']['status']=$status;
        header('Content-Type: application/javascript');
        if(isset($_GET['callback']))
        {
                echo $_GET['callback'];
                echo '(';
                echo json_encode($resultjson);
                echo ');';
        }
        else
        {
                echo json_encode($resultjson);
        }

}
}
