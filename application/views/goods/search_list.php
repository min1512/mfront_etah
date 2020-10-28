<link rel="stylesheet" href="/assets/css/display.css?ver=1.8">

<div class="content">
    <p class="srp_result_text">
        '<?=$keyword?>' 통합 검색결과<em class="bold_yel">(<?=number_format($search_cnt)?>개)</em>
    </p>

    <?if($search_cnt == 0){?>
    <div class="srp_result_text prd_none_text"style="text-align: center;">
        <em class="bold">"<?=$keyword?>"</em>에 대한 검색 결과가 없습니다.
    </div>
    <?}?>

    <?if(!empty($brand)){
        foreach($brand as $brow){
            ?>
            <div class="srp_brand">
                <img src="/assets/images/display/btn_home.png" alt="">
                <a href="/goods/brand/<?=$brow['BRAND_CD']?>?srp=<?=$keyword?>">
                    <em class="bold_yel"><?=$brow['BRAND_NM']?></em> 브랜드관 바로가기
                </a>
            </div>
            <?
        }
    }?>


    <?if(!empty($tag)){?>
        <div class="prd-list-wrap">
            <div class="srp_result_title">
                <h4 class="title-style">연관 태그<em class="bold_yel">(<?=number_format(count($tag))?>개)</em></h4>
            </div>
            <div class="relation_tag">
                <div class="owl-carousel owl-theme">
                    <?foreach($tag as $trow){?>
                        <div class="item" ><a href="/goods/search?keyword=<?=$keyword?>&gb=T&tag_keyword=<?=$trow['TAG_NM']?>">#<?=$trow['TAG_NM']?></a></div>
                    <?}?>
                    <div class="clear-item"></div>
                </div>
            </div>
            <script>
                $('.owl-carousel').owlCarousel({
                    margin:10,
                    loop:false,
                    autoWidth:true,
                    items:3,
                    dots:false
                });
            </script>

        </div>
    <?}?>

    <!-- 기획전 // -->
    <?if($planEvent_cnt != 0){?>
    <div class="srp_result_title">
        <h4 class="title-style">기획전<em class="bold_yel">(<?=number_format($planEvent_cnt)?>개)</em></h4>
        <p class="srp_ex"><button onclick="$(this).siblings('span').toggle();">?</button><span>‘<?=$keyword?>’의 상품을 포함한 기획전</span></p>
        <a href="/goods/search?keyword=<?=$keyword?>&gb=E" class="btn-more" style="font-size:0.825rem;">
            <span>more</span>
        </a>
    </div>
    <ul class="srp_project_list">
        <?foreach($planEvent as $erow){?>
            <li>
                <a href="/goods/event/<?=$erow['PLAN_EVENT_CD']?>">
                    <div class="img"><img src="<?=$erow['IMG_URL']?>" onerror="this.style.display='none'" alt="<?=$erow['TITLE']?>"></div>
                    <div class="txt">
                        <div class="txt-inner">
                            <span><?=$erow['TITLE']?></span>
                        </div>
                    </div>
                </a>
            </li>
        <?}?>
    </ul>
    <?}?>


    <!--// 기획전 -->

    <?if($goods_cnt != 0){?>
    <div class="srp_result_title">
        <h4 class="title-style">상품<em class="bold_yel">(<?=number_format($goods_cnt)?>개)</em></h4>
        <a href="/goods/search?keyword=<?=$keyword?>&gb=G" class="btn-more" style="font-size:0.825rem;">
            <span>more</span>
        </a>
    </div>
    <!-- 상품리스트 // -->
    <div class="prd-list-wrap">
        <ul class="prd-list prd-list--modify">
            <?foreach($goods as $grow){?>
                <li class="prd-item">
                    <div class="pic">
                        <a href="/goods/detail/<?=$grow['fields']['goods_cd']?>">
                            <div class="item auto-img">
                                <div class="img">
                                    <img src="<?=$grow['fields']['img_url']?>" alt="<?=$grow['fields']['goods_nm']?>">
                                </div>
                            </div>
                            <div class="tag-wrap">
                                <?@$gPrice = $arr_price[$grow['fields']['goods_cd']]?>
                                <?if(isset($gPrice['DEAL'])){?>
                                    <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                <?}?>
                                <?if($gPrice['GONGBANG']=='G'){?>
                                    <!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>-->
                                <?}else if($gPrice['GONGBANG']=='C'){?>
                                    <!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>-->
                                <?}?>
                            </div>
                        </a>
                    </div>
                    <div class="prd-info-wrap">
                        <a href="/goods/detail/<?=$grow['fields']['goods_cd']?>" class="prd-link">
                            <dl class="prd-info">
                                <dt class="prd-item-brand"><?=$grow['fields']['brand_nm']?></dt>
                                <dd class="prd-item-tit"><?=$grow['fields']['goods_nm']?></dd>
                                <dd class="prd-item-price">
                                    <?
                                    @$gPrice = $arr_price[$grow['fields']['goods_cd']];
                                    if($gPrice['COUPON_CD_S'] || $gPrice['COUPON_CD_G']){
                                        $price = $gPrice['SELLING_PRICE'] - ($gPrice['RATE_PRICE_S'] + $gPrice['RATE_PRICE_G'] ) - ($gPrice['AMT_PRICE_S'] + $gPrice['AMT_PRICE_G']);
                                        echo number_format($price);

                                        $sale_percent = (($gPrice['SELLING_PRICE'] - $price)/$gPrice['SELLING_PRICE']*100);
                                        $sale_percent = strval($sale_percent);
                                        $sale_percent_array = explode('.',$sale_percent);
                                        $sale_percent_string = $sale_percent_array[0];
                                        ?><span class="won">원</span><br>
                                        <del class="del-price"><?=number_format($gPrice['SELLING_PRICE'])?>원</del>
                                        <!--<span class="dc-rate">(<?=floor((($gPrice['SELLING_PRICE']-$price)/$gPrice['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)</span>-->
                                        <span class="dc-rate">(<?=floor((($gPrice['SELLING_PRICE']-$price)/$gPrice['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)</span>
                                    <?}else{
                                        echo number_format($price = $gPrice['SELLING_PRICE']);
                                        ?><span class="won">원</span><br>
                                    <?}?>
                                </dd>
                            </dl>
                            <ul class="prd-label-list">
                                <?
                                if($gPrice['COUPON_CD_S'] || $gPrice['COUPON_CD_G']){?>
                                    <li class="prd-label-item">쿠폰할인</li>
                                <?}
                                if($gPrice['GOODS_MILEAGE_SAVE_RATE'] > 0){
                                    ?>
                                    <li class="prd-label-item">마일리지</li>
                                <?}
                                if(($gPrice['PATTERN_TYPE_CD'] == 'FREE') || ( $gPrice['DELI_LIMIT'] > 0 && $price > $gPrice['DELI_LIMIT'])){
                                    ?>
                                    <li class="prd-label-item free_shipping">무료배송</li>
                                <?}?>
                            </ul>
                        </a>
                    </div>
                </li>
            <?}?>
                <li class="prd-item last-item">
                    <div class="pic">
                        <a href="#">
                            <div class="item auto-img">
                                <div class="img">
                                    <img src="/assets/images/data/prd_item4.jpg" alt="버플리 원목 2700 거실장 세트">
                                </div>
                            </div>
                            <div class="tag-wrap">
                                <span class="circle-tag sale">~<em class="blk">60</em>%</span>
                                <span class="circle-tag class"><em class="blk">공방<br>클래스</em></span>
                            </div>
                        </a>
                    </div>
                    <a href="/goods/search?keyword=<?=$keyword?>&gb=G">
                        <div class="more_bg">
                            <p>검색결과<br>
                                더보기<br>( + )</p>
                        </div>
                    </a>
                </li>
        </ul>
    </div>
    <?}?>
    <!-- // 상품리스트 -->

    <?if($magazine_cnt != 0){?>
    <div class="srp_result_title">
        <h4 class="title-style">매거진<em class="bold_yel">(<?=number_format($magazine_cnt)?>개)</em></h4>
        <a href="/goods/search?keyword=<?=$keyword?>&gb=M" class="btn-more" style="font-size:0.825rem;">
            <span>more</span>
        </a>
    </div>
    <!-- 매거진 리스트 // -->
    <div class="magazine srp_detail">
        <div class="magazine-list">
            <div class="ma_box">
                <div class="prds-list">
                    <ul>
                        <?foreach($magazine as $mrow){?>
                        <li>
                            <a href="/magazine/detail/<?=$mrow['MAGAZINE_NO']?>">
                                <div class="pic">
                                    <div class="item auto-img">
                                        <div class="img land">
                                            <img src="<?=$mrow['IMG_URL']?>" alt="<?=$mrow['TITLE']?>"/>
                                        </div>
                                    </div>
                                    <div class="layer"></div>
                                    <div class="status">
                                        <span class="like"><?=$mrow['LOVE']?></span>
                                        <span class="share"><?=$mrow['SHARE']?></span>
                                        <span class="view">조회 <?=$mrow['HITS']?></span>
                                    </div>
                                    <?if( isset($mrow['END_DT']) && ($mrow['END_DT']<date("Y-m-d H:i:s")) ){?>
                                        <div class="pic_slodout" style="background-color: rgba(0,0,0,0.4);">
                                            <?
                                            $gb = substr($mrow['CATEGORY_CD'],0,1);

                                            if($gb=='4') echo "<p>SOLD OUT</p>";
                                            if($gb=='9') echo "<p>이벤트 종료</p>";
                                            ?>
                                        </div>
                                    <?}?>
                                </div>
                                <div class="txt">
                                    <p class="nm_txt"><?=$mrow['TITLE']?></p>
                                </div>
                            </a>
                        </li>
                        <?}?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?}?>

    <!--// 매거진 리스트 -->
<script>
    //google_gtag
    var viewItem_array = new Object();
    <? $goods_array = array();
    foreach($goods as $key => $grow){
        $goods_array[$key]['id'       ] = $grow['fields']['goods_cd'];
        $goods_array[$key]['name'     ] = $grow['fields']['goods_nm'];
        $goods_array[$key]['list_name'] = 'viewItem_list';
        $goods_array[$key]['brand'] = $grow['fields']['brand_nm'];
        @$gPrice = $arr_price[$grow['fields']['goods_cd']];
        $goods_array[$key]['price'    ] = $gPrice['SELLING_PRICE'] - ($gPrice['RATE_PRICE_S'] + $gPrice['RATE_PRICE_G'] ) - ($gPrice['AMT_PRICE_S'] + $gPrice['AMT_PRICE_G']);
    }
    $goods_array = json_encode($goods_array);?>
    viewItem_array = <?=$goods_array?>;
        console.log(viewItem_array);
    gtag('event', 'view_item_list', {
        "items": viewItem_array
    });
</script>
