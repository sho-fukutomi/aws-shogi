<?php
App::uses('AppController', 'Controller');
class ApisaveController extends AppController {
    public $uses = array('test','rooms','historys','komas');
	public function save() {
        $this->autoRender = false;
        //形式はこんな感じ
        // http://localhost:8080/shogi/api_save/save?id=room-59f1a57f6e5e1&5-5=brank&5-6=%E9%BE%8D

        $getinfo = $this->request->data;
        // $getinfo = $this->request->query;
        // return var_dump($getinfo);
        // debug($getinfo['id']);

        $situations = $this->historys->find('first',array(
            'conditions' => array('hash' => $getinfo['id'])//,
            //'order' =>  array('id' => 'DESC')
        ));
        // debug($situations);

        $komamove=$getinfo;
        unset($komamove['id']);
        $komamove = $this->translationToId($komamove);


        // debug($komamove);

        return $this->setkoma($getinfo['id'],$komamove);
	}

    public function setkoma($uniqid,$komamove){


        $situations = $this->historys->find('first',array(
            'conditions' => array('hash' => $uniqid),
            'order' =>  array('id' => 'DESC')
        ));

        foreach ($komamove as $key => $value) {
                $situations['historys'][$key] =$komamove[$key];=
                //コマを取っていたら自陣に追加する処理を書く
                if($key == 'gotkoma'){
                    return json_encode($key) ;
                }

        }

return json_encode($situations) ;
        unset($situations['historys']['created']);
        $this->historys->create();
        $this->historys->set($situations);
        $this->historys->set('id','');
return json_encode($situations) ;
        // if($this->historys->save()){
        //     return 'saved!'.json_encode($situations);
        // }else{
        //     return 'save faild!';
        // }


    }
    public function translationToId($komamove){

        $komalist = $this->komas->find('all',array(
            'conditions' => array('or' => array(
                array('teban' => $komamove['teban']),
                array('teban' => 'なし')
            ))
        ));
        unset($komamove['teban']);
        $result = array();

        foreach($komamove as $key => $valuefrom ){
            foreach ($komalist as $valueto) {
                if($valuefrom == $valueto['komas']['koma_name']){
                    $result[$key] = $valueto['komas']['ID'];
                }
            }
        }
        return $result;
    }

    //ハッシュの最後の手番を教えてくれるよ
    public function checkreload(){
        $this->autoRender = false;
        $getinfo = $this->request->data;
        $lastTeban = $this->historys->find('first',array(
            'conditions' => array('hash' => $getinfo['hash']),
            'order' =>  array('id' => 'DESC'),
            'fields' => array('historys.teban'),
        ));
        return $lastTeban['historys']['teban'];
    }



}
