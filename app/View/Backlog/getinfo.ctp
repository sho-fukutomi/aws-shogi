<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<?php echo $this->element('menu_backlog'); ?>


<div class="wrapper">
    <div class="column cat1">
        <div class="upside">
            <?php //debug($milestones)?>

            <table>
                <tr>
                    <th>type</th>
                    <th>milestone</th>
                    <th>Key</th>
                    <th>Summary</th>
                    <th>Category</th>
                    <th>BE</th>
                    <th>GGPE</th>
                    <th>Design</th>

                </tr>
                <?php $fdc_task = array(); ?>
                <?php foreach ($result_tickets as $milestoneOrder => $ticketByMilestone): ?>
                    <?php foreach ($ticketByMilestone as $key => $value):?>
                    <?php
                            $categoryList = '';
                            $fdc_flg = 0;
                            foreach ($value['category'] as $key => $category) {
                                $categoryList = $categoryList.$category['name']."<br>";
                                if($category['id'] == 50751    //FDC
                                || $category['id'] == 124975   //iOS
                                || $category['id'] == 220480   //API
                                || $category['id'] == 204445){ //Android
                                    $fdc_flg = 1;
                                    // $fdc_task[] = $value['issueKey'];
                                }
                            }
                    ?>
<?php //debug($value)?>
                    <tr class="<?php echo  $fdc_flg ? 'fdc_task' : 'other_task' ?> ">
                        <td><?php echo $value['issueType']['name'] ?></td>
                        <td class="table_milestone milestone_<?php echo !empty($value['milestone'][0]['id']) ? $value['milestone'][0]['id'] : '9999'  ?>" ><?php echo $milestones[$milestoneOrder]?></td>
                        <td><?php echo $value['issueKey'] ?></td>
                        <td><?php echo $value['summary'] ?></td>

                        <td>
                            <?php echo $categoryList ?>

                        </td>
                        <td>
                            <div class="cp_ipselect">
                            <select class="cp_sl06 be_id_<?php echo $value['issueKey'] ?> " required>
                            <option value="" hidden disabled selected></option>
                            <?php foreach($be_list as $be_id => $be_name): ?>
                                <option value="<?php echo $be_id ?>" <?php echo $finalResult[$value['issueKey']]['be'] == $be_id ? 'selected' : ''  ?>> <?php echo $be_name ?> </option>
                            <?php endforeach; ?>
                            </select>
                            <span class="cp_sl06_highlight"></span>
                            <span class="cp_sl06_selectbar"></span>
                            </div>
                        </td>

                        <td>
                            <div class="cp_ipselect">
                            <select class="cp_sl06 ggpe_id_<?php echo $value['issueKey'] ?> " required>
                            <option value="" hidden disabled selected></option>
                            <?php foreach($ggpe_list as $ggpe_id => $ggpe_name): ?>
                                <<?php //debug($member) ?>
                                <option value="<?php echo $ggpe_id ?>" <?php echo $finalResult[$value['issueKey']]['ggpe'] == $ggpe_id ? 'selected' : ''  ?>> <?php echo $ggpe_name ?> </option>
                            <?php endforeach; ?>
                            </select>
                            <span class="cp_sl06_highlight"></span>
                            <span class="cp_sl06_selectbar"></span>
                            </div>
                        </td>
                        <td>
                            <div class="cp_ipselect">
                            <select class="cp_sl06 design_id_<?php echo $value['issueKey'] ?> " required>
                            <option value="" hidden disabled selected></option>
                            <?php foreach($design_list as $design_id => $design_name): ?>
                                <<?php //debug($member) ?>
                                <option value="<?php echo $design_id ?>" <?php echo $finalResult[$value['issueKey']]['design'] == $design_id ? 'selected' : ''  ?>> <?php echo $design_name ?> </option>
                            <?php endforeach; ?>
                            </select>
                            <span class="cp_sl06_highlight"></span>
                            <span class="cp_sl06_selectbar"></span>
                            </div>
                        </td>
                        <td>
                            <button id="edit_ticket_master_<?php echo $value['issueKey'] ?>" class="editbutton" value="<?php echo $value['issueKey']?>" >add</button>
                        </td>


                    <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                <?php // debug($fdc_task);?>
            </table>


        </div>
    </div>
</div>

<style type="text/css">

    .fdc_task {
         color: #000;
        /* text-shadow:
            0 0 10px,
            0 0 13px,
            0 0 15px; */
    }
    .other_task {
        color: #716f6f;

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
