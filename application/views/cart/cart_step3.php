<!-- 2017-02-23 추가 -->
<!-- 전환페이지 설정 -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
    var _nasa={};
    _nasa["cnv"] = wcs.cnv("1","<?=$order['ORDER_AMT']?>"); // 전환유형, 전환가치 설정해야함. 설치매뉴얼 참고: 구매(유형 값 1)의 경우 전환가치는 매번 달라질 것이므로 변수로 입력을 해 놓으시기 바랍니다.
</script>

<!--카페24전환 스크립트 시작 (2017-04-26 : 제거요청) -->
<script type='text/javascript'>
    //					   order_id = '1';
    //					   order_price = "<?=$order['ORDER_AMT']?>"; // ‘주문가격’ 부분은 ETAH에서 사용하는 주문가격 변수로 수정해야 함
    //			var SaleJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
    //					   document.write(unescape("%3Cscript id='sell_script' src='"+SaleJsHost+ "etah.cmclog.cafe24.com/sell.js?mall_id=etah' type='text/javascript'%3E%3C/script%3E"));
</script>
<!--카페24전환 스크립트 종료 -->


<link rel="stylesheet" href="/assets/css/cart_order.css">
<!-- Google Tag Manager Variable (eMnet) 2018.05.29-->
<script>
    var bprice = '<?=$order['PAY_AMT']?>';
    var brandIds =[];
</script>
<!-- End Google Tag Manager Variable (eMnet) -->
<div class="content">
    <h2 class="page-title-basic page-title-basic--line">주문&#47;결제</h2>
    <div class="payment-complete-wrap">
        <div class="payment-complete-result">
            <p class="complete-result-txt">
                결제가 정상적으로 완료되었습니다.
            </p>
        </div>

        <!-- 주문/결제정보 // -->
        <div class="basic-table-wrap--title-bg payment-complete-info payment-complete-tb">
            <h3 class="info-title">주문&#47;결제정보</h3>
            <table class="basic-table">
                <colgroup>
                    <col style="width:30%;">
                    <col style="width:70%;">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row" class="tb-info-title">주문번호</th>
                    <td class="tb-info-txt"><?=$order_no?></td>
                </tr>
                <tr>
                    <th scope="row" class="tb-info-title">결제방식</th>
                    <td class="tb-info-txt"><?=$order['ORDER_PAY_KIND_CD_NM']?></td>
                </tr>
                <tr>
                    <th scope="row" class="tb-info-title">총 결제액</th>
                    <td class="tb-info-txt"><?=number_format($order['PAY_AMT'])?>원</td>
                </tr>
                <? if($order['ORDER_PAY_KIND_CD'] == '02') {?>
                    <tr>
                        <th scope="row" class="tb-info-title">입금액</th>
                        <td class="tb-info-txt"><?=number_format($order['PAY_AMT'])?>원</td>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">입금기한</th>
                        <td class="tb-info-txt"><?=date("Y-m-d H:i:s", strtotime($order['DEPOSIT_DEADLINE_DY']))?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">입금계좌</th>
                        <td class="tb-info-txt"><?=$order['BANK_NM']?> &#47; <?=$order['BANK_ACCOUNT_NO']?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">예금주</th>
                        <td class="tb-info-txt">(주)에타</td>
                    </tr>
                <? }?>
                <? if($order['ORDER_PAY_KIND_CD'] == '08') {?>
                    <tr>
                        <th scope="row" class="tb-info-title">입금액</th>
                        <td class="tb-info-txt"><?=number_format($order['PAY_AMT'])?>원</td>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">입금기한</th>
                        <td class="tb-info-txt"><?=date("Y-m-d H:i:s", strtotime($order['VARS_EXPR_DT']))?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">가상번호</th>
                        <td class="tb-info-txt"><?=preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $order['VARS_VNUM_NO'])?></td>
                    </tr>
                <? }?>
                </tbody>
            </table>
            <ul class="text-list">
                <li class="text-item">결제수단으로 무통장입금(가상계좌) 또는 ARS결제를 선택하셨다면<br>입금을 완료하셔야 최종적으로 주문 처리가 됩니다.</li>
                <li class="text-item">주문&#47;배송 관련하여 궁금하신 점이 있으시면<br>회원&#47;비회원 로그인 후 1:1문의 또는 고객센터로 문의해주십시오.</li>
                <? if($order['ORDER_PAY_KIND_CD'] == '02') {?>
                    <li class="text-item">입금계좌번호와 입금예정액이 주문내역과 정확하게<br>일치하지 않을 경우 입금확인이 지연될 수 있으며,<br>주문일 기준으로 3일차 자정까지 입금확인이 되지 않으면<br>자동으로 주문 취소됩니다.</li>
                <? }?>
            </ul>
        </div>
        <!-- // 주문/결제정보-->

        <!-- 주문상품내역 // -->
        <div class="payment-complete-info order-prd-info">
            <h3 class="info-title">주문상품 내역</h3>
            <div class="order-prd-info-box">
                <ul class="order-prd-list">
                    <? $refer_cnt = 0;	//주문상품갯수 변수
                    $i = 0;
                    foreach($refer as $goods_grp){
                        $grp_yn = 'N';	//묶음상품여부
                        $refer_cnt += count($goods_grp);
                    foreach($goods_grp as $row){	?>
                        <li class="order-prd-item">
                            <a href="#" class="order-prd-link"><img src="<?=$row['IMG_URL']?>" alt="주문상품내역1"></a>
                        </li>
                    <input type="hidden" name="goods_code[]" value="<?=$row['GOODS_CD']?>">
                    <input type="hidden" name="goods_name[]" value="<?=$row['GOODS_NM']?>">
                    <input type="hidden" name="goods_selling_price[]" value="<?=$row['SELLING_PRICE']?>">
                    <input type="hidden" name="goods_cnt[]" value="<?=$row['ORD_QTY']?>">
                        <?  if($i == 0){
                            $goods_name = $row['GOODS_NM'];
                        }
                        $i++;

                        }?><!-- Google Tag Manager Add Value (eMnet) 2018.05.29-->
                        <script>
                            brandIds.push('<?=$row['GOODS_CD']?>');
                        </script>
                        <!-- End Google Tag Manager Add Value (eMnet) -->
                        <?
                    }
                    $j = $refer_cnt%5;
                    if($j > 0){
                        for($k=0; $k<5-$j; $k++){	?>
                            <li class="order-prd-item">
                                <img src="http://ui.etah.co.kr/mobile/assets/images/data/prd_none.png" alt="상품없음">
                            </li>
                        <?		}
                    }
                    ?>
                </ul>

                <div class="order-prd-list-txt-box">
                    <p class="order-prd-list-txt"><?=$goods_name?></p>
                    <span class="order-prd-list-num">외 <?=$refer_cnt-1?>개</span>
                </div>

                <div class="order-prd-list-total-box">
                    <p class="order-prd-total">총 결제금액</p>
                    <span class="order-prd-total-price"><strong class="price-color"><?=number_format($order['PAY_AMT'])?></strong>원</span>
                </div>
            </div>
        </div>
        <!-- // 주문상품내역 -->

        <!-- 배송지정보 // -->
        <div class="basic-table-wrap--title-bg payment-complete-info delivery-info-tb">
            <h3 class="info-title">배송지정보</h3>
            <table class="basic-table">
                <colgroup>
                    <col style="width:30%;">
                    <col style="width:70%;">
                </colgroup>
                <tbody>
                <tr>
                    <th scope="row" class="tb-info-title">주문하시는분</th>
                    <td class="tb-info-txt"><?=$order['SENDER_NM']?></td>
                </tr>
                <tr>
                    <th scope="row" class="tb-info-title">받으시는분</th>
                    <td class="tb-info-txt"><?=$order['RECEIVER_NM']?></td>
                </tr>
                <tr>
                    <th scope="row" class="tb-info-title">배송지주소</th>
                    <td class="tb-info-txt">(<?=strlen($order['RECEIVER_ZIPCODE']) == 6 ? substr($order['RECEIVER_ZIPCODE'],0,3)."-".substr($order['RECEIVER_ZIPCODE'],3,3) : $order['RECEIVER_ZIPCODE']?>) <?=$order['RECEIVER_ADDR1']?> <?=$order['RECEIVER_ADDR2']?></td>
                </tr>
                <tr>
                    <th scope="row" class="tb-info-title">휴대폰번호</th>
                    <td class="tb-info-txt"><?=$order['RECEIVER_MOB_NO']?></td>
                </tr>
                <tr>
                    <th scope="row" class="tb-info-title">전화번호</th>
                    <td class="tb-info-txt"><?=$order['RECEIVER_PHONE_NO']?></td>
                </tr>
                <tr>
                    <th scope="row" class="tb-info-title">배송시<br>요청사항</th>
                    <td class="tb-info-txt"><?=$order['DELIV_MSG']?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- // 배송지정보-->

        <? if($order['LIVING_FLOOR_CD'] != ''){	?>
            <!-- 가구 배송정보 // -->
            <div class="basic-table-wrap--title-bg payment-complete-info furniture-delivery-tb">
                <h3 class="info-title">가구 배송정보</h3>
                <table class="basic-table">
                    <colgroup>
                        <col style="width:30%;">
                        <col style="width:70%;">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row" class="tb-info-title">주거층 수</th>
                        <? if($order['LIVING_FLOOR_CD'] == 'LOW'){	?>
                            <td class="tb-info-txt">1~2층</td>
                        <? }else if($order['LIVING_FLOOR_CD'] == 'HIGH'){	?>
                            <td class="tb-info-txt">3층이상</td>
                        <? }?>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">계단폭</th>
                        <? if($order['STEP_WIDTH_CD'] == 'LOW'){	?>
                            <td class="tb-info-txt">2M 미만</td>
                        <? }else if($order['STEP_WIDTH_CD'] == 'HIGH'){	?>
                            <td class="tb-info-txt">2M 이상</td>
                        <? }?>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">엘리베이터</th>
                        <? if($order['ELEVATOR_CD'] == 'SEVEN'){	?>
                            <td class="tb-info-txt">1~7인승</td>
                        <? }else if($order['ELEVATOR_CD'] == 'TEN'){	?>
                            <td class="tb-info-txt">8~10인승</td>
                        <? }else if($order['ELEVATOR_CD'] == 'ELEVEN'){	?>
                            <td class="tb-info-txt">11인승 이상</td>
                        <? }else if($order['ELEVATOR_CD'] == 'NONE'){	?>
                            <td class="tb-info-txt">없음</td>
                        <? }else if($order['ELEVATOR_CD'] == 'NOUSE'){	?>
                            <td class="tb-info-txt">사용불가</td>
                        <? }?>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">제품 설치공간</th>
                        <td class="tb-info-txt">예. 설치 공간 확보했습니다.</td>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">사다리차 필요</th>
                        <td class="tb-info-txt">예. 필요한 경우 사다리차를 사용합니다.</td>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">사다리차<br>이용부담</th>
                        <td class="tb-info-txt">예. 사다리차 이용 부담금에 동의합니다.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- // 가구 배송정보-->
        <? }?>

        <?if(isset($order['RETURN_BANK_NM'])){?>
            <div class="basic-table-wrap--title-bg payment-complete-info furniture-delivery-tb">
                <h3 class="info-title">환불계좌정보</h3>
                <table class="basic-table">
                    <colgroup>
                        <col style="width:34%;">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row" class="tb-info-title">환불은행명</th>
                        <td class="tb-info-txt"><?=$order['RETURN_BANK_NM']?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">환불계좌번호</th>
                        <td class="tb-info-txt"><?=$order['RETURN_ACCOUNT_NO']?></td>
                    </tr>
                    <tr>
                        <th scope="row" class="tb-info-title">환불예금주명</th>
                        <td class="tb-info-txt"><?=$order['RETURN_CUST_NM']?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?}?>

        <ul class="common-btn-box">
            <li class="common-btn-item"><a href="/" class="btn-white btn-white--big">쇼핑계속하기</a></li>
            <li class="common-btn-item"><a href="/mywiz" class="btn-black btn-black--big">주문내역보기</a></li>
        </ul>
    </div>
</div>
<script>
    //google_gtag
    var purhase_array = new Object();

    <? $goods_array = array();
    foreach($refer as $goods_grp){
        $grp_yn = 'N';	//묶음상품여부
        foreach($goods_grp as $key => $row){
            $goods_array[$key]['id'       ] = $row['GOODS_CD'];
            $goods_array[$key]['name'     ] = $row['GOODS_NM'];
            $goods_array[$key]['list_name'] = 'purchase_list';
            $goods_array[$key]['quantity' ] = $row['ORD_QTY'];
            $goods_array[$key]['price'    ] = $row['TOTAL_PRICE'] - $row['DC_AMT'];

        }
        $goods_array = json_encode($goods_array);
    }?>

    purhase_array = <?=$goods_array?>;
    console.log(purhase_array);
    gtag('event', 'purchase', {
        "transaction_id": "<?=$order_no?>",
        "affiliation": "ETAH - Mob",
        "value": <?=$order['PAY_AMT']?>,
        "currency": "KRW",
        "shipping": <?=$order['DELIV_COST_AMT']?>,
        "items": purhase_array
    });
</script>

<!-- WIDERPLANET PURCHASE SCRIPT START 2017.3.29 -->
<div id="wp_tg_cts" style="display:none;"></div>
<script type="text/javascript">
    var wptg_tagscript_vars = wptg_tagscript_vars || [];

    //배열, 변수 생성
    var cartDataCnt		= "<?=$refer_cnt?>";
    var cartItemsArray  = new Array();
    var cartItems		= new Object();
    //alert(cartDataCnt);
    for (var a=0; a<cartDataCnt; a++)
    {
        var cartItems	= new Object();

        cartItems.i	= document.getElementsByName("goods_code[]")[a].value;
        cartItems.t	= document.getElementsByName("goods_name[]")[a].value;
        cartItems.p	= document.getElementsByName("goods_selling_price[]")[a].value;
        cartItems.q	= document.getElementsByName("goods_cnt[]")[a].value;

        cartItemsArray.push(cartItems);
    }
    //alert(JSON.stringify(cartItemsArray));
    wptg_tagscript_vars.push(
        (function() {
            return {
                wp_hcuid:"",     /*Cross device targeting을 원하는 광고주는 로그인한 사용자의 Unique ID (ex. 로그인 ID, 고객넘버 등)를 암호화하여 대입.
                                    *주의: 로그인 하지 않은 사용자는 어떠한 값도 대입하지 않습니다.*/
                ti:"35025",
                ty:"PurchaseComplete",
                device:"mobile"
                , items : cartItemsArray
                /*   ,items:[
                             {i:"상품ID", t:"상품명", p:"단가", q:"수량"} /* 첫번째 상품 - i:상품 식별번호(Feed로 제공되는 식별번호와 일치) t:상품명 p:단가 q:수량 */
                /*            ,{i:"상품ID", t:"상품명", p:"단가", q:"수량"} /* 두번째 상품 - i:상품 식별번호(Feed로 제공되는 식별번호와 일치) t:상품명 p:단가 q:수량 */
                /*   ]	*/
            };
        }));
</script>
<script type="text/javascript" async src="//cdn-aitg.widerplanet.com/js/wp_astg_4.0.js"></script>
<!-- // WIDERPLANET PURCHASE SCRIPT END 2017.3.29 -->
