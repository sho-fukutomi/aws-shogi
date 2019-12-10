<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

</head>

<?php echo $this->element('menu_backlog'); ?>
<div class="wrapper">
    <div class="column cat1">
        <div class="upside">
            <h1 class="glaystring"><?php echo !empty($name) ? $name : 'no data ...' ?></h1>
            <h2 class="glaystring">担当チケット数 : <?php echo !empty($issueCount) ? $issueCount : 'no data ...' ?></h2>
            <table>
                <th>Order</th>
                <th>Type</th>
                <th>ticketID</th>
                <th>summary</th>
                <th>milestone</th>
                <th>team</th>
                <th>dev start</th>
                <th>dev done</th>
                <th>GGPE check done	</th>
                <th>release</th>
                <th>be</th>
                <th>ggpe</th>
                <th>design</th>
                <?php if (!empty($ticketInfo)): ?>
                    <?php foreach ($ticketInfo as $key => $value): ?>
                        <tr>
                            <th><?php echo !empty($value['fdc_ticket_masters']['order']) ? $value['fdc_ticket_masters']['order'] : 'not yet'?> </th>
                            <td class="type_<?php echo !empty($value['fdc_backlog_webhooks']) ?  $value['fdc_backlog_webhooks'][0]['issueType_id'] : "9999" ?>"><?php echo !empty($value['fdc_backlog_webhooks']) ? $value['fdc_backlog_webhooks'][0]['issueType_name'] :"" ?></td>
                            <td class=ticket_no > <a href="../ticketinfo/<?php echo $value['fdc_ticket_masters']['key'] ?>" target="_blank"><?php echo $value['fdc_ticket_masters']['key'] ?></a></td>
                            <td><?php echo $value['fdc_backlog_webhooks'][0]['summary'] ?></td>
                            <td class="table_milestone milestone_<?php echo $value['fdc_backlog_webhooks'][0]['milestone_id'] ?>"><?php echo $value['fdc_backlog_webhooks'][0]['milestone_name'] ?></td>
                            <td>
                                <?php echo !empty($value['fdc_ticket_masters']['fdc_team']) ? $teams[$value['fdc_ticket_masters']['fdc_team']]  : 'not yet'?>
                            </td>
                            <td>
                                <div><?php echo !empty($value['fdc_ticket_masters']['dev_start_plan'])   ? $value['fdc_ticket_masters']['dev_start_plan']   : '' ?></div>
                                <div><?php echo !empty($value['fdc_ticket_masters']['dev_start_result']) ? $value['fdc_ticket_masters']['dev_start_result'] : '' ?></div>
                            </td>
                            <td>
                                <div><?php echo !empty($value['fdc_ticket_masters']['dev_done_plan'])   ? $value['fdc_ticket_masters']['dev_done_plan']   : '' ?></div>
                                <div><?php echo !empty($value['fdc_ticket_masters']['dev_done_result']) ? $value['fdc_ticket_masters']['dev_done_result'] : '' ?></div>
                            </td>
                            <td>
                                <div><?php echo !empty($value['fdc_ticket_masters']['ggpe_check_done_plan'])   ? $value['fdc_ticket_masters']['ggpe_check_done_plan']   : '' ?></div>
                                <div><?php echo !empty($value['fdc_ticket_masters']['ggpe_check_done_result']) ? $value['fdc_ticket_masters']['ggpe_check_done_result'] : '' ?></div>
                            </td>
                            <td>
                                <div><?php echo !empty($value['fdc_ticket_masters']['release_plan'])   ? $value['fdc_ticket_masters']['release_plan']   : '' ?></div>
                                <div><?php echo !empty($value['fdc_ticket_masters']['release_result']) ? $value['fdc_ticket_masters']['release_result'] : '' ?></div>
                            </td>
                            <td><?php echo !empty($value['fdc_ticket_masters']['be'])     ? $members[$value['fdc_ticket_masters']['be']]     : '' ?></td>
                            <td><?php echo !empty($value['fdc_ticket_masters']['ggpe'])   ? $members[$value['fdc_ticket_masters']['ggpe']]   : '' ?></td>
                            <td><?php echo !empty($value['fdc_ticket_masters']['design']) ? $members[$value['fdc_ticket_masters']['design']] : '' ?></td>



                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>

        <div class="upside">

        </div>
    </div>

    <div class="column cat2">
        <div class="upside">
            <table>




            </table>


        </div>
    </div>
</div>
