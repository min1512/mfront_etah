				<link rel="stylesheet" href="/assets/css/display.css">

				<div class="content">
				<h3 class="info-title info-title--sub">MD 픽!</h3>

				<!-- 상품리스트// -->
				<div class="prd-list-wrap">
					<ul class="prd-list prd-list--modify">
						<?foreach($goods as $row){?>
						<li class="prd-item">
							<a href="/goods/detail/<?=$row['GOODS_CD']?>" class="prd-link">
								<img src="<?=$row['IMG_URL']?>">
							</a>
							<div class="prd-info-wrap">
								<a href="/goods/detail/<?=$row['GOODS_CD']?>" class="prd-link">
									<dl class="prd-info">
										<dt class="prd-item-brand"><?=$row['BRAND_NM']?></dt>
										<dd class="prd-item-tit"><?=$row['NAME']?></dd>
										<dd class="prd-item-price">
											<?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
												$price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
												//$price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']);
												echo number_format($price);

												/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
												$sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
												$sale_percent = strval($sale_percent);
												$sale_percent_array = explode('.',$sale_percent);
												$sale_percent_string = $sale_percent_array[0];
											?>
											<span class="won">원</span><br>
											<del class="del-price"><?=number_format($row['SELLING_PRICE'])?></del>
											<!--<span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)</span>-->
											<span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)</span>
											<?}else{
												echo number_format($price = $row['SELLING_PRICE']);	?>
												<span class="won">원</span><br>
											<?
											}?>
										</dd>

									</dl>
									<ul class="prd-label-list">
										<? if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){?>
										<li class="prd-label-item">쿠폰할인</li>
										<?}?>
										<? if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])) {?>
										<li class="prd-label-item">무료배송</li>
										<?} if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){?>
										<li class="prd-label-item">마일리지</li>
										<?}?>
									</ul>
								</a>
								<ul class="prd-bookmark">
									<li class="prd-bookmark-item"><a href="javaScript:jsGoodsAction('W','','<?=$row['GOODS_CD']?>','','');" class="prd-bookmark-link <?=@$row['INTEREST_GOODS_NO']?'active':''?>"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
									<!-- 활성화시 클래스 active 추가 -->
									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" onClick="javaScript:openShareLayer('G', '<?=$row['GOODS_CD']?>', '<?=$row['IMG_URL']?>', '<?=$row['GOODS_NM']?>');"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
								</ul>
							</div>
						</li>
						<?}?>
					</ul>
				</div>

				<div id="share_sns"></div>
				<!-- //상품리스트-->

				<!-- 페이징 //
				<div class="page page--prd">
					<ul class="page-num-list">
						<li class="page-num-item page-num-left page-num-double-left">
							<a href="#" class="page-num-link"></a>
						</li>
						<li class="page-num-item page-num-left">
							<a href="#" class="page-num-link"></a>
						</li>
						<li class="page-num-item active">
							<a href="#" class="page-num-link">1</a>
						</li>
						<li class="page-num-item">
							<a href="#" class="page-num-link">2</a>
						</li>
						<li class="page-num-item">
							<a href="#" class="page-num-link">3</a>
						</li>
						<li class="page-num-item">
							<a href="#" class="page-num-link">4</a>
						</li>
						<li class="page-num-item">
							<a href="#" class="page-num-link">5</a>
						</li>
						<li class="page-num-item page-num-right active">
							<a href="#" class="page-num-link"></a>
						</li>
						<li class="page-num-item page-num-right page-num-double-right">
							<a href="#" class="page-num-link"></a>
						</li>
					</ul>
				</div>
				 // 페이징  -->
                    

