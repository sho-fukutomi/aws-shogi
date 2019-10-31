<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/fdcsys.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<body>

    <?php echo $this->element('menu'); ?>
    <h2><?php echo $cardName?></h2>
    <div class="wrapper">
        <div class="column cat1">
            <table>
                <tr>
                    <th> date </th>
                    <!-- <th> before </th> -->
                    <th> after </th>
                    <th> 対応者 </th>
                    <th> DIFF </th>
                    <th> DATE DIFF </th>
                    <th> act DIFF </th>
                </tr>
                <?php foreach ($cardHistory as $key => $history): ?>
                    <?php //debug($history); ?>
                    <tr>
                        <th> <?php echo $history['date'] ?>  </th>
                        <!-- <th> <?php echo $history['listBefore'] ?>  </th> -->
                        <th class="<?php echo $history['class']?>"> <?php echo $history['listAfter'] ?>  </th>
                        <th> <?php echo $cardHistory[$key - 1]['memberid'] ?>  </th>
                        <th class="<?php echo $history['class']?> diff"> <?php echo $history['timediff'] ?>  </th>                
                        <th class="<?php echo $history['class']?> datediff"> <?php echo $history['datediff'] ?> 
                        <th class="<?php echo $history['class']?> actual time diff"> <?php echo $history['actualTimediff'] ?> 
                        </th>                
                    </tr>

                <?php endforeach; ?>
            </table>
        </div>
        <div class="column cat2">
            <div class="upside">
                <table>
                    <th>reason</th>
                    <th>time</th>
    <?php //debug($sumOfList) ?>
                    <?php foreach ($result_sum as $key => $value): ?> 
                        <tr>
                            <th class="<?php echo $key ?>"><?php echo $key ?></th>
                            <th class="<?php echo $key ?>"><?php echo $value['time'] ?></th>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="space"> </div>
            <div class="downside">
                <table>
                    <th>status</th>
                    <th>time</th>
                    <?php foreach ($sumOfList as $key => $value): ?> 
                        <tr>
                            <th class="<?php echo $value['classname'] ?>"><?php echo $key ?></th>
                            <th class="<?php echo $value['classname'] ?>"><?php echo $value['time'] ?></th>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>
    </div>
</body>
<style>
.FEEDBACK-FIX,.DEV-ONGOING,.RELEASE-WAITING,.dev-time,.C-5b4d4cae168a92088b4817b9{
    background: #6fa8ff;
    color: black;
}
.C-5b4d4d5d61a48f0891d5ebe9{
    background: #ff748c;
    color: black;
}
.FINAL-TEST{
    background: #674ea7;
    color: black;
}
.GGPE-TEST,.GGPE-time{
    background: #ffff00;
    color: black;
}
.TESTCACE-WAITING,.TEST-WAITING,.STG-RELEASED,.tester-waiting-time{
    background: #251a1c;
    color: #c58c8c;
}
.TASK,.STG-WAITING,.dev-waiting-time{
    background: #273b5a;
    color: #91b9d8;
}
.space{
    padding: 50px;
}


</style>
<script>
    console.log($(".FEEDBACK-FIX.diff").text());
    console.log($(".ONGOING.diff").text());
    console.log($(".RELEASE-WAITING.diff").text());

    sum =
    $(".FEEDBACK-FIX.diff").text() +
    $(".ONGOING.diff").text(); +
    $(".RELEASE-WAITING.diff").text();

    console.log(sum);
    // reduce((a,x) => a+=x,0)



</script>