<head>
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


<?php echo $this->element('menu'); ?>



<div class="wrapper">
    <div class="column cat1">
        <div class="upside">
            <?php foreach ($detailByMilestone as $milestoneName => $value): ?>
                <h2><?php echo $milestoneName.' '.$value['count'].'tickets' ?></h2>
                <table style="margin-left: 0;width: 2000px; table-layout: fixed;">
                    <?php foreach ($value['tickets'] as $issueKey => $value2): ?>
                        <tr >
                            <td rowspan="2" style="width: 100px;" ><a href="https://love.backlog.jp/view/<?php echo $issueKey ?>" target="_blank"><?php echo $issueKey ?></td>
                            <td style="width: 130px;" >
                                <?php for ($i = 0; $i <= 5; $i++):?>
                                    <?php if (!empty($value2['category'.$i.'_name'])): ?>
                                        <div><?php echo $value2['category'.$i.'_name'] ?></div>
                                    <?php endif; ?>
                                <?php endfor;?>
                            </td>
                            <td style="width: 850px;word-wrap: break-word;" >
                                <div style="color:#c5ffdd"><?php echo $value2['summary'] ?></div>
                                <div><?php echo '' ?></div>
                            </td>
                            <td class="graph">
                                <?php if(!empty($value2['history'])):?>
                                    <?php foreach ($value2['history'] as $key3 => $valuehistory): ?>
                                        <nobr class="square<?php echo substr($milestoneOrderById[$valuehistory]['name'], 0, 2)?> text"></nobr>
                                        <p class="fukidashi"><?php echo $key3.' '.$milestoneOrderById[$valuehistory]['name']?></p>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php if (!empty($cardDetailWithHistory[$issueKey]['members'])): ?>
                                    <?php foreach ($cardDetailWithHistory[$issueKey]['members'] as $key => $value): ?>
                                        <div><a href="/shogi/fdcsys/members/<?php echo $value ?>"  target="_blank"><?php echo $memberListAndTeam[$value]['name']?></a></div>
                                    <?php endforeach; ?>
                                <?php endif;?>
                            </td>
                            <td>
                                <?php if (array_key_exists($issueKey,$cardDetailWithHistory)): ?>
                                    <?php echo $cardDetailWithHistory[$issueKey]['name'] ?>

                                <?php endif; ?>
                            </td>
                            <td class="graph">
                                <?php if(!empty($cardDetailWithHistory[$issueKey]['history'])):?>
                                    <?php foreach ($cardDetailWithHistory[$issueKey]['history'] as $key => $value): ?>
                                        <nobr class="square<?php echo $value['fdc_cards']['idList'] ?> text"></nobr>
                                        <p class="fukidashi"><?php echo $value['fdc_cards']['update_date'].' '.$listlist[$value['fdc_cards']['idList']]['name_for_use'] ?></p>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        </div>
    </div>
</div>




<?php //debug($detailByMilestone); ?>
