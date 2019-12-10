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
                <tr>
                    <?php //debug($value)?>
                    <td><?php echo $value['fdc_ticket_masters']['order'] ?></td>
                    <td><?php echo $value['fdc_ticket_masters']['key'] ?></td>
                    <td><?php echo !empty($value['fdc_backlog_webhooks'][0]['summary'])? $value['fdc_backlog_webhooks'][0]['summary'] : ""   ?></td>
                    <td class="table_milestone milestone_<?php echo !empty($value['fdc_backlog_webhooks'][0]['milestone_id']) ? $value['fdc_backlog_webhooks'][0]['milestone_id']  :""  ?>">
                        <?php echo !empty($value['fdc_backlog_webhooks'][0]['milestone_name']) ? $value['fdc_backlog_webhooks'][0]['milestone_name'] : "" ?>
                    </td>

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






</html>
