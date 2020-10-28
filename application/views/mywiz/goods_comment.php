<link rel="stylesheet" href="/assets/css/mypage.css?ver=1.3">

<?
$date_today = date("Y-m-d", time());
$date_w1 = date("Y-m-d", strtotime("-1 week"));
$date_m1 = date("Y-m-d", strtotime("-1 month"));
$date_m2 = date("Y-m-d", strtotime("-3 month"));
$date_m3 = date("Y-m-d", strtotime("-6 month"));
?>

<div class="content">
    <h2 class="page-title-basic page-title-basic--line">활동 및 문의</h2>
    <h3 class="info-title info-title--sub">상품평</h3>
    <form id="updFile" name="updFile" method="post"  enctype="multipart/form-data">
        <div class="mypage-top-select">
            <input type="hidden" id="date_type" value="<?=$date_type?>">
            <ul class="tab-common-mypage-list">
                <li class="tab-common-mypage-item <?=$date_type == '0' ? 'active' : ''?>" id="btn0">
                    <a href="javascript:;" onClick="javaScrjpt:jsSetDate(0,'<?=$date_w1?>','<?=$date_today?>');" class="tab-common-mypage-link">1주일</a>
                </li>
                <li class="tab-common-mypage-item <?=$date_type == '1' ? 'active' : ''?>" id="btn1">
                    <a href="javascript:;" onClick="javaScript:jsSetDate(1,'<?=$date_m1?>','<?=$date_today?>');" class="tab-common-mypage-link">1개월</a>
                </li>
                <li class="tab-common-mypage-item <?=$date_type == '2' ? 'active' : ''?>" id="btn2">
                    <a href="javascript:;" onClick="javaScript:jsSetDate(2,'<?=$date_m2?>','<?=$date_today?>');" class="tab-common-mypage-link">3개월</a>
                </li>
                <li class="tab-common-mypage-item <?=$date_type == '3' ? 'active' : ''?>" id="btn3">
                    <a href="javascript:;" onClick="javaScript:jsSetDate(3,'<?=$date_m3?>','<?=$date_today?>');" class="tab-common-mypage-link">6개월</a>
                </li>
            </ul>

            <!-- 달력부분 // -->
            <div class="date_option_select">
                <div class="date_option_select_item">
                    <input type="text" class="input-text datepicker" readonly id="date_from" value="<?=$date_from?>"/>
                    <button type="button" class="btn_calendar"><span class="spr-common spr-calendar"></span></button>
                </div>
                <span class="date_option_select_dash">~</span>
                <div class="date_option_select_item">
                    <input type="text" class="input-text datepicker" readonly id="date_to" value="<?=$date_to?>"/>
                    <button type="submit" class="btn_calendar"><span class="spr-common spr-calendar"></span></button>
                </div>
                <button type="button" class="btn-gray btn-check" onClick="javaScript:jsSearch();">조회</button>
            </div>
            <!-- // 달력부분 -->
        </div>

        <!-- 상품평// -->
        <div class="prd-assessment-wrap">
            <ul class="prd-assessment-list">
                <?if($comment){
                    foreach($comment as $row){
                        ?>
                        <li class="prd-assessment-item" data-toggle="toggle-parent">
                            <span class="prd-assessment-date"><?=$row['REG_DT']?></span>
                            <div class="star-grade-box">
                                <span class="star-rating spr-common"><span class="star-ico spr-common" style="width:<?=$row['TOTAL_GRADE']*20?>%"></span></span>
                            </div>
                            <div class="prd-assessment-link">
                                <p class="prd-assessment-txt"><?=$row['CONTENTS']?></p>
                                <a href="/goods/detail/<?=$row['GOODS_CD']?>"><p class="prd-assessment-name">[<?=$row['BRAND_NM']?>] <?=$row['GOODS_NM']?></p></a>
                                <ul class="media-common-btn-list">
                                    <li class="media-common-btn-item"><a href="#layerPrdCommentModify" class="btn-prd-order-detail" onClick="javaScript:modify_comment_layer('<?=$row['CUST_GOODS_COMMENT']?>');">수정</a></li>
                                    <li class="media-common-btn-item"><a href="#" class="btn-prd-order-detail" onClick="javaScript:delete_comment(<?=$row['CUST_GOODS_COMMENT']?>);">삭제</a></li>
                                </ul>
                            </div>
                            <div class="prd_review" id="prd_review">
                                <ul>
                                    <li class="list">
                                        <ul class="detail">
                                            <?
                                            $i=0;
                                            if($row['FILE_PATH']){
                                                foreach($row['FILE_PATH'] as $file){
                                            ?>
                                                <?
                                                $exif = @exif_read_data($file['FILE_PATH']); //2019-12-02 이미지 회전되어 나오는 문제
                                                $degree = 0;
                                                if(!empty($exif['Orientation'])) {
                                                    switch($exif['Orientation']) {
                                                        case 8:  $degree = -90;   break;
                                                        case 3:  $degree = 180;   break;
                                                        case 6:  $degree = 90;    break;
                                                        default: $degree = 0;    break;
                                                    }
                                                }

                                                ?>
                                                <li>
                                                    <span class="hide">A</span>
                                                    <a class="view" href="#pro<?=$i?>">
                                                        <img src="<?=$file['FILE_PATH']?>" alt="" style="transform: rotate(<?=$degree?>deg);">
                                                    </a>
                                                </li>
                                            <?
                                                    $i++;
                                                }
                                            }?>
                                        </ul><!--detail-->
                                        <div class="summary">
                                            <div class="summarybg">
                                                <?
                                                $i=0;
                                                if($row['FILE_PATH']){
                                                    foreach($row['FILE_PATH'] as $file){
                                                ?>
                                                    <?
                                                    $exif = @exif_read_data($file['FILE_PATH']); //2019-12-02 이미지 회전되어 나오는 문제
                                                    $degree = 0;
                                                    if(!empty($exif['Orientation'])) {
                                                        switch($exif['Orientation']) {
                                                            case 8:  $degree = -90;   break;
                                                            case 3:  $degree = 180;   break;
                                                            case 6:  $degree = 90;    break;
                                                            default: $degree = 0;    break;
                                                        }
                                                    }

                                                    ?>
                                                    <div id="pro<?=$i?>" class="product">
                                                        <div class="list_img">
                                                            <img src="<?=$file['FILE_PATH']?>" alt="" style="transform: rotate(<?=$degree?>deg);">
                                                        </div>
                                                    </div>
                                                <?
                                                        $i++;
                                                    }
                                                }?>
                                            </div><!--//summarybg-->
                                        </div><!--//summary-->
                                    </li><!--//list-->
                                </ul>
                            </div>
                        </li>
                        <?
                    }
                }
                ?>
            </ul>
            <!-- 페이징 // -->
            <?=$pagination?>
            <!-- // 페이징  -->

            <div id="modify_comment"></div>

        </div>
    </form>

    <!-- //상품평 -->

</div>

<script>

    $(function(){
        $('header').mouseenter(function(){
            //alert()
            $('.subBg').stop().slideDown()
        })
        $('header').mouseleave(function(){
            $('.subBg').stop().slideUp()
        })

        $('a.view').click(function(e){
            e.preventDefault();
            var current=$(this).parents('.detail')

            $('.detail').not(current).next().animate({'height':0})
            // $('.detail').next().animate({'height':0})

            var href=$(this).attr('href');//화면에 보여라 안보여라
            $('.detail li a').removeClass('on');
            $(this).addClass('on')

            //alert(href)
            $('.product').fadeOut()
            $(href).fadeIn()

            $(href).find('.detail_arrow').addClass('on')


            var h=$(href).height()
            $(current).next().animate({'height':h})

        })

        $('.close').click(function(e){
            e.preventDefault();
            $(this).parents('.summary').animate({'height':0})
            $('.detail_arrow').removeClass('on')
            $('a.view').removeClass('on');
        })
    })

</script>
<script>
    //datepicker
    $(function()
    {
        $(".datepicker").datepicker(
            {
                showOn: "button",
                dateFormat: 'yy-mm-dd',
                //numberOfMonths: 1,
                prevText: "",
                nextText: "",
                monthNames: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
                monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
                dayNames: ["일", "월", "화", "수", "목", "금", "토"],
                dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
                dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
                showMonthAfterYear: true,
                yearSuffix: ".",
            });
    });

    /* mypage 1:1문의 */
    $('.btn-prd-answere').click(function()
    {
        var thisParents = $(this).parents('.prd-qna-item')
        if ($(thisParents).hasClass('active'))
        {
            $(thisParents).find('.prd-answere-box').slideUp();
            $(thisParents).removeClass('active');
        }
        else
        {
            $(thisParents).find('.prd-answere-box').slideDown();
            $(thisParents).addClass('active');
        }
        return false;
    });

    $(document).ready(function()
    {
        var fileTarget = $('.file-upload .upload-hidden');

        fileTarget.on('change', function()
        { // 값이 변경되면
            if (window.FileReader)
            { // modern browser
                var filename = $(this)[0].files[0].name;
            }
            else
            {
                var filename = $(this).val().split('/').pop().split('\\').pop();
            }

            $(this).siblings('.input-text').val(filename);
        });
    });



    //====================================
    // 날짜버튼
    //====================================
    function jsSetDate(idx, date, date_to){
        for(var i=0; i<4; i++){
            if(idx == i){
                document.getElementById("btn"+i).className = "tab-common-mypage-item active";
                document.getElementById("date_to").value = date_to;
                document.getElementById("date_from").value = date;
            }else{
                document.getElementById("btn"+i).className = "tab-common-mypage-item";
            }
            document.getElementById("date_type").value = idx;
        }
    }

    //====================================
    // 조회
    //====================================
    function jsSearch()
    {
        var date_from	= $('#date_from').val(),
            date_to		= $('#date_to').val(),
            date_type	= $('#date_type').val(),
            page		= 1;

        var param = "";
        param += "page="			+ page;
        param += "&date_from="		+ date_from;
        param += "&date_to="		+ date_to;
        param += "&date_type="		+ date_type;

        document.location.href = "/mywiz/comment_page/"+page+"?"+param;
    }

    //====================================
    // 상품평 수정 레이어
    //====================================
    function modify_comment_layer(comment_no){

        $.ajax({
            type: 'GET',
            url: '/mywiz/update_goods_comment',
            dataType: 'json',
            data: { comment_no : comment_no},
            error: function(res) {
                alert('Database Error');
            },
            async : false,
            success: function(res) {
                if(res.status == 'ok'){
                    $("#modify_comment").html(res.modify_comment);

                }
                else alert(res.message);
            }
        });

        $('#layerPrdCommentModify').addClass('common-layer-wrap--view');
    }

    //=====================================
    // 상품평 삭제하기
    //=====================================
    function delete_comment(comment_cd){
        if(confirm("상품평을 삭제하시겠습니까?")){
            $.ajax({
                type: 'POST',
                url: '/mywiz/delete_goods_comment',
                dataType: 'json',
                data: {  comment_cd:comment_cd},
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        alert("삭제되었습니다.");
                        location.reload();
                    }
                    else alert(res.message);
                }
            });
        }
    }

</script>