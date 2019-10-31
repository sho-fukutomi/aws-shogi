<?php
class PostchanController extends AppController {
	public function index() {

        $url = "https://nativecamp.net/api/users/show";
        // $datajson =
        //  '{
        //     "users_api_token": "3138af2360dd8da9b9a383870e11f158",
        //     "api_version": 18,
        //     "reservation_status": 0,
        //     "pagination": 1
        // }';




        $data = array(
            "users_api_token" => "3138af2360dd8da9b9a383870e11f158",
            "api_version"=> 18,
            "reservation_status"=> 0,
            "pagination"=> 1
        );

        $datajson = json_encode($data);




        $header = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Content-Length: ".strlen($datajson)
        );

        $options = array('http' => array(
            'method' => 'POST',
            'header' => implode("\r\n", $header),
            'content' => $datajson,
        ));
        $options = stream_context_create($options);
        $contents = file_get_contents($url, false, $options);


        //echo $contents;
//
        debug(json_decode($contents,TRUE));







	}


    public function setting(){

        $datajson =
         '{
            "users_api_token": "3138af2360dd8da9b9a383870e11f158",
            "api_version": 18,
            "reservation_status": 0,
            "pagination": 1
        }';



        $data = array(
            "users_api_token" => "3138af2360dd8da9b9a383870e11f158",
            "api_version"=> 18,
            "reservation_status"=> 0,
            "pagination"=> 1
        );

        $datajson2 = json_encode($data);

        debug($datajson);
        debug($datajson2);

    }



}
