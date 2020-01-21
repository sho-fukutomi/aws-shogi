<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<html>
<?php echo $this->element('menu_backlog'); ?>

    <?php //debug($team_list);?>
    <?php //debug($desiger_task);?>

<div class="wrapper">
    <div class="column cat1">
        <div class="upside">



        <?php  foreach ($desiger_task as $user_name => $tickets_by_user): ?>
            <h2 class="staff_list"  ><?php echo $user_name ?></h2>
            <table>
                <tr>
                    <th>Team</th>
                    <th>Priority</th>
                    <th>ticket No.</th>
                    <th>ticket Name</th>
                    <th>Progress</th>

                    <th>dev start</th>
                    <th>dev done</th>
                    <th>GGPE check done</th>
                    <th>release</th>
                    <th>Be</th>
                    <th>GGPE</th>
                </tr>

            <?php foreach ($tickets_by_user as $team_id => $tickets): ?>
                <?php $name_flg = true?>
                <?php foreach ($tickets as $order => $ticket): ?>
                    <tr>
                        <?php if ($name_flg): ?>
                            <td rowspan=<?php echo count($tickets)?> class="team_<?php echo $team_id?>">
                                <?php echo $team_list[$ticket['fdc_ticket_masters']['fdc_team']]['fdc_team']['name']  ?>
                            </td>
                            <?php $name_flg = false?>
                        <?php endif; ?>
                        <td><?php echo $order ?></td>
                        <td><?php echo $ticket['fdc_ticket_masters']['key'] ?></td>
                        <td><?php echo $ticket['fdc_backlog_webhooks'][0]['summary'] ?></td>
                        <td class="table_milestone milestone_<?php echo $ticket['fdc_backlog_webhooks'][0]['milestone_id'] ?>"><?php echo $ticket['fdc_backlog_webhooks'][0]['milestone_name'] ?></td>
                        <td>
                            <div class="plan"> <?php echo !empty($ticket['fdc_ticket_masters']['dev_start_plan'])?$ticket['fdc_ticket_masters']['dev_start_plan']:"" ?> </div>
                            <div class="result"> <?php echo !empty($ticket['fdc_ticket_masters']['dev_start_result'])?$ticket['fdc_ticket_masters']['dev_start_result']:"" ?> </div>
                        </td>
                        <td>
                            <div class="plan"> <?php echo !empty($ticket['fdc_ticket_masters']['dev_done_plan'])?$ticket['fdc_ticket_masters']['dev_done_plan']:"" ?> </div>
                            <div class="result"> <?php echo !empty($ticket['fdc_ticket_masters']['dev_done_result'])?$ticket['fdc_ticket_masters']['dev_done_result']:"" ?> </div>
                        </td>
                        <td>
                            <div class="plan"> <?php echo !empty($ticket['fdc_ticket_masters']['ggpe_check_done_plan'])?$ticket['fdc_ticket_masters']['ggpe_check_done_plan']:"" ?> </div>
                            <div class="result"> <?php echo !empty($ticket['fdc_ticket_masters']['ggpe_check_done_result'])?$ticket['fdc_ticket_masters']['ggpe_check_done_result']:"" ?> </div>
                        </td>
                        <td>
                            <div class="plan"> <?php echo !empty($ticket['fdc_ticket_masters']['release_plan'])?$ticket['fdc_ticket_masters']['release_plan']:"" ?> </div>
                            <div class="result"> <?php echo !empty($ticket['fdc_ticket_masters']['release_result'])?$ticket['fdc_ticket_masters']['release_result']:"" ?> </div>
                        </td>
                        <td> <?php echo !empty($ticket['fdc_ticket_masters']['be']) ? $members[$ticket['fdc_ticket_masters']['be']] : "" ?> </td>
                        <td> <?php echo !empty($ticket['fdc_ticket_masters']['ggpe']) ? $members[$ticket['fdc_ticket_masters']['ggpe']] : "" ?> </td>
                    </tr>



                <?php endforeach; ?>
            <?php endforeach; ?>


            </table>
        <?php endforeach; ?>



        </div>
    </div>
</div>

</html>
