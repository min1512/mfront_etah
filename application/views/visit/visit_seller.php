<?php
/**
 * Created by PhpStorm.
 * User: YIC-007
 * Date: 2019-11-06
 * Time: 오후 5:41
 */
?>


<!DOCTYPE html>
<html lang="ko-KR">
<head>
    <title>ETAH Visit System</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta property="og:type" content="website">
    <meta property="og:title" content="ETAH">
    <meta property="og:description" content="EveryThing About Home 홈&amp;라이프&amp;펫 2000여개 프리미엄 브랜드 편집샵! 집을 사랑하는 사람들이 집을 사랑하는 사람들을 위해 한땀한땀 만든 곳 집에 관한 모든것, 에타(Etah) , 일본직구, 집꾸미기 , DIY, 가구, 욕실, 주방, 가드닝, 반려동물">
    <meta property="og:url" content="http://www.etah.co.kr/">
    <meta name="naver-site-verification" content="54a86b68cc34cc4188be49ba4ad9fcf4dbd1827d">
    <link rel="stylesheet" href="/assets/css/system.css?ver=1.1">
    <link rel="shortcut icon" href="http://ui.etah.co.kr/favicon.ico">
    <link rel="apple-touch-icon" href="http://ui.etah.co.kr/favicon.png">
    <link rel="apple-touch-icon" href="http://ui.etah.co.kr/favicon-60.png"><!-- 비 레티나 -->
    <link rel="apple-touch-icon" sizes="76x76" href="http://ui.etah.co.kr/favicon-76.png"><!-- 아이패드 -->
    <link rel="apple-touch-icon" sizes="120x120" href="http://ui.etah.co.kr/favicon-60@2x.png"><!-- 레티나 기기 -->
    <link rel="apple-touch-icon" sizes="152x152" href="http://ui.etah.co.kr/favicon-76@2x.png"><!-- 레티나 패드 -->
    <link rel="apple-touch-icon-precomposed" href="http://ui.etah.co.kr/favicon-60.png"><!-- 구형/ 안드로이드 -->
    <link href="https://fonts.googleapis.com/css?family=Malgun+Gothic|Noto+Sans+KR" rel="stylesheet">
    <script src="/assets/js/common.js"></script>
</head>
<body>
<div class="system-wrap" id="system-visit"> <!-- 카테고리 오픈시 category-open 클래스 추가 -->

    <div class="main-contents seller <?if($reserve['RESERVATION_STS_CD']=='05'){?>cancel<?}?>" id="">
        <div class="state">
            <ul>
                <li <?if($reserve['RESERVATION_STS_CD']=='01'){?>class="active"<?}?>>예약완료</li>
                <li <?if($reserve['RESERVATION_STS_CD']=='02'){?>class="active"<?}?>>예약확정</li>
                <li <?if($reserve['RESERVATION_STS_CD']=='03'){?>class="active"<?}?>>방문</li>
                <li <?if($reserve['RESERVATION_STS_CD']=='04'){?>class="active"<?}?>>완료</li>
            </ul>
        </div>
        <div class="item-wrap">
            <div class="item-top">
                <p class="item-order-code"><a href="#">예약번호 : <?=$reserve['RESERVATION_NO']?></a></p>
                <p class="item-top-brand"><a href="#">[클러프트] </a></p>
                <p class="item-top-title"><a href="#">클러프트 매장 방문 예약</a></p>
            </div>
            <div class="item-main-img">
                <img src="<?=($reserve['IMG_URL']=='')?"/assets/images/data/kluft_logo.jpg":$reserve['IMG_URL']?>" alt="">
            </div>
            <div class="item-order">
                <p class="item-prd-code">예약상품번호 : <?=$reserve['RESERVATION_NO']?> <span class="item-cancel">*예약취소</span></p>
                <?
                $yoil = array("일","월","화","수","목","금","토");
                $date_time = date("m월 d일", strtotime($reserve['VISIT_START_DT']))."(".$yoil[date('w', strtotime($reserve['VISIT_START_DT']))].")";
                ?>
                <p class="item-date-time"><?=$date_time?> <?=$sTime?>~<?=$eTime?></p>
            </div>
        </div>
    </div>

    <form id="frmList" name="frmList">
        <input type="hidden" name="reserve_no" value="<?=$reserve['RESERVATION_NO']?>">
        <div class="contents-info seller <?if($reserve['RESERVATION_STS_CD']=='05'){?>cancel<?}?>" id="">
            <div class="contents-info-list fold-type">
                <ul>
                    <li>
                        <div class="list-head">
                            <p>예약자 정보</p>
                        </div>
                        <div class="list-body reservator">
                            <table class="type1">
                                <colgroup>
                                    <col style="width: 45px;">
                                    <col>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th>예약자</th>
                                    <td><?=$reserve['CUST_NM']?></td>
                                </tr>
                                <tr>
                                    <th>연락처</th>
                                    <td><a href="tel:<?=$reserve['MOB_NO']?>"><i><?=$reserve['MOB_NO']?></i></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </li>
                    <li>
                        <div class="list-head">
                            <p>시간 / 이용상태</p>
                        </div>
                        <div class="list-body booking"><!-- //'시간 확정하기' 버튼 클릭 시 complete 활성화 -->
                            <!-- <div class="list-body booking complete"> -->
                            <p class="incomplete">*고객에게 연락해 시간을 확정해주세요!</p>
                            <p class="completed">*예약이 확정되었습니다.</p>
                            <p class="finish">*방문이 완료되었습니다.</p>
                            <p class="cancel">*예약이 취소되었습니다.</p>
                            <div class="set-time">
                                <div class="set-t start">
                                    <div class="date-picker-button input-group">
                                        <label for="date01-1" name="sdate"><?=date("m월 d일", strtotime($reserve['VISIT_START_DT']))?></label>
                                        <input class="input-startdate date-picker-input hasDatepicker" id="date01-1" name="sdate" required="" type="date" value="<?=date('Y-m-d', strtotime($reserve['VISIT_START_DT']))?>">
                                    </div>
                                    <div class="date-picker-button input-group">
                                        <label for="time01-1"><?=date("G시 i분", strtotime($reserve['VISIT_START_DT']))?></label>
                                        <input class="input-startdate date-picker-input hasDatepicker" id="time01-1" name="stime" required="" type="time" value="<?=$sTime?>">
                                    </div>
                                    <span class="date-txt">부터</span>
                                </div>

                                <div class="set-t end">
                                    <div class="date-picker-button input-group">
                                        <label for="date01-2"><?=date("m월 d일", strtotime($reserve['VISIT_END_DT']))?></label>
                                        <input class="input-startdate date-picker-input hasDatepicker" id="date01-2" name="edate" required="" type="date" value="<?=date('Y-m-d', strtotime($reserve['VISIT_END_DT']))?>">
                                    </div>
                                    <div class="date-picker-button input-group">
                                        <label for="time01-2"><?=date("G시 i분", strtotime($reserve['VISIT_END_DT']))?></label>
                                        <input class="input-startdate date-picker-input hasDatepicker" id="time01-2" name="etime" required="" type="time" value="<?=$eTime?>">
                                    </div>
                                    <span class="date-txt">까지</span>
                                </div>
                            </div>
                            <a href="javaScript://" class="btn time-set" onclick="javaScript:jsConfirm()">예약 확정하기</a>
                            <a href="javaScript://" class="btn finished-class" onclick="javaScript:jsComplete()">방문 완료 확인</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </form>
</div>

<script>
    //===============================================================
    // 판매자 - 예약확정
    //===============================================================
    function jsConfirm(){
        var sdate = $("#date01-1").val();
        var stime = $("#time01-1").val();

        var edate = $("#date01-2").val();
        var etime = $("#time01-2").val();

        if(sdate > edate) {
            alert("날짜를 다시 확인해주세요.");
            return false;
        }
        if(stime > etime) {
            alert("시간을 다시 확인해주세요.");
            return false;
        }

        if(!confirm("예약 확정하시겠습니까?")){
            return false;
        }

        var data		= $('#frmList').serialize();

        $.ajax({
            type: 'POST',
            url: '/visit/reservation_confirm',
            dataType: 'json',
            data: data,
            error:	function(res)	{
                alert( 'Database Error' );
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert("예약 확정되었습니다.");
                    location.reload();
                } else{
                    alert(res.message);
                }
            }
        });
    }

    //===============================================================
    // 판매자 - 방문완료
    //===============================================================
    function jsComplete(){
        if(!confirm("방문 완료하시겠습니까?")){
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/visit/reservation_complete',
            dataType: 'json',
            data: {
                'reserve_cd' : <?=$reserve['RESERVATION_NO']?>
            },
            error:	function(res)	{
                alert( 'Database Error' );
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert("방문 완료되었습니다.");
                    location.reload();
                } else{
                    alert(res.message);
                }
            }
        });
    }
</script>

<script src="http://stagingm.etah.co.kr/assets/js2/jquery.cookie.js"></script>
<script type="text/javascript">
    $(function(){
        //accordion 메뉴
        $(".list-body").hide();
        $(".list-head").click(function(){
            $(".list-body").slideUp();
            $(".list-head").removeClass("active");
            var listBody = $(this).next(".list-body");
            if ( listBody.is(":visible") ) {
                listBody.slideUp();
                $(this).removeClass("active");
            } else {
                $(this).next(".list-body:hidden").slideDown();
                $(this).addClass("active");
            }
            return false;
        });

        //inputbox - set-time
        var select = $(".set-time input");
        select.change(function(){
            var select_name = $(this).val();
            $(this).siblings("label").text(select_name);
        });

        //Status changes based on the booking process
        var booking = $(".list-body.booking");
        var txtCompleted = $(".list-body.booking .completed");
        var txtFinish = $(".list-body.booking .finish");
        var btnSetTime = $(".list-body.booking .btn.time-set");
        var btnFinished = $(".list-body.booking .btn.finished-class");
        if ( $(".state li").eq(1).hasClass("active") ) {
            booking.addClass("complete");
        } else if ( $(".state li").eq(2).hasClass("active") ) {
            booking.addClass("complete");
            btnSetTime.css("display", "none");
            btnFinished.css("display", "block");
        } else if ( $(".state li").eq(3).hasClass("active") ) {
            booking.addClass("complete");
            txtCompleted.css("display", "none");
            txtFinish.css("display", "block");
            btnSetTime.css("display", "none");
            btnFinished.css("display", "block").addClass("disabled");
        }
    });
</script>
</body>
</html>

