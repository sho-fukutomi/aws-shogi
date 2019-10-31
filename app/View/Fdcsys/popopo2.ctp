<html>
    <head>
        <title>ぽぽぽ</title>
        <link rel="stylesheet" type="text/css" href="/shogi/css/fdcsys.css">
        <script>
            // function allchecklist( tf ) {
            //    var ElementsCount = document.listoflist.elements.length; // チェックボックスの数
            //    for( i=0 ; i<ElementsCount ; i++ ) {
            //       document.listoflist.elements[i].checked = tf; // ON・OFFを切り替え
            //    }
            // }
            // function allcheckmember( tf ) {
            //    var ElementsCount = document.listofmember.elements.length; // チェックボックスの数
            //    for( i=0 ; i<ElementsCount ; i++ ) {
            //       document.listofmember.elements[i].checked = tf; // ON・OFFを切り替え
            //    }
            // }
        </script>
    </head>
    <body>
    <?php echo $this->element('menu'); ?>

        <div class="wrapper">
                <div class="upside">

                        <?php foreach ($resultByBacklog as $milestoneName => $value): ?>
                            <h2><?php echo $milestoneName ?></h2>
                            <table style="margin-left: 0;width: 1600px;">
                                <?php foreach ($value as $issueKey => $value2): ?>
                                    <?php foreach ($value2['category'] as $key => $value3): ?>
                                        <?php //debug($value3)?>
                                        <?php //if ($value3 == '開発（FDC）'): ?>

                                            <tr>
                                                <td style="width: 100px;" ><a href="https://love.backlog.jp/view/<?php echo$issueKey ?>" target="_blank"><?php echo $issueKey ?></td>
                                                <td style="width: 130px;" >
                                                    <?php foreach ($value2['category'] as $key => $value3): ?>
                                                        <div><?php echo $value3 ?></div>
                                                    <?php endforeach; ?>
                                                    <?php //debug($value2)?>
                                                </td>
                                                <td style="width: 850px;" >
                                                    <div style="color:#c5ffdd"><?php echo $value2['summary'] ?></div>
                                                    <div style="color:<?php echo $value2['trello']['idBoard']['color'] ?>"><?php echo $value2['trello']['card_name'] ?></div>
                                                </td>
                                                <td style="width: 350px;" >
                                                    <div style="color:#c5e4d1;"><?php echo $milestoneName.' '.substr($value2['dueDate'],5,5)  ?></div>
                                                    <div>
                                                        <span style="color:<?php echo $value2['trello']['idBoard']['color'] ?>"> <?php echo $value2['trello']['idBoard']['listName']?> </span>
                                                        <span style="color:<?php echo $value2['trello']['due']['color'] ?>"> <?php echo $value2['trello']['due']['due'] ?></span><??>
                                                    </div>
                                                </td>
                                            </tr>

                                            <?php break; ?>



                                    <?php endforeach; ?>


                                <?php endforeach; ?>
                            </table>

                        <?php endforeach; ?>

                </div>



                <div class="downside">
                    <div class="menu">


                    </div>
                </div>
        </div>
    </body>
</html>
