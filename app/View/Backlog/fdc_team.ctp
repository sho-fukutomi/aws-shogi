<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<html>
<?php echo $this->element('menu_backlog'); ?>


            <?php //debug($tsuchie_tasks)?>

<div class="wrapper">
    <div class="column cat1">
        <div class="upside">
            <table>


            <?php foreach ($ticketList as $key => $value): ?>
                <?php //debug($value)?>
                <?php
                    $summary_class = '';
                    if(!empty($value['fdc_backlog_webhooks'][0]['milestone_id'])){
                        if(
                            $value['fdc_backlog_webhooks'][0]['milestone_id']==252579 || // 期限日設定中
                            $value['fdc_backlog_webhooks'][0]['milestone_id']==252591 || // 本番確認中
                            $value['fdc_backlog_webhooks'][0]['milestone_id']==252587 || // FB
                            $value['fdc_backlog_webhooks'][0]['milestone_id']==252586 || // 期限日再設定中
                            $value['fdc_backlog_webhooks'][0]['milestone_id']==252581  // 開発中
                        ){
                            $summary_class = 'team_currenttask';
                        }
                    }
                     ?>
                <tr>
                    <?php //debug($value)?>
                    <th><?php echo $value['fdc_ticket_masters']['order'] ?></th>
                    <td><?php echo $value['fdc_ticket_masters']['key'] ?></td>
                    <td class="summary <?php echo $summary_class ?>"><?php echo !empty($value['fdc_backlog_webhooks'][0]['summary'])? $value['fdc_backlog_webhooks'][0]['summary'] : ""   ?></td>
                    <td class="table_milestone milestone_<?php echo !empty($value['fdc_backlog_webhooks'][0]['milestone_id']) ? $value['fdc_backlog_webhooks'][0]['milestone_id']  :""  ?>">
                        <?php echo !empty($value['fdc_backlog_webhooks'][0]['milestone_name']) ? $value['fdc_backlog_webhooks'][0]['milestone_name'] : "" ?>
                    </td>
                    <td><?php  echo !empty($value['fdc_ticket_masters']['be']) ? $members[$value['fdc_ticket_masters']['be']]['backlog_name'] : "" ?></td>
                    <td class="table_staff" >
                        <div class="cp_ipselect">
                        <select class="cp_sl06 ggpe_id_<?php //echo $tickets['fdc_ticket_masters']['key'] ?> " required>
                        <option value="" hidden disabled selected></option>
                        <?php foreach($teamMembers as $key => $teamMember): ?>
                            <?php if ($teamMember['all_members']['role'] == 2): ?>
                                    <option value="<?php  echo $teamMember['fdc_team_member']['members_id'] ?>" <?php echo $value['fdc_ticket_masters']['dev'] == $teamMember['fdc_team_member']['members_id'] ? 'selected' : ''  ?>> <?php echo $teamMember['all_members']['backlog_name']  ?> </option>
                            <?php endif; ?>

                        <?php endforeach; ?>
                        </select>
                        <span class="cp_sl06_highlight"></span>
                        <span class="cp_sl06_selectbar"></span>
                        </div>
                    </td>
                    <td class="table_staff" >
                        <div class="cp_ipselect">
                        <select class="cp_sl06 ggpe_id_<?php //echo $tickets['fdc_ticket_masters']['key'] ?> " required>
                        <option value="" hidden disabled selected></option>
                        <?php foreach($teamMembers as $key => $teamMember): ?>
                            <?php if ($teamMember['all_members']['role'] == 3): ?>
                                    <option value="<?php  echo $teamMember['fdc_team_member']['members_id'] ?>" <?php echo $value['fdc_ticket_masters']['tester'] == $teamMember['fdc_team_member']['members_id'] ? 'selected' : ''  ?>> <?php echo $teamMember['all_members']['backlog_name']  ?> </option>
                            <?php endif; ?>

                        <?php endforeach; ?>
                        </select>
                        <span class="cp_sl06_highlight"></span>
                        <span class="cp_sl06_selectbar"></span>
                        </div>
                    </td>
                    <td>
                        <button id="edit_team_member_<?php echo $value['fdc_ticket_masters']['key']  ?>" class="editbutton" value="<?php echo $value['fdc_ticket_masters']['key'] ?>" >update</button>
                    </td>
                    <td></td>




                </tr>
            <?php endforeach; ?>
            </table>
        </div>

        <div class="upside">


        </div>
    </div>

    <div class="column cat2">
        <div class="upside">
            <table>
                <?php foreach ($teamMembers as $key => $value): ?>
                    <?php ?>
                    <tr>
                        <td><?php echo $value['all_members']['backlog_name'] ?></td>
                        <td style="color:#000 ;background:<?php echo $roles[$value['all_members']['role']]['color'] ?>"><?php echo $roles[$value['all_members']['role']]['name'] ?></td>


                    </tr>
                <?php endforeach; ?>
            </table>



        </div>
    </div>
</div>

<script>


    $(".editbutton").on('click',function(){
        target_ticket_id = $(this).val();
        console.log(target_ticket_id);

        if(target_ticket_id) {




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

        post_flg = 0;

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


</html>
