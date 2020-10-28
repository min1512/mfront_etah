<link rel="stylesheet" href="/assets/css/main.css">

<div class="content">
				<!-- main banner // -->
				<div class="main-banner" id="detailImgFlick">
					<ul class="main-banner-list" id="bannerList">
					<?=$top[0]['DISP_HTML']?>
		<!--				<li class="main-banner-item" style="z-index: 1">
							<a href="#" class="main-banner-link">
								<img src="http://ui.etah.co.kr/assets/images/data/161121_main_banner_01.jpg" alt="">
								<strong class="main-banner-title">Chilewich<br />페블 테이블 매트, 러너<br />20% 특별 할인</strong>
								<span class="main-banner-text">단 일주일, 반짝 세일 기회를 잡으세요!</span>
							</a>
						</li>
						<li class="main-banner-item">
							<a href="#" class="main-banner-link">
								<img src="http://ui.etah.co.kr/assets/images/data/161103_main_banner_01.jpg" alt="">
								<strong class="main-banner-title">봄티비리빙 OPEN <br>기념 20% 할인전</strong>
								<span class="main-banner-text">봄티비리빙의 액자 소품을 <br> 할인된 가격으로 만나보세요.</span>
							</a>
						</li>
						<li class="main-banner-item">
							<a href="#" class="main-banner-link">
								<img src="http://ui.etah.co.kr/assets/images/data/160921_main_banner_01.jpg" alt="">
								<strong class="main-banner-title">집에 관한 모든 것,<br />에타 회원님이<br />되어주세요!</strong>
								<span class="main-banner-text">에타 회원이 되시면, 브랜드 프로모션 및 마일리지 적립 등을<br />제약없이 참여하실 수 있습니다.</span>
							</a>
						</li>
						<li class="main-banner-item">
							<a href="#" class="main-banner-link">
								<img src="http://ui.etah.co.kr/assets/images/data/161103_main_banner_02.jpg" alt="">
								<strong class="main-banner-title">HOMEWORKS<br />수입 소품 기획전</strong>
								<span class="main-banner-text">움브라, 인터디자인, 프레젠트, 웨스코, 야마토재팬 <br/> 신규 입점 브랜드 할인</span>
							</a>
						</li>	-->
					</ul>

					<a href="#" class="btn-white-prev spr-common" id="banner_left" tile="이전이미지"></a>
					<a href="#" class="btn-white-next spr-common" id="banner_right" titlt="다음이미지"></a>
					<ul class="circle-page" id="bigBannerPage">
						<li class="circle-page-item active">
							<a href="#" title="1"></a>1번이미지</li>
						<li class="circle-page-item">
							<a href="#" title="2"></a>2번이미지</li>
						<li class="circle-page-item">
							<a href="#" title="3"></a>3번이미지</li>
						<li class="circle-page-item">
							<a href="#" title="4"></a>4번이미지</li>
					</ul>
				</div>
				<!-- // main banner -->

				<!-- category menu // -->
				<ul class="category-menu-list category-menu-list--main">
				<? $icon = '';
					for($a=0; $a<count($menu['arr_menu1_cd']); $a++){
					switch($menu['arr_menu1_cd'][$a]){
						case "10000000": $icon = 'spr-common ico-category-furniture';	break;
						case "11000000": $icon = 'spr-common ico-category-interior';	break;
						case "13000000": $icon = 'spr-common ico-category-diy';			break;
						case "14000000": $icon = 'spr-common ico-category-light';		break;
						case "18000000": $icon = 'spr-common ico-category-pet';			break;
						case "19000000": $icon = 'spr-common ico-category-kitchen';		break;
						case "15000000": $icon = 'spr-common ico-category-bedding';		break;
						case "16000000": $icon = 'spr-common ico-category-gardening';	break;
						case "17000000": $icon = 'spr-common ico-category-living';		break;
						default: $icon = '';
					} ?>
					<li class="category-menu-item">
						<a href="/category/main?cate_cd=<?=$menu['arr_menu1_cd'][$a]?>" class="category-menu-link">
							<span class="<?=$icon?>"></span><?=$menu['arr_menu1_nm'][$a]?>
						</a>
					</li>
				<? }?>

			<!--		<li class="category-menu-item">
						<a href="#" class="category-menu-link">
							<span class="spr-common ico-category-furniture"></span>가구
						</a>
					</li>
					<li class="category-menu-item">
						<a href="#" class="category-menu-link">
							<span class="spr-common ico-category-interior"></span>인테리어
						</a>
					</li>
					<li class="category-menu-item">
						<a href="#" class="category-menu-link">
							<span class="spr-common ico-category-diy"></span>DIY
						</a>
					</li>
					<li class="category-menu-item">
						<a href="#" class="category-menu-link">
							<span class="spr-common ico-category-light"></span>조명&#47;전기
						</a>
					</li>
					<li class="category-menu-item">
						<a href="#" class="category-menu-link">
							<span class="spr-common ico-category-gardening"></span>가드닝
						</a>
					</li>
					<li class="category-menu-item">
						<a href="#" class="category-menu-link">
							<span class="spr-common ico-category-kitchen"></span>주방
						</a>
					</li>
					<li class="category-menu-item">
						<a href="#" class="category-menu-link">
							<span class="spr-common ico-category-bedding"></span>침구
						</a>
					</li>
					<li class="category-menu-item">
						<a href="#" class="category-menu-link">
							<span class="spr-common ico-category-bathroom"></span>욕실
						</a>
					</li>
					<li class="category-menu-item">
						<a href="#" class="category-menu-link">
							<span class="spr-common ico-category-living"></span>생활&#47;수납
						</a>
					</li>	-->
				</ul>
				<!-- // category menu -->

				<!-- the choice wrap 영역 -->
				<div class="the-choice-wrap">
					<h3 class="prd-list-title">THE CHOICE</h3>

					<div class="prd-list-wrap">
						<ul class="prd-list">
							<?foreach($etah_choice as $erow){?>
							<li class="prd-item">
								<a href="/goods/detail/<?=$erow['GOODS_CD']?>" class="prd-link">
									<img src="<?=$erow['IMG_URL']?>" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="/goods/detail/<?=$erow['GOODS_CD']?>" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand"><?=$erow['BRAND_NM']?></dt>
											<dd class="prd-item-tit"><?=$erow['NAME']?></dd>
											<dd class="prd-item-price">
												<?if($erow['COUPON_CD_S'] || $erow['COUPON_CD_G']){
													$price = $erow['SELLING_PRICE'] - ($erow['RATE_PRICE_S'] + $erow['RATE_PRICE_G']) - ($erow['AMT_PRICE_S'] + $erow['AMT_PRICE_G']);
													echo number_format($price);

													/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
													$sale_percent = (($erow['SELLING_PRICE'] - $price)/$erow['SELLING_PRICE']*100);
													$sale_percent = strval($sale_percent);
													$sale_percent_array = explode('.',$sale_percent);
													$sale_percent_string = $sale_percent_array[0];
												?>
												<del class="del-price"><?=number_format($erow['SELLING_PRICE'])?></del>
												<!--<span class="dc-rate">(<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)
												</span>-->
												<span class="dc-rate">(<?=floor((($erow['SELLING_PRICE']-$price)/$erow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)
												</span>
												<? } else {
													echo number_format($erow['SELLING_PRICE']);
												}
												?>
											</dd>
										</dl>
										<ul class="prd-label-list">
										<? if(($erow['PATTERN_TYPE_CD'] == 'FREE') || ( $erow['DELI_LIMIT'] > 0 && $price > $erow['DELI_LIMIT'])){	?>
											<li class="prd-label-item">무료배송</li>
										<? }?>
										<? if($erow['GOODS_MILEAGE_SAVE_RATE'] > 0){	?>
											<li class="prd-label-item">마일리지</li>
										<? }?>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="javaScript:jsGoodsAction('W','','<?=$erow['GOODS_CD']?>','','');" class="prd-bookmark-link <?=@$erow['INTEREST_GOODS_NO']?'active':''?>"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
										<!-- 활성화시 클래스 active 추가 -->
										<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open" onClick="javaScript:openShareLayer('G', '<?=$erow['GOODS_CD']?>', '<?=$erow['IMG_URL']?>', '<?=$erow['GOODS_NM']?>');"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<? }?>
			<!--				<li class="prd-item">
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
											<li class="prd-label-item">무료배송</li>
											<li class="prd-label-item">마일리지</li>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
			-->
										<!-- 활성화시 클래스 active 추가 -->
			<!--							<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item3.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
			-->
										<!-- 활성화시 클래스 active 추가 -->
			<!--							<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item4.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
										<ul class="prd-label-list">
											<li class="prd-label-item">마일리지</li>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
			-->
										<!-- 활성화시 클래스 active 추가 -->
			<!--							<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item5.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
			-->
										<!-- 활성화시 클래스 active 추가 -->
			<!--							<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item6.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
			-->
										<!-- 활성화시 클래스 active 추가 -->
			<!--							<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item7.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
										<ul class="prd-label-list">
											<li class="prd-label-item">무료배송</li>
											<li class="prd-label-item">마일리지</li>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
			-->
										<!-- 활성화시 클래스 active 추가 -->
			<!--							<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item8.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
										<ul class="prd-label-list">
											<li class="prd-label-item">무료배송</li>
											<li class="prd-label-item">마일리지</li>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
			-->
										<!-- 활성화시 클래스 active 추가 -->
			<!--							<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>	-->
						</ul>
						<a href="/goods/the_choice" class="more">more</a>
					</div>
				</div>
				<!-- //the choice wrap 영역-->

				<!-- BRAND RECOMMENDATION // -->
				<?if($brand_recommendation[0]['DISP_HTML']){	?>
				<div class="brand-recommendation">
					<h3 class="prd-list-title">BRAND RECOMMENDATION</h3>
					<ul class="brand-recommendation-list">
					<?foreach($brand_recommendation as $brow){?>
						<?=$brow['DISP_HTML']?>
					<!--	<li class="brand-recommendation-item">
							<a href="#" class="brand-recommendation-link">
								<img src="../assets/images/data/data_brand_recommendation_01.jpg" alt="">
								<p class="brand-recommendation-text">
									세라믹 조명의 모든 것<br>
									<span class="small-text">감각적인 인테리어 조명, LAMPDA</span>
								</p>
							</a>
						</li>
						<li class="brand-recommendation-item brand-recommendation-item--right">
							<a href="#" class="brand-recommendation-link">
								<img src="../assets/images/data/data_brand_recommendation_02.jpg" alt="">
								<p class="brand-recommendation-text">
									빛을 디자인하다<br>
									<span class="small-text">모던&amp;스타일리쉬 램프, 바이빔</span>
								</p>
							</a>
						</li>
						<li class="brand-recommendation-item">
							<a href="#" class="brand-recommendation-link">
								<img src="../assets/images/data/data_brand_recommendation_03.jpg" alt="">
								<p class="brand-recommendation-text">
									독일 디자인, Koziol<br>
									<span class="small-text">당신의 소중한 반지를 위해</span>
								</p>
							</a>
						</li>
						<li class="brand-recommendation-item brand-recommendation-item--right">
							<a href="#" class="brand-recommendation-link">
								<img src="../assets/images/data/data_brand_recommendation_04.jpg" alt="">
								<p class="brand-recommendation-text">
									레뇨마지아 디자인 시계<br>
									<span class="small-text">즐겁고 유쾌한 이태리 명품 브랜드</span>
								</p>
							</a>
						</li>	-->
						<?}?>
					</ul>
				</div>
				<? }?>
				<!-- // BRAND RECOMMENDATION -->

				<!-- BEST ITEM 영역 -->
				<div class="best-item">
					<h3 class="prd-list-title">BEST ITEM</h3>
					<div class="prd-list-wrap">
						<ul class="prd-list">
							<?foreach($best_goods as $grow){?>
							<li class="prd-item">
								<a href="/goods/detail/<?=$grow['GOODS_CD']?>" class="prd-link">
									<img src="<?=$grow['IMG_URL']?>" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="/goods/detail/<?=$grow['GOODS_CD']?>" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand"><?=$grow['BRAND_NM']?></dt>
											<dd class="prd-item-tit"><?=$grow['GOODS_NM']?></dd>
											<dd class="prd-item-price">
												<?	if($grow['COUPON_CD_S'] || $grow['COUPON_CD_G']){
													$price = $grow['SELLING_PRICE'] - ($grow['RATE_PRICE_S'] + $grow['RATE_PRICE_G']) - ($grow['AMT_PRICE_S'] + $grow['AMT_PRICE_G']);
													echo number_format($price);

													/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
													$sale_percent = (($grow['SELLING_PRICE'] - $price)/$grow['SELLING_PRICE']*100);
													$sale_percent = strval($sale_percent);
													$sale_percent_array = explode('.',$sale_percent);
													$sale_percent_string = $sale_percent_array[0];
												?>
												<del class="del-price"><?=number_format($grow['SELLING_PRICE'])?></del>
												<!--<span class="dc-rate">(<?=floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)
												</span>-->
												<span class="dc-rate">(<?=floor((($grow['SELLING_PRICE']-$price)/$grow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)
												</span>
												<?}else{
														echo number_format($grow['SELLING_PRICE']);
													}
													?>
											</dd>
										</dl>
										<ul class="prd-label-list">
										<? if(($grow['PATTERN_TYPE_CD'] == 'FREE') || ( $grow['DELI_LIMIT'] > 0 && $price > $grow['DELI_LIMIT'])){	?>
											<li class="prd-label-item">무료배송</li>
										<? }?>
										<? if($grow['GOODS_MILEAGE_SAVE_RATE'] > 0){	?>
											<li class="prd-label-item">마일리지</li>
										<? }?>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="javaScript:jsGoodsAction('W','','<?=$grow['GOODS_CD']?>','','');" class="prd-bookmark-link <?=@$grow['INTEREST_GOODS_NO']?'active':''?>"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
										<!-- 활성화시 클래스 active 추가 -->
										<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open" onClick="javaScript:openShareLayer('G', '<?=$grow['GOODS_CD']?>', '<?=$grow['IMG_URL']?>', '<?=$grow['GOODS_NM']?>');"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<? }?>
				<!--			<li class="prd-item">
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
											<li class="prd-label-item">무료배송</li>
											<li class="prd-label-item">마일리지</li>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
				-->
										<!-- 활성화시 클래스 active 추가 -->
				<!--						<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item3.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
				-->
										<!-- 활성화시 클래스 active 추가 -->
				<!--						<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item4.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
										<ul class="prd-label-list">
											<li class="prd-label-item">마일리지</li>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
				-->
										<!-- 활성화시 클래스 active 추가 -->
				<!--						<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item5.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
				-->
										<!-- 활성화시 클래스 active 추가 -->
				<!--						<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item6.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
				-->
										<!-- 활성화시 클래스 active 추가 -->
				<!--						<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item7.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
										<ul class="prd-label-list">
											<li class="prd-label-item">무료배송</li>
											<li class="prd-label-item">마일리지</li>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
					-->
										<!-- 활성화시 클래스 active 추가 -->
					<!--					<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>
							<li class="prd-item">
								<a href="#" class="prd-link">
									<img src="../assets/images/data/prd_item8.jpg" alt="버플리 원목 2700 거실장 세트">
								</a>
								<div class="prd-info-wrap">
									<a href="#" class="prd-link">
										<dl class="prd-info">
											<dt class="prd-item-brand">해오름가구</dt>
											<dd class="prd-item-tit">버플리 원목 2700 거실장 세트</dd>
											<dd class="prd-item-price">
												436,500
												<del class="del-price">310,000</del>
												<span class="dc-rate">(9%<span class="spr-common ico-arrow-down"></span>)</span>
											</dd>
										</dl>
										<ul class="prd-label-list">
											<li class="prd-label-item">무료배송</li>
											<li class="prd-label-item">마일리지</li>
										</ul>
									</a>
									<ul class="prd-bookmark">
										<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
					-->
										<!-- 활성화시 클래스 active 추가 -->
					<!--					<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
									</ul>
								</div>
							</li>	-->
						</ul>
						<a href="/goods/best_item" class="more">more</a>
					</div>
				</div>
				<!-- //best-item 영역-->

				<!-- magazine // -->
				<div class="magazine-wrap prd-list-wrap">
					<h3 class="prd-list-title">MAGAZINE</h3>
					<div class="magazine">
						<ul class="magazine-list">
							<?foreach($magazine as $mrow){	?>
							<li class="magazine-item">
								<a href="<?=$mrow['LINK_URL']?>" class="magazine-link">
									<img src="<?=$mrow['MOB_MAGAZINE_IMG_URL']?>" alt="" onerror="this.src='http://ui.etah.co.kr/assets/images/data/main_magazin_6.jpg'">
									<span class="magazine-text"><?=$mrow['NAME'][0]?></span>
								</a>
							</li>
							<? }?>
				<!--			<li class="magazine-item">
								<a href="#" class="magazine-link">
									<img src="../assets/images/data/data_magazine_350x350_02.jpg" alt="">
									<span class="magazine-text">#집의 분위기를 좌우하는 램프</span>
								</a>
							</li>
							<li class="magazine-item">
								<a href="#" class="magazine-link">
									<img src="../assets/images/data/data_magazine_350x350_01.jpg" alt="">
									<span class="magazine-text">#집의 분위기를 좌우하는 램프</span>
								</a>
							</li>
							<li class="magazine-item">
								<a href="#" class="magazine-link">
									<img src="../assets/images/data/data_magazine_350x350_02.jpg" alt="">
									<span class="magazine-text">#집의 분위기를 좌우하는 램프</span>
								</a>
							</li>
							<li class="magazine-item">
								<a href="#" class="magazine-link">
									<img src="../assets/images/data/data_magazine_350x350_01.jpg" alt="">
									<span class="magazine-text">#집의 분위기를 좌우하는 램프</span>
								</a>
							</li>
							<li class="magazine-item">
								<a href="#" class="magazine-link">
									<img src="../assets/images/data/data_magazine_350x350_02.jpg" alt="">
									<span class="magazine-text">#집의 분위기를 좌우하는 램프</span>
								</a>
							</li>
							<li class="magazine-item">
								<a href="#" class="magazine-link">
									<img src="../assets/images/data/data_magazine_350x350_01.jpg" alt="">
									<span class="magazine-text">#집의 분위기를 좌우하는 램프</span>
								</a>
							</li>
							<li class="magazine-item">
								<a href="#" class="magazine-link">
									<img src="../assets/images/data/data_magazine_350x350_02.jpg" alt="">
									<span class="magazine-text">#집의 분위기를 좌우하는 램프</span>
								</a>
							</li>	-->
						</ul>
					</div>
					<a href="/magazine" class="more">more</a>
				</div>
				<!-- // magazine -->

			<!-- 공유하기 레이어 // -->
			<div id="share_sns"></div>
			<!-- // 공유하기 레이어 -->

			<!-- 2018-01-29 김지혜 레이어팝업 수정 -->
			<!-- 메인프로모션 레이어 // -->
			<div class="layer-wrap layer-main01 layer-wrap--view" id="layer_main_pop01" style="visibility:hidden">
				<div class="layer-inner">
					<div class="layer-content">
						<!-- <div class="banner01">
							<img src="/assets/images/data/180116_main_popup_01.jpg" alt="">
							<a href="/mywiz" class="btn-link01"><img src="/assets/images/data/180116_btn_popup01.png" alt=""></a>
						</div>
						<div class="banner01">
							<img src="/assets/images/data/180117_main_popup_02.jpg" alt="">
							<a href="/goods/event/66" class="btn-link01"><img src="/assets/images/data/180116_btn_popup02.png" alt=""></a>
						</div>
					</div> -->
					<a href="/mywiz"><img src="../assets/images/data/180124_coupon_banner_2.jpg" style="width: 100%;" alt=""></a>
					<!-- <a href="/goods/detail/1247573"><img src="../assets/images/data/180125_main_popup_2.jpg" style="width: 100%;" alt=""></a> -->
					<a href="/goods/event/66"><img src="../assets/images/data/main_popup_2.jpg" style="width: 100%;" alt=""></a>
					<div class="bottom-wrap">
						<div class="checkbox_area">
							<input type="checkbox" id="formMainClose" class="checkbox"> <label for="formMainClose" class="checkbox-label">오늘 하루 열지 않음</label>
						</div>
						<a href="#" data-close="layer-close" id="full_layer_close" class="btn_close">닫기 X</a>
					</div>
				</div>
			</div>
			<!-- // 메인프로모션 레이어 -->

<!--			<div class="layer-wrap layer-main01 layer-wrap--view" id="layer_main_pop01" style="visibility:hidden">
				<div class="layer-inner">
					<div class="layer-content">
						<img src="/assets/images/data/main_popup_01.jpg" alt="" usemap="#001" style="width: 100%">
					</div>
					<div class="bottom-wrap">
						<div class="checkbox_area">
							<input type="checkbox" id="formMainClose" class="checkbox"> <label for="formMainClose" class="checkbox-label">오늘 하루 열지 않음</label>
						</div>
						<a href="#" data-close="layer-close" id="full_layer_close" class="btn_close">닫기 X</a>
					</div>
				</div>
			</div>

			<map name="001">
				<area shape="rect" coords="0,540,466,598" href="/mywiz" target="_blank">
			</map>
-->
			<script type="text/javascript">

			//========================================
			//오늘 하루 창 닫기
			//========================================
			$(document).ready(function() {
				//alert($.cookie('layer_main_pop01'));
				if($.cookie('layer_main_pop01') != 'hidden'){
					$('#layer_main_pop01').show();
					$('#layer_main_pop01').css('visibility','visible');
					//console.log(true);
				}else{
					$('#layer_main_pop01').hide();
				}

				$('#full_layer_close').click(function() {		 
					var chkd = $("#formMainClose").is(":checked");
					if(chkd){
						$.cookie('layer_main_pop01', 'hidden', {expires : 1});
					}
					$('#layer_main_pop01').hide();
				}); 
			});
			</script>