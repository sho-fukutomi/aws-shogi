<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<html>
<?php echo $this->element('menu_backlog'); ?>


            <?php //debug($tsuchie_tasks)?>
<h1 class="glaystring center_h1">
    <a href="/shogi/backlog/calendar?date=<?php echo $lastmonth?>"><</a><span class="brank"></span>
        <?php echo $eng_month?><span class="brank"></span>
    <a href="/shogi/backlog/calendar?date=<?php echo $nextmonth?>">></a>

</h1>
<div class="wrapper center_h1">

<table class="calendar">
    <tr>
        <th>Sun</th>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
    </tr>


<?php $k = 0 - $adjustment_days ?>
    <?php for ($i=1 ; $i <= $tr_count ; $i++): ?>
        <tr>
        <?php for ($j=0 ; $j <= 6 ; $j++): ?>
            <?php $k++ ?>
            <?php
                $week_class = "";
                if($j == 0){
                    $week_class = 'sunday';
                }elseif ($j == 6) {
                    $week_class = 'saturday';
                }
            ?>

            <td class="center_calendar <?php echo $week_class ?>">
                <?php if ($k >0 && $k <= $final_date ): ?>
                    <div class="date_calendar"><?php echo $k ?></div>
                    <?php if(!empty($result[$k])): ?>
                        <?php foreach ($datelist as $key => $value): ?>
                            <?php if (!empty($result[$k][$value])): ?>
                                <?php foreach ($result[$k][$value] as $key => $value): ?>
                                    <div class="table_milestone milestone_<?php echo $value['milestone_id'] ?>" >
                                        <?php echo $value['milestone_name']?>
                                    </div>
                                    <div>
                                        <?php echo $value['key'].":".$value['text'] ?>
                                    </div>
                                    <div>
                                        <?php echo $value['summary'] ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif;?>
                <?php endif; ?>
            </td>

        <?php endfor; ?>
        </tr>
    <?php endfor; ?>



</table>



</div>

</html>
