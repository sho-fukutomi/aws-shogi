<head>
    <link rel="stylesheet" type="text/css" href="/shogi/css/fdcsys2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
            <?php //debug($newList);?>
            <?php //debug($listFromDb);?>
            <h2> -- NewList -- </h2>
            <table>
                <tr>
                    <th>using_status</th>
                    <th>name</th>
                    <th>position_in_charge</th>
                    <th>work_status</th>
                    <th>update</th>
                </tr>
                <?php foreach ($newList as $key => $value): ?>
                    <tr>
                        <td><?php echo $value['using_status'] ? "enable" : "disable" ?> </td>
                        <td><?php echo $value['name'] ?> </td>
                        <td>
                            <select name="example" class="position_in_charge_<?php echo $key; ?>">
                                <?php foreach($teamCategory as $teamId => $team) :?>
                                    <option value="<?php echo $teamId ?>"> <?php echo $team; ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="example" class="work_status_<?php echo $key; ?>">
                                    <option value="0"> waiting </option>
                                    <option value="1"> working </option>
                                    <option value="9"> pending </option>
                            </select>
                        </td>
                        <td>
                            <button id="<?php echo $key ?>" class="editbutton">EDIT</button>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
        <div class="downside">
            <h2> -- current list -- </h2>
            <table>
                <tr>
                    <th>using_status</th>
                    <th>name</th>
                    <th>position_in_charge</th>
                    <th>work_status</th>
                    <th>update</th>
                </tr>
                <?php foreach ($listFromDb as $key => $value): ?>
                    <tr>
                        <td><?php echo $value['using_status'] ? "enable" : "disable" ?> </td>
                        <td><?php echo $value['name'] ?> </td>
                        <td>
                            <select name="example" class="position_in_charge_<?php echo $key; ?>">
                                <?php foreach($teamCategory as $teamId => $team) :?>
                                    <option value="<?php echo $teamId ?>" <?php echo $value['position_in_charge']==$teamId ? 'selected' : ''  ?>> <?php echo $team; ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select name="example" class="work_status_<?php echo $key; ?>">
                                <?php foreach ($workStatuslist as $workStatusKey => $workStatus): ?>
                                    <option value="<?php echo $workStatusKey ?>" <?php echo $value['work_status']==$workStatusKey ? 'selected' : ''  ?>> <?php echo $workStatus; ?> </option>
                                <?php endforeach; ?>
                            </select>

                        </td>
                        <td>
                            <button id="<?php echo $key ?>" class="editbutton">EDIT</button>
                        </td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</div>

   <script>
        $(".editbutton").on('click',function(){

            console.log($($(".position_in_charge_"+$(this).attr("id"))).val())
            console.log($($(".work_status_"+$(this).attr("id"))).val())
            $.ajax({
                    url:'./listupdate',
                    type:'POST',
                    data:{
                        'id':$(this).attr("id"),
                        'position_in_charge':$($(".position_in_charge_"+$(this).attr("id"))).val(),
                        'work_status':$($(".work_status_"+$(this).attr("id"))).val()
                    },
                    success: function(j_data){
 
                     // 処理を記述
                        console.log(j_data);
                    }
                }


                );


                // // Ajaxリクエストが成功した時発動
                // .done( (data) => {
                //     $('.result').html(data);
                //    console.log(data);
                // })
                // // Ajaxリクエストが失敗した時発動
                // .fail( (data) => {
                //     $('.result').html(data);
                //    console.log(data);
                // })
                // // Ajaxリクエストが成功・失敗どちらでも発動
                // .always( (data) => {

                // }
                // );
        });
    </script>
