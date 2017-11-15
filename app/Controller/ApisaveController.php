<?php
App::uses('AppController', 'Controller');
class ApisaveController extends AppController {
    public $uses = array('test','rooms','historys','komas');
	public function save() {
        $this->autoRender = false;


        //形式はこんな感じ
        //http://localhost:8080/shogi/api_save/save?id=room-59f1a57f6e5e1&5-5=brank&5-6=%E9%BE%8D
        // debug($this->request->query);

        $getinfo = $this->request->data;

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
                $situations['historys'][$key] =$komamove[$key];
        }


        $this->historys->create();
        $this->historys->set($situations);
        $this->historys->set('id','');
        // $this->historys->save();

        if($this->historys->save()){
            return 'saved!';
        }else{
            return 'save faild!';
        }


    }
    public function translationToId($komamove){
        $komalist = $this->komas->find('all',array(
            'conditions' => array('or' => array(
                array('teban' => '先手'),
                array('teban' => 'なし')
            ))
        ));
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



}
