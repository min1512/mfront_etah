				<link rel="stylesheet" href="/assets/css/vip.css">
				
				<!-- 취소/반품신청 레이어 // -->
				<div class="common-layer-wrap layer-shopping-cancel-return" id="layerShoppingCancelReturn">
					<h3 class="common-layer-title">취소신청</h3>
					<!-- common-layer-content //-->
					<div class="common-layer-content ">
						<!--<div class="common-form-line-wrap">
							<div class="form-line">
								<div class="form-line-title"><label for="mypageShoppingName">주문자명</label></div>
								<div class="form-line-info">
									<input type="text" class="input-text" id="mypageShoppingName" placeholder="etah">
								</div>
							</div>
							<div class="form-line">
								<div class="form-line-title"><label for="mypageShoppingPayment">결제수단</label></div>
								<div class="form-line-info">
									<input type="text" class="input-text" id="mypageShoppingPayment" placeholder="무통장입금">
								</div>
							</div>
							<div class="form-line form-line--cols">
								<div class="form-line-title"><label for="mypageShoppingPhone_1_1">연락처</label></div>
								<div class="form-line-info">
									<input type="text" class="input-text" id="mypageShoppingPayment" placeholder="숫자만 입력해주세요." onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
								</div>
							</div>
						</div>-->

						<h3 class="info-title info-title--sub">상품정보</h3>
						<div class="media-area prd-order-media">
							<span class="media-area-img prd-order-media-img"><img src="<?=$order['IMG_URL']?>" alt=""></span>
							<span class="media-area-info prd-order-media-info">
							<span class="prd-order-media-info-brand">[<?=$order['BRAND_NM']?>] <?=$order['GOODS_NM']?></span>
							<span class="prd-order-media-info-name">옵션명 : <?=$order['GOODS_OPTION_NM']?><?=$order['SELLING_ADD_PRICE'] > 0 ? " (+".number_format($order['SELLING_ADD_PRICE']).")" : ""?></span>
							<span class="prd-order-media-info-price">상품금액 <strong class="bold"><?=number_format($order['SELLING_PRICE'])?></strong><span class="won">원</span></span>/
							<span class="prd-order-media-info-price">
								<?
								$str_delivery = "";
								$deli_cost = "";
								switch($order['PATTERN_TYPE_CD']){
									case 'PRICE' :	if($order['DELI_LIMIT']>(($order['SELLING_PRICE']+$order['SELLING_ADD_PRICE'])*$order['ORD_QTY'])){
														$str_delivery = "배송비 ".number_format($order['DELI_COST'])."원";
														$deli_cost = $order['DELI_COST'];
													}else{
														$str_delivery = "무료배송";
														$deli_cost = "0";
													} break;
									case 'FREE'  :	$str_delivery = "무료배송"; 
													$deli_cost = "0";	break;
									case 'STATIC': 	$str_delivery = "배송비 ".number_format($order['DELI_COST'])."원";
													$deli_cost = $order['DELI_COST']; break;
								}
								echo $str_delivery;
								?>
							</span>
							<div style="padding-top:10px; padding-right:20%;">
                                <input type="hidden" value="<?=$order['ORD_QTY']?>" name="qty">
                                <span class="prd-order-media-info-brand">수량 <?=$order['ORD_QTY']?>개</span>
<!--							<div class="ui-buy-quantity">-->
<!--								<input type="text" class="quantity_input" name="qty" readonly value="--><?//=$order['ORD_QTY']?><!--">-->
<!--								<button type="button" class="quantity_minus_btn"><span class="hide-text">minus</span></button>-->
<!--								<button type="button" class="quantity_plus_btn"><span class="hide-text">plus</span></button>-->
<!--							</div>-->
							</div>
							</span>
						</div>

						<h3 class="info-title info-title--sub">취소사유</h3>

						<div class="form-line form-line--wide">
							<div class="select-box select-box--big">
								<select class="select-box-inner" name="reason">
									<option value="" selected>취소사유 선택</option>
									<?foreach($reason_list as $row){?>
									<option value="<?=$row['CANCEL_RETURN_REASON_CD']?>"><?=$row['CANCEL_RETURN_REASON_CD_NM']?></option>
									<?}?>
								</select>
							</div>
						</div>
						<div class="form-line form-line--wide">
							<div class="form-line-info">
								<label>
									<textarea type="text" class="input-text input-text--textarea" placeholder="상세사유를 입력해주세요." name="reason_detail"></textarea>
								</label>
							</div>
						</div>
						
						<br/><br/>
							<div class="media-area prd-order-media">
							<h3 class="info-title info-title--sub">환불예상금액</h3>
						</div>

						<div class="media-area prd-order-media">
							<div style="font-family:'맑은 고딕';  padding-left:20px;">
								<div style=" color:gray;">
								<b>· </b><span class="prd-order-media-info-price" id="str_goods_pri">상품금액 : <?=number_format(($order['SELLING_PRICE']+$order['SELLING_ADD_PRICE'])*$order['ORD_QTY'])?><span class="won">원</span></span><br/>
								<b>· </b><span class="prd-order-media-info-price" id="str_deli_cost">배송비 &nbsp;&nbsp;&nbsp;: <?=number_format($deli_cost)?><span class="won">원</span></span><input type="hidden" id="t_deli_cost" value=0><br/>
								<b>· </b><span class="prd-order-media-info-price">할인금액 : -<?=number_format($order['DC_AMT'])?><span class="won">원</span></span><br/><br/>
								</div>
								<b><span class="prd-order-media-info-price" id="str_total_price">환불예상금액 : <?=number_format((($order['SELLING_PRICE']+$order['SELLING_ADD_PRICE'])*$order['ORD_QTY'])-($order['DC_AMT'])+$deli_cost)?>원</span></b>
								
							</div>
						</div>
						<br/><br/><br/>

						<div class="media-area prd-order-media">
						</div>
						<div class="mypage-info-section mypage-info-section--border">
							<h4 class="mypage-info-section-title"><span class="ico-i">i</span>취소 시 유의사항</h4>
							<ul class="text-list">
								<li class="text-item">신용카드는 승인취소의 방법으로 환불처리가 되고, 체크카드는 승인취소 후 해당 카드 계좌로 입금 됩니다.</li>
								<li class="text-item">환불은 취소 승인 후 약 3~5일(주말&#47;공휴일 제외) 소요될 수 있습니다.</li>
								<li class="text-item">장바구니 구매건 중 일부 상품이 취소되는 경우, 카드사에 따라 부분취소 또는 재결제의 방식으로 대금 환급이 진행될 수 있습니다.</li>
							</ul>
						</div>
						<ul class="common-btn-box">
							<li class="common-btn-item"><a href="javaScript:;" class="btn-white btn-white--big" onClick="javaScript:$('#layerShoppingCancelReturn').attr('class','common-layer-wrap layer-shopping-cancel-return'); $('#etah_html').removeClass();">신청취소</a></li>
							<li class="common-btn-item"><a href="javaScript:;" class="btn-black btn-black--big" onClick="javaScript:cancel_apply('<?=$order['ORDER_REFER_NO']?>');">취소신청</a></li>
						</ul>
					</div>
					<a href="#" class="btn-layer-close" onClick="javaScript:document.getElementById('layerShoppingCancelReturn').className = 'common-layer-wrap layer-shopping-cancel-return'; $('html').removeClass('bottom-layer-open'); $('#etah_html').removeClass();"><span class="hide"><span class="hide">닫기</span></a>
					<!-- // common-layer-content -->
				</div>

				<!-- // 취소/반품신청 레이어 -->


				<script type="text/javaScript">

				//====================================
				// 취소신청
				//====================================
				function cancel_apply(val){
					var order_refer_no = val, 
						gb = 'CANCEL',
						qty = $('input[name=qty]').val(),
						reason = $('select[name=reason]').val(),
						reason_detail = $('textarea[name=reason_detail]').val(),
						state_cd = 'OC01';
					
					if(reason == ''){
						alert("취소사유를 입력해주세요.");
						$('select[name=reason]').focus();
						return false;
					}
					if(reason_detail == ''){
						alert("상세사유를 입력해주세요.");
						$('textarea[name=reason_detail]').focus();
						return false;
					}
					
					if(confirm("취소신청 하시겠습니까?")){
					
						$.ajax({
							type: 'POST',
							url: '/mywiz/cancel_apply',
							dataType: 'json',
							data: {	order_refer_no : order_refer_no,
									gb : gb,
									qty : qty,
									reason : reason,
									reason_detail : reason_detail,
									state_cd : state_cd },
							error: function(res) {
								alert('Database Error');
							},
							success: function(res) {
								if(res.status == 'ok'){
										alert("취소되었습니다.");
										location.reload();
								}
								else alert(res.message);
							}
						});
					}
				}

				</script>