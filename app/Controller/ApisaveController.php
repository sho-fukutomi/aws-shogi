<?php
App::uses('AppController', 'Controller');
class ApisaveController extends AppController {
    public $uses = array('test','rooms','historys','komas');
	public function save() {

        debug($this->request->query);

        $getinfo = $this->request->query;

        debug($getinfo['id']);

        $situations = $this->historys->find('first',array(
            'conditions' => array('hash' => $getinfo['id'])//,
            //'order' =>  array('id' => 'DESC')
        ));

        debug($situations);
        $this->setkoma($getinfo['id']);

	}




    public function setkoma($uniqid){


        $situations = $this->historys->find('first',array(
            'conditions' => array('hash' => $uniqid),
            'order' =>  array('id' => 'DESC')
        ));


        $this->historys->create();
        $this->historys->set($situations);
        $this->historys->set('id','');
        debug($this->historys->save());




    }




}
