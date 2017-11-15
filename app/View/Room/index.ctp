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

    //----------------------------------------------------------リサイズ系-----------------------
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
            var minWidth = (window.innerWidth);
            var minHeight = (window.innerHeight) *0.9;

            // var minWidth = (window.innerWidth-30)*0.9;
            // var minHeight = (window.innerHeight -50) * 0.8;
            if(minWidth < minHeight){
                minHeight = minWidth;
            }else{
                minWidth = minHeight;
            }
            $('#shougiban').width(minWidth).height(minHeight);
            $('.masu').width(minWidth/10).height(minHeight / 10);
        }, 200);
    }


    //----------------------------------------------------------将棋系-----------------------

    $('td').click(function(){
        //縦
        var row = $(this).closest('tr').index() + 1;
        //横
        var col = 9 - this.cellIndex;
        console.log('Row: ' + row + ', Column: ' + col);
        $("#debugger").val('Row: ' + row + ', Column: ' + col);

        if($(this).children('div').hasClass('youcango')){
            var arrayData = {};
            var class_Array = $(".yourplace").children().attr('class').split(" ")

            var addto = String(row)+'-'+String(col);
            var fromadd = class_Array[2].slice(4);

            arrayData['id'] = "<?php echo $roomid ?>";
            arrayData[fromadd] = 'brank'
            arrayData[addto] = $(".yourplace").children().attr('alt');

            $('.yourplace').appendTo($(this));
            $("div").removeClass("youcango");
            $("div").removeClass("yourplace");
            $.post(
                "../api_save/save",
                arrayData,
                function(data){
                    console.log(data); //結果をアラートで表示
                }
            );

        }


    });

    //----------自駒クリック時-----------
    $('.jijin').on('click', function(){
            var classall =  $(this).attr("class");
            var class_Array = classall.split(" ")
            var alt =  $(this).attr("alt");
            showYouCanMove(alt,class_Array[2]);//駒が動けるところを表示するまとめ関数
    });
    //----------動けるとこクリック時-----------



    function showYouCanMove(alt,address){
        var tate = Number(address.slice(4,5));
        var yoko = Number(address.slice(6,7));
        var clickedkoma = ('#'+ address.slice(4));
        $("div").removeClass("youcango");
        $("div").removeClass("yourplace");
        $(clickedkoma).addClass("yourplace")
        var array_address = new Array();
        var array_address_straight = new Array();

        switch (alt) {
            case "王":
            case "玉":
                array_address.push([tate-1,yoko-1]);
                array_address.push([tate-1,yoko]);
                array_address.push([tate-1,yoko+1]);
                array_address.push([tate,yoko-1]);
                array_address.push([tate,yoko+1]);
                array_address.push([tate+1,yoko-1]);
                array_address.push([tate+1,yoko]);
                array_address.push([tate+1,yoko+1]);
                break;
            case "金":
            case "成銀":
            case "成桂":
            case "成香":
            case "と金":
                array_address.push([tate-1,yoko-1]);
                array_address.push([tate-1,yoko]);
                array_address.push([tate-1,yoko+1]);
                array_address.push([tate,yoko-1]);
                array_address.push([tate,yoko+1]);
                array_address.push([tate+1,yoko]);
                break;
            case "銀":
                array_address.push([tate-1,yoko-1]);
                array_address.push([tate-1,yoko]);
                array_address.push([tate-1,yoko+1]);
                array_address.push([tate+1,yoko-1]);
                array_address.push([tate+1,yoko+1]);
                break;
            case "桂馬":
                array_address.push([tate-2,yoko-1]);
                array_address.push([tate-2,yoko+1]);

                break;
            case "歩":
                array_address.push([tate-1,yoko]);
                break;

            case "香車":
                array_address_straight.push(Array());
                array_address_straight[0].push([tate-1,yoko]);
                array_address_straight[0].push([tate-2,yoko]);
                array_address_straight[0].push([tate-3,yoko]);
                array_address_straight[0].push([tate-4,yoko]);
                array_address_straight[0].push([tate-5,yoko]);
                array_address_straight[0].push([tate-6,yoko]);
                array_address_straight[0].push([tate-7,yoko]);
                array_address_straight[0].push([tate-8,yoko]);
                break;
            case "飛車":
                array_address_straight.push(Array());
                array_address_straight[0].push([tate-1,yoko]);
                array_address_straight[0].push([tate-2,yoko]);
                array_address_straight[0].push([tate-3,yoko]);
                array_address_straight[0].push([tate-4,yoko]);
                array_address_straight[0].push([tate-5,yoko]);
                array_address_straight[0].push([tate-6,yoko]);
                array_address_straight[0].push([tate-7,yoko]);
                array_address_straight[0].push([tate-8,yoko]);
                array_address_straight.push(Array());
                array_address_straight[1].push([tate+1,yoko]);
                array_address_straight[1].push([tate+2,yoko]);
                array_address_straight[1].push([tate+3,yoko]);
                array_address_straight[1].push([tate+4,yoko]);
                array_address_straight[1].push([tate+5,yoko]);
                array_address_straight[1].push([tate+6,yoko]);
                array_address_straight[1].push([tate+7,yoko]);
                array_address_straight[1].push([tate+8,yoko]);
                array_address_straight.push(Array());
                array_address_straight[2].push([tate,yoko-1]);
                array_address_straight[2].push([tate,yoko-2]);
                array_address_straight[2].push([tate,yoko-3]);
                array_address_straight[2].push([tate,yoko-4]);
                array_address_straight[2].push([tate,yoko-5]);
                array_address_straight[2].push([tate,yoko-6]);
                array_address_straight[2].push([tate,yoko-7]);
                array_address_straight[2].push([tate,yoko-8]);
                array_address_straight.push(Array());
                array_address_straight[3].push([tate,yoko+1]);
                array_address_straight[3].push([tate,yoko+2]);
                array_address_straight[3].push([tate,yoko+3]);
                array_address_straight[3].push([tate,yoko+4]);
                array_address_straight[3].push([tate,yoko+5]);
                array_address_straight[3].push([tate,yoko+6]);
                array_address_straight[3].push([tate,yoko+7]);
                array_address_straight[3].push([tate,yoko+8]);
                break;
            case "龍":
                array_address_straight.push(Array());
                array_address_straight[0].push([tate-1,yoko]);
                array_address_straight[0].push([tate-2,yoko]);
                array_address_straight[0].push([tate-3,yoko]);
                array_address_straight[0].push([tate-4,yoko]);
                array_address_straight[0].push([tate-5,yoko]);
                array_address_straight[0].push([tate-6,yoko]);
                array_address_straight[0].push([tate-7,yoko]);
                array_address_straight[0].push([tate-8,yoko]);
                array_address_straight.push(Array());
                array_address_straight[1].push([tate+1,yoko]);
                array_address_straight[1].push([tate+2,yoko]);
                array_address_straight[1].push([tate+3,yoko]);
                array_address_straight[1].push([tate+4,yoko]);
                array_address_straight[1].push([tate+5,yoko]);
                array_address_straight[1].push([tate+6,yoko]);
                array_address_straight[1].push([tate+7,yoko]);
                array_address_straight[1].push([tate+8,yoko]);
                array_address_straight.push(Array());
                array_address_straight[2].push([tate,yoko-1]);
                array_address_straight[2].push([tate,yoko-2]);
                array_address_straight[2].push([tate,yoko-3]);
                array_address_straight[2].push([tate,yoko-4]);
                array_address_straight[2].push([tate,yoko-5]);
                array_address_straight[2].push([tate,yoko-6]);
                array_address_straight[2].push([tate,yoko-7]);
                array_address_straight[2].push([tate,yoko-8]);
                array_address_straight.push(Array());
                array_address_straight[3].push([tate,yoko+1]);
                array_address_straight[3].push([tate,yoko+2]);
                array_address_straight[3].push([tate,yoko+3]);
                array_address_straight[3].push([tate,yoko+4]);
                array_address_straight[3].push([tate,yoko+5]);
                array_address_straight[3].push([tate,yoko+6]);
                array_address_straight[3].push([tate,yoko+7]);
                array_address_straight[3].push([tate,yoko+8]);
                array_address.push([tate-1,yoko-1]);
                array_address.push([tate+1,yoko-1]);
                array_address.push([tate-1,yoko+1]);
                array_address.push([tate+1,yoko+1]);

                break;
            case "角":
                array_address_straight.push(Array());
                array_address_straight[0].push([tate-1,yoko-1]);
                array_address_straight[0].push([tate-2,yoko-2]);
                array_address_straight[0].push([tate-3,yoko-3]);
                array_address_straight[0].push([tate-4,yoko-4]);
                array_address_straight[0].push([tate-5,yoko-5]);
                array_address_straight[0].push([tate-6,yoko-6]);
                array_address_straight[0].push([tate-7,yoko-7]);
                array_address_straight[0].push([tate-8,yoko-8]);
                array_address_straight.push(Array());
                array_address_straight[1].push([tate+1,yoko+1]);
                array_address_straight[1].push([tate+2,yoko+2]);
                array_address_straight[1].push([tate+3,yoko+3]);
                array_address_straight[1].push([tate+4,yoko+4]);
                array_address_straight[1].push([tate+5,yoko+5]);
                array_address_straight[1].push([tate+6,yoko+6]);
                array_address_straight[1].push([tate+7,yoko+7]);
                array_address_straight[1].push([tate+8,yoko+8]);
                array_address_straight.push(Array());
                array_address_straight[2].push([tate+1,yoko-1]);
                array_address_straight[2].push([tate+2,yoko-2]);
                array_address_straight[2].push([tate+3,yoko-3]);
                array_address_straight[2].push([tate+4,yoko-4]);
                array_address_straight[2].push([tate+5,yoko-5]);
                array_address_straight[2].push([tate+6,yoko-6]);
                array_address_straight[2].push([tate+7,yoko-7]);
                array_address_straight[2].push([tate+8,yoko-8]);
                array_address_straight.push(Array());
                array_address_straight[3].push([tate-1,yoko+1]);
                array_address_straight[3].push([tate-2,yoko+2]);
                array_address_straight[3].push([tate-3,yoko+3]);
                array_address_straight[3].push([tate-4,yoko+4]);
                array_address_straight[3].push([tate-5,yoko+5]);
                array_address_straight[3].push([tate-6,yoko+6]);
                array_address_straight[3].push([tate-7,yoko+7]);
                array_address_straight[3].push([tate-8,yoko+8]);
                break;
            case "馬":
                array_address_straight.push(Array());
                array_address_straight[0].push([tate-1,yoko-1]);
                array_address_straight[0].push([tate-2,yoko-2]);
                array_address_straight[0].push([tate-3,yoko-3]);
                array_address_straight[0].push([tate-4,yoko-4]);
                array_address_straight[0].push([tate-5,yoko-5]);
                array_address_straight[0].push([tate-6,yoko-6]);
                array_address_straight[0].push([tate-7,yoko-7]);
                array_address_straight[0].push([tate-8,yoko-8]);
                array_address_straight.push(Array());
                array_address_straight[1].push([tate+1,yoko+1]);
                array_address_straight[1].push([tate+2,yoko+2]);
                array_address_straight[1].push([tate+3,yoko+3]);
                array_address_straight[1].push([tate+4,yoko+4]);
                array_address_straight[1].push([tate+5,yoko+5]);
                array_address_straight[1].push([tate+6,yoko+6]);
                array_address_straight[1].push([tate+7,yoko+7]);
                array_address_straight[1].push([tate+8,yoko+8]);
                array_address_straight.push(Array());
                array_address_straight[2].push([tate+1,yoko-1]);
                array_address_straight[2].push([tate+2,yoko-2]);
                array_address_straight[2].push([tate+3,yoko-3]);
                array_address_straight[2].push([tate+4,yoko-4]);
                array_address_straight[2].push([tate+5,yoko-5]);
                array_address_straight[2].push([tate+6,yoko-6]);
                array_address_straight[2].push([tate+7,yoko-7]);
                array_address_straight[2].push([tate+8,yoko-8]);
                array_address_straight.push(Array());
                array_address_straight[3].push([tate-1,yoko+1]);
                array_address_straight[3].push([tate-2,yoko+2]);
                array_address_straight[3].push([tate-3,yoko+3]);
                array_address_straight[3].push([tate-4,yoko+4]);
                array_address_straight[3].push([tate-5,yoko+5]);
                array_address_straight[3].push([tate-6,yoko+6]);
                array_address_straight[3].push([tate-7,yoko+7]);
                array_address_straight[3].push([tate-8,yoko+8]);
                array_address.push([tate,yoko-1]);
                array_address.push([tate-1,yoko]);
                array_address.push([tate,yoko+1]);
                array_address.push([tate+1,yoko]);
                break;
        }

        array_address = checkMasu(array_address);
        array_address_straight = checkMasu_straight(array_address_straight);
        addColorClass(array_address);
        addColorClass(array_address_straight);

    }

    //通常の駒の動き
    function checkMasu(array_address){
        var array_checked_address = new Array();

        var i = 0;
        var j = 0;
        while(i < array_address.length){
            if(array_address[i][0] >= 1 && array_address[i][0] <= 9 && array_address[i][1] >= 1 && array_address[i][1] <= 9 ){
                if(!$(".masu" + String(array_address[i][0]) + "-" + String(array_address[i][1])).hasClass("jijin")){
                    array_checked_address[j] = [array_address[i][0],array_address[i][1]];
                    j++;
                }
            }
            i++;
        }
        return array_checked_address;
    }
    //飛車、角、龍、馬、香車の時にこれつかう
    function checkMasu_straight(array_address_straight){
        var array_checked_address = new Array();
        var i = 0;
        var j = 0;
        var k = 0
        while(i < array_address_straight.length){
            while(j < array_address_straight[i].length){
                if(array_address_straight[i][j][0] >= 1 && array_address_straight[i][j][0] <= 9 && array_address_straight[i][j][1] >= 1 && array_address_straight[i][j][1] <= 9 ){
                    if($(".masu" + String(array_address_straight[i][j][0]) + "-" + String(array_address_straight[i][j][1])).hasClass("jijin")){
                        break;;
                    }else if($(".masu" + String(array_address_straight[i][j][0]) + "-" + String(array_address_straight[i][j][1])).hasClass("tekijin")){
                        array_checked_address[k] = [array_address_straight[i][j][0],array_address_straight[i][j][1]]
                        k++;
                        break;
                    }else{
                        array_checked_address[k] = [array_address_straight[i][j][0],array_address_straight[i][j][1]]
                        k++;
                    }
                }
                j++
            }
            j = 0 ;
            i++;
        }
        return array_checked_address;
    }

    function addColorClass(array_address){
        var i = 0;
        while(i < array_address.length){
            $("#" + String(array_address[i][0]) + "-" + String(array_address[i][1])).addClass("youcango");
            i++;
        }
    }



</script>
