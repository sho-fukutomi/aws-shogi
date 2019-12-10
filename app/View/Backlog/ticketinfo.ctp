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
            <h1 class="glaystring"><?php echo !empty($webhook) ? $webhook[0]['fdc_backlog_webhook']['backlog_id'].' - '.$webhook[0]['fdc_backlog_webhook']['summary'] : 'no data ...' ?></h1>
            <h2 class="glaystring">Link :<a href="https://love.backlog.jp/view/<?php echo $ticket_num ?>" target="_blank"> <?php echo $ticket_num ?> </a>  </h2>
            <div class="staff_list"><span> BE: </span> <a href="../userinfo/<?php echo $be_id?>"><?php echo $be ?></a></div>
            <div class="staff_list"><span> GGPE: </span> <a href="../userinfo/<?php echo $ggpe_id?>"><?php echo $ggpe ?></a></div>
            <div class="staff_list"><span> Design: </span> <a href="../userinfo/<?php echo $design_id?>"><?php echo $design ?></a></div>
            <table>
                <?php if (!empty($webhook)): ?>
                    <tr>
                        <th>date</th>
                        <th>elapsed time</th>
                        <th>milestone</th>


                    </tr>
                    <?php foreach ($webhook as $key => $value): ?>
                        <tr>
                            <td><?php echo $value['fdc_backlog_webhook']['time'] ?></td>
                            <td><?php echo $value['fdc_backlog_webhook']['time_diff'] ?></td>
                            <td class="table_milestone milestone_<?php echo $value['fdc_backlog_webhook']['milestone_id'] ?>"><?php echo $value['fdc_backlog_webhook']['milestone_name'] ?></td>
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
