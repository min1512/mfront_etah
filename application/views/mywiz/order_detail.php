			<link rel="stylesheet" href="/assets/css/mypage.css">
			
			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">쇼핑내역</h2>
				<h3 class="info-title info-title--sub">주문&#47;배송상세</h3>
				<div class="basic-table-wrap basic-table-wrap--title-bg mypage-order-detail">
					<table class="basic-table">
						<colgroup>
							<col style="width:34%;">
							<col>
						</colgroup>
						<tbody>
							<tr>
								<th scope="row" class="tb-info-title">주문일&#47;주문번호</th>
								<td class="tb-info-txt"><?=substr($order['REG_DT'],0,10)?> &#47; <?=$order['ORDER_NO']?></td>
							</tr>
							<tr>
								<th scope="row" class="tb-info-title">결제방법</th>
								<td class="tb-info-txt">
									<?
									$str_pay_kind = "";
									switch($order['ORDER_PAY_KIND_CD']){
										case '01' : $str_pay_kind = $order['CARD_COMPANY_NM']. " ";
													$order['FREE_INTEREST_YN'] == 'Y' ? $str_pay_kind .= "무이자 " : "";
													if($order['CARD_MONTH']){
														$str_pay_kind .= $order['CARD_MONTH']."개월 할부";
													}else{
														$str_pay_kind .= "일시불";
													}
													$str_pay_kind .= "<br/>".$order['ORDER_PAY_COMPLETE_DT'];
													echo $str_pay_kind; break;
										case '02' :
													if($order['ORDER_REFER_PROC_STS_CD']=='OA00' || $order['ORDER_REFER_PROC_STS_CD']=='OA01' || $order['ORDER_REFER_PROC_STS_CD']=='OA02'){
														$str_pay_kind = "무통장입금 (".$order['BANK_NM']." ".$order['BANK_ACCOUNT_NO']." / 예금주 : 에타몰)<br />입금기한 : ".date("Y-m-d H:i:s", strtotime($order['DEPOSIT_DEADLINE_DY']))." (입금 기한까지 입금하지 않으시면 자동취소 됩니다.)";
														echo $str_pay_kind;
													}else{
														$str_pay_kind = "무통장입금";
														echo $str_pay_kind;
													}
													break;
                                        case '03' :
                                                    $str_pay_kind = '실시간계좌이체';
                                                    echo $str_pay_kind;
                                                    break;
                                        case '04' :
                                                    $str_pay_kind = "마일리지";
                                                    echo $str_pay_kind;
                                                    break;
                                        case '05' :
                                                    $str_pay_kind = '휴대폰 결제';
                                                    echo $str_pay_kind;
                                                    break;
                                        case '07' :
                                                    $str_pay_kind = '카카오페이';
                                                    echo $str_pay_kind;
                                                    break;
                                        case '08' :
                                                    if($order['ORDER_REFER_PROC_STS_CD']=='OA00' || $order['ORDER_REFER_PROC_STS_CD']=='OA01' || $order['ORDER_REFER_PROC_STS_CD']=='OA02'){
                                                        $str_pay_kind = "ARS결제 (가상번호 : ".preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/", "\\1-\\2-\\3", $order['VARS_VNUM_NO']).")<br />입금기한 : ".date("Y-m-d H:i:s", strtotime($order['VARS_EXPR_DT']))." (입금 기한까지 입금하지 않으시면 자동취소 됩니다.)";
                                                        echo $str_pay_kind;
                                                    }else{
                                                        $str_pay_kind = "ARS결제";
                                                        echo $str_pay_kind;
                                                    }
                                                    break;
                                        case '09' :
                                                    $str_pay_kind = $order['ORDER_PAY_KIND_NM'];
                                                    echo $str_pay_kind;
                                                    break;
                                        case '10' :
                                                $str_pay_kind = '이벤트';
                                                echo $str_pay_kind;
                                                break;

									}
									?>
									
								</td>
							</tr>
							<tr>
								<th scope="row" class="tb-info-title">주문금액</th>
								<td class="tb-info-txt">
                                    <?=number_format($order['ORDER_AMT']+$order['DELIV_COST_AMT'])?>원
                                </td>
							</tr>
							<tr>
								<th scope="row" class="tb-info-title">할인금액</th>
								<td class="tb-info-txt"><?=number_format($order['DC_AMT'])?>원 <?=$order['DC_AMT']>0 ? "(쿠폰할인 : ".number_format($order['DC_AMT'])."원)" : ""?></td>
							</tr>
							<tr class="bg">
								<th scope="row" class="tb-info-title">결제금액</th>
								<td class="tb-info-txt"><strong>
									<?=number_format($order['TOTAL_PAY_SUM'])?><span class="won"></strong>원
                                    <?
                                    if($order['PAY_MILEAGE']) {
                                        if($order['REAL_PAY_AMT'] == 0) {
                                            echo "(마일리지 : ".number_format($order['PAY_MILEAGE'])."원)";
                                        } else {
                                            echo "(".$order['ORDER_PAY_KIND_NM']." : ".number_format($order['R_PAY_AMT'])."원 + 마일리지 : ".number_format($order['PAY_MILEAGE'])."원)";
                                        }
                                    } else {
                                        echo "";
                                    }
                                    ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<h3 class="info-title info-title--sub">상품정보</h3>
				<?foreach($order_dtl as $row){?>
				<div class="prd-order-section prd-order-section--info">
					<div class="prd-order-title">
						<span class="prd-order-number"><?=$row['GOODS_CD']?></span>
						<span class="prd-order-title-name">[<?=$row['BRAND_NM']?>] <?=$row['GOODS_NM']?></span>
					</div>
					<div class="media-area prd-order-media">
						<span class="media-area-img prd-order-media-img">
							<a href="/goods/detail/<?=$row['GOODS_CD']?>"><img src="<?=$row['IMG_URL']?>" alt=""></a>
						</span>
						<span class="media-area-info prd-order-media-info">
							<span class="prd-order-media-info-option"><?=$row['GOODS_OPTION_NM']?><?if($row['SELLING_ADD_PRICE'] > 0){?>( 옵션추가금액 : <?=number_format($row['SELLING_ADD_PRICE'])?> ) <?}?> &#47; <?=$row['ORD_QTY']?>개</span>
						<span class="prd-order-media-info-status"><?=$row['ORDER_REFER_PROC_STS_CD_NM']?> </span>
						</span>
					</div>
					<div class="prd-order-dc-price">
						<strong class="price"><?=number_format($row['SUM_GOODS_SELIING_PRICE']-$row['SUM_R_DC_AMT']+$row['ORDER_DELIV_COST'])?><span class="won">원</span></strong>
						<span class="price-explain">(판매가 <strong class="bold"><?=number_format(($row['SELLING_PRICE']+$row['SELLING_ADD_PRICE'])*$row['ORD_QTY'])?></strong>원 - 할인 <strong class="bold"><?=number_format($row['SUM_R_DC_AMT'])?></strong>원 + 배송비 <strong class="bold"><?=$row['ORDER_DELIV_COST']?></strong>원)</span>
					</div>
					
					<?if($row['CANCEL_YN']=='Y' && !in_array($order['ORDER_PAY_KIND_CD'], array('09','10'))){?>
                        <a href="#layerShoppingCancelReturn" class="btn-white btn-order-cancel" onClick="javaScript:openApplyLayer(<?=$row['ORDER_REFER_NO']?>, 'layer_cancel');">취소신청</a>
                    <?}?>
					<?if($row['RETURN_YN']=='Y' && !in_array($order['ORDER_PAY_KIND_CD'], array('09','10'))){?>
						<a href="#layerShoppingCancelReturn" class="btn-white btn-order-cancel" onClick="javaScript:openApplyLayer(<?=$row['ORDER_REFER_NO']?>, 'layer_return');">반품신청</a>
					<?}?>
				</div>
				<?}?>

				<!--<div class="prd-order-section prd-order-section--info">
					<div class="prd-order-title">
						<span class="prd-order-number">1077990</span>
						<span class="prd-order-title-name">[LAMPDA]마이키 장스탠드(블랙)</span>
					</div>
					<div class="media-area prd-order-media">
						<span class="media-area-img prd-order-media-img">
							<img src="../assets/images/data/data_100x100.jpg" alt="">
						</span>
						<span class="media-area-info prd-order-media-info">
							<span class="prd-order-media-info-option">단일상품 &#47; 2개</span>
						<span class="prd-order-media-info-status">배송중 </span>
						</span>
					</div>
					<div class="prd-order-dc-price">
						<strong class="price">305,000<span class="won">원</span></strong>
						<span class="price-explain">(판매가 <strong class="bold">15,000</strong>원 - 할인 <strong class="bold">137</strong>원 + 배송비 <strong class="bold">0</strong>원)</span>
					</div>
					<a href="#layerShoppingCancelReturn" class="btn-white btn-order-cancel" data-layer="bottom-layer-open2">취소/반품신청</a>
				</div>-->

                <h3 class="info-title info-title--sub">배송지정보</h3>
                <div class="basic-table-wrap basic-table-wrap--title-bg mypage-order-detail">
                    <table class="basic-table">
                        <colgroup>
                            <col style="width:34%;">
                            <col>
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
                                <td class="tb-info-txt">(<?=$order['RECEIVER_ZIPCODE']?>) <?=$order['RECEIVER_ADDR1']." ".$order['RECEIVER_ADDR2']?></td>
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
                                <th scope="row" class="tb-info-title">배송시 <br>요청사항</th>
                                <td class="tb-info-txt"><?=$order['DELIV_MSG']?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

				<?if($order['PARENT_CATEGORY_MNG_CD'] == '10000000' || $order['CATEGORY_MNG_CD'] == '18010000'){?>
				<h3 class="info-title info-title--sub">가구 배송정보</h3>
				<div class="basic-table-wrap basic-table-wrap--title-bg mypage-order-detail">
					<table class="basic-table">
						<colgroup>
							<col style="width:34%;">
							<col>
						</colgroup>
						<tbody>
							<tr>
								<th scope="row" class="tb-info-title">주거층수</th>
								<td class="tb-info-txt">
								<?
								switch($order['LIVING_FLOOR_CD']){
									case 'LOW' : echo "1~2층"; break;
									case 'HIGH': echo "3층 이상"; break;
								}
								?>
								</td>
							</tr>
							<tr>
								<th scope="row" class="tb-info-title">계단폭</th>
								<td class="tb-info-txt">
								<?
								switch($order['STEP_WIDTH_CD']){
									case 'LOW' : echo "2m 미만"; break;
									case 'HIGH': echo "2m 이상"; break;
								}
								?>
								</td>
							</tr>
							<tr>
								<th scope="row" class="tb-info-title">엘리베이터</th>
								<td class="tb-info-txt">
								<?
								switch($order['ELEVATOR_CD']){
									case 'SEVEN'	: echo "1~7인승"; break;
									case 'TEN'		: echo "8~10인승"; break;
									case 'ELEVEN'	: echo "11인승 이상"; break;
									case 'NONE'		: echo "없음"; break;
									case 'NOUSE'	: echo "사용불가"; break;
								}
								?>
								</td>
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
								<th scope="row" class="tb-info-title">사다리차<br>이용 부담</th>
								<td class="tb-info-txt">예. 사다리차 이용 부담금에 동의합니다.</td>
							</tr>
						</tbody>
					</table>
				</div>
				<?}?>

                <?if(isset($order['RETURN_BANK_NM'])){?>
                <h3 class="info-title info-title--sub">환불계좌정보</h3>
                <div class="basic-table-wrap basic-table-wrap--title-bg mypage-order-detail">
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

				<ul class="common-btn-box mypage-bottom-btn">
					<li class="common-btn-item"><a href="/mywiz/order" class="btn-gray btn-gray--big">목록으로</a></li>
				</ul>

				<div id="apply"></div>

			
			<script>


			//====================================
			// 취소/반품 신청 레이어
			//====================================
			function openApplyLayer(order_refer_no, url){
				
				$.ajax({
					type: 'POST',
					url: '/mywiz/'+url,
					dataType: 'json',
					data: { order_refer_no : order_refer_no},
					error: function(res) {
						alert('Database Error');
					},
					async : false,
					success: function(res) {
						if(res.status == 'ok'){
							$("#apply").html(res.apply);

						}
						else alert(res.message);
					}
				});

				$('#layerShoppingCancelReturn').addClass('common-layer-wrap--view');
				$('html').addClass('bottom-layer-open');

					
			}


			</script>

