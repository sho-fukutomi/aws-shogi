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
                <tr>
                    <th>Member</th>
                    <th>order</th>
                    <th>key</th>
                    <th>title</th>
                    <th>team</th>
                    <th>milestone</th>
                </tr>

                <?php foreach ($issue_list['dev'] as $memberID => $member_and_issue): ?>
                    <?php if (empty($member_and_issue)): ?>
                        <tr style="background:#760000">
                            <td>
                                <a href="/shogi/backlog/userinfo/<?php echo $memberID ?>" target="_blank"><?php echo $memberByid[$memberID]['name']?></a>
                            </td>
                            <td colspan="5"> No have issue! </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($member_and_issue as $key => $value): ?>
                        <?php //debug($memberID)?>
                        <tr>
                            <?php if ($name_flg): ?>
                                <td class="roletext"  rowspan="<?php echo count($member_and_issue)?>" >
                                    <a href="/shogi/backlog/userinfo/<?php echo $memberID ?>" target="_blank"><?php echo $memberByid[$memberID]['name'] ?></a>
                                </td>
                                <?php $name_flg = false ?>
                            <?php endif; ?>
                            <td class="team_<?php echo $value['fdc_team'] ?>"><?php echo $value['order'] ?> </td>
                            <td><?php echo $value['key'] ?> </td>
                            <td><?php echo $value['summary'] ?> </td>
                            <td class="team_<?php echo $value['fdc_team'] ?>"><?php echo $teamname[$value['fdc_team']] ?> </td>
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
                <tr>
                    <th>Member</th>
                    <th>order</th>
                    <th>key</th>
                    <th>title</th>
                    <th>team</th>
                    <th>milestone</th>
                </tr>
                <?php foreach ($issue_list['tester'] as $memberID => $member_and_issue): ?>
                    <?php if (empty($member_and_issue)): ?>
                        <tr style="background:#760000">
                            <td>
                                <a href="/shogi/backlog/userinfo/<?php echo $memberID ?>" target="_blank"><?php echo $memberByid[$memberID]['name']?></a>
                            </td>
                            <td colspan="5"> No have issue! </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($member_and_issue as $key => $value): ?>
                        <tr>
                            <?php if ($name_flg): ?>
                                <td class="roletext"  rowspan="<?php echo count($member_and_issue)?>" >
                                    <a href="/shogi/backlog/userinfo/<?php echo $memberID ?>" target="_blank"><?php echo $memberByid[$memberID]['name'] ?></a>
                                </td>
                                <?php $name_flg = false ?>
                            <?php endif; ?>
                            <td class="team_<?php echo $value['fdc_team'] ?>"><?php echo $value['order'] ?> </td>
                            <td><?php echo $value['key'] ?> </td>
                            <td><?php echo $value['summary'] ?> </td>
                            <td class="team_<?php echo $value['fdc_team'] ?>"><?php echo $teamname[$value['fdc_team']] ?> </td>
                            <td class="milestone_<?php echo $value['milestone_id'] ?> table_milestone" ><?php echo $value['milestone_name'] ?> </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php $name_flg = true ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<?php //debug($confirmation_required_list)?>
<table>
    <?php foreach ($confirmation_required_list as $key => $value): ?>
        <tr>
            <td><?php echo $value['order'] ?></td>
            <td><?php echo $value['key'] ?></td>
            <td><?php echo $value['summary'] ?></td>
            <td class="milestone_<?php echo $value['milestone_id'] ?> table_milestone" ><?php echo $value['milestone_name'] ?></td>
            <?php if ($value['fdc_team']): ?>
                <td class="team_<?php echo $value['fdc_team'] ?>"><?php echo  $teamname[$value['fdc_team']]?></td>
            <?php else: ?>
                <td style="background:#760000" > put team!! </td>
            <?php endif; ?>
            <?php if ($value['be']): ?>
                <td><?php echo $value['be'] ?></td>
            <?php else: ?>
                <td style="background:#760000" > put be!! </td>
            <?php endif; ?>
            <?php if ($value['dev']): ?>
                <td><?php echo $value['dev'] ?></td>
            <?php else: ?>
                <td style="background:#760000" > put dev!! </td>
            <?php endif; ?>
            <?php if ($value['tester']): ?>
                <td><?php echo $value['tester'] ?></td>
            <?php else: ?>
                <td style="background:#760000" > put tester!! </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
