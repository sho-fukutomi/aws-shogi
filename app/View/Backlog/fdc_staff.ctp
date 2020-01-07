<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<html>
<?php echo $this->element('menu_backlog'); ?>


<div class="wrapper">
    <div class="column cat1">
        <div class="upside">
            <?php //debug($issue_list['dev'])?>
            <table>
                <?php $name_flg = true ?>
                <?php foreach ($issue_list['dev'] as $key => $member_and_issue): ?>
                    <?php foreach ($member_and_issue as $key => $value): ?>
                        <tr>
                            <?php if ($name_flg): ?>
                                <td class="roletext" style="background:#a4c2f4" rowspan="<?php echo count($member_and_issue)?>" ><?php echo $value['member_name'] ?> </td>
                                <?php $name_flg = false ?>
                            <?php endif; ?>
                            <td class=team_<?php echo $value['fdc_team'] ?>><?php echo $value['order'] ?> </td>
                            <td><?php echo $value['key'] ?> </td>
                            <td><?php echo $value['summary'] ?> </td>
                            <td class=team_<?php echo $value['fdc_team'] ?>><?php echo $teamname[$value['fdc_team']] ?> </td>
                            <td class="milestone_<?php echo $value['milestone_id'] ?> table_milestone" ><?php echo $value['milestone_name'] ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php $name_flg = true ?>
                <?php endforeach; ?>
            </table>

        </div>
    </div>

    <div class="column cat2">
        <div class="upside">

            <table>
                <?php $name_flg = true ?>
                <?php foreach ($issue_list['tester'] as $key => $member_and_issue): ?>
                    <?php foreach ($member_and_issue as $key => $value): ?>
                        <tr>
                            <?php if ($name_flg): ?>
                                <td class="roletext" style="background:#ff7fad" rowspan="<?php echo count($member_and_issue)?>" ><?php echo $value['member_name'] ?> </td>
                                <?php $name_flg = false ?>
                            <?php endif; ?>
                            <td class=team_<?php echo $value['fdc_team'] ?>><?php echo $value['order'] ?> </td>
                            <td><?php echo $value['key'] ?> </td>
                            <td><?php echo $value['summary'] ?> </td>
                            <td class=team_<?php echo $value['fdc_team'] ?>><?php echo $teamname[$value['fdc_team']] ?> </td>
                            <td class="milestone_<?php echo $value['milestone_id'] ?> table_milestone" ><?php echo $value['milestone_name'] ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php $name_flg = true ?>
                <?php endforeach; ?>
            </table>

        </div>
    </div>
</div>
