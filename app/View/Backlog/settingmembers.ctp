<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>


<?php echo $this->element('menu_backlog'); ?>
<div class="wrapper">
    <div class="column cat1">
        <div class="upside">
            <?php foreach ($teamList as $key => $team) :?>
                <div class="separate_team">
                <h3><?php echo $teamList[$key]['fdc_team']['name'] ?></h3>
                <table>
                    <?php if (isset($membersByTeam[$team['fdc_team']['id']])): ?>
                        <tr>
                            <th>unique_key</th>
                            <th>Name</th>
                            <th>Nickname</th>
                            <th>Role</th>
                            <th>edit</th>
                        </tr>
                        <?php foreach ($membersByTeam[$team['fdc_team']['id']] as $key2 => $teamMember): ?>
<?php //debug($teamMember)?>
                            <tr>
                                <th class="team_<?php echo $team['fdc_team']['id'] ?>_key_<?php echo $teamMember['unique_key'] ?>" > <?php echo $teamMember['unique_key'] ?></th>
                                <td class="team_<?php echo $team['fdc_team']['id'] ?>_key_<?php echo $teamMember['unique_key'] ?>" > <?php echo $teamMember['name'] ?> </td>
                                <td class="team_<?php echo $team['fdc_team']['id'] ?>_key_<?php echo $teamMember['unique_key'] ?>" > <?php echo $teamMember['nick_name'] ?> </td>
                                <td class="team_<?php echo $team['fdc_team']['id'] ?>_key_<?php echo $teamMember['unique_key'] ?> roletext" style="background:<?php echo $teamMember['role']['color'] ?>" > <?php echo $teamMember['role']['name']?> </td>
                                <td>
                                    <button id="delete_from_team_id_<?php echo $teamMember['unique_key'] ?>" class="editbutton" value="<?php echo $team['fdc_team']['id']?>">delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <tr>
                        <td>
                            <div class="cp_ipselect">
                            <select class="cp_sl06 add_team_id_<?php echo $team['fdc_team']['id'] ?> " required>
                            <option value="" hidden disabled selected></option>
                            <?php foreach($backlogMembers as $key3 => $member): ?>
                                <<?php //debug($member) ?>
                                <option value="<?php echo $key3 ?>"> <?php echo $member['backlog_name']; ?> </option>
                            <?php endforeach; ?>
                            </select>
                            <span class="cp_sl06_highlight"></span>
                            <span class="cp_sl06_selectbar"></span>
                            </div>
                        </td>
                        <td>
                            <button id="add_to_team_id_<?php echo $key ?>" class="editbutton" value="<?php echo $team['fdc_team']['id']?>" >add</button>
                        </td>
                    </tr>
                </table>
                </div>
            <?php endforeach;?>

        </div>

        <div class="upside">

        </div>
    </div>

    <div class="column cat2">
        <div class="upside">
            <table>
                <?php //debug(//$backlogMembers)?>
                <?php foreach ($backlogMembers as $key => $value): ?>
                    <?php //debug($value)?>
                    <tr>
                        <th><?php echo $value['backlog_id']  ?></th>
                        <td><?php echo $value['backlog_name'] ?></td>
                        <td>
                            <input type="text"class="textbox member_update_nick_name_<?php echo $value['backlog_id'] ?>" name="nick_name_<?php echo $value['backlog_id']  ?>" value="<?php echo $value['nickname'] ?>">
                        </td>
                        <td class="roletext" style="background:<?php echo $value['color']?>">
                            <div class="cp_ipselect">
                            <select class="roletext cp_sl06 member_update_role_<?php echo $value['backlog_id'] ?>" required>
                            <option value="" hidden disabled selected></option>
                            <?php foreach ($roleList as $roleNumber => $role): ?>
                                <option value="<?php echo $role['fdc_role']['id'] ?>" <?php echo $role['fdc_role']['id']==$value['role'] ? 'selected' : ''  ?>> <?php echo $role['fdc_role']['name']; ?> </option>
                            <?php endforeach; ?>
                            </select>
                            <span class="cp_sl06_highlight"></span>
                            <span class="cp_sl06_selectbar"></span>
                            </div>
                        </td>
                        <td>
                            <button id="member_update_<?php echo $value['backlog_id'] ?>" class="editbutton" value="<?php echo $value['backlog_id'] ?>">EDIT</button>
                        </td>
                    </tr>
                <?php  endforeach; ?>
            </table>


        </div>
    </div>
</div>


<script>
     $(".editbutton").on('click',function(){

         post_flg = 1;

        if(~$(this).attr('id').indexOf('delete_from_team')) {
            task = 'delete_from_team';
            target_team_id = $(this).val();
            target_user_id = $(this).attr('id').replace("delete_from_team_id_","");
            console.log(task);
            console.log(target_team_id);
            console.log(target_user_id);

            if(task == null || target_team_id == null || target_user_id == null){
                post_flg = 0;
            }else{
                post_data = {
                    "task" : task,
                    "target_team_id" : target_team_id,
                    "target_user_id" : target_user_id
                }
            }

        }else if(~$(this).attr('id').indexOf('add_to_team')){
            task = 'add_to_team';
            target_team_id = $(this).val();
            target_user_id = $(".add_team_id_" + target_team_id).val();

            console.log(task);
            console.log(target_team_id);
            console.log(target_user_id);

            if(task == null || target_team_id == null || target_user_id == null){
                post_flg = 0;
            }else{
                post_data = {
                    "task" : task,
                    "target_team_id" : target_team_id,
                    "target_user_id" : target_user_id
                }
            }

        }else if(~$(this).attr('id').indexOf('member_update')){

            task = 'member_update';
            target_user_id = $(this).val();
            target_user_role = $(".member_update_role_" + target_user_id).val();
            target_user_nick_name = $(".member_update_nick_name_" + target_user_id).val();

            console.log(task);
            console.log(target_user_id);
            console.log(target_user_role);
            console.log(target_user_nick_name);

            if(task == null || target_user_id == null || target_user_role == null || target_user_nick_name == null){
                post_flg = 0;
            }else{
                post_data = {
                    "task" : task,
                    "target_user_id" : target_user_id,
                    "target_user_role" : target_user_role,
                    "target_user_nick_name" : target_user_nick_name
                }
            }



        }else{
            post_flg = 0;

        }

console.log('post_flg=' + post_flg );
        if(post_flg == 1){
            console.log(post_data)
            $.ajax({
                    url:'./updatemembers',
                    type:'POST',
                    data:post_data,
                    success: function(j_data){
    
                        // 処理を記述
                        console.log(j_data);
                    }
                }


                );


                // // Ajaxリクエストが成功した時発動
                // .done( (data) => {
                //     $('.result').html(data);
                //    console.log(data);
                // })
                // // Ajaxリクエストが失敗した時発動
                // .fail( (data) => {
                //     $('.result').html(data);
                //    console.log(data);
                // })
                // // Ajaxリクエストが成功・失敗どちらでも発動
                // .always( (data) => {

                // }
                // );
        }

         // console.log($($(".position_in_charge_"+$(this).attr("id"))).val())
         // console.log($($(".work_status_"+$(this).attr("id"))).val())


             // // Ajaxリクエストが成功した時発動
             // .done( (data) => {
             //     $('.result').html(data);
             //    console.log(data);
             // })
             // // Ajaxリクエストが失敗した時発動
             // .fail( (data) => {
             //     $('.result').html(data);
             //    console.log(data);
             // })
             // // Ajaxリクエストが成功・失敗どちらでも発動
             // .always( (data) => {

             // }
             // );
     });
 </script>
