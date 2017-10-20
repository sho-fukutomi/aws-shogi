<?php echo $this->Html->script( 'jquery-3.2.1.min', array( 'inline' => false ) ); ?>
<?php echo $this->Html->script( 'jquery-ui.min.js', array( 'inline' => false ) ); ?>


<div style="text-align: -webkit-center">
<!-- シェア用フォーム -->
<h3><?php echo $share['jpn']?><h3>
<form>
<input style="font-size:80%" type="text" name="share" value='<?php echo $share['url'] ?>' readonly>
</form>

<!-- 将棋盤 -->
<table style="width:700px" id="shougiban">
    <?php $j = 1?>
    <?php foreach ($koma as $key => $value): ?>
    <tr style="height:70px">
        <?php for ($i = 9; $i>0; $i-- ): ?>
            <?php //echo debug($key)?>
            <?php if($value[$i] =='1' ):?>
                <!-- ブランク -->

                <td class="masu <?php echo 'masu'.$key.'-'.$i ?>"></td>
            <?php else:?>
                <!-- 駒がある状態 -->
                <?php if($value[$i] >14): ?>
                    <td style="text-align:-webkit-center"><img src="../img/koma/<?php echo $value[$i]?>.png" id=koma<?php echo $j?>  alt="<?php echo $komaarray[$value[$i]]?>" class="tekijin masu <?php echo 'masu'.$key.'-'.$i ?>"> </td>
                <?php else: ?>
                    <td style="text-align:-webkit-center"><img src="../img/koma/<?php echo $value[$i]?>.png" id=koma<?php echo $j?>  alt="<?php echo $komaarray[$value[$i]]?>" class="jijin masu <?php echo 'masu'.$key.'-'.$i ?>"> </td>
                <?php endif;?>
            <?php endif;?>
        <?php $j++?>
        <?php endfor; ?>
    </tr>
    <?php endforeach; ?>
</table>
<!-- 将棋盤ここまで -->
</div>



<form>
    <input id="debugger" readonly> </input>
    <input id="debugger2" readonly> </input>
    <input id="debugger3" readonly> </input>
    <input id="debugger4" readonly> </input>

</form>
<script>

$(".jijin").draggable({
        snap        : ".masu",
        snapMode    : "inner",
        stop: function(event, ui) {
            //$("#debugger").val($('#shougiban').offset().top, $('#shougiban').get(0).offsetTop, $('#shougiban').position().top, '#1');

            var row = $(this).closest('tr').index();
            //横
            var col = $(this).closest('td').index();

            $("#debugger").val(row);
            $("#debugger2").val(col);


    	}
        //containment: 'parent'

     });


$('td').click(function(){
    //縦
    var row = $(this).closest('tr').index();
    //横
    var col = this.cellIndex;
    console.log('Row: ' + row + ', Column: ' + col);
    console.log("test test test");

});

//$("#debugger").val('lkjaflkjaf')



</script>
