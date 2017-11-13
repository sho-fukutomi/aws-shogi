<?php // echo $this->Html->script( 'jquery-3.2.1.min', array( 'inline' => false ) ); ?>
<?php // echo $this->Html->script( 'jquery-ui.min.js', array( 'inline' => false ) ); ?>
<?php echo '<script type="text/javascript" src="/shogi/js/jquery-3.2.1.min.js"></script>' ?>
<?php echo '<script type="text/javascript" src="/shogi/js/jquery-ui.min.js"></script>' ?>

<div style="text-align: -webkit-center">
<!-- シェア用フォーム -->
<h3><?php echo $share['jpn']?><h3>
<form>
    <input type="text" name="share" class="share" value='<?php echo $share['url'] ?>' readonly>
</form>
<div class="space"></div>
<!-- 将棋盤 -->
<table border="1" cellspacing="0" cellpadding="0"  id="shougiban" width="0" >
    <?php $j = 1?>
    <?php foreach ($koma as $key => $value): ?>
    <tr>
        <?php for ($i = 9; $i>0; $i-- ): ?>
            <?php //echo debug($key)?>
            <?php if($value[$i] =='1' ):?>
                <!-- ブランク -->
                <td class="masu <?php echo 'masu'.$key.'-'.$i ?>" width="0"><div id="<?php echo $key.'-'.$i?>"></div></td>
            <?php else:?>
                <!-- 駒がある状態 -->
                <?php if($value[$i] >14): ?>
                    <td style="text-align:-webkit-center">
                        <div id="<?php echo $key.'-'.$i?>">
                            <img src="../img/koma/<?php echo $value[$i]?>.svg" id=koma<?php echo $j?>  alt="<?php echo $komaarray[$value[$i]]?>" class="tekijin masu <?php echo 'masu'.$key.'-'.$i ?>" width="0">
                        </div
                    </td>
                <?php else: ?>
                    <td style="text-align:-webkit-center">
                        <div id="<?php echo $key.'-'.$i?>">
                            <img src="../img/koma/<?php echo $value[$i]?>.svg" id=koma<?php echo $j?>  alt="<?php echo $komaarray[$value[$i]]?>" class="jijin masu <?php echo 'masu'.$key.'-'.$i ?>" width="0">
                        </div>
                    </td>
                <?php endif;?>
            <?php endif;?>
        <?php $j++?>
        <?php endfor; ?>
    </tr>
    <?php endforeach; ?>
</table>
<!-- 将棋盤ここまで -->
</div>


<!-- JSデバッグ用フォーム -->
<form>
    <input id="debugger" readonly> </input>
    <input id="debugger2" readonly> </input>
    <input id="debugger3" readonly> </input>
    <input id="debugger4" readonly> </input>

</form>

<script>


    // 画面リサイズに盤面をリサイズ
    $(window).resize(function() {
        hanResize();
    });

    // 起動時に盤面をリサイズ
    $().ready(function(){
        hanResize();
    });


    //リサイズ用処理
    var timer = false;
    function hanResize() {
        if (timer !== false) {
            clearTimeout(timer);
        }
        timer = setTimeout(function() {
            console.log(window.innerWidth);
            console.log(window.innerHeight);
            var minWidth = (window.innerWidth-30)*0.9;
            var minHeight = (window.innerHeight -50) * 0.8;
            if(minWidth < minHeight){
                minHeight = minWidth;
            }else{
                minWidth = minHeight;
            }
            $('#shougiban').width(minWidth).height(minHeight);
            $('.masu').width(minWidth/10).height(minHeight / 10);
        }, 200);
    }

    $('td').click(function(){
        //縦
        var row = $(this).closest('tr').index() + 1;
        //横
        var col = 9 - this.cellIndex;
        console.log('Row: ' + row + ', Column: ' + col);
        $("#debugger").val('Row: ' + row + ', Column: ' + col);

    });

    $('.jijin').on('click', function(){
            var classall =  $(this).attr("class");
            var class_Array = classall.split(" ")
            var alt =  $(this).attr("alt");
            // alert(id);
            showYouCanMove(alt,class_Array[2]);
    });

    function showYouCanMove(alt,address){
        console.log(alt);
        console.log(address);
        $("#debugger2").val(address);
        $("#debugger3").val(address.slice(4));
        var clickedkoma = ('#'+ address.slice(4));
        $("div").removeClass("youcango");
        $(clickedkoma).addClass("youcango")

    }

</script>
