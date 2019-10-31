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
                <div class="upside">
 
                </div>

                <div class="downside">
                    <div class="menu">
                        <form name="listoflist">
                            <p class="listbutton">
                                <span><a href="#" class="square_btn" onclick="allchecklist(true);">All Open</a></span>
                                <span><a href="#" class="square_btn" onclick="allchecklist(false);">All Close</a></span>
                            </p>
                            <?php $i = 1; ?>
                            <?php foreach ($fixByList as $key => $value): ?>
                                <label class="green" style="color:<?php echo $colorList[$key]?>" for="Panel<?php echo $i ?>"><?php echo $key?></label>
                                <input type="checkbox" id="Panel<?php echo $i ?>" class="on-off" name="foropen">
                                <?php $i++; ?>
                                <ul>
                                    <?php foreach ($value as $key2 => $value2): ?>
                                        <li>
                                            <span style="color: <?php echo $value2['due']['color'] ?>;"><?php echo($value2['due']['due']) ?></span>
                                            <a href="<?php echo($value2['shortUrl']) ?>" target="_blank"><?php echo $key2 ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="column cat2">
                <div class="upside">
                    <div class="menu">
                        <form name="listofmember">
                            <p class="listbutton">
                                <a href="#" class="square_btn" onclick="allcheckmember(true);">All Open</a>
                                <a href="#" class="square_btn" onclick="allcheckmember(false);">All Close</a>
                            </p>

                            <?php $i = 1; ?>
                            <?php foreach ($memberListx as $key => $value): ?>
                                <h3>
                                    <?php echo $key?>
                                </h3>
                                <?php foreach ($value as $key2 => $value2): ?>
                                    <label class="red" for="Panelmid<?php echo $i ?>">
                                        <?php if ( $memberListx[$key][$key2]['Freeflag'] == true && $memberListx[$key][$key2]['devflag'] == true): ?>
                                            <span style="color:#ff5555">●</span>
                                        <?php endif; ?>
                                        <span><?php echo $key2 .' '.(count($value2)-2).'cards'?></span>
                                    </label>
                                    <input type="checkbox" id="Panelmid<?php echo $i ?>" class="on-off" />
                                    <?php $i++;?>
                                    <ul>
                                        <?php foreach ($value2 as $key3 => $value3): ?>
                                            <li>
                                                <span style="color: <?php echo $value3['due']['color'] ?>;"><?php echo $value3['due']['due']?></span>
                                                <span style="color:#000; background: <?php echo $value3['idBoard']['color'] ?>;"><?php echo ' '.$value3['idBoard']['listName'].' ' ?></span>
                                                <a href="<?php echo $value3['shortUrl'] ?>" target="_blank"><?php echo $value3['card_name'] ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
