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
    <link rel="stylesheet" href="/assets/css/system.css">
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

    <div class="main-contents customer <?if($reserve['RESERVATION_STS_CD']=='05'){?>cancel<?}?>" id="">
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
                <p class="item-top-brand"><a href="#">[클러프트]</a></p>
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

    <div class="contents-info customer <?if($reserve['RESERVATION_STS_CD']=='05'){?>cancel<?}?>" id="">
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
                                <td><?=$reserve['MOB_NO']?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li>
                    <div class="list-head">
                        <p>오시는길 / 판매자 연락처</p>

                    </div>
                    <div class="list-body map">

                        <!-- 카카오지도 삽입 영역 -->
                        <div style="font:normal normal 400 12px/normal dotum, sans-serif; width:100%; height:auto; color:#333; position:relative">
                            <div style="height: auto;">
                                <div id="map" style="border:1px solid #ccc;width:auto;height:200px;position: relative;"></div>
                            </div>
                            <div style="overflow: hidden; padding: 7px 11px; border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 0px 0px 2px 2px; background-color: rgb(249, 249, 249);">
                                <a href="https://map.kakao.com" target="_blank" style="float: left;">
                                    <img src="//t1.daumcdn.net/localimg/localimages/07/2018/pc/common/logo_kakaomap.png" width="72" height="16" alt="카카오맵" style="display:block;width:72px;height:16px">
                                </a>
                                <div style="float: right; position: relative; top: 1px; font-size: 11px;">
                                    <a id="path" target="_blank" href="#" style="float:left;height:15px;padding-top:1px;line-height:15px;color:#000;text-decoration: none;">길찾기</a>
                                </div>
                            </div>
                        </div>
                        <!-- //카카오지도 삽입 영역 -->
                        <div class="seller-info">
                            <p class="name">클러프트</p>
                            <p class="address">서울 강남구 논현동 57-18</p>
                            <p class="tel">전화번호 : <a href="tel:02-542-0225"><i>02-542-0225</i></a></p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="list-head">
                        <p>시간 / 이용상태</p>
                    </div>
                    <div class="list-body booking"><!-- //'시간 확정하기' 버튼 클릭 시 complete 활성화 -->
                        <!-- <div class="list-body booking complete"> -->
                        <p class="incomplete">*클러프트에서 연락이 갈거예요! 조금만 기다려주세요~</p>
                        <p class="completed">*예약이 확정되었습니다.</p>
                        <p class="finish">*방문이 완료되었습니다.</p>
                        <p class="cancel">*예약이 취소되었습니다.</p>
                        <div class="set-time">
                            <div class="set-t start">
                                <div class="date-picker-button input-group">
                                    <label for="date01-1"><?=date("m월 d일", strtotime($reserve['VISIT_START_DT']))?></label>
                                    <input class="input-startdate date-picker-input hasDatepicker" id="date01-1" name="date01" required="" type="date" value="<?=date('Y-m-d', strtotime($reserve['VISIT_START_DT']))?>">
                                </div>
                                <div class="date-picker-button input-group">
                                    <label for="time01-1"><?=date("G시 i분", strtotime($reserve['VISIT_START_DT']))?></label>
                                    <input class="input-startdate date-picker-input hasDatepicker" id="time01-1" name="time01" required="" type="time" value="<?=$sTime?>">
                                </div>
                                <span class="date-txt">부터</span>
                            </div>

                            <div class="set-t end">
                                <div class="date-picker-button input-group">
                                    <label for="date01-2"><?=date("m월 d일", strtotime($reserve['VISIT_END_DT']))?></label>
                                    <input class="input-startdate date-picker-input hasDatepicker" id="date01-2" name="date01" required="" type="date" value="<?=date('Y-m-d', strtotime($reserve['VISIT_END_DT']))?>">
                                </div>
                                <div class="date-picker-button input-group">
                                    <label for="time01-2"><?=date("G시 i분", strtotime($reserve['VISIT_END_DT']))?></label>
                                    <input class="input-startdate date-picker-input hasDatepicker" id="time01-2" name="time01" required="" type="time" value="<?=$eTime?>">
                                </div>
                                <span class="date-txt">까지</span>
                            </div>
                        </div>
                        <a href="javaScript://" class="btn cancel" onclick="jsCancel()">예약 취소</a>
                        <a href="#" class="btn time-set">예약 확정하기</a>
                        <a href="#" class="btn finished-class disabled">방문 완료</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    //===============================================================
    // 고객 - 예약취소
    //===============================================================
    function jsCancel() {
        if(!confirm("예약을 취소하시겠습니까?")){
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/visit/reservation_cancel',
            dataType: 'json',
            data: {
                'reserve_cd' : <?=$reserve['RESERVATION_NO']?>
            },
            error:	function(res)	{
                alert( 'Database Error' );
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert("취소되었습니다.");
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
        //accordion menu
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
        if ( $(".state li").eq(1).hasClass("active") ) {
            booking.addClass("complete");
        } else if ( $(".state li").eq(2).hasClass("active") ) {
            booking.addClass("complete");
        } else if ( $(".state li").eq(3).hasClass("active") ) {
            booking.addClass("complete");
            booking.addClass("finished");
            txtCompleted.css("display", "none");
            txtFinish.css("display", "block");
        }
    });
</script>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a05f67602dc7a0ac2ef1a72c27e5f706&libraries=services"></script>
<script>
    //===============================================================
    // 다음지도 API
    //===============================================================
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
            level: 3 // 지도의 확대 레벨
            //draggable: false
        };

    // 지도를 생성합니다
    var map = new kakao.maps.Map(mapContainer, mapOption);

    // 주소-좌표 변환 객체를 생성합니다
    var geocoder = new kakao.maps.services.Geocoder();

    // 주소로 좌표를 검색합니다
    geocoder.addressSearch('서울 강남구 논현동 57-18', function(result, status) {

        // 정상적으로 검색이 완료됐으면
        if (status === kakao.maps.services.Status.OK) {

            var coords = new kakao.maps.LatLng(result[0].y, result[0].x);
            x = result[0].y;
            y = result[0].x;

            // 마커가 표시될 위치입니다
            var markerPosition  = coords;

            // 마커를 생성합니다
            var marker = new kakao.maps.Marker({
                position: markerPosition
            });

            // 마커가 지도 위에 표시되도록 설정합니다
            marker.setMap(map);

            var iwContent = '<div style="width:280px;margin-left:17%;padding:6px 0;"><span>클러프트</span></div>',
                iwPosition = coords; //인포윈도우 표시 위치입니다

            // 인포윈도우를 생성합니다
            var infowindow = new kakao.maps.InfoWindow({
                position : iwPosition,
                content : iwContent
            });

            // 마커 위에 인포윈도우를 표시합니다. 두번째 파라미터인 marker를 넣어주지 않으면 지도 위에 표시됩니다
            infowindow.open(map, marker);

            // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
            map.setCenter(coords);

            var path = 'https://map.kakao.com/link/to/클러프트' + ','+ x + ',' + y;

            $("#path").attr("href",path);
        }
    });

</script>
</body>
</html>

