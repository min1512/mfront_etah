<? if(!$this->session->userdata('EMS_U_NO_')){	?>
    <script>
        //	location.href = 'member/login';
    </script>
<? }?>
<!-- 2017-02-23 추가 -->
<!-- 전환페이지 설정 -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
    var _nasa={};
    _nasa["cnv"] = wcs.cnv("3","1"); // 전환유형, 전환가치 설정해야함. 설치매뉴얼 참고
</script>

<link rel="stylesheet" href="/assets/css/cart_order.css?ver=1.2">
<div class="content">

    <h2 class="page-title-basic">장바구니</h2>

    <form name="buyForm" id="buyForm" method="post">
        <input type="hidden" name="order_gb"	id="order_gb"	 value="">		<!-- 전체주문/선택주문/바로주문 구분 -->
        <input type="hidden" name="direct_code" id="direct_code" value="">		<!-- 바로주문시 장바구니코드 -->
        <input type="hidden" name="guest_gb"    id="guest_gb"   value="">                   <!-- 비회원주문시 로그인화면         -->

        <div class="cart-prd-order">
            <div class="cart-prd-all-check position-area">
                <input type="checkbox" id="all_check" class="checkbox" onClick="javascript:jsChkAll(this.checked)"; checked/>
                <label for="all_check" class="checkbox-label">전체선택 <span name="check_count" class="cart-prd-all-check-num">(1/4)</span></label>
                <a href="javascript://" onClick="jsDelGoods('B','');" class="btn-white position-right btn-select-delete">선택삭제</a>
            </div>
            <!-- Google Tag Manager Variable (eMnet) 2018.05.29-->
            <script>
                var brandIds = [];
            </script>
            <!-- End Google Tag Manager Variable (eMnet) -->
            <?
            $cart_idx				= 0;	//장바구니 상품수 인덱스
            $idx2					= 0;	//묶음상품수 인덱스
            $total_goods_price		= 0;	//총 상품금액
            $total_cpn_price		= 0;	//총 할인금액
            $total_group_deli_price	= 0;	//총 배송비
            $goods_mileage_save		= 0;	//적립예정마일리지

            $group					= array_keys($cart);
            $group_str				= "";

            if(count($cart) != 0){
            foreach($cart as $cart_grp){

                $group_goods = "N";		//묶음배송 여부
                $group_deli_price	= 0;	//묶음상품 배송비
                $group_code = $group[$idx2];
                if($idx2 == 0){
                    $group_str	= $group[$idx2];
                } else {
                    $group_str	.= "||".$group[$idx2];
                }	?>
            <input type="hidden"	name="group_code[]"	value="<?=$group_code?>">
            <?	foreach($cart_grp as $row){?>
                <div class="prd-order-section">
                    <h3 class="prd-order-section-title">
                        <input type="checkbox" id="cartPrdCheck<?=$cart_idx?>" name="chkGoods[]" class="checkbox" value="<?=$cart_idx?>||<?=$row['CART_NO']?>||<?=$row['DELI_CODE']?>" <? if($row['GOODS_STS_CD'] == 03 && $row['GOODS_OPTION_QTY'] != 0){?>checked<?}?>/>
                        <label for="cartPrdCheck<?=$cart_idx?>" class="checkbox-label checkbox-label--hidden"><? if($row['GOODS_STS_CD'] != 03){?><font style="color:red;">[<?=$row['GOODS_STS_CD_NM']?>]</font> <?}?><?=$row['GOODS_NM']?></label>
                    </h3>
                    <div class="media-area prd-order-media">
                        <span class="media-area-img prd-order-media-img"><a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['GOODS_IMG']?>" alt=""></a></span>
                        <span class="media-area-info prd-order-media-info">
								<span class="prd-order-media-info-name">
									<?=$row['GOODS_OPTION_NM']?> <? if($row['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? } else if($row['GOODS_OPTION_ADD_PRICE'] < 0){?>(<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? }?>
                                    <? if($row['GOODS_OPTION_QTY'] == 0){?><p style="color:red;">-- 해당 옵션은 품절되었습니다.</p><? }?>
								</span>
								<span class="position-area prd-order-media-info-option">
								<a href="#optionChangeLayer<?=$cart_idx?>" class="btn-white" data-layer="bottom-layer-open2">옵션변경</a>
                                    <!--
                                        <div class="select-box active" style=""> <!-- 활성화시 클래스 active추가 -->
                                    <!--		<select class="select-box-inner" id="select_option[]" name="select_option[]" onChange="javascript:jsChgcart(<?=$row['CART_NO']?>,'OPT',<?=$cart_idx?>,this.value);">
										<!-- value:옵션코드||옵션추가금||옵션 재고 수량 -->
                                    <?// foreach($row['GOODS_OPTION'] as $row2){	?>
                                    <!--			<option value="<?=$row2['GOODS_OPTION_CD']?>||<?=$row2['GOODS_OPTION_ADD_PRICE']?>||<?=$row2['QTY']?>"<?//if($row['GOODS_OPTION_CD'] == $row2['GOODS_OPTION_CD']){?>selected<?//}?>><?=$row2['GOODS_OPTION_NM']?> <? //if($row2['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row2['GOODS_OPTION_ADD_PRICE'])?>원)<?// }
                                    //else if($row2['GOODS_OPTION_ADD_PRICE'] < 0){ ?>(<?=number_format($row2['GOODS_OPTION_ADD_PRICE'])?>원)<?//}
                                    //if($row2['QTY'] == 0){?> [품절] <?//}?></option>
											<?// }?>
										</select>
									</div>	-->
									<div class="select-box select-box--arrow" style="width: 43px;">
										<!-- 쿠폰 갯수 계산할때 HIDDEN으로 해서 하는게 간편함-->
										<input type="hidden" name="goods_cnt[]" value="<?=$row['GOODS_CNT']?>">
										<input type="hidden" name="limit_cnt[]" value="<?=$row['BUY_LIMIT_QTY']?>" />
										<select class="select-box-inner" id="select_cnt<?=$cart_idx?>" onChange="javascript:jsChgcart(<?=$row['CART_NO']?>,'CNT',<?=$cart_idx?>,this.value);">
											<? for($i=1; $i<=10; $i++){	?>
                                                <option <?if($row['GOODS_CNT'] == $i){?>selected<?}?>><?=$i?></option>
                                            <? }?>
										</select>
									</div>
									<a href="javascript://" onClick="jsStep2('Direct','<?=$cart_idx?>||<?=$row['CART_NO']?>');" class="btn-black btn-prd-order-buy position-right">바로구매</a>
								</span>
							</span>
                    </div>
                    <dl class="prd-order-price">	<!-- 판매가 --->
                        <dt class="title">판매가</dt>
                        <dd class="price"><strong><?=number_format(($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT'])?></strong><span class="won">원</span></dd>
                    </dl>
                    <div class="prd-order-dc-price">	<!--할인가-->
                        <?
                        $seller_cpn_price	= 0;	//셀러쿠폰가격
                        $item_cpn_price		= 0;	//아이템쿠폰가격
                        if(isset($row['SELLER_COUPON_AMT'])){
                            if($row['SELLER_COUPON_AMT'] > $row['SELLER_COUPON_MAX'] && $row['SELLER_COUPON_MAX'] != 0){
                                $seller_cpn_price += $row['SELLER_COUPON_MAX'] * $row['GOODS_CNT'];
                                $total_cpn_price += $row['SELLER_COUPON_MAX'] * $row['GOODS_CNT'];
                            } else {
                                $seller_cpn_price  += $row['SELLER_COUPON_AMT'] * $row['GOODS_CNT'];
                                $total_cpn_price += $row['SELLER_COUPON_AMT'] * $row['GOODS_CNT'];
                            }
                        }
                        if(isset($row['ITEM_COUPON_AMT'])){
                            if($row['ITEM_COUPON_AMT'] > $row['ITEM_COUPON_MAX'] && $row['ITEM_COUPON_MAX'] != 0){
                                $item_cpn_price	 += $row['ITEM_COUPON_MAX'] * $row['GOODS_CNT'];
                                $total_cpn_price += $row['ITEM_COUPON_MAX'] * $row['GOODS_CNT'];
                            } else {
                                $item_cpn_price	 += $row['ITEM_COUPON_AMT'] * $row['GOODS_CNT'];
                                $total_cpn_price += $row['ITEM_COUPON_AMT'] * $row['GOODS_CNT'];
                            }
                        }
                        //$total_cpn_price += $row['COUPON_AMT'] * $row['GOODS_CNT']'

                        //==================================배송비 계산할 때 할인금액 포함해서 계산했었음
                        //2018.08.23 다시 할인가로 변경
                        if(isset($row['SELLER_COUPON_CD']) || isset($row['ITEM_COUPON_CD'])){
                            $selling_price = ($row['COUPON_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'];
                        } else {
                            $selling_price = ($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT'];
                        }
                        //2017-01-10 배송비 계산 수정
                        //								$selling_price = ($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT'];

                        ?>

                        <? if($group_goods == "N"){		//배송비
                            $group_selling_price	= 0;	//묶음 상품 가격 합
                            $group_goods_cnt		= 0;	//묶음 상품 총 갯수
                            $j = 0;
                            for($i=$cart_idx; $i<$cart_idx+count($cart_grp); $i++){
//==================================배송비 계산할 때 할인금액 포함해서 계산했었음
                                //2018.08.23 다시 할인가로 변경
                                if(isset($cart_grp[$j]['SELLER_COUPON_CD']) || isset($cart_grp[$j]['ITEM_COUPON_CD'])){
                                    $group_selling_price += $cart_grp[$j]['COUPON_PRICE']*$cart_grp[$j]['GOODS_CNT'];
                                } else {
                                    $group_selling_price += ($cart_grp[$j]['SELLING_PRICE'] + $cart_grp[$j]['GOODS_OPTION_ADD_PRICE']) * $cart_grp[$j]['GOODS_CNT'];
                                }
                                //2017-01-10 배송비 계산 수정
//									$group_selling_price += $cart_grp[$j]['SELLING_PRICE'] - () * $cart_grp[$j]['GOODS_CNT'];

                                $group_goods_cnt		 += $cart_grp[$j]['GOODS_CNT'];
                                $j++;
                            }
                            
                            ?>
                            <? if( $row['DELI_LIMIT'] == 0 || $row['DELI_LIMIT']>$group_selling_price ) {	//묶음 배송비
                                if($row['PATTERN_TYPE_CD'] == 'STATIC'){	//갯수대로 배송비 부과
                                    $group_deli_price += $row['DELI_COST']*$group_goods_cnt;?>
                                    <input type="hidden" name="group_delivery_price[]"	value="<?=$row['DELI_COST']*$group_goods_cnt?>">
                                <?	} else if($row['PATTERN_TYPE_CD'] == 'PRICE'){	//가격조건
                                    $group_deli_price += $row['DELI_COST'];	?>
                                    <input type="hidden" name="group_delivery_price[]"	value="<?=$row['DELI_COST']?>">
                                <?	} else if($row['PATTERN_TYPE_CD'] == 'FREE'){	//무료배송조건
                                    $group_deli_price += 0;	?>
                                    <input type="hidden" name="group_delivery_price[]"	value="0">
                                <?	} else {	?>
                                    <input type="hidden" name="group_delivery_price[]"	value="0">
                                <?	}
                            } else {	?>

                                <input type="hidden" name="group_delivery_price[]"	value="0">
                            <? }?>

                            <?  $goods_deli_price	= 0;
                            if( $row['DELI_LIMIT'] == 0 || $row['DELI_LIMIT']>$selling_price ){	//상품별 배송비
                                if($row['PATTERN_TYPE_CD'] == 'STATIC'){	//갯수대로 배송비 부과
                                    $goods_deli_price = $row['DELI_COST']*$row['GOODS_CNT'];	?>
                                    <input type="hidden" name="goods_delivery_price[]" value="<?=$row['DELI_COST']*$row['GOODS_CNT']?>">
                                <? } else if($row['PATTERN_TYPE_CD'] == 'PRICE'){	//가격조건
                                    $goods_deli_price = $row['DELI_COST'];	?>
                                    <input type="hidden" name="goods_delivery_price[]" value="<?=$row['DELI_COST']?>">
                                <? } else if($row['PATTERN_TYPE_CD'] == 'FREE'){	//무료배송조건
                                    $goods_deli_price = 0;	?>
                                    <input type="hidden" name="goods_delivery_price[]" value=0>
                                <? } else {
                                    $goods_deli_price = 0;	?>
                                    <input type="hidden" name="goods_delivery_price[]" value=0>
                                <? }
                            } else { ?>
                                <input type="hidden" name="goods_delivery_price[]" value=0>
                                <? $goods_deli_price = 0;
                            }?>


                            <?
                        } else if($group_goods == "Y"){ 	//체크해제했을때 배송비를 어떻게 계산해주는지가 관건?>

                            <? $goods_deli_price	= 0;
                            if( $row['DELI_LIMIT'] == 0 || $row['DELI_LIMIT']>$selling_price ){	//상품별 배송비
                                if($row['PATTERN_TYPE_CD'] == 'STATIC'){	//갯수대로 배송비 부과
                                    $goods_deli_price = $row['DELI_COST']*$row['GOODS_CNT'];	?>
                                    <input type="hidden" name="goods_delivery_price[]" value="<?=$row['DELI_COST']*$row['GOODS_CNT']?>">
                                <? } else if($row['PATTERN_TYPE_CD'] == 'PRICE'){	//가격조건
                                    $goods_deli_price = $row['DELI_COST'];	?>
                                    <input type="hidden" name="goods_delivery_price[]" value="<?=$row['DELI_COST']?>">
                                <? } else if($row['PATTERN_TYPE_CD'] == 'FREE'){	//무료배송조건
                                    $goods_deli_price = 0;	?>
                                    <input type="hidden" name="goods_delivery_price[]" value=0>
                                <? } else {
                                    $goods_deli_price = 0;	?>
                                    <input type="hidden" name="goods_delivery_price[]" value=0>
                                <? }
                            } else {?>
                                <input type="hidden" name="goods_delivery_price[]" value=0>
                                <?	$goods_deli_price = 0;
                            }
                        }?>
                        <input type="hidden" name="group_text[]" value="">
                        <strong class="price">
								<span name="goods_apply_price[]">
								<? if($group_goods == 'Y' && $group_deli_price >= 0){	?>
                                    <?=number_format((($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT']) - ($seller_cpn_price + $item_cpn_price))?>
                                <? } else {	?>
                                    <?=number_format((($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT']) - ($seller_cpn_price + $item_cpn_price) + $goods_deli_price)?>
                                <? }?>
								</span>
                            <span class="won">원</span>
                        </strong>
                        <span class="price-explain">판매가 <strong class="bold"><?=number_format(($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT'])?></strong> - 할인 <strong class="bold"><span name="discount_price<?=$cart_idx?>"><?=number_format(($seller_cpn_price + $item_cpn_price))?></span></strong>원<br>
                                할인적용 금액 : <strong class="bold"><span name="sale_price<?=$cart_idx?>"><?=number_format($selling_price)?></span> 원</strong>
                                + 배송비
								<span name="goods_delivery[]">
								<? if($row['PATTERN_TYPE_CD'] != 'NONE'){
                                    if($group_goods == 'Y' && $group_deli_price >= 0){	?>
                                        <del><strong class="bold"><?=number_format($goods_deli_price)?></strong>원</del>
                                        <br />*묶음 배송비 할인 적용중입니다.
                                    <? } else {	?>
                                        <strong class="bold"><?=number_format($goods_deli_price)?></strong>원
                                    <? }
                                } else {?>
                                    착불
                                <?	}?>
								</span>
							</span>
                    </div>
                    <? if($group_goods == "N"){
                        $group_goods = "Y";
                    }	?>
                    <div class="prd-order-btns">
                        <a href="#cartCouponLayer<?=$cart_idx?>" class="btn-gray btn-gray--min btn-coupon-change" data-layer="bottom-layer-open2">쿠폰변경</a>
                        <a href="#cartDeliveryLayer<?=$cart_idx?>" class="btn-white btn-white--bold btn-add-delivery-charge" data-layer="bottom-layer-open2">지역별 추가배송비</a>
                    </div>
                    <a href="javascript://" onClick="jsDelGoods('A','<?=$row['CART_NO']?>');" class="btn-prd-order-delete"><span class="hide">장바구니에서 삭제</span></a>
                </div>
                <!-- Google Tag Manager Add Value (eMnet) 2018.05.29-->
                <script>
                    brandIds.push('<?=$row['GOODS_CD']?>');
                </script>
                <!-- End Google Tag Manager Add Value (eMnet) 2018.05.29-->
                <!--장바구니 변수	-->
            <input type="hidden" name="cart_code[]"					value="<?=$row['CART_NO']?>">
            <input type="hidden" name="deli_code[]"					value="<?=$row['DELI_CODE']?>||<?=$group_deli_price?>">
            <input type="hidden" name="chk_deli_code[]"				value="<?=$row['DELI_CODE']?>||<?=$group_deli_price?>">	<!--선택상품 주문시 묶음배송비가 변경되면서 deli_code값도 변경되어서 생성 -->
            <input type="hidden" name="goods_code[]"				value="<?=$row['GOODS_CD']?>">
            <input type="hidden" name="goods_name[]"				value="<?=$row['GOODS_NM']?>">
            <input type="hidden" name="goods_state_code[]"			value="<?=$row['GOODS_STS_CD']?>">
            <input type="hidden" name="goods_cate_code1[]"			value="<?=$row['CATEGORY_MNG_CD1']?>">
            <input type="hidden" name="goods_cate_code2[]"			value="<?=$row['CATEGORY_MNG_CD2']?>">
            <input type="hidden" name="goods_cate_code3[]"			value="<?=$row['CATEGORY_MNG_CD3']?>">
            <input type="hidden" name="brand_code[]"				value="<?=$row['BRAND_CD']?>">
            <input type="hidden" name="brand_name[]"				value="<?=$row['BRAND_NM']?>">
            <input type="hidden" name="goods_option_code[]"			value="<?=$row['GOODS_OPTION_CD']?>">
            <input type="hidden" name="goods_option_name[]"			value="<?=$row['GOODS_OPTION_NM']?>">
            <input type="hidden" name="goods_option_add_price[]"	value="<?=$row['GOODS_OPTION_ADD_PRICE']?>">
            <input type="hidden" name="goods_option_qty[]"			value="<?=$row['GOODS_OPTION_QTY']?>">	<!--잔여수량-->
            <input type="hidden" name="goods_img[]"					value="<?=$row['GOODS_IMG']?>">
            <input type="hidden" name="goods_price_code[]"			value="<?=$row['GOODS_PRICE_CD']?>">
            <input type="hidden" name="goods_selling_price[]"		value="<?=$row['SELLING_PRICE']?>">
            <input type="hidden" name="goods_street_price[]"		value="<?=$row['STREET_PRICE']?>">
            <input type="hidden" name="goods_factory_price[]"		value="<?=$row['FACTORY_PRICE']?>">
            <input type="hidden" name="goods_discount_price[]"	value="<?=($seller_cpn_price+$item_cpn_price)/$row['GOODS_CNT']?>">	<!--셀러쿠폰+아이템쿠폰 1개당-->
            <input type="hidden" name="goods_mileage_save_rate[]"	value="<?=$row['GOODS_MILEAGE_SAVE_RATE']?>">
            <input type="hidden" name="goods_coupon_code_s[]"		value="<?=isset($row['SELLER_COUPON_CD']) ? $row['SELLER_COUPON_CD'] : ""?>">	<!--할인쿠폰코드(셀러)-->
            <input type="hidden" name="goods_coupon_amt_s[]"		value="<?=$seller_cpn_price/$row['GOODS_CNT']?>">	<!--쿠폰할인적용금액(셀러쿠폰)-->
            <input type="hidden" name="goods_coupon_code_i[]"		value="<?=isset($row['ITEM_COUPON_CD']) ? $row['ITEM_COUPON_CD'] : ""?>">		<!--할인쿠폰코드(아이템)-->
            <input type="hidden" name="goods_coupon_amt_i[]"		value="<?=$item_cpn_price/$row['GOODS_CNT']?>">		<!--쿠폰할인적용금액(아이템쿠폰)-->
                                                                                                                           <!--					<input type="hidden" name="goods_coupon_num[]"		value="">	<!--할인쿠폰번호-->
                                                                                                                           <!--2017-02-23 CUST_COUPON_NO 추가	-->
            <input type="hidden" name="goods_add_coupon_no[]"		value="">	<!--추가할인쿠폰코드의번호...? cust_coupon_no컬럼-->
            <input type="hidden" name="goods_add_coupon_code[]"		value="">	<!--추가할인쿠폰코드-->
            <input type="hidden" name="goods_add_coupon_num[]"		value="">	<!--추가할인쿠폰번호-->
            <input type="hidden" name="goods_add_coupon_type[]"		value="">	<!--추가할인쿠폰 지급방식-->
            <input type="hidden" name="goods_add_coupon_gubun[]"	value="">	<!--추가할인쿠폰 구분-->
            <input type="hidden" name="goods_add_discount_price[]"	value=0>	<!--추가할인쿠폰적용금액-->
            <input type="hidden" name="deli_policy_no[]"			value="<?=$row['DELIV_POLICY_NO']?>">
            <input type="hidden" name="deli_cost[]"					value="<?=$row['DELI_COST']?>">	<!-- 개별 배송비 -->
            <input type="hidden" name="deli_limit[]"				value="<?=$row['DELI_LIMIT']?>">
            <input type="hidden" name="deli_pattern[]"				value="<?=$row['PATTERN_TYPE_CD']?>">
            <input type="hidden" name="send_nation[]"				value="<?=$row['SEND_NATION']?>">	<!--출고국가-->
            <input type="hidden" name="goods_buy_limit_qty[]"		value="<?=$row['BUY_LIMIT_QTY']?>"> <!--구매제한 수량-->
            <input type="hidden" name="goods_tax_gb_cd[]"           value="<?=$row['TAX_GB_CD']?>"> <!--과세 구분-->


            <?	$total_goods_price	+= (($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT']);
            $goods_mileage_save	+= ($row['SELLING_PRICE']*$row['GOODS_CNT']) * ($row['GOODS_MILEAGE_SAVE_RATE']/1000);	//적립예정마일리지
            $cart_idx++;
            }
            $total_group_deli_price += $group_deli_price;
            $idx2++;
            }
            } else {?>
                <div class="prd-order-section">
                    <h3 class="prd-order-section-title" align=center>장바구니에 담긴 상품이 없습니다.</h3>
                </div>
            <? }?>

            <div class="prd-all-price-box">
                <dl class="prd-all-price-line">
                    <dt class="title">총 상품금액 (상품 <span name="order_total_goods_cnt"><?=$cart_idx?></span>개)</dt>
                    <dd class="price"><span name="total_goods_price">1,109,000</span><span class="won">원</span></dd>
                </dl>
                <dl class="prd-all-price-line">
                    <dt class="title"><span class="minus"></span>총 할인금액</dt>
                    <dd class="price"><span name="total_discount_price">52,240</span><span class="won">원</span></dd>
                </dl>
                <dl class="prd-all-price-line">
                    <dt class="title"><span class="plus"></span>총 배송비</dt>
                    <dd class="price"><span name="total_delivery_price">10,000</span><span class="won">원</span></dd>
                </dl>
                <dl class="prd-all-price-line prd-all-price-line--total">
                    <dt class="title">결제 예정 금액</dt>
                    <dd class="price"><span name="payment_price">1,066,760</span><span class="won">원</span></dd>
                </dl>


                <ul class="common-btn-box">
                    <li class="common-btn-item"><a href="javascript://" onClick="jsStep2('Choice','');" class="btn-gray btn-gray--big">선택상품주문</a></li>
                    <li class="common-btn-item"><a href="javascript://" onClick="jsStep2('All','');" class="btn-black btn-black--big">전체상품주문</a></li>
                </ul>

                <input type="hidden" value="<?=$ENABLE?>" name="np_enable_yn" id="np_enable_yn">
                <div class="naverpay">
                    <script type="text/javascript" src="https://pay.naver.com/customer/js/mobile/naverPayButton.js" charset="UTF8"></script>
                    <script type="text/javascript" >
                        naver.NaverPayButton.apply({
                            BUTTON_KEY: "CC68CEA7-3129-4153-8D29-BE38810016E1", // 네이버페이에서 제공받은 버튼 인증 키 입력
                            TYPE: "MA", // 버튼 모음 종류 설정
                            COLOR: 1, // 버튼 모음의 색 설정
                            COUNT: 1, // 버튼 개수 설정. 구매하기 버튼만 있으면 1, 찜하기 버튼도 있으면 2를 입력.
                            ENABLE: "<?=$ENABLE?>", // 품절 등의 이유로 버튼 모음을 비활성화할 때에는 "N" 입력
                            BUY_BUTTON_HANDLER: jsNaverPay, // 구매하기 버튼 이벤트 Handler 함수 등록, 품절인 경우 not_buy_nc 함수 사용
                            "":""
                        });

                        function jsNaverPay() {
                            if(document.getElementsByName("cart_code[]").length < 1){
                                alert("장바구니에 담긴 상품이 없습니다.");
                                return false;
                            }

                            if($("#np_enable_yn").val() == 'N'){
                                alert('네이버페이를 통한 구매가 불가한 상품입니다.');
                                return false;
                            }

                            var order_yn = 'Y';

                            if($("input[name='chkGoods[]']").is(':checked') == false){
                                alert("선택하신 상품이 없습니다. 상품을 선택해주세요.");
                                return false;
                            }

                            $("input:checkbox[name='chkGoods[]']:checked").each(function() {	    // 체크된 것만 값을 뽑아서 배열에 push
                                var idx = $(this).val().split("||")[0];

                                if(document.getElementsByName("goods_state_code[]")[idx].value != 03){	//판매중인 상품이 아니면
                                    alert("선택한 상품중 판매가 불가능한 상품이 있습니다.");
                                    order_yn = 'N';
                                    return false;
                                }

                                if(document.getElementsByName("goods_option_qty[]")[idx].value == 0){	//옵션품절
                                    alert("선택한 상품중 옵션이 품절된 상품이 있습니다.");
                                    order_yn = 'N';
                                    return false;
                                }
                            });

                            if(order_yn == 'Y'){
                                document.getElementById("order_gb").value = "NP";
                            } else {
                                return false;
                            }

                            var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
                            var frm = document.getElementById("buyForm");
                            frm.action = "https://"+SSL_val+"/order/naver_pay";
                            frm.submit();
                        }
                    </script>
                </div>
            </div>

            <div class="notice-section notice-section--bg">
                <h4 class="notice-section-title"><span class="ico-i">i</span>장바구니 이용안내</h4>
                <ul class="text-list">
                    <li class="text-item">업체별로 배송비가 다를 수 있으며, 자세한 내용은 상품상세페이지의 설명을 참조하시기 바랍니다.</li>
                    <li class="text-item">장바구니의 총 예상 결제금액은 쿠폰 및 기타할인, 배송정보가 확정되지 않은 예정 가격으로 실제 최종 결제금액과 차이가 있을 수 있습니다.</li>
                </ul>
            </div>
        </div>
    </form>

    <?	if(count($cart) != 0){
        $idx = 0;
        foreach($cart as $cart_grp){
            foreach($cart_grp as $row){
                $seller_coupon_max	= isset($row['SELLER_COUPON_MAX']) ? $row['SELLER_COUPON_MAX'] : 0;
                $item_coupon_max	= isset($row['ITEM_COUPON_MAX']) ? $row['ITEM_COUPON_MAX'] : 0;
                $seller_coupon_amt	= isset($row['SELLER_COUPON_AMT']) ? $row['SELLER_COUPON_AMT'] : 0;
                $item_coupon_amt	= isset($row['ITEM_COUPON_AMT']) ? $row['ITEM_COUPON_AMT'] : 0;

                if($seller_coupon_amt > $seller_coupon_max && $seller_coupon_max != 0){
                    $seller_coupon_amt	= $seller_coupon_max * $row['GOODS_CNT'];
                } else {
                    $seller_coupon_amt	= $seller_coupon_amt * $row['GOODS_CNT'];
                }

                if($item_coupon_amt > $item_coupon_max && $item_coupon_max != 0){
                    $item_coupon_amt	= $item_coupon_max * $row['GOODS_CNT'];
                } else {
                    $item_coupon_amt	= $item_coupon_amt * $row['GOODS_CNT'];
                }

                $goods_price = $row['SELLING_PRICE']*$row['GOODS_CNT'];
                ?>

                <!-- 쿠폰적용하기 레이어 // -->
                <div class="common-layer-wrap cart-coupon-layer" id="cartCouponLayer<?=$idx?>">
                    <!-- common-layer-wrap--view 추가 -->
                    <h3 class="common-layer-title">쿠폰 적용하기</h3>

                    <!-- common-layer-content // -->
                    <div class="common-layer-content">
                        <div class="basic-table-wrap">
                            <table class="basic-table">
                                <colgroup>
                                    <col style="width:30%;">
                                    <col style="width:47%;">
                                    <col style="width:23%;">
                                </colgroup>
                                <tr>
                                    <th scope="row" class="tb-info-title">할인구분</th>
                                    <th scope="row" class="tb-info-title">쿠폰명</th>
                                    <th scope="row" class="tb-info-title">할인액</th>
                                </tr>
                                <tr>
                                    <td class="tb-info-txt">판매자할인</td>
                                    <td class="tb-info-txt">
                                        <ul>
                                            <? $idx2 = 0;
                                            if($row['AUTO_COUPON_LIST']){
                                                foreach($row['AUTO_COUPON_LIST'] as $row2)	{
                                                    if($row2['COUPON_KIND_CD'] == 'SELLER'){

                                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($row2['COUPON_SALE']/100*$goods_price) : floor($row2['COUPON_SALE']*$row['GOODS_CNT']);

                                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                                        ?>
                                                        <li class="tb-info-txt-item">
                                                            <label>
                                                                <input type="radio" class="common-radio-btn" name="coupon_select_S<?=$idx?>" id="coupon_1_1"  value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=($row2['COUPON_PRICE']/$row['GOODS_CNT'])?>||<?=$row2['MAX_DISCOUNT']?>" checked>
                                                                <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액 -->
                                                                <p class="tb-info-txt-right"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                                    <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                                </p>
                                                            </label>
                                                        </li>
                                                        <?  $coupon_S_text = $row2['MAX_DISCOUNT'] < ($row2['COUPON_PRICE']/$row['GOODS_CNT']) && $row2['MAX_DISCOUNT'] != 0 ? number_format($row2['MAX_DISCOUNT']*$row['GOODS_CNT']) : number_format($row2['COUPON_PRICE']);
                                                        $idx2++;
                                                    }//END IF
                                                    else if($row2['COUPON_KIND_CD'] != 'GOODS' || count($row['AUTO_COUPON_LIST']) == 1){	?>
                                                        <li class="tb-info-txt-item">
                                                            적용 가능 쿠폰이 없습니다.
                                                        </li>
                                                        <?
                                                        $coupon_S_text = 0;
                                                    }
                                                }//END FOREACH
                                            }//END IF
                                            else {	?>
                                                <li class="tb-info-txt-item">
                                                    적용 가능 쿠폰이 없습니다.
                                                </li>
                                                <?
                                                $coupon_S_text = 0;
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                    <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 셀러쿠폰이 몇개인지 알려주는 변수 -->
                                    <input type="hidden"	name="seller_coupon_cnt[]"			value="<?=$idx2?>">
                                    <td class="tb-info-txt">
                                        <?=$coupon_S_text?>원
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb-info-txt">에타할인</td>
                                    <td class="tb-info-txt">
                                        <ul>
                                            <? $idx2 = 0;
                                            $ITEM_COUPON_YN = '';
                                            $coupon_E_text = 0;
                                            if($row['AUTO_COUPON_LIST'] || $row['CUST_COUPON_LIST']){
                                                foreach($row['AUTO_COUPON_LIST'] as $row2)	{
                                                    if($row2['COUPON_KIND_CD'] == 'GOODS'){

                                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($row2['COUPON_SALE']/100*$goods_price) : floor($row2['COUPON_SALE']*$row['GOODS_CNT']);

                                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                                        ?>
                                                        <li class="tb-info-txt-item">
                                                            <label>
                                                                <input type="radio" class="common-radio-btn" name="coupon_select_E<?=$idx?>" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=($row2['COUPON_PRICE']/$row['GOODS_CNT'])?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_I" checked>
                                                                <p id="coupon_name_E<?=$idx?>_<?=$idx2?>" class="tb-info-txt-right"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                                    <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                                </p>
                                                            </label>
                                                        </li>
                                                        <?	$coupon_E_text = $row2['MAX_DISCOUNT'] < ($row2['COUPON_PRICE']/$row['GOODS_CNT']) && $row2['MAX_DISCOUNT'] != 0 ? number_format($row2['MAX_DISCOUNT']*$row['GOODS_CNT']) : number_format($row2['COUPON_PRICE']);	//COUPON_PRICE에 이미 CNT가격포함
                                                        ?>

                                                        <?		$ITEM_COUPON_YN = 'Y';
                                                        $idx2++;
                                                    }
                                                }	//END FOREACH
                                                foreach($row['CUST_COUPON_LIST'] as $row2)	{
                                                    if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'N' && $row2['MIN_AMT'] < (($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])){
                                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods_price : $row2['COUPON_SALE']*$row['GOODS_CNT'];

                                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환

                                                        ?>
                                                        <li class="tb-info-txt-item">
                                                            <label>
                                                                <input type="radio" class="common-radio-btn" name="coupon_select_E<?=$idx?>" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']/$row['GOODS_CNT']?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_B||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
                                                                <p id="coupon_name_E<?=$idx?>_<?=$idx2?>" class="tb-info-txt-right"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                                    <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                                </p>
                                                            </label>
                                                        </li>
                                                        <?	if(!$row['AUTO_COUPON_LIST']){
                                                            $coupon_E_text = 0;
                                                        }
                                                        if($ITEM_COUPON_YN == ''){
                                                            $ITEM_COUPON_YN = 'N';
                                                        }

                                                        $idx2++;
                                                    }
                                                }	//END FOREACH

                                                if(($row['AUTO_COUPON_LIST'] && ($row['AUTO_COUPON_LIST'][0]['COUPON_KIND_CD'] == 'GOODS') || (@$row['AUTO_COUPON_LIST'][1]['COUPON_KIND_CD'] == 'GOODS')) || $row['CUST_COUPON_LIST']){
                                                    ?>
                                                    <li class="tb-info-txt-item">
                                                        <label>
                                                            <input type="radio" class="common-radio-btn" name="coupon_select_E<?=$idx?>" class="radio" id="coupon_E<?=$idx?>_<?=$idx2?>" value="" onClick="javascript:Coupon_check('EN',this.value,<?=$idx?>,<?=$idx2?>);"<?if($ITEM_COUPON_YN == 'N'){?>checked<?}?>>
                                                            <p class="tb-info-txt-right">쿠폰 적용 안함</p>
                                                        </label>
                                                    </li>
                                                    <?
                                                } else {	?>
                                                    <li class="tb-info-txt-item">
                                                        적용 가능 쿠폰이 없습니다.
                                                    </li>
                                                    <?		$coupon_E_text = 0;
                                                }

                                            }	//END IF
                                            else {	?>
                                                <li class="tb-info-txt-item">
                                                    적용 가능 쿠폰이 없습니다.
                                                </li>
                                                <?
                                                $coupon_E_text = 0;
                                            }
                                            ?>

                                        </ul>
                                    </td>
                                    <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 셀러쿠폰이 몇개인지 알려주는 변수 -->
                                    <input type="hidden"	name="item_coupon_cnt[]"			value="<?=$idx2?>">
                                    <td class="tb-info-txt">
                                        <span name="coupon_E_text<?=$idx?>"><?=$coupon_E_text?></span>원
                                    </td>
                                </tr>
                                <tr id="dup_coupon_<?=$idx?>">
                                    <td class="tb-info-txt">에타중복할인</td>
                                    <td class="tb-info-txt">
                                        <ul>
                                            <? $idx2 = 0;
                                            if($row['CUST_COUPON_LIST']){
                                                foreach($row['CUST_COUPON_LIST'] as $row2)	{
                                                    if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'Y' && $row2['MIN_AMT'] < (($row['SELLING_PRICE']+$row['GOODS_OPTION_ADD_PRICE'])*$row['GOODS_CNT'])){	//최소금액 이상일때 보임

                                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods_price : $row2['COUPON_SALE']*$row['GOODS_CNT'];

                                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                                        ?>
                                                        <li class="tb-info-txt-item">
                                                            <label>
                                                                <input type="radio" class="common-radio-btn" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('C',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']/$row['GOODS_CNT']?>||<?=$row2['MAX_DISCOUNT'] ? $row2['MAX_DISCOUNT'] : 0?>||<?=$row2['COUPON_DTL_NO']?>||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
                                                                <p class="tb-info-txt-right" id="coupon_name_C<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                                    <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                                                </p>
                                                            </label>
                                                        </li>
                                                        <? $idx2++;
                                                    }	//END IF
                                                } //END FOREACH

                                                if($idx2>0){	//최소금액 이상일때 보임?>
                                                    <li class="tb-info-txt-item">
                                                        <label>
                                                            <input type="radio" class="common-radio-btn"  name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="" onClick="javascript:Coupon_check('CN',this.value,<?=$idx?>,<?=$idx2?>);" checked>
                                                            <p class="tb-info-txt-right">쿠폰 적용 안함</p>
                                                        </label>
                                                    </li>
                                                <? } else {	?>
                                                    <input type="hidden" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="">
                                                    <li class="tb-info-txt-item">
                                                        적용 가능 쿠폰이 없습니다.
                                                    </li>
                                                <? } ?>
                                                <?
                                                $coupon_C_text = 0;
                                            } //END IF
                                            else {?>
                                                <input type="hidden" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="">
                                                <li class="tb-info-txt-item">
                                                    적용 가능 쿠폰이 없습니다.
                                                </li>
                                                <?
                                                $coupon_C_text = 0;
                                            } ?>


                                        </ul>
                                    </td>
                                    <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 추가쿠폰이 몇개인지 알려주는 변수 -->
                                    <input type="hidden"	name="add_coupon_cnt[]"			value="<?=$idx2?>">
                                    <td class="tb-info-txt">
                                        <span name="coupon_C_text<?=$idx?>"><?=$coupon_C_text?></span>원
                                    </td>
                                </tr>
                                <!-- seller & item value :: 쿠폰코드||쿠폰명||할인금액||최대할인금액)
                                     cust value :: 쿠폰코드||쿠폰명||할인금액||최대할인금액||쿠폰번호||쿠폰지급방식||중복여부)	-->
                                <input type="hidden" name="goods_seller_coupon_<?=$idx?>"		value="">
                                <input type="hidden" name="goods_item_coupon_<?=$idx?>"			value="">
                                <input type="hidden" name="goods_cust_coupon_<?=$idx?>"			value="">
                                <tr>
                                    <td colspan="3" class="tb-info-txt tb-info-total">쿠폰할인 총액 <strong class="total-color"><span name="coupon_total_amt_<?=$idx?>"><?=number_format(($seller_coupon_amt+$item_coupon_amt))?></span></strong><span class="tb-info-total-color">원</span></td>
                                </tr>
                            </table>
                        </div>

                        <ul class="text-list">
                            <li class="text-item">할인쿠폰은 판매가 기준으로 할인율 적용됩니다.</li>
                        </ul>
                        <ul class="common-btn-box common-btn-box--layer">
                            <li class="common-btn-item"><a href="javascript://" onClick="jsReset(<?=$idx?>,'CPN');" class="btn-gray-link" >적용취소</a></li>
                            <li class="common-btn-item"><a href="javascript://" onClick="Coupon_apply(<?=$idx?>);" class="btn-black-link">쿠폰적용</a></li>
                        </ul>
                        <!-- // common-layer-button -->
                    </div>
                    <!-- // common-layer-content -->

                    <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
                </div>

                <!-- // 쿠폰적용하기 레이어 -->

                <!-- 지역별 추가배송비 확인 레이어 // -->
                <div class="common-layer-wrap cart-delivery-layer" id="cartDeliveryLayer<?=$idx?>">
                    <!-- common-layer-wrap--view 추가 -->
                    <h3 class="common-layer-title">지역별 추가 배송비 확인</h3>
                    <div class="common-layer-content">
                        <div class="basic-table-wrap">
                            <table class="basic-table">
                                <colgroup>
                                    <col style="width:40%;">
                                    <col style="width:60%;">
                                </colgroup>
                                <tr>
                                    <th scope="row" class="tb-info-title">상품정보</th>
                                    <td class="tb-info-txt"><?=$row['BRAND_NM']?><br><?=$row['GOODS_NM']?><br><?=$row['GOODS_OPTION_NM']?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="tb-info-title">지역별 추가 배송비</th>
                                    <td class="tb-info-txt">제주도 및 도서산간지역<br> 추가 운임 발생 가능<br> (수도권 외 지역 추가운임은 상품페이지 내 설명 참조)</td>
                                </tr>
                            </table>
                            <ul class="text-list">
                                <li class="text-item">상품별로 배송비 및 추가배송비가 다르게 적용됩니다.</li>
                                <li class="text-item">택배사를 통해 배송되는 상품의 경우, 지역별 추가운임을 상품 페이지 내 설명에서 꼭 확인해주십시오.</li>
                                <li class="text-item">업체직접배송 또는 설치배송 상품의 경우, 사전에 고객님께 연락을 하고 배송 및 설치를 진행하는 과정에서 추가배송비를 확인하실 수 있으며, 일정 기간 내 연락 부재 시 1:1문의 또는 고객센터로 문의하여 주십시오.</li>
                            </ul>

                            <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
                        </div>
                    </div>
                </div>

                <!-- 옵션변경 레이어 // -->
                <div class="common-layer-wrap option-change-layer" id="optionChangeLayer<?=$idx?>">
                    <!-- common-layer-wrap--view 추가 -->
                    <h3 class="common-layer-title">옵션변경</h3>

                    <!-- common-layer-content // -->
                    <div class="common-layer-content">
                        <input type="hidden"	name="dup_option" value="N">		<!-- 중복 옵션 선택 여부-->
                        <div class="media-area prd-order-media">
                            <span class="media-area-img prd-order-media-img"><img src="<?=$row['GOODS_IMG']?>" alt=""></span>
                            <span class="media-area-info prd-order-media-info">
                <span class="prd-order-media-info-brand"><?=$row['GOODS_NM']?></span>
							<span class="prd-order-media-info-price"><strong class="bold"><?=number_format($row['SELLING_PRICE'])?></strong><span class="won">원</span></span>
							</span>
                        </div>
                        <div class="option-change-select">
                            <h3 class="info-title info-title--sub">상품옵션 선택</h3>
                            <div class="option-select">
                                <a href="#" name="option_select_text[]" class="option-select-box" data-option="option-select-box"><?=$row['GOODS_OPTION_NM']?> <? if($row['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? } else if($row['GOODS_OPTION_ADD_PRICE'] < 0){?>(<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? }?>
                                    <? if($row['GOODS_OPTION_QTY'] == 0){?><p style="color:red;">-- 해당 옵션은 품절되었습니다.</p><? }?></a>
                                <div class="option-select-inner">
                                    <ul class="option-select-list">
                                        <? foreach($row['GOODS_OPTION'] as $row2){	?>
                                            <li class="option-select-item"><a href="javascript://" onClick='javascript:jsValiOption("<?=$row2['GOODS_OPTION_CD']?>||<?=$row2['GOODS_OPTION_ADD_PRICE']?>||<?=$row2['QTY']?>","<?=$row2['GOODS_OPTION_NM']?>","<?=$idx?>")' class="option-select-link" title="<?=$row2['GOODS_OPTION_NM']?> <? if($row2['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row2['GOODS_OPTION_ADD_PRICE'])?>원)<? } else if($row2['GOODS_OPTION_ADD_PRICE'] < 0){?>(<?=number_format($row2['GOODS_OPTION_ADD_PRICE'])?>원)<? } if($row2['QTY'] == 0){?> [품절] <?}?>" data-option="option-select-link"><?=$row2['GOODS_OPTION_NM']?> <? if($row2['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row2['GOODS_OPTION_ADD_PRICE'])?>원)<? } else if($row2['GOODS_OPTION_ADD_PRICE'] < 0){?>(<?=number_format($row2['GOODS_OPTION_ADD_PRICE'])?>원)<? } if($row2['QTY'] == 0){?> [품절] <?}?></a></li>
                                        <? }?>
                                    </ul>
                                    <a href="#" class="btn-close" data-option="option-select-close"><span class="hide">닫기</span></a>
                                </div>
                            </div>
                        </div>

                        <div class="option-change-apply">
                            <h3 class="info-title info-title--sub">변경된 옵션 적용</h3>
                            <p class="prd-name"><?=$row['GOODS_NM']?></p>
                            <p name="chk_option_name[]" class="prd-option"><?=$row['GOODS_OPTION_NM']?> <? if($row['GOODS_OPTION_ADD_PRICE'] > 0){?>(+<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? } else if($row['GOODS_OPTION_ADD_PRICE'] < 0){?>(<?=number_format($row['GOODS_OPTION_ADD_PRICE'])?>원)<? } if($row['GOODS_OPTION_QTY'] == 0){?> [품절] <?}?></p><p class="prd-option" name="duplicate_option[]"></p>
                            <div class="select-box select-box--arrow" style="width: 43px;">
                                <select class="select-box-inner" id="option_cnt<?=$idx?>" name="option_cnt[]" onChange="javascript:jsOptionCnt(<?=$idx?>,this.value);">
                                    <option value="1" <?if($row['GOODS_CNT'] == 1){?>selected<?}?>>1</option>
                                    <option value="2" <?if($row['GOODS_CNT'] == 2){?>selected<?}?>>2</option>
                                    <option value="3" <?if($row['GOODS_CNT'] == 3){?>selected<?}?>>3</option>
                                    <option value="4" <?if($row['GOODS_CNT'] == 4){?>selected<?}?>>4</option>
                                    <option value="5" <?if($row['GOODS_CNT'] == 5){?>selected<?}?>>5</option>
                                    <option value="6" <?if($row['GOODS_CNT'] == 6){?>selected<?}?>>6</option>
                                    <option value="7" <?if($row['GOODS_CNT'] == 7){?>selected<?}?>>7</option>
                                    <option value="8" <?if($row['GOODS_CNT'] == 8){?>selected<?}?>>8</option>
                                    <option value="9" <?if($row['GOODS_CNT'] == 9){?>selected<?}?>>9</option>
                                    <option value="10" <?if($row['GOODS_CNT'] == 10){?>selected<?}?>>10</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="select_option_code[]" value="<?=$row['GOODS_OPTION_CD']?>">
                        <div class="option-change-price">
                            <span class="title">총 주문금액</span>
                            <strong class="price"><span name="total_option_price[]"><?=number_format(($row['SELLING_PRICE'] + $row['GOODS_OPTION_ADD_PRICE']) * $row['GOODS_CNT'])?></span><span>원</span></strong>
                        </div>
                        <ul class="common-btn-box common-btn-box--layer">
                            <li class="common-btn-item"><a href="#" class="btn-gray-link" data-close="bottom-layer-close2">변경취소</a></li>
                            <li class="common-btn-item"><a href="javascript://" onClick="javascript:jsChgcart(<?=$row['CART_NO']?>,'OPT',<?=$idx?>,'')" class="btn-black-link">옵션변경</a></li>
                        </ul>
                    </div>
                    <!-- // common-layer-content -->

                    <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
                </div>

                <!-- // 옵션변경 레이어 -->
                <?	$idx ++;
            }
        }
    }?>
    <!-- // 지역별 추가배송비 확인 레이어 -->

</div>


<script src="/assets/js2/cart_coupon.js"></script>
<script type="text/javascript">
    /******************************************************/
    /** 쿠폰 관련 함수는 /assets/js2/cart_coupon.js 참고 **/
    /******************************************************/
    var cart_cnt = "<?=$cart_idx?>";
    $('span[name=check_count]').text('('+cart_cnt+'/'+cart_cnt+')');

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

    /***************************/
    /** 옵션레이어의 변경수량 **/
    /***************************/
    function jsOptionCnt(idx,cnt){
        var limit_cnt = parseInt(document.getElementsByName("limit_cnt[]")[idx].value);

        if(limit_cnt < cnt){
            alert('1회 최대 구매수는 '+limit_cnt+' 개 입니다');
            $("#option_cnt"+idx).val(limit_cnt);
            return false;
        }

        document.getElementsByName("total_option_price[]")[idx].innerText = numberFormat((parseInt(document.getElementsByName("goods_selling_price[]")[idx].value) + parseInt(document.getElementsByName("goods_option_add_price[]")[idx].value)) * parseInt(cnt));
    }

    /***********************/
    /** 옵션 선택 값 비교 **/
    /***********************/
    function jsValiOption(option_value,option_name,idx){
        if(option_value.split("||")[2] == 0){
            alert("해당 옵션은 품절입니다. 다른 옵션을 선택해주세요.");
            document.getElementsByName("total_option_price[]")[idx].innerText = numberFormat((parseInt(document.getElementsByName("goods_selling_price[]")[idx].value) + parseInt(document.getElementsByName("goods_option_add_price[]")[idx].value)) * parseInt(document.getElementsByName("goods_cnt[]")[idx].value));

            return false;
        }

        document.getElementsByName("option_cnt[]")[idx].value = 1;	//옵션 선택할 경우 수량 1개로 초기화

        $($("p[name='duplicate_option[]']").get(idx)).html("");
        $("input[name=dup_option]").val('N');	//중복옵션선택 비교값

        var option_code = option_value.split("||")[0];
        var add_option_price = option_value.split("||")[1];

        for(var i=0; i<cart_cnt; i++){
            if(i != idx){
                if(document.getElementsByName("goods_option_code[]")[i].value == option_code){
                    $($("p[name='duplicate_option[]']").get(idx)).html("<font style='color:red'><b>이미 선택한 옵션입니다.</b></font>");
                    $("input[name=dup_option]").val('Y');
                    break;
                }
            }
        }

        if(option_value.split("||")[1] > 0){
            $($("p[name='chk_option_name[]']").get(idx)).text(option_name+' (+'+numberFormat(option_value.split("||")[1])+'원)');
        } else if(option_value.split("||")[1] < 0){
            $($("p[name='chk_option_name[]']").get(idx)).text(option_name+' ('+numberFormat(option_value.split("||")[1])+')');
        } else {
            $($("p[name='chk_option_name[]']").get(idx)).text(option_name);
        }

        document.getElementsByName("select_option_code[]")[idx].value = option_code;

////	document.getElementsByName("goods_option_add_price[]")[idx].value = add_option_price;

        var cnt = document.getElementsByName("option_cnt[]")[idx].value;		//옵션선택수량
        document.getElementsByName("total_option_price[]")[idx].innerText = numberFormat((parseInt(document.getElementsByName("goods_selling_price[]")[idx].value) + parseInt(add_option_price)) * parseInt(cnt));	//선택한 옵션금액 재계산
    }

    //===============================================================
    // 장바구니 선택항목에서 제거
    //===============================================================
    function jsDelGoods(gb, cart_no){


        if(gb == 'A'){	//바로 제거


            //google_gtag
            gtag('event', 'remove_from_cart', {
                "items": [
                    {
                        "id": cart_no
                    }
                ]
            });
//        ga('require', 'ecommerce', 'ecommerce.js');
//        ga('ecommerce:addProduct', {
//                'cart_no': cart_no
//        });
//        ga('ecommerce:setAction', 'remove');
//        ga('send', 'event', 'UX', 'click', 'remove to cart');     // Send data using an event.

            if(confirm("해당 상품을 장바구니에서 제거하시겠습니까?")){
                $.ajax({
                    type: 'POST',
                    url: '/cart/del_cart',
                    dataType: 'json',
                    data: { gb : gb, cart_no : cart_no },
                    error: function(res) {
                        alert('Database Error');
                    },
                    success: function(res) {
                        if(res.status == 'ok'){
                            alert('선택한 상품이 장바구니에서 제거됐습니다.');
                            location.reload();
                        }
                        else alert(res.message);
                    }
                })
            }

        } else if(gb == 'B'){	//선택상품 제거
            var cartArr = [];
            var cartItemsArray = [];

            $("input:checkbox[name='chkGoods[]']:checked").each(function() {
                //        cartArr.push($(this).val());     // 체크된 것만 값을 뽑아서 배열에 push
                cartArr.push($(this).val().split("||")[1]);

            });

            if(cartArr.length == 0){
                alert("삭제할 상품을 선택해주세요.");
                return false;
            }

            for (var a=0; a<cartArr.length; a++)
            {
                var cartItems	= new Object();

                cartItems.id	= cartArr[a];

                cartItemsArray.push(cartItems);
            }
            //google_gtag
            gtag('event', 'remove_from_cart', {
                "items": [
                    {
                        "id": cartItemsArray
                    }
                ]
            });
//        ga('require', 'ecommerce', 'ecommerce.js');
//        for(i = 0; i < cartArr.length; i++) {
//            ga('ecommerce:addProduct', {
//                'id': cartArr[i]
//            });
//        }
//        ga('ecommerce:setAction', 'remove');
//        ga('send', 'event', 'UX', 'click', 'remove to cart');     // Send data using an event.

            if(confirm("선택한 상품을 장바구니에서 제거하시겠습니까?")){
                $.ajax({
                    type: 'POST',
                    url: '/cart/del_cart',
                    dataType: 'json',
                    data: { gb : gb, chkGoods : cartArr },
                    error: function(res) {
                        alert('Database Error');
                    },
                    success: function(res) {
                        if(res.status == 'ok'){
                            alert('선택한 상품이 장바구니에서 제거됐습니다.');
                            location.reload();
                        }
                        else alert(res.message);
                    }
                })
            }
        }	//end if
    }

    //===============================================================
    // 장바구니 수량/옵션 변경
    //===============================================================
    function jsChgcart(cart_no, gb, idx, pVal){
//	for(var i=0; i<cart_cnt; i++){
//		if(i != idx){
//			if(document.getElementsByName("goods_option_code[]")[i].value == pVal.split("||")[0]){
//				alert("해당 옵션상품은 이미 장바구니에 담겨져있습니다. \n다른 옵션을 선택해주세요.");
//				//옵션 초기화
//				document.getElementsByName("select_option[]")[idx].value = document.getElementsByName("goods_option_code[]")[idx].value+"||"+document.getElementsByName("goods_option_add_price[]")[idx].value+"||"+document.getElementsByName("goods_option_qty[]")[idx].value;
//				return false;
//			}
//		}
//	}

//	if(pVal.split("||")[2] == 0){
//		alert("해당 옵션은 품절입니다. 다른 옵션을 선택해주세요.");
//		//옵션 초기화
//		document.getElementsByName("select_option[]")[idx].value = document.getElementsByName("goods_option_code[]")[idx].value+"||"+document.getElementsByName("goods_option_add_price[]")[idx].value+"||"+document.getElementsByName("goods_option_qty[]")[idx].value;
//		return false;
//	}

        if($("input[name=dup_option]").val() == 'Y'){
            alert("해당 옵션상품은 이미 장바구니에 담겨져있습니다. \n다른 옵션을 선택해주세요.");
            return false;
        }
        if(confirm("수량이나 옵션을 변경하게 되면 쿠폰을 다시 재선택하셔야 합니다.")){
            var option_code = '';

            var limit_cnt = parseInt(document.getElementsByName("limit_cnt[]")[idx].value);
            if (limit_cnt == '0'){
                limit_cnt = 1000;
            }

            //	alert(limit_cnt);
            //	alert(pVal);

            if(gb == 'CNT'){
                if(limit_cnt < pVal){
                    alert('1회 최대 구매수는 '+limit_cnt+' 개 입니다');
                    $("#select_cnt"+idx).val(limit_cnt);
                    return false;
                }
                var Chgcnt = pVal;

            } else if(gb == 'OPT'){
                var Chgcnt = document.getElementsByName("option_cnt[]")[idx].value;

                //alert(limit_cnt);

                if(limit_cnt < Chgcnt){
                    alert('1회 최대 구매수는 '+limit_cnt+' 개 입니다');
                    $("#select_cnt"+idx).val(limit_cnt);
                    return false;
                }

                var option_code = document.getElementsByName("select_option_code[]")[idx].value;
            }

            $.ajax({
                type: 'POST',
                url: '/cart/chg_cart',
                dataType: 'json',
                data: { cart_no : cart_no, gb : gb, cnt : Chgcnt, option_code : option_code },
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        location.reload();
                    }
                    else alert(res.message);
                }
            })
        } else {
//		//옵션 초기화
//		document.getElementsByName("select_option[]")[idx].value = document.getElementsByName("goods_option_code[]")[idx].value+"||"+document.getElementsByName("goods_option_add_price[]")[idx].value+"||"+document.getElementsByName("goods_option_qty[]")[idx].value;
//		return false;
        }

    }

    /*********************************/
    /** 체크한 상품들만 금액 재계산 **/
    /*********************************/
    $(function(){
        $("input:checkbox[name='chkGoods[]']").on('click', function(e) {
            var chk_cnt	 = 0;
            if($("input:checkbox[name='chkGoods[]']:checked").val() == undefined){	//체크된 값이 없을 경우
                $('span[name=check_count]').text('('+chk_cnt+'/'+cart_cnt+')');
                $('span[name=order_total_goods_cnt]').text(chk_cnt);
            } else {
                $("input:checkbox[name='chkGoods[]']:checked").each(function() {
                    chk_cnt++;
                    $('span[name=check_count]').text('('+chk_cnt+'/'+cart_cnt+')');
                    $('span[name=order_total_goods_cnt]').text(chk_cnt);
                })
            }
            total_sum_price();	//총 금액 재계산
        })
    })

    /*****************************/
    /** 체크박스 전체선택/해제	**/
    /*****************************/
    function jsChkAll(pBool){
        for (var i=0; i<document.getElementsByName("chkGoods[]").length; i++){
            document.getElementsByName("chkGoods[]")[i].checked = pBool;
        }

        var chk_cnt	 = 0;
        if($("input:checkbox[name='chkGoods[]']:checked").val() == undefined){	//체크된 값이 없을 경우
            $('span[name=check_count]').text('('+chk_cnt+'/'+cart_cnt+')');
            $('span[name=order_total_goods_cnt]').text(chk_cnt);
        } else {
            $("input:checkbox[name='chkGoods[]']:checked").each(function() {
                chk_cnt++;
                $('span[name=check_count]').text('('+chk_cnt+'/'+cart_cnt+')');
                $('span[name=order_total_goods_cnt]').text(chk_cnt);
            })
        }

        total_sum_price();	//총 금액 재계산
    }

    /************************************************/
    /** 총 금액 재계산
     /************************************************/
    var total_sum_price = function()
    {
        var total_goods_price			= 0;
        var total_discount_price		= 0;	//가격할인
        var total_discount_coupon		= 0;	//쿠폰할인
        var total_mileage_save_price	= 0;	//적립예정 마일리지
        var total_delivery_price		= 0;	//묶음배송비 합계
        var group_cnt					= "<?=count($group)?>";	//장바구니에 들어있는 상품의 배송정책종류 갯수
        var delivery_price				= [];	//묶음배송비 배열
        var total_price_by_policy       = {};   //배송 정책 별로 배송비 다시 계산
        var deli_fee_j                  = {};   //배송료
        var deli_policy                 = [];   //배송정책 별도로
        var goods_deli_code             = document.getElementsByName('deli_code[]');

        //배열 초기화
        for(var i=0; i<goods_deli_code.length; i++) {
            var deli_p = document.getElementsByName('deli_code[]')[i].value.split('||')[0].split('_')[1];   //배송정책 코드 추출
            total_price_by_policy[deli_p]   = 0;        //배송정책별 주문금액 초기화
            deli_fee_j[deli_p]              = 0;        //배송료 초기화
            deli_policy[i]                  = deli_p;   //배송정책 할당
            /*
            * if 문으로 배송정책이 현재 계산하려는 상품의 배송정책과 같으면, 배송정책에 할당 된 금액을 +
            * { 배송정책 : 현재 선택한 금액 } }
            *
            * 추후 배송정책별로 얼마가 부여 되었는지, 조건별 계산
            */
        }

        /* 배송 정책별 전체 주문금액 결정 */
        $("input:checkbox[name='chkGoods[]']:checked").each(function() {
            var idx			= $(this).val().split("||")[0];				//상품 인덱스
            var cur_deli_code             = document.getElementsByName('deli_code[]')[idx].value.split('||')[0].split('_')[1] + ''; // 현재 배송정책 추출
            //별도 계산

            //배송정책별 현재 배송료 계산 [현재 상품의 배송정책코드]
            total_price_by_policy[cur_deli_code] = parseInt(total_price_by_policy[cur_deli_code])
                + (parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) +
                    -parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value);
            //현재 값에 전체 판매가 합산
        });

        /* 배송 정책별 전체 주문금액에 따른 배송료 결정 */
        for(var i=0; i<deli_policy.length; i++) {
            var deliv_fee               = 0;                                   //배송료 => 상품별이 아닌, 배송정책별 계산
            $("input:checkbox[name='chkGoods[]']:checked").each(function() {
                var idx			            = $(this).val().split("||")[0];				                                            //상품 인덱스
                var cur_deli_code           = document.getElementsByName('deli_code[]')[idx].value.split('||')[0].split('_')[1];    // 현재 배송정책 추출
                var deli_code	            = $(this).val().split("||")[2];		                                                    //상품 배송정책코드

                if (deli_policy[i] == cur_deli_code) {
                    if (document.getElementsByName("deli_limit[]")[idx].value == 0 || document.getElementsByName("deli_limit[]")[idx].value > total_price_by_policy[deli_policy[i]] ) {
                        if(document.getElementsByName("deli_pattern[]")[idx].value == 'STATIC'){
                            deliv_fee += parseInt(document.getElementsByName("deli_cost[]")[idx].value*document.getElementsByName("goods_cnt[]")[idx].value);
                        } else if(document.getElementsByName("deli_pattern[]")[idx].value == 'PRICE'){
                            deliv_fee = parseInt(document.getElementsByName("deli_cost[]")[idx].value);
                        } else if(document.getElementsByName("deli_pattern[]")[idx].value == 'FREE'){
                            deliv_fee = 0;
                        } else {
                            deliv_fee = 0;
                        }
                    } else {
                        deliv_fee = 0;
                    }
                }
            });

            deli_fee_j[deli_policy[i]] = deliv_fee;
        }


        for(i=0; i<group_cnt; i++){
            delivery_price[i] = 0;
            eval("var selling_price_"+i+" = 0");	//묶음상품비 가변 변수 생성
        }

        if($("input:checkbox[name='chkGoods[]']:checked").val() == undefined){		//체크된 값이 없을 경우
            $('span[name=total_goods_price]').text('0');
            $('span[name=total_discount_price]').text('0');
            $('span[name=total_delivery_price]').text('0');
            $('span[name=payment_price]').text('0');
        } else {
            $("input:checkbox[name='chkGoods[]']:checked").each(function() {	    // 체크된 것만 값을 뽑아서 배열에 push
                var idx			= $(this).val().split("||")[0];				//상품 인덱스
                var deli_code	= $(this).val().split("||")[2];		//상품 배송정책코드
                var str			= "<?=$group_str?>";				//장바구니에 들어있는 상품의 배송정책코드 문자열
                var group		= str.split("||");
                var cur_deli_code             = document.getElementsByName('deli_code[]')[idx].value.split('||')[0].split('_')[1]; // 현재 배송정책 추출

                //상품 금액 변경
                total_goods_price += (parseInt($($("input[name='goods_selling_price[]']").get(idx)).val()) + parseInt($($("input[name='goods_option_add_price[]']").get(idx)).val()))* parseInt($($("input[name='goods_cnt[]']").get(idx)).val());

                //할인 금액 변경
                total_discount_price += parseInt($($("input[name='goods_discount_price[]']").get(idx)).val())* parseInt($($("input[name='goods_cnt[]']").get(idx)).val());	//상품기본할인
                total_discount_coupon += parseInt($($("input[name='goods_add_discount_price[]']").get(idx)).val());	//추가할인

                //적립예정 마일리지 금액
                total_mileage_save_price += parseInt($($("input[name='goods_selling_price[]']").get(idx)).val())* parseInt($($("input[name='goods_cnt[]']").get(idx)).val()) * ((parseInt($($("input[name='goods_mileage_save_rate[]']").get(idx)).val()))/1000);


                //배송비 금액 변경
                for(i=0; i<group_cnt; i++){		//계산
                    if(group[i] == deli_code){
                        //2018.08.23 할인가 기준으로 배송비 변경 황승업
//					 eval("selling_price_"+i+" += ( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + " +
//                         "parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) - parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) " +
//                         "- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)) * " +
//                         "parseInt(document.getElementsByName('goods_cnt[]')[idx].value) ");

                        //판매가로 배송비 계산 (수정 2017-01-10)
//					eval("selling_price_"+i+" += parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)");
                        //
                        eval("selling_price_"+i+" += ( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + " +
                            "parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value)" +
                            "- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)) * " +
                            "parseInt(document.getElementsByName('goods_cnt[]')[idx].value) ");


                        if(document.getElementsByName("group_text[]")[i].value == ''){
                            document.getElementsByName("group_text[]")[i].value = 'N';
                        } else if(document.getElementsByName("group_text[]")[i].value == 'N'){
                            document.getElementsByName("group_text[]")[i].value = 'Y';
                        }

                        if(document.getElementsByName("deli_limit[]")[idx].value == 0 || document.getElementsByName("deli_limit[]")[idx].value > eval("selling_price_"+i)){
                            if(document.getElementsByName("deli_pattern[]")[idx].value == 'STATIC'){
                                delivery_price[i] += parseInt(document.getElementsByName("deli_cost[]")[idx].value*document.getElementsByName("goods_cnt[]")[idx].value);
                            } else if(document.getElementsByName("deli_pattern[]")[idx].value == 'PRICE'){
                                delivery_price[i] = parseInt(document.getElementsByName("deli_cost[]")[idx].value);
                            } else if(document.getElementsByName("deli_pattern[]")[idx].value == 'FREE'){
                                delivery_price[i] = 0;
                            } else {
                                delivery_price[i] = 0;
                            }//END else if
                        } else {
                            delivery_price[i] = 0;
                        }

                        //2019.12.27 묶음배송비 할인적용 표시 오류로 수정 (3개이상인경우 제대로 표시 X)
                        $($("input[name='chk_deli_code[]']").get(idx)).val(deli_code+"||"+delivery_price[i]);

                        if(delivery_price[i] == 0 && document.getElementsByName("deli_pattern[]")[idx].value != 'PRICE' && document.getElementsByName("deli_pattern[]")[idx].value != 'NONE' ){
                            $($("span[name='goods_delivery[]']").get(idx)).html("<strong class='bold'>무료</strong>");
                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
                                - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));

                        } else if(delivery_price[i] == 0 && document.getElementsByName("deli_pattern[]")[idx].value == 'PRICE' && document.getElementsByName("group_text[]")[i].value == 'Y'){
                            $($("span[name='goods_delivery[]']").get(idx)).html("<del><strong class='bold'>"+numberFormat(document.getElementsByName("goods_delivery_price[]")[idx].value)+"</strong></del><br />*묶음 배송비 할인 적용중입니다.");

                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
                                - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));

                        } else if(delivery_price[i] == 0 && document.getElementsByName("deli_pattern[]")[idx].value == 'PRICE' && document.getElementsByName("group_text[]")[i].value == 'N'){
                            $($("span[name='goods_delivery[]']").get(idx)).html("<del><strong class='bold'>"+numberFormat(document.getElementsByName("goods_delivery_price[]")[idx].value)+"원</strong></del><br />*묶음 배송비 할인 적용중입니다.");

                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
                                - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));

                        } else {
                            $($("span[name='goods_delivery[]']").get(idx)).html("<strong class='bold'>"+numberFormat(document.getElementsByName("goods_delivery_price[]")[idx].value)+"원</strong>");

                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value)
                                + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
                                - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))
                                - parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)+parseInt(document.getElementsByName("goods_delivery_price[]")[idx].value)));
                        }

                        if(document.getElementsByName("group_text[]")[i].value == 'Y'){
                            $($("span[name='goods_delivery[]']").get(idx)).html("<del><strong class='bold'>"+numberFormat(document.getElementsByName("goods_delivery_price[]")[idx].value)+"원</strong></del><br />*묶음 배송비 할인 적용중입니다.");

                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value) - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));
                        }

                        if(document.getElementsByName("deli_pattern[]")[idx].value == 'NONE'){
//                            $($("span[name='goods_delivery[]']").get(idx)).text('착불');
                            $($("span[name='goods_delivery[]']").get(idx)).html("<strong class='bold'>착불</strong>");
                        }

                    }	//END if

                }	//END for
//				total_delivery_price += parseInt($($("input[name='goods_delivery_price[]']").get(idx)).val());
            });

            /* 기존 소스는 건들지 않고 수정하기 위함(위 코드 덮어쓰기) 2020-05-25 */
            $("input:checkbox[name='chkGoods[]']:checked").each(function () {
                for(var i=0; i<deli_policy.length; i++) {
                    var idx = $(this).val().split("||")[0];				//상품 인덱스
                    var deli_code = $(this).val().split("||")[2];		//상품 배송정책코드
                    var cur_deli_code = document.getElementsByName('deli_code[]')[idx].value.split('||')[0].split('_')[1]; // 현재 배송정책 추출

                    if (deli_policy[i] == cur_deli_code) {
                        $($("input[name='chk_deli_code[]']").get(idx)).val(deli_code + "||" + deli_fee_j[cur_deli_code]);
                    }
                }
            });


            //2019.12.27 묶음배송 초기화
            for(i=0; i<group_cnt; i++){
                document.getElementsByName("group_text[]")[i].value = '';
            }

//2019.12.27 묶음배송비 할인적용 표시 오류로 수정 (3개이상인경우 제대로 표시 X)
//            $("input:checkbox[name='chkGoods[]']:checked").each(function() {	//묶음상품 배송비 value를 deli_code에 넣기 위해
//                var idx = $(this).val().split("||")[0];
//                var deli_code	= $(this).val().split("||")[2];
//                var str			= "<?//=$group_str?>//";				//장바구니에 들어있는 상품의 배송정책코드 문자열
//                var group		= str.split("||");
//
//
//                for(i=0; i<group_cnt; i++){
//                    if(group[i] == deli_code){
//
//                        if(document.getElementsByName("group_text[]")[i].value == '' ){
//                            document.getElementsByName("group_text[]")[i].value = 'N';
//                        }
//
//
//                        $($("input[name='chk_deli_code[]']").get(idx)).val(deli_code+"||"+delivery_price[i]);
//
//                        if(delivery_price[i] == 0 && document.getElementsByName("deli_pattern[]")[idx].value != 'PRICE' && document.getElementsByName("deli_pattern[]")[idx].value != 'NONE' ){
//                            $($("span[name='goods_delivery[]']").get(idx)).html("무료");
////						$($("span[name='goods_delivery[]']").get(idx)).html("<del><strong class='bold'>"+numberFormat(document.getElementsByName("goods_delivery_price[]")[idx].value)+"</strong></del>)<br />*묶음 배송비 할인 적용중입니다.");
////
//                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
//                                - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));
//
////                        $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
////                            - parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));
//
//
//                        } else if(delivery_price[i] == 0 && document.getElementsByName("deli_pattern[]")[idx].value == 'PRICE' && document.getElementsByName("group_text[]")[i].value == 'Y'){
//                            $($("span[name='goods_delivery[]']").get(idx)).html("<del><strong class='bold'>"+numberFormat(document.getElementsByName("goods_delivery_price[]")[idx].value)+"</strong></del><br />*묶음 배송비 할인 적용중입니다.");
//
//                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
//                                - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));
//
////                        $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
////                            - parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));
//
//                        } else if(delivery_price[i] == 0 && document.getElementsByName("deli_pattern[]")[idx].value == 'PRICE' && document.getElementsByName("group_text[]")[i].value == 'N'){
////						$($("span[name='goods_delivery[]']").get(idx)).html("무료)");
//                            $($("span[name='goods_delivery[]']").get(idx)).html("<del><strong class='bold'>"+numberFormat(document.getElementsByName("goods_delivery_price[]")[idx].value)+"원</strong></del><br />*묶음 배송비 할인 적용중입니다.");
//
//                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
//                                - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));
////                        $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
////                            - parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));
//
//                        } else {
//                            $($("span[name='goods_delivery[]']").get(idx)).html(numberFormat(document.getElementsByName("goods_delivery_price[]")[idx].value)+"원");
//
//                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value)
//                                + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value)
//                                - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))
//                                - parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)+parseInt(document.getElementsByName("goods_delivery_price[]")[idx].value)));
//                        }
////alert(document.getElementsByName("group_text[]")[i].value);
//                        if(document.getElementsByName("group_text[]")[i].value == 'Y'){
//                            $($("span[name='goods_delivery[]']").get(idx)).html("<del><strong class='bold'>"+numberFormat(document.getElementsByName("goods_delivery_price[]")[idx].value)+"원</strong></del><br />*묶음 배송비 할인 적용중입니다.");
//
//                            $($("span[name='goods_apply_price[]']").get(idx)).text(numberFormat(( parseInt(document.getElementsByName('goods_selling_price[]')[idx].value) + parseInt(document.getElementsByName('goods_option_add_price[]')[idx].value) ) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value) - (parseInt(document.getElementsByName('goods_discount_price[]')[idx].value) * parseInt(document.getElementsByName('goods_cnt[]')[idx].value))- parseInt(document.getElementsByName('goods_add_discount_price[]')[idx].value)));
//                        }
//
//                        document.getElementsByName("group_text[]")[i].value = '';	//변수 초기화해야 체크해제하고 다시 체크해도 맞음
//                    }
//
//                    if(document.getElementsByName("deli_pattern[]")[idx].value == 'NONE'){
//                        $($("span[name='goods_delivery[]']").get(idx)).text('착불)');
//                        break;
//                    }
//                }
//
//            });

            for(i=0; i<group_cnt; i++){
                total_delivery_price += parseInt(delivery_price[i]);
            }

            $('span[name=total_goods_price]').text(numberFormat(total_goods_price));
            $('span[name=total_discount_price]').text(numberFormat(total_discount_price+total_discount_coupon));
            $('span[name=total_delivery_price]').text(numberFormat(total_delivery_price));
            $('span[name=payment_price]').text(numberFormat(total_goods_price-total_discount_price-total_discount_coupon+total_delivery_price));

            //적립예정 마일리지 재계산
            $('span[name=goods_save_mileage]').text(numberFormat(total_mileage_save_price));
        }

    }


    /*******************/
    /** 레이어 초기화 **/
    /*******************/
    function jsReset(idx,gb){
        if(gb == 'OPT'){
            $($("span[name='chk_option_name[]']").get(idx)).text(document.getElementsByName("goods_option_name[]")[idx].value);
//		alert(document.getElementsByName("moption1[]")[idx].value);
            document.getElementsByName("moption1[]")[idx].value = document.getElementsByName("goods_option_code[]")[idx].value+"||"+document.getElementsByName("goods_option_add_price[]")[idx].value+"||"+document.getElementsByName("goods_option_qty[]")[idx].value;
//		alert(document.getElementsByName("goods_option_code[]")[idx].value+"||"+document.getElementsByName("goods_option_add_price[]")[idx].value+"||"+document.getElementsByName("goods_option_qty[]")[idx].value);
            document.getElementsByName("option_cnt[]")[idx].value = document.getElementsByName("goods_cnt[]")[idx].value;
            $("input[name=dup_option]").val('N');
            $($("span[name='duplicate_option[]']").get(idx)).html('');
            document.getElementsByName("total_option_price[]")[idx].innerText = numberFormat((parseInt(document.getElementsByName("goods_selling_price[]")[idx].value) + parseInt(document.getElementsByName("goods_option_add_price[]")[idx].value)) * parseInt(document.getElementsByName("goods_cnt[]")[idx].value));

            $("#layer__cart_03_"+idx).attr('class','layer layer__cart_03');	//레이어 닫기
        } else if(gb == 'CPN'){
            var total_coupon_price	= parseInt(document.getElementsByName("goods_discount_price[]")[idx].value)*parseInt($($("input[name='goods_cnt[]']").get(idx)).val());
            var item_coupon_max		= parseInt(0);
            var item_coupon_amt		= parseInt(0);
            var item_coupon_checked_id	= '';
            var item_coupon_checked_tid = '';
            var item_coupon_checked_name = '';
            var cust_coupon_max		= parseInt(0);
            var cust_coupon_amt		= parseInt(0);

            for(var i=0; i<cart_cnt; i++){		//체크한 쿠폰 원래대로
                if(i == idx){
                    var goods_cnt	= parseInt($($("input[name='goods_cnt[]']").get(idx)).val());	//상품갯수

                    if($($("input[name='item_coupon_cnt[]']").get(idx)).val() > 0){	//아이템쿠폰이 하나라도 있을경우 체크재점검
                        for(k=0; k<document.getElementsByName("coupon_select_E"+i).length; k++){
                            document.getElementsByName("coupon_select_E"+i)[k].checked = false;
                        }
//===2016-10-06 중복불가쿠폰은 에타할인으로
                        for(var j=0; j<$($("input[name='item_coupon_cnt[]']").get(i)).val(); j++){
                            if($($("input[name='goods_coupon_code_i[]']").get(idx)).val() == $("#coupon_E"+i+"_"+j).val().split("||")[0]){
                                $("#coupon_E"+i+"_"+j).prop('checked', true);
                                $("#coupon_E"+i+"_"+j).prop('disabled', false);
                                $("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);

                                item_coupon_max	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[3]);
                                item_coupon_amt	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[2]);
                                item_coupon_kind	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[4]);

                                if(item_coupon_kind	== 'COUPON_B'){
                                    if( item_coupon_max < (item_coupon_amt*goods_cnt) && item_coupon_max != 0){
                                        item_coupon_amt = item_coupon_max;
                                    } else {
                                        item_coupon_amt = item_coupon_amt*goods_cnt;
                                    }
                                } else {
                                    if( item_coupon_max < (item_coupon_amt) && item_coupon_max != 0){
                                        item_coupon_amt = item_coupon_max*goods_cnt;
                                    } else {
                                        item_coupon_amt = item_coupon_amt*goods_cnt;
                                    }

                                }
                                $("span[name=coupon_E_text"+i+"]").text(numberFormat(item_coupon_amt));

                                $("#dup_coupon_"+idx).show();
                                break;
                            } else if($($("input[name='goods_coupon_code_i[]']").get(idx)).val() == ""){	//아이템쿠폰 사용안함
                                if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == ''){	//고객쿠폰쪽도 비어있을경우
                                    $("input[name='coupon_select_E"+idx+"']:input[value='']").prop('checked', true);
//								$("#coupon_E"+i+"_"+j).prop('disabled', false);
//								$("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);
                                    $("span[name=coupon_E_text"+i+"]").text(0);

                                    $("#dup_coupon_"+idx).show();
                                    break;
                                } else {	//고객쿠폰이 있음
//								alert("aa");
//								alert($($("input[name='goods_add_coupon_code[]']").get(idx)).val());
//								alert($("#coupon_E"+i+"_"+j).val().split("||")[0]);
                                    if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == $("#coupon_E"+i+"_"+j).val().split("||")[0]){
//									alert("bb");
                                        $("#coupon_E"+i+"_"+j).prop('checked', true);
                                        $("#coupon_E"+i+"_"+j).prop('disabled', false);
                                        $("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);

                                        item_coupon_max	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[3]);
                                        item_coupon_amt	= parseInt($("#coupon_E"+i+"_"+j).val().split("||")[2]);
                                        if( item_coupon_max < (item_coupon_amt*goods_cnt) && item_coupon_max != 0){
                                            item_coupon_amt = item_coupon_max;
                                        } else {
                                            item_coupon_amt = item_coupon_amt*goods_cnt;
                                        }
                                        $("span[name=coupon_E_text"+i+"]").text(numberFormat(item_coupon_amt));

                                        total_coupon_price += item_coupon_amt;

                                        $("#dup_coupon_"+idx).hide();
                                        break;
                                    } else if(j==$($("input[name='item_coupon_cnt[]']").get(i)).val()-1) {	//아이템쿠폰의 고객쿠폰은 아님
                                        $("input[name='coupon_select_E"+idx+"']:input[value='']").prop('checked', true);
//									$("#coupon_E"+i+"_"+j).prop('disabled', false);
//									$("#coupon_name_E"+i+"_"+j).html($("#coupon_E"+i+"_"+j).val().split("||")[1]);
                                        $("span[name=coupon_E_text"+i+"]").text(0);

                                        $("#dup_coupon_"+idx).show();
                                        break;
                                    }
                                }
                            }
                        }

                    }

                    if($($("input[name='add_coupon_cnt[]']").get(idx)).val() > 0){	//에타중복쿠폰 하나라도 있을경우 체크재점검
                        for(k=0; k<document.getElementsByName("coupon_select_C"+i).length; k++){
                            document.getElementsByName("coupon_select_C"+i)[k].checked = false;
                        }

//===2016-10-06 중복불가쿠폰은 에타할인으로
                        for(var j=0; j<$($("input[name='add_coupon_cnt[]']").get(i)).val(); j++){
                            if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == $("#coupon_C"+i+"_"+j).val().split("||")[0]){
                                $("#coupon_C"+i+"_"+j).prop('checked', true);
                                cust_coupon_max	= parseInt($("#coupon_C"+i+"_"+j).val().split("||")[3]);
                                cust_coupon_amt	= parseInt($("#coupon_C"+i+"_"+j).val().split("||")[2]);
                                if( cust_coupon_max < (cust_coupon_amt*goods_cnt) && cust_coupon_max != 0){
//								cust_coupon_amt = cust_coupon_max*goods_cnt;
                                    cust_coupon_amt = cust_coupon_max;
                                } else {
                                    cust_coupon_amt = cust_coupon_amt*goods_cnt;
                                }
                                total_coupon_price += cust_coupon_amt;

                                break;
                            } else if($($("input[name='goods_add_coupon_code[]']").get(idx)).val() == ""){	//중복쿠폰사용x
                                $("input[name='coupon_select_C"+idx+"']:input[value='']").prop('checked', true);
                                break;
                            }
                        }	//END FOR

                    }
                }	//END if
            }	//END for

            $("span[name='coupon_C_text"+idx+"']").text(numberFormat(cust_coupon_amt));	//할인액 재계산
            $("span[name='coupon_total_amt_"+idx+"']").text(numberFormat(total_coupon_price));		//총 재계산
//		$("#layer__cart_02_"+idx).attr('class','layer layer__cart_02');			//레이어 닫기
            $("div[id=cartCouponLayer"+idx+"]").removeClass();
            $("div[id=cartCouponLayer"+idx+"]").addClass('common-layer-wrap cart-coupon-layer');	//레이어 닫기
            $("#etah_html").removeClass();

        }	//END else if
    }	//END function


    //===============================================================
    // 주문/결제 페이지 이동
    //===============================================================
    function jsStep2(gb,cart_no){
        if(document.getElementsByName("cart_code[]").length < 1){
            alert("장바구니에 담긴 상품이 없습니다.");
            return false;
        }

        if(gb == 'All'){	//전체 상품 주문시
            for(var i=0; i<document.getElementsByName("goods_state_code[]").length; i++){
                if(document.getElementsByName("goods_state_code[]")[i].value != 03){
                    alert("판매가 불가능한 상품이 포함되어 있습니다. 삭제후 주문해주세요.");
                    return false;
                }
                if(document.getElementsByName("goods_option_qty[]")[i].value == 0){
                    alert("옵션이 품절된 상품이 포함되어 있습니다. 삭제후 주문해주세요.");
                    return false;
                }
            }

            document.getElementById("order_gb").value = "A";
        } else if(gb == 'Choice'){	//선택 상품 주문시
            var order_yn = 'Y';

            if($("input[name='chkGoods[]']").is(':checked') == false){
                alert("선택하신 상품이 없습니다. 상품을 선택해주세요.");
                return false;
            }

            $("input:checkbox[name='chkGoods[]']:checked").each(function() {	    // 체크된 것만 값을 뽑아서 배열에 push
                var idx = $(this).val().split("||")[0];

                if(document.getElementsByName("goods_state_code[]")[idx].value != 03){	//판매중인 상품이 아니면
                    alert("선택한 상품중 판매가 불가능한 상품이 있습니다.");
                    order_yn = 'N';
                    return false;
                }

                if(document.getElementsByName("goods_option_qty[]")[idx].value == 0){	//옵션품절
                    alert("선택한 상품중 옵션이 품절된 상품이 있습니다.");
                    order_yn = 'N';
                    return false;
                }
            });

            if(order_yn == 'Y'){
                document.getElementById("order_gb").value = "C";
            } else {
                return false;
            }

        } else if(gb == 'Direct'){	//바로 상품 주문시
            document.getElementById("order_gb").value = "D";
            document.getElementById("direct_code").value = cart_no;
        }

        var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";

        if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){	//로그인 안한 경우
            document.getElementById("guest_gb").value = "direct";
        }

        var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";
        var frm = document.getElementById("buyForm");


        if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){	//로그인 안한 경우
            frm.action = "https://"+SSL_val+"/member/Guestlogin";
            frm.submit();
        } else {
            frm.action = "https://"+SSL_val+"/cart/OrderInfo";
            frm.submit();
        }

        return true;
    }

    total_sum_price();

</script>


<!-- WIDERPLANET  SCRIPT START 2017.3.29 -->
<div id="wp_tg_cts" style="display:none;"></div>
<script type="text/javascript">
    var wptg_tagscript_vars = wptg_tagscript_vars || [];

    //배열, 변수 생성
    var cartDataCnt		= "<?=$cart_idx?>";
    var cartItemsArray  = new Array();
    var cartItems		= new Object();
    //alert(cartDataCnt);
    for (var a=0; a<cartDataCnt; a++)
    {
        var cartItems	= new Object();

        cartItems.i	= document.getElementsByName("goods_code[]")[a].value;
        cartItems.t	= document.getElementsByName("goods_name[]")[a].value;

        cartItemsArray.push(cartItems);
    }
    //alert(JSON.stringify(cartItemsArray));
    wptg_tagscript_vars.push(
        (function() {
            return {
                wp_hcuid:"",     /*Cross device targeting을 원하는 광고주는 로그인한 사용자의 Unique ID (ex. 로그인 ID, 고객넘버 등)를 암호화하여 대입.
                                    *주의: 로그인 하지 않은 사용자는 어떠한 값도 대입하지 않습니다.*/
                ti:"35025",
                ty:"Cart",
                device:"mobile"
                , items : cartItemsArray
                /*   ,items:[
                             {i:"상품ID",    t:"상품명"} /* 첫번째 상품 - i:상품 식별번호 (Feed로 제공되는 식별번호와 일치) t:상품명 */
                /*          ,{i:"상품ID",    t:"상품명"} /* 두번째 상품 - i:상품 식별번호 (Feed로 제공되는 식별번호와 일치) t:상품명 */
                /*   ]	*/
            };
        }));
</script>
<script type="text/javascript" async src="//cdn-aitg.widerplanet.com/js/wp_astg_4.0.js"></script>
<!-- // WIDERPLANET  SCRIPT END 2017.3.29 -->
