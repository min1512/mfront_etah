
				<!-- 배송조회 레이어 // -->
				<div class="common-layer-wrap cart-coupon-layer" id="layerMypageShopping">
					<!-- common-layer-wrap--view 추가 -->
					<h3 class="common-layer-title">배송조회</h3>

					<!-- common-layer-content // -->
					<div class="common-layer-content delivery-search-layer">
						<div class="media-area prd-order-media">
							<span class="media-area-img prd-order-media-img"><img src="<?=$delivery['IMG_URL']?>" alt=""></span>
							<span class="media-area-info prd-order-media-info">
					<span class="prd-order-media-info-brand">[<?=$delivery['BRAND_NM']?>] <?=$delivery['GOODS_NM']?></span>
							<span class="prd-order-media-info-name">외 2개 </span>
							<span class="prd-order-media-info-price">주문금액 <strong class="bold">315,000</strong><span class="won">원</span></span>
							</span>
						</div>
						<table class="basic-table">
							<colgroup>
								<col style="width:25%;">
								<col style="width:75%;">
							</colgroup>
							<tbody>
								<tr>
									<th scope="col" class="tb-info-title">주문상태</th>
									<td class="tb-info-txt"><?=$delivery['ORDER_REFER_PROC_STS_CD_NM']?></td>
								</tr>
								<tr>
									<th scope="row" class="tb-info-title">택배사</th>
									<td class="tb-info-txt"><?=$delivery['DELIVERY_COMPANY_NM']?></td>
								</tr>
								<tr>
									<th scope="row" class="tb-info-title">운송장번호</th>
									<td class="tb-info-txt"><?=$delivery['INVOICE_NO']?></td>
								</tr>
							</tbody>
						</table>
						<ul class="common-btn-box">
							<li class="common-btn-item"><a href="javaScript:;" class="btn-gray btn-gray--big" onClick="javaScript:document.getElementById('layerMypageShopping').className = 'common-layer-wrap cart-coupon-layer';">확인</a></li>
						</ul>
					</div>
					<!-- // common-layer-content -->

					<a href="javaScript:;" class="btn-layer-close" onClick="javaScript:document.getElementById('layerMypageShopping').className = 'common-layer-wrap cart-coupon-layer';"><span class="hide">닫기</span></a>
				</div>

				<!-- // 배송조회 레이어 레이어 -->