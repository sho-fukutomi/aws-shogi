<?php
class BacklogController extends AppController {
    public $uses = array('fdc_ticket_masters','all_members', 'fdc_team_member','fdc_role','fdc_backlog_webhook','test','rooms','historys','komas','fdc_members','fdc_cards','fdc_milestones','fdc_backlog_lists','fdc_list_list','fdc_webhook','fdc_team');

    function beforeFilter() {
        $this->GlobalVar_time_start = microtime(true);
        $this->GlobalVar_request_time = 0;
        $this->GlobalVar_request_count = 0;
        $this->GlobalVar_request_url = array();
        $this->autoLayout = false;

    }


    public function index() {

        $category = array(
            1 => 'management/BE',
            2 => 'Developer',
            3 => 'Tester',
            4 => 'BE',
            9 => 'None'
        );
	}

    public function getinfo_lite(){
        $this->fdc_ticket_masters->bindModel(array(
            'hasMany' => array(
                'fdc_backlog_webhooks' => array(
                    'className' => 'fdc_backlog_webhooks',
                    'foreignKey' => 'backlog_id',
                    'order' => 'time DESC',
                    'fields' => array(
                        'backlog_id',
                        'summary',
                        'issueType_id',
                        'issueType_name',
                        'milestone_id',
                        'milestone_name',
                        'fdc_task',
                        'created'
                    )
                )
            )
        ));

        $this->fdc_ticket_masters->primaryKey = 'key';
        $test2 = $this->fdc_ticket_masters->find('all',array(
            'conditions'  => array(
                'status' => 1
            )
        ) );



        $result = array();
        foreach ($test2 as $key => $value) {

            if(!empty($value['fdc_backlog_webhooks'][0]['milestone_id'])){
                if($value['fdc_backlog_webhooks'][0]['fdc_task']){
                    $result[$value['fdc_backlog_webhooks'][0]['milestone_name']][] = $value;
                }
            }else{
                $result['000_no_data_in_webhook'][] = $value;
            }
        }
        krsort($result);

        //メンバーリスト取得
        $tmpbacklogMembers = $this->updateAndGetAllMembers();

        //backlogIDをキーに並べ替えついでに、BE,GGPE,Designチームのリスト作成
        $be_list = array();
        $ggpe_list = array();
        $design_list = array();
        foreach ($tmpbacklogMembers as $key => $value) {
            if($value['all_members']['role'] == 4 ){
                $be_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }elseif($value['all_members']['role'] == 30){
                $design_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }elseif ($value['all_members']['role'] == 40) {
                $ggpe_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }
            $backlogMembers[$value['all_members']['backlog_id']] = $value['all_members'];
        }

        $team_list_tmp = $this->fdc_team->find('all',array(
            'conditions' => array(
                'status' => 1
            )
        ));
        $team_list = array();
        foreach ($team_list_tmp as $key => $value) {
            $team_list[$value['fdc_team']['id']] = $value;
        }

        $this->set('team_list',$team_list);
        $this->set('ticketList',$result);
        $this->set('be_list',$be_list);
        $this->set('ggpe_list',$ggpe_list);
        $this->set('design_list',$design_list);

    }

    public function sort(){

        $team_list = $this->fdc_team->find('all',array(
            'conditions' => array(
                'status' => 1
            )
        ));
        //詳細情報出すために、マスターにwebhookからの受け取りを紐づける
        $this->fdc_ticket_masters->primaryKey = 'key';
        $this->fdc_ticket_masters->bindModel(array(
            'hasMany' => array(
                'fdc_backlog_webhooks' => array(
                    'className' => 'fdc_backlog_webhooks',
                    'foreignKey' => 'backlog_id',
                    'order' => 'time DESC',
                    'fields' => array(
                        'backlog_id',
                        'summary',
                        'milestone_id',
                        'milestone_name',
                        'issueType_id',
                        'issueType_name',
                        'created'
                    ),
                    'limit' => 1,
                )
            )
        ),false);


        $ticketList = $this->fdc_ticket_masters->find('all', array(
            'conditions' => array(
                'status' => 1,
                'not' => array(
                    'order' => NULL
                )
            ),
            'order' => 'order asc'
        ));

        $newTicketList = $this->fdc_ticket_masters->find('all', array(
            'conditions' => array(
                'status' => 1,
                'order' => NULL
            ),
            'order' => 'order asc'
        ));



        $arrayTicketList = array();
        foreach ($team_list as $key => $value) {
            $arrayTicketList[$value['fdc_team']['name']] = $this->fdc_ticket_masters->find('all', array(
                'conditions' => array(
                    'status' => 1,
                    'fdc_team' => $value['fdc_team']['id']
                ),
                'order' => 'order asc'
            ));
        }

        $arrayTicketList['Team Assign Not Yet'] = $this->fdc_ticket_masters->find('all', array(
            'conditions' => array(
                'status' => 1,
                'fdc_team' => NULL
            ),
            'order' => 'order asc'
        ));

        $team_list = $this->fdc_team->find('all', array(
            'conditions' => array(
                'status' => 1
            )
        ));

        $tmpbacklogMembers = $this->updateAndGetAllMembers();

        $be_list = array();
        $ggpe_list = array();
        $design_list = array();

        foreach ($tmpbacklogMembers as $key => $value) {
            //debug($value);
            if($value['all_members']['role'] == 4 ){
                $be_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }elseif($value['all_members']['role'] == 30){
                $design_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];

            }elseif ($value['all_members']['role'] == 40) {
                $ggpe_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }
        }

        $this->set('arrayTicketList',$arrayTicketList);
        $this->set('team_list',$team_list);
        $this->set('ticketList',$ticketList);
        $this->set('newTicketList',$newTicketList);
        $this->set('be_list',$be_list);
        $this->set('design_list',$design_list);
        $this->set('ggpe_list',$ggpe_list);

    }

    public function updatesort(){
        $this->autoRender = false;

        if ('POST' == $_SERVER['REQUEST_METHOD'] ) {
            $body = file_get_contents("php://input");
            $decoded_body = json_decode($body,true);
            $key_list = array();
            foreach ($decoded_body as $key => $value) {
                $key_list['or'][]['key'] = $key;
            }
            $ticket_list =  $this->fdc_ticket_masters->find('all',array(
                'conditions' => $key_list
            ));


            foreach ($ticket_list as $key => $value) {
                $ticket_list[$key]['fdc_ticket_masters']['order'] =  $decoded_body[$value['fdc_ticket_masters']['key']];
            }
            $this->fdc_ticket_masters->create();
            $this->fdc_ticket_masters->saveAll($ticket_list);
            // $this->log($ticket_list);
        }


    }

    public function getinfo(){
        ini_set("memory_limit", "4000M");
        set_time_limit(0);
        $result_backlog_milestones = $this->getBacklogMilestoneList();

        //マイルストーンリストを作成 (keyにマイルストーン名)
        foreach ($result_backlog_milestones as $key => $value) {
            $milestones[$value['displayOrder']] = $value['name'];
        }

        // デバッグ場合直下のforeachは使わずこちらをアクティブにする
        // $result_tickets[0] = $this->getBacklogInfoByMilestone(252589);

        //マイルストーン毎にチケットを取得
        foreach ($result_backlog_milestones as $key => $value) {
             $result_tickets[$value['displayOrder']] = $this->getBacklogInfoByMilestone($value['id']);
        }

        //fdc_ticket_masters にない新規チケットは追加 & 現在のステータス(close or not)をアップデート
        $finalResult = $this->updateTicketMaster($result_tickets);

        //メンバーリスト取得
        $tmpbacklogMembers = $this->updateAndGetAllMembers();

        //backlogIDをキーに並べ替えついでに、BE,GGPE,Designチームのリスト作成

        $be_list = array();
        $ggpe_list = array();
        $design_list = array();

        foreach ($tmpbacklogMembers as $key => $value) {
            //debug($value);
            if($value['all_members']['role'] == 4 ){
                $be_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }elseif($value['all_members']['role'] == 30){
                $design_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];

            }elseif ($value['all_members']['role'] == 40) {
                $ggpe_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }

            $backlogMembers[$value['all_members']['backlog_id']] = $value['all_members'];
        }

        //Viewにセット
        $this->set('milestones',$milestones);
        $this->set('result_tickets',$result_tickets);
        $this->set('finalResult',$finalResult);
        $this->set('backlogMembers',$backlogMembers);
        $this->set('be_list',$be_list);
        $this->set('design_list',$design_list);
        $this->set('ggpe_list',$ggpe_list);

        //速度計測用
        // debug($this->GlobalVar_request_time);
        // debug(microtime(true) - $this->GlobalVar_time_start);
        // debug($this->GlobalVar_request_count);
        // debug($this->GlobalVar_request_url);

    }

    public function ticketinfo($ticket_num){
        //debug($ticket_num);

        $master =  $this->fdc_ticket_masters->find('all',array(
            'conditions' => array(
                'key' => $ticket_num
            )
        ));

        $webhook = $this->fdc_backlog_webhook->find('all',array(
            'conditions' => array(
                'backlog_id' => $ticket_num
            ),
            'order' => 'time asc'
        ));

        $temp = array(
            'all_members' => array(
                'backlog_name' => '',
                'backlog_id' => ''
            )
        );
        $be = $temp;
        $ggpe = $temp;
        $design = $temp;
        if(!empty($master[0]['fdc_ticket_masters']['be'])){
            $be = $this->all_members->find('first',array(
                'conditions' => array(
                    'backlog_id' => $master[0]['fdc_ticket_masters']['be']
                )
            ));
        }
        if(!empty($master[0]['fdc_ticket_masters']['ggpe'])){
            $ggpe = $this->all_members->find('first',array(
                'conditions' => array(
                    'backlog_id' => $master[0]['fdc_ticket_masters']['ggpe']
                )
            ));
        }
        if(!empty($master[0]['fdc_ticket_masters']['design'])){
            $design = $this->all_members->find('first',array(
                'conditions' => array(
                    'backlog_id' => $master[0]['fdc_ticket_masters']['design']
                )
            ));
        }

        $deleteKey = array();
        foreach ($webhook as $key => $value) {
            if($key){
                if($value['fdc_backlog_webhook']['milestone_id'] == $webhook[$key-1]['fdc_backlog_webhook']['milestone_id']){
                    $deleteKey[] = $key;
                }
            }
        }
        foreach ($deleteKey as $key => $value) {
            unset($webhook[$value]);
        }
        $webhook = array_reverse($webhook);

        $firstflg = 1;
        foreach ($webhook as $key => $value) {
            if($firstflg){
                //debug(strtotime(date("Y-m-d H:i:s")));
                //debug(strtotime($value['fdc_backlog_webhook']['time']));
                $time_diff = strtotime(date("Y-m-d H:i:s")) - strtotime($value['fdc_backlog_webhook']['time']);
                $time_diff = $this->msecTotime(intval($time_diff));

                $webhook[$key]['fdc_backlog_webhook']['time_diff'] = $time_diff;
                $firstflg = 0;
            }else{
                $time_diff = strtotime($webhook[$key - 1]['fdc_backlog_webhook']['time']) - strtotime($value['fdc_backlog_webhook']['time']);
                $time_diff = $this->msecTotime(intval($time_diff));
                $webhook[$key]['fdc_backlog_webhook']['time_diff'] = $time_diff;
            }

        }
        $this->set('ticket_num',$ticket_num);
        $this->set('master',$master);
        $this->set('webhook',$webhook);
        $this->set('be',$be['all_members']['backlog_name']);
        $this->set('ggpe',$ggpe['all_members']['backlog_name']);
        $this->set('design',$design['all_members']['backlog_name']);
        $this->set('be_id',$be['all_members']['backlog_id']);
        $this->set('ggpe_id',$ggpe['all_members']['backlog_id']);
        $this->set('design_id',$design['all_members']['backlog_id']);


    }

    private function msecTotime($msec){
        $hour =floor($msec / 3600);
        $min = str_pad(floor(($msec - ($hour * 3600)) / 60), 2, 0, STR_PAD_LEFT);
        $sec = str_pad(floor($msec - ($hour * 3600) - ($min * 60)),2,0,STR_PAD_LEFT);
        $result = $hour.':'.$min.':'.$sec;
        return $result;
    }

    public function userinfo($userId){

        $this->fdc_ticket_masters->primaryKey = 'key';
        $this->fdc_ticket_masters->bindModel(array(
            'hasMany' => array(
                'fdc_backlog_webhooks' => array(
                    'className' => 'fdc_backlog_webhooks',
                    'foreignKey' => 'backlog_id',
                    'order' => 'time DESC',


                    'fields' => array(
                        'backlog_id',
                        'summary',
                        'milestone_id',
                        'milestone_name',
                        'issueType_id',
                        'issueType_name',
                        'created'
                    ),
                    'limit' => 1,
                )
            )
        ),false);

        $userInfo = $this->all_members->find('first',array(
            'conditions' => array(
                'backlog_id' => $userId
            )
        ));
        switch ($userInfo['all_members']['role']) {
            case '4':
                $role = 'be';
                break;
            case '30':
                $role = 'design';
                break;
            case '40':
                $role = 'ggpe';
                break;

            default:
                $role = '';
                break;
        }

        $ticketInfo = $this->fdc_ticket_masters->find('all',array(
            'conditions' => array(
                $role => $userId,
                'status' => 1
            ),
            'order' => array(
                //'milestone_name' => 'desc',
                'fdc_team' => 'asc',
                'order' => 'asc'
            )
        ));


        $allMembers = $this->all_members->find('all',array(
            'fields' => array(
                'backlog_id',
                'backlog_name'
            ),
            'conditions' => array(
                'role' => array(
                        4,30,40
                )
            )
        ));
        $members = array();
        foreach ($allMembers as $key => $value) {
            $members[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
        }


        //milestone name でソート
        foreach ((array) $ticketInfo as $key => $value) {
            $sort[$key] = $value['fdc_backlog_webhooks'][0]['milestone_name'];
        }
        array_multisort($sort, SORT_DESC, $ticketInfo);


        $teams_tmp = $this->fdc_team->find('all',array(
            'conditions' => array(
                'status' => 1
            )
        ));
        $teams = array();
        foreach ($teams_tmp as $key => $value) {
            $teams[$value['fdc_team']['id']] = $value['fdc_team']['name'];
        }

        $this->set('name',$userInfo['all_members']['backlog_name']);
        $this->set('issueCount',count($ticketInfo));
        $this->set('ticketInfo',$ticketInfo);
        $this->set('members',$members);
        $this->set('teams',$teams);


    }

    public function fdc_task(){
        //詳細情報出すために、マスターにwebhookからの受け取りを紐づける
        $this->fdc_ticket_masters->primaryKey = 'key';
        $this->fdc_ticket_masters->bindModel(array(
            'hasMany' => array(
                'fdc_backlog_webhooks' => array(
                    'className' => 'fdc_backlog_webhooks',
                    'foreignKey' => 'backlog_id',
                    'order' => 'time DESC',
                    'fields' => array(
                        'fdc_task',
                        'backlog_id',
                        'summary',
                        'milestone_id',
                        'milestone_name',
                        'issueType_id',
                        'issueType_name',
                        'created'
                    ),
                    'limit' => 1,
                )
            )
        ),false);

        $ticketList = $this->fdc_ticket_masters->find('all', array(
            'conditions' => array(
                'status' => 1,
                'not' => array(
                    'order' => NULL
                )
            ),
            'order' => 'order asc'
        ));


        $fdc_tickets = array();
        $tsuchie_tasks = array();
        $be_task = array();
        foreach ($ticketList as $key => $value) {
            if(!empty($value['fdc_backlog_webhooks'][0]['fdc_task'])){
                $fdc_tickets[] = $value;

                if(
                    $value['fdc_backlog_webhooks'][0]['milestone_id'] == 252578 ||
                    $value['fdc_backlog_webhooks'][0]['milestone_id'] == 252698
                ){
                    $tsuchie_tasks[$value['fdc_ticket_masters']['fdc_team']][$value['fdc_ticket_masters']['order']] = $value;
                }

                if(isset($value['fdc_ticket_masters']['be'])){
                    $be_task[$value['fdc_ticket_masters']['be']][$value['fdc_ticket_masters']['fdc_team']][$value['fdc_ticket_masters']['order']] = $value;
                }

            }
        }
        //debug($be_task);

        $tmpbacklogMembers = $this->updateAndGetAllMembers();

        //backlogIDをキーに並べ替えついでに、BE,GGPE,Designチームのリスト作成
        $be_list = array();
        $ggpe_list = array();
        $design_list = array();
        foreach ($tmpbacklogMembers as $key => $value) {
            if($value['all_members']['role'] == 4 ){
                $be_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }elseif($value['all_members']['role'] == 30){
                $design_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }elseif ($value['all_members']['role'] == 40) {
                $ggpe_list[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
            }
            $backlogMembers[$value['all_members']['backlog_id']] = $value['all_members'];
        }


        $team_list_tmp = $this->fdc_team->find('all',array(
            'conditions' => array(
                'status' => 1
            )
        ));
        $team_list = array();
        foreach ($team_list_tmp as $key => $value) {
            $team_list[$value['fdc_team']['id']] = $value;
        }

        $this->set('team_list',$team_list);
        $this->set('be_list',$be_list);
        $this->set('fdc_tickets',$fdc_tickets);
        $this->set('tsuchie_tasks',$tsuchie_tasks);
        $this->set('be_task',$be_task);




    }

    public function fdc_team($teamId){
        $teamInfo = $this->fdc_team->find('first',array(
            'conditions' => array(
                'id' => $teamId
            )
        ));



        $this->fdc_team_member->primaryKey = 'members_id';
        $this->fdc_team_member->bindModel(array(
            'hasOne' => array(
                'all_members' => array(
                    'className' => 'all_members',
                    'foreignKey' => 'backlog_id',
                    // 'order' => 'time DESC',

                    'fields' => array(
                        'backlog_name',
                        'nickname',
                        'role'
                    ),
                    'limit' => 1,
                )
            )
        ),false);



        $teamMembers = $this->fdc_team_member->find('all',array(
            'conditions' => array(
                'team_id' => $teamId
            )
        ));

        // debug($teamInfo);
        // debug($teamMembers);


        $this->fdc_ticket_masters->primaryKey = 'key';
        $this->fdc_ticket_masters->bindModel(array(
            'hasMany' => array(
                'fdc_backlog_webhooks' => array(
                    'className' => 'fdc_backlog_webhooks',
                    'foreignKey' => 'backlog_id',
                    'order' => 'time DESC',
                    'fields' => array(
                        'fdc_task',
                        'backlog_id',
                        'summary',
                        'milestone_id',
                        'milestone_name',
                        'issueType_id',
                        'issueType_name',
                        'created'
                    ),
                    'limit' => 1,
                )
            )
        ),false);

        $ticketList = $this->fdc_ticket_masters->find('all', array(
            'conditions' => array(
                'status' => 1,
                'fdc_team' => $teamId
            ),
            'order' => 'order asc'
        ));

        // debug($ticketList);


        $roles_tmp = $this->fdc_role->find('all',array());
        $roles = array();
        foreach ($roles_tmp as $key => $value) {
            $roles[$value['fdc_role']['id']] = $value['fdc_role'];
        }
        $members = $this->getMemberById();

        $this->set('members',$members);
        $this->set('teamInfo',$teamInfo);
        $this->set('ticketList',$ticketList);
        $this->set('teamMembers',$teamMembers);
        $this->set('roles',$roles);
    }
    public function updateTeamAssign(){
        $this->log('testtest');

    }



    public function calendar(){




    }



    public function getMemberById(){
        $members_tmp = $this->all_members->find('all');
        $members = array();
        foreach ($members_tmp as $key => $value) {
            // debug();
            $members[$value['all_members']['backlog_id']] = $value['all_members'];
        }
        return $members;
    }

    public function settingmembers(){
        ini_set("memory_limit", "4000M");

        //roleを取得しIDをキーに並べ替え
        $tmp_roleList = $this->fdc_role->find('all');
        foreach ($tmp_roleList as $key => $value) {
            $roleList[$value['fdc_role']['id']] = $value;
        }


        //現在DB上にいるユーザー取得、
        //backlogからユーザー取得
        //新規ユーザーいた場合はDBに保存
        //上記行なった上で全ユーザー取得
        $tmpbacklogMembers = $this->updateAndGetAllMembers();

        //backlogIDをキーに並べ替え
        foreach ($tmpbacklogMembers as $key => $value) {
            // debug($value['all_members']['role']);
            $value['all_members']['color'] = $roleList[$value['all_members']['role']]['fdc_role']['color'];
            $backlogMembers[$value['all_members']['backlog_id']] = $value['all_members'];
        }



        //チームリストも同様に取得して並べ替え
        $tmp_teamList = $this->fdc_team->find('all', array(
            'conditions' => array(
                'status' => 1 )
        ));
        foreach ($tmp_teamList as $key => $value) {
            $teamList[$value['fdc_team']['id']] = $value;
        }

        //チームとメンバー紐付け用DBから全取得
        $teamAndMembers = $this->fdc_team_member->find('all',array(
        ));


        //チーム毎にメンバー情報とそのrole情報を入力
        foreach ($teamAndMembers as $key => $value) {
            // debug($value);
            $membersByTeam[$value['fdc_team_member']['team_id']][] = array(
                'unique_key' => $value['fdc_team_member']['members_id'],
                'name' => $backlogMembers[$value['fdc_team_member']['members_id']]['backlog_name'],
                'nick_name' => $backlogMembers[$value['fdc_team_member']['members_id']]['nickname'],
                'role' => $roleList[$backlogMembers[$value['fdc_team_member']['members_id']]['role']]['fdc_role']
            );
        }

        //Viewにセット
        $this->set('backlogMembers',$backlogMembers);
        $this->set('roleList',$roleList);
        $this->set('membersByTeam',$membersByTeam);
        $this->set('teamList',$teamList);

    }

    private function updateAndGetAllMembers(){
        //現在DB上にいるユーザー取得し、backlogとの比較用配列にセット
        $tmpAllMembers =  $this->all_members->find('all');
        foreach ($tmpAllMembers as $key => $value) {
            $checkCurrentmembers[$value['all_members']['backlog_id']] = $value['all_members']['backlog_name'];
        }

        //バックログからユーザー取得(NativeCampチームのみ)
        $tmpAllMemberFromBacklog = $this->getBacklogMemberList();

        //バックログからのユーザーのうちDBにいなかった場合、新規メンバーとみなし、DBに追加する
        $saveData  = array();
        foreach ($tmpAllMemberFromBacklog as $key => $value) {
            $AllMemberFromBacklog[$key]['all_members']['backlog_id'] = $value['id'];
            $AllMemberFromBacklog[$key]['all_members']['backlog_name'] = $value['name'];
            // $AllMemberFromBacklog[$key]['all_member']['backlog_id'] = $value['id'];

            if(!isset($checkCurrentmembers[$value['id']])){
                $saveData[] = array(
                    'all_members' => array(
                        // 'id' => $value['id'],
                        'backlog_id' => $value['id'],
                        'backlog_name' => $value['name']
                    )
                );
            }
        }
        //新規メンバーがいた場合、DBに保存
        if(!empty($saveData)){
            if($this->all_members->saveAll($saveData)){
                debug('New member saved!');
            }
        }
        //上記作業が終わったら改めてDBよりメンバー取得
        $AllMembers = $this->all_members->find('all');
        return $AllMembers;
    }

    public function updatepersonincharge(){
        //getinfoよりコールされるAjax受け取り用function
        //レンダリング不要
        $this->autoRender = false;
        $this->log($_POST);
        if(isset($_POST)){
            $got_data = $_POST;
            $check = $this->fdc_ticket_masters->find('first',array(
                'conditions' => array(
                    'key' => $got_data['target_ticket_id']
                )
            ));

            if(!empty($check)){
                $saveData = $check;
                $saveData['fdc_ticket_masters']['be'] = $got_data['be_id'];
                $saveData['fdc_ticket_masters']['ggpe'] = $got_data['ggpe_id'];
                $saveData['fdc_ticket_masters']['design'] = $got_data['design_id'];

                $this->fdc_ticket_masters->create();
                if($this->fdc_ticket_masters->save($saveData)){
                    echo "add success !";
                }
            }
        }
    }

    public function updatebysort(){
        //getinfoよりコールされるAjax受け取り用function
        //レンダリング不要
        $this->autoRender = false;
        $this->log($_POST);
        if(isset($_POST)){
            $got_data = $_POST;
            $check = $this->fdc_ticket_masters->find('first',array(
                'conditions' => array(
                    'key' => $got_data['target_ticket_id']
                )
            ));

            if(!empty($check)){
                $this->log($check);
                $saveData = $check;
                $saveData['fdc_ticket_masters']['be'] = $got_data['be_id'];
                $saveData['fdc_ticket_masters']['ggpe'] = $got_data['ggpe_id'];
                $saveData['fdc_ticket_masters']['design'] = $got_data['design_id'];
                $saveData['fdc_ticket_masters']['fdc_team'] = $got_data['team_id'];
                $saveData['fdc_ticket_masters']['dev_start_plan'] = $got_data['dev_start_plan'];
                $saveData['fdc_ticket_masters']['dev_start_result'] = $got_data['dev_start_result'];
                $saveData['fdc_ticket_masters']['dev_done_plan'] = $got_data['dev_done_plan'];
                $saveData['fdc_ticket_masters']['dev_done_result'] = $got_data['dev_done_result'];
                $saveData['fdc_ticket_masters']['ggpe_check_done_plan'] = $got_data['ggpe_check_done_plan'];
                $saveData['fdc_ticket_masters']['ggpe_check_done_result'] = $got_data['ggpe_check_done_result'];
                $saveData['fdc_ticket_masters']['release_plan'] = $got_data['release_plan'];
                $saveData['fdc_ticket_masters']['release_result'] = $got_data['release_result'];
                $this->fdc_ticket_masters->create();
                if($this->fdc_ticket_masters->save($saveData)){
                    echo "add success !";
                }
            }
        }
    }

    public function updatemembers(){
        //settingmembersよりコールされるAjax受け取り用function
        //レンダリング不要
        $this->autoRender = false;

        //Postの内容をチェックし、各処理を行う
        if(isset($_POST)){
            $got_data = $_POST;

            if($got_data['task'] == 'add_to_team'){
                echo "メンバー追加処理をするよ";
                $check = $this->fdc_team_member->find('all' , array(
                    'conditions' => array(
                        'team_id' => $got_data['target_team_id'],
                        'members_id' => $got_data['target_user_id']
                    )
                ));
                if(empty($check)){
                    $saveData['fdc_team_member']['team_id'] = $got_data['target_team_id'];
                    $saveData['fdc_team_member']['members_id'] = $got_data['target_user_id'];

                    $this->fdc_team_member->create();
                    if($this->fdc_team_member->save($saveData)){
                        echo "add success !";
                    }
                }else{
                    echo 'alredy member...';

                }
            }elseif ($got_data['task'] == 'delete_from_team') {
                echo "メンバー削除処理をするよ";
                $this->log($got_data);
                $check = $this->fdc_team_member->find('all',array(
                    'conditions' => array(
                        'team_id' => $got_data['target_team_id'],
                        'members_id' => $got_data['target_user_id']
                    )
                ));
                if($this->fdc_team_member->deleteAll($check[0]['fdc_team_member'])){
                    echo "delete success !";
                }

            }elseif ($got_data['task'] == 'member_update') {
                echo "メンバー変更処理をするよ";
                $this->log($got_data);
                $check = $this->all_members->find('all',array(
                    'conditions' => array(
                        'backlog_id' => $got_data['target_user_id']
                    )
                ));
                if(!empty($check)){
                    // $this->log($check[0]);
                    $saveData = $check[0];
                    $saveData['all_members']['nickname'] = $got_data['target_user_nick_name']  ;
                    $saveData['all_members']['role'] = $got_data['target_user_role']  ;
                    // $this->log($saveData);
                    $this->all_members->create();
                    if($this->all_members->save($saveData)){
                        echo "edit success !";
                    }
                }
            }else{
                echo "unknown task";
            }
        }
    }

    public function popomilestone(){
        //チケット管理シート更新用function
        //closeではないチケットをチケットナンバー、マイルストーンを表示するのみ
        $this->autoRender = false;
        $this->layout = '';
        //backlogより、新鮮なマイルストーン一覧を取得
        $result_backlog = $this->getBacklogMilestoneList();
        //マイルストーンごとに、チケット情報を取得
        foreach ($result_backlog as $key => $value) {
            $result_tickets[$value['displayOrder']] = $this->getBacklogInfoByMilestone($value['id']);
        }

        //結果をここで出力しちゃう
        echo "<table>";
        echo "<tr>";
            echo "<td> last update </td>";
            echo "<td>";
                echo date("Y/m/d H:i:s");
            echo "</td>";
        echo "</tr>";

        foreach ($result_tickets as $milestone => $byMilestone) {
            foreach ($byMilestone as $key2 => $ticket) {
                echo "<tr>";
                echo '<td>'. $ticket['issueKey'].'</td>';
                echo '<td>'. $ticket['milestone'][0]['name'].'</td>';
                // echo '<td>'. $ticket['summary'].'</td>';
                echo "</tr>";
            }
        }
        echo "</table>";
    }

    public function webhook(){
        //backlogからのwebhook受け取り用function
        //更新履歴はfdc_backlog_webhookに保存される

        $this->autoRender = false;
        $this->layout = '';

        if ('POST' == $_SERVER['REQUEST_METHOD'] ) {
            $body = file_get_contents("php://input");
            $decoded_body = json_decode($body,true);



            $fdc_flg = 0;
            foreach($decoded_body['content']['category'] as $key => $value) {
                // $this->log($value);
                if($value['id']== 50751    //FDC
                || $value['id'] == 124975   //iOS
                || $value['id'] == 220480   //API
                || $value['id'] == 204445 //Android
                 ){
                    $fdc_flg = 1;
                }
            }

            $result['backlog_id'] = 'NC-'. $decoded_body['content']['key_id'];
            $result['summary'] = $decoded_body['content']['summary'];
            $result['issueType_id'] = $decoded_body['content']['issueType']['id'];
            $result['issueType_name'] = $decoded_body['content']['issueType']['name'];
            $result['milestone_id'] = $decoded_body['content']['milestone'][0]['id'];
            $result['milestone_name'] = $decoded_body['content']['milestone'][0]['name'];
            $result['fdc_task'] = $fdc_flg;
            $result['time'] =  date("Y-m-d H:i:s");

            $this->fdc_backlog_webhook->save($result);

        }

    }

    private function getBacklogInfoByMilestone($milestoneID){
        //backlogからチケットリストを取得するfunction
        //マイルストーンIDを受け取り、マイルストーン毎に取得する

        //backlogAPIは100件までしか取得できないため
        //1マイルストーンで100件以上の場合はカテゴリを分けて取得する必要がある
        //まずはチケットを取得してみた上で件数取得
        $api_url = 'api/v2/issues';

        $raw_result =  $this->curlRequestomy(
            BACKLOG_URL.
            $api_url.
            '?apiKey='.BACKLOG_API_KEY.
            '&milestoneId[]='.$milestoneID.
            '&count=100'.
            '&statusId[]=3'.
            '&statusId[]=2'.
            '&statusId[]=1');

        $issueCount = count($raw_result);

        // チケット100件以下の場合はそのまま取得
        if($issueCount < 100) {
            $result = array();
            foreach ($raw_result as $key => $value) {
                $result[$key]['issueKey'] = $value['issueKey'];
                $result[$key]['issueType'] = $value['issueType'];
                $result[$key]['summary'] = $value['summary'];
                $result[$key]['category'] = $value['category'];
                $result[$key]['milestone'] = $value['milestone'];
            }
        }else{
            //100件以上の場合、カテゴリリストを取得し、カテゴリを条件に加え、カテゴリ数分リクエストする
            $categoryList = $this->getCategoryList();
            foreach ($categoryList as $key => $category) {
                $result[$key] =  $this->curlRequestomy(
                    BACKLOG_URL.
                    $api_url.
                    '?apiKey='.BACKLOG_API_KEY.
                    '&milestoneId[]='.$milestoneID.
                    '&count=100'.
                    '&statusId[]=3'.
                    '&statusId[]=2'.
                    '&statusId[]=1'.
                    '&categoryId[]='.$category['id']
                );

                foreach ($result[$key] as $key2 => $value2) {
                    $tmp_result[$result[$key][$key2]['issueKey']]['issueKey'] = $result[$key][$key2]['issueKey'];
                    $tmp_result[$result[$key][$key2]['issueKey']]['issueType'] = $result[$key][$key2]['issueType'];
                    $tmp_result[$result[$key][$key2]['issueKey']]['summary'] = $result[$key][$key2]['summary'];
                    $tmp_result[$result[$key][$key2]['issueKey']]['category'] = $result[$key][$key2]['category'];
                    $tmp_result[$result[$key][$key2]['issueKey']]['milestone'] = $result[$key][$key2]['milestone'];
                }
            }

            //カテゴリ毎に取得したものをマージする
            $result = array();
            foreach ($tmp_result as $key => $value) {
                $result[] = $value;
            }
        }
        return $result;
    }

    private function updateTicketMaster($tmp_result){
        //マイルストーン毎のチケットリストを受け取りチケットマスターを更新するfunction
        //なんかもっとうまくできる気がする

        //debug($tmp_result);
        $disableData = array();
        $saveData = array();
        $finalResult = array();
        $checkkey = array();
        $updateData = array();
        $checkData = array();
        $ticketMasters = array();

        //チケットリストをチケットナンバーをキーにしたシンプルな配列に変換
        foreach ($tmp_result as $key => $ticketByMilestone) {
            foreach ($ticketByMilestone as $key2 => $value) {
                $finalResult[$value['issueKey']] = $value;
            }
        }

        //チケットマスターからenableなチケット一覧を取得
        $tmp_ticketMasters = $this->fdc_ticket_masters->find('all',array(
            'conditions' => array(
                'status' => 1
            )
        ));

        //チケットナンバーをキーにしたシンプルな配列に変換
        foreach ($tmp_ticketMasters as $key => $value) {
            $ticketMasters[$value['fdc_ticket_masters']['key']] = $value;
        }

        //backlogからのチケットリスト毎に、チケットマスターの存在確認
        foreach ($finalResult as $key => $value) {
            //チケットマスターに存在している場合、追加情報を付与
            if(isset($ticketMasters[$key])){
                // debug('heyhey');
                $finalResult[$key]['order'] = $ticketMasters[$key]['fdc_ticket_masters']['order'];
                // $finalResult[$key]['summary'] = $ticketMasters[$key]['fdc_ticket_masters']['summary'];
                $finalResult[$key]['fdc_team'] = $ticketMasters[$key]['fdc_ticket_masters']['fdc_team'];
                $finalResult[$key]['be'] = $ticketMasters[$key]['fdc_ticket_masters']['be'];
                $finalResult[$key]['ggpe'] = $ticketMasters[$key]['fdc_ticket_masters']['ggpe'];
                $finalResult[$key]['design'] = $ticketMasters[$key]['fdc_ticket_masters']['design'];
            }else{
                //チケットマスターにenable状態で存在していない場合
                //まずはdisable状態でいるかどうかを確認
                $checkData = $this->fdc_ticket_masters->find('first',array(
                    'conditions' => array(
                        'key' => $value['issueKey'],
                    ),
                    'fields' => array(
                        'id','key'
                    )
                ));

                if(empty($checkData)){
                    //disable状態でも存在していないということは新規チケット
                    //新しくマスタに追加する
                    $saveData[] = array('fdc_ticket_masters' => array(

                        'key' => $value['issueKey'],
                        'status' => 1,
                        // 'summary' => $value['summary']
                    ));
                }else{
                    //disable状態でマスタに存在してる場合はenableに戻す
                    //きっと閉じたのに復活したゾンビチケットなのでしょう
                    $checkData['fdc_ticket_masters']['status'] = 1;
                    $updateData[] = $checkData;
                }
            }
        }

        //追加かアップデート、または両方、対象のデータがあった場合DB更新
        if(!empty($saveData)){
            if($this->fdc_ticket_masters->saveAll($saveData)){
                debug('savedone');
            }
        }
        if(!empty($updateData)){
            if($this->fdc_ticket_masters->saveAll($updateData)){
                debug('update to enable done');
            }
        }

        //DBマスタに存在するのにbacklogにはない場合
        //closeしたとみなしてマスタをDisableにする、お疲れ様でした
        foreach ($ticketMasters as $key => $value) {
            if(!isset($finalResult[$key])){
                // debug($value);
                $value['fdc_ticket_masters']['status'] = 0;
                $disableData[] = $value;
            }
        }
        //disable対象があった場合にDBをアップデート
        if(!empty($disableData)){
            if($this->fdc_ticket_masters->saveAll($disableData)){
                debug('update to disable done');
            }
        }
        return $finalResult;
    }

    private function getBacklogMemberList(){
        $api_url = 'api/v2/projects/';

        $request_url =
            BACKLOG_URL.
            $api_url.
            PROJECT_ID.
            '/users'.
            '?apiKey='.BACKLOG_API_KEY;
        $result = $this->curlRequestomy($request_url);
        return $result;
    }

    private function getBacklogMilestoneList(){
        $api_url = 'api/v2/projects/';
        $request_url =
            BACKLOG_URL.
            $api_url.
            PROJECT_ID.
            '/versions'.
            '?apiKey='.BACKLOG_API_KEY.
            '&count=100';
        $result = $this->curlRequestomy($request_url);
        return $result;
    }

    private function checkCountIssue($milestoneID){
        $api_url = 'api/v2/issues/count';
        $result =  $this->curlRequestomy(
            BACKLOG_URL.
            $api_url.
            '?apiKey='.BACKLOG_API_KEY.
            '&milestoneId[]='.$milestoneID.
            '&statusId[]=3'.
            '&statusId[]=2'.
            '&statusId[]=1');
        return $result['count'];
    }

    private function getCategoryList(){
        $api_url = 'api/v2/projects/';
        $result = $this->curlRequestomy(
            BACKLOG_URL.
            $api_url.
            PROJECT_ID.
            '/categories'.
            '?apiKey='.BACKLOG_API_KEY.
            '&count=100');
        return $result;
    }

    private function curlRequestomy($url){
        $start = microtime(true);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す
        $response = curl_exec($curl);
        // if you want to use it -> json_decode($response, true);
        $response = json_decode($response, true);
        curl_close($curl);
        $end = microtime(true) - $start;
        $this->GlobalVar_request_time = $this->GlobalVar_request_time + $end;
        $this->GlobalVar_request_count++;
        $this->GlobalVar_request_url[] = $url;

        return $response;


    }

}
