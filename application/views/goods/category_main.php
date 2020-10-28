<link rel="stylesheet" href="/assets/css/display.css?ver=1.4">
<div class="content" id="category-main">
    <!-- top-location -->
    <div class="page-title-box page-title-box--location">
        <div class="page-title">
            <ul class="page-title-list">
                <li class="page-title-item"><a href="/">홈</a></li>
                <li class="page-title-item active"><?=$category['CATE_TITLE']?></li> <!-- 퐐성화시 클래스 active추가 -->
            </ul>
        </div>
    </div>
    <!-- //top-location -->

    <!-- main banner // -->
    <div class="main-banner">
        <ul class="main-banner-list owl-carousel owl-dot1">
            <?foreach ($top_banner as $row){?>
                <li class="main-banner-item">
                    <a href="<?=$row['BANNER_LINK_URL']?>" class="main-banner-link">
                        <img src="<?=$row['BANNER_IMG_URL']?>" alt="">
                        <div class="main-banner-title<?=$row['BANNER_LOCATION']?>">
                            <div class="main-banner-inner">
                                <p class="p01" style="font-family: <?=$row['BANNER_FONT_CLASS_GB_CD1']?>; color: <?=$row['BANNER_FONTCOLOR_CLASS_GB_CD1']?>;
                                        font-weight:<?=$row['BANNER_FONTWEIGHT_CLASS_GB_CD1']?>; font-size: <?=$row['BANNER_FONT_SIZE1']?>px;"><?=$row['BANNER_MAIN_TITLE']?></p>
                                <p class="p02" style="font-family: <?=$row['BANNER_FONT_CLASS_GB_CD2']?>; color: <?=$row['BANNER_FONTCOLOR_CLASS_GB_CD2']?>;
                                        font-weight:<?=$row['BANNER_FONTWEIGHT_CLASS_GB_CD2']?>; font-size: <?=$row['BANNER_FONT_SIZE2']?>px;"><?=$row['BANNER_SUB_TITLE']?></p>
                                <p class="p03" style="font-family: <?=$row['BANNER_FONT_CLASS_GB_CD3']?>; color: <?=$row['BANNER_FONTCOLOR_CLASS_GB_CD3']?>;
                                        font-weight:<?=$row['BANNER_FONTWEIGHT_CLASS_GB_CD3']?>; font-size: <?=$row['BANNER_FONT_SIZE3']?>px;"><?=$row['BANNER_SUB_TITLE_2']?></p>
                            </div>
                        </div>
                    </a>
                </li>
            <?}?>
        </ul>
    </div>
    <!-- // main banner -->

    <!--The choice// -->
    <div class="the-choice-wrap">
        <h3 class="prd-list-title">The choice</h3>
        <div class="prd-list-wrap">
            <ul class="prd-list prd-list--main owl-carousel owl-dot2">
                <?foreach($etah_choice as $erow){?>
                    <li class="prd-item">
                        <div class="pic">
                            <a href="/goods/detail/<?=$erow['GOODS_CD']?>">
                                <div class="item auto-img">
                                    <div class="img">
                                        <img src="<?=$erow['IMG_URL']?>" alt="">
                                    </div>
                                </div>
                                <div class="tag-wrap">
                                    <?if(!empty($erow['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                                    <?if($erow['CLASS_GUBUN']=='C'){?><!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>--><?}?>
                                    <?if($erow['CLASS_GUBUN']=='G'){?><!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>--><?}?>
                                </div>
                            </a>
                        </div>
                        <div class="prd-info-wrap">
                            <a href="/goods/detail/<?=$erow['GOODS_CD']?>">
                                <dl class="prd-info">
                                    <dt class="prd-item-brand">
                                        <?if($erow['CLASS_GUBUN']=='C'){?>[<?=$erow['ADDRESS']?>][<?=$erow['CLASS_TYPE']?>]<?}?>
                                        <?if($erow['CLASS_GUBUN']=='G'){?>[<?=$erow['CLASS_TYPE']?>]<?}?>
                                        <?=$erow['BRAND_NM']?>
                                    </dt>
                                    <dd class="prd-item-tit"><?=$erow['NAME']?></dd>
                                    <dd class="prd-item-price">
                                        <?if($erow['COUPON_CD']){
                                            $price = $erow['SELLING_PRICE'] - ($erow['RATE_PRICE']) - ($erow['AMT_PRICE']);
                                            echo number_format($price);

                                            /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
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
                                    <?if($erow['COUPON_CD']){?>
                                        <li class="prd-label-item">쿠폰할인</li>
                                    <?} if(($erow['PATTERN_TYPE_CD'] == 'FREE') || ( $erow['DELI_LIMIT'] > 0 && $price > $erow['DELI_LIMIT'])){	?>
                                        <li class="prd-label-item free_shipping">무료배송</li>
                                    <? }?>
                                    <? if($erow['GOODS_MILEAGE_SAVE_RATE'] > 0){	?>
                                        <li class="prd-label-item">마일리지</li>
                                    <? }?>
                                </ul>
                            </a>
                        </div>
                    </li>
                <? }?>

            </ul>
        </div>
    </div>
    <!-- //The choice-->

    <!-- 필터 -->
    <div class="filter-list">
        <div class="filter-inner">
            <div class="filter-item filter-category">
                <a href="#filterOptionBtn" class="filter-btn btn-gnb-open category-btn" data-ui="filter-btn">카테고리</a>
            </div>
            <div class="filter-item filter-option">
                <a href="#filterOptionBtn" class="filter-btn btn-gnb-open ranking-btn" data-ui="filter-btn">
                    <? switch ($order_by) {
                        case 'A':echo '인기순';break;
                        case 'B':echo '신상품순';break;
                        case 'C':echo '낮은가격순';break;
                        case 'D':echo '높은가격순';break;
                    } ?>
                </a>
            </div>
            <div class="filter-item filter-check">
                <a href="#filterOptionBtn" class="filter-btn btn-gnb-open" data-ui="filter-btn"><span class="spr-common spr-ico-filter"></span>상세검색</a>
            </div>
        </div>
    </div>
    <div class="filter-gnb-list">

        <aside class="filter-gnb" style="margin-right: -300px;">
            <form>
                <p class="filter-gnb-tit">상세검색</p>
                <button type="button" class="btn-close lg-w pop-close">close</button>
                <!-- member -->

                <!-- logined -->
                <div class="filter-search">
                    <p class="search-result">검색결과 <span><?=number_format($totalCnt)?></span>개</p>
                    <input type="reset" class="btn-reset">
                </div>
                <!-- logined -->
                <!-- //member -->

                <!-- nav -->
                <nav>

                    <!-- 카테고리 필터 -->
                    <div class="option_button position_area srp_option_area">
                        <div class="position_left">
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit2">카테고리</h4>
                                <ul id="srp-cate" class="srp-cate2">
                                    <?foreach($arr_cate2 as $c2){?>
                                        <li><a href="#none"><?=$c2['NM']?></a>
                                            <ul>
                                                <?foreach($arr_cate3 as $c3){
                                                    if($c3['P_CD']==$c2['CD']){?>
                                                        <li><a href="#none" onclick="search_goods('C','<?=$c3['CD']?>');"><?=$c3['NM']?></a></li>
                                                    <?}
                                                }?>
                                            </ul>
                                        </li>
                                    <?}?>
                                </ul>
                            </div>
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit1">정렬</h4>
                                <ul id="srp-cate" class="srp-cate1">
                                    <li>
                                        <a href="#none">
                                            <label class="common-radio-label" for="ranking1">
                                                <input type="radio" id="ranking1" class="common-radio-btn" name="order_by" value="A" <?=($order_by=='A')?'checked':''?>>
                                                <span class="common-radio-text">인기순</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#none">
                                            <label class="common-radio-label" for="ranking2">
                                                <input type="radio" id="ranking2" class="common-radio-btn" name="order_by" value="B" <?=($order_by=='B')?'checked':''?>>
                                                <span class="common-radio-text">신상품순</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#none">
                                            <label class="common-radio-label" for="ranking3">
                                                <input type="radio" id="ranking3" class="common-radio-btn" name="order_by" value="C" <?=($order_by=='C')?'checked':''?>>
                                                <span class="common-radio-text">낮은가격순</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#none">
                                            <label class="common-radio-label" for="ranking4">
                                                <input type="radio" id="ranking4" class="common-radio-btn" name="order_by" value="D" <?=($order_by=='D')?'checked':''?>>
                                                <span class="common-radio-text">높은가격</span>
                                            </label>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit4">국가</h4>
                                <ul id="srp-cate" class="srp-cate4">
                                    <?
                                    $cnidx = 1;
                                    foreach($arr_country as $key=>$value){?>
                                        <li class="checkbox_area country">
                                            <a href="#none">
                                                <input type="checkbox" class="checkbox" id="CountryCheck<?=$cnidx?>" name="country" value="<?=$key?>">
                                                <label class="checkbox_label" for="CountryCheck<?=$cnidx?>"><?=$value['NM']?></label>
                                            </a>
                                        </li>
                                        <?$cnidx++;
                                    }
                                    ?>
                                </ul>
                            </div>

                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit3">배송</h4>
                                <ul id="srp-cate" class="srp-cate3">
                                    <li>
                                        <a href="#none" class="free-deli">
                                            <label class="common-radio-label" for="free-deli1">
                                                <input type="radio" id="free-deli1" class="common-radio-btn" name="deliv_type" value="" <?=($deliv_type=='')?'checked':''?>>
                                                <span class="common-radio-text">전체</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#none" class="free-deli">
                                            <label class="common-radio-label" for="free-deli2">
                                                <input type="radio" id="free-deli2" class="common-radio-btn" name="deliv_type" value="FREE" <?=($deliv_type=='FREE')?'checked':''?>>
                                                <span class="common-radio-text">무료배송만</span>
                                            </label>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit5">가격</h4>
                                <?
                                $price_min = min($arr_sellingPrice);
                                $price_max = max($arr_sellingPrice);

                                //최소값, 최대값 재설정
                                if ($price_min < 10000) $price_min = 1000; //1천원

                                if ($price_max > 300000) $price_min = 100000;    //10만원
                                if ($price_max > 3000000) $price_min = 1000000;   //100만원

                                //기준금액단위 설정
                                if( (($price_max - $price_min) > 3000000) && ($price_min > 1000000) ) {
                                    $limit = 1000000; //100만원
                                } else if( (($price_max - $price_min) > 300000) && ($price_min > 100000) ){
                                    $limit = 100000; //10만원
                                } else if( (($price_max - $price_min) < 30000)){
                                    $limit = 5000; //5천원
                                } else {
                                    $limit = 10000; //1만원
                                }

                                $price_min = ceil($price_min / $limit) * $limit;
                                $price_max = floor($price_max / $limit) * $limit;

                                $price_range = ($price_max - $price_min) / 3;
                                $price_range = floor($price_range / $limit) * $limit;
                                ?>
                                <ul id="srp-cate" class="srp-cate5">
                                    <li class="checkbox_area country">
                                        <a href="#none">
                                            <label class="common-radio-label" for="price0">
                                                <input type="radio" id="price0" class="common-radio-btn" name="price_limit" value="" <?=($price_limit=='')?'checked':''?>>
                                                <span class="common-radio-text">전체</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <a href="#none">
                                            <label class="common-radio-label" for="price1">
                                                <?$range = '|'.(string)$price_min?>
                                                <input type="radio" id="price1" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text"><?=number_format($price_min)?>원 이하</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <?$range = (string)$price_min.'|'.(string)($price_min+($price_range*1))?>
                                        <a href="#none">
                                            <label class="common-radio-label" for="price2">
                                                <input type="radio" id="price2" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text"><?=number_format($price_min)?>원 ~ <?=number_format($price_min+($price_range*1))?>원</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <a href="#none">
                                            <label class="common-radio-label" for="price3">
                                                <?$range = (string)$price_min+($price_range*1).'|'.(string)($price_min+($price_range*2))?>
                                                <input type="radio" id="price3" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text"><?=number_format($price_min+($price_range*1))?>원 ~ <?=number_format($price_min+($price_range*2))?>원</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <a href="#none">
                                            <label class="common-radio-label" for="price4">
                                                <?$range = (string)($price_min+($price_range*2)).'|'.(string)($price_min+($price_range*3))?>
                                                <input type="radio" id="price4" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text"><?=number_format($price_min+($price_range*2))?>원 ~ <?=number_format($price_min+($price_range*3))?>원</span>
                                            </label>
                                        </a>
                                    </li>
                                    <li class="checkbox_area country">
                                        <a href="#">
                                            <label class="common-radio-label" for="price5">
                                                <?$range = (string)($price_min+($price_range*3)).'|'?>
                                                <input type="radio" id="price5" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                <span class="common-radio-text"><?=number_format($price_min+($price_range*3))?>원 이상</span>
                                            </label>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="select_wrap select_wrap_cate">
                                <h4 class="srp-cate-tit srp-cate-tit6">브랜드</h4>
                                <?$search_brand = explode("|", substr($brand_cd,1));?>
                                <ul id="srp-cate" class="srp-cate6">
                                    <?
                                    $aidx = 1;
                                    foreach($arr_brand as $key=>$value){?>
                                        <li class="checkbox_area country">
                                            <a href="#none"><?=$key?></a>
                                            <ul id="srp-cate" class="srp-cate7" style="display: none">
                                                <?
                                                $bidx = 1;
                                                foreach($value as $k=>$v){?>
                                                    <li class="checkbox_area country">
                                                        <a href="#none">
                                                            <input type="checkbox" class="checkbox" id="BrandCheck<?=$aidx?>_<?=$bidx?>" name="brand_cd" value="<?=$k?>" <?=in_array($k, $search_brand)?'checked':''?>>
                                                            <label class="checkbox_label" for="BrandCheck<?=$aidx?>_<?=$bidx?>"><?=$v['NM']?></label>
                                                        </a>
                                                    </li>
                                                    <?
                                                    $bidx++;
                                                }?>
                                            </ul>
                                        </li>
                                        <?
                                        $aidx++;
                                    }?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- //카테고리 필터 -->

                    <!-- //shoping guide -->
                    <div class="confirm">
                        <button class="confirm" onclick="search_goods('', ''); return false;">확인</button>
                    </div>
                </nav>
                <!-- //nav -->
            </form>
        </aside>

    </div>
    <!-- // 필터 -->

    <!-- 상품리스트 // -->
    <div class="prd-list-wrap">
        <ul class="prd-list prd-list--modify">
            <? foreach($goods as $row){ ?>
                <li class="prd-item">
                    <div class="pic">
                        <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                            <div class="item auto-img">
                                <div class="img">
                                    <img src="<?=$row['IMG_URL']?>" alt="">
                                </div>
                            </div>
                            <div class="tag-wrap">
                                <?if(!empty($row['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
                                <?if($row['CLASS_GUBUN'] == 'C'){?><!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>--><?}?>
                                <?if($row['CLASS_GUBUN'] == 'G'){?><!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>--><?}?>
                            </div>
                        </a>
                    </div>
                    <div class="prd-info-wrap">
                        <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                            <dl class="prd-info">
                                <dt class="prd-item-brand">
                                    <?if($row['CLASS_GUBUN'] == 'C'){?>[<?=$row['ADDRESS']?>][<?=$row['CLASS_TYPE']?>]<?}?>
                                    <?if($row['CLASS_GUBUN'] == 'G'){?>[<?=$row['CLASS_TYPE']?>]<?}?>
                                    <?=$row['BRAND_NM']?>
                                </dt>
                                <dd class="prd-item-tit"><?=$row['GOODS_NM']?></dd>
                                <dd class="prd-item-price">
                                    <? if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                        $price = $row['SELLING_PRICE'] - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']) - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']);
                                        echo number_format($price);

                                        /* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
                                        $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                        $sale_percent = strval($sale_percent);
                                        $sale_percent_array = explode('.',$sale_percent);
                                        $sale_percent_string = $sale_percent_array[0];

                                        ?><span class="won">원</span><br>
                                        <del class="del-price"><?=number_format($row['SELLING_PRICE'])?>원</del>
                                        <!--<span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)</span>-->
                                        <span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)</span>
                                    <?} else {
                                        echo number_format($price = $row['SELLING_PRICE']);
                                        ?><span class="won">원</span><br>
                                    <?}?>
                                </dd>
                            </dl>
                            <ul class="prd-label-list">
                                <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){?>
                                    <li class="prd-label-item">쿠폰할인</li>
                                <?} if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])){	?>
                                    <li class="prd-label-item free_shipping">무료배송</li>
                                <?} if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){?>
                                    <li class="prd-label-item">마일리지</li>
                                <?}?>
                            </ul>
                        </a>
                    </div>
                </li>
            <?}?>
        </ul>
    </div>
    <!-- // 상품리스트 -->


    <!-- 페이징 //-->
    <?=$pagination?>
    <!-- // 페이징 -->

    <!-- 공유하기 레이어 // -->
    <div id="share_sns"></div>
    <!-- // 공유하기 레이어 -->



    <script src="/assets/js/common.js?ver=2.5"></script>
    <script>
        $(function(){
            // $('#pageCategoryLayer2').categorySwipe();

            $('#pageCategoryLayer2').categorySwipe( function( ele ){
                ele.css('display', 'none');
            } );

            $('#filterCheckLayer').css('display', 'none');

            $('.filter-check .filter-btn').on('click', function(){
                $('#pageCategoryLayer2').css('display','block');
            });

            // $('.page-title').areaSwipe();
        })

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
    <script>
        $(document).ready(function(){
            // 스크롤 시 상품상세 탭 네비 동작
            var tabsOffset = $('.filter-list').offset().top + 570; // - Scroll Up
            var tabsOffset_up = $('.filter-list').offset().top + 615; // - Scroll Down

            $(window).scroll(function () {
                var scroll2 = $(this).scrollTop();
                if (scroll2 >= tabsOffset_up) {
                    $('.filter-list').addClass('fixed');
                } else if (scroll2 <= tabsOffset) {
                    $('.filter-list').removeClass('fixed');
                }
            });
        });

        check_attr();
        //====================================
        // 하위속성 체크
        //====================================
        function check_attr()
        {
            var attr_cd = "<?=$attr_cd?>",
                attr = document.getElementsByName("chkAttr[]");
            arr_attr = attr_cd.split("|");
            for( j=0; j<arr_attr.length; j++){
                for( i=0; i<attr.length; i++){
                    if(document.getElementsByName("chkAttr[]")[i].value == arr_attr[j+1]){
                        document.getElementsByName("chkAttr[]")[i].checked = true;
                    }
                }
            }
        }

        //====================================
        // 조건별 검색
        //====================================
        function search_goods(kind, val)
        {
            var cate_gb     = '<?=$cate_gb?>';
            var cate_cd     = '<?=$cate_cd?>';
            var order_by    = '';
            var country     = '';
            var deliv_type  = '';
            var price_limit = '';
            var brand_cd    = '';


//카테고리
            if(kind=='C'){
                cate_gb = 'S';
                cate_cd = val;
            }

            //정렬
            order_by = $('input[name=order_by]:checked').val();

            //국가
            $("input[name=country]:checked").each(function() {
                country += '|'+$(this).val();
            });

            //배송
            deliv_type = $('input[name=deliv_type]:checked').val();

            //가격
            price_limit = $('input[name=price_limit]:checked').val();

            //브랜드
            $("input[name=brand_cd]:checked").each(function() {
                brand_cd += '|'+$(this).val();
            });

            document.location.href = "/category/category_list?cate_cd="+cate_cd+"&cate_gb="+cate_gb+"&order_by="+order_by+"&country="+country+"&deliv_type="+deliv_type+"&price_limit="+price_limit+"&brand_cd="+brand_cd;
        }
    </script>
    <!--GA script-->
    <script>
        //Impression
        //        ga('require', 'ecommerce', 'ecommerce.js');
        //        <?//foreach ($goods as $grow){?>
        //        ga('ecommerce:addImpression', {
        //            'id': <?//=$grow['GOODS_CD']?>//,                   // Product details are provided in an impressionFieldObject.
        //            'name': "<?//=$grow['GOODS_NM']?>//",
        //            'category':<?//=$cate_cd?>//,
        //            'brand': '<?//=$grow['BRAND_NM']?>//',
        //            'list': 'Mob_Goods Results'
        //        });
        //        <?//}?>
        //        ga('ecommerce:send');
        //
        //        //action
        //        function onProductClick(param,param2) {
        //            var goods_cd = param;
        //            var goods_nm = param2;
        //            ga('ecommerce:addProduct', {
        //                'id': goods_cd,
        //                'name': goods_nm
        //            });
        //            ga('ecommerce:setAction', 'click', {list: 'Mob_Goods Results'});
        //
        //            // Send click with an event, then send user to product page.
        //            ga('send', 'event', 'UX', 'click', 'Results', {
        //                hitCallback: function() {
        //                    //alert(goods_cd + '/' + goods_nm);
        //                    document.location = '/goods/detail/'+goods_cd;
        //                }
        //            });
        //        }
    </script>
    <!--/GA script-->


    <script>

        /* lnb */
        (function($) {
            var lnbUI = {
                click: function(target, speed) {
                    var _self = this,
                        $target = $(target);
                    _self.speed = speed || 300;
                    $target.each(function() {
                        if (findChildren($(this))) {
                            return;
                        }
                        $(this).addClass('noDepth');
                    });

                    function findChildren(obj) {
                        return obj.find('> ul').length > 0;
                    }
                    $target.on('click', 'a', function(e) {
                        e.stopPropagation();
                        var $this = $(this),
                            $depthTarget = $this.next(),
                            $siblings = $this.parent().siblings();
                        $this.parent('li').find('ul li').removeClass('on');
                        $siblings.removeClass('on');
                        $siblings.find('ul').slideUp(250);
                        if ($depthTarget.css('display') == 'none') {
                            _self.activeOn($this);
                            $depthTarget.slideDown(_self.speed);
                        } else {
                            $depthTarget.slideUp(_self.speed);
                            _self.activeOff($this);
                        }
                    })
                },
                activeOff: function($target) {
                    $target.parent().removeClass('on');
                },
                activeOn: function($target) {
                    $target.parent().addClass('on');
                }
            }; // Call lnbUI
            $(function() {
                lnbUI.click('#srp-cate li', 300)
            });
        }(jQuery));


    </script>