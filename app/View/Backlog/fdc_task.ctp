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
            <?php foreach ($be_task as $be_id => $task_by_be) :?>
                <div class="separate_team">
                <h3><?php echo $be_list[$be_id] ?></h3>
                <table>
                    <?php //debug($task_by_be)?>
                    <?php foreach ($task_by_be as $team_id => $team_task): ?>
                        <?php foreach ($team_task as $order => $ticket_value): ?>
                            <?php
                                $summary_class = '';
                                if(
                                    $ticket_value['fdc_backlog_webhooks'][0]['milestone_id']==252579 || // 期限日設定中
                                    $ticket_value['fdc_backlog_webhooks'][0]['milestone_id']==252575 || // 仕様作成中
                                    $ticket_value['fdc_backlog_webhooks'][0]['milestone_id']==252591 || // 本番確認中
                                    $ticket_value['fdc_backlog_webhooks'][0]['milestone_id']==252698 || // ハンコ待ち
                                    $ticket_value['fdc_backlog_webhooks'][0]['milestone_id']==252698 || // FB
                                    $ticket_value['fdc_backlog_webhooks'][0]['milestone_id']==252586 || // 期限日再設定中
                                    $ticket_value['fdc_backlog_webhooks'][0]['milestone_id']==252583 // FB使用作成中
                                ){
                                    $summary_class = 'be_currenttask';
                                } ?>
                            <tr>
                                <td class="type_<?php echo $ticket_value['fdc_backlog_webhooks'][0]['issueType_id']?> "><?php echo $ticket_value['fdc_backlog_webhooks'][0]['issueType_name'] ?></td>
                                <td class="team_<?php echo $team_id ?>"><?php echo !empty($team_list[$team_id]['fdc_team']['name'])? $team_list[$team_id]['fdc_team']['name'] : '' ?></td>
                                <td><?php echo $order ?></td>
                                <td class="<?php echo $summary_class?>">
                                    <a href="ticketinfo/<?php echo $ticket_value['fdc_backlog_webhooks'][0]['backlog_id'] ?>" target="_blank"><?php echo $ticket_value['fdc_backlog_webhooks'][0]['backlog_id']?> </a>
                                </td>
                                <td class="<?php echo $summary_class?>"><?php echo $ticket_value['fdc_backlog_webhooks'][0]['summary'] ?></td>
                                <td class="table_milestone milestone_<?php echo $ticket_value['fdc_backlog_webhooks'][0]['milestone_id'] ?>" ><?php echo $ticket_value['fdc_backlog_webhooks'][0]['milestone_name'] ?></td>

                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </table>
                </div>
            <?php endforeach;?>

        </div>

        <div class="upside">


        </div>
    </div>

    <div class="column cat2">
        <div class="upside">
            <h3>Sir Tsuchie</h3>


            <?php foreach ($tsuchie_tasks as $team_id => $team_task): ?>

                <h3> <?php echo !empty($team_list[$team_id]['fdc_team']['name'])? $team_list[$team_id]['fdc_team']['name'] : '' ?></h3>
                <table>
                <?php foreach ($team_task as $order => $ticket_value): ?>
                    <?php
                        $summary_class = '';
                        if(
                            $ticket_value['fdc_backlog_webhooks'][0]['milestone_id']==252698  // ハンコ待ち
                        ){
                            $summary_class = 'be_currenttask';
                        } ?>
                    <tr>

                        <td class="type_<?php echo $ticket_value['fdc_backlog_webhooks'][0]['issueType_id']?> "><?php echo $ticket_value['fdc_backlog_webhooks'][0]['issueType_name'] ?></td>
                        <td class="team_<?php echo $team_id ?>"><?php echo !empty($team_list[$team_id]['fdc_team']['name'])? $team_list[$team_id]['fdc_team']['name'] : '' ?></td>
                        <td><?php echo $order ?></td>
                        <td class="<?php echo $summary_class?>">
                            <a href="ticketinfo/<?php echo $ticket_value['fdc_backlog_webhooks'][0]['backlog_id'] ?>" target="_blank"><?php echo $ticket_value['fdc_backlog_webhooks'][0]['backlog_id']?> </a>
                        </td>
                        <td class="<?php echo $summary_class?>"><?php echo $ticket_value['fdc_backlog_webhooks'][0]['summary'] ?></td>
                        <td class="table_milestone milestone_<?php echo $ticket_value['fdc_backlog_webhooks'][0]['milestone_id'] ?>" ><?php echo $ticket_value['fdc_backlog_webhooks'][0]['milestone_name'] ?></td>

                        <td>

                        </td>
                    </tr>

                <?php endforeach; ?>
                </table>
            <?php endforeach; ?>



        </div>
    </div>
</div>






</html>
