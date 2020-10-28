<link rel="stylesheet" href="/assets/css/main.css?var=1.1">
<div class="content">
    <!-- main banner // -->
    <div class="main-banner" >
        <ul class="main-banner-list owl-carousel owl-dot1">
            <li class="main-banner-item">
                <a href="<?=$banLinkUrl?>" class="main-banner-link">
                    <img src="<?=$banImgUrl?>" alt="">
                    <div class="main-banner-title<?=$text_locaion?>">
                        <div class="main-banner-inner">
                        <p class="p01" style="font-family: <?=$font_Gb1?>; color: <?=$font_color1?>; font-weight:<?=$font_weight1?>; font-size: <?=$font_size1?>px;"><?=$banner_text1?></p>
                        <p class="p03" style="font-family: <?=$font_Gb2?>; color: <?=$font_color2?>; font-weight:<?=$font_weight2?>; font-size: <?=$font_size2?>px;"><?=$banner_text2?></p>
                        <p class="p03" style="font-family: <?=$font_Gb3?>; color: <?=$font_color3?>; font-weight:<?=$font_weight3?>; font-size: <?=$font_size3?>px;"><?=$banner_text3?></p>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>

    <!-- // main banner -->

    <!-- category menu // -->
    <ul class="category-menu-list category-menu-list--main">
        <? $icon = '';
        for($a=0; $a<count($menu['arr_menu1_cd']); $a++){
            switch($menu['arr_menu1_cd'][$a]){
                case "10000000": $icon = 'spr-common ico-category-furniture';	break;
                case "11000000": $icon = 'spr-common ico-category-interior';	break;
                case "13000000": $icon = 'spr-common ico-category-diy';			break;
                case "14000000": $icon = 'spr-common ico-category-light';		break;
                case "18000000": $icon = 'spr-common ico-category-pet';			break;
                case "19000000": $icon = 'spr-common ico-category-kitchen';		break;
                case "15000000": $icon = 'spr-common ico-category-bedding';		break;
                case "16000000": $icon = 'spr-common ico-category-gardening';	break;
                case "17000000": $icon = 'spr-common ico-category-living';		break;
                case "20000000": break;
                default: $icon = '';
            } ?>
            <li class="category-menu-item">
                <a href="/category/main?cate_cd=<?=$menu['arr_menu1_cd'][$a]?>" class="category-menu-link">
                    <span class="<?=$icon?>"></span><?=$menu['arr_menu1_nm'][$a]?>
                </a>
            </li>
        <? }?>
    </ul>

    <!-- keyword//-->
    <div class="keyword">
        <p class="tag-head">#핫 이슈 키워드</p>
        <ul>
            <? //print_r($keyword);
            foreach($keyword as $erow){
                //$keylen = strlen($erow['NAME']);
                //$key = substr($erow['NAME'], 1, $keylen)?>
                <li><a href="<?=$erow['LINK_URL']?>"><div class="circle-img">
                            <img src="<?=$erow['IMG_URL']?>" alt="">
                        </div><?=$erow['NAME']?></a></li>
            <?}?>
            <!-- <li><a href="#">
                 <div class="circle-img"><img src="../assets/images/data/data_prd_130x130.jpg" alt=""></div>
                 #일본직구
                 </a></li>-->
        </ul>
    </div>
    <!-- // keyword -->

    <!-- MD 픽! 영역// -->
    <div class="the-choice-wrap">
        <h3 class="prd-list-title">MD 픽!</h3>
        <div class="prd-list-wrap">
            <ul class="prd-list prd-list--main owl-carousel owl-dot2">
                <?foreach($etah_choice as $erow){?>
                    <li class="prd-item">
                        <a href="/goods/detail/<?=$erow['GOODS_CD']?>" class="prd-link">
                            <img src="<?=$erow['IMG_URL']?>" alt="버플리 원목 2700 거실장 세트">
                        </a>
                        <div class="prd-info-wrap">
                            <a href="/goods/detail/<?=$erow['GOODS_CD']?>" class="prd-link">
                                <dl class="prd-info">
                                    <dt class="prd-item-brand"><?=$erow['BRAND_NM']?></dt>
                                    <dd class="prd-item-tit"><?=$erow['NAME']?></dd>
                                    <dd class="prd-item-price" >
                                        <?if($erow['COUPON_CD']){
                                            $price = $erow['SELLING_PRICE'] - ($erow['RATE_PRICE']) - ($erow['AMT_PRICE']);
                                            echo number_format($price);
                                            $sale_percent = (($erow['SELLING_PRICE'] - $price)/$erow['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?><span class="won"> 원</span><br>
                                            <del class="del-price"><?=number_format($erow['SELLING_PRICE'])?>원</del>
                                            <!--<span class="dc-rate">(<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)
												</span>-->
                                            <span class="dc-rate">(<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)
												</span>
                                        <? } else {
                                            echo number_format($erow['SELLING_PRICE']);
                                            ?><span class="won"> 원</span><?
                                        }
                                        ?>
                                    </dd>
                                </dl>
                                <ul class="prd-label-list">
                                    <? if(($erow['PATTERN_TYPE_CD'] == 'FREE') || ( $erow['DELI_LIMIT'] > 0 && $price > $erow['DELI_LIMIT'])){	?>
                                        <li class="prd-label-item">무료배송</li>
                                    <? }?>
                                    <? if($erow['GOODS_MILEAGE_SAVE_RATE'] > 0){	?>
                                        <li class="prd-label-item">마일리지</li>
                                    <? }?>
                                </ul>
                            </a>
                            <br>
                            <ul class="prd-bookmark">
                                <li class="prd-bookmark-item"><a href="javaScript:jsGoodsAction('W','','<?=$erow['GOODS_CD']?>','','');" class="prd-bookmark-link <?=@$erow['INTEREST_GOODS_NO']?'active':''?>"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
                                <!-- 활성화시 클래스 active 추가 -->
                                <li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open" onClick="javaScript:openShareLayer('G', '<?=$erow['GOODS_CD']?>', '<?=$erow['IMG_URL']?>', '<?=$erow['GOODS_NM']?>');"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
                            </ul>
                        </div>
                    </li>
                <? }?>
            </ul>
            <a href="/goods/event/234" class="more">more</a>
        </div>
    </div>
    <!--컬렉션 타이틀//-->
    <h3 class="prd-list-title">It's 트랜드</h3>

    <!--컬렉션 영역//-->
    <div class="the-choice-wrap">

        <div class="prd-list-wrap">
            <ul class="prd-list prd-list--main owl-carousel owl-dot2">
                <?foreach($collection as $erow){?>
                    <li class="prd-item">
                        <a href="/goods/detail/<?=$erow['GOODS_CD']?>" class="prd-link">
                            <img src="<?=$erow['IMG_URL']?>" alt="버플리 원목 2700 거실장 세트">
                        </a>
                        <div class="prd-info-wrap">
                            <a href="/goods/detail/<?=$erow['GOODS_CD']?>" class="prd-link">
                                <dl class="prd-info">
                                    <dt class="prd-item-brand"><?=$erow['BRAND_NM']?></dt>
                                    <dd class="prd-item-tit"><?=$erow['NAME']?></dd>
                                    <dd class="prd-item-price">
                                        <?if($erow['COUPON_CD']){
                                            $price = $erow['SELLING_PRICE'] - ($erow['RATE_PRICE']) - ($erow['AMT_PRICE']);
                                            echo number_format($price);
                                            $sale_percent = (($erow['SELLING_PRICE'] - $price)/$erow['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?><span class="won"> 원</span><br>
                                            <del class="del-price"><?=number_format($erow['SELLING_PRICE'])?>원</del>
                                            <!--<span class="dc-rate">(<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)
												</span>-->
                                            <span class="dc-rate">(<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)
												</span>
                                        <?} else {
                                            echo number_format($erow['SELLING_PRICE']);
                                            ?><span class="won"> 원</span><?
                                        }
                                        ?>
                                    </dd>
                                </dl>
                                <ul class="prd-label-list">
                                    <? if(($erow['PATTERN_TYPE_CD'] == 'FREE') || ( $erow['DELI_LIMIT'] > 0 && $price > $erow['DELI_LIMIT'])){	?>
                                        <li class="prd-label-item">무료배송</li>
                                    <? }?>
                                    <? if($erow['GOODS_MILEAGE_SAVE_RATE'] > 0){	?>
                                        <li class="prd-label-item">마일리지</li>
                                    <? }?>
                                </ul>
                            </a>
                            <br>
                            <ul class="prd-bookmark">
                                <li class="prd-bookmark-item"><a href="javaScript:jsGoodsAction('W','','<?=$erow['GOODS_CD']?>','','');" class="prd-bookmark-link <?=@$erow['INTEREST_GOODS_NO']?'active':''?>"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
                                <!-- 활성화시 클래스 active 추가 -->
                                <li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open" onClick="javaScript:openShareLayer('G', '<?=$erow['GOODS_CD']?>', '<?=$erow['IMG_URL']?>', '<?=$erow['GOODS_NM']?>');"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
                            </ul>
                        </div>
                    </li>
                <? }?>
            </ul>

        </div>
    </div>
    <!--// 컬렉션 영역-->

    <!-- 브랜드포커스 // -->
    <?if($new_brand){	?>
        <div class="brand-theme">
            <h3 class="prd-list-title">브랜드포커스</h3>
            <div class="prd-list-wrap">
                <ul class="brand-theme-list owl-carousel owl-dot2">
                    <?foreach($new_brand as $brow){?>
                        <li class="brand-theme-item">
                            <a href="<?=$brow['LINK_URL']?>" class="brand-theme-link">
                                <img src="<?=$brow['IMG_URL']?>" alt="버플리 원목 2700 거실장 세트">
                            </a>
                        </li>
                    <?}?>
                </ul>

            </div>
        </div>
    <?}?>
    <!--// 브랜드포커스 -->

    <!-- WEEKLY THEME // -->
    <?if($new_item){?>
        <div class="brand-theme">
            <h3 class="prd-list-title">위클리 테마</h3>
            <div class="prd-list-wrap">
                <ul class="brand-theme-list owl-carousel owl-dot2">
                    <?foreach($new_item as $brow){?>
                        <li class="brand-theme-item">
                            <a href="<?=$brow['LINK_URL']?>" class="brand-theme-link">
                                <img src="<?=$brow['IMG_URL']?>" alt="버플리 원목 2700 거실장 세트">
                            </a>
                        </li>
                    <?}?>
                </ul>
            </div>
        </div>
    <?}?>
    <!-- // WEEKLY THEME -->

    <!-- magazine // -->
    <div class="magazine-wrap prd-list-wrap">
        <h3 class="prd-list-title">매거진</h3>
        <div class="magazine">
            <ul class="magazine-list">
                <?foreach($magazine as $mrow){	?>
                    <li class="magazine-item">
                        <a href="<?=$mrow['LINK_URL']?>" class="magazine-link">
                            <img src="<?=$mrow['MOB_MAGAZINE_IMG_URL']?>" alt="" onerror="this.src='/assets/images/data/main_magazin_6.jpg'">
                            <span class="magazine-text"><?=$mrow['NAME'][0]?></span>
                        </a>
                    </li>
                <? }?>
            </ul>
        </div>
        <a href="/magazine" class="more">more</a>
    </div>
    <!-- // magazine -->

    <!-- // INSTAGRAM -->
    <div class="instagram-banner">
        <h3 class="prd-list-title text-center"><a href="https://www.instagram.com/etahcompany/" target="_blank">
                <img src="/assets/images/data/logo_instagram1.png" alt=""></a></h3>
        <div id="instafeed-gallery-feed" class="gallery row no-gutter"></div>
    </div>
    <!-- INSTAGRAM // -->

    <!--PROMOTION // -->
    <?if($brand_recommendation[0]['DISP_HTML']){	?>
        <div class="brand-recommendation">
            <h3 class="prd-list-title">프로모션</h3>
            <ul class="brand-recommendation-list">
                <?foreach($brand_recommendation as $brow){?>
                    <?=$brow['DISP_HTML']?>
                <?}?>
            </ul>
        </div>
    <? }?>

    <!-- 공유하기 레이어 // -->
    <div class="layer-wrap layer-sns-share" id="layerSnsShare">
        <div class="layer-inner">
            <h1 class="layer-title">공유하기</h1>
            <div class="layer-content">
                <ul class="layer-sns-list">
                    <li class="layer-sns-item">
                        <a href="#" class="layer-sns-link"><span class="spr-layer layer-sns-kakaotalk"></span>카카오톡</a>
                    </li>
                    <li class="layer-sns-item">
                        <a href="#" class="layer-sns-link"><span class="spr-layer layer-sns-facebook"></span>페이스북</a>
                    </li>
                    <li class="layer-sns-item">
                        <a href="#" class="layer-sns-link"><span class="spr-layer layer-sns-kakaostory"></span>카카오스토리</a>
                    </li>
                </ul>
                <!-- <a href="#" class="btn-layer-url-copy">URL 복사하기</a> -->
            </div>
            <a href="#" class="btn-layer-close" data-close="layer-close"><span class="hide">닫기</span></a>
        </div>
    </div>
    <!-- // 공유하기 레이어 -->


    <!-- 메인프로모션 레이어 // -->

    <div class="layer-wrap layer-main01 layer-wrap--view" id="layerMainPopup" style="visibility:hidden;">
        <div class="layer-inner">
            <div class="layer-content">
                <!--<a href="http://m.etah.co.kr/goods/search?keyword=나우재팬&cate_cd=&type=srp"><img src="../assets/images/data/main_popup01_180827.jpg" style="width: 100%;" alt=""></a>-->
                <a href="http://m.etah.co.kr/goods/event/407"><img src="../assets/images/data/main_popup01_180910.jpg" style="width: 100%;" alt=""></a>
                <a href="/goods/event/66"><img src="../assets/images/data/main_popup02_180831.jpg" style="width: 100%;" alt=""></a>
                <!-- <a href="http://m.etah.co.kr/goods/event/375"><img src="../assets/images/data/main_popup03_180712.jpg" style="width: 100%;" alt=""></a> -->
                <a href="http://m.etah.co.kr/goods/event/375"><img src="../assets/images/data/main_popup03_180910.jpg" style="width: 100%;" alt=""></a>
            </div>
            <div class="bottom-wrap">
                <div class="checkbox_area">
                    <input type="checkbox" id="formMainClose" class="checkbox"> <label for="formMainClose" class="checkbox-label">오늘 하루 열지 않음</label>
                </div>
                <a href="#" data-close="layer-close" id="full_layer_close" class="btn_close">닫기 X</a>
            </div>
        </div>
    </div>
    <!-- // 메인프로모션 레이어 -->

    <script>
        $(document).ready(function(){
            // 팝업슬라이드
            $(".layer-main01 .layer-content").owlCarousel({
                items: 1,
                loop: true,
                autoHeight: true,
                smartSpeed: 300,
                autoplay: true,
                autoplayTimeout: 5000
            });
        });
    </script>

    <script type="text/javascript">
        //메인 프로모션 팝업 딤레이어
        $(function(){
            if($.cookie('layerMainPopup') != 'hidden'){
                $('#wrap').addClass('layer-open');
                $('#layerMainPopup').show();
                $('#layerMainPopup').css('visibility','visible');

            }else {
                $('#wrap').removeClass('layer-open');
                $('#layerMainPopup').hide();
            }

            $('#full_layer_close').click( function() {
                var chkd = $("#formMainClose").is(":checked");
                if(chkd){
                    $.cookie('layerMainPopup', 'hidden', {expires : 1});
                }
                $('#wrap').removeClass('layer-open');
            });
        });

    </script>
    <div class="dimd"></div>