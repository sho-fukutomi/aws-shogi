<?php

    $url = 'https://nativecamp.net/api/teachers/search';
    $n = 1;
    $data = array(
        'users_api_token' => 'b1a6bbf3347563765d462b3f03754dc1',
        'api_version' => 6,
        "pagination" => $n
    );
    $result_echoTeacherStatus = array();
    $count = array();
    $count['standby'] = 0;
    $count['soon'] = 0;
    $count['busy'] = 0;

    $result = postToTeacherSearch($url,$data);
    $result_echoTeacherStatus = echoTeacherStatus($result,$count);
    $count = $result_echoTeacherStatus['count'];
    $n++;

    while($result->has_next){
        $data = array(
            'users_api_token' => 'b1a6bbf3347563765d462b3f03754dc1',
            'api_version' => 6,
            "pagination" => $n
        );

        $result = postToTeacherSearch($url,$data);
        $result_echoTeacherStatus =echoTeacherStatus($result,$count);
        $n = $n +1 ;
    }


    function postToTeacherSearch($url,$data){
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result);
        return $result;
    }

    function echoTeacherStatus($result,$count){
        $i=0;
        $statusList = array();
        foreach ($result->teachers as $teachser_data) {
            switch ($teachser_data->status) {
                case '1':
                    $status = '🔵';
                    $count['standby']++;

                    break;
                case '2':
                    $status = '😆';
                    $count['soon']++;
                    break;
                case '3':
                    $status = '🔴';
                    $count['busy']++;
                    break;
                case '4':
                    $status = 'offline';
                    $j = 0;
                    $filename = '/Users/sho.fukutomi/develop/twitter/'.date("Y-m-d").'.txt';
                    $timeArray = localtime();
                    if ($timeArray[2] + 8 > 24 ){
                        $timeArray[2] = $timeArray[2] - 12;
                    }
                    $timeArray[2] = $timeArray[2] + 8;


                    file_put_contents($filename,$timeArray[2].':'.$timeArray[1].':'.$timeArray[0].','.$count['standby'].','.$count['soon'].','.$count['busy']."\n",FILE_APPEND);
                    exit;
                case '5':
                    $status = 'reserved';
                    break;

                default:
                    $status = 'unknown !! BUG!?';
                    break;
            }
            $statusList[$i] = $status.$teachser_data->name_eng."(". $teachser_data->name_ja.")";
            $i++;

            // echo $status.$teachser_data->name_eng."(". $teachser_data->name_ja.")"."\n" ;
        }
        $j = 0;
        foreach ($statusList as $key) {
//            echo $statusList[$j] ."\n";
            $j++;
        }
        $result_echoTeacherStatus = array();
        $result_echoTeacherStatus['statusList'] = $statusList;
        $result_echoTeacherStatus['count'] = $count;
        return $result_echoTeacherStatus;

    }

?>
