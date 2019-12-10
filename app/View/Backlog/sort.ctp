<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

</head>

<?php echo $this->element('menu_backlog'); ?>
<?php $teamcount = 0 ?>
<?php foreach ($arrayTicketList as $key => $newTicketList): ?>
    <?php if(empty($newTicketList)){ continue ;} ?>
    <h2 class="glaystring"><?php echo $key ?></h2>
    <table>
        <thead>
            <tr>
                <th>Order</th>
                <th>Type</th>
                <th>key</th>
                <th>summary</th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th class="milestone"></th>
                <th>milestone</th>
                <th>dev start</th>
                <th>dev done</th>
                <th>GGPE check done</th>
                <th>release</th>
                <th>Team</th>
                <th>FDC</th>
                <th>GGPE</th>
                <th>Design</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="sortdata<?php echo ++$teamcount ?>">
            <?php $num = 1; ?>
            <?php foreach($newTicketList as $key => $tickets): ?>
                <?php  //debug($tickets)?>
                <tr id=raw_<?php echo $teamcount.'_'.$key?> >
                    <th name=num_data class="team_<?php echo $tickets['fdc_ticket_masters']['fdc_team']?>"><?php echo $num++  //$tickets['fdc_ticket_masters']['order'] ?></th>
                    <td class="type_<?php echo !empty($tickets['fdc_backlog_webhooks']) ?  $tickets['fdc_backlog_webhooks'][0]['issueType_id'] : "9999" ?>"><?php echo !empty($tickets['fdc_backlog_webhooks']) ? $tickets['fdc_backlog_webhooks'][0]['issueType_name'] :"" ?></td>
                    <td class=ticket_no > <a href="ticketinfo/<?php echo $tickets['fdc_ticket_masters']['key'] ?>" target="_blank"><?php echo $tickets['fdc_ticket_masters']['key'] ?></a></td>
                    <td class="table_summary"  ><?php echo !empty($tickets['fdc_backlog_webhooks']) ? $tickets['fdc_backlog_webhooks'][0]['summary'] : ''  ?>  </td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 01 ? 'milestone_01': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 02 ? 'milestone_02': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 10 ? 'milestone_10': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 11 ? 'milestone_11': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 20 ? 'milestone_20': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 21 ? 'milestone_21': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 30 ? 'milestone_30': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 31 ? 'milestone_31': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 32 ? 'milestone_32': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 33 ? 'milestone_33': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 40 ? 'milestone_40': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 50 ? 'milestone_50': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 60 ? 'milestone_60': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 61 ? 'milestone_61': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 71 ? 'milestone_71': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 73 ? 'milestone_73': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 89 ? 'milestone_80': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 90 ? 'milestone_90': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 91 ? 'milestone_91': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 93 ? 'milestone_93': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="<?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) >= 99 ? 'milestone_99': 'notyet' : 'notyet'?> milestone"></td>
                    <td class="table_milestone milestone_<?php echo !empty($tickets['fdc_backlog_webhooks'][0]['milestone_id']) ? $tickets['fdc_backlog_webhooks'][0]['milestone_id'] : '9999'  ?>"  >
                        <?php echo !empty($tickets['fdc_backlog_webhooks']) ? $tickets['fdc_backlog_webhooks'][0]['milestone_name'] : ''  ?>
                    </td>
                    <?php $date_enterable = !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) < 31 ? 'not yet': 'show' : 'no data' ?>
                    </td>
                    <td>
                        <?php if ($date_enterable == 'show'): ?>
                            <div><input type="date"class="datebox plan dev_start_plan_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" name="dev_start_plan_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" value="<?php echo $tickets['fdc_ticket_masters']['dev_start_plan'] ?>"></div>
                            <div><input type="date"class="datebox result dev_start_result_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" name="dev_start_result<?php echo $tickets['fdc_ticket_masters']['key']  ?>" value="<?php echo $tickets['fdc_ticket_masters']['dev_start_result'] ?>"></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($date_enterable == 'show'): ?>
                            <div><input type="date"class="datebox plan <?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) < 31 ? 'glayout': '' : ''?> dev_done_plan_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" name="dev_start_plan_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" value="<?php echo $tickets['fdc_ticket_masters']['dev_done_plan'] ?>"></div>
                            <div><input type="date"class="datebox result dev_done_result_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" name="dev_start_result<?php echo $tickets['fdc_ticket_masters']['key']  ?>" value="<?php echo $tickets['fdc_ticket_masters']['dev_done_result'] ?>"></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($date_enterable == 'show'): ?>
                            <div><input type="date"class="datebox plan <?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) < 31 ? 'glayout': '' : ''?> ggpe_check_done_plan_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" name="ggpe_check_done_plan_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" value="<?php echo $tickets['fdc_ticket_masters']['ggpe_check_done_plan'] ?>"></div>
                            <div><input type="date"class="datebox result ggpe_check_done_result_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" name="ggpe_check_done_result_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" value="<?php echo $tickets['fdc_ticket_masters']['ggpe_check_done_result'] ?>"></div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($date_enterable == 'show'): ?>
                            <div><input type="date"class="datebox plan <?php echo !empty($tickets['fdc_backlog_webhooks']) ? substr($tickets['fdc_backlog_webhooks'][0]['milestone_name'],0,2) < 31 ? 'glayout': '' : ''?> release_plan_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" name="release_plan_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" value="<?php echo $tickets['fdc_ticket_masters']['release_plan'] ?>"></div>
                            <div><input type="date"class="datebox result release_result_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" name="release_result_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" value="<?php echo $tickets['fdc_ticket_masters']['release_result'] ?>"></div>
                        <?php endif; ?>
                    </td>
                    <td class="team" >
                        <?php //if ($date_enterable != 'no data'): ?>
                            <div class="cp_ipselect" >
                            <select class="cp_sl06 team_id_<?php echo $tickets['fdc_ticket_masters']['key'] ?> " required>
                            <option value="" hidden disabled selected></option>
                            <?php foreach($team_list as $team_key => $team): ?>
                                <?php //debug($member) ?>
                                <option value="<?php echo $team['fdc_team']['id'] ?>" <?php echo $tickets['fdc_ticket_masters']['fdc_team'] == $team['fdc_team']['id'] ? 'selected' : ''  ?>> <?php echo $team['fdc_team']['name'] ?> </option>
                            <?php endforeach; ?>
                            </select>
                            <span class="cp_sl06_highlight"></span>
                            <span class="cp_sl06_selectbar"></span>
                            </div>
                        <?php //endif; ?>
                    </td>
                    <td class="table_staff" >
                        <?php if ($date_enterable != 'no data'): ?>
                            <div class="cp_ipselect">
                            <select class="cp_sl06 be_id_<?php echo $tickets['fdc_ticket_masters']['key'] ?> " required>
                            <option value="" hidden disabled selected></option>
                            <?php foreach($be_list as $be_id => $be_name): ?>
                                <option value="<?php echo $be_id ?>" <?php echo $tickets['fdc_ticket_masters']['be'] == $be_id ? 'selected' : ''  ?>> <?php echo $be_name ?> </option>
                            <?php endforeach; ?>
                            </select>
                            <span class="cp_sl06_highlight"></span>
                            <span class="cp_sl06_selectbar"></span>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="table_staff" >
                        <?php if ($date_enterable != 'no data'): ?>
                            <div class="cp_ipselect">
                            <select class="cp_sl06 ggpe_id_<?php echo $tickets['fdc_ticket_masters']['key'] ?> " required>
                            <option value="" hidden disabled selected></option>
                            <?php foreach($ggpe_list as $ggpe_id => $ggpe_name): ?>
                                <?php //debug($member) ?>
                                <option value="<?php echo $ggpe_id ?>" <?php echo $tickets['fdc_ticket_masters']['ggpe'] == $ggpe_id ? 'selected' : ''  ?>> <?php echo $ggpe_name ?> </option>
                            <?php endforeach; ?>
                            </select>
                            <span class="cp_sl06_highlight"></span>
                            <span class="cp_sl06_selectbar"></span>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="table_staff" >
                        <?php if ($date_enterable != 'no data'): ?>
                            <div class="cp_ipselect">
                            <select class="cp_sl06 design_id_<?php echo $tickets['fdc_ticket_masters']['key'] ?> " required>
                            <option value="" hidden disabled selected></option>
                            <?php foreach($design_list as $design_id => $design_name): ?>
                                <?php //debug($member) ?>
                                <option value="<?php echo $design_id ?>" <?php echo $tickets['fdc_ticket_masters']['design'] == $design_id ? 'selected' : ''  ?>> <?php echo $design_name ?> </option>
                            <?php endforeach; ?>
                            </select>
                            <span class="cp_sl06_highlight"></span>
                            <span class="cp_sl06_selectbar"></span>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button id="edit_ticket_master_<?php echo $tickets['fdc_ticket_masters']['key']  ?>" class="editbutton" value="<?php echo $tickets['fdc_ticket_masters']['key'] ?>" >add</button>
                    </td>
                </tr>
                <?php //break; ?>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endforeach; ?>


<script>


        <?php for ($i = 0; $i <= $teamcount; $i++): ?>
            $('#sortdata<?php echo $i?>').sortable();

            // sortstopイベントをバインド
            $('#sortdata<?php echo $i?>').bind('sortstop',function(){
                // 番号を設定している要素に対しループ処理

                console.log($(this).find('[name="num_data"]'));
                $(this).find('[name="num_data"]').each(function(index,element){
                    $(this).html(index+1);
                });

                sortnum = $("#sortdata<?php echo $i?>").children("tr").length;
                result_array = {};
                for (var i = 0; i < sortnum; i++) {
                    result_array[String($("#raw_<?php echo $i?>_"+i ).children('[class="ticket_no"]').text()).trim()] = $("#raw_<?php echo $i?>_"+i ).children('[name="num_data"]').text();
                    // console.log(String($("#raw_<?php echo $i?>_"+i ).children('[class="ticket_no"]').text()).trim())
                }
                post_data = JSON.stringify(result_array);
                console.log(post_data)
                $.ajax({
                    url:'./updatesort',
                    type:'POST',
                    data:post_data,
                    success: function(j_data){
                            // 処理を記述
                        console.log(j_data);
                    }
                });

            });
        <?php endfor;?>









    $(".editbutton").on('click',function(){
        post_flg = 1;
        target_ticket_id = $(this).val();
        console.log(target_ticket_id);

        if(target_ticket_id) {
            be_id = $(".be_id_" + target_ticket_id).val();
            ggpe_id = $(".ggpe_id_" + target_ticket_id).val();
            design_id = $(".design_id_" + target_ticket_id).val();
            team_id = $(".team_id_" + target_ticket_id).val();

            dev_start_plan = $(".dev_start_plan_" + target_ticket_id).val();
            dev_start_result = $(".dev_start_result_" + target_ticket_id).val();
            dev_done_plan = $(".dev_done_plan_" + target_ticket_id).val();
            dev_done_result = $(".dev_done_result_" + target_ticket_id).val();
            ggpe_check_done_plan = $(".ggpe_check_done_plan_" + target_ticket_id).val();
            ggpe_check_done_result = $(".ggpe_check_done_result_" + target_ticket_id).val();
            release_plan = $(".release_plan_" + target_ticket_id).val();
            release_result = $(".release_result_" + target_ticket_id).val();

            console.log(be_id);
            console.log(ggpe_id);
            console.log(design_id);
            console.log(team_id);
            console.log(dev_start_plan);
            console.log(dev_start_result);
            console.log(dev_done_plan);
            console.log(dev_done_result);
            console.log(ggpe_check_done_plan);
            console.log(ggpe_check_done_result);
            console.log(release_plan);
            console.log(release_result);

           if(be_id == null && ggpe_id == null && design_id && null){
               post_flg = 0;
           }else{
               post_data = {
                   "target_ticket_id" : target_ticket_id,
                   "be_id" : be_id,
                   "ggpe_id" : ggpe_id,
                   "design_id" : design_id,
                   "team_id" : team_id,
                   "dev_start_plan" : dev_start_plan,
                   "dev_start_result" : dev_start_result,
                   "dev_done_plan" : dev_done_plan,
                   "dev_done_result" : dev_done_result ,
                   "ggpe_check_done_plan" :ggpe_check_done_plan,
                   "ggpe_check_done_result" : ggpe_check_done_result,
                   "release_plan" : release_plan,
                   "release_result" : release_result
               }
           }

        }else{
           post_flg = 0;

        }
        console.log('post_flg=' + post_flg );
        if(post_flg == 1){
            console.log(post_data)
            $.ajax({
                url:'./updatebysort',
                type:'POST',
                data:post_data,
                success: function(j_data){ 
                    // 処理を記述
                    console.log(j_data);
                }
            });
        }

    });



</script>
