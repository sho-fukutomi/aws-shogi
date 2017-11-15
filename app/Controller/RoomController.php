<?php
class RoomController extends AppController {
    public $uses = array('test','rooms','historys','komas');

    public function index() {

        $pagedata = $this->request->query;
        $komaname = $this->komas->find('all');

        //DBから、駒状況取得
        $situations = $this->historys->find('first',array(
            'conditions' => array('hash' => $pagedata['id']),
            'order' =>  array('id' => 'DESC')
        ));


//debug($situations);

        //駒の名前パース
        foreach ($komaname as $key => $value) {
            $komaarray[$value['komas']['ID']] = $value['komas']['koma_name'];
        }

        //駒状況を配列に格納
        foreach ($situations['historys'] as $key => $value) {

            if ($key == 'id' || $key == 'created' || $key == 'hash'){

            }else{
                $koma[substr($key,0,1)][substr($key,2,1)]  = $value;
            }
        }

        if(empty($pagedata['teban'])){
        //先手番

            //シェア用文言
            $share['jpn'] = '後手番をシェア';
            $share['url'] = 'http://tomitomiclub.com/shogi/room/?id='.$pagedata['id'].'&teban=gote';
            $share['teban'] = '先手';


        }else{
        //後手番
            $share['jpn'] = '先手番をシェア';
            $share['url'] = 'http://tomitomiclub.com/shogi/room/?id='.$pagedata['id'];
            $share['teban'] = '後手';

            for($i=9; $i>0 ;$i--){
                for($j=9; $j>0 ;$j--){

                    if($koma[$i][$j] == 1){
                        $komagote[10-$i][10-$j] = $koma[$i][$j];
                    }elseif($koma[$i][$j] > 14){
                        $komagote[10-$i][10-$j] = $koma[$i][$j] - 14;
                    }else{
                        $komagote[10-$i][10-$j] = $koma[$i][$j] + 14;
                    }

                }

            }
            $koma = $komagote;
        }
        $this->set('title_for_layout', '将棋しようぜ! '.$share['teban'].'  '.$pagedata['id']);

        $this->set('share',$share);
        $this->set('koma',$koma);
        $this->set('komaarray',$komaarray);
        $this->set('roomid',$pagedata['id']);
	}
    public function makeroom() {

        $uniqid = uniqid('room-');
        $visiterip = $_SERVER["REMOTE_ADDR"];

        $pagedata = $this->request->query;
        if(empty($pagedata)){
            $pagedata['handicap'] = 0;
        }

        $this->rooms->create();
        $this->rooms->set('hash', $uniqid);
        $this->rooms->set('madeip', $visiterip);
        $this->rooms->save();

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

        $this->historys->set('4-1', 1);
        $this->historys->set('4-2', 1);
        $this->historys->set('4-3', 1);
        $this->historys->set('4-4', 1);
        $this->historys->set('4-5', 1);
        $this->historys->set('4-6', 1);
        $this->historys->set('4-7', 1);
        $this->historys->set('4-8', 1);
        $this->historys->set('4-9', 1);

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
        $this->historys->set('6-3', 1);
        $this->historys->set('6-4', 1);
        $this->historys->set('6-5', 1);
        $this->historys->set('6-6', 1);
        $this->historys->set('6-7', 1);
        $this->historys->set('6-8', 1);
        $this->historys->set('6-9', 1);

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

        if($pagedata['handicap'] >= 2 ){
            $this->historys->set('8-2', 1);
        }else{
            $this->historys->set('8-2', 10);
        }
        $this->historys->set('8-3', 1);
        $this->historys->set('8-4', 1);
        $this->historys->set('8-5', 1);
        $this->historys->set('8-6', 1);
        $this->historys->set('8-7', 1);
        if($pagedata['handicap'] >= 2){
            $this->historys->set('8-8', 1);
        }else{
            $this->historys->set('8-8', 12);
        }
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

       $this->historys->save();


       $this->redirect('/room/?id='.$uniqid);


	}

}
