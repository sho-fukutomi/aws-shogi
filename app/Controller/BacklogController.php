<?php
class BacklogController extends AppController {
    public $uses = array('all_member', 'fdc_team_member','fdc_role','fdc_backlog_webhook','test','rooms','historys','komas','fdc_members','fdc_cards','fdc_milestones','fdc_backlog_lists','fdc_list_list','fdc_webhook','fdc_team');

    function beforeFilter() {
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
    public function getinfo(){
        ini_set("memory_limit", "4000M");
        set_time_limit(0);
        $result_backlog = $this->getBacklogMilestoneList();
        foreach ($result_backlog as $key => $value) {
            $milestones[$value['displayOrder']] = $value['name'];
        }



        $result_tickets[0] = $this->getBacklogInfoByMilestone(252589);

        //デバッグのため消し
        // foreach ($result_backlog as $key => $value) {
        //     $result_tickets[$value['displayOrder']] = $this->getBacklogInfoByMilestone($value['id']);
        // }


        $this->set('milestones',$milestones);
        $this->set('result_tickets',$result_tickets);
    }


    public function settingmembers(){
        $tmpFdcMembers =  $this->fdc_members->find('all');
        $tmpAllMembers =  $this->all_members->find('all');


debug($tmpAllMembers);

        foreach ($tmpFdcMembers as $key => $value) {
            $fdcMembers[$value['fdc_members']['unique_key']] = $value;
        }

        $tmp_roleList = $this->fdc_role->find('all');
        foreach ($tmp_roleList as $key => $value) {
            $roleList[$value['fdc_role']['id']] = $value;
        }

        $tmp_teamList = $this->fdc_team->find('all', array(
            'conditions' => array(
                'status' => 1 )
        ));

        foreach ($tmp_teamList as $key => $value) {
            $teamList[$value['fdc_team']['id']] = $value;
        }

        $teamAndMembers = $this->fdc_team_member->find('all',array(
        ));


        foreach ($teamAndMembers as $key => $value) {
            $membersByTeam[$value['fdc_team_member']['team_id']][] = array(
                'unique_key' => $fdcMembers[$value['fdc_team_member']['members_id']]['fdc_members']['unique_key'],
                'name' => $fdcMembers[$value['fdc_team_member']['members_id']]['fdc_members']['username'],
                'nick_name' => $fdcMembers[$value['fdc_team_member']['members_id']]['fdc_members']['nick_name'],
                'role' =>  $roleList[$fdcMembers[$value['fdc_team_member']['members_id']]['fdc_members']['role']]['fdc_role'],
                // 'raw' => $value
            );
        }

        // debug($fdcMembers) ;
        // debug($membersByTeam);
        // debug($fdcMembers);
        // $this->set('backlogMembers',$backlogMembers);

        $this->set('fdcMembers',$fdcMembers);
        $this->set('roleList',$roleList);
        $this->set('membersByTeam',$membersByTeam);
        $this->set('teamList',$teamList);
    }


    public function updatemembers(){
        $this->autoRender = false;

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
                $check = $this->fdc_members->find('all',array(
                    'conditions' => array(
                        'unique_key' => $got_data['target_user_id']
                    )
                ));
                if(!empty($check)){
                    $this->log($check[0]);
                    $saveData = $check[0];
                    $saveData['fdc_members']['nick_name'] = $got_data['target_user_nick_name']  ;
                    $saveData['fdc_members']['role'] = $got_data['target_user_role']  ;
                    $this->log($saveData);
                    $this->fdc_members->create();
                    if($this->fdc_members->save($saveData)){
                        echo "edit success !";
                    }
                }
            }else{
                echo "unknown task";
            }
        }
    }


    public function popomilestone(){
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
        $this->autoRender = false;
        $this->layout = '';

        if ('POST' == $_SERVER['REQUEST_METHOD'] ) {
            $body = file_get_contents("php://input");
            $decoded_body = json_decode($body,true);

            $result['backlog_id'] = 'NC-'. $decoded_body['content']['key_id'];
            $result['summary'] = $decoded_body['content']['summary'];
            $result['issueType_id'] = $decoded_body['content']['issueType']['id'];
            $result['issueType_name'] = $decoded_body['content']['issueType']['name'];
            $result['milestone_id'] = $decoded_body['content']['milestone'][0]['id'];
            $result['milestone_name'] = $decoded_body['content']['milestone'][0]['name'];
            $result['time'] =  date("Y-m-d H:i:s");

            $this->fdc_backlog_webhook->save($result);

        }





        // $file = new File(WWW_ROOT.'files/test/test.txt',True);
        // // $file->write($_POST ,"a");
        // $file->close();

    }


    private function getBacklogMemberList(){
        $api_url = 'api/v2/users';

        $request_url =
            BACKLOG_URL.
            $api_url.
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


    private function getBacklogInfoByMilestone($milestoneID){
        $api_url = 'api/v2/issues';

        $issueCount = $this->checkCountIssue($milestoneID);
        if ($issueCount <= 100) {
            $api_url = '/api/v2/issues';
            //apiKey ユーザー毎のユニークID(本当は各自のものを使うべきではある)
            //count デフォルトだと一回のリクエストで20までしか取得できない(100以上だったら取得できないみたいなので貯めないようにしましょ)
            //statusId 1,2,3を指定することで完了以外を取得してくる
            $raw_result =  $this->curlRequestomy(
                BACKLOG_URL.
                $api_url.
                '?apiKey='.BACKLOG_API_KEY.
                '&milestoneId[]='.$milestoneID.
                '&count=100'.
                '&statusId[]=3'.
                '&statusId[]=2'.
                '&statusId[]=1');

            $result = array();
            foreach ($raw_result as $key => $value) {
                $result[$key]['issueKey'] = $value['issueKey'];
                $result[$key]['issueType'] = $value['issueType'];
                $result[$key]['summary'] = $value['summary'];
                $result[$key]['category'] = $value['category'];
                $result[$key]['milestone'] = $value['milestone'];


            }
        }else{

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

            $result = array();

            foreach ($tmp_result as $key => $value) {
                $result[] = $value;
            }
        }
        return $result;
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

}
