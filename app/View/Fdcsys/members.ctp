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





<div class="wrapper">
    <div class="column cat1">
        <div class="upside">
            <table>
                <tr>
                    <th><?php echo $membername; ?></th>
                    <?php
                        $time[0] = '🕛';
                        $time[1] = '🕐';
                        $time[2] = '🕑';
                        $time[3] = '🕒';
                        $time[4] = '🕓';
                        $time[5] = '🕔';
                        $time[6] = '🕕';
                        $time[7] = '🕖';
                        $time[8] = '🕗';
                        $time[9] = '🕘';
                        $time[10] = '🕙';
                        $time[11] = '🕚';
                    ?>
                    <?php foreach ($update_date_list as $Key => $update_date): ?>
                            <th >
                                <div>
                                    <?php echo substr($update_date,5,5)?>
                                </div>
                                <div>
                                <?php
                                    if(substr($update_date,11,2) >= 12){
                                        $time12 = substr($update_date,11,2) - 12;
                                        $ampm = 'PM';
                                    }else{
                                        $time12 = substr($update_date,11,2);
                                        $ampm = 'AM';
                                    }
                                    echo $ampm;
                                ?>
                                </div>
                                <div>
                                    <?php echo $time[number_format($time12)]; ?>
                                </div>
                            </th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($result as $key2 => $cardDetail): ?>

                <tr>
                    <td><?php echo substr($key2,0,7) ?></td>
                    <?php foreach ($update_date_list as $Key => $update_date): ?>
                        <?php if(array_key_exists($update_date, $cardDetail)): ?>
                            <td class="td<?php echo $cardDetail[$update_date]['id'] ?>" style="text-align: center">
                                <?php //echo $cardDetail[$update_date]['name'];  ?>

                                <nobr class="text">■</nobr>
                                <p class="fukidashi"><?php echo $cardDetail[$update_date]['name']?></p>


                            </td>
                        <?php else:?>
                            <td></td>
                        <?php endif;?>
                    <?php endforeach; ?>

                </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</div>
