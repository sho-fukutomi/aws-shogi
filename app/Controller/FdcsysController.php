<?php
class FdcsysController extends AppController {
    public $uses = array('test','rooms','historys','komas','fdc_members','fdc_cards','fdc_milestones','fdc_backlog_lists','fdc_list_list','fdc_webhook','fdc_team');

    public function index() {
	}
    public function popopo(){
        $fixByList = $this->fixByList();
        $infoByDate = $this->perthFixByList($fixByList);
        //debug($infoByDate);

        // $dayList = $this->getDayList();
        // $dayList['dueBlank'] = $infoByDate['dueBlank'];
        // foreach ($dayList as $key => $value) {
        //     if(array_key_exists($key,$infoByDate)){
        //         $dayList[$key] = $infoByDate[$key];
        //     }else{
        //         $dayList[$key] = '';
        //     }
        //
        // }
        // debug($dayList);

        $infoByUser  =  array();
        $colorList = array();
        foreach ($fixByList as $key => $value) {
            $colorList[$key] = $this->addListColor($key);
            foreach ($value as $key2 => $value2) {
                foreach ($value2['idMembers'] as $key3 => $value3) {
                    $infoByUser[$value3][$value2['card_name']] = $value2;
                }
            }
        }
        $memberList = $this->getMemberlist();
        $memberListx = array();
        foreach ($memberList as $key => $memberList2) {
            foreach ($memberList2 as $key2 => $memberList3) {
                foreach ($fixByList as $key3 => $value3) {
                    foreach ($value3 as $key4 => $value4) {
                        foreach ($value4['idMembers'] as $value5) {
                            if($memberList3 == $value5){
                                foreach( $memberList as $key6 => $value6){
                                    foreach ($value6 as $key7 => $value7) {
                                        if($value5 == $value7){
                                            if($value4['idBoard']['color'] == '#8c8c8c' or $value4['idBoard']['color'] == '#ff8f42' ){
                                                $memberListx[$key6][$this->getmemberName($memberList3)][$value4['card_name']] = $value4;
                                            }else{
                                                $memberListx[$key6][$this->getmemberName($memberList3)][$value4['card_name']] = $value4;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


        foreach ($memberListx as $teamName => $value) {
            foreach ($value as $memberName => $value2) {
                $freeFlg = true;
                $devFlg = false;
                foreach ($value2 as $key3 => $value3) {

                    //debug($value3);
                    if($value3['idBoard']['color'] == '#6fa8dc' ){
                        $freeFlg = false;
                    }
                }
                if($teamName == 'Teamjeff' or $teamName == 'TeamFred' or $teamName == 'TeamFrank' or $teamName == 'TeamiOS'){
                    $devFlg = True;

                }


                $memberListx[$teamName][$memberName]['devflag'] = $devFlg;
                $memberListx[$teamName][$memberName]['Freeflag'] = $freeFlg;
            }
        }
        $this->set('colorList',$colorList);
        $this->set('memberListx',$memberListx);
        $this->set('infoByUser',$infoByUser);
        // $this->set('dayList', $dayList);
        $this->set('infoByDate', $infoByDate);
        $this->set('fixByList', $fixByList);
        $this->layout = '';
    }

    public function popopo2(){


        $backlogList = $this->formatBacklog();

        // debug($backlogList);
        $fixByList = $this->fixByList();

        $resultByTrello = array();
        foreach ($fixByList as $listName => $value) {
            foreach ($value as $cardTitle => $value2) {
                $resultByTrello[substr($cardTitle,0,7)] = $value2;
            }
        }

        $resultByBacklog = array();
        foreach ($backlogList as $milestoneName => $value) {
            foreach ($value as $ticketOrder => $value2) {
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['summary'] = $value2['summary'];
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['priority'] = $value2['priority']['name'];
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['category'] = $this->getMilestoneCategory($value2['category']);
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['dueDate'] = $value2['dueDate'];
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['createdUser'] = $value2['createdUser']['name'];
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['updated'] = $value2['updated'];
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['created'] = $value2['created'];
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['description'] = $value2['description'];
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['status'] = $value2['status']['name'];
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['assignee'] = $value2['assignee']['name'];
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['trello'] = $this->getTrelloinfo($value2['issueKey'],$resultByTrello);
                    $resultByBacklog[$milestoneName][$value2['issueKey']]['dueDate'] = $value2['dueDate'];
             }
        }

        // debug($resultByBacklog);
        //$resultByBacklog = array();

        // $resultByBacklog = $this->debugRequest();
        // debug($resultByBacklog);
        $this->set('resultByBacklog',$resultByBacklog);
        $this->layout = '';

    }

    public function popopo3() {

        $update_date =  date("Y-m-d H:i:s");
        $this->updateUserList();
        $this->updateCardList($update_date);
        $this->updateMilestoneList();
        $backlogList = $this->updateBacklogList($update_date);
        // $this->updateListList();   //実行するとリストがダブっちゃうバグあり
	}

    public function testpopo() {

        $test = $this->getListList();

        debug($test);
	}


public function popofinal(){

        $func_update_time = $this->fdc_backlog_lists->find('first',array(
            'fields' => array('fdc_backlog_lists.func_update_time'),
            'order' => array('fdc_backlog_lists.func_update_time desc')
        ));
        $func_update_time_cards = $this->fdc_cards->find('first',array(
            'fields' => array('fdc_cards.update_date'),
            'order' => array('fdc_cards.update_date desc')

        ));

        $cardDetail = $this->getCardDetail($func_update_time_cards['fdc_cards']['update_date']);
        $cardDetailWithHistory = $this->addCardHistory($cardDetail);
        $memberListAndTeam = $this->getMemberListAndTeam();
        $detailByMilestone = $this->getDetailByMilestone($func_update_time['fdc_backlog_lists']['func_update_time']);
        $milestoneOrderById = $this->getMilestoneOrderById();
        $listlist = $this->getListList();

        $this->set('cardDetailWithHistory',$cardDetailWithHistory);
        $this->set('milestoneOrderById',$milestoneOrderById);
        $this->set('detailByMilestone',$detailByMilestone);
        $this->set('memberListAndTeam',$memberListAndTeam);
        $this->set('listlist',$listlist);
        $this->layout = '';


    }
    public function popofb(){

        // $this->autoRender = false;

        $releasedLists =   $this->getInfofromTrelloByCardAfterRelease();
        $keylist = $this->createKeylist();
        $nicknameByid = $this->createNicknameByid();
        $resultFB = array();

        foreach ($releasedLists as $listName => $list) {
            foreach ($list as $key => $card) {
                foreach ($card['idMembers'] as $key => $value) {
                    // debug($nicknameByid[$value]);
                    $resultFB[$listName][$card['name']]['members'][$key] = $nicknameByid[$value];
                }
                $resultFB[$listName][$card['name']]['id'] = $card['id'];
                $historyAll = $this->getCardHistory($card['id']);
                //debug($historyAll);
                foreach ((array)$historyAll as $key => $history) {
                    //"FEEDBACK-FIXING BUG"               => "5b4d4cae168a92088b4817b9",
                    //"FEEDBACK-ADD Spec"                 => "5d425b2a4cff0b55a72702f0" ,
                    if($history['type'] == "updateCard"){

                        if($history['data']['listAfter']['id'] == "5b4d4cae168a92088b4817b9"
                        ||  $history['data']['listAfter']['id'] == "5d425b2a4cff0b55a72702f0" ){
                            $tmp_array = array(
                                "listAfter" => $keylist[$history['data']['listAfter']['id']] ,
                                "listBefore" => $keylist[$history['data']['listBefore']['id']],
                                "date" => $history['date']
                            );
                            $resultFB[$listName][$card['name']]['FBhistory'][] = $tmp_array;
                        }
                    }


                }
                $resultFB[$listName][$card['name']]['count'] = isset($resultFB[$listName][$card['name']]['FBhistory'])?count($resultFB[$listName][$card['name']]['FBhistory']):"0";
                $resultFB[$listName][$card['name']]['color'] = $this->colorbycount($resultFB[$listName][$card['name']]['count']);
            }
        }


        $this->layout = '';
        $this->set('colorList',$this->getColorListforAfterRelease());
        $this->set('resultFB',$resultFB);
        //debug($resultFB);


    }

    public function popomilestone(){
        $this->autoRender = false;
        $backlogList = $this->formatBacklog();


        echo "<table>";
        foreach ($backlogList as $milestone => $tickets) {
            foreach ($tickets as $key => $ticket) {
                echo "<tr>";
                echo '<td>'. $ticket['issueKey'].'</td>';
                echo '<td>'.$milestone.'</td>';
                echo '<td>'. $ticket['assignee']['name'].'</td>';
                echo '<td>'. $ticket['dueDate'].'</td>';

                echo "</tr>";
            }
        }
        echo "</table>";

    }


    public function colorbycount($count){

        if($count == 0){
            $result = "#c1c1c1";
        }elseif ($count == 1) {
            $result = "#ffdcdc";
        }elseif ($count == 2) {
            $result = "#fc8c8c";
        }elseif ($count == 3) {
            $result = "#ef5a5a";
        }else{
            $result = "#ff0f0f";
        }



        return $result;
    }


    public function popohook(){ //TrelloからのWebhookを受け取ってDBに送る関数、カードIDとFrom,toのみ保存しているが、$body内には情報もっとあるので改良すればもっと色々取得可能

        $this->autoRender = false;
        if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_SERVER['HTTP_X_TRELLO_WEBHOOK'])) {
            $body = file_get_contents("php://input");
            if (!empty($body)) {
                $array = json_decode($body);

                if( $array->action->type =='updateCard'){
                    if(!$array->action->data->listAfter->name==NULL){
                        $for_save_webhook = array();
                        $for_save_webhook[0]['fdc_webhook']['card_id'] = $array->action->data->card->id;
                        $for_save_webhook[0]['fdc_webhook']['list_before'] = $array->action->data->listBefore->id;
                        $for_save_webhook[0]['fdc_webhook']['list_after'] = $array->action->data->listAfter->id;
                        $this->fdc_webhook->create();
                        $this->fdc_webhook->saveAll($for_save_webhook);
                    }
                }





                // ... あとはご自由に ...
            }
        }
    }

    public function webhooklog(){ //webhookから取得した情報を表示する関数、IDのままではわからないので、DBからカード名とList情報持ってきてみやすくしている

        $listtmp = $this->fdc_list_list->find('all');
        $listlist = array();
        foreach ($listtmp as $key => $value) {
            $listlist[$value['fdc_list_list']['list_id']] = $value['fdc_list_list']['name'];
        }
        $logtmp = $this->fdc_webhook->find('all',array(
            'limit' => 100
        ));

        $logresult = array();
        foreach ($logtmp as $key => $value) {
            $cardname = $this->fdc_cards->find('first',array(
                'conditions' => array(
                    'card_id' => $value['fdc_webhook']['card_id']
                ),
                'fields' => array(
                    'name'
                )
            ));


            $logresult[$key]['created'] = $value['fdc_webhook']['created'];
            $logresult[$key]['card_name'] = $cardname['fdc_cards']['name'];
            $logresult[$key]['list_before'] = $listlist[$value['fdc_webhook']['list_before']];
            $logresult[$key]['list_after'] = $listlist[$value['fdc_webhook']['list_after']];

        }


        $logresult = array_reverse($logresult);
        $this->set('logresult',$logresult);
        $this->layout = '';

    }

    public function reslpo(){

    }

    public function popomembers(){ //メンバー表示用関数、ページではTeamとニックネームの更新が可能
        $members = $this->fdc_members->find("all");
        $teams = $this->fdc_team->find("all");

        $this->set('teams',$teams);
        $this->set('members',$members);
        $this->layout = '';

    }

    public function memberupdate(){ // popomembersからAjaxで更新された場合にリクエストされるAPI、popomembersからの更新情報をDB保存
        $this->autoRender = false;
        $this->layout = '';

        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $team = $_POST['team'];
            $name = $_POST['name'];

            $data= array(
                'fdc_members' => array(
                    'unique_key' => 29,
                    'id' => $id,
                    'team' => $team,
                    'name' => $name
                )
            );

            $finddata = $this->fdc_members->find('first',array(
                'conditions' => array(
                    'id' => $id
                )
            ));

            $finddata['fdc_members']['nick_name'] = $name;
            $finddata['fdc_members']['team'] = $team;
            $fields = array('team','nick_name');
            var_dump($this->fdc_members->save($finddata, false, $fields));
        }else{
            echo "error_no_post_data";
        }


    }

    public function createKeylist(){
        //リストIDからリスト名を取得する配列生成
        $lists = $this->fdc_list_list->find('all');
        $keyByList = array();
        foreach ($lists as $key => $value) {
          $keylist[$value['fdc_list_list']['list_id']] = $value['fdc_list_list']['name_for_use'];
        }
        return $keylist;
    }

    public function createNicknameByid(){
        //メンバーIDからニックネームを取得する配列生成
        $members = $this->fdc_members->find('all');
        $nicknameByid = array();
        foreach ($members as $key => $value) {
          $nicknameByid[$value['fdc_members']['id']] = $value['fdc_members']['nick_name'];
        }
        return $nicknameByid;
    }

    public function cardhistory($cardID){
        $this->layout = '';
        //$this->autoRender = false;

        //URLとcardIDを使いTrelloへカード履歴を問い合わせ
        $listlist = array();
        $base_url = 'https://api.trello.com/1/cards/';
        $board_ID = TRELLO_BOARD_ID;
        $base_url2 = '/actions?limit=200&';
        $api_key = 'key='.TRELLO_KEY;
        $api_token = '&token='.TRELLO_TOKEN;
        $result = $this->curlRequestomy($base_url.$cardID.$base_url2.$api_key.$api_token);    //debug($result);

        // //リストIDからリスト名を取得する配列生成
        // $lists = $this->fdc_list_list->find('all');
        // $keyByList = array();
        // foreach ($lists as $key => $value) {
        //   $keylist[$value['fdc_list_list']['list_id']] = $value['fdc_list_list']['name_for_use'];
        // }

        $keylist = $this->createKeylist();

        $nicknameByid = $this->createNicknameByid();


        //Cardupdate の履歴のみを抽出して、日付、before/after/変更者を
        $cardHistory = array();
        $i = 0;
        foreach ($result as $key => $action) {
            if($action['type'] == "updateCard"){
                $cardHistory[$i] = array(
                'date' => date('Y-m-d H:i:s',strtotime($action['date'])),
                'listBefore' => $keylist[$action['data']['listBefore']['id']],
                'listAfter' => $keylist[$action['data']['listAfter']['id']],
                'memberid' => $nicknameByid[$action['memberCreator']['id']],
                );
                $i++;
            }
        }


        $countHistory = count($cardHistory);
        foreach ($cardHistory as $key => $value) {
            if($key+1 < $countHistory){
                //debug(date('Y-m-d H:i:s',strtotime($cardHistory[$key]['date']) - strtotime($cardHistory[$key+1]['date']) ));

                //debug($this->time_diff(strtotime($cardHistory[$key + 1]['date']), strtotime($cardHistory[$key]['date']) ));

                $diff = strtotime($cardHistory[$key]['date']) - strtotime($cardHistory[$key + 1]['date']);

            //    debug(date('Y-m-d H:i:s',strtotime($cardHistory[$key]['date'])));
            //    debug(date('Y-m-d H:i:s',strtotime($cardHistory[$key +1]['date'])));

                $datediff = (date("d",
                    (floor(strtotime($cardHistory[$key]['date']) / 86400 ) * 86400)
                    - (floor(strtotime($cardHistory[$key + 1]['date']) / 86400 ) * 86400 )
                    ));

                if($datediff > 0){ // datediff が1日ある場合は 15時間をマイナスする (24時間 - 勤務 9時間)
                     $actualTimediff = $diff - $datediff;
                     //debug($actualTimediff);
                }

                if($datediff >= 3){ //3日以上ある場合は

                }

                $hour =floor($diff / 3600);
                $min = str_pad(floor(($diff - ($hour * 3600)) / 60), 2, 0, STR_PAD_LEFT);
                $sec = str_pad(floor($diff - ($hour * 3600) - ($min * 60)),2,0,STR_PAD_LEFT);
                $cardHistory[$key+1]['timediff'] = $hour.':'.$min.':'.$sec;
                $cardHistory[$key+1]['datediff'] = $datediff - 1;


            }else{

            }
        }


        //debug($cardHistory);
        $this->set('cardHistory',$cardHistory);
        $this->set('cardName',$result[0]['data']['card']['name']);
    }


    public function getCardHistory($cardID){
        //URLとcardIDを使いTrelloへカード履歴を問い合わせ
        $listlist = array();
        $base_url = 'https://api.trello.com/1/cards/';
        $board_ID = TRELLO_BOARD_ID;
        $base_url2 = '/actions?limit=200&';
        $api_key = 'key='.TRELLO_KEY;
        $api_token = '&token='.TRELLO_TOKEN;
        $result = $this->curlRequestomy($base_url.$cardID.$base_url2.$api_key.$api_token);
        return $result;
    }



    public function cardhistory2($cardID){
        $this->layout = '';

        $result = $this->getCardHistory($cardID);

        //リストIDからリスト名を取得する配列生成
        $lists = $this->fdc_list_list->find('all');
        $keyByList = array();
        $sumOfList = array();


        foreach ($lists as $key => $value) {
          $keylist[$value['fdc_list_list']['list_id']] = $value['fdc_list_list']['name'];
          $sumOfList[$value['fdc_list_list']['name']]["msec"] = 0;
          $sumOfList[$value['fdc_list_list']['name']]["classname"] = "C-" .$value['fdc_list_list']['list_id'];
        // debug($value);
        }
        //メンバーIDからニックネームを取得する配列生成
        $members = $this->fdc_members->find('all');
        $nicknameByid = array();
        foreach ($members as $key => $value) {
          $nicknameByid[$value['fdc_members']['id']] = $value['fdc_members']['nick_name'];
        }


        //Cardupdate の履歴のみを抽出して、日付、before/after/変更者を
        $cardHistory = array();
        $i = 0;
        foreach ($result as $key => $action) {
            if($action['type'] == "updateCard"){
    //            debug($action);

                $cardHistory[$i] = array(
                'date' => date('Y-m-d H:i:s',strtotime($action['date'])),
                'listBefore' => $keylist[$action['data']['listBefore']['id']],
                'listAfter' => $keylist[$action['data']['listAfter']['id']],
                'memberid' => $nicknameByid[$action['memberCreator']['id']],
                'class' => "C-".$action['data']['listAfter']['id'],
                );
                $i++;
            }
        }


        $countHistory = count($cardHistory);

        foreach ($cardHistory as $key => $value) {
            if($key+1 < $countHistory){
                $diff = strtotime($cardHistory[$key]['date']) - strtotime($cardHistory[$key + 1]['date']);
                $datediff = (date("d",
                    (floor(strtotime($cardHistory[$key]['date']) / 86400 ) * 86400)
                    - (floor(strtotime($cardHistory[$key + 1]['date']) / 86400 ) * 86400 )
                    ));
                if($datediff > 1){ // datediff が1日ある場合は 15時間をマイナスする (24時間 - 勤務 9時間)
                    $actualTimediff = $diff - (($datediff-1) * 3600 * 15);
                }else{
                    $actualTimediff = $diff;
                }


                if($datediff > 3){ //3日以上ある場合に土日見る処理入れる
                    $end = strtotime($cardHistory[$key]['date']);
                    $start = strtotime($cardHistory[$key +1 ]['date']);
                    $holidaycount = 0;
                    for($i = $start ; $i < $end ; $i = $i + (3600 * 24) ){
                        $checkweek = date("w",$i);
                        // debug(date("w",$i));
                        if($checkweek == "0" || $checkweek == "6"){
                            $actualTimediff = $actualTimediff - (3600 * 9);
                        }
                    }
                }

                $sumOfList[$cardHistory[$key+1]['listAfter']]["msec"] = $sumOfList[$cardHistory[$key+1]['listAfter']]["msec"] + $actualTimediff;
                $actualTimediff = $this->msecTotime($actualTimediff);
                $cardHistory[$key+1]['timediff'] = $this->msecTotime($diff);
                $cardHistory[$key+1]['datediff'] = $datediff - 1;
                $cardHistory[$key+1]['actualTimediff'] = $actualTimediff;
            }
        }

        $result_sum['dev-time']['msec'] = 0;
        $result_sum['tester-time']['msec'] = 0;
        $result_sum['GGPE-time']['msec'] = 0;
        $result_sum['dev-waiting-time']['msec'] = 0;
        $result_sum['tester-waiting-time']['msec'] = 0;
        $result_sum['other']['msec'] = 0;


        //将来的にlist_listsに開発者、テスター、BEの担当を持たせてそこで色分けする
        foreach ($sumOfList as $key => $value) {
            $sumOfList[$key]['time'] = $this->msecTotime($value["msec"]);

            // switch ($key) {
            //     case 'RELEASE-WAITING':
            //     case 'DEV-ONGOING':
            //     case 'FEEDBACK-FIX':
            //         $result_sum['dev-time']['msec'] = $result_sum['dev-time']['msec'] + $value["msec"];
            //         break;
            //
            //     case 'TESTCACE-IN-PROGRESS':
            //     case 'TEST-ONGOING':
            //     case 'STG-TESTING':
            //         $result_sum['tester-time']['msec'] = $result_sum['tester-time']['msec'] + $value["msec"];
            //         break;
            //     case 'GGPE-TEST':
            //         $result_sum['GGPE-time']['msec'] = $result_sum['GGPE-time']['msec'] + $value["msec"];
            //         break;
            //
            //     case 'TASK':
            //     case 'STG-WAITING':
            //         $result_sum['dev-waiting-time']['msec'] = $result_sum['dev-waiting-time']['msec'] + $value["msec"];
            //         break;
            //
            //     case "TESTCACE-WAITING":
            //     case "TEST-WAITING":
            //     case "STG-RELEASED":
            //         $result_sum['tester-waiting-time']['msec'] = $result_sum['tester-waiting-time']['msec'] + $value["msec"];
            //         break;
            //     default:
            //         $result_sum['other']['msec'] = $result_sum['other']['msec'] + $value["msec"];
            //         break;
            // }

            switch ($value['classname']) {
                //dev
                case 'C-5d651100e4a7124bd92b1aca': // Developer DB/API Design
                case 'C-5d6511583e5e402eb9778e26': // ONGOING-DEV iOS
                case 'C-5d65e334f1187d2a0a73ad46': // ONGOING-DEV Android
                case 'C-5b4d4c5ba209bce449d15877': // ONGOING-DEV PHP
                case 'C-5b4d4cae168a92088b4817b9': // FEEDBACK - FIXING BUG
                case 'C-5d425b2a4cff0b55a72702f0': // FEEDBACK - ADD Spec
                case 'C-5b4d4cd34877ca1013784f43': // FOR RELEASE - STAGING
                case 'C-5b4d4d851cd8e30871de21aa': // FOR RELEASE - PRODUCTION
                    $result_sum['dev-time']['msec'] = $result_sum['dev-time']['msec'] + $value["msec"];
                    break;

                case 'C-5b4d4ca1281ef5370d4d699e': // ON TEST - DEV
                case 'C-5b4d4d5d61a48f0891d5ebe9': // ON TEST - STAGING
                    $result_sum['tester-time']['msec'] = $result_sum['tester-time']['msec'] + $value["msec"];
                    break;

                case 'C-5b4d4cc5f972bd78428555df': // GGPEI TEST - DEV
                    $result_sum['GGPE-time']['msec'] = $result_sum['GGPE-time']['msec'] + $value["msec"];
                    break;

                default:
                    $result_sum['other']['msec'] = $result_sum['other']['msec'] + $value["msec"];
                    break;
            }






        }
        foreach ($result_sum as $key => $value) {
            $result_sum[$key]['time'] = $this->msecTotime($value['msec']);
        }

        $this->set('sumOfList',$sumOfList);
        $this->set('result_sum',$result_sum);
        $this->set('cardHistory',$cardHistory);
        $this->set('cardName',$result[0]['data']['card']['name']);
    }



    private function msecTotime($msec){
        $hour =floor($msec / 3600);
        $min = str_pad(floor(($msec - ($hour * 3600)) / 60), 2, 0, STR_PAD_LEFT);
        $sec = str_pad(floor($msec - ($hour * 3600) - ($min * 60)),2,0,STR_PAD_LEFT);
        $result = $hour.':'.$min.':'.$sec;
        return $result;
    }




    public function performancecheck($memberID){
        //$this->autoRender = false;
        $this->layout = '';

        $tmp = $this->getcardsfromtrello($memberID);
        debug($tmp);


        $lists = $this->fdc_list_list->find('all');
    //    debug($lists);
        $keyByList = array();
        foreach ($lists as $key => $value) {
            $keylist[$value['fdc_list_list']['list_id']] = $value['fdc_list_list']['name'];
        }



        foreach ($tmp as $key => $cards) {
            echo '<div>';
            echo $keylist[$cards['idList']].'   ';
            echo $cards['name'];
            echo '</div>';
        }




    }

    private function getcardsfromtrello($memberID){

        $listlist = array();
        $base_url = 'https://api.trello.com/1/members/';
        $board_ID = TRELLO_BOARD_ID;
        $base_url2 = '/cards?filter=visible&';
        $api_key = 'key='.TRELLO_KEY;
        $api_token = '&token='.TRELLO_TOKEN;
        $result = $this->curlRequestomy($base_url.$memberID.$base_url2.$api_key.$api_token);

        return $result;


    }

    public function members($memberHash){
        $temp = $this->fdc_cards->find('all',array(
            'conditions' => array(
                'OR' => array(
                    'idMembers0' => $memberHash,
                    'idMembers1' => $memberHash,
                    'idMembers2' => $memberHash,
                    'idMembers3' => $memberHash,
                    'idMembers4' => $memberHash,
                    'idMembers5' => $memberHash,
                    'idMembers6' => $memberHash,
                    'idMembers7' => $memberHash,
                    'idMembers8' => $memberHash,
                    'idMembers9' => $memberHash,
                    'idMembers10' => $memberHash
                )
            )
        ));
        // debug($temp);
        $listlist = $this->getListList();
        foreach ($temp as $key => $value) {
           $result[$value['fdc_cards']['name']][$value['fdc_cards']['update_date']]['id'] = $value['fdc_cards']['idList'];
           $result[$value['fdc_cards']['name']][$value['fdc_cards']['update_date']]['name'] = $listlist[$value['fdc_cards']['idList']]['name'];
           // $update_date_list[$value['fdc_cards']['update_date']] = 0;
        }

        $memberListAndTeam = $this->getMemberListAndTeam();

        $update_date_list = $this->getUpdateList(50);
        $memberListAndTeam = $this->getMemberListAndTeam();


        $this->set('memberListAndTeam',$memberListAndTeam);
        $this->set('listlist',$listlist);
        $this->set('update_date_list',$update_date_list);


        $this->set('membername',$memberListAndTeam[$memberHash]['name']);
        $this->set('result',$result);
        $this->layout = '';


    }

    private function getUpdateList($limit){
        $temp2 = $this->fdc_cards->find('all',array(
            'fields' => array(
                'DISTINCT fdc_cards.update_date'
            ),
            'limit' => $limit,
            'order' => array('fdc_cards.update_date' => 'desc')
        ));
        foreach ($temp2 as $key => $value) {
            $update_date_list[$key] = $value['fdc_cards']['update_date'];
        }
        return $update_date_list;
    }

    private function updateListList(){
        $listlist = array();
        $base_url = 'https://api.trello.com/1/boards/';
        $board_ID = TRELLO_BOARD_ID;
        $base_url2 = '/lists?';
        $api_key = 'key='.TRELLO_KEY;
        $api_token = '&token='.TRELLO_TOKEN;
        $result = $this->curlRequestomy($base_url.$board_ID.$base_url2.$api_key.$api_token);

        // debug($result);
        return $result;
        // $current_lists = $this->fdc_list_list->find("all");
        //
        // // debug($current_lists);
        //
        //
        //
        // $forListList = array();
        //
        // foreach ($result as $key => $value) {
        //
        //     $addflg = true;
        //     foreach ($current_lists as $key2 => $current_list) {
        //         if($current_list['fdc_list_list']['list_id'] == $value['id'] ){
        //             $addflg = false;
        //         }
        //     }
        //
        //     if($addflg){
        //         $forListList[$key]['fdc_list_list']['list_id'] = $value['id'];
        //         $forListList[$key]['fdc_list_list']['name'] = $value['name'];
        //         $forListList[$key]['fdc_list_list']['closed'] = $value['closed'];
        //         $forListList[$key]['fdc_list_list']['id_board'] = $value['idBoard'];
        //         $forListList[$key]['fdc_list_list']['pos'] = $value['pos'];
        //         $forListList[$key]['fdc_list_list']['subscribed'] = $value['subscribed'];
        //     }
        // }

        // $this->fdc_list_list->create();
        // $this->fdc_list_list->saveAll($forListList);

    }

    private function getListList(){
        $resulttmp = $this->fdc_list_list->find('all');
        $result = array();
        foreach ($resulttmp as $key => $value) {
            $result[$value['fdc_list_list']['list_id']]['name'] = $value['fdc_list_list']['name'];
            $result[$value['fdc_list_list']['list_id']]['name_for_use'] = $value['fdc_list_list']['name_for_use'];
        }
        return $result;

    }

    private function getMemberListAndTeam(){
        $temp = $this->fdc_members->find('all',array());
        foreach ($temp as $key => $value) {
            $result[$value['fdc_members']['id']] = array(
                'name' => $value['fdc_members']['nick_name'],
                'team' => $value['fdc_members']['team']
            );
        }
        //debug($result);
        return $result;
    }

    private function addCardHistory($cardDetail){

        foreach ($cardDetail as $key => $value) {
        //    debug($value['fdc_cards']['card_id']);
            $history = $this->fdc_cards->find('all',array(
                'conditions' => array(
                    'card_id' => $value['card_id']
                ),
                'fields' => array(
                    'update_date',
                    'idList',
                ),
                'limit' => 50,
                'order' => array(
                    'fdc_cards.update_date' => 'desc'
                ),
            ));
            $cardDetail[$key]['history'] = $history;
        }
       //debug($cardDetail);
        return $cardDetail;
    }

    private function getCardDetail($func_update_time_cards){
        $resulttmp = $this->fdc_cards->find('all',array(
            // 'fields' => array('fdc_cards.update_date')
            'conditions' => array(
                'update_date' => $func_update_time_cards
            )
        ));
        foreach ($resulttmp as $key => $value) {
            $result[substr($value['fdc_cards']['name'],0,7)] = $value['fdc_cards'];
            // debug($value);
            $members = array();
            for ($i=0; $i <= 10 ; $i++) {
                if($value['fdc_cards']['idMembers'.$i]){
                    $members[$i] = $value['fdc_cards']['idMembers'.$i];
                    unset($result[substr($value['fdc_cards']['name'],0,7)]['idMembers'.$i]);
                }
            }
            $result[substr($value['fdc_cards']['name'],0,7)]['members'] = $members;
        }
        return $result;
    }

    private function getMilestoneOrderById(){
        $milestoneNameList = $this->fdc_milestones->find('all');
        // debug($milestoneNameList);
        $result = array();
        foreach ($milestoneNameList as $key => $value) {
            $result[$value['fdc_milestones']['id']]['order'] = $value['fdc_milestones']['displayOrder'];
            $result[$value['fdc_milestones']['id']]['name'] = $value['fdc_milestones']['name'];

        }
        return $result;
    }

    private function getDetailByMilestone($func_update_time){
        $result = array();
        $fields = array(
            'DISTINCT fdc_backlog_lists.milestone',
        );
        $conditions = array(
            'func_update_time' => $func_update_time
        );
        $milestoneNameList = $this->fdc_milestones->find('all',array(
            'order' => 'displayOrder asc'
        ));
        $milestoneTrance = array();
        foreach ($milestoneNameList as $key => $value) {
            $milestoneTrance[$value['fdc_milestones']['id']] = $value['fdc_milestones']['name'] ;
        }
        foreach ($milestoneNameList as $key => $value) {
            // debug($value['fdc_milestones']['id']);
            $countByMilestones = $this->fdc_backlog_lists->find('count',array(
                'conditions' => array(
                    'func_update_time' => $func_update_time,
                    'milestone' => $value['fdc_milestones']['id']
                )
            ));
            $ticketInfo = array();
            $ticketInfo = $this->fdc_backlog_lists->find('all',array(
                'conditions' => array(
                    'func_update_time' => $func_update_time,
                    'milestone' => $milestoneNameList[$key]['fdc_milestones']['id']
                )
            ));
            $ticketHistory = array();
            if(!empty($ticketInfo)){
                foreach ($ticketInfo as $key2 => $value2) {
                    $ticketDetail[$value2['fdc_backlog_lists']['issueKey']] = $value2['fdc_backlog_lists'];
                    $ticketHistoryTmp = $this->fdc_backlog_lists->find(
                        'all',array(
                            'conditions' => array(
                                'issueKey' => $value2['fdc_backlog_lists']['issueKey']
                            ),
                            'order' => array(
                                'fdc_backlog_lists.func_update_time' => 'desc'
                            ),
                            'limit' => 100
                        )
                    );
                    if(!empty($ticketHistoryTmp)){
                        foreach ($ticketHistoryTmp as $key3 => $value3) {
                            $ticketHistory[$value3['fdc_backlog_lists']['func_update_time']] = $value3['fdc_backlog_lists']['milestone'];
                        }
                    }

                    $ticketDetail[$value2['fdc_backlog_lists']['issueKey']]['history'] = $ticketHistory;
                }
            }else{
                $ticketDetail = array();
            }
            $result[$milestoneTrance[$milestoneNameList[$key]['fdc_milestones']['id']]] = array(
                'count' => $countByMilestones,
                'milestone_id' => $milestoneNameList[$key]['fdc_milestones']['id'],
                'tickets' => $ticketDetail
            );
            $ticketDetail = array();

        }
        return $result;
    }

    private function updateBacklogList($funcUpdateTime){
        $backlogList = $this->formatBacklog();
        $for_backlog_list = array();
        // $funcUpdateTime =  date("Y-m-d H:i:s");
        $i=0;
        foreach ($backlogList as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $for_backlog_list[$i]['fdc_backlog_lists']['func_update_time'] = $funcUpdateTime;
                $for_backlog_list[$i]['fdc_backlog_lists']['description'] = '';
                $for_backlog_list[$i]['fdc_backlog_lists']['issueKey'] = $value2['issueKey'];
                $for_backlog_list[$i]['fdc_backlog_lists']['issue_type'] = $value2['issueType']['name'];
                $for_backlog_list[$i]['fdc_backlog_lists']['summary'] = $value2['summary'];
                $for_backlog_list[$i]['fdc_backlog_lists']['priority'] = $value2['priority']['name'];
                $for_backlog_list[$i]['fdc_backlog_lists']['status'] = $value2['status']['name'];
                $for_backlog_list[$i]['fdc_backlog_lists']['assignee'] = $value2['assignee']['name'];
                $for_backlog_list[$i]['fdc_backlog_lists']['milestone'] = $value2['milestone'][0]['id'];
                $for_backlog_list[$i]['fdc_backlog_lists']['dueDate'] = $this->remmoveTZfromDate($value2['dueDate']);
                $for_backlog_list[$i]['fdc_backlog_lists']['createdUser'] = $value2['createdUser']['name'];
                $for_backlog_list[$i]['fdc_backlog_lists']['created'] = $this->remmoveTZfromDate($value2['created']);
                $for_backlog_list[$i]['fdc_backlog_lists']['updatedUser'] = $value2['updatedUser']['name'];
                $for_backlog_list[$i]['fdc_backlog_lists']['updated'] = $this->remmoveTZfromDate($value2['updated']);
                $j = 0;
                foreach ($value2['category'] as $key3 => $value3) {
                        $for_backlog_list[$i]['fdc_backlog_lists']['category'.$j.'_id'] = $value3['id'];
                        $for_backlog_list[$i]['fdc_backlog_lists']['category'.$j.'_name'] = $value3['name'];
                        $j++;
                }
                $i++;
            }
        }
        $this->fdc_backlog_lists->create();
        $this->fdc_backlog_lists->saveAll($for_backlog_list);

        return $for_backlog_list;


    }

    private function remmoveTZfromDate($value){

        $result = substr($value,0,10).' '.substr($value,11,8);
        if ($result == ' '){
            $result = NULL;
        };


        return $result;
    }

    private function updateMilestoneList(){
        $milestone_list = $this->getMilestoneList();
        // debug($milestone_list);
        $for_milestone_list = array();

        foreach ($milestone_list as $key => $value) {
            $for_milestone_list[$key]['fdc_milestones'] = $value;
        }


        $this->fdc_milestones->create();
        $this->fdc_milestones->saveAll($for_milestone_list);


    }

    private function updateCardList($update_date){
        $result_cards_list = $this->getCardListFromTrello();
        $for_save_cards_list = array();
        foreach ($result_cards_list as $key => $value) {
            $for_save_cards_list[$key]['fdc_cards']['update_date'] = $update_date;
            $for_save_cards_list[$key]['fdc_cards']['card_id'] = $value['id'];
            $for_save_cards_list[$key]['fdc_cards']['idList'] = $value['idList'];
            $for_save_cards_list[$key]['fdc_cards']['name'] = $value['name'];
            $for_save_cards_list[$key]['fdc_cards']['shortUrl'] = $value['shortUrl'];
            if(array_key_exists('due',$value)){
                if($value['due']){
                    $for_save_cards_list[$key]['fdc_cards']['due'] = substr($value['due'],0,10).' '.substr($value['due'],11,8);
                }
            }
            if ($value['idMembers']){
                foreach ($value['idMembers'] as $key2 => $value2) {
                    $for_save_cards_list[$key]['fdc_cards']['idMembers'.$key2] = $value2;
                }
            }
        }
        $this->fdc_cards->create();
        $this->fdc_cards->saveAll($for_save_cards_list);
    }

    private function getCardListFromTrello(){
        $base_url = 'https://api.trello.com/1/boards/';
        $board_ID = TRELLO_BOARD_ID;
        $base_url2 = '/cards/?';
        $api_key = 'key='.TRELLO_KEY;
        $api_token = '&token='.TRELLO_TOKEN;
        $result_cards_list = $this->curlRequestomy($base_url.$board_ID.$base_url2.$api_key.$api_token);
        return $result_cards_list;
    }

    private function updateUserList(){
        $result_member_list = $this->getMemberlistFromTrello();
        $currentmembers = $this->fdc_members->find('all');

        $for_save_member_list = array();
        foreach ($result_member_list as $key => $value) {
            $for_save_member_list[$key]['fdc_members'] = $value;


            //$for_save_member_list[$key]['fdc_members']['nick_name'] = $for_save_member_list[$key]['fdc_members']['fullName'];
        }
        $this->fdc_members->create();
        $this->fdc_members->saveAll($for_save_member_list);
    }

    private function getMemberlistFromTrello(){
        $base_url = 'https://api.trello.com/1/boards/';
        $base_url2 = '/members?';
        $api_key = 'key='.TRELLO_KEY;
        $api_token = '&token='.TRELLO_TOKEN;
        $board_ID = TRELLO_BOARD_ID;
        $result_member_list = $this->curlRequestomy($base_url.$board_ID.$base_url2.$api_key.$api_token);
        return $result_member_list;
    }

    private function getTrelloinfo($issueKey,$resultByTrello){
        $result = '';
        $result['idBoard']['color'] = '#fff';
        $result['idBoard']['listName'] = '-';
        $result['due']['color'] = '#fff';
        $result['due']['due'] = '-';
        foreach ($resultByTrello as $key => $value) {
            if($issueKey == $key){
                $result = $value;
            }
        }
        return $result;
    }

    private function perthFixByList($fixByList){
        foreach ($fixByList as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if($value2['due']['due'] == ''){
                    // debug($value2);

                    if($value2['idBoard']['listName'] == 'TODO' or $value2['idBoard']['listName'] == 'TASK'){
                    }else{
                        $infoByDate['dueBlank'][$value2['card_name']] = array(
                            'name' => $value2['card_name'],
                            'listname' => $key,
                            'categoryColor' => $this->addListColor($key)
                        );
                    }
                }else{
                    $infoByDate[$value2['due']['due']][$value2['card_name']] = array(
                        'name' => $value2['card_name'],
                        'listname' => $key,
                        'categoryColor' => $this->addListColor($key)
                    );
                }
            }

        }
        return $infoByDate;
    }

    private function getMilestoneCategory($categoryList){
        $result = '';
        foreach ($categoryList as $key => $value) {
            $result[$key] = $value['name'];
        }
        return $result;
    }

    private function getDayList(){
        $dayList = array();
        for ($i=0; $i < 10 ; $i++) {
            if($i==0){
                $dayList[date("m-d", strtotime('-1 day'))] = date("m-d", strtotime('-1 day')); // 昨日の日付
            }elseif ($i == 1) {
                $dayList[date("m-d")] = date("m-d");
            }else{
                $dayList[date("m-d", strtotime('+'.($i-1).'day'))] = date("m-d", strtotime('+'.($i-1).'day')); // 翌日以降の日付
            }
        }
        return $dayList;
    }

    public function fixByList(){
        $test = $this->getInfofromTrelloByCard();
        $tmp_array = array();
        $result = array();


        $idList = $this->makeIDList();


//debug($idList);
//debug($test);

        foreach ($test as $keyByList => $valueByList) {
            foreach ($valueByList as $key => $value) {



                $tmp_array[$idList[$value['idList']]][$value['name']]['card_name'] = $value['name'];
                $tmp_array[$idList[$value['idList']]][$value['name']]['due'] = $this->adjustmentTimeZone($value['due'],date("Y-m-d"));
                $tmp_array[$idList[$value['idList']]][$value['name']]['idMembers'] = $value['idMembers'];
                $tmp_array[$idList[$value['idList']]][$value['name']]['shortUrl'] = $value['shortUrl'];
                $tmp_array[$idList[$value['idList']]][$value['name']]['shortUrl'] = 'http://tomitomiclub.com/shogi/fdcsys/cardhistory2/'.$value['id'];

                $tmp_array[$idList[$value['idList']]][$value['name']]['idBoard'] = array(
                    'listName' => $idList[$value['idList']],
                    'color'    => $this->addListColor($idList[$value['idList']])

                );
            }
        }
        //debug($tmp_array);
        return $tmp_array;
    }

    function adjustmentTimeZone($timeFromTrello,$today){
        $result = array(
            'due' => '',
            'color' => ''
        );
        if($timeFromTrello){
            // return left($timeFromTrello,10) ;
            $time1 = strtotime(substr($timeFromTrello,0,10).' '.substr($timeFromTrello,12,10));
            $tmp = strtotime('+8 hour' , $time1);
            $time2 = strtotime($today);
            $diff = $tmp - $time2;
            if($diff == ''){
            $color = '' ;
            }elseif($diff > 43200){
            $color = '#90ffbe' ;
            }elseif($diff <= 43200 && $diff >= 0){
                $color = '#ff9090' ;
            }elseif($diff < 0){
                $color = '#ff0404' ;
            }else{
                $color = '';
            }
            $result = array(
                'due' => date('m-d',$tmp),
                'color' => $color
            );
        }
        return $result;
    }

    private function getInfofromTrelloByCard(){
        $result = '';
        $base_url = 'https://trello.com/1/lists/';
        $base_url2 = '/cards?';
        $api_key = 'key='.TRELLO_KEY;
        $api_token = '&token='.TRELLO_TOKEN;


        $this->updateListList();
        $lists =    $this->fdc_list_list->find("all",array(
            "fields" => array(
                "list_id","name","name"
            ),
            "order" => array("pos asc")
        ));

        $list = array();
        foreach ($lists as $key => $value) {
            $list[$value['fdc_list_list']['name']] = $value['fdc_list_list']['list_id'];
        }

        foreach ($list as $key => $value) {
            $result[$key] = $this->curlRequestomy($base_url.$value.$base_url2.$api_key.$api_token);
        }

        return $result;

    }


    private function getInfofromTrelloByCardAfterRelease(){
        $result = '';
        $base_url = 'https://trello.com/1/lists/';
        $base_url2 = '/cards?';
        $api_key = 'key='.TRELLO_KEY;
        $api_token = '&token='.TRELLO_TOKEN;
        $list = array(
            "RELEASED-PRODUCTION"               => "5b4d4d9342a723f457e34c7c",
            "REPORTED - BACKLOG"                => "5c9096f9ca0e3f6de327d98d",
            "ROLLEDBACK-INVESTIGATING"          => "5c36f5a51aafef03db35fb85",
            "CLOSED"                            => "5b4d4d99a68f925adbb85223",
        );
        foreach ($list as $key => $value) {
            $result[$key] = $this->curlRequestomy($base_url.$value.$base_url2.$api_key.$api_token);
        }
        return $result;

    }
    private function getColorListforAfterRelease(){
        $list = array(
            "RELEASED-PRODUCTION"               => "ff8f42",
            "REPORTED - BACKLOG"                => "8c8c8c",
            "ROLLEDBACK-INVESTIGATING"          => "8c8c8c",
            "CLOSED"                            => "8c8c8c"
        );
        return $list;
    }


    private function curlRequestomy($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

        $response = curl_exec($curl);
        // if you want to use it -> json_decode($response, true);
        $response = json_decode($response, true);

        curl_close($curl);
        return $response;

    }

    function getmemberName($hash){




        $membersList = array();
        $memberList = $this->fdc_members->find('first',array(
            'conditions' => array('id' => $hash)
        ));
        return $memberList['fdc_members']['nick_name'];

    }

    function getMemberlist(){

        $memberList = array();

        $teamlist = $this->fdc_team->find('all');
        $members = $this->fdc_members->find('all');

        foreach ($teamlist as $key => $value) {
            foreach ($members as $key2 => $value2) {
                if($value2['fdc_members']['team'] == $value['fdc_team']['id'] ){
                    $memberList[$value['fdc_team']['name']][$value2['fdc_members']['nick_name']] = $value2['fdc_members']['id'];
                }
            }
        }

        return $memberList;
    }


    function makeIDList(){


        $listlists =  $this->updateListList();
    //    debug($listlists);

        $result = array();
        foreach ($listlists as $key => $value) {
            $result[$value['id']] = $value['name'];
        }



        return $result;


    }




    function getIdList($id){

        // 　リストが変更された時はここをつかう
        // $list_list = $this->fdc_list_list->find("all");
        // $list =array();
        // foreach ($list_list as $key => $value) {
        //     $list[$value['fdc_list_list']['list_id']] = $value['fdc_list_list']['name_for_use'];
        // }
        // debug($list);


        $list = array(
            '5d8c82903e29165a9930c001' => 'Automation1' ,
            '5d8c828d40ef3d59b1bdc45c' => 'Automation2' ,
            '5c9096f9ca0e3f6de327d98d' => 'Reported backlog',
            '5b4d4d99a68f925adbb85223' => 'CLOSED',

            '5d650f5097c68c074c0af74b' => 'BE check requirement + make slack thread + BE DL set' ,
            '5d651001a7488f806c789930' => 'BE requirement clarify to GGPE if needed' ,
            '5d651039a1d0dc6965fea359' => 'BE making spec' ,
            '5d65104d1458f304ba8b9766' => 'BE waiting for stamp' ,
            '5d651091c7eb0f41173d1a24' => 'BE waiting for Tokyo UI design' ,
            '5d6510a8e0de835c3c354f0c' => 'Fred developer assign PHP' ,
            '5d6510b643e32638ac87bc67' => 'Fred developer assign iOS' ,
            '5d65e3571a1b4107986a1b03' => 'Fred developer assign Android' ,
            '5d6510c7a1aec33eb7401d77' => 'Marj tester assign' ,
            '5d6510e2dac04f3f6f927a35' => 'yamaaki write backlog' ,
            '5d651100e4a7124bd92b1aca' => 'Developer DB/API Design' ,
            '5d65110c9d869a150c713e07' => 'Park DB/API design review' ,
            '5d651139b6b4347b23e80020' => 'Fred dev DL set' ,
            '5d651147dbb81e6af331488d' => 'Marj test DL set' ,
            '5d4250541521f552074ab779' => 'TASKS - IOS' ,
            '5d6511583e5e402eb9778e26' => 'ONGOING-DEV iOS' ,
            '5d65e334f1187d2a0a73ad46' => 'ONGOING-DEV Android' ,
            '5d4a0eb3e06c9f74168a9d9e' => 'PARENT TICKET(NO DEVELOP NEEDED)' ,
            '5b4d4c457c73ecf308842895' => 'Aki before assign(new)' ,
            '5b4d4c4d596cd4d00bdd5321' => 'TASKS - Main Job OF BE' ,
            '5b4d4c5ba209bce449d15877' => 'ONGOING-DEV PHP' ,
            '5c0746f07504186070af4f0a' => 'ONGOING but pending' ,
            '5b4d4cae168a92088b4817b9' => 'FEEDBACK - FIXING BUG' ,
            '5d425b2a4cff0b55a72702f0' => 'FEEDBACK - ADD Spec' ,
            '5bbc0458b92ef309981e8685' => 'PARK_CODE_REVIEW' ,
            '5b4d4fa071efa46b72f92e18' => 'FOR TESTING - DEV' ,
            '5b4d4ca1281ef5370d4d699e' => 'ON TEST - DEV' ,
            '5b4d4cb695d1ad087452739c' => 'FINAL TEST - DEV' ,
            '5b4d4cc5f972bd78428555df' => 'GGPEI TEST - DEV' ,
            '5b5ef37b2ded8753eee24107' => 'BE Adjust Release' ,
            '5b4d4cd34877ca1013784f43' => 'FOR RELEASE - STAGING' ,
            '5b4d4d55ec5938f2a7b36fbc' => 'RELEASED - STAGING' ,
            '5b4d4d5d61a48f0891d5ebe9' => 'ON TEST - STAGING' ,
            '5b4d4d7705e106519935138c' => 'DONE - STAGING - WT RELEASE TO LIVE' ,
            '5b4d4d851cd8e30871de21aa' => 'FOR RELEASE - PRODUCTION' ,
            '5b4d4d9342a723f457e34c7c' => 'RELEASED - PRODUCTION' ,
            '5c36f5a51aafef03db35fb85' => 'ROLLEDBACK - INVESTIGATING' ,
            '5c0748dea5d3d839a23db64a' => 'TEST CASE - WAITING' ,
            '5c074cd16ece435304d95df1' => 'TEST CASE - FOR REVIEW' ,
            '5c0746a95e7301133ff5188b' => 'TEST CASE - IN PROGRESS (1 DAY OR LESS)'
        );
        return $list[$id];
    }

    function addListColor($list){
        switch ($list) {
            case "PARENT TICKET(NO DEVELOP NEEDED)" :
            case "Aki before assign(new)" :
                $color ='#8c8c8c';
                break;

            case "BE check requirement + make slack thread + BE DL set" :
            case "BE requirement clarify to GGPE if needed" :
            case "BE making spec" :
            case "BE waiting for stamp" :
            case "BE waiting for Tokyo UI design" :
            case "Fred developer assign PHP" :
            case "Fred developer assign iOS" :
            case "Fred developer assign Android" :
            case "Marj tester assign" :
            case "yamaaki write backlog" :
            case "Developer DB/API Design" :
            case "Park DB/API design review" :
            case "Fred dev DL set" :
            case "Marj test DL set" :
                $color ='#8ccaef';
                break;

            case "TASKS - Main Job OF BE" :
            case "TASKS - IOS" :
                $color = '#7e94ff';
                break;

            case "ONGOING-DEV PHP" :
            case "ONGOING-DEV iOS" :
            case "ONGOING-DEV Android" :
                $color = '#5a8dff';
                break;

            case "ONGOING but pending" :
                $color = '#6277a6';
                break;


            case "FEEDBACK - FIXING BUG" :
            case "FEEDBACK - ADD Spec" :
                $color = '#ff7ad0';
                break;

            case "PARK_CODE_REVIEW" :
                $color = '#ba7aff';
                break;

            case "FOR TESTING - DEV" :
            case "ON TEST - DEV" :
                $color = '#ff7ad0';
                break;

            case "FINAL TEST - DEV" :
                $color = '#ba7aff';
                break;

            case "GGPEI TEST - DEV" :
                $color = '#ffff99';
                break;

            case "BE Adjust Release" :
                $color = '#dfccf3';
                break;

            case "FOR RELEASE - STAGING" :
                $color = '#307d03';
                break;

            case "RELEASED - STAGING" :
                $color = '#307d03';
                break;

            case "ON TEST - STAGING" :
            case "DONE - STAGING - WT RELEASE TO LIVE" :
                $color = '#307d03';
                break;

            case "FOR RELEASE - PRODUCTION" :
            case "RELEASED - PRODUCTION" :
                $color = '#ff8f42';
                break;

            case "ROLLEDBACK - INVESTIGATING" :
                $color = '#9e9e9e';
                break;

            case "TEST CASE - WAITING" :
            case "TEST CASE - FOR REVIEW" :
            case "TEST CASE - IN PROGRESS (1 DAY OR LESS)" :
                $color = '#307d03';
                break;
            default:
                $color = '#888888';
                break;

        }
        return $color;
    }


    function time_diff($time_from, $time_to){
        // 日時差を秒数で取得
        $dif = $time_to - $time_from;
        // 時間単位の差
        $dif_time = date("H:i:s", $dif);
        // 日付単位の差
        $dif_days = (strtotime(date("Y-m-d", $dif)) - strtotime("1970-01-01")) / 86400;
        return "{$dif_days}days {$dif_time}";
    }

//使っていないFunction↓



    Private function getInfofromTrelloByUser(){
        $userList = $this->getMemberlist();
        $tmp = array();
        foreach ($userList as $key => $value) {
            $tmp[$key] = $value;
            foreach ($value as $key2 => $value2) {
                $tmp[$key][$key2] = $this->getUserTask($value2);
            }
        }
        return $tmp;
    }
    function getUserTask($userID = 0){
        $base_url = 'https://api.trello.com/1/members/';
        $base_url2 = '/cards?';
        $api_key = 'key='.TRELLO_KEY;
        $api_token = '&token='.TRELLO_TOKEN;
        // echo $base_url.$userID.$base_url2.$api_key.$api_token;
        $result = $this->curlRequestomy($base_url.$userID.$base_url2.$api_key.$api_token);
        return $result;
    }
    function getMilestoneList(){
        $url = 'https://love.backlog.jp/api/v2/projects/25169/versions?apiKey=H53eJK4oE4OnQLwibkjyihRGgnVxNZsCx4akeQ5uOhJqmNkR3GvKIkoJmONrwy6O&count=100';

        $result = $this->curlRequestomy($url);
        $return_result = array();
        // foreach ($result as $value) {
        //     $return_result = $return_result + array($value['name'] => $value['id']);
        // }
        return $result;
    }
    private function formatBacklog(){
        //https://xx.backlog.jp/api/v2/users/myself?apiKey=abcdefghijklmn

        $base_url = 'https://love.backlog.jp/';
        $api_url2 = '/api/v2/issues';

        //apiKey ユーザー毎のユニークID(本当は各自のものを使うべきではある)
        //count デフォルトだと一回のリクエストで20までしか取得できない(100以上だったら取得できないみたいなので貯めないようにしましょ)
        //statusId 1,2,3を指定することで完了以外を取得してくる
        $api_key = '?apiKey=H53eJK4oE4OnQLwibkjyihRGgnVxNZsCx4akeQ5uOhJqmNkR3GvKIkoJmONrwy6O&count=100&statusId[]=3&statusId[]=2&statusId[]=1&';
        $param = '&milestoneId[]=';

        $milestonelist_for_use = array();
        $milestonelist = $this->fdc_milestones->find('all',array());

        foreach ($milestonelist as $key => $value) {
            $milestonelist_for_use[$value['fdc_milestones']['name']] = $value['fdc_milestones']['id'];
        }
        foreach ($milestonelist_for_use as $key => $value) {
            $result[$key] = $this->curlRequestomy($base_url.$api_url2.$api_key.$param.$milestonelist_for_use[$key]);
        }
        return $result;
    }
    private function debugRequest(){
        $result = array();











        return $result;
    }

}
