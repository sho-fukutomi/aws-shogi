<?php
App::uses('AppController', 'Controller');
class ApisaveController extends AppController {
    public $uses = array('test','rooms','historys','komas');
	public function save() {

        debug($this->request->query);

        $getinfo = $this->request->query;

        debug($getinfo['id']);





	}
}
