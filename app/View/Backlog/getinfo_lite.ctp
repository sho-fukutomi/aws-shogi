<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<?php echo $this->element('menu_backlog'); ?>

<?php // debug($team_list)?>

    <?php foreach($ticketList as $milestone => $tickets): ?>
        <h2 class='milestone_name'><?php echo $milestone ?></h2>
        <table>
            <?php foreach ($tickets as $key => $value): ?>
                <tr>
                    <td class="type_<?php echo !empty($value['fdc_backlog_webhooks']) ?  $value['fdc_backlog_webhooks'][0]['issueType_id'] : "9999" ?>"><?php echo !empty($value['fdc_backlog_webhooks']) ? $value['fdc_backlog_webhooks'][0]['issueType_name'] :"" ?></td>
                    <td class=ticket_no > <a href="ticketinfo/<?php echo $value['fdc_ticket_masters']['key'] ?>" target="_blank"><?php echo $value['fdc_ticket_masters']['key'] ?></a></td>
                    <td class="table_summary"  ><?php echo !empty($value['fdc_backlog_webhooks']) ? $value['fdc_backlog_webhooks'][0]['summary'] : ''  ?>  </td>
                    <td class="team_<?php echo $value['fdc_ticket_masters']['fdc_team']?>"><?php echo  !empty($value['fdc_ticket_masters']['fdc_team']) ? $team_list[$value['fdc_ticket_masters']['fdc_team']]['fdc_team']['name'] : ''  ?></td>
                    <td class="table_milestone milestone_<?php echo !empty($value['fdc_backlog_webhooks'][0]['milestone_id']) ? $value['fdc_backlog_webhooks'][0]['milestone_id']:'' ?>"  ><?php echo !empty($value['fdc_backlog_webhooks']) ? $value['fdc_backlog_webhooks'][0]['milestone_name'] : ''  ?> </td>
                    <td class="table_staff" >
                        <div class="cp_ipselect">
                        <select class="cp_sl06 be_id_<?php echo $value['fdc_ticket_masters']['key'] ?> " required>
                        <option value="" hidden disabled selected></option>
                        <?php foreach($be_list as $be_id => $be_name): ?>
                            <option value="<?php echo $be_id ?>" <?php echo $value['fdc_ticket_masters']['be'] == $be_id ? 'selected' : ''  ?>> <?php echo $be_name ?> </option>
                        <?php endforeach; ?>
                        </select>
                        <span class="cp_sl06_highlight"></span>
                        <span class="cp_sl06_selectbar"></span>
                        </div>
                    </td>
                    <td class="table_staff" >
                        <div class="cp_ipselect">
                        <select class="cp_sl06 ggpe_id_<?php echo $value['fdc_ticket_masters']['key'] ?> " required>
                        <option value="" hidden disabled selected></option>
                        <?php foreach($ggpe_list as $ggpe_id => $ggpe_name): ?>
                            <<?php //debug($member) ?>
                            <option value="<?php echo $ggpe_id ?>" <?php echo $value['fdc_ticket_masters']['ggpe'] == $ggpe_id ? 'selected' : ''  ?>> <?php echo $ggpe_name ?> </option>
                        <?php endforeach; ?>
                        </select>
                        <span class="cp_sl06_highlight"></span>
                        <span class="cp_sl06_selectbar"></span>
                        </div>
                    </td>
                    <td class="table_staff" >
                        <div class="cp_ipselect">
                        <select class="cp_sl06 design_id_<?php echo $value['fdc_ticket_masters']['key'] ?> " required>
                        <option value="" hidden disabled selected></option>
                        <?php foreach($design_list as $design_id => $design_name): ?>
                            <<?php //debug($member) ?>
                            <option value="<?php echo $design_id ?>" <?php echo $value['fdc_ticket_masters']['design'] == $design_id ? 'selected' : ''  ?>> <?php echo $design_name ?> </option>
                        <?php endforeach; ?>
                        </select>
                        <span class="cp_sl06_highlight"></span>
                        <span class="cp_sl06_selectbar"></span>
                        </div>
                    </td>
                    <td>
                        <button id="edit_ticket_master_<?php echo $value['fdc_ticket_masters']['key']  ?>" class="editbutton" value="<?php echo $value['fdc_ticket_masters']['key'] ?>" >add</button>
                    </td>

                </tr>
                <?php //break;?>
            <?php endforeach; ?>

        </table>


    <?php endforeach; ?>


<style type="text/css">

    .fdc_task {
         color: #e4e4e4;
        /* text-shadow:
            0 0 10px,
            0 0 13px,
            0 0 15px; */
    }
    .other_task {
        color: #222;
    }
    .milestone_name{
        color: #eee;
    }

    .table_key{
        width: 5%;
    }
    .table_summary{
        width: 40%;
    }
    .table_milestone{
        width: 15%;
    }
    .table_staff{
        width: 10%;
    }








</style>

<script>
$(".editbutton").on('click',function(){

    post_flg = 1;
    target_ticket_id = $(this).val();
    console.log(target_ticket_id);

   if(target_ticket_id) {
        be_id = $(".be_id_" + target_ticket_id).val();
        ggpe_id = $(".ggpe_id_" + target_ticket_id).val();
        design_id = $(".design_id_" + target_ticket_id).val();

        console.log(be_id);
        console.log(ggpe_id);
        console.log(design_id);

       if(be_id == null && ggpe_id == null && design_id && null){
           post_flg = 0;
       }else{
           post_data = {
               "target_ticket_id" : target_ticket_id,
               "be_id" : be_id,
               "ggpe_id" : ggpe_id,
               "design_id" : design_id
           }
       }

   }else{
       post_flg = 0;

   }

   console.log('post_flg=' + post_flg );
   if(post_flg == 1){
       console.log(post_data)
       $.ajax({
               url:'./updatepersonincharge',
               type:'POST',
               data:post_data,
               success: function(j_data){
 
                     // 処理を記述
                   console.log(j_data);
               }
           }


           );
   }

});
</script>
