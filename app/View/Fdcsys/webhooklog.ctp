<html>
    <head>
        <title>ぽぽぽ</title>
        <link rel="stylesheet" type="text/css" href="/shogi/css/fdcsys.css">

     
    </head>
    <body>
    <?php echo $this->element('menu'); ?>

        <div class="wrapper">
            <div class="column cat1">
                <table border="1" style="width: 100%;">
                    <tr>
                        <th>日時</th>
                        <th>タイトル</th>
                        <th>from</th>
                        <th>to</th>
                    </tr>
                        <?php foreach ($logresult as $key => $value): ?>
                        <tr>
                            <td><?php echo $value['created']; ?></td>
                            <td><?php echo $value['card_name']; ?></td>
                            <td><?php echo $value['list_before']; ?></td>
                            <td><?php echo $value['list_after']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                </table>
            </div>
            <div class="column cat2">
                
            </div>
        </div>
    </body>
</html>
