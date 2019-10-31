<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/fdcsys.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<body>

    <?php echo $this->element('menu'); ?>
    <h2><?php echo $cardName?></h2>
    <table>
        <tr>
            <th> date </th>
            <!-- <th> before </th> -->
            <th> after </th>
            <th> 対応者 </th>
            <th> DIFF </th>
            <th> DATE DIFF </th>
        </tr>

        <?php foreach ($cardHistory as $key => $history): ?>
            <?php //debug($history); ?>
            <tr>
                <th> <?php echo $history['date'] ?>  </th>
                <!-- <th> <?php echo $history['listBefore'] ?>  </th> -->
                <th class="<?php echo $history['listAfter']?>"> <?php echo $history['listAfter'] ?>  </th>
                <th> <?php echo $cardHistory[$key - 1]['memberid'] ?>  </th>
                <th class="<?php echo $history['listAfter']?> diff"> <?php echo $history['timediff'] ?>  </th>                
                <th class="<?php echo $history['listAfter']?> datediff"> <?php echo $history['datediff'] ?>  </th>                
            </tr>

        <?php endforeach; ?>
    </table>

</body>
<style>
.FEEDBACK-FIX,.DEV-ONGOING,.RELEASE-WAITING{
    background: #6fa8ff;
    color: black;
}
.TESTCACE-IN-PROGRESS,.TEST-ONGOING,.STG-TESTING{
    background: #ff748c;
    color: black;
}
.FINAL-TEST{
    background: #674ea7;
    color: black;
}
.GGPE-TEST{
    background: #ffff00;
    color: black;
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