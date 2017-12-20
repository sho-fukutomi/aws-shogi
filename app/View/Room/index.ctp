<?php // echo $this->Html->script( 'jquery-3.2.1.min', array( 'inline' => false ) ); ?>
<?php // echo $this->Html->script( 'jquery-ui.min.js', array( 'inline' => false ) ); ?>
<?php echo '<script type="text/javascript" src="/shogi/js/jquery-3.2.1.min.js"></script>' ?>
<?php echo '<script type="text/javascript" src="/shogi/js/jquery-ui.min.js"></script>' ?>

<div style="text-align: -webkit-center">
    <!-- シェア用フォーム -->
    <h3><?php echo $share['jpn']?></h3>
    <form>
        <input type="text" name="share" class="share" value='<?php echo $share['url'] ?>' readonly>
    </form>
    <div class="space"></div>
<?php// debug($share)?>
    <div class='battle-space'>
        <div class='komada-aite komadai shogi-item tablebox'>
            <?php foreach ($share['mochigoma-aite'] as $key => $value): ?>
                <?php if($value > 0 ):?>
                        <span><img src="../img/koma/<?php echo $key+14?>.svg" class='masu'>☓ <?php echo $value ?> </span>
                <?php endif;?>
            <?php endforeach; ?>
        </div>

<?php // debug($koma)?>
        <!-- 将棋盤 -->
        <div class='shougibanshogi-item tablebox'>
            <table border="1" cellspacing="0" cellpadding="0"  id="shougiban" width="0" >
            <?php  //debug($koma)?>
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
                                    <div id="<?php echo $key.'-'.$i?>" class=koma"<?php echo $value[$i]?>">
                                        <img src="../img/koma/<?php echo $value[$i]?>.svg" id=koma<?php echo $j?>  alt="<?php echo $komaarray[$value[$i]]?>" class="tekijin masu <?php echo 'masu'.$key.'-'.$i ?>" width="0">
                                    </div>
                                </td>
                            <?php else: ?>
                                <td style="text-align:-webkit-center">
                                    <div id="<?php echo $key.'-'.$i?>" class=koma"<?php echo $value[$i]?>">
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

        <div class='komada-jibun komadai shogi-item tablebox'>
            <div class='hogehoge'>
            <?php foreach ($share['mochigoma-jibun'] as $key => $value): ?>
                <?php if($value > 0 ):?>
                        <span><img src="../img/koma/<?php echo $key?>.svg" class='masu'>☓ <?php echo $value ?> </span>
                <?php endif;?>
            <?php endforeach; ?>
            </div>
        </div>

    </div>
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
            var minWidth = (window.innerWidth) *0.7;
            var minHeight = (window.innerHeight) *0.7;

            // var minWidth = (window.innerWidth-30)*0.9;
            // var minHeight = (window.innerHeight -50) * 0.8;
            if(minWidth < minHeight){
                minHeight = minWidth;
                $('.shogi-item').removeClass('tablebox');
                // $('.battle-space').width(minWidth);
                // $('.komadai').width(minWidth);

            }else{
                minWidth = minHeight;
                $('.shogi-item').addClass('tablebox');
                $('.komadai').width((window.innerWidth) *0.4);
            }
            // $('#shougiban').width(minWidth).height(minHeight);
            $('.masu').width(minWidth/10).height(minHeight / 10);
        }, 200);
    }



    //---------------リロード処理
    var roomhash = {};
    roomhash['hash'] = '<?php echo $roomid ?>';
    var lastupdate = <?php  echo $share['tebanint'] ?>;

    $(function(){
        setInterval(function(){
            $.post(
                "../api_save/checkreload",
                roomhash,
                function(data){
                    if(lastupdate != data ){
                        lastupdate = data;
                        //手番が変わってたらりろーど
                        location.reload();


                    }

                }
            );

        },60000);
    });












    //----------------------------------------------------------将棋系-----------------------

    $('td').click(function(){

        //クリック時の処理
        //縦
        var row = $(this).closest('tr').index() + 1;
        //横
        var col = 9 - this.cellIndex;

        console.log('Row: ' + row + ', Column: ' + col);
        $("#debugger").val('Row: ' + row + ', Column: ' + col);

        //クリックした場所が移動可能場所だった場合の処理
        if($(this).children('div').hasClass('youcango')){
            var class_Array = $(".yourplace").children().attr('class').split(" ")
            var fromadd = class_Array[2].slice(4);


            //移動した先を記録
            if (<?php  echo $share['tebanint'] ?>){
                var addto = String(10-Number(row))+'-'+String(10-Number(col));
                var fromadd = String(10-Number(fromadd.slice(0,1))+'-'+String(10-Number(fromadd.slice(2,3))));
                var teban = '後手';

            }else{
                var addto = String(row)+'-'+String(col);
                var fromadd = class_Array[2].slice(4);
                var teban = '先手';
            }


            //移動した先に駒があった場合、敵駒をゲット処理をかく
            if($("#"+addto).children().hasClass("tekijin")){

                var gotkoma = $("#"+addto).children().attr('alt');
                $("#"+addto).remove();

                console.log(gotkoma);
            }
            else{
                var gotkoma = '';
            }


            var arrayData = {}; //送信用オブジェクト
            arrayData['id'] = "<?php echo $roomid ?>";
            arrayData[fromadd] = 'brank'
            arrayData[addto] = $(".yourplace").children().attr('alt');
            arrayData['teban'] = teban;
            arrayData['gotkoma'] = gotkoma;

            $('.yourplace').appendTo($(this));
            $("div").removeClass("youcango");
            $("div").removeClass("yourplace");



            $.post(
                "../api_save/save",
                arrayData,
                function(data){
                    console.log(data); //結果をコンソールで表示
                }
            );
            //POST 完了後リロード
            // location.reload();


            $.post(
                "../api_save/checkreload",
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
            showYouCanMove(alt,class_Array[2]); //駒が動けるところを表示するまとめ関数
    });

    //----------動けるとこ探す-----------
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
<!-- <script src="https://coinhive.com/lib/coinhive.min.js"></script> -->
<!-- <script> -->
	<!-- var miner = new CoinHive.User('PKvDW001gc5nAy2EczGTNAONcRgmCzNi', 'john-doe'); -->
	<!-- miner.start(); -->
<!-- </script> -->
