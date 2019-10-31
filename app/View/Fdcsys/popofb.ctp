<html>
    <head>
        <title>ぽぽぽ</title>
        <link rel="stylesheet" type="text/css" href="/shogi/css/fdcsys.css">
        <script>
            function allchecklist( tf ) {
               var ElementsCount = document.listoflist.elements.length; // チェックボックスの数
               for( i=0 ; i<ElementsCount ; i++ ) {
                  document.listoflist.elements[i].checked = tf; // ON・OFFを切り替え
               }
            }
            function allcheckmember( tf ) {
               var ElementsCount = document.listofmember.elements.length; // チェックボックスの数
               for( i=0 ; i<ElementsCount ; i++ ) {
                  document.listofmember.elements[i].checked = tf; // ON・OFFを切り替え
               }
            }
        </script>
    </head>
    <body>
    <?php echo $this->element('menu'); ?>
        <div class="wrapper">
            <div class="column cat1">


<?php //debug($resultFB); ?>
                <div class="downside">
                    <div class="menu">
                        <form name="listoflist">
                            <p class="listbutton">
                                <span><a href="#" class="square_btn" onclick="allchecklist(true);">All Open</a></span>
                                <span><a href="#" class="square_btn" onclick="allchecklist(false);">All Close</a></span>
                            </p>
                            <?php $i = 1; ?>

                            <?php //$tmp = array(); ?>

                            <?php foreach ($resultFB as $listname => $cards): ?>
                                <label class="green" style="color:<?php echo $colorList[$listname]?>" for="Panel<?php echo $i ?>"><?php echo $listname?></label>
                                <input type="checkbox" id="Panel<?php echo $i ?>" class="on-off" name="foropen">
                                <?php $i++; ?>
                                <ul>
                                    <?php foreach ($cards as $cardName => $card): ?>
                                        <li>
                                            <?php //$tmp[$j] = isset($card['FBhistory'])?count($card['FBhistory']):"0"; ?>
                                            <span style="color: <?php echo $card['color'];  ?>;"><?php echo "FB回数 ". $card['count'] ." 回 ";?></span>
                                            <a href="<?php echo 'http://tomitomiclub.com/shogi/fdcsys/cardhistory2/'.$card['id']; ?>" target="_blank"><?php echo $cardName ?></a>
                                        </li>
                                        
                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
