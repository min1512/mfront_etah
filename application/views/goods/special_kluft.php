<?php
/**
 * Created by PhpStorm.
 * User: YIC-007
 * Date: 2019-11-12
 * Time: 오전 11:34
 */
?>

<link rel="stylesheet" href="/assets/css/display.css">

<div class="content">
    <!--    <p class="event-data">행사기간 : 2019-11-29 ~ 2019-12-31</p>-->
    <div class="event_visual">
        <div class="evt_contents1">
            <img src="/assets/images/data/m_kluft_reservation_1.png" alt="" />
        </div>
        <div class="evt_contents2">
            <ul class="event_link list1">
                <li><a href="/goods/detail/1932251"><img src="/assets/images/data/bancroft.png"><p class="direct">상품보기</p></a></li>
                <li><a href="/goods/detail/1932253"><img src="/assets/images/data/preston.png"><p class="direct">상품보기</p></a></li>
                <li><a href="/goods/detail/1932255"><img src="/assets/images/data/victory.png"><p class="direct">상품보기</p></a></li>
            </ul>
        </div>
        <div class="evt_contents3">
            <img src="/assets/images/data/m_kluft_reservation_3.png" alt="" />
        </div>
        <div class="evt_contents4">
            <ul class="event_link list2">
                <li><a href="/goods/detail/1932243"><img src="/assets/images/data/green_point.png"><p class="direct">상품보기</p></a></li>
                <li><a href="/goods/detail/1932245"><img src="/assets/images/data/chelsea.png"><p class="direct">상품보기</p></a></li>
                <li><a href="/goods/detail/1932247"><img src="/assets/images/data/sutton.png"><p class="direct">상품보기</p></a></li>
                <li><a href="/goods/detail/1932249"><img src="/assets/images/data/prospect.png"><p class="direct">상품보기</p></a></li>
            </ul>
        </div>
        <div class="evt_contents5">
            <img src="/assets/images/data/m_kluft_reservation_5.png" alt="" />
        </div>
        <div class="evt_contents6">
            <ul class="event_link list3">
                <li><a href="/goods/detail/1932262"><img src="/assets/images/data/talay_latex_pillow.png"><p class="direct">상품보기</p></a></li>
            </ul>
        </div>
        <div class="evt_contents7">
            <img src="/assets/images/data/m_kluft_reservation_page_MO.jpg" alt="" />
        </div>

<!--        <a href="javascript://" onClick="javascript:jsReservationLayer()" class="btn-vip-write" data-layer="bottom-layer-open2"><img src="/assets/images/data/btn_kluft_m.png" alt="" /></a>-->
        <div onClick="javascript:jsReservationLayer()" style="cursor:pointer;"><img src="/assets/images/data/btn_kluft_m.png" alt="" /></div>
    </div>
</div>

<div class="RESERVATION_LAYER" id="reservation_layer"></div>

<script>
    //====================================
    // 방문예약 레이어 생성
    //====================================
    function jsReservationLayer(){
        $.ajax({
            type: 'POST',
            url: '/goods/reservation_layer',
            dataType: 'json',
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    $("#reservation_layer").prepend(res.reservation_layer);
                }
                else alert(res.message);
            }
        });
    }
</script>
