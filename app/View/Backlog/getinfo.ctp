<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/backlog.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<?php echo $this->element('menu_backlog'); ?>


<div class="wrapper">
    <div class="column cat1">
        <div class="upside">
            <?php //debug($milestones)?>

            <table>
                <tr>
                    <th>type</th>
                    <th>milestone</th>
                    <th>Key</th>
                    <th>Summary</th>
                    <th>Category</th>
                </tr>

                <?php foreach ($result_tickets as $milestoneOrder => $ticketByMilestone): ?>
                    <?php foreach ($ticketByMilestone as $key => $value):?>
                    <?php
                            $categoryList = '';
                            $fdc_flg = 0;
                            foreach ($value['category'] as $key => $category) {
                                $categoryList = $categoryList.$category['name']."<br>";
                                if($category['id'] == 50751){
                                    $fdc_flg = 1;
                                }
                            }
                    ?>


                    <tr class="<?php echo  $fdc_flg ? 'fdc_task' : 'other_task' ?>">
                        <td><?php echo $value['issueType']['name'] ?></td>
                        <td><?php echo $milestones[$milestoneOrder]?></td>
                        <td><?php echo $value['issueKey'] ?></td>
                        <td><?php echo $value['summary'] ?></td>
                        <td>
                            <?php echo $categoryList ?>

                        </td>
                    <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>

            </table>


        </div>
    </div>
</div>
<style type="text/css">

    .fdc_task {

        color: #bebeff;
        text-shadow:
            0 0 10px,
            0 0 13px,
            0 0 15px;
    }
    .other_task {
        color: #bebeff;

    }


</style>
