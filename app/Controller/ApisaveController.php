<?php
App::uses('AppController', 'Controller');
class ApisaveController extends AppController {
    public $uses = array('test','rooms','historys','komas');
	public function save() {

        debug($this->request->query);

        $getinfo = $this->request->query;

        debug($getinfo['id']);

        $situations = $this->historys->find(
            'first',array(
                'conditions' => array('hash' => $getinfo['id'])
            )
        );

        debug($situations);
        $this->setkoma($getinfo['id']);

	}




    public function setkoma($uniqid){

        $this->historys->create();
        $this->historys->set('hash', $uniqid);

        $this->historys->set('1-1', 22);
        $this->historys->set('1-2', 20);
        $this->historys->set('1-3', 18);
        $this->historys->set('1-4', 17);
        $this->historys->set('1-5', 16);
        $this->historys->set('1-6', 17);
        $this->historys->set('1-7', 18);
        $this->historys->set('1-8', 20);
        $this->historys->set('1-9', 22);

        $this->historys->set('2-1', 1);
        $this->historys->set('2-2', 26);
        $this->historys->set('2-3', 1);
        $this->historys->set('2-4', 1);
        $this->historys->set('2-5', 1);
        $this->historys->set('2-6', 1);
        $this->historys->set('2-7', 1);
        $this->historys->set('2-8', 24);
        $this->historys->set('2-9', 1);

        $this->historys->set('3-1', 28);
        $this->historys->set('3-2', 28);
        $this->historys->set('3-3', 28);
        $this->historys->set('3-4', 28);
        $this->historys->set('3-5', 28);
        $this->historys->set('3-6', 28);
        $this->historys->set('3-7', 28);
        $this->historys->set('3-8', 28);
        $this->historys->set('3-9', 28);

        $this->historys->set('4-1', 28);
        $this->historys->set('4-2', 28);
        $this->historys->set('4-3', 28);
        $this->historys->set('4-4', 28);
        $this->historys->set('4-5', 28);
        $this->historys->set('4-6', 28);
        $this->historys->set('4-7', 28);
        $this->historys->set('4-8', 1);
        $this->historys->set('4-9', 28);

        $this->historys->set('5-1', 1);
        $this->historys->set('5-2', 1);
        $this->historys->set('5-3', 1);
        $this->historys->set('5-4', 1);
        $this->historys->set('5-5', 1);
        $this->historys->set('5-6', 1);
        $this->historys->set('5-7', 1);
        $this->historys->set('5-8', 1);
        $this->historys->set('5-9', 1);

        $this->historys->set('6-1', 1);
        $this->historys->set('6-2', 1);
        $this->historys->set('6-3', 14);
        $this->historys->set('6-4', 14);
        $this->historys->set('6-5', 14);
        $this->historys->set('6-6', 14);
        $this->historys->set('6-7', 14);
        $this->historys->set('6-8', 14);
        $this->historys->set('6-9', 14);

        $this->historys->set('7-1', 14);
        $this->historys->set('7-2', 14);
        $this->historys->set('7-3', 14);
        $this->historys->set('7-4', 14);
        $this->historys->set('7-5', 14);
        $this->historys->set('7-6', 14);
        $this->historys->set('7-7', 14);
        $this->historys->set('7-8', 14);
        $this->historys->set('7-9', 14);

        $this->historys->set('8-1', 1);

        $this->historys->set('8-2', 1);
        $this->historys->set('8-3', 1);
        $this->historys->set('8-4', 1);
        $this->historys->set('8-5', 1);
        $this->historys->set('8-6', 1);
        $this->historys->set('8-7', 1);
        $this->historys->set('8-8', 12);
        $this->historys->set('8-9', 1);

        $this->historys->set('9-1', 8);
        $this->historys->set('9-2', 6);
        $this->historys->set('9-3', 4);
        $this->historys->set('9-4', 3);
        $this->historys->set('9-5', 2);
        $this->historys->set('9-6', 3);
        $this->historys->set('9-7', 4);
        $this->historys->set('9-8', 6);
        $this->historys->set('9-9', 8);

       debug($this->historys->save());



    }




}
