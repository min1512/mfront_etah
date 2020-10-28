<?
//구매제한 관련 기능 추가 201800115 이진호
//	setcookie('limit_cd', $goods['GOODS_CD'], time() + 86400);

//if($goods['limit_cd'] !='NONE'){
$cookieGoodsCd = get_cookie("limit_cd");

//}

if($goods['BUY_LIMIT_QTY'] !='0'){
    $buyMaxCnt = $goods['BUY_LIMIT_QTY'];
}else{
    $buyMaxCnt = 10000;
}

?>


<link rel="stylesheet" href="/assets/css/vip.css?ver=1.4.3">

<!-- WIDERPLANET  SCRIPT START 2017.3.29 -->
<div id="wp_tg_cts" style="display:none;"></div>
<script type="text/javascript">
    var wptg_tagscript_vars = wptg_tagscript_vars || [];
    wptg_tagscript_vars.push(
        (function() {
            return {
                wp_hcuid:"",     /*Cross device targeting을 원하는 광고주는 로그인한 사용자의 Unique ID (ex. 로그인 ID, 고객넘버 등)를 암호화하여 대입.
										*주의: 로그인 하지 않은 사용자는 어떠한 값도 대입하지 않습니다.*/
                ti:"35025",
                ty:"Item",
                device:"mobile"
                ,items:[{i:"<?=$goods['GOODS_CD']?>",      t:"<?=$goods['GOODS_NM']?>"}] /* i:상품 식별번호 (Feed로 제공되는 식별번호와 일치하여야 합니다.) t:상품명 */
            };
        }));
</script>
<script type="text/javascript" async src="//cdn-aitg.widerplanet.com/js/wp_astg_4.0.js"></script>
<!-- // WIDERPLANET  SCRIPT END 2017.3.29 -->


<div class="content">
    <!-- 상품정보 form 시작 -->
    <!-- Google Tag Manager Variable (eMnet) 2018.05.29-->
    <script>
        var brandIds = [];
        brandIds.push('<?=$goods['GOODS_CD']?>');
    </script>
    <!-- End Google Tag Manager Variable (eMnet) -->
    <form id="goods_form" name="goods_form" method="post">

        <input type="hidden" id="cust_no"			name="cust_no"			value="<?=$this->session->userdata('EMS_U_NO_')?>">
        <input type="hidden" id="goods_code"				name="goods_code"				value="<?=$goods['GOODS_CD']?>">
        <input type="hidden" id="goods_name"				name="goods_name"				value="<?=$goods['GOODS_NM']?>">
        <input type="hidden" id="goods_img"					name="goods_img"				value="<?=$goods['IMG_URL']?>">
        <input type="hidden" id="goods_mileage_save_rate"	name="goods_mileage_save_rate"	value="<?=$goods['GOODS_MILEAGE_SAVE_RATE']?>">
        <input type="hidden" id="goods_price_code"			name="goods_price_code"			value="<?=$goods['GOODS_PRICE_CD']?>">
        <input type="hidden" id="goods_selling_price"		name="goods_selling_price"		value="<?=$goods['SELLING_PRICE']?>">
        <input type="hidden" id="goods_street_price"		name="goods_street_price"		value="<?=$goods['STREET_PRICE']?>">
        <input type="hidden" id="goods_factory_price"		name="goods_factory_price"		value="<?=$goods['FACTORY_PRICE']?>">
        <input type="hidden" id="goods_state"				name="goods_state"				value="<?=$goods['GOODS_STATE_CD']?>">
        <input type="hidden" id="brand_code"				name="brand_code"				value="<?=$goods['BRAND_CD']?>">
        <input type="hidden" id="brand_name"				name="brand_name"				value="<?=$goods['BRAND_NM']?>">
        <input type="hidden" id="goods_buy_limit_qty"       name="goods_buy_limit_qty"		value="<?=$goods['BUY_LIMIT_QTY']?>"> <!--구매제한 수량-->
        <input type="hidden" id="goods_tax_gb_cd"           name="goods_tax_gb_cd"		    value="<?=$goods['TAX_GB_CD']?>"> <!--과세 구분-->
        <input type="hidden" id="goods_discount_price"		name="goods_discount_price"		value="<?=$goods['COUPON_PRICE'] != 0 ? $goods['SELLING_PRICE'] - $goods['COUPON_PRICE'] : 0?>">
        <!-- value :: 쿠폰코드||쿠폰타입||쿠폰할인율(액)||최대할인액 -->
        <input type="hidden" id="goods_coupon_code_s"			name="goods_coupon_code_s"	value="<?=isset($goods['SELLER_COUPON_CD']) ? $goods['SELLER_COUPON_CD']."||".$goods['SELLER_COUPON_METHOD']."||".($goods['SELLER_COUPON_METHOD']=='RATE' ? $goods['SELLER_COUPON_FLAT_RATE'] : $goods['SELLER_COUPON_FLAT_AMT'])."||".$goods['SELLER_COUPON_MAX_DISCOUNT'] : ""?>">
        <?
        $seller_coupon_amt = 0;
        if(isset($goods['SELLER_COUPON_CD'])){
            if($goods['SELLER_COUPON_METHOD'] == 'RATE'){
                $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods['SELLER_COUPON_FLAT_RATE']/1000);
            } else if($goods['SELLER_COUPON_METHOD'] == 'AMT'){
                $seller_coupon_amt = $goods['SELLER_COUPON_FLAT_AMT'];
            }

            if($seller_coupon_amt > $goods['SELLER_COUPON_MAX_DISCOUNT'] && $goods['SELLER_COUPON_MAX_DISCOUNT'] != 0){
                $seller_coupon_amt = $goods['SELLER_COUPON_MAX_DISCOUNT'];
            }
        }

        $item_coupon_amt = 0;
        if(isset($goods['ITEM_COUPON_CD'])){
            if($goods['ITEM_COUPON_METHOD'] == 'RATE'){
                $item_coupon_amt = $goods['SELLING_PRICE'] * ($goods['ITEM_COUPON_FLAT_RATE']/1000);
            } else if($goods['ITEM_COUPON_METHOD'] == 'AMT'){
                $item_coupon_amt = $goods['ITEM_COUPON_FLAT_AMT'];
            }

            if($item_coupon_amt > $goods['ITEM_COUPON_MAX_DISCOUNT'] && $goods['ITEM_COUPON_MAX_DISCOUNT'] != 0){
                $item_coupon_amt = $goods['ITEM_COUPON_MAX_DISCOUNT'];
            }
        }
        ?>

        <input type="hidden" id="goods_coupon_amt_s"			name="goods_coupon_amt_s"		value="<?=$seller_coupon_amt?>">	<!--쿠폰금액 (수량 합 미포함)-->
        <input type="hidden" id="goods_coupon_code_i"			name="goods_coupon_code_i"		value="<?=isset($goods['ITEM_COUPON_CD']) ? $goods['ITEM_COUPON_CD']."||".$goods['ITEM_COUPON_METHOD']."||".($goods['ITEM_COUPON_METHOD']=='RATE' ? $goods['ITEM_COUPON_FLAT_RATE'] : $goods['ITEM_COUPON_FLAT_AMT'])."||".$goods['ITEM_COUPON_MAX_DISCOUNT'] : ""?>">
        <input type="hidden" id="goods_coupon_amt_i"			name="goods_coupon_amt_i"		value="<?=$item_coupon_amt?>">
        <input type="hidden" id="deli_policy_no"			name="deli_policy_no"			value="<?=$goods['DELIV_POLICY_NO']?>">
        <input type="hidden" id="deli_limit"				name="deli_limit"				value="<?=$goods['DELI_LIMIT']?>">
        <input type="hidden" id="deli_cost"					name="deli_cost"				value="<?=$goods['DELI_COST']?>">
        <input type="hidden" id="deli_code"					name="deli_code"				value="<?=$goods['DELI_CODE']?>">
        <input type="hidden" id="goods_cate_code1"			name="goods_cate_code1"				value="<?=$goods['CATEGORY_MNG_CD1']?>">
        <input type="hidden" id="goods_cate_code2"			name="goods_cate_code2"				value="<?=$goods['CATEGORY_MNG_CD2']?>">
        <input type="hidden" id="goods_cate_code3"			name="goods_cate_code3"				value="<?=$goods['CATEGORY_MNG_CD3']?>">
        <input type="hidden" id="goods_deliv_pattern_type"	name="goods_deliv_pattern_type"	value="<?=$goods['PATTERN_TYPE_CD']?>">
        <input type="hidden" id="guest_gb" name="guest_gb" value="">		<!-- 비회원 구매시 바로구매인지 장바구니구매인지 -->
        <input type="hidden" id="send_nation" name="send_nation" value="<?=$goods['SEND_NATION']?>">	<!--출고국가-->
        <!-- 옵션 선택에 대한 값들을 가져옴 -->
        <div id="goods_option_value_section"></div>
    </form>	<!--상품폼 닫기-->
    <!--		</div>-->

    <!-- vip banner // -->
    <!--		<div  id="INFO" class="vip-prd-top position-area">-->
    <!--            <h2 class="vip-prd-title position-left">--><?//=$goods['BRAND_NM']?><!--</h2>-->
    <!--            <a href="--><?//=$returnUrl?><!--" class="vip-prd-back-btn"><span class="hide">뒤로가기</span></a>-->
    <!--            <div class="vip-prd-navi position-right">-->
    <!--                <ul>-->
    <!--                    <li><a href="/">홈</a></li>-->
    <!--                    <li><a href="javascript:search_goods('C', '--><?//=$goods['CATEGORY_MNG_CD1']?><!--');">--><?//=$goods['CATEGORY_MNG_NM1']?><!--</a></li>-->
    <!--                    <li><a href="javascript:search_goods('C', '--><?//=$goods['CATEGORY_MNG_CD2']?><!--');">--><?//=$goods['CATEGORY_MNG_NM2']?><!--</a></li>-->
    <!--                    <li><a href="#" class="active">--><?//=$goods['CATEGORY_MNG_NM3']?><!--</a></li>-->
    <!--                </ul>-->
    <!--            </div>-->
    <!--		</div>-->
    <!-- vip banner // -->
    <div class="vip-prd-top position-area">

        <div class="vip-prd-navi position-right">
            <ul>
                <li><a href="/">홈</a></li>
                <li><a href="javascript:search_goods('C', '<?=$goods['CATEGORY_MNG_CD1']?>');"><?=$goods['CATEGORY_MNG_NM1']?></a></li>
                <li><a href="javascript:search_goods('C', '<?=$goods['CATEGORY_MNG_CD2']?>');"><?=$goods['CATEGORY_MNG_NM2']?></a></li>
                <li><a href="javascript:search_goods('C', '<?=$goods['CATEGORY_MNG_CD3']?>')" class="active"><?=$goods['CATEGORY_MNG_NM3']?></a></li>
            </ul>
        </div>
    </div>

    <div class="main-banner main-banner--vip">
        <ul class="main-banner-list  owl-carousel" id="bannerList">
            <? $i = 0;
            foreach($img as $row){
                if($row != ''){?>
                    <li class="main-banner-item" <?if($i==0){?>style="z-index: 1"<?}?>>
                        <img src="<?=$row['IMG_URL']?>" alt="">
                    </li>
                <?		}
            }
            $i++;
            ?>
        </ul>
    </div>
    <!-- // vip banner -->

    <?
    $i = 0;
    $total_grade		= 0;	//전체 평점
    $tot_grade_val01	= 0;	//품질 평점 합산
    $tot_grade_val02	= 0;	//배송 평점 합산
    $tot_grade_val03	= 0;	//가격 평점 합산
    $tot_grade_val04	= 0;	//디자인 평점 합산
    $total_goods_grade	= 0;	//품질+배송+가격+디자인 평점 합산
    $grade_val01		= 0;	//품질 평점
    $grade_val02		= 0;	//배송 평점
    $grade_val03		= 0;	//가격 평점
    $grade_val04		= 0;	//디자인 평점

    foreach($total_comment_val as $row){
        $grade_val01 += $row['GRADE_VAL01'];
        $grade_val02 += $row['GRADE_VAL02'];
        $grade_val03 += $row['GRADE_VAL03'];
        $grade_val04 += $row['GRADE_VAL04'];
        $total_goods_grade += $row['TOTAL_GRADE_VAL'];
        $i++;
    }
    @$tot_grade_val01 = $grade_val01/$i*20;
    @$tot_grade_val02 = $grade_val02/$i*20;
    @$tot_grade_val03 = $grade_val03/$i*20;
    @$tot_grade_val04 = $grade_val04/$i*20;
    @$total_grade = $total_goods_grade/(5*$i)*100;
    ?>

    <div class="vip-prd-info">
        <div class="vip_prd_code"><span>상품번호 : <?=$goods['GOODS_CD']?></span></div>
        <h3 class="vip-prd-info-name"><?=$goods['GOODS_STATE_CD'] != '03' ? "<font color=\"red\"><b>[".$goods['GOODS_STATE']."]</b></font>" : "" ?>[<?=$goods['BRAND_NM']?>]<?=$goods['GOODS_NM']?></h3>
        <div class="star-grade-box">
            <span class="star-rating spr-common"><span class="star-ico spr-common" style="width:<?=$goods['TOTAL_GRADE_VAL']*20?>%"></span></span>
        </div>
        <? if(isset($goods['SELLER_COUPON_CD']) || isset($goods['ITEM_COUPON_CD']))	{ //할인가가 있을경우
            $sale_percent = (($goods['SELLING_PRICE'] - $goods['COUPON_PRICE'])/$goods['SELLING_PRICE']*100);
            $sale_percent = strval($sale_percent);
            $sale_percent_array = explode('.',$sale_percent);
            $sale_percent_string = $sale_percent_array[0];
            ?>
            <div class="prd-item-price">
                <?=number_format($goods['COUPON_PRICE'])?><span class="won">원</span><br>
                <del class="del-price"><?=number_format($goods['SELLING_PRICE'])?><span class="won">원</span></del>
                <!--<span class="dc-rate">(<?=floor(($goods['SELLING_PRICE'] - $goods['COUPON_PRICE'])/$goods['SELLING_PRICE']*100) == 0 ? 1 : floor(($goods['SELLING_PRICE'] - $goods['COUPON_PRICE'])/$goods['SELLING_PRICE']*100)?>%<span class="spr-common ico-arrow-down"></span>)</span>-->
                <span class="dc-rate"><?=floor(($goods['SELLING_PRICE'] - $goods['COUPON_PRICE'])/$goods['SELLING_PRICE']*100) == 0 ? 1 : $sale_percent_string?>%</span>
                <!--				<span class="btn-white icon-coupon">쿠폰할인</span>-->
                <?if(!empty($goods['DEAL'])){?>
                    <span class="btn-yellow2">특가</span>
                <?}?>
            </div>
        <? } //END IF
        else {	//없을경우 판매가 보여주기
            $sale_percent_string = '';
            ?>
            <div class="prd-item-price" style="margin-bottom: 0.3rem;">
                <?=number_format($goods['SELLING_PRICE'])?><span class="won">원</span><br><br>
            </div>
        <? }?>

        <ul class="prd-bookmark">
            <li class="prd-bookmark-item"><a href="javascript:;" onClick="javaScript:jsGoodsAction('W','','<?=$goods['GOODS_CD']?>','','');" class="prd-bookmark-link <?=@$goods['INTEREST_GOODS_NO']?'active':''?>"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
            <!-- 활성화시 클래스 active 추가 -->
            <li class="prd-bookmark-item">
                <a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open" onClick="javaScript:openShareLayer('G', '<?=$goods['GOODS_CD']?>', '<?=$goods['IMG_URL']?>', '<?=$goods['GOODS_NM']?>', '<?=$goods['COUPON_PRICE']?>|<?=$goods['SELLING_PRICE']?>|<?=$sale_percent_string?>');">
                    <span class="ico-share spr-common"></span><span class="hide">공유하기</span>
                </a>
            </li>
        </ul>

    </div>

    <!-- 제조사/브랜드, 배송가능지역, 배송비// -->
    <div class="basic-table-wrap vip-prd-info-table">
        <table class="basic-table">
            <colgroup>
                <col style="width:32%;">
                <col>
            </colgroup>
            <? if($goods['GOODS_MILEAGE_SAVE_RATE']){	?>
                <tr>
                    <th scope="row" class="tb-info-title">마일리지 적립액</th>
                    <td class="tb-info-txt"><?=number_format($goods['SELLING_PRICE']*($goods['GOODS_MILEAGE_SAVE_RATE']/1000))?></td>
                </tr>
            <? }?>
            <tr>
                <th scope="row" class="tb-info-title">배송비</th>
                <td class="tb-info-txt btn-wrap">
                    <ul class="prd-label-list">
                        <? if($goods['PATTERN_TYPE_CD'] == 'PRICE') {
                            if($goods['DELI_LIMIT'] > 0){	?>
                                <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_LIMIT']>$goods['COUPON_PRICE'] ? $goods['DELI_COST'] : 0 ?>">
                                <li><?=$goods['DELI_LIMIT']>$goods['COUPON_PRICE'] ? number_format($goods['DELI_COST'])."원 (".number_format($goods['DELI_LIMIT'])."원 이상 무료배송)" : "<li class=\"prd-label-item free_shipping\">무료배송</li>"?></li>
                            <? } else {
                                if($goods['DELI_COST'] != 0){	?>
                                    <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_COST']?>">
                                    <li><?=number_format($goods['DELI_COST'])."원"?></li>
                                <? } else {	?>
                                    <li><li class="prd-label-item free_shipping">무료배송</li>(배송비 유,무/배송표 필 참조)</li>
                                <?}
                            }
                        } //END PATTERN_TYPE_CD == PRICE
                        else if($goods['PATTERN_TYPE_CD'] == 'STATIC'){	?>
                            <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="<?=$goods['DELI_COST']?>">
                            <li><?=number_format($goods['DELI_COST'])."원"?></li>
                        <?  } //END PATTERN_TYPE_CD == STATIC
                        else if($goods['PATTERN_TYPE_CD'] == 'FREE'){		?>
                            <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="0">
                            <li><li class="prd-label-item free_shipping">무료배송</li>(배송비 유,무/배송표 필 참조)</li>
                        <?  } //END PATTERN_TYPE_CD == FREE
                        else if($goods['PATTERN_TYPE_CD'] == 'NONE'){		?>
                            <input type="hidden" id="goods_delivery_price" name="goods_delivery_price" value="0">
                            <li>착불 (상품상세설명참조)</li>
                        <? }?>
                        <!--		서울&#47;경기 무료배송<br>지방 및 경기외곽은 배송비가 발생할 수 있습니다.<br> (경기외곽 5,000원 &#47; 지방 10,000원)	-->
                        <? if( ($goods['PATTERN_TYPE_CD'] == 'PRICE' || $goods['PATTERN_TYPE_CD'] == 'FREE') && $goods['PACKED_DELI'] == 'Y'){	?>
                            <li><a href="/goods/bundle_delivery/<?=$goods['GOODS_CD']?>" class="btn-gray bundle-shipping">묶음배송 가능상품</a></li>
                        <? }?>
                    </ul>
                </td>
            </tr>
            <?if($goods['CATEGORY_MNG_CD2'] == 24010000){?>
                <tr>
                    <th scope="row" class="tb-info-title">장르</th>
                    <td class="tb-info-txt"><?=$goods['CLASS_TYPE']?> 클래스</td>
                </tr>
                <tr>
                    <th scope="row" class="tb-info-title">위치</th>
                    <td class="tb-info-txt"><?=$goods['ADDRESS']?></td>
                </tr>
                <tr>
                    <th scope="row" class="tb-info-title">기간</th>
                    <td class="tb-info-txt"><?=substr($goods['START_DT'],0,10)?> ~ <?=substr($goods['END_DT'],0,10)?></td>
                </tr>
            <?}?>
        </table>
    </div>
    <!-- //제조사/브랜드, 배송가능지역, 배송비 -->

    <!-- 브랜드관 바로가기 -->
    <div class="vip-prd-brand">
        <?if($goods['MOB_DISP_YN'] == 'Y'){	?>
            <a href="/goods/brand/<?=$goods['BRAND_CD']?>" class="btn_brand_shop"><?=$goods['BRAND_NM']?> 브랜드관<span class="spr-common spr-triangle_white_02"></span></a>
        <?}?>
    </div>

    <?if(count($tag)!=0){?>
        <div class="vip-prd-hashtag">
            <h3 class="info-title">연관태그</h3>
            <div class="hashtag">
                <?foreach($tag as $trow){?>
                    <a href="/goods/search?keyword=<?=$trow['TAG_NM']?>&gb=T&tag_keyword=<?=$trow['TAG_NM']?>">#<?=$trow['TAG_NM']?></a>
                <?}?>
            </div>
        </div>
    <?}?>

    <div class="vip-event-banenr">
        <h3 class="info-title">에타 이벤트</h3>
        <a href="<?=$event[0]['BANNER_LINK_URL']?>"><img src="<?=$event[0]['BANNER_IMG_URL']?>" alt=""></a><br /><br />
        <a href="<?=$event[1]['BANNER_LINK_URL']?>"><img src="<?=$event[1]['BANNER_IMG_URL']?>" alt=""></a>
    </div>

    <!-- 상품상세, 상품평, 상품문의, 배송정보, 교환/환불 정보 // -->
    <div class="tab-vip-wrap tabs goods-tabs">
        <!-- tab영역// -->
        <ul class="tab-vip-list">
            <li class="tab-vip-btn active"><a href="#prdImg" class="vip-btn-link" data-ui="btn-tab">상품정보</a></li>
            <li class="tab-vip-btn"><a href="#prdRecommend" class="vip-btn-link" data-ui="btn-tab">추천</a></li>
            <li class="tab-vip-btn"><a href="#prdComment" class="vip-btn-link" data-ui="btn-tab">상품평<?if($cmt_total!=0){?><b style="color:#3A3A3A"><?}?>(<?=$cmt_total?>)<?if($cmt_total!=0){?></b><?}?></a></li>
            <li class="tab-vip-btn"><a href="#prdInquiry" class="vip-btn-link" data-ui="btn-tab">상품문의<?if($qna_total!=0){?><b style="color:#3A3A3A"><?}?>(<?=$qna_total?>)<?if($qna_total!=0){?></b><?}?></a></li>
        </ul>
        <!-- //tab영역 -->


        <!-- 상품정보// -->
        <div id="prdImg" class="vip-tab-cont func1">
            <h3 class="info-title">상품정보</h3>

            <?if(count($mdTalk) != 0){?>
                <div class="vip-md-ment">
                    <h3 class="vip-md-ment-title">MD 추천멘트</h3>
                    <div class="vip-md-ment-contents">
                        <?foreach($mdTalk as $mrow){?>
                            <?if($mrow['GOODS_DESC_MD_GB_CD']=='TEXT'){?>
                                <p style="font-size: 0.9rem"><?=nl2br($mrow['HEADER_DESC'])?></p>
                            <?}?>
                            <?if($mrow['GOODS_DESC_MD_GB_CD']=='VIDEO'){?>
                                <div style="position: relative; padding-top: 56%;">
                                    <iframe src="https://www.youtube.com/embed/<?=$mrow['HEADER_DESC']?>" frameborder="0" style="position: absolute; top: 0; left: 0; width: 100%;height: 100%;"></iframe>
                                </div>
                            <?}?>
                            <?if($mrow['GOODS_DESC_MD_GB_CD']=='IMAGE'){?>
                                <br><img width="100%" src="<?=$mrow['HEADER_DESC']?>" />
                            <?}?>
                        <?}?>
                    </div>
                </div>
            <?}?>

            <!-- 업체 공지 이미지// -->
            <?if( !empty($goods_desc[0]['SUBVENDOR_NOTICE']) ){?>
                <p><img alt="" src="<?=$goods_desc[0]['SUBVENDOR_NOTICE']?>" /></p>
            <?}?>
            <!-- //업체 공지 이미지 -->

            <div class="folding-area">
                <div class="folding-area-bler"></div>
                <div class="vip-prd-detail-img">
                    <?if($goods_desc[0]['TEMPLATE_GB_CD']){?>
                        <?	foreach($goods_desc as $row){?>
                            <?if($row['NOTICE_IMG_URL'] != null){?>
                                <img src="<?=$row['NOTICE_IMG_URL']?>">
                            <?}?>
                            <img src="<?=$row['TITLE_IMG_URL']?>" />
                        <?	}?>

                        <!--                            <p style="font-size: large"><b>--><?//=$goods_desc[0]['BRAND_NM']?><!--</b></p><br/>-->
                        <!--                            --><?//	foreach($img as $erow){
//                                if($erow['TYPE_CD'] == 'TITLE'){?>
                        <!--                                    <div class="vip_banner_info_img"><img src="--><?//=$erow['IMG_URL']?><!--" alt="" /></div>-->
                        <!--                                --><?//}
//                            }?>
                    <?}?>

                    <?	foreach($goods_desc as $row){
                        if($row['GOODS_DESC_BLOG_GB_CD'] == 'IMG'){	?>
                            <div class="vip_banner_info_img"><img src="<?=$row['HEADER_DESC']?>" alt="" /></div>
                        <? } else if($row['GOODS_DESC_BLOG_GB_CD'] == 'TEXT'){	?>
                            <p class="vip_banner_info_text"><?=$row['HEADER_DESC']?></p>
                        <? } else if($row['GOODS_DESC_BLOG_GB_CD'] == 'HTML'){	?>
                            <?=$row['HEADER_DESC']?>
                        <? } else if($row['GOODS_DESC_BLOG_GB_CD'] == 'VIDEO'){?>
                            <div style="position: relative; padding-top: 56%;">
                                <iframe src="https://www.youtube.com/embed/<?=$row['HEADER_DESC']?>" frameborder="0" style="position: absolute; top: 0; left: 0; width: 100%;height: 100%;"></iframe>
                            </div>
                        <? }?>
                    <?	}?>
                    <br/>

                    <?if($goods_desc[0]['TEMPLATE_GB_CD']){?>

                        <?	foreach($img as $erow2){
                            if($erow2['TYPE_CD'] != 'TITLE'){?>
                                <!--                                    <div class="vip_banner_info_img">-->
                                <img src="<?=$erow2['IMG_URL']?>" alt="" />
                                <!--                                    </div>-->
                            <?}
                        }?>

                        <?	foreach($goods_desc as $row){?>
                            <!--                                <div align="center">-->
                            <img src="<?=$row['DELIV_IMG_URL']?>" />
                            <!--                                </div>-->
                        <?	}?>
                    <?}?>
                    <br/>

                    <?if($goods['VENDOR_SUBVENDOR_CD']==10240){?>
                        <div class="evt_contents7">
                            <img src="/assets/images/data/m_kluft_reservation_page_MO.jpg" alt="" />
                        </div>
                        <div onClick="javascript:jsReservationLayer('<?= $goods['GOODS_CD']?>');" style="cursor:pointer;"><img src="/assets/images/data/btn_kluft_m.png" alt="" /></div>
                    <?}?>
                </div>

                <!-- 상품/거래조건 기본정보// -->
                <?	if(isset($goods_extend_info)){	?>
                    <h3 class="info-title">상품&#47;거래조건 기본정보</h3>
                    <div class="basic-table-wrap basic-table-wrap--title-bg vip-prd-basic-info">
                        <table class="basic-table">
                            <colgroup>
                                <col style="width:55%;">
                                <col style="width:45%;">
                            </colgroup>
                            <?  $idx=0;
                            foreach($goods_extend_info as $row){	?>
                                <tr>
                                    <th scope="row" class="tb-info-title"><?=$row['branch_name']?></th>
                                    <td class="tb-info-txt"><?=$goods_extend['article'.$idx]?></td>
                                </tr>
                                <? $idx++;
                            }?>
                        </table>
                    </div>
                <? }	//END IF?>
                <!-- //상품/거래조건 기본정보 -->

                <!-- 배송정보// -->
                <h3 class="info-title">배송정보</h3>
                <div class="basic-table-wrap">
                    <table class="basic-table">
                        <colgroup>
                            <col style="width:20%;">
                            <col style="width:80%;">
                        </colgroup>
                        <tr>
                            <th scope="row" class="tb-info-title">배송방법</th>
                            <td class="tb-info-txt"><?=$goods['DELIV_COMPANY_CD'] == '99' ? $goods['BRAND_NM']." 브랜드는 직접 배송을 원칙으로 합니다." : $goods['DELIV_COMPANY_NM']?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="tb-info-title">배송지역</th>
                            <td class="tb-info-txt"> <?
                                $ints = 203174;
                                if($goods['DELIV_POLICY_NO'] == $ints){?>
                                    서울/경기<?=/*$goods_no_deli[0]['DELIV_AREA_CD'] == true*/ isset($goods_no_deli) ? "(도서/일부 지역은 배송이 불가능 합니다.)" : ""?>
                                <?}else{?>
                                    전국<?=/*$goods_no_deli[0]['DELIV_AREA_CD'] == true*/ isset($goods_no_deli) ? "(도서/일부 지역은 배송이 불가능 합니다.)" : ""?>
                                <?}?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="tb-info-title">배송비용</th>
                            <td class="tb-info-txt">
                                <? $i=0;
                                if(@$goods_add_deli){
                                    foreach($goods_add_deli as $row){
                                        if($i==0){
                                            if($goods['PATTERN_TYPE_CD'] == 'PRICE'){
                                                if($goods['DELI_LIMIT'] > 0){
                                                    if($goods['DELI_LIMIT']>$goods['COUPON_PRICE']){
                                                        $DELI_COST = $goods['DELI_COST'];	?>
                                                        <?=number_format($goods['DELI_COST'])."원 (".number_format($goods['DELI_LIMIT'])."원 이상 무료배송)"?>
                                                    <?		} else {
                                                        $DELI_COST = 0;	?>
                                                        무료배송(배송비 유,무/배송표 필 참조)
                                                    <?		}
                                                } else {
                                                    if($goods['DELI_COST'] != 0){
                                                        $DELI_COST = $goods['DELI_COST'];	?>
                                                        <?=number_format($goods['DELI_COST'])."원"?>
                                                    <?  } else {
                                                        $DELI_COST = 0;	?>
                                                        무료배송(배송비 유,무/배송표 필 참조)
                                                    <? }
                                                }
                                            } //END PATTERN_TYPE_CD == PRICE
                                            else if($goods['PATTERN_TYPE_CD'] == 'STATIC'){
                                                $DELI_COST = $goods['DELI_COST'];	?>
                                                <?=number_format($goods['DELI_COST'])."원"?>
                                            <?  } //END PATTERN_TYPE_CD == STATIC
                                            else if($goods['PATTERN_TYPE_CD'] == 'FREE'){
                                                $DELI_COST = 0;	?>
                                                무료배송(배송비 유,무/배송표 필 참조)
                                            <?  } //END PATTERN_TYPE_CD == FREE
                                            else if($goods['PATTERN_TYPE_CD'] == 'NONE'){
                                                $DELI_COST = 0;	?>
                                                착불 (상품상세설명참조)
                                            <? }
                                        }
                                        if(isset($row['DELIV_AREA_CD'])){	?>
                                            &#47; <?=$row['DELIV_AREA_NM']?> - <!--<?=number_format($row['ADD_DELIV_COST']+$DELI_COST)?>원	-->
                                            <?=number_format($row['ADD_DELIV_COST'])?>원 추가
                                        <? }?>

                                        <?	$i++;
                                    }
                                } else {
                                    if($goods['PATTERN_TYPE_CD'] == 'PRICE'){
                                        if($goods['DELI_LIMIT'] > 0){
                                            if($goods['DELI_LIMIT']>$goods['COUPON_PRICE']){
                                                $DELI_COST = $goods['DELI_COST'];	?>
                                                <?=number_format($goods['DELI_COST'])."원 (".number_format($goods['DELI_LIMIT'])."원 이상 무료배송)"?>
                                            <?		} else {
                                                $DELI_COST = 0;	?>
                                                무료배송(배송비 유,무/배송표 필 참조)
                                            <?		}
                                        } else {
                                            if($goods['DELI_COST'] != 0){
                                                $DELI_COST = $goods['DELI_COST'];	?>
                                                <?=number_format($goods['DELI_COST'])."원"?>
                                            <?  } else {
                                                $DELI_COST = 0;	?>
                                                무료배송(배송비 유,무/배송표 필 참조)
                                            <? }
                                        }
                                    } //END PATTERN_TYPE_CD == PRICE
                                    else if($goods['PATTERN_TYPE_CD'] == 'STATIC'){
                                        $DELI_COST = $goods['DELI_COST'];	?>
                                        <?=number_format($goods['DELI_COST'])."원"?>
                                    <?  } //END PATTERN_TYPE_CD == STATIC
                                    else if($goods['PATTERN_TYPE_CD'] == 'FREE'){
                                        $DELI_COST = 0;	?>
                                        무료배송(배송비 유,무/배송표 필 참조)
                                    <?  } //END PATTERN_TYPE_CD == FREE
                                    else if($goods['PATTERN_TYPE_CD'] == 'NONE'){
                                        $DELI_COST = 0;	?>
                                        착불 (상품상세설명참조)
                                    <? }
                                }?>
                                <? if(@$goods_no_deli){
                                    foreach($goods_no_deli as $row){
                                        if(isset($row['DELIV_AREA_CD'])){	?>
                                            &#47; <?=$row['DELIV_AREA_NM']?> - 배송 불가
                                        <?		}
                                    }
                                }?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="tb-info-title">배송안내</th>
                            <td class="tb-info-txt">상품페이지에 배송비(지역별 추가 배송비 등) 및 배송가능지역에 관한 브랜드 기준이 있는 경우에는 해당 내용이 우선 적용되오니, 상품상세페이지 내용을 반드시 확인해 주십시오.<br> (특히, 가구 등의 상품은 지역에 따라 배송제한 및 추가 배송비용이 착불로 발생할 수 있습니다.)<br><br> 차량의 이동이 어려운 일부 도서지역 및 제주도는 배송이 불가할 수도 있으니 반드시 상담 후 주문해 주시길 바랍니다.<br><br> 배송 시 연락처
                                오기재 및 주소 불분명, 그리고 수취인 부재 시 배송이 지연될 수 있습니다.<br><br> 사다리차 및 엘리베이터 사용 시 발생하는 비용 및 단순변심에 의한 반품&#47;교환 왕복배송비는 고객님께서 부담해주셔야 합니다.
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- //배송정보 -->

                <!-- 교환/환불// -->
                <h3 class="info-title">반품/환불</h3>
                <div class="basic-table-wrap">
                    <table class="basic-table">
                        <colgroup>
                            <col style="width:20%;">
                            <col style="width:80%;">
                        </colgroup>
                        <tr>
                            <th scope="col" class="tb-info-title">지정택배사</th>
                            <td class="tb-info-txt"><?=$goods['DELIV_COMPANY_NM']?></td>
                        </tr>
                        <tr>
                            <th scope="row" class="tb-info-title">교환배송비</th>
                            <td class="tb-info-txt">
                                <? if($goods['VENDOR_SUBVENDOR_CD'] == '3782'){ //[3782]지이라이프	?>
                                    배송비 : 3만원 미만 5000원 - 한진<br/>
                                    반품배송비 : 고객센터 (1522-5572)로 문의주세요
                                <? } else if($goods['PATTERN_TYPE_CD'] != 'NONE'){	?>
                                    <?=number_format($goods['RETURN_DELIV_COST'])?>원 (편도)
                                <? } else {	?>
                                    고객센터(<?=$goods['VENDOR_SUBVENDOR_TEL']?>)로 문의해주세요.
                                <? }?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="tb-info-title">보내실 곳</th>
                            <td class="tb-info-txt">
                                (<?=strlen($goods['RETURN_ZIPCODE'])==6 ? substr($goods['RETURN_ZIPCODE'],0,3)."-".substr($goods['RETURN_ZIPCODE'],3,3) : $goods['RETURN_ZIPCODE']?>) <?=$goods['RETURN_ADDR']?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row" class="tb-info-title">교환안내</th>
                            <td class="tb-info-txt">
                                상품페이지에 반품&#47;환불&#47;AS에 관한 브랜드 기준이 있는 경우에는 해당 내용이 본 항목을 우선하여 적용됩니다.<br><br> 반품 신청은 배송완료 후 7일 이내 가능합니다.<br><br>변심 반품의 경우 왕복배송비를 차감한 금액이 환불되며, 제품 및 포장 상태가 재판매 가능하여야 합니다. (상품 불량인 경우는 배송비를 포함한 전액이 환불됩니다.)<br><br> 출고 이후 환불요청 시 상품 회수 후 처리됩니다.<br><br>주문제작상품은
                                변심으로 인한 반품&#47;환불이 불가합니다.
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- //교환/환불 -->
            </div>
            <button class="btn-prd-view-more">상품정보 더보기</button>
        </div>
        <!-- //상품정보 -->

        <!-- 추천// -->
        <div id="prdRecommend" class="vip-tab-cont func1">
            <!-- 이 카테고리 베스트 상품 // -->
            <h3 class="info-title">이 카테고리 베스트 상품</h3>
            <div class="prd-list-wrap">
                <ul class="prd-list prd-list--main owl-carousel owl-dot2">
                    <?foreach($category_goods as $crow){?>
                        <li class="prd-item">
                            <div class="pic">
                                <a href="/goods/detail/<?=$crow['GOODS_CD']?>">
                                    <div class="item auto-img">
                                        <div class="img">
                                            <img src="<?=$crow['IMG_URL']?>" alt="">
                                        </div>
                                    </div>
                                    <div class="tag-wrap">
                                        <?if(!empty($crow['DEAL'])){?>
                                            <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                        <?}?>
                                        <?if($crow['CLASS_GUBUN']=='C'){?>
                                            <!--<span class="circle-tag class"><em class="blk">공방<br>클래스</em></span>-->
                                        <?}?>
                                        <?if($crow['CLASS_GUBUN']=='G'){?>
                                            <!--<span class="circle-tag class"><em class="blk">공방<br>제작상품</em></span>-->
                                        <?}?>
                                    </div>
                                </a>
                            </div>
                            <div class="prd-info-wrap">
                                <a href="/goods/detail/<?=$crow['GOODS_CD']?>">
                                    <dl class="prd-info">
                                        <dt class="prd-item-brand"><?=$crow['BRAND_NM']?></dt>
                                        <dd class="prd-item-tit"><?=$crow['GOODS_NM']?></dd>
                                        <dd class="prd-item-price">
                                            <?if($crow['COUPON_CD']){
                                                $price = $crow['SELLING_PRICE'] - ($crow['RATE_PRICE']) - ($crow['AMT_PRICE']);
                                                echo number_format($price);
                                                $sale_percent = (($crow['SELLING_PRICE'] - $price)/$crow['SELLING_PRICE']*100);
                                                $sale_percent = strval($sale_percent);
                                                $sale_percent_array = explode('.',$sale_percent);
                                                $sale_percent_string = $sale_percent_array[0];
                                                ?><span class="won"> 원</span><br>
                                                <del class="del-price"><?=number_format($crow['SELLING_PRICE'])?>원</del>
                                                <span class="dc-rate">(<?=floor((($crow['SELLING_PRICE']-$price)/$crow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)
												</span>
                                            <? } else {
                                                echo number_format($price = $crow['SELLING_PRICE']);
                                                ?><span class="won"> 원</span><?
                                            }
                                            ?>
                                        </dd>
                                    </dl>
                                    <ul class="prd-label-list">
                                        <? if($crow['COUPON_CD']){?>
                                            <li class="prd-label-item">쿠폰할인</li>
                                        <?}?>
                                        <? if(($crow['PATTERN_TYPE_CD'] == 'FREE') || ( $crow['DELI_LIMIT'] > 0 && $price > $crow['DELI_LIMIT'])) {?>
                                            <li class="prd-label-item free_shipping">무료배송</li>
                                        <?} if($crow['GOODS_MILEAGE_SAVE_RATE'] > 0){?>
                                            <li class="prd-label-item">마일리지</li>
                                        <?}?>
                                    </ul>
                                </a>
                            </div>
                        </li>
                    <?}?>
                </ul>
            </div>
            <!-- // 이 카테고리 베스트 상품 -->

            <!-- 이 상품이 포함된 기획전 // -->
            <h3 class="info-title"><?=($plan_event[0]['GUBUN']=='A')?"이 상품이 포함된 기획전":"인기 기획전"?></h3>
            <div class="dim-subject-list">
                <ul class="owl-carousel owl-nav1">
                    <?foreach($plan_event as $prow){?>
                        <li class="subject-item">
                            <a href="/goods/event/<?=$prow['PLAN_EVENT_CD']?>">
                                <div class="img">
                                    <img src="<?=$prow['IMG_URL']?>" alt="">
                                </div>
                                <div class="txt">
                                    <div class="txt-inner">
                                        <span><?=$prow['TITLE']?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?}?>
                </ul>
            </div>
            <!-- 이 상품이 포함된 기획전 // -->

            <!-- 이 상품이 포함된 매거진 // -->
            <h3 class="info-title"><?=($magazine[0]['GUBUN']=='A')?"이 상품이 포함된 매거진":"인기 매거진"?></h3>
            <div class="dim-subject-list">
                <ul class="owl-carousel owl-nav1">
                    <?foreach($magazine as $mrow){?>
                        <li class="subject-item">
                            <a href="/magazine/detail/<?=$mrow['MAGAZINE_NO']?>">
                                <div class="img">
                                    <img src="<?=$mrow['MOB_IMG_URL']?>" alt="">
                                </div>
                                <div class="txt">
                                    <div class="txt-inner">
                                        <span><?=$mrow['TITLE']?></span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?}?>
                </ul>
            </div>
            <!-- 이 상품이 포함된 매거진 // -->


            <!-- 이 브랜드 베스트 상품 // -->
            <div class="brand-tag-box"><a href="/goods/brand/<?=$goods['BRAND_CD']?>"><span><?=$goods['BRAND_NM']?> 브랜드관 바로가기</span></a></div>
            <?if(count($brand_goods)!=0){?>
                <div class="prd-list-wrap">
                    <ul class="prd-list prd-list--modify" id="brandPlus">
                        <?foreach($brand_goods as $brow){?>
                            <li class="prd-item" name="row[]">
                                <div class="pic">
                                    <a href="/goods/detail/<?=$brow['GOODS_CD']?>">
                                        <div class="item auto-img">
                                            <div class="img">
                                                <img src="<?=$brow['IMG_URL']?>" alt="">
                                            </div>
                                        </div>
                                        <div class="tag-wrap">
                                            <?if(!empty($brow['DEAL'])){?>
                                                <!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>-->
                                            <?}?>
                                            <?if($brow['CLASS_GUBUN']=='C'){?>
                                                <!--<span class="circle-tag class"><em class="blk">공방<br>클래스</em></span>-->
                                            <?}?>
                                            <?if($brow['CLASS_GUBUN']=='G'){?>
                                                <!--<span class="circle-tag class"><em class="blk">공방<br>제작상품</em></span>-->
                                            <?}?>
                                        </div>
                                    </a>
                                </div>
                                <div class="prd-info-wrap">
                                    <a href="/goods/detail/<?=$brow['GOODS_CD']?>">
                                        <dl class="prd-info">
                                            <dt class="prd-item-brand"><?=$brow['BRAND_NM']?></dt>
                                            <dd class="prd-item-tit"><?=$brow['GOODS_NM']?></dd>
                                            <dd class="prd-item-price">
                                                <?if($brow['COUPON_CD']){
                                                    $price = $brow['SELLING_PRICE'] - ($brow['RATE_PRICE']) - ($brow['AMT_PRICE']);
                                                    echo number_format($price);
                                                    $sale_percent = (($brow['SELLING_PRICE'] - $price)/$brow['SELLING_PRICE']*100);
                                                    $sale_percent = strval($sale_percent);
                                                    $sale_percent_array = explode('.',$sale_percent);
                                                    $sale_percent_string = $sale_percent_array[0];
                                                    ?><span class="won"> 원</span><br>
                                                    <del class="del-price"><?=number_format($brow['SELLING_PRICE'])?>원</del>
                                                    <span class="dc-rate">(<?=floor((($brow['SELLING_PRICE']-$price)/$brow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)
												</span>
                                                <? } else {
                                                    echo number_format($price = $brow['SELLING_PRICE']);
                                                    ?><span class="won"> 원</span><?
                                                }
                                                ?>
                                            </dd>
                                        </dl>
                                        <ul class="prd-label-list">
                                            <? if($brow['COUPON_CD']){?>
                                                <li class="prd-label-item">쿠폰할인</li>
                                            <?}?>
                                            <? if(($brow['PATTERN_TYPE_CD'] == 'FREE') || ( $brow['DELI_LIMIT'] > 0 && $price > $brow['DELI_LIMIT'])) {?>
                                                <li class="prd-label-item free_shipping">무료배송</li>
                                            <?} if($brow['GOODS_MILEAGE_SAVE_RATE'] > 0){?>
                                                <li class="prd-label-item">마일리지</li>
                                            <?}?>
                                        </ul>
                                    </a>
                                </div>
                            </li>
                        <?}?>
                    </ul>
                </div>
                <!-- // 이 브랜드 베스트 상품 -->
                <button class="btn-white btn-white--big" id="btn-plus-show" onclick="jsBrandPlus(<?=$goods['GOODS_CD']?>, '<?= $goods['BRAND_CD']?>')">상품 더보기</button>
            <?}?>
        </div>
        <!-- //추천 -->

        <!-- 상품평// -->
        <div id="prdComment" class="vip-tab-cont prd-assessment-wrap func2">
            <h3 class="info-title">상품평</h3>
            <?=$comment_template?>
        </div>
        <!-- //상품평 -->

        <!-- 상품문의// -->
        <div id="prdInquiry" class="vip-tab-cont prd-qna-box func2">
            <h3 class="info-title">상품문의</h3>
            <?=$qna_template?>
        </div>
        <!-- //상품문의 -->
    </div>
    <!-- // 상품상세, 상품평, 상품문의, 배송정보, 교환/환불 정보 -->


    <!-- 하단메뉴 // -->
    <div class="vip-bottom" id="vipBuy">

        <!-- 옵션선택 열기 -->
        <button type="button" class="vip-option-open" id="vipBuyOpener">
            <span class="spr-common vip-option-state-icon"></span>
            <span class="spr-common vip-option-open-img"></span>열기
        </button>

        <!-- 옵션선택 열릴경우 해당 영역 및 버튼이 보여짐. -->
        <div class="vip-detail-data-block" id="vipDetailDataBlock">

            <!-- 옵션 선택 및 선택 된 상품 리스트 -->
            <div class="vip-detail-option-block">
                <div class="vip-select-option" id="vipSelectOption">

                    <ul class="ui-select-option-list">
                        <? if(isset($MOPTION_RESULT_NO)){
                            if(!empty($template_option_list)) {
                                if ($MOPTION_RESULT_NO >= 1) { ?>
                                    <li class="ui-select-option-item">
                                        <button type="button" class="ui-select-option" data-group="opt_1" data-index="0"
                                                data-target="opt_1" placeholder="옵션을 선택하세요">옵션을 선택하세요
                                        </button>
                                    </li>
                                <? }
                                if ($MOPTION_RESULT_NO >= 2) { ?>
                                    <li class="ui-select-option-item">
                                        <button type="button" class="ui-select-option" data-group="opt_1" data-index="1"
                                                data-target="" placeholder="옵션을 선택하세요" disabled>옵션을 선택하세요
                                        </button>
                                    </li>
                                <? }
                                if ($MOPTION_RESULT_NO >= 3) { ?>
                                    <li class="ui-select-option-item">
                                        <button type="button" class="ui-select-option" data-group="opt_1" data-index="2"
                                                data-target="" placeholder="옵션을 선택하세요" disabled>옵션을 선택하세요
                                        </button>
                                    </li>
                                <? }
                                if ($MOPTION_RESULT_NO >= 4) { ?>
                                    <li class="ui-select-option-item">
                                        <button type="button" class="ui-select-option" data-group="opt_1" data-index="3"
                                                data-target="" placeholder="옵션을 선택하세요" disabled>옵션을 선택하세요
                                        </button>
                                    </li>
                                <? }
                                if ($MOPTION_RESULT_NO >= 5) { ?>
                                    <li class="ui-select-option-item">
                                        <button type="button" class="ui-select-option" data-group="opt_1" data-index="4"
                                                data-target="" placeholder="옵션을 선택하세요" disabled>옵션을 선택하세요
                                        </button>
                                    </li>
                                <? }
                            }
                        } else {?>
                            <li class="ui-select-option-item">
                                옵션이 없습니다.
                            </li>
                        <? }?>

                    </ul>
                    <? if(!empty($template_option_list)){?>
                        <div class="ui-option-layer" id="optionViewLayer">

                        </div>
                    <?}else{?>
                        <b>옵션이 모두 품절되었습니다.</b>
                    <?}?>
                </div>

                <div class="vip-buy-option-list" style="display:;" id="selectListInner">
                    <ul class="ui-buy-option-list">

                    </ul>
                </div>
            </div>

        </div>
        <div class="vip-detail-btn-block" id="vipDetailBtns">
            <div class="vip-detail-btn">
                <button type="button" onClick="javaScript:jsGoodsAction('W','','<?=$goods['GOODS_CD']?>','','');" class="ico-block--button <?=@$goods['INTEREST_GOODS_NO']?'active':''?>"><span class="ico-heart ico-heart--block  spr-common"></span></button>
                <button type="button" class="add-cart" onClick="javascript:jsAddCart();">장바구니</button>
                <button type="button" class="btn-buy" onClick="javascript:jsDirect();">바로구매</button>
            </div>

            <?if($goods['CATEGORY_MNG_CD2']!=24010000){?>
                <input type="hidden" value="<?=$ENABLE?>" name="np_enable_yn" id="np_enable_yn">
                <div class="naverpay">
                    <script type="text/javascript" src="https://pay.naver.com/customer/js/mobile/naverPayButton.js" charset="UTF8"></script>
                    <script type="text/javascript" >
                        naver.NaverPayButton.apply({
                            BUTTON_KEY: "CC68CEA7-3129-4153-8D29-BE38810016E1", // 네이버페이에서 제공받은 버튼 인증 키 입력
                            TYPE: "MA", // 버튼 모음 종류 설정
                            COLOR: 1, // 버튼 모음의 색 설정
                            COUNT: 2, // 버튼 개수 설정. 구매하기 버튼만 있으면 1, 찜하기 버튼도 있으면 2를 입력.
                            ENABLE: "<?=$ENABLE?>",
                            BUY_BUTTON_HANDLER: jsNaverPay, // 구매하기 버튼 이벤트 Handler 함수 등록, 품절인 경우 not_buy_nc 함수 사용
                            WISHLIST_BUTTON_HANDLER:jaNaverPick, // 찜하기 버튼 이벤트 Handler 함수 등록
                            "":""
                        });

                        function jaNaverPick() {
                            var goods_cd    = $("#goods_code").val();
                            var goods_name  = $("#goods_name").val();
                            var goods_price = $("#goods_selling_price").val() - $("#goods_discount_price").val();
                            var goods_img   = $("#goods_img").val();

                            if($("#np_enable_yn").val() == 'N'){
                                alert('네이버페이를 통한 구매가 불가한 상품입니다.');
                                return false;
                            }

                            $.ajax({
                                type: 'POST',
                                url: '/goods/naver_pick',
                                dataType: 'json',
                                data: {
                                    'goods_cd' : goods_cd,
                                    'goods_name' : goods_name,
                                    'goods_price' : goods_price,
                                    'goods_img' : goods_img
                                },
                                error:	function(res)	{
                                    alert( 'Database Error' );
                                },
                                success: function(res) {
                                    if(res.status == 'ok'){
                                        var url = res.url+'?SHOP_ID=np_chfrl677135&ITEM_ID='+res.itemId;
                                        location.href=url;
                                    }
                                    else{
                                        alert(res.message);
                                        console.log(res.message);
                                    }
                                }
                            });
                        }

                        function jsNaverPay() {
                            //모바일 버젼은 옵션값들이 goods_form에 담기지 않기 때문에 임의로 넣어줘야함.
                            var OptionValHtml = '';

                            for(var i=0; i<$("input[name='goods_option_code[]']").size(); i++){
                                OptionValHtml += "<input type='hidden' id='goods_option_code' name='goods_option_code[]' value='"+$($("input[name='goods_option_code[]']").get(i)).val()+"'>";
                                OptionValHtml += "<input type='hidden' id='goods_item_coupon_code' name='goods_item_coupon_code[]' value='"+$($("input[name='goods_item_coupon_code[]']").get(i)).val()+"'>";
                                OptionValHtml += "<input type='hidden' id='goods_option_name' name='goods_option_name[]' value='"+$($("input[name='goods_option_name[]']").get(i)).val()+"'>";
                                OptionValHtml += "<input type='hidden' id='goods_option_add_price' name='goods_option_add_price[]' value='"+$($("input[name='goods_option_add_price[]']").get(i)).val()+"'>";
                                OptionValHtml += "<input type='hidden' id='goods_option_qty' name='goods_option_qty[]' value='"+$($("input[name='goods_option_qty[]']").get(i)).val()+"'>";
                                OptionValHtml += "<input type='hidden' id='goods_item_coupon_price' name='goods_item_coupon_price[]' value='"+$($("input[name='goods_item_coupon_price[]']").get(i)).val()+"'>";
                                OptionValHtml += "<input type='hidden' id='goods_add_coupon_code' name='goods_add_coupon_code[]' value="+$($("input[name='goods_add_coupon_code[]']").get(i)).val()+">";
                                OptionValHtml += "<input type='hidden' id='goods_add_discount_price' name='goods_add_discount_price[]' value="+$($("input[name='goods_add_discount_price[]']").get(i)).val()+">";
                                OptionValHtml += "<input type='hidden' id='goods_add_coupon_type' name='goods_add_coupon_type[]' value="+$($("input[name='goods_add_coupon_type[]']").get(i)).val()+">";
                                OptionValHtml += "<input type='hidden' id='goods_add_coupon_gubun' name='goods_add_coupon_gubun[]' value="+$($("input[name='goods_add_coupon_gubun[]']").get(i)).val()+">";
                                OptionValHtml += "<input type='hidden' id='goods_add_coupon_no' name='goods_add_coupon_no[]' value="+$($("input[name='goods_add_coupon_no[]']").get(i)).val()+">";
                                OptionValHtml += "<input type='hidden' id='goods_coupon_amt' name='goods_coupon_amt[]' value="+$($("input[name='goods_coupon_amt[]']").get(i)).val()+">";
                                OptionValHtml += "<input type='hidden' id='goods_cnt' name='goods_cnt[]' value="+$($("input[name='goods_cnt[]']").get(i)).val()+">";
                            }

                            $("#goods_option_value_section").append(OptionValHtml);

                            var goods_option_code = document.getElementsByName("goods_option_code[]");     //옵션코드
                            var goods_option_cnt  = document.getElementsByName("goods_cnt[]");  //상품수량
                            var buymaxCnt         = "<?=$goods['BUY_LIMIT_QTY']?>";    //구매제한수량

                            if($("#np_enable_yn").val() == 'N'){
                                alert('네이버페이를 통한 구매가 불가한 상품입니다.');
                                return false;
                            }


                            if(goods_option_code.length == 0) {
                                alert("상품 옵션을 선택해 주세요.");
                                return false;
                            }

                            for(var i=0;i<goods_option_cnt.length;i++) {
                                if(goods_option_cnt[i].value == 0) {
                                    alert("수량을 입력해 주세요.");
                                    return false;
                                }

                                if(goods_option_cnt[i].value > 999) {
                                    alert("수량을 999개 이하로 입력해 주세요.");
                                    return false;
                                }

                                //구매제한이 있는 경우
                                if( buymaxCnt!=0 ) {
                                    if( parseInt(goods_option_cnt[i].value) > parseInt(buymaxCnt) ) {
                                        alert("이 상품은 "+buymaxCnt+"개 이하로 구매하실 수 있습니다. "+buymaxCnt+"개 이하로 구매해 주세요.");
                                        return false;
                                    }
                                }
                            }

                            if($("input[name=goods_state]").val() != '03'){
                                alert("죄송합니다. 네이버페이로 구매가 불가능한 상품입니다.");
                                return false;
                            }

                            //네이버페이로 주문 정보를 등록하는 가맹점 페이지로 이동.
                            // 해당 페이지에서 주문 정보 등록 후 네이버페이 주문서 페이지로 이동.
                            var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
                            var frm = document.getElementById("goods_form");
                            frm.action = "https://"+SSL_val+"/order/naver_pay";
                            frm.submit();
                        }
                    </script>
                </div>
            <?}?>
        </div>
        <!-- 옵션선택 열릴경우 해당 영역 및 버튼 숨김. -->
        <div class="vip-default-btn">
            <!--	<button type="button" class="ico-block--button prd-bookmark-link <?=$goods['INTEREST_GOODS_NO']?'active':''?>" onClick="javaScript:jsGoodsAction('W','','<?=$goods['GOODS_CD']?>','','');"><span class="ico-heart ico-heart--block  spr-common"></span></button>	-->
            <button type="button" onClick="javaScript:jsGoodsAction('W','','<?=$goods['GOODS_CD']?>','','');" class="ico-block--button <?=@$goods['INTEREST_GOODS_NO']?'active':''?>"><span class="ico-heart ico-heart--block  spr-common"></span></button>
            <button type="button" class="btn-buy">구매하기</button>
        </div>
    </div>
    <!-- // 하단메뉴 -->

    <div id="share_sns"></div>

    <!-- // 공유하기 레이어 -->

    <!-- 쿠폰적용하기 레이어 // -->
    <div class="COUPON_LAYER" id="coupon_layer"></div>
    <!-- // 쿠폰적용하기 레이어 -->

    <!-- 방문예약하기 레이어 // -->
    <div class="RESERVATION_LAYER" id="reservation_layer"></div>
    <!-- // 방문예약하기 레이어 -->

    <!-- 구매하기 레이어 // -->
    <div class="common-layer-wrap layer-vip-guide-view" id="layerVipGuideView">
        <?=$goods_buy_guide_template?>
    </div>
    <!-- // 구매하기 레이어 -->




    <script src="/assets/js/common.js"></script>
    <script src="/assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // 상품 썸네일 슬라이드
            $(".main-banner-list").owlCarousel({
                items: 1,
                loop: true,
                autoHeight: true,
                smartSpeed: 300,
                autoplay: true,
                autoplayTimeout: 5000,
                nav:true,
                dots:false
            });
            google_ga('view_item');
        });
        // 탑버튼
        //    function topBtn (){       <!-- 푸터 스크립트랑 중복 -->
        //        var btn = $('#btnTop'),
        //            deadLine = $('#footer').offset().top;
        //        var scrollFnc = function(){
        //            deadLine = $('#footer').offset().top,
        //                scrollTop = $(window).scrollTop();
        //            if( scrollTop > 50 ) {
        //                btn.stop().fadeIn();
        //                if( scrollTop > deadLine - $(window).height() ) {
        //                    btn.css({
        //                        'position' : 'absolute',
        //                        'bottom' : '',
        //                        'top' : deadLine - 55
        //                    });
        //                } else {
        //                    btn.css({
        //                        'position' : 'fixed',
        //                        'top' : '',
        //                        'bottom' : '50px'
        //                    })
        //                }
        //            } else {
        //                btn.stop().fadeOut();
        //            }
        //        };
        //        $(window).on('scroll', scrollFnc);
        //        btn.on('click', function(){
        //            $('html, body').animate({
        //                scrollTop : 0
        //            }, 'fast');
        //        });
        //        scrollFnc();
        //    }

        // 스크롤 시 헤더 동작
        var didScroll;
        var lastScrollTop = 0;
        var delta = 0; //동작 구현이 시작되는 위치

        // 스크롤 시 알림
        $(window).scroll(function(event){
            didScroll = true;
        });

        // hasScrolled() 실행, didScroll 상태 재설정
        setInterval(function() {
            if (didScroll) {
                hasScrolled();
                didScroll = false;
            }
        }, 100);

        function hasScrolled() {
            //현재 스크롤의 위치
            var scrollTop = $(this).scrollTop();

            // 설정한 delta 값보다 더 스크롤되었는지를 확인
            if(Math.abs(lastScrollTop - scrollTop) <= delta) {
                return;
            }

            if (scrollTop < 0){
                scrollTop = 0;
            }

            // 헤더 높이보다 더 스크롤되었는지 확인, 스크롤 방향 확인
            if (scrollTop > lastScrollTop){
                // Scroll Down
                $('#header').addClass('header-up');
            } else {
                // Scroll Up
                if($(window).height() < $(document).height()) {
                    $('#header').removeClass('header-up');
                }
            }

            lastScrollTop = scrollTop;
        }

        //    $(function()  <!-- 푸터 스크립트랑 중복 -->
        //    {
        //         topBtn();
        ////        topNav();
        //        etahUi.layercontroller();
        //        etahUi.bottomLayercontroller();
        //        etahUi.bottomLayerOpen();
        //        etahUi.toggleMenu();
        ////        etahUi.tabMenu();
        //        etahUi.cartOptionLayer();
        //        etahUi.listToggle();
        //        etahUi.filterLayer();
        //        etahUi.selectFun();
        //    });
    </script>
    <!--2019.01.30 추가 스크립트-->
    <script>
        $('.dim-subject-list').each(function(){
            // 이 상품이 포함된 기획전 슬라이드
            $(this).find('.owl-carousel').owlCarousel({
                items: 1,
                loop: $(this).find('.subject-item').size() > 1 ? true:false,
                margin: 0,
                autoplay: true,
                autoplayTimeout: 3000,
                smartSpeed: 300,
                nav: true,
                dots: false
            });
        });

        //이 카테고리 베스트 상품
        $(".prd-list--main").owlCarousel({
            items: 2,
            loop: true,
            margin: 6,
            autoHeight: false,
            smartSpeed: 300,
            autoplay: true,
            autoplayTimeout: 7000,
            nav: false,
            dots: false
        });

        $(document).ready(function(){
            //상품정보 더보기
            $('.btn-prd-view-more').click(function(){
                $('.folding-area').toggleClass('func-fold');
                $(this).toggleClass('fold');
                $(this).text( $(this).text() == '상품정보 더보기' ? "상품정보 접기" : "상품정보 더보기");
            });

            // Tabs
            var tab = $('.tab-vip-list');
            var btnTab = $('.tab-vip-list a');

            $(btnTab).click(function (e) {
                e.preventDefault();

                if ($(this.hash).hasClass('func2')) {
                    $('.vip-tab-cont.func1').css('display', 'none');
                } else {
                    $('.vip-tab-cont.func1').css('display', 'block');
                }

                $('.vip-tab-cont').removeClass('active');
                $(this.hash).addClass('active');

                $(this).parent('li').siblings('li').removeClass('active');
                $(this).parent('li').addClass('active');
                $('html,body').animate({scrollTop:$(this.hash).offset().top - 58});
            });

            // 스크롤 시 상품상세 탭 네비 동작
            var tabsOffset = $('.goods-tabs .tab-vip-list').offset().top - 0; // Scroll Up

            $(window).scroll(function () {
                var scroll = $(this).scrollTop();
                if (scroll >= tabsOffset) {
                    $('.goods-tabs .tab-vip-list').addClass('fixed');
                } else if (scroll <= tabsOffset) {
                    $('.goods-tabs .tab-vip-list').removeClass('fixed');
                }
            });
        });

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

    <script src="/assets/js2/goods_coupon.js"></script>
    <script type="text/javascript">
        //===============================================================
        // 브랜드상품 더보기
        //===============================================================
        function jsBrandPlus(goods_cd, brand_cd) {
            var seq = document.getElementsByName("row[]").length;

            $.ajax({
                type: 'POST',
                url: '/goods/detail_brand_plus',
                data: {
                    seq : seq,
                    goods_cd : goods_cd,
                    brand_cd : brand_cd
                },
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        $("#brandPlus").append(res.message);
                    }
                    else {  //더이상 상품이 없을때
                        $("#btn-plus-show").hide();
                    }
                }
            });
        }

        //===============================================================
        // 옵션 수량 변경 시, 쿠폰 초기화
        //===============================================================
        function jsOptionCntChange(opt_code)
        {
            for(var i=0; i<document.getElementsByName("goods_option_code[]").length; i++){
                if(opt_code == document.getElementsByName("goods_option_code[]")[i].value){
                    var idx = i;
                    break;
                }
            }

            //쿠폰이 선택되어있는 경우
            if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() != '' || $($("input[name='goods_item_coupon_code[]']").get(idx)).val() != $("input[name='goods_coupon_code_i']").val().split("||")[0]){
                if(confirm("수량을 변경하시면, 선택하신 쿠폰이 초기화 됩니다.")){
                    //아이템 쿠폰 히든 값에 넣어놨던 쿠폰들 다 리셋
                    $($("input[name='goods_item_coupon_code[]']").get(idx)).val($("input[name='goods_coupon_code_i']").val().split("||")[0]);
                    $($("input[name='goods_item_coupon_price[]']").get(idx)).val($("input[name='goods_coupon_amt_i']").val());

                    //바이어쿠폰 히든값을 빈값으로 넣기
                    $($("input[name='goods_add_coupon_code[]']").get(idx)).val('');
                    $($("input[name='goods_add_discount_price[]']").get(idx)).val(parseInt(0));
                    $($("input[name='goods_add_coupon_type[]']").get(idx)).val('');
                    $($("input[name='goods_add_coupon_gubun[]']").get(idx)).val('');
                    $($("input[name='goods_add_coupon_no[]']").get(idx)).val('');

                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }

        function jsChgCouponR(opt_code, cnt){
            for(var i=0; i<document.getElementsByName("goods_option_code[]").length; i++){
                if(opt_code == document.getElementsByName("goods_option_code[]")[i].value){
                    var idx = i;
                    break;
                }
            }

            var selling_price			= parseInt($("input[name='goods_selling_price']").val());
            var goods_option_add_price	= parseInt($($("input[name='goods_option_add_price[]']").get(idx)).val());
            var seller_coupon_amt		= parseInt($("input[name='goods_coupon_amt_s']").val());
            var item_coupon_amt			= parseInt($($("input[name='goods_item_coupon_price[]']").get(idx)).val());
            var cust_coupon_amt			= parseInt($($("input[name='goods_add_discount_price[]']").get(idx)).val());
            var coupon_price			= ( selling_price + goods_option_add_price ) - ( seller_coupon_amt + item_coupon_amt + cust_coupon_amt);


            //판매금액 적용
            $("s[name=option_selling_price]").eq(idx).text(numberFormat(parseInt(selling_price + goods_option_add_price) * parseInt(cnt)));
            //할인금액 적용
            $("span[name=cpn_price]").eq(idx).text(numberFormat(parseInt(coupon_price) * parseInt(cnt)));

            $($("input[name='goods_coupon_amt[]']").get(idx)).val(parseInt(coupon_price) * parseInt(cnt))

//		totalPrice();
            Total_goods_price();
        }

        //===============================================================
        // 옵션 선택에 대한 옵션 값들
        //===============================================================
        function jsOptionVal(data){
            var OptionValHtml = '';
            OptionValHtml += "<input type='hidden' id='goods_option_code' name='goods_option_code[]' value='"+data.option_code+"'>";
            OptionValHtml += "<input type='hidden' id='goods_item_coupon_code' name='goods_item_coupon_code[]' value='"+data.item_coupon_code+"'>";
//	OptionValHtml += "<input type='hidden' id='goods_option_name' name='goods_option_name[]' value='"+data.option_name+"'>";
            OptionValHtml += "<input type='hidden' id='goods_option_add_price' name='goods_option_add_price[]' value='"+data.addPrice+"'>";
            OptionValHtml += "<input type='hidden' id='goods_option_qty' name='goods_option_qty[]' value='"+data.len+"'>";
            OptionValHtml += "<input type='hidden' id='goods_item_coupon_price' name='goods_item_coupon_price[]' value='"+data.item_coupon_amt+"'>";
            OptionValHtml += "<input type='hidden' id='goods_add_coupon_code' name='goods_add_coupon_code[]' value=''>";
            OptionValHtml += "<input type='hidden' id='goods_add_discount_price' name='goods_add_discount_price[]' value=0>";
            OptionValHtml += "<input type='hidden' id='goods_add_coupon_type' name='goods_add_coupon_type[]' value=''>";
            OptionValHtml += "<input type='hidden' id='goods_add_coupon_gubun' name='goods_add_coupon_gubun[]' value=''>";
            OptionValHtml += "<input type='hidden' id='goods_add_coupon_no' name='goods_add_coupon_no[]' value=''>";
            OptionValHtml += "<input type='hidden' id='goods_coupon_amt' name='goods_coupon_amt[]' value="+data.price+">";
            OptionValHtml += "<input type='hidden' id='f_goods_cnt' name='f_goods_cnt[]' value=1>";

            $("#goods_option_value_section").append(OptionValHtml);
        }

        //===============================================================
        // 장바구니에 상품 담기
        //===============================================================
        function jsAddCart(){
            var cookieGoodsCd	= "<?=$cookieGoodsCd?>";
            var goodsCd			= "<?=$goods['GOODS_CD']?>";

            if(cookieGoodsCd == goodsCd){
                alert('해당상품은 1일 구매제한이 있습니다.');
                return false;
            }

            var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
            var param		= $("#goods_form").serialize();
            var goods_option_code = $("input[name='goods_option_code[]']").val();

            //모바일 버젼은 옵션값들이 goods_form에 담기지 않기 때문에 임의로 넣어줘야함.
            for(var i=0; i<$("input[name='goods_option_code[]']").size(); i++){
                param		+= "&goods_option_code[]="+$($("input[name='goods_option_code[]']").get(i)).val();
                param		+= "&goods_item_coupon_code[]="+$($("input[name='goods_item_coupon_code[]']").get(i)).val();
                param		+= "&goods_option_name[]="+$($("input[name='goods_option_name[]']").get(i)).val();
                param		+= "&goods_option_add_price[]="+$($("input[name='goods_option_add_price[]']").get(i)).val();
                param		+= "&goods_option_qty[]="+$($("input[name='goods_option_qty[]']").get(i)).val();
                param		+= "&goods_item_coupon_price[]="+$($("input[name='goods_item_coupon_price[]']").get(i)).val();
                param		+= "&goods_add_coupon_code[]="+$($("input[name='goods_add_coupon_code[]']").get(i)).val();
                param		+= "&goods_add_discount_price[]="+$($("input[name='goods_add_discount_price[]']").get(i)).val();
                param		+= "&goods_add_coupon_type[]="+$($("input[name='goods_add_coupon_type[]']").get(i)).val();
                param		+= "&goods_add_coupon_gubun[]="+$($("input[name='goods_add_coupon_gubun[]']").get(i)).val();
                param		+= "&goods_add_coupon_no[]="+$($("input[name='goods_add_coupon_no[]']").get(i)).val();
                param		+= "&goods_coupon_amt[]="+$($("input[name='goods_coupon_amt[]']").get(i)).val();
                param		+= "&goods_cnt[]="+$($("input[name='goods_cnt[]']").get(i)).val();
            }


            if($("input[name=goods_state]").val() != '03'){
                alert("판매중이 아닌 상품은 장바구니에 담을 수 없습니다.");
                return false;
            }

            if(goods_option_code == undefined){
                alert("옵션을 선택해주세요.");
                return false;
            }


            google_ga('add_to_cart');

            $.ajax({
                type: 'POST',
                url: '/cart/insert_cart',
                dataType: 'json',
                data: param,
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        if(confirm('장바구니에 상품이 담겼습니다. 확인하시겠습니까?')){
                            location.href='/cart';
                        }
                    }
                    else alert(res.message);
                }
            })

            return false;
        }

        //===============================================================
        // 상품 바로구매
        //===============================================================
        function jsDirect(){
            var cookieGoodsCd	= "<?=$cookieGoodsCd?>";
            var goodsCd			= "<?=$goods['GOODS_CD']?>";

            if(cookieGoodsCd == goodsCd){
                alert('해당상품은 1일 구매제한이 있습니다.');
                return false;
            }

            var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
            var param		= $("#goods_form").serialize();
            var goods_option_code = $("input[name='goods_option_code[]']").val();
            var OptionValHtml = '';
            var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
//    alert(goods_option_code);
            //모바일 버젼은 옵션값들이 goods_form에 담기지 않기 때문에 임의로 넣어줘야함.
            for(var i=0; i<$("input[name='goods_option_code[]']").size(); i++){
                OptionValHtml += "<input type='hidden' id='goods_option_code' name='goods_option_code[]' value='"+$($("input[name='goods_option_code[]']").get(i)).val()+"'>";
                OptionValHtml += "<input type='hidden' id='goods_item_coupon_code' name='goods_item_coupon_code[]' value='"+$($("input[name='goods_item_coupon_code[]']").get(i)).val()+"'>";
                OptionValHtml += "<input type='hidden' id='goods_option_name' name='goods_option_name[]' value='"+$($("input[name='goods_option_name[]']").get(i)).val()+"'>";
                OptionValHtml += "<input type='hidden' id='goods_option_add_price' name='goods_option_add_price[]' value='"+$($("input[name='goods_option_add_price[]']").get(i)).val()+"'>";
                OptionValHtml += "<input type='hidden' id='goods_option_qty' name='goods_option_qty[]' value='"+$($("input[name='goods_option_qty[]']").get(i)).val()+"'>";
                OptionValHtml += "<input type='hidden' id='goods_item_coupon_price' name='goods_item_coupon_price[]' value='"+$($("input[name='goods_item_coupon_price[]']").get(i)).val()+"'>";
                OptionValHtml += "<input type='hidden' id='goods_add_coupon_code' name='goods_add_coupon_code[]' value="+$($("input[name='goods_add_coupon_code[]']").get(i)).val()+">";
                OptionValHtml += "<input type='hidden' id='goods_add_discount_price' name='goods_add_discount_price[]' value="+$($("input[name='goods_add_discount_price[]']").get(i)).val()+">";
                OptionValHtml += "<input type='hidden' id='goods_add_coupon_type' name='goods_add_coupon_type[]' value="+$($("input[name='goods_add_coupon_type[]']").get(i)).val()+">";
                OptionValHtml += "<input type='hidden' id='goods_add_coupon_gubun' name='goods_add_coupon_gubun[]' value="+$($("input[name='goods_add_coupon_gubun[]']").get(i)).val()+">";
                OptionValHtml += "<input type='hidden' id='goods_add_coupon_no' name='goods_add_coupon_no[]' value="+$($("input[name='goods_add_coupon_no[]']").get(i)).val()+">";
                OptionValHtml += "<input type='hidden' id='goods_coupon_amt' name='goods_coupon_amt[]' value="+$($("input[name='goods_coupon_amt[]']").get(i)).val()+">";
                OptionValHtml += "<input type='hidden' id='goods_cnt' name='goods_cnt[]' value="+$($("input[name='goods_cnt[]']").get(i)).val()+">";
            }

            $("#goods_option_value_section").append(OptionValHtml);
//    alert(OptionValHtml);
            if($("input[name=goods_state]").val() != '03'){
                alert("판매중이 아닌 상품은 구매할 수 없습니다.");
                return false;
            }

            if(goods_option_code == undefined){
                alert("옵션을 선택해주세요.");
                return false;
            }

            if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){	//로그인 안한 경우
                document.getElementById("goods_form").guest_gb.value = 'direct';

                var frm = document.getElementById("goods_form");
                frm.action = "https://"+SSL_val+"/member/Guestlogin";
                frm.submit();
            } else {
                var frm = document.getElementById("goods_form");
                frm.action = "https://"+SSL_val+"/cart/OrderInfo";
                frm.submit();
            }
        }

        <?if($goods['VENDOR_SUBVENDOR_CD']==10240){?>
        //====================================
        // 방문예약 레이어 생성
        //====================================
        function jsReservationLayer(goods_cd){
            $.ajax({
                type: 'POST',
                url: '/goods/reservation_layer',
                dataType: 'json',
                data: { goods_cd : goods_cd },
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
        <?}?>

        //====================================
        // 쿠폰 레이어 생성
        //====================================
        function couponLayerCreate(opt_code,opt_price){
//	for(var i=0; i<$("#coupon_layer").children().size(); i++){
//		alert($("#coupon_layer").children().eq(i).attr("id"));
//		alert('cartCouponLayer'+opt_code);
//		if($("#coupon_layer").children().eq(i).attr("id") == 'cartCouponLayer'+opt_code){
//			alert("이미 등록된 옵션입니다.");
//			return false;
//		}
//	}

            if(opt_code == undefined){
                alert("이미 등록된 옵션입니다.");
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '/goods/coupon_layer',
                dataType: 'json',
                data: { goods_code : document.getElementById("goods_code").value, option_add_price : opt_price, idx : opt_code},
                error: function(res) {
                    alert('Database Error');
                },
                async : false,
                success: function(res) {
                    if(res.status == 'ok'){
                        $("#coupon_layer").prepend(res.coupon_layer);
                    }
                    else alert(res.message);
                }
            });
        }

        //======================================
        // 쿠폰 레이어 열기
        //======================================
        function couponLayerOpen(opt_code){
            Coupon_Reset(opt_code);
            Coupon_use_check(opt_code);		//사용가능/사용불가능 쿠폰 체크

            $('#cartCouponLayer'+opt_code).removeClass();
            $('#cartCouponLayer'+opt_code).addClass('common-layer-wrap cart-coupon-layer common-layer-wrap--view');
            $("#etah_html").addClass('bottom-layer-open');
        }

        /*****************/
        /** 천단위 콤마 **/
        /*****************/
        function numberFormat(num) {
            num = String(num);
            return num.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,"$1,");
        }

        /**********************/
        /** 천단위 콤마 제거 **/
        /**********************/
        function renumberFormat(num){
            return num.replace(/^\$|,/g, "") + ""
        }


        //google_gtag
        function google_ga(gtag_event)
        {

            var brand = '['+$("input[name='brand_code']").val() + ']'+$("input[name='brand_name']").val();
            var option_nm = '['+ $("input[name='goods_option_code[]']").val() + ']' + $("input[name='goods_option_name[]']").val();
            var categroy_info = '[' + <?=$goods['CATEGORY_MNG_CD3']?> + ']' + "<?=$goods['CATEGORY_MNG_NM3']?>";
            if(gtag_event == 'view_item'){
                gtag('event', 'view_item', {
                    "items": [
                        {
                            "id": $("input[name='goods_code']").val(),
                            "name": $("input[name='goods_name']").val(),
                            "list_name": "view item",
                            "brand": brand,
                            "category": categroy_info,
                            "list_position": 1,
                            "price": $("input[name='goods_selling_price']").val()
                        }
                    ]
                });
            }else{
                gtag('event', 'add_to_cart', {
                    "items": [
                        {
                            "id": $("input[name='goods_code']").val(),
                            "name": $("input[name='goods_name']").val(),
                            "list_name": "add cart",
                            "brand": brand,
                            "category": categroy_info,
                            "variant":option_nm,
                            "list_position": 1,
                            "quantity": $("input[name='goods_option_qty[]']").val(),
                            "price": $("input[name='goods_selling_price']").val()
                        }
                    ]
                });
            }
        }
    </script>

    <!-- 선택 된 상품 추가 html 탬플릿 -->

    <!-- option button create -->
    <script id="select-template" type="text/x-handlebars-template">
        <li class="ui-buy-option-item">
            <div class="ui-buy-option-data">
                <ul class="add-options-list">
                    <input type="hidden" id="goods_option_code"			name="goods_option_code[]"		value="{{option_code}}">
                    <input type="hidden" id="goods_item_coupon_code"	name="goods_item_coupon_code[]" value="{{item_coupon_code}}">
                    <input type="hidden" id="goods_option_name"			name="goods_option_name[]"		value="{{string}}">
                    <input type="hidden" id="goods_option_add_price"	name="goods_option_add_price[]"	value="{{addPrice}}">
                    <input type="hidden" id="goods_option_qty"			name="goods_option_qty[]"		value="{{len}}">
                    <input type="hidden" id="goods_item_coupon_price"	name="goods_item_coupon_price[]" value="{{item_coupon_amt}}">
                    <input type="hidden" id="goods_add_coupon_code"		name="goods_add_coupon_code[]"  value="">
                    <input type="hidden" id="goods_add_discount_price"	name="goods_add_discount_price[]" value=0>
                    <input type="hidden" id="goods_add_coupon_type"		name="goods_add_coupon_type[]"  value="">
                    <input type="hidden" id="goods_add_coupon_gubun"	name="goods_add_coupon_gubun[]"	value="">
                    <input type="hidden" id="goods_add_coupon_no"		name="goods_add_coupon_no[]"	value="">	<!--추가할인쿠폰코드의번호...? cust_coupon_no컬럼-->
                    <input type="hidden" id="goods_coupon_amt"			name="goods_coupon_amt[]"		value={{price}}>	<!--쿠폰적용가-->
                    <li class="add-options-item">
                        {{string}} {{#if addPrice_txt}} {{addOption}} ({{addPrice_txt}}원) {{/if}}
                    </li>
                </ul>

                <div class="ui-buy-quantity">
                    <input type="number" class="quantity_input" value="1" data-max="{{mpq}}" data-price="{{price}}" data-priceuse="{{price}}" data-qty="{{len}}" data-sellingprice="{{sellingPrice}}" data-optioncode="{{option_code}}" id="goods_cnt" name="goods_cnt[]">
                    <button type="button" class="quantity_minus_btn"><span class="hide-text">minus</span></button>
                    <button type="button" class="quantity_plus_btn"><span class="hide-text">plus</span></button>
                </div>
                <span class="ui-buy-price">
                <del class="del">{{#if selling_price}} {{selling_price}}원 {{/if}}</del>
                <strong name="cpn_price">{{replacePrice}}</strong><span class="won">원</span>
            </span>

                {{#if option_code}}
                <a href="javascript:couponLayerOpen({{option_code}});" data-layer="bottom-layer-open2" class="btn-gray btn-coupon-select">쿠폰선택</a> {{/if}}

                <button type="button" class="vip-disable-type-btn ui-remove-item"><span class="hide-text">삭제</span></button>
            </div>
        </li>


    </script>

    <!-- option button create -->
    <script id="option-template" type="text/x-handlebars-template">
        <?if(!empty($template_option_list)){?>
            <ul class="ui-option-layer-list">
                {{#options}}
                <li class="ui-option-layer-item">
                    <button class="ui-option-layer-btn" data-value="{{value}}" data-sub="{{subOption}}" onclick="{{link}}" data-price="{{price}}" data-len="{{len}}" data-mpq="{{MPQ}}" data-addprice="{{addPrice}}" data-addoption="{{addOption}}" data-str="{{string}}" data-optioncode="{{option_code}}"
                            data-sellingprice="{{selling_price}}">
                        {{string}}
                        {{#if addOption}}
                        /&nbsp;{{addOption}}
                        {{/if}}
                        {{#if addPriceComma}}
                        ({{addPriceComma}})
                        {{/if}}
                        [잔여수량 : {{len}}개]
                    </button>
                </li>
                {{/options}}
            </ul>
        <?}?><!--
       <b>옵션이 모두 품절되었습니다.</b>
   --><?/*}*/?>
        <button class="ui-option-layer-close"></button>
        </div>
    </script>

    <script>

        /***********************/
        /*****기본 값 세팅******/
        /***********************/
        var aJsonArray = new Array();
        var aJson = new Object();

        <?  $i = 1;
        if($template_option_list){
        foreach($template_option_list as $row){
        $DEPTH = substr_count($row['SEQ'],"|");
        if($DEPTH == 0){	//멀티옵션1일경우 멀티옵션 2 배열 미리 생성?>
        eval("var moption2Array_"+"<?=$i?>"+" = new Array();");
        <?		$i++;
        } else if($DEPTH == 1){	//멀티옵션2일경우 멀티옵션 3 배열 미리 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];	?>
        eval("var moption3Array_"+"<?=$i.$j?>"+" = new Array();");
        <?		} else if($DEPTH == 2){	//멀티옵션3일경우 멀티옵션 4 배열 미리 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];	?>
        eval("var moption4Array_"+"<?=$i.$j.$k?>"+" = new Array();");
        <?		} else if($DEPTH == 3){ //멀티옵션4일경우 멀티옵션 4 배열 미리 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        $l = explode("|",$row['SEQ'])[3];	?>
        eval("var moption5Array_"+"<?=$i.$j.$k.$l?>"+" = new Array();");
        <?		}
        }
        }	//END IF
        ?>

        <?  $i = 1;
        if($template_option_list){
        foreach($template_option_list as $row) {
        $DEPTH = substr_count($row['SEQ'],"|");

        if($DEPTH == 0){	//멀티옵션 1 생성?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";

        aJson.selling_price = parseInt(document.getElementById('goods_selling_price').value);
        aJson.option_code	= "<?=$row['GOODS_OPTION_CD']?>";
        aJson.link			= "";
        aJson.string		= "<?=$row['OPT_NAME']?>";
        aJson.value			= "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i?>";
        aJson.price			= parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);
        aJson.addPrice		= "<?=$row['GOODS_OPTION_ADD_PRICE'] == 0 ? '' : $row['GOODS_OPTION_ADD_PRICE']?>";
        aJson.len			= "<?=$row['GOODS_OPTION_QTY']?>";
        aJson.MPQ			= "<?=$row['GOODS_OPTION_QTY']?>";

        <? if($MOPTION_RESULT == 'M_OPTION_1'){	?>
        aJson.subOption = 'false';
        <? } else { ?>
        aJson.subOption = 'moption2_<?=$i?>';
        <? }?>

        aJsonArray.push(aJson);
        var aJson = new Object();
        <?		$i++;
        } else if($DEPTH == 1 && ( $MOPTION_RESULT == 'M_OPTION_2' || $MOPTION_RESULT == 'M_OPTION_3' || $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5' )){	//멀티옵션 2 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];

        ?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";
        eval("var moption2_<?=$i?> = new Object();");	//오브젝트 초기화

        eval("moption2_"+"<?=$i?>"+".selling_price	= parseInt(document.getElementById('goods_selling_price').value);");
        eval("moption2_"+"<?=$i?>").option_code		= "<?=$row['GOODS_OPTION_CD']?>";
        eval("moption2_"+"<?=$i?>").link			= '';
        eval("moption2_"+"<?=$i?>").string			= "<?=$row['OPT_NAME']?>";
        eval("moption2_"+"<?=$i?>").value			= "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i?>";
        eval("moption2_"+"<?=$i?>"+".price			= parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);");
        eval("moption2_"+"<?=$i?>").addPrice		= "<?=$row['GOODS_OPTION_ADD_PRICE'] == 0 ? '' : $row['GOODS_OPTION_ADD_PRICE']?>";
        eval("moption2_"+"<?=$i?>"+".len			= "+"<?=$row['GOODS_OPTION_QTY']?>"+";");
        eval("moption2_"+"<?=$i?>"+".MPQ			= <?=$row['GOODS_OPTION_QTY']?>;");

        <? if($MOPTION_RESULT == 'M_OPTION_2'){	?>
        eval("moption2_"+"<?=$i?>"+".subOption		= 'false';");
        <? } else { ?>
        eval("moption2_"+"<?=$i?>"+".subOption		= 'moption3_<?=$i.$j?>';");
        <? }?>

        eval("moption2Array_"+"<?=$i?>"+".push(moption2_"+"<?=$i?>);");
        eval("var moption2_<?=$i?> = new Object();");	//오브젝트 초기화
        <?		} else if($DEPTH == 2 && ( $MOPTION_RESULT == 'M_OPTION_3' || $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5' )){	//멀티옵션 3 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        ?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";
        eval("var moption3_<?=$i.$j?> = new Object();");	//오브젝트 초기화

        eval("moption3_"+"<?=$i.$j?>"+".selling_price	= parseInt(document.getElementById('goods_selling_price').value);");
        eval("moption3_"+"<?=$i.$j?>").option_code		= "<?=$row['GOODS_OPTION_CD']?>";
        eval("moption3_"+"<?=$i.$j?>"+".link			= '';");
        eval("moption3_"+"<?=$i.$j?>").string			= "<?=$row['OPT_NAME']?>";
        eval("moption3_"+"<?=$i.$j?>").value			= "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i.$j?>";
        eval("moption3_"+"<?=$i.$j?>"+".price			= parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);");
        eval("moption3_"+"<?=$i.$j?>").addPrice			= "<?=$row['GOODS_OPTION_ADD_PRICE'] == 0 ? '' : $row['GOODS_OPTION_ADD_PRICE']?>";
        eval("moption3_"+"<?=$i.$j?>"+".len				= "+"<?=$row['GOODS_OPTION_QTY']?>"+";");
        eval("moption3_"+"<?=$i.$j?>"+".MPQ				= <?=$row['GOODS_OPTION_QTY']?>;");

        <? if($MOPTION_RESULT == 'M_OPTION_3'){	?>
        eval("moption3_"+"<?=$i.$j?>"+".subOption		= 'false';");
        <? } else { ?>
        eval("moption3_"+"<?=$i.$j?>"+".subOption		= 'moption4_<?=$i.$j.$k?>';");
        <? } ?>

        eval("moption3Array_"+"<?=$i.$j?>"+".push(moption3_"+"<?=$i.$j?>);");
        eval("var moption3_<?=$i.$j?> = new Object();");	//오브젝트 초기화
        <?		} else if($DEPTH == 3 && ( $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5' )){	//멀티옵션 4 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        $l = explode("|",$row['SEQ'])[3];
        ?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";
        eval("var moption4_<?=$i.$j.$k?> = new Object();");	//오브젝트 초기화

        eval("moption4_"+"<?=$i.$j.$k?>"+".selling_price	= parseInt(document.getElementById('goods_selling_price').value);");
        eval("moption4_"+"<?=$i.$j.$k?>").option_code		= "<?=$row['GOODS_OPTION_CD']?>";
        eval("moption4_"+"<?=$i.$j.$k?>"+".link				= '';");
        eval("moption4_"+"<?=$i.$j.$k?>").string			= "<?=$row['OPT_NAME']?>";
        eval("moption4_"+"<?=$i.$j.$k?>").value				= "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i.$j.$k?>";
        eval("moption4_"+"<?=$i.$j.$k?>"+".price			= parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);");
        eval("moption4_"+"<?=$i.$j.$k?>").addPrice			= "<?=$row['GOODS_OPTION_ADD_PRICE'] == 0 ? '' : $row['GOODS_OPTION_ADD_PRICE']?>";
        eval("moption4_"+"<?=$i.$j.$k?>"+".len				= "+"<?=$row['GOODS_OPTION_QTY']?>"+";");
        eval("moption4_"+"<?=$i.$j.$k?>"+".MPQ				= <?=$row['GOODS_OPTION_QTY']?>;");

        <? if($MOPTION_RESULT == 'M_OPTION_4'){	?>
        eval("moption4_"+"<?=$i.$j.$k?>"+".subOption		= 'false';");
        <? } else { ?>
        eval("moption4_"+"<?=$i.$j.$k?>"+".subOption		= 'moption5_<?=$i.$j.$k.$l?>';");
        <? }?>

        eval("moption4Array_"+"<?=$i.$j.$k?>"+".push(moption4_"+"<?=$i.$j.$k?>);");
        eval("var moption4_<?=$i.$j.$k?> = new Object();");	//오브젝트 초기화
        <?		} else if($DEPTH == 4 && ( $MOPTION_RESULT == 'M_OPTION_5' )){ //멀티옵션 5 생성
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        $l = explode("|",$row['SEQ'])[3];
        $m = explode("|",$row['SEQ'])[4];
        ?>
        var option_add_price = "<?=$row['GOODS_OPTION_ADD_PRICE']?>";
        eval("var moption5_<?=$i.$j.$k.$l?> = new Object();");	//오브젝트 초기화

        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".selling_price		= parseInt(document.getElementById('goods_selling_price').value);");
        eval("moption5_"+"<?=$i.$j.$k.$l?>").option_code		= "<?=$row['GOODS_OPTION_CD']?>";
        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".link				= '';");
        eval("moption5_"+"<?=$i.$j.$k.$l?>").string				= "<?=$row['OPT_NAME']?>";
        eval("moption5_"+"<?=$i.$j.$k.$l?>").value				= "<?=$row['GOODS_OPTION_CD']?>"+"||"+"<?=$row['OPT_NAME']?>"+"||"+"<?=$i.$j.$k.$l?>";
        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".price				= parseInt(document.getElementById('goods_selling_price').value) - parseInt(document.getElementById('goods_discount_price').value) + parseInt(option_add_price);");
        eval("moption5_"+"<?=$i.$j.$k.$l?>").addPrice			= "<?=$row['GOODS_OPTION_ADD_PRICE'] == 0 ? '' : $row['GOODS_OPTION_ADD_PRICE']?>";
        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".len				= "+"<?=$row['GOODS_OPTION_QTY']?>"+";");
        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".MPQ				= <?=$row['GOODS_OPTION_QTY']?>;");
        eval("moption5_"+"<?=$i.$j.$k.$l?>"+".subOption			= 'false';");

        eval("moption5Array_"+"<?=$i.$j.$k.$l?>"+".push(moption5_"+"<?=$i.$j.$k.$l?>);");
        eval("var moption5_<?=$i.$j.$k.$l?> = new Object();");	//오브젝트 초기화
        <?		}

        }
        } //END IF?>

        //alert(JSON.stringify(moption2Array_1));

        var bJson = new Object();
        bJson.title = '선택1';
        <? if($MOPTION_RESULT == 'M_OPTION_5'){	?>
        bJson.subTitle = ['선택2','선택3','선택4','선택5'];
        <? } else if($MOPTION_RESULT == 'M_OPTION_4'){	?>
        bJson.subTitle = ['선택2','선택3','선택4'];
        <? } else if($MOPTION_RESULT == 'M_OPTION_3'){	?>
        bJson.subTitle = ['선택2','선택3'];
        <? } else if($MOPTION_RESULT == 'M_OPTION_2'){	?>
        bJson.subTitle = ['선택2'];
        <? }	?>

        bJson.options = aJsonArray;
        bJsonString			= JSON.stringify(bJson);
        TotalOptionJson_1	= JSON.parse(bJsonString);

        //제일 큰 옵션 (optionData 배열 생성)
        var cJson = new Object();
        cJson.opt_1 = TotalOptionJson_1;

        var eJson = new Object();

        <?  $i = 1;
        if($MOPTION_RESULT == 'M_OPTION_2' || $MOPTION_RESULT == 'M_OPTION_3' || $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5'){

        if($template_option_list){
        foreach($template_option_list as $row){
        $DEPTH = substr_count($row['SEQ'],"|");
        if($DEPTH == 0){	?>
        //모바일버젼은 option[]이 추가되어야함
        eJson.options = eval("moption2Array_"+"<?=$i?>"+";");
        eval("cJson.moption2_"+"<?=$i?>"+" = eJson;");
        var eJson = new Object();
        //			eval("cJson.moption2_"+"<?=$i?>"+" = moption2Array_"+"<?=$i?>"+";");
        <?		 $i++;
        } else if($DEPTH == 1){
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];

        if($MOPTION_RESULT == 'M_OPTION_3' || $MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5'){		?>
        //모바일버젼은 option[]이 추가되어야함
        eJson.options = eval("moption3Array_"+"<?=$i.$j?>"+";");
        eval("cJson.moption3_"+"<?=$i.$j?>"+" = eJson;");
        var eJson = new Object();

        //				eval("cJson.moption3_"+"<?=$i.$j?>"+" = moption3Array_"+"<?=$i.$j?>"+";");
        <?			}
        } else if($DEPTH == 2){
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];

        if($MOPTION_RESULT == 'M_OPTION_4' || $MOPTION_RESULT == 'M_OPTION_5'){		?>
        //모바일버젼은 option[]이 추가되어야함
        eJson.options = eval("moption4Array_"+"<?=$i.$j.$k?>"+";");
        eval("cJson.moption4_"+"<?=$i.$j.$k?>"+" = eJson;");
        var eJson = new Object();

        //				eval("cJson.moption4_"+"<?=$i.$j.$k?>"+" = moption4Array_"+"<?=$i.$j.$k?>"+";");
        <?			}
        } else if($DEPTH == 3){
        $i = explode("|",$row['SEQ'])[0];
        $j = explode("|",$row['SEQ'])[1];
        $k = explode("|",$row['SEQ'])[2];
        $l = explode("|",$row['SEQ'])[3];

        if($MOPTION_RESULT == 'M_OPTION_5'){		?>
        //모바일버젼은 option[]이 추가되어야함
        eJson.options = eval("moption5Array_"+"<?=$i.$j.$k.$l?>"+";");
        eval("cJson.moption5_"+"<?=$i.$j.$k.$l?>"+" = eJson;");
        var eJson = new Object();

        //				eval("cJson.moption5_"+"<?=$i.$j.$k.$l?>"+" = moption5Array_"+"<?=$i.$j.$k.$l?>"+";");
        <?			}
        }
        }	//END FOREACH
        }

        }	//END IF
        ?>

        //	alert(JSON.stringify(cJson));
        cJsonString = JSON.stringify(cJson);
        GroupOption = JSON.parse(cJsonString);
        //alert(JSON.stringify(GroupOption));
        var optionData = GroupOption;		//옵션 생성


        // 가격에 콤마를 추가
        function comma(str)
        {
            str = String(str);
            return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
        }

        var etahVipOpt = {
            ele:
                {
                    selectOptionBlock: $('#vipSelectOption'), // option 선택 영역
                    optionLayerBlock: $('#optionViewLayer'), // 하위옵션레이어 추가되는 영역.
                    choiceOptionWriteBlock: $('#selectListInner'), // 선택된 옵션 삽입.
                    optionTemplate: $('#option-template').html(), // 하위 옵션 선택 영역 html 템플릿
                    choiceTemplate: $('#select-template').html(), // 선택된 옵션 추가html 템플릿.
                },
            defaultMax: 999, // 최대 구매수량 미지정 시 기본값을 셋팅 합니다. 정책에 따라 수정해 주세요.
            state:
                {
                    data: null,
                    step: 0,
                    groups: null,
                    opener: null
                },
            buyData:
                {},

            // 이벤트 추가.
            init: function(data)
            {
                var instance = this;
                $block = this.ele.selectOptionBlock;
                instance.state.data = data;
                var buymaxCnt = "<?=$goods['BUY_LIMIT_QTY']?>";
                if(buymaxCnt == '0'){
                    buymaxCnt = 1000;
                }

                // 옵션 버튼 클릭시 이벤트 추가.
                $block.on('click', '.ui-select-option', function()
                {
                    instance.state.opener = $(this);
                    instance.createOption();
                });

                // 생성된 옵션 레이어에서 버튼 클릭시 이벤트 추가.
                instance.ele.optionLayerBlock.on('click', '.ui-option-layer-btn', function()
                {
                    instance.submitOption($(this));
                }).on('click', '.ui-option-layer-close', function()
                { // 레이어 닫기 이벤트 추가.
                    instance.closeOption();
                });

                instance.ele.choiceOptionWriteBlock.on('click', '.ui-remove-item', function()
                {
                    instance.removeSelectOption($(this));
                }).on('keydown keyup', '.quantity_input', function()
                {
                    instance.counterCheck($(this), 'push');

                }).on('focusout', '.quantity_input', function()
                {
                    var $input = $(this).parent().find('.quantity_input'),
                        val = $input.val(),
                        maxCounter = ($input.data('max') !== '') ? $input.data('max') : instance.defaultMax;
                    //alert(buymaxCnt);
                    if(Number(val) > Number(buymaxCnt)){
//                        if(val > buymaxCnt){
                        alert('1회 최대 구매수는 '+buymaxCnt+' 개 입니다');
                        $input.val(buymaxCnt);
                        return false;
                    }
                    instance.counterCheck($(this), 'focusout');
                }).on('click', '.quantity_minus_btn', function()
                {
                    if(jsOptionCntChange($(this).parent().find('.quantity_input').data('optioncode')) == true){	//옵션에 쿠폰이 선택되어 있다면 쿠폰은 초기화 됨.

                        var $input = $(this).parent().find('.quantity_input'),
                            val = $input.val(),
                            minCounter = 1;

                        if (val > minCounter)
                        {
                            val--;
                        }
                        $input.val(val);

                        $input.trigger('focusout');

                    }

                }).on('click', '.quantity_plus_btn', function()
                {
                    //alert('dd');
                    //var buymaxCnt = "<?=$goods['BUY_LIMIT_QTY']?>";


                    if(jsOptionCntChange($(this).parent().find('.quantity_input').data('optioncode')) == true){	//옵션에 쿠폰이 선택되어 있다면 쿠폰은 초기화 됨.

                        var $input = $(this).parent().find('.quantity_input'),
                            val = $input.val(),
                            maxCounter = ($input.data('max') !== '') ? $input.data('max') : instance.defaultMax;

                        if(val == buymaxCnt){
                            alert('1회 최대 구매수는 '+buymaxCnt+' 개 입니다');
                            return false;
                        }

                        if(val == maxCounter){
                            alert('현재 주문가능한 재고수량은 '+maxCounter+'개 입니다.\n'+maxCounter+'개 이하로 주문해 주세요.');
                            return false;
                        }

                        if (val < maxCounter)
                        {
                            val++;
                        }

                        $input.val(val);

                        $input.trigger('focusout');

                    }
                });


            },

            // 옵션 수량 변경시 실행.
            counterCheck: function($target, opt)
            {

                var instance = this,
                    reg = /[^0-9]/g,
                    val = $target.val().replace(reg, ''),
                    item = $target.parents('.ui-buy-option-item'),
                    itemPriceTarget = item.find('.ui-buy-price > strong'),
                    sellingPirceTarget = item.find('.ui-buy-price > .del'),
                    maxCounter = ($target.data('max') !== '') ? $target.data('max') : instance.defaultMax,
                    qty = ($target.data('qty') !== '') ? $target.data('qty') : 0,
                    selling_price = parseInt($target.data('sellingprice'));
                price = parseInt($target.data('price'), 10);


                if (val > qty)
                {
                    alert("현재 주문가능한 재고수량은 "+qty+"개 입니다.\n"+qty+"개 이하로 주문해 주세요.");
                    val = qty;
                }
                if (val > maxCounter)
                {
                    val = maxCounter;
                }
                if (opt === 'focusout' && val <= 0)
                {
                    val = 1;
                }
                $target.val(val);
                selling_price = selling_price * val;
                price = price * val;
                sellingPirceTarget.text(comma(selling_price+"원"));
                itemPriceTarget.text(comma(price));
                $target.data('priceuse', price);
                instance.totalPrice();

                jsChgCouponR($target.data('optioncode'),val);
            },

            // 옵션 레이어를 생성.
            createOption: function()
            { // 레이어를 생성한다.
                var target = this.state.opener.data('target'), // 이전에 선택된 옵션그룹이 있는지 체크를 위해.
                    $block = this.ele.selectOptionBlock, // 옵션 선택 영역.
                    instance = this,
                    targetData = (function()
                    {
                        var returnData = instance.state.data[target];
                        $.each(returnData.options, function(index, value)
                        {
                            if (this.addPrice !== '' && this.addPrice !== false && this.addPrice !== undefined || this.addPrice === 0)
                            {
                                if(this.addPrice > 0){
                                    this.addPriceComma = '+'+comma(this.addPrice);
                                } else {
                                    this.addPriceComma = comma(this.addPrice);
                                }
                            }
                            else
                            {
                                this.addPriceComma = '';
                            }

                        });

                        return returnData;
                    })(),
                    template = Handlebars.compile(this.ele.optionTemplate);
                htm = $(template(targetData));

                this.state.opener.data('data', targetData);
                this.ele.optionLayerBlock.html(htm); // 옵션레이어 추가.
                this.ele.selectOptionBlock.addClass('vip-select-option--layer'); // 옵션레이어 활성화 클래스

                BuyArea.reHeight(); // 하단 고정영역 높이 갱신.
            },

            // 생성된 옵션 레이어의 버튼을 클릭 했을 경우 실행.
            submitOption: function($ele)
            {
                var instance = this,
                    txt = $ele.text(),
                    val = $ele.data('value'),
                    sub = $ele.data('sub'),
                    groups = instance.ele.selectOptionBlock.find('[data-group="' + instance.state.opener.data('group') + '"]'),
                    openerIndex = instance.state.opener.data('index');
                instance.state.opener.text(txt).data(
                    {
                        'value': val,
                        'sub': sub
                    });

                if (sub === false)
                {

                    // 선택한 옵션이 최종 옵션일경우
                    instance.insertSelectOption($ele);

                }
                else
                {

                    // 추가로 선택해야 하는 옵션이 존재할 경우
                    // 선택한 옵션의 다음 옵션 버튼을 활성화 하고, 해당 옵션에 선택해야 할 옵션의 데이터 키를 할당 한다.
                    $.each(groups, function(index)
                    {
                        if ($(this).data('index') > openerIndex)
                        {
                            $(this).prop('disabled', true)
                                .text($(this).attr('placeholder'));
                        };
                    });
                    groups.eq(openerIndex + 1).prop('disabled', false)
                        .data('target', sub);

                    // 스크롤을 다음 선택 해야 할 옵션쪽으로 이동 시킨다.
                    $('#vipDetailDataBlock').find('.vip-detail-option-block').animate(
                        {
                            'scrollTop': 40 * (openerIndex + 1)
                        }, 'fast');

                }

                this.closeOption();
            },

            // 옵션 레이어를 닫음.
            closeOption: function()
            {
                this.ele.selectOptionBlock.removeClass('vip-select-option--layer');
                BuyArea.reHeight();
            },

            // 옵션을 선택하여 최종적으로 선택된 값을 영역에 추가한다.
            insertSelectOption: function($ele)
            {
                //옵션추가금액 세팅
                if($ele.data('addprice') > 0){
                    var add_price_txt = '+'+$ele.data('addprice');
                } else {
                    var add_price_txt = $ele.data('addprice');
                }

                if($ele.data('addprice') == ''){
                    var add_price = 0;
                } else {
                    var add_price = $ele.data('addprice');
                }

                //상품쿠폰세팅
                if(document.getElementById("goods_coupon_code_i").value != ''){
                    var item_coupon_code	= document.getElementById("goods_coupon_code_i").value.split('||')[0];
                    var item_coupon_amt		= document.getElementById("goods_coupon_amt_i").value;
                } else {
                    var item_coupon_code	= '';
                    var item_coupon_amt		= 0;
                }

                var instance = this,
                    template = Handlebars.compile(this.ele.choiceTemplate),
                    opener = instance.state.opener,
                    groups = instance.ele.selectOptionBlock.find('[data-group="' + opener.data('group') + '"]'),
                    data = { // html 에 삽입될 데이터를 가공.
                        'string': $ele.data('str'), // 제품 명.
                        'mpq': $ele.data('mpq'), // 주문 제한수량
                        'len': $ele.data('len'), // 상품 재고수량
                        'price': $ele.data('price'), // 제품의 판매 가격 (콤마 추가 없이 data 에 들어가는 가격)
                        'replacePrice': comma($ele.data('price')), // 가격(콤마 추가되어 보여지는 가격)
                        'addPrice': add_price, //옵션 추가금액
                        'addPrice_txt': comma(add_price_txt), // 옵션 추가금액 (+,-표시)
                        'addOption': $ele.data('addoption'), // 옵션명
                        'selling_price': comma(parseInt($ele.data('sellingprice'))+parseInt(add_price)), // 판매가 삭선표시됨.
                        'sellingPrice' : parseInt($ele.data('sellingprice'))+parseInt(add_price),		//판매가
                        'option_code': ($ele.data('optioncode') !== '') ? $ele.data('optioncode') : false,
                        'item_coupon_code': item_coupon_code,
                        'item_coupon_amt': item_coupon_amt
                    },
                    htm = $(template(data)),
                    selectOptions = instance.ele.choiceOptionWriteBlock.find('.ui-buy-option-item');

                // 이미 삽입 된 데이터인지 체크한다.
                if (!instance.buyData[$ele.data('value')])
                {
                    instance.buyData[$ele.data('value')] = true;
                }
                else
                {
                    data = false; // 이미 삽입된 데이터일 경우 입력되지 않도록 값을 false 로 변경.
                }

                if (data !== false)
                {
                    htm.data('value', $ele.data('value')); // 선택된 value 데이터를 해당 엘리먼트에 대입.
                    // 해당 영역이 최초에 숨겨 져 있으므로 활성화.
                    // html 을 삽입.
                    instance.ele.choiceOptionWriteBlock.show().find('.ui-buy-option-list').append(htm);

                    // 선택 했던 group 의 버튼을 첫번째 것 제외한 나머지 모두 비활성화.
                    $.each(groups, function()
                    {
                        $(this).text($(this).attr('placeholder'));
                        if ($(this).data('index') !== 0)
                        {
                            $(this).prop('disabled', true);
                        }
                    });
                }

                // 스크롤을 선택된 옵션이 있는 곳으로 이동.
                $('#vipDetailDataBlock').find('.vip-detail-option-block').animate(
                    {
                        'scrollTop': $('#vipSelectOption').outerHeight() + $('#optionViewLayer').outerHeight()
                    }, 'fast');

                this.totalPrice()

                couponLayerCreate(data.option_code,data.addPrice);	//쿠폰레이어 생성

            },

            // 선택했던 데이터를 삭제.
            removeSelectOption: function($ele)
            {
                var removeTarget = $ele.parents('.ui-buy-option-item');
                this.buyData[removeTarget.data('value')] = false;
                removeTarget.remove();
                if (this.ele.choiceOptionWriteBlock.find('.ui-buy-option-item').length === 0)
                {
                    this.ele.choiceOptionWriteBlock.hide();
                }
                this.totalPrice();
            },

            // 최종 구매 금액을 갱신.
            totalPrice: function()
            {
                var total = (function()
                    {
                        var returnNum = 0,
                            dataEle = $('#selectListInner').find('.quantity_input'),
                            len = dataEle.length,
                            i = 0;
                        for (i; i < len; i++)
                        {
                            returnNum += parseInt(dataEle.eq(i).data('priceuse'), 10);
                        }
                        return returnNum;
                    })(),
                    htm = '';

                if ($('#total_price').get(0) === undefined)
                {
                    htm += '<dl class="vip-total-price"><dt class="vip-total-price-title">상품합계</dt><dd class="vip-total-price-data">';
                    htm += '<strong class="vip-total-price-number" id="total_price">' + comma(total) + '</strong>원';
                    htm += '</dd></dl>';
                    $('#vipDetailBtns').prepend(htm);
                }
                else
                {
                    $('#total_price').text(comma(total));
                }
            }
        };



        var BuyArea = {
            rootElement: null,
            openBtn: null,
            detail: null,
            defaultH: 70,
            objH: 0,
            realBtn: null,
            ele:
                {
                    blockId: 'vipBuy',
                    blockBtnId: 'vipBuyOpener',
                    openClass: 'vip-bottom--open',
                    optionsArea: 'vipDetailDataBlock',
                    btnsArea: 'vipDetailBtns'
                },
            init: function()
            {
                var instance = this;
                this.rootElement = $('#' + this.ele.blockId);
                this.openBtn = $('#' + this.ele.blockBtnId);
                this.detail = $('#' + this.ele.optionsArea);
                this.btnsArea = $('#' + this.ele.btnsArea);
                this.openBtn.on('click', function()
                {
                    if (instance.rootElement.hasClass(instance.ele.openClass))
                    {
                        instance.close();
                    }
                    else
                    {
                        instance.open();

                    }
                });
                this.rootElement.find('.btn-buy').on('click', function()
                {
                    instance.open();
                })
            },
            open: function()
            {
                this.rootElement.addClass(this.ele.openClass);
                this.reHeight();
            },
            close: function()
            {
                this.rootElement.css(
                    {
                        'height': 0
                    });
                this.rootElement.removeClass(this.ele.openClass);
            },
            reHeight: function()
            {
                this.rootElement.css(
                    {
                        'height': this.btnsArea.height() + this.detail.height()
                    });
            }
        };


        $(function()
        {

            etahVipOpt.init(optionData);

            BuyArea.init();


            /*etahUi.slideBox(
            {
                box: $('#detailImgFlick'), // maxwidth 넘거가면 margin 제거.
                page: $('#bigBannerPage'), // page 표시영역
                imgArea: $('#bannerList'), // motion box, box size * 3 width, box height
                imgObj: $('#detailImgFlick').find('li.main-banner-item'), // li, contents / box size width,
                btns: $('#detailImgFlick').find('.banner-left, .banner-right'), // 좌우 버튼.
                imgCls: 'main-banner-item',
                pageHtm: '', // 페이징(블릿) html
                moveClass: 'transition',
                boxReheight: true // box 의 높이를 조정.
                    // .visual-list
            });*/

            // vip 상품문의=
//				$('.btn-prd-answere').click(function()
//				{
            $('body').on('click', ".btn-prd-answere",function()
            {
                //비밀글을 클릭했을 때는 펼쳐지지 않도록 함
                var thisChildrens = $(this).children('.none')
                if (thisChildrens.hasClass('none'))
                {
                    return false;
                }
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

            // vip  상품평=
            $('body').on('click', ".prd-assessment-camera-btn",function()
            {
                var thisParents = $(this).parents('.prd-assessment-item')
                if ($(thisParents).hasClass('active'))
                {
                    $(thisParents).find('.prd-assessment-photo').slideUp();
                    $(thisParents).removeClass('active');
                }
                else
                {
                    $(thisParents).find('.prd-assessment-photo').slideDown();
                    $(thisParents).addClass('active');
                }
                return false;
            });

            var vipLayerBtn = $('[data-ui="vip-layer"]'),
                vipLayerClose = $('[data-ui="vip-layer-close"]');
            $(vipLayerBtn).on('click', function()
            {
                var thisHref = $(this).attr('href');
                if ($(this).hasClass('active'))
                {
                    $(this).removeClass('active');
                    $(thisHref).slideUp();
                }
                else
                {
                    $(this).addClass('active');
                    $(thisHref).slideDown();
                }
                return false;
            });
            $(vipLayerClose).on('click', function()
            {
                var thisHref = $(this).attr('href');
                $(thisHref).slideUp();
                $(vipLayerBtn).removeClass('active');
                return false;
            });

            //별점
            $('.star-grade-select-item').on('click', function()
            {
                if ($(this).hasClass('active'))
                {
                    $(this).removeClass('active');
                    $(this).nextAll().removeClass('active');
                }
                else
                {
                    $(this).addClass('active');
                    $(this).prevAll().addClass('active');
                }
            });
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
        $(document).ready(function()
        {
            location.hash='#INFO';
        });

        //====================================
        // 조건별 검색
        //====================================
        function search_goods(kind, val)
        {
            var cate_cd		= "";
            var order_by	= "";
            var	brand_cd	= "";
            var type		= "";
            var cate_gb		= "";
            var price_limit = "";
            var keyword		= "";
            var search_cnt	= "";
            var attr		= "";
            var href        = "";

            //카테고리
            if(kind == 'C'){
                cate_cd = val;
            }

            var param = "";
            param += "kind="			+ kind;
            param += "&type="			+ type;
            param += "&cate_cd="		+ cate_cd;
            param += "&price_limit="	+ price_limit;
            param += "&brand_cd="		+ brand_cd;
            param += "&order_by="		+ order_by;
            param += "&keyword="		+ keyword;
            param += "&attr="			+ attr;
            param += "&cate_gb="		+ cate_gb;
            param += "&search_cnt="		+ search_cnt;
            param += "";
            var category = new Array('10000000','11000000','13000000','14000000','15000000','16000000','17000000','18000000','19000000','21000000','22000000','23000000');

            href = "/category/category_list?" + param;

            for (var word in category) {
                if (cate_cd.match(category[word])) {
                    param = "cate_cd="		+ val;
                    href = "/category/main?" + param;
                }
            }

            document.location.href = href;
        }
    </script>
    <!---->
    <!---->
    <!--		<!-- 2017-02-23 추가 -->
    <!--		<!-- 공통 적용 스크립트 , 모든 페이지에 노출되도록 설치. 단 전환페이지 설정값보다 항상 하단에 위치해야함 -->
    <!--		<script type="text/javascript" src="//wcs.naver.net/wcslog.js"> </script>-->
    <!--		<script type="text/javascript">-->
    <!--		if (!wcs_add) var wcs_add={};-->
    <!--		wcs_add["wa"] = "s_51fd0fb4ae2b";-->
    <!--		if (!_nasa) var _nasa={};-->
    <!--		wcs.inflow();-->
    <!--		wcs_do(_nasa);-->
    <!--		</script>-->
    <!---->
    <!--		<!--카페24전환 스크립트 시작 -->
    <!--		<script type='text/javascript'>-->
    <!--		var cmcJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");-->
    <!--		document.write(unescape("%3Cscript id='cmclog_script' src='" + cmcJsHost + "etah.cmclog.cafe24.com/weblog.js?uid=etah&uname=etah' type='text/javascript'%3E%3C/script%3E"));-->
    <!--		</script>-->
    <!---->
    <!--		<!-- 리포트2.0 로그분석코드 시작 -->
    <!--		<script type="text/javascript">-->
    <!--		var JsHost = (("https:" == document.location.protocol) ? "https://" : "http://");-->
    <!--		var uname = escape('에타');-->
    <!--		document.write(unescape("%3Cscript id='log_script' src='" + JsHost + "etah.weblog.cafe24.com/weblog.js?uid=etah&uname="+uname+"' type='text/javascript'%3E%3C/script%3E"));-->
    <!--		</script>-->
    <!--		<!-- 리포트2.0  로그분석코드 완료 -->
    <!--		<!--카페24전환 스크립트 완료 -->
    <!---->
    <!--		</body>-->
    <!--	</html>-->

