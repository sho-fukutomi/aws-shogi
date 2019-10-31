<html>
    <head>
        <title>ぽぽぽ</title>
        <link rel="stylesheet" type="text/css" href="/shogi/css/fdcsys.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <?php echo $this->element('menu'); ?>

        <div class="wrapper">
            <div class="column cat2">
                <div>
                    <label> team setting </label>
                    <?php 
                        $category = array(
                            '1' => 'management',
                            '2' => 'develop',
                            '3' => 'tester',
                            '4' => 'BE',
                            '9' => 'other'                            
                        );
                    ?>
                    <table>
                        <?php //var_dump($teams) ?>
                        <th>team name</th>
                        <th>team category</th>
                        <th>edit</th>
                        
                        <?php foreach($teams as $key => $value):  ?>
                            <tr>
                                <td>
                                    <input type="text" name="name" value="<?php echo $value['fdc_team']['name']; ?>"class="name_<?php echo $value['fdc_team']['name']; ?>">
                                </td>

                                <td>
                                    <select name="example" class="team_<?php echo $value['fdc_team']['id']; ?>">
                                        <?php foreach ($category as $key_cate => $value_cate) : ?>
                                            <option value="<?php echo $key_cate ?>" <?php echo $value['fdc_team']['category'] == $key_cate ? 'selected':'' ; ?>>
                                                <?php echo $value_cate ; ?>
                                            </option>


                                        <?php endforeach; ?>
                                    </select>
                                    <td><button id="<?php echo $value['fdc_team']['id'] ?>" class="edit_teambutton">EDIT</button></td>
                                    
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </table>
                </div>    
            </div>

            <div class="column cat1">
                <label> member setting </label>
                <div class="result"></div>

                <table border="1" style="width: 100%;">
                    <tr>
                        <th>ID</th>
                        <th>username</th>
                        <th>FullName</th>
                        <th>nick_name</th>
                        <th>team</th>
                        <th>edit</th>
                        
                    </tr>
                        <?php foreach ($members as $key => $value): ?>
                        <tr>
                            <td><?php echo $value['fdc_members']['id']; ?></td>
                            <td><?php echo $value['fdc_members']['username']; ?></td>
                            <td><?php echo $value['fdc_members']['fullName']; ?></td>
                            <td><input type="text" name="name" value="<?php echo $value['fdc_members']['nick_name']; ?>"class="name_<?php echo $value['fdc_members']['id']; ?>"></td>
                            <td>
                                <select name="example" class="team_<?php echo $value['fdc_members']['id']; ?>">
                                <?php foreach($teams as $key2 => $value2) :?>
                                    <option value="<?php echo $value2['fdc_team']['id'] ?>" <?php echo $value['fdc_members']['team'] == $value2['fdc_team']['id']? 'selected':'' ; ?>>
                                        <?php echo $value2['fdc_team']['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                                </select>
                            </td>
                            <td><button id="<?php echo $value['fdc_members']['id'] ?>" class="editbutton">EDIT</button></td>
                        </tr>
                        <?php endforeach; ?>
                </table>
            </div>
        </div>
    </body>
    <script>
        $(".editbutton").on('click',function(){

            console.log($($(".name_"+$(this).attr("id"))).val())
            console.log($($(".team_"+$(this).attr("id"))).val())
            $.ajax({
                    url:'./memberupdate',
                    type:'POST',
                    data:{
                        'id':$(this).attr("id"),
                        'team':$($(".team_"+$(this).attr("id"))).val(),
                        'name':$($(".name_"+$(this).attr("id"))).val()
                    }
                })
                // Ajaxリクエストが成功した時発動
                .done( (data) => {
                    $('.result').html(data);
                    console.log(data);
                })
                // Ajaxリクエストが失敗した時発動
                .fail( (data) => {
                    $('.result').html(data);
                    console.log(data);
                })
                // Ajaxリクエストが成功・失敗どちらでも発動
                .always( (data) => {

                });
        });
    </script>
</html>
