<?php // echo $this->Html->script( 'jquery-3.2.1.min', array( 'inline' => false ) ); ?>
<?php // echo $this->Html->script( 'jquery-ui.min.js', array( 'inline' => false ) ); ?>
<?php echo '<script type="text/javascript" src="/shogi/js/jquery-3.2.1.min.js"></script>' ?>
<?php echo '<script type="text/javascript" src="/shogi/js/jquery-ui.min.js"></script>' ?>

<html>
    <head>
        <title>ぽぽぽ</title>
        <style>
            body {
                background-color: #000;
                color: #3fff5f;
                margin: 10;
                padding: 0px;
                font-family: ricty;
            }
            a:link { color: #6467ff; }
            a:visited { color: #e2a6ff; }
            a:hover { color: #f53e65; }
            a:active { color: #ff8000; }
            .css-fukidashi {
              padding: 0;
              margin: 0;
            }
            .text {
              width: 200px;
              position: relative;
              margin:80px 3px 3px;
              padding: 3px;
              border: 0px solid #ccc;
            }
            .fukidashi {
              display: none;
              width: 400px;
              position: absolute;
              z-index: 2;
              /* left: 250px; */
              padding: 16px;
              border-radius: 5px;
              background: #1b4034;
              color: #d3ffe8;
              font-weight: bold;
            }
            /* .fukidashi:after {
              position: absolute;
              width: 0;
              height: 0;
              left: 0;
              bottom: -19px;
              margin-left: 10px;
              border: solid transparent;
              border-color: rgba(51, 204, 153, 0);
              border-top-color: #33cc99;
              border-width: 10px;
              pointer-events: none;
              content: " ";
            } */
            .text:hover + .fukidashi {
              display: block;
            }
            h3 {
                color: #8cffc6;
                display: block;
                font-size: 1.15em;
                -webkit-margin-before: 0em;
                -webkit-margin-after: 0em;
                -webkit-margin-start: 0px;
                -webkit-margin-end: 0px;
                padding: 0px;
                font-weight: bold;
            }
            ul, ol {
                background: #020202;
                /* box-shadow: 0px 0px 0px 10px #ada552; */
                border: dashed 2px #3fff5f;
                border-radius: 9px;
                margin-left: 10px;
                margin-right: 10px;
                padding: 0.5em 0.5em 0.5em 2em;
                color: #78a295;
            }



            ul li, ol li {
              line-height: 1.0;
              padding: 0.0em 0;
            }
            h3 {
                display: block;
                font-size: 1.00em;
                -webkit-margin-before: 0em;
                -webkit-margin-after: 0em;
                -webkit-margin-start: 0px;
                -webkit-margin-end: 0px;
                font-weight: bold;
            }
            .column {
              height: 100vh;
              width: 100%;
            }
            .cat1 {
              /* background: url(images/cat1.jpg) no-repeat top center; */
              background-size: cover;
            }
            .cat2 {
              /* background: url(images/cat2.jpg) no-repeat center center; */
              background-size: cover;
            }
            @media all and (min-width: 500px) {
                .wrapper{
                    display: flex;
                }
            }
            .notfdc {
                color: #4d635c;
            }
            .fdc{
                color: #78a295;
            }

        </style>
    </head>
    <?php
        $today = date("Y-m-d");


        echo '<div class="wrapper">';
        // }
            echo '  <div class="column cat1">';
                $result = formatBacklog();
                foreach ($result as $key => $value) {
                    echo '<ul>';
                        echo '<h3>';
                            echo $key.' '.count($value).'件';
                        echo '</h3>';

                        foreach ($value as $key => $value) {

                            if(categorycheck($value['category']) == 'Ｆ'){
                                $addClass = ' class="fdc"';
                            }
                            else{
                                $addClass = ' class="notfdc"';
                            }
                            echo '<li'.$addClass .'>';
                                echo '<a href="https://love.backlog.jp/view/'.$value['issueKey'].'">'.$value['issueKey'].'</a>';
                                echo '<span> '.assigneecheck($value['assignee']['name']).'</span>';
                                echo '<span> '.createdUsercheck($value['createdUser']['name']).'</span>';
                                echo '<span> '.categorycheck($value['category']).'</span>';
                                echo '<span class="text">'.$value['summary'].'</span>';
                                echo '<p class="fukidashi">'.$value['description'].'</p>';
                            echo '</li>';
                            // echo '<pre>';
                            //          var_dump($value);
                            // echo '</pre>';
                        }
                    echo '</ul>';
                }

                echo '</div>';
            echo '  <div class="column cat2">';

            echo '  <div class="upside">';
                    $TeamMembers = getMemberlist();
                    $TeamMembersDetail = array();
                    foreach($TeamMembers as $key => $value){
                        foreach($value as $key2 => $value2){
                            $TeamMembersDetail[$key][$key2] = getUserTask($value2);
                        }
                    }
                    echo '<pre>';
                        // var_dump($TeamMembersDetail);
                    echo '</pre>';

                    foreach($TeamMembersDetail as $key => $value){
                        echo '<div>';
                            echo $key; // Team Jeff
                        echo '</div>';
                                // var_dump($value);

                                $list = array(
                                    "PENDING"                           => "5b4d4d9e95d1ad0874528a04",
                                    "CLOSED"                            => "5b4d4d99a68f925adbb85223",
                                    "RELEASED-PRODUCTION"               => "5b4d4d9342a723f457e34c7c",
                                    "FOR RELEASE-PRODUCTION"            => "5b4d4d851cd8e30871de21aa",
                                    "DONE-STAGING-WT RELEASE TO LIVE"   => "5b4d4d7705e106519935138c",
                                    "ON TEST-STAGING_"                  => "5b4d4d5d61a48f0891d5ebe9",
                                    "RELEASED-STAGING_"                 => "5b4d4d55ec5938f2a7b36fbc",
                                    "FOR RELEASE-STAGING"               => "5b4d4cd34877ca1013784f43",
                                    "WT Review or Adjust Release"       => "5b5ef37b2ded8753eee24107",
                                    "GGPEI TEST-DEV"                    => "5b4d4cc5f972bd78428555df",
                                    "FINAL TEST-DEV"                    => "5b4d4cb695d1ad087452739c",
                                    "ON TEST-DEV"                      => "5b4d4ca1281ef5370d4d699e",
                                    "FOR TESTING-DEV"                   => "5b4d4fa071efa46b72f92e18",
                                    "FOR RELEASE-DEV"                  => "5b4d4c8f3cd91f668bf56065",
                                    "FOR CODE REVIEW"                  => "5b4d4c83196c2c03af7ec49f",
                                    "FEEDBACK-FIXING BUG"               => "5b4d4cae168a92088b4817b9",
                                    "ONGOING-DEV"                       => "5b4d4c5ba209bce449d15877",
                                    "TASK"                              => "5b4d4c4d596cd4d00bdd5321",
                                    "TODO"                              => "5b4d4c457c73ecf308842895"
                                );

                                foreach ($value as $key2 => $value2) {
                                    echo '<li>';
                                        echo '<span>';
                                            echo $key2; // epoy
                                        echo '</span>';
                                        echo '<ul>';

                                        foreach($value2 as $key3 => $value3){
                                            // echo '<pre>';
                                            echo '<li>';
                                            echo $value3['name'].$value3['due'].$list[$value3['idList']];
                                            echo '</li>';
                                        }
                                        echo '</ul>';

                                    echo '</li>';
                                }


                        }
                        // break;


                echo '  </div>';

                echo '  <div class="downside">';

                    $result = formatTrello();
                    foreach ($result as $key => $value) {
                        echo '<ul>';
                            echo '<h3>';
                                echo $key.' '.count($value).'cards';
                            echo '</h3>';
                            foreach ($value as $key => $value) {
                                echo '<li>';
                                    echo '<a href="'.$value['shortUrl'].'">'. substr($value['name'],0,7).'</a>';
                                    $due = adjustmentTimeZone($value['badges']['due'],$today);
                                    $color = '';
                                        if($due[1] == ''){
                                        $color = '' ;
                                        }elseif($due[1] > 43200){
                                        $color = ' style="color: #90ffbe;"' ;
                                        }elseif($due[1] <= 43200 && $due[1] >= 0){
                                            $color = ' style="color: #ff9090;"' ;
                                        }elseif($due[1] < 0){
                                            $color = ' style="color: #ff0404;"' ;
                                        }else{
                                            $color = '';
                                        }
                                    echo '<span'.$color.'>';
                                        echo ' '.$due[0].' ';
                                    echo '</span>';
                                    // echo adjustmentTimeZone($value['dateLastActivity']);
                                    echo '<span class="text">'.$value['desc'].'</span>';
                                    echo '<div class="fukidashi">';
                                    // var_dump($value['idMembers']);
                                    foreach ($value['idMembers'] as $value2) {
                                        echo('<div>');
                                        echo getmemberName($value2);
                                        echo('</div>');
                                    }
                                    echo '</div>';
                                echo '</li>';
                                //var_dump($value);
                            }
                        echo '</ul>';

                    }
                echo '  </div>';
            echo '</div>';
        echo '</div>';
        function adjustmentTimeZone($timeFromTrello,$today){
            $result = array('','');
            if($timeFromTrello){
                // return left($timeFromTrello,10) ;
                $time1 = strtotime(substr($timeFromTrello,0,10).' '.substr($timeFromTrello,12,10));
                $tmp = strtotime('+8 hour' , $time1);
                $time2 = strtotime($today);
                $diff = $tmp - $time2;

                $result = array(
                    date('m-d',$tmp),
                    $diff
                );
            }
            return $result;
        }
        function getMilestoneList(){
            $url = 'https://love.backlog.jp/api/v2/projects/25169/versions?apiKey=H53eJK4oE4OnQLwibkjyihRGgnVxNZsCx4akeQ5uOhJqmNkR3GvKIkoJmONrwy6O&count=100';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

            $response = curl_exec($curl);
            $result = json_decode($response, true);
            curl_close($curl);

            $return_result = array();
            foreach ($result as $value) {
                $return_result = $return_result + array($value['name'] => $value['id']);
            }
            return $return_result;
        }


        function assigneecheck($name){
            $result = '　';
            if ($name == 'NC.Fukutomi') {
                $result = '自';
            }
            return $result;
        }
        function createdUsercheck($name){
            $result = '　';
            if ($name == 'NC.Fukutomi') {
                $result = '書';
            }
            return $result;
        }
        function categorycheck($categorys){
            $result = '　';
            foreach ($categorys as $key => $value) {
                //var_dump( $value['name'] );
                if ($value['name'] == '開発（FDC）') {
                    $result = 'Ｆ';
                }
            }
            return $result;
        }
        function formatBacklog(){
            //https://xx.backlog.jp/api/v2/users/myself?apiKey=abcdefghijklmn

                $base_url = 'https://love.backlog.jp/';
                $api_url2 = '/api/v2/issues';

                //apiKey ユーザー毎のユニークID(本当は各自のものを使うべきではある)
                //count デフォルトだと一回のリクエストで20までしか取得できない(100以上だったら取得できないみたいなので貯めないようにしましょ)
                //statusId 1,2,3を指定することで完了以外を取得してくる
                $api_key = '?apiKey=H53eJK4oE4OnQLwibkjyihRGgnVxNZsCx4akeQ5uOhJqmNkR3GvKIkoJmONrwy6O&count=100&statusId[]=3&statusId[]=2&statusId[]=1&';
                $param = '&milestoneId[]=';

                $milestonelist = getMilestoneList();

                // $milestonelist = array(
                //     "90-Close(完了)" => 191419,
                //     "80-Pending but finsh (未完終了)" => 191418,
                //     "62-Testing Fix after release(公開後テスト)" => 197021,
                //     "61-Fixing after release(公開後の修正中)" => 191417,
                //     "51-Done release(公開完了)" => 191416,
                //     "42-Waiting release(公開待ち)" => 191415,
                //     "41-Waiting Apple/Google(Apple/Google待ち)" => 191414,
                //     "33-Others check (FDC以外のチェック中)" => 197020,
                //     "32-JP staff check (日本人チェック中)" => 197019,
                //     "31-FDC testing(FDCテスト中)" => 197018,
                //     "26-Fixing FB (FB修正中)" => 197543,
                //     "25-doing without develop(開発以外作業中)" => 197022,
                //     "24-App Develop underway(App開発中)" => 197017,
                //     "23-Waiting start App develop (App開発着手待ち)" => 197016,
                //     "22-Develop underway(開発中)" => 191411,
                //     "21-Waiting start develop (開発着手待ち)" => 191410,
                //     "12-Design underway(制作開発中)" => 191409,
                //     "11-Waiting start design(制作着手待ち)" => 191408,
                //     "05-Making spec(仕様作成中)" => 197015,
                //     "04-Requirement definition(要件定義)" => 197013,
                //     "03-survey(調査中、再現中)" => 197012,
                //     "02-Proposal(提案)" => 191407,
                //     "01-New" => 191406,
                // );

            foreach ($milestonelist as $key => $value) {
               $curl = curl_init();
               curl_setopt($curl, CURLOPT_URL, $base_url.$api_url2.$api_key.$param.$milestonelist[$key]);
            //    curl_setopt($curl, CURLOPT_URL, $base_url.$api_url2.$api_key.$param.'197013');
               curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
               curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

               $response = curl_exec($curl);
               $result[$key] = json_decode($response, true);

               curl_close($curl);

            }
            return $result;
        }
        function formatTrello(){
            $result = '';
            $base_url = 'https://trello.com/1/lists/';
            $base_url2 = '/cards?';
            $api_key = 'key=34a2f2656df485531bb44bb6b3699ea6';
            $api_token = '&token=2fb661fa1054e60475e9ef8488435c2e89567ef25561fca2a8268601de098575';
            $list = array(
                "PENDING"                           => "5b4d4d9e95d1ad0874528a04",
                "CLOSED"                            => "5b4d4d99a68f925adbb85223",
                "RELEASED-PRODUCTION"               => "5b4d4d9342a723f457e34c7c",
                "FOR RELEASE-PRODUCTION"            => "5b4d4d851cd8e30871de21aa",
                "DONE-STAGING-WT RELEASE TO LIVE"   => "5b4d4d7705e106519935138c",
                "ON TEST-STAGING_"                  => "5b4d4d5d61a48f0891d5ebe9",
                "RELEASED-STAGING_"                 => "5b4d4d55ec5938f2a7b36fbc",
                "FOR RELEASE-STAGING"               => "5b4d4cd34877ca1013784f43",
                "WT Review or Adjust Release"       => "5b5ef37b2ded8753eee24107",
                "GGPEI TEST-DEV"                    => "5b4d4cc5f972bd78428555df",
                "FINAL TEST-DEV"                    => "5b4d4cb695d1ad087452739c",
                "ON TEST-DEV"                      => "5b4d4ca1281ef5370d4d699e",
                "FOR TESTING-DEV"                   => "5b4d4fa071efa46b72f92e18",
                "FOR RELEASE-DEV"                  => "5b4d4c8f3cd91f668bf56065",
                "FOR CODE REVIEW"                  => "5b4d4c83196c2c03af7ec49f",
                "FEEDBACK-FIXING BUG"               => "5b4d4cae168a92088b4817b9",
                "ONGOING-DEV"                       => "5b4d4c5ba209bce449d15877",
                "TASK"                              => "5b4d4c4d596cd4d00bdd5321",
                "TODO"                              => "5b4d4c457c73ecf308842895"
            );
            foreach ($list as $key => $value) {
                // var_dump($base_url.$value.$base_url2.$api_key.$api_token);
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $base_url.$value.$base_url2.$api_key.$api_token);
                // curl_setopt($curl, CURLOPT_URL, $base_url.'5b4d4c5ba209bce449d15877'.$base_url2.$api_key.$api_token);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

                $response = curl_exec($curl);
                $result[$key] = json_decode($response, true);
                curl_close($curl);
                //var_dump($response);
            }


            // echo '<pre>';
            //     var_dump($result);
            // echo '</pre>';

            return $result;

        }

        function getUserTask($userID = 0){
            $base_url = 'https://api.trello.com/1/members/';
            $base_url2 = '/cards?';
            $api_key = 'key=34a2f2656df485531bb44bb6b3699ea6';
            $api_token = '&token=2fb661fa1054e60475e9ef8488435c2e89567ef25561fca2a8268601de098575';
            // echo $base_url.$userID.$base_url2.$api_key.$api_token;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $base_url.$userID.$base_url2.$api_key.$api_token);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

            $response = curl_exec($curl);
            $result = json_decode($response, true);
            curl_close($curl);
            return $result;
        }




        function getmemberName($hash){
            $memberList = array(
                "5b4c4da57d88501a017e7540" =>	'Tsuchie',
                "5b4eb54851d38234ac325ccf" =>	'Frank',
                "5b4d8f12bd6b61393ab7c01b" =>	'FRED',
                "5b4d61ffcdc60188edf4e307" =>	'NerfeYan',
                "5b037231d92f49701f36aec7" =>	'Mary Rose Carcueva',
                "56c44f36602144689c794a3f" =>	'Fukutomi',
                "5b4e92666ea7d146de38989d" =>	'Epoy',
                "5b4da0ce4a29522654e05380" =>	'Jo',
                "5b4d4721698c6c5c2f561443" =>	'Joyii',
                "57c087eacf316743b0150df0" =>	'Raymund Vincent Ylaya',
                "5b4d8896a0e54136df75a8ca" =>	'Valerie',
                "5b4d8988fbe57c51e140ae3f" =>	'Marjiee',
                "5b0b5eb1be757e0cca86362d" =>	'katekbg',
                "5b4d8b23991d569c176559de" =>	'Serj',
                "5b4807642a6b4258ac3e30e3" =>	'Kuyaj',
                "5b48150b0e4d281054826aab" =>   'yun'   ,
                "55113284dda70271f8e6d08e" =>   'Lester Padul'  ,
                "552c78c06ba80a2bd60655d6" =>   'blezel tajor'  ,
                "5ac34c79437e7120a85607a2" =>   'Kokoy'   ,
                "5b4d88bf6dc49772e6fd54b3" =>   'Neil Ross Rances' ,
                "5b4daf226820f240dcf46e9c" =>   'Park' ,
                "5b4e9249a161b2289af116b1" =>   'Karl Lim'  ,
                "5b4edf4c6d78a87f2d139b87" =>   'testkim one' ,
                "57cf86f9920f5bb772e8658f" =>   'Yamaaki' ,
                "5533080dcba47de721101186" =>   'Roy'
            );
            return $memberList[$hash];

        }

        function getMemberlist(){

            $memberList = array(
                'Teamjeff' =>   array(
                    'Epoy'         => "5b4e92666ea7d146de38989d",
                    'Ross'         => "5b4d88bf6dc49772e6fd54b3",
                    'Val'          => "5b4d8896a0e54136df75a8ca",
                ),
                'TeamFred' => array(
                    'Fred'         => "5b4d8f12bd6b61393ab7c01b",
                    'Jo'           => "5b4da0ce4a29522654e05380",
                    'Chin'         => "57c087eacf316743b0150df0",
                ),
                'TeamFrank' => array(
                    'Frank'        => "5b4eb54851d38234ac325ccf",
                    'Karl'         => "5b4e9249a161b2289af116b1",
                ),
                'TeamiOS' => array(
                    'Kokoy'        => "5ac34c79437e7120a85607a2",
                    'KuyaJ'        => "5b4807642a6b4258ac3e30e3",
                    'Serj'         => "5b4d8b23991d569c176559de",
                ),
                'Teamtester' => array(
                    'Efren'        => "5b4d61ffcdc60188edf4e307",
                    'Mary'         => "5b037231d92f49701f36aec7",
                    'Amay'         => "5b4d8988fbe57c51e140ae3f",
                    'Joyi'         => "5b4d4721698c6c5c2f561443",
                    'bleze'        => "552c78c06ba80a2bd60655d6",
                    'Kim'          => '5b4edf4c6d78a87f2d139b87',
                ),
                'TeamManager' => array(
                    'Yun'          => '5b48150b0e4d281054826aab',
                    'Lester'       => "55113284dda70271f8e6d08e",
                    'Tsuchie'      => "5b4c4da57d88501a017e7540",
                    'Fukutomi'     => "56c44f36602144689c794a3f",
                    'Yamaaki'      => '57cf86f9920f5bb772e8658f',
                    'Park'         => "5b4daf226820f240dcf46e9c"
                ),
            );
            return $memberList;
        }



    ?>


</html>
