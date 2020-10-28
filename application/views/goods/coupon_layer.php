<?
$seller_coupon_amt = 0;
if(isset($goods['SELLER_COUPON_CD'])){
    if($goods['SELLER_COUPON_METHOD'] == 'RATE'){
        $seller_coupon_amt = floor($goods['SELLING_PRICE'] * $goods['SELLER_COUPON_FLAT_RATE']/1000);
    } else if($goods['SELLER_COUPON_METHOD'] == 'AMT'){
        $seller_coupon_amt = $goods['SELLER_COUPON_FLAT_RATE'];
    }

    if($seller_coupon_amt > $goods['SELLER_COUPON_MAX_DISCOUNT'] && $goods['SELLER_COUPON_MAX_DISCOUNT'] != 0){
        $seller_coupon_amt = $goods['SELLER_COUPON_MAX_DISCOUNT'];
    }
}

$item_coupon_amt = 0;
if(isset($goods['ITEM_COUPON_CD'])){
    if($goods['ITEM_COUPON_METHOD'] == 'RATE'){
        $item_coupon_amt = $goods['SELLING_PRICE'] * ($goods['ITEM_COUPON_FLAT_RATE']/100);
    } else if($goods['ITEM_COUPON_METHOD'] == 'AMT'){
        $item_coupon_amt = $goods['ITEM_COUPON_FLAT_RATE'];
    }

    if($item_coupon_amt > $goods['ITEM_COUPON_MAX_DISCOUNT'] && $goods['ITEM_COUPON_MAX_DISCOUNT'] != 0){
        $item_coupon_amt = $goods['ITEM_COUPON_MAX_DISCOUNT'];
    }
}
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
                        <? $idx2 = 0;
                        if($AUTO_COUPON_LIST){
                        foreach($AUTO_COUPON_LIST as $row)	{
                        if($row['COUPON_KIND_CD'] == 'SELLER'){
                        $row['COUPON_PRICE'] = $row['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($goods['SELLING_PRICE']*$row['COUPON_SALE']/100) : $row['COUPON_SALE'];

                        $row = str_replace("\"","&ldquo;",$row);		//큰따옴표 치환
                        ?>
                        <ul>
                            <li class="tb-info-txt-item">
                                <label>
                                    <input type="radio" class="common-radio-btn" name="coupon_select_S<?=$idx?>" id="coupon_1_1" value="<?=$row['COUPON_CD']?>||<?=$row['WEB_DISP_DC_COUPON_NM'] == '' ? $row['DC_COUPON_NM'] : $row['WEB_DISP_DC_COUPON_NM']?>||<?=$row['COUPON_PRICE']?>||<?=$row['MAX_DISCOUNT']?>"  checked>
                                    <p class="tb-info-txt-right"><?=$row['WEB_DISP_DC_COUPON_NM'] == '' ? $row['DC_COUPON_NM'] : $row['WEB_DISP_DC_COUPON_NM']?>
                                        <span class="tb-info-txt--font"><?=$row['COUPON_DC_METHOD_CD'] == 'RATE' ? $row['COUPON_SALE'].'%' : number_format($row['COUPON_SALE']).'원'?>할인 <?=$row['MAX_DISCOUNT'] ? "(최대 ".number_format($row['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                    </p>
                                </label>
                            </li>
                            <?  $coupon_S_text = $row['MAX_DISCOUNT'] < $row['COUPON_PRICE'] && $row['MAX_DISCOUNT'] != 0 ? number_format($row['MAX_DISCOUNT']) : number_format($row['COUPON_PRICE']);
                            $idx2++;
                            }//END IF
                            else if($row['COUPON_KIND_CD'] != 'GOODS' || count($AUTO_COUPON_LIST) == 1){	?>
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
							<span name="coupon_S_text<?=$idx?>">
								<?=$coupon_S_text?>
							</span>원
                    </td>
                </tr>
                <tr>
                    <td class="tb-info-txt">에타홈 할인</td>
                    <td class="tb-info-txt">
                        <ul>
                            <? $idx2 = 0;
                            $ITEM_COUPON_YN = '';
                            $coupon_E_text = 0;
                            if($AUTO_COUPON_LIST || $CUST_COUPON_LIST){
                                foreach($AUTO_COUPON_LIST as $row2)	{
                                    if($row2['COUPON_KIND_CD'] == 'GOODS'){

                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? floor($row2['COUPON_SALE']/100*$goods['SELLING_PRICE']) : $row2['COUPON_SALE'];

                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                        ?>
                                        <li class="tb-info-txt-item">
                                            <label>
                                                <input type="radio" class="common-radio-btn" name="coupon_select_E<?=$idx?>" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_I" checked>
                                                <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액||아이템쿠폰|| -->
                                                <p class="tb-info-txt-right" id="coupon_name_E<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                </p>
                                                <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?>
										</span>
                                            </label>
                                            <?	$coupon_E_text = $row2['MAX_DISCOUNT'] < $row2['COUPON_PRICE'] && $row2['MAX_DISCOUNT'] != 0 ? number_format($row2['MAX_DISCOUNT']) : number_format($row2['COUPON_PRICE']);
                                            ?>
                                        </li>
                                        <?		$ITEM_COUPON_YN = 'Y';
                                        $idx2++;
                                    }
                                }	//END FOREACH
                                foreach($CUST_COUPON_LIST as $row2)	{
                                    if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'N' && $row2['MIN_AMT'] < ($goods['SELLING_PRICE']+$option_add_price)){
                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods['SELLING_PRICE'] : $row2['COUPON_SALE'];

                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환

                                        ?>
                                        <li class="tb-info-txt-item">
                                            <label>
                                                <input type="radio" class="common-radio-btn" name="coupon_select_E<?=$idx?>" id="coupon_E<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('E',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']?>||<?=$row2['MAX_DISCOUNT']?>||COUPON_B||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
                                                <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액||바이어쿠폰||쿠폰지급방식||중복여부||쿠폰구분 -->
                                                <p class="tb-info-txt-right" id="coupon_name_E<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                </p>
                                                <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                            </label>
                                            <? if(!$AUTO_COUPON_LIST){
                                                $coupon_E_text = 0;
                                            }?>
                                        </li>
                                        <?
                                        if($ITEM_COUPON_YN == ''){
                                            $ITEM_COUPON_YN = 'N';
                                        }

                                        $idx2++;
                                    }
                                }	//END FOREACH

                                if(($AUTO_COUPON_LIST && ($AUTO_COUPON_LIST[0]['COUPON_KIND_CD'] == 'GOODS') || (@$AUTO_COUPON_LIST[1]['COUPON_KIND_CD'] == 'GOODS')) || $CUST_COUPON_LIST){
                                    ?>
                                    <li class="tb-info-txt-item">
                                        <label>
                                            <input type="radio" class="common-radio-btn" name="coupon_select_E<?=$idx?>" id="coupon_E<?=$idx?>_<?=$idx2?>" value="" onClick="javascript:Coupon_check('EN',this.value,<?=$idx?>,<?=$idx2?>);"<?if($ITEM_COUPON_YN == 'N'){?>checked<?}?>>
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
                    <td class="tb-info-txt">에타홈 중복할인</td>
                    <td class="tb-info-txt">
                        <ul>
                            <? $idx2 = 0;
                            //										var_dump($CUST_COUPON_LIST);
                            if($CUST_COUPON_LIST){
                                foreach($CUST_COUPON_LIST as $row2)	{
                                    if($row2['BUYER_COUPON_DUPLICATE_DC_YN'] == 'Y' && $row2['MIN_AMT'] < ($goods['SELLING_PRICE']+$option_add_price)){	//최소금액 이상일때 보임

                                        $row2['COUPON_PRICE'] = $row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE']/100*$goods['SELLING_PRICE'] : $row2['COUPON_SALE'];

                                        $row2 = str_replace("\"","&ldquo;",$row2);		//큰따옴표 치환
                                        ?>
                                        <li class="tb-info-txt-item">
                                            <label>
                                                <input type="radio" class="common-radio-btn" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" onClick="javascript:Coupon_check('C',this.value,<?=$idx?>,<?=$idx2?>);" value="<?=$row2['COUPON_CD']?>||<?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>||<?=$row2['COUPON_PRICE']?>||<?=$row2['MAX_DISCOUNT'] ? $row2['MAX_DISCOUNT'] : 0?>||<?=$row2['COUPON_DTL_NO']?>||<?=$row2['BUYER_COUPON_GIVE_METHOD_CD']?>||<?=$row2['BUYER_COUPON_DUPLICATE_DC_YN']?>||<?=$row2['GUBUN']?>||<?=$row2['CUST_COUPON_NO']?>">
                                                <!-- 쿠폰코드||쿠폰명||할인금액||최대할인금액||쿠폰번호||쿠폰지급방식||중복여부||쿠폰구분-->
                                                <p class="tb-info-txt-right" id="coupon_name_C<?=$idx?>_<?=$idx2?>"><?=$row2['WEB_DISP_DC_COUPON_NM'] == '' ? $row2['DC_COUPON_NM'] : $row2['WEB_DISP_DC_COUPON_NM']?>
                                                </p>
                                                <span class="tb-info-txt--font"><?=$row2['COUPON_DC_METHOD_CD'] == 'RATE' ? $row2['COUPON_SALE'].'%' : number_format($row2['COUPON_SALE']).'원'?>할인 <?=$row2['MAX_DISCOUNT'] ? "(최대 ".number_format($row2['MAX_DISCOUNT'])."원 할인)" : ""?></span>
                                            </label>
                                        </li>
                                        <? $idx2++;
                                    }	//END IF
                                } //END FOREACH

                                if($idx2>0){	//최소금액 이상일때 보임?>
                                    <li class="tb-info-txt-item">
                                        <label>
                                            <input type="radio" class="common-radio-btn" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="" onClick="javascript:Coupon_check('CN',this.value,<?=$idx?>,<?=$idx2?>);" checked>
                                            <p class="tb-info-txt-right">쿠폰 적용 안함</p>
                                        </label>
                                    </li>
                                <? } else {	?>
                                    <input type="hidden" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="">
                                    <p>적용 가능한 쿠폰이 없습니다.</p>
                                <? } ?>
                                <?
                                $coupon_C_text = 0;
                            } //END IF
                            else {?>
                                <input type="hidden" name="coupon_select_C<?=$idx?>" id="coupon_C<?=$idx?>_<?=$idx2?>" value="">
                                <p>적용 가능한 쿠폰이 없습니다.</p>
                                <?
                                $coupon_C_text = 0;
                            } ?>
                        </ul>
                    </td>
                    <!-- 밑에 함수에서 사용쿠폰 표시를 위해 각 상품별 추가쿠폰이 몇개인지 알려주는 변수 -->
                    <input type="hidden"	name="add_coupon_cnt[]"			value="<?=$idx2?>">
                    <td class="tb-info-txt">
                        <span name="coupon_C_text<?=$idx?>"><?=$coupon_C_text?></span><span class="won">원</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="tb-info-txt tb-info-total">쿠폰할인 총액 <strong class="total-color"><span name="coupon_total_amt_<?=$idx?>"><?=number_format($seller_coupon_amt+$item_coupon_amt)?></span></strong><span class="tb-info-total-color">원</span></td>
                </tr>
            </table>
        </div>

        <ul class="text-list">
            <li class="text-item">할인쿠폰은 판매가 기준으로 할인율 적용됩니다.</li>
        </ul>
        <ul class="common-btn-box common-btn-box--layer">
            <li class="common-btn-item"><a href="javascript://" class="btn-gray-link" onClick="javascript:Coupon_Reset(<?=$idx?>);">적용취소</a></li>
            <li class="common-btn-item"><a href="javascript://" class="btn-black-link" onClick="javascript:Coupon_apply(<?=$idx?>);">쿠폰적용</a></li>
        </ul>
        <!-- // common-layer-button -->
    </div>
    <!-- // common-layer-content -->

    <a href="javascript://" class="btn-layer-close" onClick="javascript:Coupon_Reset(<?=$idx?>);"><span class="hide">닫기</span></a>
</div>

<!-- // 쿠폰적용하기 레이어 -->