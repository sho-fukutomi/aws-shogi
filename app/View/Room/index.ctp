<?php // echo $this->Html->script( 'jquery-3.2.1.min', array( 'inline' => false ) ); ?>
<?php // echo $this->Html->script( 'jquery-ui.min.js', array( 'inline' => false ) ); ?>
<?php echo '<script type="text/javascript" src="/shogi/js/jquery-3.2.1.min.js"></script>' ?>
<?php echo '<script type="text/javascript" src="/shogi/js/jquery-ui.min.js"></script>' ?>

<div style="text-align: -webkit-center">
<!-- シェア用フォーム -->
<h3><?php echo $share['jpn']?><h3>
<form>
<input style="font-size:80%" type="text" name="share" value='<?php echo $share['url'] ?>' readonly>
</form>

<!-- 将棋盤 -->
<table id="shougiban width="0">
    <?php $j = 1?>
    <?php foreach ($koma as $key => $value): ?>
    <tr>
        <?php for ($i = 9; $i>0; $i-- ): ?>
            <?php //echo debug($key)?>
            <?php if($value[$i] =='1' ):?>
                <!-- ブランク -->

                <td class="masu <?php echo 'masu'.$key.'-'.$i ?> width="0"></td>
            <?php else:?>
                <!-- 駒がある状態 -->
                <?php if($value[$i] >14): ?>
                    <td style="text-align:-webkit-center">
                        <img src="../img/koma/<?php echo $value[$i]?>.svg" id=koma<?php echo $j?>  alt="<?php echo $komaarray[$value[$i]]?>" class="tekijin masu <?php echo 'masu'.$key.'-'.$i ?>" width="0">
                        <!-- <svg class="icon-logo">
                            <use xlink:href="#koma1"/>
                        </svg> -->
                    </td>
                <?php else: ?>

                    <td style="text-align:-webkit-center"><img src="../img/koma/<?php echo $value[$i]?>.svg" id=koma<?php echo $j?>  alt="<?php echo $komaarray[$value[$i]]?>" class="jijin masu <?php echo 'masu'.$key.'-'.$i ?>" width="0"> </td>
                    <!-- <svg class="icon-logo">
                        <use xlink:href="#koma1"/>
                    </svg> -->
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
    start : function (event , ui){
        console.log("start event start" );
        console.log(event , ui);
    } ,
    stop: function(event, ui) {
        var row = $(this).closest('tr').index();
        var col = $(this).closest('td').index();
        $("#debugger").val(row); // 動く前のコマの位置
        $("#debugger2").val(col);// 動く前のコマの位置
    }
});


var timer = false;
$(window).resize(function() {
    hanResize();
});
$().ready(function(){
    hanResize();
});

function hanResize() {


        if (timer !== false) {
            clearTimeout(timer);
        }
        timer = setTimeout(function() {
            console.log($(window).width());
            console.log($(window).height());
            var minWidth = $(window).innerWidth()*0.9;
            var minHeight = window.innerHeight * 0.8;
            if(minWidth < minHeight){
                minHeight = minWidth;
            }else{
                minWidth = minHeight;
            }


            $('#shougiban').width(minWidth).height(minHeight);
            $('.masu').width(minWidth / 10).height(minHeight / 10);



            // 何らかの処理
        }, 200);
    }

//$("#debugger").val('lkjaflkjaf')

</script>
