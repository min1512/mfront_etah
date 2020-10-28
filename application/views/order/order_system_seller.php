<!DOCTYPE html>
<html lang="ko-KR">
<head>
    <title>ETAHOME Order System</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta property="og:type" content="website">
    <meta property="og:title" content="ETAHOME">
    <meta property="og:description" content="홈&펫&직구, 국내부터 해외까지 가구/소품/주방 등 홈퍼니싱 전문 온라인샵!">
    <meta property="og:url" content="http://www.etahome.co.kr/">
    <meta name="naver-site-verification" content="54a86b68cc34cc4188be49ba4ad9fcf4dbd1827d">
    <link rel="stylesheet" href="/assets/css/system.css?var=1.0">
    <link rel="shortcut icon" href="http://ui.etah.co.kr/favicon.ico">
    <link rel="apple-touch-icon" href="http://ui.etah.co.kr/favicon.png">
    <link rel="apple-touch-icon" href="http://ui.etah.co.kr/favicon-60.png"><!-- 비 레티나 -->
    <link rel="apple-touch-icon" sizes="76x76" href="http://ui.etah.co.kr/favicon-76.png"><!-- 아이패드 -->
    <link rel="apple-touch-icon" sizes="120x120" href="http://ui.etah.co.kr/favicon-60@2x.png"><!-- 레티나 기기 -->
    <link rel="apple-touch-icon" sizes="152x152" href="http://ui.etah.co.kr/favicon-76@2x.png"><!-- 레티나 패드 -->
    <link rel="apple-touch-icon-precomposed" href="http://ui.etah.co.kr/favicon-60.png"><!-- 구형/ 안드로이드 -->
    <link href="https://fonts.googleapis.com/css?family=Malgun+Gothic|Noto+Sans+KR" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script src="/assets/js/common.js"></script>
</head>
<body>
<div class="system-wrap" id="system-class"> <!-- 카테고리 오픈시 category-open 클래스 추가 -->

    <?
    $arr_cancel_cd = ['OC01','OC02','OC21','OC22'];
    ?>
    <div class="main-contents seller <?if(in_array($order['ORDER_REFER_PROC_STS_CD'], $arr_cancel_cd)){?>cancel<?}?>" id="">
        <div class="state">
            <ul>
                <li class="<?=$order['ORDER_REFER_PROC_STS_CD'] == "OA03" ? "active" : ""?>">결제완료</li>
                <li class="<?=$order['ORDER_REFER_PROC_STS_CD'] == "OB01" ? "active" : ""?>">구매확정</li>
                <li class="<?=$order['ORDER_REFER_PROC_STS_CD'] == "OE01" ? "active" : ""?>">방문</li>
                <li class="<?=$order['ORDER_REFER_PROC_STS_CD'] == "OE02" ? "active" : ""?>">완료</li>
            </ul>
        </div>
        <div class="item-wrap">
            <div class="item-top">
                <p class="item-order-code"><a href="#">주문번호 : <?=$order['ORDER_NO']?></a></p>
                <p class="item-top-brand"><a href="#"><!--보니보니베이킹스튜디오(데쎄르룸)--><?=$order['VENDOR_SUBVENDOR_NM']?></a></p>
                <p class="item-top-title"><a href="#"><!--베이직 마카롱 만들기--><?=$order['GOODS_NM']?></a></p>
            </div>
            <div class="item-main-img" >
                <a href="/goods/detail/<?=$order['GOODS_CD']?>"><img src="<?=$order['IMG_URL']?>" alt=""></a>
            </div>
            <div class="item-order">
                <p class="item-prd-code">상품번호 : <?=$order['GOODS_CD']?> <span class="item-cancel">*주문취소</span></p>
                <table class="type1">
                    <colgroup>
                        <col style="width: 35px;">
                        <col>
                        <col style="width: 90px;">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>옵션</th>
                        <th><span><?=$order['GOODS_OPTION_NM']?> <i>(<?=
                                    number_format($order['SELLING_PRICE'] + $order['SELLING_ADD_PRICE'])
                                    ?> X <?=$order['ORD_QTY']?>)</i></span></th>
                        <td><?=number_format($order['TOTAL_PRICE'])?>원</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="2">합계</th>
                        <td><?=number_format($order['TOTAL_PRICE'])?>원</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="contents-info seller <?if(in_array($order['ORDER_REFER_PROC_STS_CD'], $arr_cancel_cd)){?>cancel<?}?>" id="">
        <div class="contents-info-list fold-type">
            <ul>
                <li>
                    <div class="list-head">
                        <p>구매자 정보</p>
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
                                <td><?=$order['SENDER_NM']?></td>
                            </tr>
                            <tr>
                                <th>연락처</th>
                                <td><a href="tel:<?=$order['RECEIVER_MOB_NO']?>"><i><?=$order['RECEIVER_MOB_NO']?></i></a></td>
                            </tr>
                            <tr>
                                <th>이메일</th>
                                <td><?=$order['SENDER_EMAIL']?></td>
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
                        <div style="font:normal normal 400 12px/normal dotum, sans-serif; width:100%; height:238px; color:#333; position:relative">

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
                            <p class="name"><?=$order['VENDOR_SUBVENDOR_NM']?></p>
                            <p class="address"><!--서울 강남구 도곡동 543-7 , 도곡1차 I PARK 상가동 105호--><?=$order['VENDOR_SUBVENDOR_ADDR']?></p>
                            <p class="tel">전화번호 : <a href="tel:<?=$order['VENDOR_SUBVENDOR_TEL']?>"><i><!--010- 5005-6190--><?=$order['VENDOR_SUBVENDOR_TEL']?></i></a></p>
                            <p class="kakao">카카오톡 ID : <a href="http://plus.kakao.com/home/@에타" target="_blank"><i>etahcompany</i></a></p>
                        </div>
                    </div>
                </li>
                <!-- <li>
                    <div class="list-head">
                        <p>이용확인</p>
                    </div>
                    <div class="list-body complete">
                        <button type="button" class="btn compl"> 비활성화 : disabled 클래스 추가
                            이용완료
                            <small class="before">(완료시 버튼을 클릭해주세요)</small>
                            <small class="after">(이용이 완료되었습니다)</small>
                        </button>
                    </div>
                </li> -->
                <li>
                    <div class="list-head">
                        <p>시간 / 이용상태</p>
                    </div>
                    <div class="list-body booking"><!-- //'시간 확정하기' 버튼 클릭 시 complete 활성화 -->
                        <!-- <div class="list-body booking complete"> -->
                        <p class="incomplete">*고객에게 연락해 시간을 협의해주세요!</p>
                        <p class="completed">*시간이 확정되었습니다^^</p>
                        <p class="finish">*이용이 완료되었습니다^^ 수고하셨습니다!</p>
                        <p class="cancel">*주문이 취소되었습니다.</p>
                        <div class="set-time">
                            <?
                            if(!isset($order['CLASS_START_DT'])) {
                                $order['CLASS_START_DT' ] = date("Y-m-d H:i:")."00";
                                $order['CLASS_END_DT'   ] = date("Y-m-d H:i:")."00";
                            }
                            ?>
                            <div class="set-t start">
                                <div class="date-picker-button input-group">
                                    <label for="date01-1"><?=date("m월 d일", strtotime($order['CLASS_START_DT']))?></label>
                                    <input class="input-startdate date-picker-input hasDatepicker" id="date01-1" name="date01" required="" type="date" value="<?=date('Y-m-d', strtotime($order['CLASS_START_DT']))?>">
                                </div>
                                <div class="date-picker-button input-group">
                                    <label for="time01-1"><?=date("G시 i분", strtotime($order['CLASS_START_DT']))?></label>
                                    <input class="input-startdate date-picker-input hasDatepicker" id="time01-1" name="time01" required="" type="time" value="<?=date('H:i:', strtotime($order['CLASS_START_DT']))."00"?>">
                                </div>
                                <span class="date-txt">부터</span>
                            </div>

                            <div class="set-t end">
                                <div class="date-picker-button input-group">
                                    <label for="date01-2"><?=date("m월 d일", strtotime($order['CLASS_END_DT']))?></label>
                                    <input class="input-startdate date-picker-input hasDatepicker" id="date01-2" name="date01" required="" type="date" value="<?=date('Y-m-d', strtotime($order['CLASS_END_DT']))?>">
                                </div>
                                <div class="date-picker-button input-group">
                                    <label for="time01-2"><?=date("G시 i분", strtotime($order['CLASS_END_DT']))?></label>
                                    <input class="input-startdate date-picker-input hasDatepicker" id="time01-2" name="time01" required="" type="time" value="<?=date('H:i:', strtotime($order['CLASS_END_DT']))."00"?>">
                                </div>
                                <span class="date-txt">까지</span>
                            </div>
                        </div>
<!--                        --><?//if($order['ORDER_REFER_PROC_STS_CD'] != 'OA03'){
//                            $start_date = explode(' ',$order['CLASS_START_DT']);
//                            $timestamp  = strtotime($start_date[0]);
//                            $timestamp2 = strtotime($start_date[1]);
//                            $sm = date('m',$timestamp);
//                            $sd = date('d',$timestamp);
//                            $sh = date('H',$timestamp2);
//                            $si = date('i',$timestamp2);
//
//                            $end_date = explode(' ',$order['CLASS_END_DT']);
//                            $timestamp  = strtotime($end_date[0]);
//                            $timestamp2 = strtotime($end_date[1]);
//                            $em = date('m',$timestamp);
//                            $ed = date('d',$timestamp);
//                            $eh = date('H',$timestamp2);
//                            $ei = date('i',$timestamp2);?>
<!--                            <div class="set-time">-->
<!--                                <div class="set-t start">-->
<!--                                    <div class="date-picker-button input-group">-->
<!--                                        <label for="date01-1">--><?//=$sm?><!--월 --><?//=$sd?><!--일</label>-->
<!--                                        <input class="input-startdate date-picker-input hasDatepicker" id="date01-1" name="date01" required="" type="date" value="--><?//=$start_date[0]?><!--">-->
<!--                                    </div>-->
<!--                                    <div class="date-picker-button input-group">-->
<!--                                        <label for="time01-1">--><?//=$sh?><!--시 --><?//=$si?><!--분</label>-->
<!--                                        <input class="input-startdate date-picker-input hasDatepicker" id="time01-1" name="time01" required="" type="time" value="00:00">-->
<!--                                    </div>-->
<!--                                    <span class="date-txt">부터</span>-->
<!--                                </div>-->
<!---->
<!--                                <div class="set-t end">-->
<!--                                    <div class="date-picker-button input-group">-->
<!--                                        <label for="date01-2">--><?//=$em?><!--월 --><?//=$ed?><!--일</label>-->
<!--                                        <input class="input-startdate date-picker-input hasDatepicker" id="date01-2" name="date01" required="" type="date" value="--><?//=$end_date[0]?><!--">-->
<!--                                    </div>-->
<!--                                    <div class="date-picker-button input-group">-->
<!--                                        <label for="time01-2">--><?//=$eh?><!--시 --><?//=$ei?><!--분</label>-->
<!--                                        <input class="input-startdate date-picker-input hasDatepicker" id="time01-2" name="time01" required="" type="time" value="00:00">-->
<!--                                    </div>-->
<!--                                    <span class="date-txt">까지</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        --><?//}else{?>
<!--                            <div class="set-time">-->
<!--                                <div class="set-t start">-->
<!--                                    <div class="date-picker-button input-group">-->
<!--                                        <label for="date01-1">--><?//=date('m')?><!--월 --><?//=date('d')?><!--일</label>-->
<!--                                        <input class="input-startdate date-picker-input hasDatepicker" id="date01-1" name="date01" required="" type="date" value="--><?//=date('Y-m-d')?><!--">-->
<!--                                    </div>-->
<!--                                    <div class="date-picker-button input-group">-->
<!--                                        <label for="time01-1">--시 --분</label>-->
<!--                                        <input class="input-startdate date-picker-input hasDatepicker" id="time01-1" name="time01" required="" type="time" value="00:00">-->
<!--                                    </div>-->
<!--                                    <span class="date-txt">부터</span>-->
<!--                                </div>-->
<!---->
<!--                                <div class="set-t end">-->
<!--                                    <div class="date-picker-button input-group">-->
<!--                                        <label for="date01-2">--><?//=date('m')?><!--월 --><?//=date('d')?><!--일</label>-->
<!--                                        <input class="input-startdate date-picker-input hasDatepicker" id="date01-2" name="date01" required="" type="date" value="--><?//=date('Y-m-d')?><!--">-->
<!--                                    </div>-->
<!--                                    <div class="date-picker-button input-group">-->
<!--                                        <label for="time01-2">--시 --분</label>-->
<!--                                        <input class="input-startdate date-picker-input hasDatepicker" id="time01-2" name="time01" required="" type="time" value="00:00">-->
<!--                                    </div>-->
<!--                                    <span class="date-txt">까지</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        --><?//}?>
                        <div class="time-set-wrap" style="display: flex">
                            <a href="javascript:studyCheck();" class="btn time-set"></a>
                            <a href="javaScript:studyMod()" class="btn time-change" style="flex-basis:40%;margin-top: 10px;display: none;">예약시간 수정</a>
                            <a href="javascript:studyFinish();" class="btn finished-class">수업 완료 확인</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</div>

<script src="/assets/js2/jquery.cookie.js"></script>
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
        var booking = $(".list-body.booking");                                          // 예약 바
        var txtCompleted = $(".list-body.booking .completed");                          // 비활성화 된 예약바 ( 시간확정 )
        var txtFinish = $(".list-body.booking .finish");                                // 상품 판매 완료 후 -> display:none

        var btnSetTime = $(".list-body.booking .btn.time-set");                         // 시간확정
        var btnFinished = $(".list-body.booking .btn.finished-class");                  // 판매확정
        var btnModTime = $(".list-body.booking .time-change");                      // 시간수정


        if ( $(".state li").eq(1).hasClass("active") ) {
            //OB01 구매확정
            booking.addClass("complete");

            btnModTime.css("display", "block");
            btnModTime.css('background-color', '#ffc000');
            btnSetTime.css('flex-basis', '60%');
            btnModTime.css('pointer-events', 'auto');
        } else if ( $(".state li").eq(2).hasClass("active") ) {
            //OE01 방문
            booking.addClass("complete");

            btnSetTime.css("display", "none");
            btnModTime.css("display", "none");
            btnFinished.css("display", "block");
        } else if ( $(".state li").eq(3).hasClass("active") ) {
            //OE02 완료
            booking.addClass("complete");

            txtCompleted.css("display", "none");
            txtFinish.css("display", "block");
            btnSetTime.css("display", "none");
            btnModTime.css("display", "none");
            btnFinished.css("display", "block").addClass("disabled");
        }
    });

    function studyCheck()
    {
        var date1 = $("#date01-1").val();
        var time1 = $("#time01-1").val();
        var date2 = $("#date01-2").val();
        var time2 = $("#time01-2").val();


        if(!confirm('시간을 확정하시겠습니까?')){
            return false;
        }

        //time checker
        if(!timeCheck( date1 + ' ' + time1, date2 + ' ' + time2 )) {
            return false;
        }

        var param = {
            "order_no"                  : <?=$order['ORDER_REFER_NO']?>,
            "order_refer_proc_sts_cd"   : '<?=$order['ORDER_REFER_PROC_STS_CD']?>',
            "start_date"                : date1,
            "start_time"                : time1,
            "end_date"                  : date2,
            "end_time"                  : time2
        };

        $.ajax({
            type: 'POST',
            url: '/order/order_time_fixed',
            dataType: 'json',
            data: param,
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert(res.message);
                    console.log(res.message);
                    location.reload();
                } else if ( res.status == 'reload') {
                    location.reload();
                }

            }
        });
    }


    function timeCheck (date1, date2) {
        var now = new Date().getTime();
        var time1 = new Date(date1).getTime();
        var time2 = new Date(date2).getTime();

        /*console.log(new Date().format('yyyy-MM-dd HH:mm:ss'));
        console.log(new Date(date1).format('yyyy-MM-dd HH:mm:ss'));
        console.log(new Date(date2).format('yyyy-MM-dd HH:mm:ss'));*/

        if(time1 > time2){
            alert('시작시간을 다시 설정해주세요!');
        }else if(now > time2){
            alert('종료시간을 다시 설정해주세요!');
        }else if(now > time1){
            alert('시작시간을 다시 설정해주세요!');
        } else {
            return true;
        }
        return false;
    }



    function studyMod() {
        //Status changes based on the booking process
        var btnSetTime = $(".list-body.booking .btn.time-set");
        var btnModTime = $(".time-set-wrap .time-change");
        var btnWrapper = $('.contents-info .time-set-wrap');
        var btnInputDate = $('.set-time .input-startdate.date-picker-input');
        var timeLabel = $(".set-time .date-picker-button label");

        btnModTime.css('cursor', 'default');
        btnModTime.css('background-color', '#eee');
        btnSetTime.css('pointer-events', 'auto');
        btnSetTime.css('background-color', '#ffc000');
        btnInputDate.css('pointer-events', 'auto');
        timeLabel.css('color', '#000');
        btnWrapper.addClass('change');
    }

    function studyFinish()
    {

        if(!confirm('완료하시겠습니까?')){
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/order/order_class_finished',
            dataType: 'json',
            data: {'order_no' : <?=$order['ORDER_REFER_NO']?>},
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert(res.message);
                    console.log(res.message);
                    location.reload();
                }
                else alert(res.message);
            }
        });
    }
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
    geocoder.addressSearch('<?=$order['VENDOR_SUBVENDOR_ADDR']?>', function(result, status) {

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

            var iwContent = '<div style="width:280px;margin-left:17%;padding:6px 0;"><span><?=$order['VENDOR_SUBVENDOR_NM']?></span></div>',
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


            var path = 'https://map.kakao.com/link/to/'+'<?=$order['VENDOR_SUBVENDOR_NM']?>' + ','+ x + ',' + y;

//            alert(path);
//            https://map.kakao.com/link/to/Hello World!,33.450701,126.570667
            $("#path").attr("href",path);
        }
    });

</script>
</body>
</html>