<?php
class NecapiController extends AppController {
    //public $uses = array('Post');
    public function index(){
        if ($this->request->is('post') || $this->request->is('put')) {

            //debug($this->request->data['url'] );
            //$img = $this->base64_encode_urlsafe(file_get_contents($this->request->data['url']));
            $img = $this->base64_encode_urlsafe(file_get_contents($this->request->data['url']));
            debug($img);
            debug($this-> curlRequestnec($img));
        }


        $this->layout = '';


    }

    private function curlRequestnec($img){
        $curl = curl_init();
        $url = 'https://api.cloud.nec.com/neoface/f-face-image/v1/action/auth';
        $header = array(
            'apikey:l7b3f190e8fbc74168912fc4b2f883a1c9',  // 前準備で取得したtokenをヘッダに含める
            'Content-Type: application/json',
        );

        $jsoned_data2 = '{"paramSetId":"auth_30_02_0055","queryImages":["'. $img.'"]}';

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS,$jsoned_data2 ); // jsonデータを送信
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header); // リクエストにヘッダーを含める
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        curl_close($curl);
        return $response;

    }

    function base64_encode_urlsafe($s){
	       $s = base64_encode($s);
	// return(str_replace(array('+','=','/'),array('_','-','.'),$s));
    return(str_replace(array('+','/'),array('-','_'),$s));
    }
}
