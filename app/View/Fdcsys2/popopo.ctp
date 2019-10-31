<html>
    <head>
        <title>ぽぽぽ</title>
        <link rel="stylesheet" type="text/css" href="/shogi/css/fdcsys2.css">
     
    </head>
    <body>
    <?php echo $this->element('menu2'); ?>
        <div class="wrapper">
            <div class="column cat1">
                <div class="upside">
 
                </div>

                <div class="downside">
                    <div class="menu">
                        <form name="listoflist">
                            <table>
                                <tr>
                                    <th>position</th>
                                    <th>name</th>
                                    <th>card count</th>
                                    <th>working cards</th>
                                    <th>waiting cards</th>
                                    <th>all cards</th>

                                </tr>
                            <?php foreach($membersLists as $key => $member): ?>
                                <tr class="category_<?php echo $member['team_detail']['category'] ?>">
                                    <td><?php echo $member['team_detail']['name']?></td>
                                    <td class="name"><?php echo $member['username'] ?></td>
                                    <td><?php if(isset($member['cards'])){echo " total ".count($member['cards'])."cards";}else{echo 'no card';}?></td>
                                    <td>
                                        <div class="issuelist">
                                        <?php if(isset($member['incharge'])):  ?>
                                            <?php foreach($member['incharge'] as $key2 => $issue ): ?>
                                            <?php //echo $issue['list']['work_status'] ?>
                                                <?php if($issue['list']['work_status']): ?>
                                                    <div class='workingissue'>
                                                        <div class='listname'><?php echo $issue['list']['name'] ?></div>
                                                        <div class='issuename'><?php echo $issue['name'] ?> </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif;?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="issuelist">
                                        <?php if(isset($member['incharge'])):  ?>
                                            <?php foreach($member['incharge'] as $key2 => $issue ): ?>
                                            <?php //echo $issue['list']['work_status'] ?>
                                                <?php if(!($issue['list']['work_status'])): ?>
                                                    <div class='workingissue'>
                                                        <div class='listname'><?php echo $issue['list']['name'] ?></div>
                                                        <div class='issuename'><?php echo $issue['name'] ?> </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif;?>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <?php if(isset($member['cards'])): ?>
                                            <?php foreach($member['cards'] as $key2 => $cardId ): ?>
                                                <div>
                                                    <a href="cardhistory/<?php echo $cardId?>"><?php echo $cardlistById[$cardId]['name'] ?></a>
                                                </div>
                                            <?php endforeach; ?>
                                            <?php endif ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </table>

                            
                        </form>
                        <?php //debug($cardlistById)?>

                        <?php //debug($membersLists)?>
                    </div>
                </div>
            </div>
           
        </div>
    </body>
</html>

<style type="text/css">
    .memberlist {
        display: flex;
        margin: 10px;
    }
    .issuelist {
        margin-left: 20px;
        
    }
    .category_1{

    }
    .category_2{
        color: #bebeff;
    }
    .category_3{
        color: #c79db2;
    }
    .category_4{
        
    }
    .category_9{
        color: #111111;

    }
    .workingissue{
        margin: 20px;
    }
    .listname{
        text-shadow:
            0 0 10px,
            0 0 13px,
            0 0 15px;
    }
    .name{
        font-weight: bold;
        font-size: x-large;
    }
    
</style>
