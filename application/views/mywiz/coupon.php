			<link rel="stylesheet" href="/assets/css/mypage.css">

			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">나의 혜택관리</h2>
				<div class="mypage-benefit-wrap mypage-coupon-history">
					<h3 class="info-title info-title--sub">쿠폰현황</h3>
					<ul class="tab-common-list">
						<li class="tab-common-item <?=$last_coupon != "L" ? "active" : ""?>"><a href="javaScript:;" class="tab-common-link" onClick="javaScript:search_coupon();">사용 가능한 쿠폰</a></li>
						<!-- 활성화시 클래스 active추가 -->
						<li class="tab-common-item <?=$last_coupon == "L" ? "active" : ""?>"><a href="javaScript:;" class="tab-common-link" onClick="javaScript:search_coupon('L');">지난 쿠폰 내역</a></li>
					</ul>

					<!-- 사용가능한쿠폰 // -->
					<div id="mypageUseCoupon" class="mypage-coupon-content" data-ui="tab-cont" style="display:block;">
						<div class="basic-table-wrap basic-table-wrap--title-bg">
							<table class="basic-table">
								<colgroup>
									<col style="width:25%;">
									<col style="width:50%;">
									<col style="width:25%;">
								</colgroup>
								<thead>
									<tr>
										<th scope="col" class="tb-info-title">쿠폰종류</th>
										<th scope="col" class="tb-info-title">쿠폰정보</th>
										<th scope="col" class="tb-info-title">유효기간</th>
									</tr>
								</thead>
								<tbody>
								<?if($coupon_list){
									foreach($coupon_list as $row){?>
									<tr>
										<td class="tb-info-txt">EVENT 구매자쿠폰</td>
										<td class="tb-info-txt">
											<ul class="text-list">
												<li class="text-item"> <?=$row['DC_COUPON_NM']?></li>
												<li class="text-item"><!--10,000원 이상 구매시 최대 5,000원 할인-->
                                                <?if($row['MIN_AMT'] != null){?>
                                                    <?=$row['MIN_AMT']?>원 이상 구매시
                                                <?}?> 최대 <?=$row['MAX_DISCOUNT']?>원 할인
                                                </li>
											</ul>
										</td>
										<td class="tb-info-txt"><?=$row['COUPON_START_DT']?> ~ <?=$row['COUPON_END_DT']?></td>
									</tr>
								<?
									}
								}else{
								?>
								<tr><td class="tb-info-txt" colspan="3">쿠폰내역이 없습니다.</td></tr>
								<?}?>
								</tbody>
							</table>
						</div>

						<ul class="text-list">
							<li class="text-item">쿠폰은 중복사용 할 수 없으며, 주문취소/반품시의 쿠폰은 환원됩니다. (쿠폰 사용기간 내)</li>
							<li class="text-item">주문취소/반품 시에는, 해당상품에 적용된 할인금액을 제외하고 실제 결제금액만큼 환불됩니다.</li>
							<li class="text-item">할인쿠폰 별 사용 유효기간을 꼭 확인하시기 바랍니다.</li>
							<li class="text-item">할인쿠폰 사용하여 주문 시, 할인된 금액을 제외하고 실제 결제하신 금액에 대해서 상품의 적립금이 부여됩니다.</li>
							<li class="text-item">할인쿠폰은 일부 상품에는 적용되지 않으며 쿠폰의 종류에 따라서 특정상품에만 적용될 수 있습니다.</li>
							<li class="text-item">쿠폰금액이 판매금액 보다 높은 경우 잔액은 환원되지 않습니다.</li>
						</ul>
					</div>
					<!-- // 사용가능한쿠폰 -->

					<!-- 지난쿠폰내역
					<div id="mypageCouponHistory" class="mypage-coupon-content" data-ui="tab-cont" style="display:none;">
						<div class="basic-table-wrap basic-table-wrap--title-bg">
							<table class="basic-table">
								<colgroup>
									<col style="width:25%;">
									<col style="width:50%;">
									<col style="width:25%;">
								</colgroup>
								<thead>
									<tr>
										<th scope="col" class="tb-info-title">쿠폰종류</th>
										<th scope="col" class="tb-info-title">쿠폰정보</th>
										<th scope="col" class="tb-info-title">유효기간</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="tb-info-txt">회원가입<br>감사<br>구매자쿠폰</td>
										<td class="tb-info-txt">
											<ul class="text-list">
												<li class="text-item">고객 전용 쿠폰</li>
											</ul>
										</td>
										<td class="tb-info-txt">2016.11.30 ~ 2016.12.30</td>
									</tr>
									<tr>
										<td class="tb-info-txt">PC오픈<br>구매자쿠폰</td>
										<td class="tb-info-txt">
											<ul class="text-list">
												<li class="text-item">고객 전용 쿠폰</li>
											</ul>
										</td>
										<td class="tb-info-txt">2016.11.30 ~ 2016.12.30</td>
									</tr>
									<tr>
										<td class="tb-info-txt">실수인듯<br>제공된<br>썸 쿠폰</td>
										<td class="tb-info-txt">
											<ul class="text-list">
												<li class="text-item">고객 전용 쿠폰</li>
											</ul>
										</td>
										<td class="tb-info-txt">2016.11.30 ~ 2016.12.30</td>
									</tr>
								</tbody>
							</table>
						</div>

						<ul class="text-list">
							<li class="text-item">쿠폰은 중복사용 할 수 없으며, 주문취소/반품시의 쿠폰은 환원됩니다. (쿠폰 사용기간 내)</li>
							<li class="text-item">주문취소/반품 시에는, 해당상품에 적용된 할인금액을 제외하고 실제 결제금액만큼 환불됩니다.</li>
							<li class="text-item">할인쿠폰 별 사용 유효기간을 꼭 확인하시기 바랍니다.</li>
							<li class="text-item">할인쿠폰 사용하여 주문 시, 할인된 금액을 제외하고 실제 결제하신 금액에 대해서 상품의 적립금이 부여됩니다.</li>
							<li class="text-item">할인쿠폰은 일부 상품에는 적용되지 않으며 쿠폰의 종류에 따라서 특정상품에만 적용될 수 있습니다.</li>
							<li class="text-item">쿠폰금액이 판매금액 보다 높은 경우 잔액은 환원되지 않습니다.</li>
						</ul>
					</div>
					지난쿠폰내역 -->
				</div>
			</div>

			<script>
			//====================================
			// 조회
			//====================================
			function search_coupon(val)
			{
				var	page		= 1
					, goods_cd  = $('#goods_cd').val()
					, last_coupon = "";

				if(val == 'L') last_coupon = val;

				var param = "";
				param += "page="			+ page;
				param += "&goods_cd="		+ goods_cd;
				param += "&last_coupon="	+ last_coupon;

				document.location.href = "/mywiz/coupon_page/"+page+"?"+param;
			}

			</script>