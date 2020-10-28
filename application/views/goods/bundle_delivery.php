			<link rel="stylesheet" href="/assets/css/display.css?ver=1">
			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">묶음배송 상품</h2>

				<!-- 최근본상품 // -->
				<div class="prd-bundle-delivery">
					<h3 class="prd-bundle-delivery-title">최근 본 상품</h3>
					<a href="/goods/detail/<?=$goods['GOODS_CD']?>" class="media-area">
						<span class="media-area-img"><img src="<?=$goods['IMG_URL']?>" alt=""></span>
						<span class="media-area-info">
							<span class="prd-order-media-info-brand"><?=$goods['GOODS_NM']?></span>
						</span>
					</a>
					<div class="recent-prd-price-box">
						<dl class="recent-prd-price-line">
							<dt class="recent-prd-tlt">가격</dt>
							<dd class="price"><strong class="price-color"><?=number_format($goods['SELLING_PRICE'])?></strong>원</dd>
						</dl>
						<dl class="recent-prd-price-line">
							<dt class="recent-prd-tlt">할인금액</dt>
							<dd class="price"><strong class="price-color"><?=number_format($goods['COUPON_AMT'])?></strong>원</dd>
						</dl>
						<dl class="recent-prd-price-line">
							<dt class="recent-prd-tlt">배송비</dt>
							<dd class="price"><strong class="price-color"><?=number_format($goods['DELI_COST'])?></strong>원</dd>
						</dl>
					</div>
					<ul class="text-list">
						<li class="text-item">최근 보신 상품 및 아래 상품들을 <strong class="price-color"><?=number_format($goods['DELI_LIMIT'])?>원</strong> 이상 장바구니에 담으실 경우 무료배송이 가능합니다.</li>
					</ul>
				</div>
				<!--  //최근본상품 -->

                <!-- top-location -->
                <div class="page-title-box page-title-box--location">
                    <div class="page-title">
                        <ul class="page-title-list">
                            <li class="page-title-item active">상품 <em class="bold_yel">(<?=$total_cnt?>)</em></li> <!-- 퐐성화시 클래스 active추가 -->
                        </ul>
                    </div>
                </div>
                <!-- //top-location -->

                <div class="filter-list">
                    <div class="filter-inner">
                        <div class="filter-item filter-option1">
                            <a href="#filterOptionBtn" class="filter-btn btn-gnb-open ranking-btn" data-ui="filter-btn">
                                <? switch ($order_by) {
                                    case 'A':echo '인기순';break;
                                    case 'B':echo '신상품순';break;
                                    case 'C':echo '낮은가격순';break;
                                    case 'D':echo '높은가격순';break;
                                } ?>
                            </a>
                        </div>

                        <div class="filter-item filter-check">
                            <a href="#filterOptionBtn" class="filter-btn btn-gnb-open" data-ui="filter-btn"><span class="spr-common spr-ico-filter"></span>상세검색</a>
                        </div>
                    </div>
                </div>
                <div class="filter-gnb-list">

                    <aside class="filter-gnb" style="margin-right: -300px;">
                        <form>
                            <p class="filter-gnb-tit">상세검색</p>
                            <button type="button" class="btn-close lg-w pop-close">close</button>
                            <!-- member -->

                            <!-- logined -->
                            <div class="filter-search">
                                <p class="search-result">검색결과 <span><?=$total_cnt?></span>개</p>
                                <input type="reset" class="btn-reset">
                            </div>
                            <!-- logined -->
                            <!-- //member -->

                            <!-- nav -->
                            <nav>

                                <!-- 카테고리 필터 -->
                                <div class="option_button position_area srp_option_area">
                                    <div class="position_left">
                                        <div class="select_wrap select_wrap_cate">
                                            <h4 class="srp-cate-tit srp-cate-tit2">카테고리</h4>
                                            <ul id="srp-cate" class="srp-cate2">
                                                <li><a href="#" onclick="search_goods('C','');" <?=($cate_cd=='')?'class="on"':''?>>전체</a></li>
                                                <?foreach($arr_cate1 as $c1){?>
                                                    <li><a href="#none" <?=($cur_category['CATE_CD1']==$c1['CODE'])?'class="on"':''?>><?=$c1['NAME']?></a>
                                                        <ul>
                                                            <?foreach($arr_cate2 as $c2){
                                                                if($c2['PARENT_CODE'] == $c1['CODE']){?>
                                                                    <li><a href="#none" <?=($cur_category['CATE_CD2']==$c2['CODE'])?'class="on"':''?>><?=$c2['NAME']?></a>
                                                                        <ul>
                                                                            <?foreach($arr_cate3 as $c3){
                                                                                if($c3['PARENT_CODE'] == $c2['CODE']){?>
                                                                                    <li><a href="#none" onclick="search_goods('C','<?=$c3['CODE']?>');" <?=($cur_category['CATE_CD3']==$c3['CODE'])?'class="on"':''?>><?=$c3['NAME']?></a></li>
                                                                                <?}
                                                                            }?>
                                                                        </ul>
                                                                    </li>
                                                                <?}
                                                            }?>
                                                        </ul>
                                                    </li>
                                                <?}?>
                                            </ul>
                                        </div>
                                        <div class="select_wrap select_wrap_cate">
                                            <h4 class="srp-cate-tit srp-cate-tit1">정렬</h4>
                                            <ul id="srp-cate" class="srp-cate1">
                                                <li>
                                                    <a href="#none">
                                                        <label class="common-radio-label" for="ranking1">
                                                            <input type="radio" id="ranking1" class="common-radio-btn" name="order_by" value="A" <?=($order_by=='A')?'checked':''?>>
                                                            <span class="common-radio-text">인기순</span>
                                                        </label>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#none">
                                                        <label class="common-radio-label" for="ranking2">
                                                            <input type="radio" id="ranking2" class="common-radio-btn" name="order_by" value="B" <?=($order_by=='B')?'checked':''?>>
                                                            <span class="common-radio-text">신상품순</span>
                                                        </label>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#none">
                                                        <label class="common-radio-label" for="ranking3">
                                                            <input type="radio" id="ranking3" class="common-radio-btn" name="order_by" value="C" <?=($order_by=='C')?'checked':''?>>
                                                            <span class="common-radio-text">낮은가격순</span>
                                                        </label>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#none">
                                                        <label class="common-radio-label" for="ranking4">
                                                            <input type="radio" id="ranking4" class="common-radio-btn" name="order_by" value="D" <?=($order_by=='D')?'checked':''?>>
                                                            <span class="common-radio-text">높은가격</span>
                                                        </label>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="select_wrap select_wrap_cate">
                                            <h4 class="srp-cate-tit srp-cate-tit4">국가</h4>
                                            <ul id="srp-cate" class="srp-cate4">
                                                <?
                                                $srp_country = explode("|", substr($country,1));

                                                $cnidx = 1;
                                                foreach($arr_country as $key=>$value){?>
                                                    <li class="checkbox_area country">
                                                        <a href="#none">
                                                            <input type="checkbox" class="checkbox" id="CountryCheck<?=$cnidx?>" name="country" value="<?=$key?>" <?=(in_array($key,$srp_country))?'checked':''?>>
                                                            <label class="checkbox_label" for="CountryCheck<?=$cnidx?>"><?=$value['NM']?></label>
                                                        </a>
                                                    </li>
                                                    <?$cnidx++;
                                                }
                                                ?>
                                            </ul>
                                        </div>

                                        <div class="select_wrap select_wrap_cate">
                                            <h4 class="srp-cate-tit srp-cate-tit3">배송</h4>
                                            <ul id="srp-cate" class="srp-cate3">
                                                <li>
                                                    <a href="#none" class="free-deli">
                                                        <label class="common-radio-label" for="free-deli1">
                                                            <input type="radio" id="free-deli1" class="common-radio-btn" name="deliv_type" value="" <?=($deliv_type=='')?'checked':''?>>
                                                            <span class="common-radio-text">전체</span>
                                                        </label>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#none" class="free-deli">
                                                        <label class="common-radio-label" for="free-deli2">
                                                            <input type="radio" id="free-deli2" class="common-radio-btn" name="deliv_type" value="FREE" <?=($deliv_type=='FREE')?'checked':''?>>
                                                            <span class="common-radio-text">무료배송만</span>
                                                        </label>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="select_wrap select_wrap_cate">
                                            <h4 class="srp-cate-tit srp-cate-tit5">가격</h4>
                                            <?
                                            $price_min = min($arr_sellingPrice);
                                            $price_max = max($arr_sellingPrice);

                                            //최소값, 최대값 재설정
                                            if ($price_min < 10000) $price_min = 1000; //1천원

                                            if ($price_max > 300000) $price_min = 100000;    //10만원
                                            if ($price_max > 3000000) $price_min = 1000000;   //100만원

                                            //기준금액단위 설정
                                            if( (($price_max - $price_min) > 3000000) && ($price_min > 1000000) ) {
                                                $limit = 1000000; //100만원
                                            } else if( (($price_max - $price_min) > 300000) && ($price_min > 100000) ){
                                                $limit = 100000; //10만원
                                            } else if( (($price_max - $price_min) < 30000)){
                                                $limit = 5000; //5천원
                                            } else {
                                                $limit = 10000; //1만원
                                            }

                                            $price_min = ceil($price_min / $limit) * $limit;
                                            $price_max = floor($price_max / $limit) * $limit;

                                            $price_range = ($price_max - $price_min) / 3;
                                            $price_range = floor($price_range / $limit) * $limit;
                                            ?>
                                            <ul id="srp-cate" class="srp-cate5">
                                                <li class="checkbox_area country">
                                                    <a href="#none">
                                                        <label class="common-radio-label" for="price0">
                                                            <input type="radio" id="price0" class="common-radio-btn" name="price_limit" value="" <?=($price_limit=='')?'checked':''?>>
                                                            <span class="common-radio-text">전체</span>
                                                        </label>
                                                    </a>
                                                </li>
                                                <li class="checkbox_area country">
                                                    <a href="#none">
                                                        <label class="common-radio-label" for="price1">
                                                            <?$range = '|'.(string)$price_min?>
                                                            <input type="radio" id="price1" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                            <span class="common-radio-text"><?=number_format($price_min)?>원 이하</span>
                                                        </label>
                                                    </a>
                                                </li>
                                                <li class="checkbox_area country">
                                                    <?$range = (string)$price_min.'|'.(string)($price_min+($price_range*1))?>
                                                    <a href="#none">
                                                        <label class="common-radio-label" for="price2">
                                                            <input type="radio" id="price2" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                            <span class="common-radio-text"><?=number_format($price_min)?>원 ~ <?=number_format($price_min+($price_range*1))?>원</span>
                                                        </label>
                                                    </a>
                                                </li>
                                                <li class="checkbox_area country">
                                                    <a href="#none">
                                                        <label class="common-radio-label" for="price3">
                                                            <?$range = (string)$price_min+($price_range*1).'|'.(string)($price_min+($price_range*2))?>
                                                            <input type="radio" id="price3" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                            <span class="common-radio-text"><?=number_format($price_min+($price_range*1))?>원 ~ <?=number_format($price_min+($price_range*2))?>원</span>
                                                        </label>
                                                    </a>
                                                </li>
                                                <li class="checkbox_area country">
                                                    <a href="#none">
                                                        <label class="common-radio-label" for="price4">
                                                            <?$range = (string)($price_min+($price_range*2)).'|'.(string)($price_min+($price_range*3))?>
                                                            <input type="radio" id="price4" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                            <span class="common-radio-text"><?=number_format($price_min+($price_range*2))?>원 ~ <?=number_format($price_min+($price_range*3))?>원</span>
                                                        </label>
                                                    </a>
                                                </li>
                                                <li class="checkbox_area country">
                                                    <a href="#">
                                                        <label class="common-radio-label" for="price5">
                                                            <?$range = (string)($price_min+($price_range*3)).'|'?>
                                                            <input type="radio" id="price5" class="common-radio-btn" name="price_limit" value="<?=$range?>" <?=($price_limit==$range)?'checked':''?>>
                                                            <span class="common-radio-text"><?=number_format($price_min+($price_range*3))?>원 이상</span>
                                                        </label>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- //카테고리 필터 -->

                                <!-- //shoping guide -->
                                <div class="confirm">
                                    <button class="confirm" onclick="search_goods('', ''); return false;">확인</button>
                                </div>
                            </nav>
                            <!-- //nav -->
                        </form>
                    </aside>

                </div>

				<!-- 상품리스트 // -->
				<div class="prd-list-wrap">
					<ul class="prd-list prd-list--modify">
						<? foreach($goodsList as $row){	?>
						<li class="prd-item">
							<a href="/goods/detail/<?=$row['GOODS_CD']?>" class="prd-link">
								<img src="<?=$row['IMG_URL']?>" alt="<?=$row['GOODS_NM']?>">
							</a>
							<div class="prd-info-wrap">
								<a href="/goods/detail/<?=$row['GOODS_CD']?>" class="prd-link">
									<dl class="prd-info">
										<dt class="prd-item-brand"><?=$row['BRAND_NM']?></dt>
										<dd class="prd-item-tit"><?=$row['GOODS_NM']?></dd>
										<dd class="prd-item-price">
											<?
												if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
													//$price = $row['SELLING_PRICE'] - $row['RATE_PRICE'] - $row['AMT_PRICE'];
													$price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
													echo number_format($price);

													/* floor(float(숫자))에서 왜인지 숫자가 정수일경우 1이 깎임...ㅠㅠ 그래서 string으로 변환 2017-04-27*/
													$sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
													$sale_percent = strval($sale_percent);
													$sale_percent_array = explode('.',$sale_percent);
													$sale_percent_string = $sale_percent_array[0];
												?>
											<del class="del-price"><?=number_format($row['SELLING_PRICE'])?></del>
											<!--<span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)
											</span>-->
											<span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)
											</span>
											<?}else{
												echo number_format($price = $row['SELLING_PRICE']);
											}?>
										</dd>
									</dl>
									<ul class="prd-label-list">
									<?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
									?>
									<li class="prd-label-item">쿠폰할인</li>
									<?
									}
									if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])){ ?>
										<li class="prd-label-item free_shipping">무료배송</li>
									<? }
									  if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){ ?>
										<li class="prd-label-item">마일리지</li>
									<? }?>
									</ul>
								</a>
								<ul class="prd-bookmark">
									<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
									<!-- 활성화시 클래스 active 추가 -->
									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open" onClick="javaScript:openShareLayer('G', '<?=$row['GOODS_CD']?>', '<?=$row['IMG_URL']?>', '<?=$row['GOODS_NM']?>');"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
								</ul>
							</div>
						</li>
						<? }?>
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
										<li class="prd-label-item">무료배송</li>
										<li class="prd-label-item">마일리지</li>
									</ul>
								</a>
								<ul class="prd-bookmark">
									<li class="prd-bookmark-item"><a href="#" class="prd-bookmark-link"><span class="ico-heart spr-common"></span><span class="hide">찜하기</span></a></li>
									<!-- 활성화시 클래스 active 추가 -->
<!--									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
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
									<!-- 활성화시 클래스 active 추가 -->
<!--									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
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
									<!-- 활성화시 클래스 active 추가 -->
<!--									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
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
									<!-- 활성화시 클래스 active 추가 -->
<!--									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
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
									<!-- 활성화시 클래스 active 추가 -->
<!--									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
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
									<!-- 활성화시 클래스 active 추가 -->
<!--									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
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
									<!-- 활성화시 클래스 active 추가 -->
<!--									<li class="prd-bookmark-item"><a href="#layerSnsShare" class="prd-bookmark-link" data-layer="layer-open"><span class="ico-share spr-common"></span><span class="hide">공유하기</span></a></li>
								</ul>
							</div>
						</li>	-->
					</ul>
				</div>
				<!-- // 상품리스트 -->

				<!-- 페이징-->
				<?=$pagination?>
				<!-- // 페이징 -->

				<!-- 공유하기 레이어 // -->
				<? // foreach($goodsList as $row){?>
			<!--	<div class="layer-wrap layer-sns-share" id="layerSnsShare<?=$row['GOODS_CD']?>">
					<div class="layer-inner">
						<h1 class="layer-title">공유하기<?=$row['GOODS_CD']?></h1>
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
				<div id="share_sns"></div>
				<?// }?>
				<!-- // 공유하기 레이어 -->



<script src="/assets/js/common.js?ver=2.0"></script>
<script>
    /* lnb */
    (function($) {
        var lnbUI = {
            click: function(target, speed) {
                var _self = this,
                    $target = $(target);
                _self.speed = speed || 300;
                $target.each(function() {
                    if (findChildren($(this))) {
                        return;
                    }
                    $(this).addClass('noDepth');
                });

                function findChildren(obj) {
                    return obj.find('> ul').length > 0;
                }
                $target.on('click', 'a', function(e) {
                    e.stopPropagation();
                    var $this = $(this),
                        $depthTarget = $this.next(),
                        $siblings = $this.parent().siblings();
                    $this.parent('li').find('ul li').removeClass('on');
                    $siblings.removeClass('on');
                    $siblings.find('ul').slideUp(250);
                    if ($depthTarget.css('display') == 'none') {
                        _self.activeOn($this);
                        $depthTarget.slideDown(_self.speed);
                    } else {
                        $depthTarget.slideUp(_self.speed);
                        _self.activeOff($this);
                    }
                })
            },
            activeOff: function($target) {
                $target.parent().removeClass('on');
            },
            activeOn: function($target) {
                $target.parent().addClass('on');
            }
        }; // Call lnbUI
        $(function() {
            lnbUI.click('#srp-cate li', 300)
        });
    }(jQuery));
</script>

<script>
//====================================
// 조건별 검색
//====================================
function search_goods(kind, val)
{
	var limit			= "<?=$limit?>";
	var page			= "<?=$page?>";
    var	deli_policy_no	= "<?=$deli_policy_no?>";
    var goods_code		= "<?=$goods_code?>";

    var cate_gb     = '<?=$cate_gb?>';
    var cate_cd     = '<?=$cate_cd?>';
    var order_by    = '';
    var country     = '';
    var deliv_type  = '';
    var price_limit = '';

    //카테고리
    if(kind='C'){
        cate_cd = val;
    }

    //정렬
    order_by = $('input[name=order_by]:checked').val();

    //국가
    $("input[name=country]:checked").each(function() {
        country += '|'+$(this).val();
    });

    //배송
    deliv_type = $('input[name=deliv_type]:checked').val();

    //가격
    price_limit = $('input[name=price_limit]:checked').val();



	document.location.href = "/goods/bundle_delivery_page/"+page+"?deli_policy_no="+deli_policy_no+"&goods_code="+goods_code+"&page="+page+"&limit="+limit+"&cate_cd="+cate_cd+"&cate_gb="+cate_gb+"&price_limit="+price_limit+"&order_by="+order_by+"&country="+country+"&deliv_type="+deliv_type;

}

</script>