			<link rel="stylesheet" href="/assets/css/mypage.css">

			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">최근 본 상품(<?=$view_cnt?>)</h2>

				<div class="prd-list-wrap prd-list-wrap--mypage">
					<ul class="prd-list prd-list--modify">
					<?if($view){
						foreach($view as $vrow){?>
						<li class="prd-item">
							<a href="/goods/detail/<?=$vrow['GOODS_CD']?>" class="prd-link">
								<img src="<?=$vrow['IMG_URL']?>" alt="<?=$vrow['GOODS_NM']?>">
							</a>
							<div class="prd-info-wrap">
								<a href="/goods/detail/<?=$vrow['GOODS_CD']?>" class="prd-link">
									<dl class="prd-info">
										<dt class="prd-item-brand"><?=$vrow['BRAND_NM']?></dt>
										<dd class="prd-item-tit"><?=$vrow['GOODS_NM']?></dd>
										<dd class="prd-item-price">
											<? if($vrow['COUPON_CD_S'] || $vrow['COUPON_CD_G']){
												$price = $vrow['SELLING_PRICE'] - ($vrow['RATE_PRICE_S'] + $vrow['RATE_PRICE_G']);
												echo number_format($price);
											?><span class="won">원</span><br>
											<del class="del-price"><?=number_format($vrow['SELLING_PRICE'])?>원</del>
											<span class="dc-rate">(<?=number_format(floor((($vrow['SELLING_PRICE']-$price)/$vrow['SELLING_PRICE'])*100) == 0 ? 1 : floor((($vrow['SELLING_PRICE']-$price)/$vrow['SELLING_PRICE'])*100))?>%<span class="spr-common ico-arrow-down"></span>)</span>
											<?} else {
												echo number_format($price = $vrow['SELLING_PRICE']);
											?><span class="won">원</span><br>
											<?
											}?>
										</dd>
									</dl>
										<ul class="prd-label-list">
                                            <?if($vrow['COUPON_CD_S'] || $vrow['COUPON_CD_G']){?>
                                            <li class="prd-label-item">쿠폰할인</li>
											<?} if(($vrow['PATTERN_TYPE_CD'] == 'FREE') || ( $vrow['DELI_LIMIT'] > 0 && $price > $vrow['DELI_LIMIT'])) {?>
											<li class="prd-label-item free_shipping">무료배송</li>
											<?} if($vrow['GOODS_MILEAGE_SAVE_RATE'] > 0){?>
											<li class="prd-label-item">마일리지</li>
											<?}?>
										</ul>
								</a>
								<ul class="prd-bookmark">
									<li class="prd-bookmark-item"><a href="#" onClick="javaScript:jsGoodsAction('W','','<?=$vrow['GOODS_CD']?>','','');" class="prd-bookmark-link <?=$vrow['INTEREST_GOODS_NO']?'active':''?>"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
									<!-- 활성화시 클래스 active 추가 -->
									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open" onClick="javaScript:openShareLayer('G', '<?=$vrow['GOODS_CD']?>', '<?=$vrow['IMG_URL']?>', '<?=$vrow['GOODS_NM']?>');"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
								</ul>
							</div>
						</li>
					<?}}?>
<!--						<li class="prd-item">
							<a href="#" class="prd-link">
								<img src="../assets/images/data/prd_item2.jpg" alt="버플리 원목 2700 거실장 세트">
							</a>
							<div class="prd-info-wrap">
								<a href="#" class="prd-link">
									<dl class="prd-info">
										<dt class="prd-item-brand">해오름가구</dt>
										<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
										<dd class="prd-item-price">
											436,500
											<del class="del-price">310,000</del>
										</dd>
									</dl>
									<ul class="prd-label-list">
										<li class="prd-label-item">쿠폰확인</li>
										<li class="prd-label-item">무료배송</li>
										<li class="prd-label-item">마일리지</li>
									</ul>
								</a>
								<ul class="prd-bookmark">
									<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>

									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
								</ul>
							</div>
						</li>-->
					</ul>
				</div>

				<!-- 페이징 // -->
				<?=$pagination?>
				<!-- //페이징 -->

				<!-- 공유하기 레이어 // -->
				<div id="share_sns"></div>
				<!-- // 공유하기 레이어 -->

				<!-- 공유하기 레이어 // -->
				<?//if($view){
					//foreach($view as $row){ ?>
		<!--		<div class="layer-wrap layer-sns-share" id="layerSnsShare<?=$row['GOODS_CD']?>">
					<div class="layer-inner">
						<h1 class="layer-title">공유하기</h1>
						<div class="layer-content">
							<ul class="layer-sns-list">
								<li class="layer-sns-item">
									<a href="javaScript:jsGoodsAction('S','K','<?=$row['GOODS_CD']?>','','<?=$row['GOODS_NM']?>');" class="layer-sns-link"><span class="spr-layer layer-sns-kakaotalk"></span>카카오톡</a>
								</li>
								<li class="layer-sns-item">
									<a href="javaScript:jsGoodsAction('S','F','<?=$row['GOODS_CD']?>','<?=$row['IMG_URL']?>','<?=$row['GOODS_NM']?>');" class="layer-sns-link"><span class="spr-layer layer-sns-facebook"></span>페이스북</a>
								</li>
								<li class="layer-sns-item">
									<a href="#" class="layer-sns-link"><span class="spr-layer layer-sns-instagram"></span>인스타그램</a>
								</li>
							</ul>
							<a href="javaScript:jsUrlCopy('devm.etah.co.kr/goods/detail/<?=$row['GOODS_CD']?>');" class="btn-layer-url-copy">URL 복사하기</a>
						</div>
						<a href="#" class="btn-layer-close" data-close="layer-close"><span class="hide">닫기</span></a>
					</div>
				</div>	-->
				<?//}}?>
				<!-- // 공유하기 레이어 -->
