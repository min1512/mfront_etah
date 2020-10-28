<?
if($event['PLAN_EVENT_CD'] == '66' && $this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'TMP_GUEST'){
redirect('/goods/event/77');
}
?>
<link rel="stylesheet" href="/assets/css/display.css?var=1.2.1">
<link href="https://fonts.googleapis.com/css?family=Nanum+Gothic|Noto+Sans+KR|Nanum+Myeongjo|Noto+Serif+KR|Gothic+A1|Nanum+Gothic+Coding|Do+Hyeon|Jua" rel="stylesheet">
<div class="content">
	<div class="event-img">
	<?if($event['PLAN_EVENT_CD'] == '66'){?>
		<a href="https://<?=$_SERVER['HTTP_HOST']?>/member/login"><img src="<?=$event['EVENT_IMG_URL']?>" alt=""></a>
	<?}else if($event['PLAN_EVENT_CD'] == '77'){?>
		<a href="#goods0" onClick="javaScript:clickEvent('<?=$cidx?>');"><img src="<?=$event['EVENT_IMG_URL']?>" alt=""></a>
	<?}else{?>
        <a href="#"><img src="<?=$event['EVENT_IMG_URL']?>" alt=""></a>
        <?if(!empty($banner)){?>
        <div class="main-banner-title<?=$banner['BANNER_LOCATION']?>">
            <div class="main-banner-inner">
                <p class="p01" style="font-family: <?=$banner['BANNER_FONT_CLASS_GB_CD1']?>; color: <?=$banner['BANNER_FONTCOLOR_CLASS_GB_CD1']?>;
                        font-weight:<?=$banner['BANNER_FONTWEIGHT_CLASS_GB_CD1']?>; font-size: <?=$banner['BANNER_FONT_SIZE1']?>px;"><?=$banner['BANNER_MAIN_TITLE']?></p>
                <p class="p02" style="font-family: <?=$banner['BANNER_FONT_CLASS_GB_CD2']?>; color: <?=$banner['BANNER_FONTCOLOR_CLASS_GB_CD2']?>;
                        font-weight:<?=$banner['BANNER_FONTWEIGHT_CLASS_GB_CD2']?>; font-size: <?=$banner['BANNER_FONT_SIZE2']?>px;"><?=$banner['BANNER_SUB_TITLE']?></p>
                <p class="p03" style="font-family: <?=$banner['BANNER_FONT_CLASS_GB_CD3']?>; color: <?=$banner['BANNER_FONTCOLOR_CLASS_GB_CD3']?>;
                        font-weight:<?=$banner['BANNER_FONTWEIGHT_CLASS_GB_CD3']?>; font-size: <?=$banner['BANNER_FONT_SIZE3']?>px;"><?=$banner['BANNER_SUB_TITLE_2']?></p>
            </div>
        </div>
	<?}}?>
	</div>
	<!--
	2018.02.21 행사기간 제거.
	<p class="event-data">행사기간 : <?/*=$event['START_TIME']*/?> ~ <?/*=$event['END_TIME']*/?></p>-->
	<!-- 쿠폰있을 경우  (기획전에 쿠폰코드를 추가해야함!)// -->
	<? if($event['EVENT_COUPON_CD']){	?>
	<div class="event-coupon">
		<h4 class="event-coupon-title"><?=$event['EVENT_COUPON_NM']?></h4>
		<div class="event-coupon-img"><img src="<?=$event['EVENT_COUPON_IMG']?>" alt=""></div>
		<ul class="common-btn-box">
			<li class="common-btn-item"><a href="javascript://" onClick="javascript:jsGetCoupon(<?=$event['EVENT_COUPON_CD']?>);" class="btn-gray btn-gray--big">쿠폰받기</a></li>
		</ul>
	</div>
	<? if($event['ISSUE_COUPON_DESC'] != ''){	?>
	<div class="event-notice">
		<h4 class="event-notice-title"><span class="ico-i">i</span>쿠폰 사용 시 유의사항</h4>
		<ul class="text-list">
		<?
			$coupon_text = explode('<br>',$event['ISSUE_COUPON_DESC']);

			foreach($coupon_text as $row){
		?>
			<li class="text-item"><?=trim($row)?></li>
		<!--	<li class="text-item">본 이벤트는 당사 사정에 따라 변경 및 종료될 수 있습니다.</li>	-->
		<?
			}
		?>
		</ul>
	</div>
	<?} else {?>
	<div class="event-notice">
		<h4 class="event-notice-title"><span class="ico-i">i</span>쿠폰 사용 시 유의사항</h4>
		<ul class="text-list">
			<li class="text-item">타 할인쿠폰과 중복적용 불가능합니다.</li>
			<li class="text-item">본 이벤트는 당사 사정에 따라 변경 및 종료될 수 있습니다.</li>
		</ul>
	</div>
	<? }?>
	<? }?>
	<!-- // 쿠폰있을 경우 -->
	<ul class="tab-category">
		<?
			$cidx=0;
			$cate_name = "";
			foreach($goods as $crow){
				if($crow['NAME'] != $cate_name){	?>
		<li class="tab-category-item">
			<a href="#goods<?=$cidx?>" id="cate<?=$cidx?>" class="tab-category-link" onClick="javaScript:clickEvent('<?=$cidx?>');">
				<?=$crow['NAME']?>
			</a>
		</li>
                    <!--<li id="cate<?/*=$cidx*/?>" class="tab-category-item" <?/*=$cidx == 0 ? "class='active'" : ""*/?>>
                        <a  href="#goods<?/*=$cidx*/?>" class="tab-category-link" onClick="javaScript:clickEvent('<?/*=$cidx*/?>');">
                            <?/*=$crow['NAME']*/?>
                            <span class="section_tab_line"></span>
                        </a>
                    </li>     -->

		<?
			$cate_name = $crow['NAME'];
			$cidx++;
				}
			}	?>
		<!-- 활성화시 클래스 active 추가 --->
	<!--	<li class="tab-category-item"><a href="#" class="tab-category-link">디자인 바체어</a></li>
		<li class="tab-category-item"><a href="#" class="tab-category-link">홈데코상품</a></li>	-->
	</ul>

	<?
		$i = 0;
		$idx = 0;
		$cate_name = "";
		foreach($goods as $row){
			if($cate_name != $row['NAME']){
				if($idx != 0){	?>
				</ul>
			</div>
		</div>
		<?		}	?>
			<div class="event_section" id="goods<?=$i?>">
				<h3 class="info-title info-title--sub"><?=$row['NAME']?></h3>
				<div class="prd-list-wrap">
					<ul class="prd-list prd-list--modify">
		<?
			$cate_name = $row['NAME'];
			$i++;
			}

			if($cate_name == $row['NAME']){	?>
				<!-- 상품리스트// -->
					<li class="prd-item">
                        <div class="pic">
                            <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                <div class="item auto-img">
                                    <div class="img">
                                        <img src="<?=$row['IMG_URL']?>" alt="">
                                    </div>
                                </div>
                                <div class="tag-wrap">
                                    <?if(isset($row['DEAL'])){?><?}?><!--<span class="btn-yellow2">특가</span> ===== <span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                    <?if($row['GONGBANG']=='G'){?><!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>--><?}?>
                                    <?if($row['GONGBANG']=='C'){?><!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>--><?}?>
                                </div>
                            </a>
                        </div>
                        <div class="prd-info-wrap">
                            <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                <dl class="prd-info">
                                    <dt class="prd-item-brand"><?=$row['BRAND_NM']?></dt>
                                    <dd class="prd-item-tit"><?=$row['GOODS_NM']?></dd>
                                    <dd class="prd-item-price">
                                        <?
                                        if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
//											$price = $row['SELLING_PRICE'] - $row['RATE_PRICE'] - $row['AMT_PRICE'];
                                            $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
                                            echo number_format($price);

                                            /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                            $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?>
                                            <span class="won">원</span><br>
                                            <del class="del-price"><?=number_format($row['SELLING_PRICE'])?>원</del>
                                            <!--<span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)</span>-->
                                            <span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)</span>
                                        <?}else{
                                            echo number_format($price = $row['SELLING_PRICE']);
                                            ?><span class="won"> 원</span><?
                                        } ?>
                                    </dd>
                                </dl>
                                <ul class="prd-label-list">
                                    <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                        ?>
                                        <li class="prd-label-item">쿠폰할인</li>
                                        <?
                                    }
                                    if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])){
                                        ?>
                                        <li class="prd-label-item free_shipping">무료배송</li>
                                        <?
                                    }
                                    if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){
                                        ?>
                                        <li class="prd-label-item">마일리지</li>
                                        <?
                                    }
                                    ?>
                                </ul>
                            </a>
                        </div>
					</li>
		<?
			$cate_name = $row['NAME'];
			$idx ++;
			}?>

	<?	}?>
				</ul>
			</div>
		</div>
		<!-- 공유하기 레이어 // -->
		<div id="share_sns"></div>
		<!-- // 공유하기 레이어 -->
			<!-- //상품리스트-->

	<!-- 페이징 // -->
<!--	<div class="page page--prd">
		<ul class="page-num-list">
			<li class="page-num-item page-num-left page-num-double-left">
				<a href="#" class="page-num-link"></a>
			</li>
			<li class="page-num-item page-num-left">
				<a href="#" class="page-num-link"></a>
			</li>
			<li class="page-num-item active">
				<a href="#" class="page-num-link">1</a>
			</li>
			<li class="page-num-item">
				<a href="#" class="page-num-link">2</a>
			</li>
			<li class="page-num-item">
				<a href="#" class="page-num-link">3</a>
			</li>
			<li class="page-num-item">
				<a href="#" class="page-num-link">4</a>
			</li>
			<li class="page-num-item">
				<a href="#" class="page-num-link">5</a>
			</li>
			<li class="page-num-item page-num-right active">
				<a href="#" class="page-num-link"></a>
			</li>
			<li class="page-num-item page-num-right page-num-double-right">
				<a href="#" class="page-num-link"></a>
			</li>
		</ul>
	</div>		-->
	<!-- // 페이징  -->


<script>
    //calculate image size
    function calcImgSize() {
        $("img", ".auto-img").each(function() {
            var $el = $(this);
            $el.parents(".img").addClass(function() {
                var $height = $el.height();
                var $width = $el.width();
                if ($height > $width) return "port";
                else return "land";
            });
        });
    };
    //이미지가 모두 로드 된 후 실행
    jQuery.event.add(window,"load",function(){
        calcImgSize();
    });
</script>



<script type="text/javaScript">
    //google_gtag
    gtag('event', 'select_content', {
        "promotions": [
            {
                "id": "<?=$event['PLAN_EVENT_CD']?>",
                "name": "ETAH - promotion"
            }
        ]
    });
function clickEvent(val){
	var idx = "<?=$cidx?>";
	for(i=0; i<idx; i++){
		if(val == i){
			$('#cate'+i).addClass('active');
			//$('#goods'+i').show();
		}else{
			$('#cate'+i).removeClass('active');
            //$('#goods'+i').hide();
		}
	}
//				$('#bestItem_li').removeClass('active');
//				$('#etahsChoice_li').addClass('active');
//				$('#bestItem').css("display","none");
//				$('#etahsChoice').css("display","");
}

//===============================================
// 쿠폰받기 (2017-02-16)
//===============================================
function jsGetCoupon(coupon_code){
	var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";

	if(SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST' || SESSION_ID == ''){
		location.href = '/member/login';
	}
	else {
		$.ajax({
			type: 'POST',
			url: '/goods/get_event_coupon',
			dataType: 'json',
			data: { coupon_code : coupon_code },
			error: function(res) {
				alert('Database Error');
			},
			success: function(res) {
				if(res.status == 'ok'){
					alert("쿠폰 발급이 완료되었습니다.");
				}
				else alert(res.message);
			}
		})
	}


}

clickEvent(0);
</script>
<!--GA script-->
<script>
    //Impression
//    ga('require', 'ecommerce', 'ecommerce.js');
//    <?//foreach ($goods as $grow){?>
//    ga('ecommerce:addImpression', {
//        'id': <?//=$grow['GOODS_CD']?>//,                   // Product details are provided in an impressionFieldObject.
//        'name': "<?//=$grow['GOODS_NM']?>//",
//        'category':<?//=$grow['CATEGORY_CD']?>//,
//        'brand': '<?//=$grow['BRAND_NM']?>//',
//        'list': 'Mob_Event Results'
//    });
//    <?//}?>
//    ga('ecommerce:send');
//
//    //action
//    function onProductClick(param,param2) {
//        var goods_cd = param;
//        var goods_nm = param2;
//        ga('ecommerce:addProduct', {
//            'id': goods_cd,
//            'name': goods_nm
//        });
//        ga('ecommerce:setAction', 'click', {list: 'Mob_Event Results'});
//
//        // Send click with an event, then send user to product page.
//        ga('send', 'event', 'UX', 'click', 'Results', {
//            hitCallback: function() {
//                //alert(goods_cd + '/' + goods_nm);
//                document.location = '/goods/detail/'+goods_cd;
//            }
//        });
//    }
</script>
<!--/GA script-->