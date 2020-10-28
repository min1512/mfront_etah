				<link rel="stylesheet" href="/assets/css/display.css?ver=1.0">

				<div class="content">
				<h3 class="info-title info-title--sub">베스트 100 <?=$bar_deal?></h3>

                <!-- 대분류 // -->
                <div class="filter-list">
                    <div class="filter-inner">
                        <div class="filter-item filter-category" style="width: 100%;">
                            <a href="#filterCategoryBtn" class="filter-btn" data-ui="filter-btn"><?=$CATE_NM?></a>
                            <ul class="filter-layer" id="filterCategoryBtn" style="display: none">
                                <li class="filter-layer-item"><a href="/goods/best_item" class="filter-layer-link"><?if($CATE_CD==''){?><strong class="all"><?}?>전체<?if($CATE_CD==''){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=10000000" class="filter-layer-link"><?if($CATE_CD=='10000000'){?><strong class="all"><?}?>가구<?if($CATE_CD=='10000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=11000000" class="filter-layer-link"><?if($CATE_CD=='11000000'){?><strong class="all"><?}?>인테리어소품<?if($CATE_CD=='11000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=14000000" class="filter-layer-link"><?if($CATE_CD=='14000000'){?><strong class="all"><?}?>조명<?if($CATE_CD=='14000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=19000000" class="filter-layer-link"><?if($CATE_CD=='19000000'){?><strong class="all"><?}?>주방<?if($CATE_CD=='19000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=22000000" class="filter-layer-link"><?if($CATE_CD=='22000000'){?><strong class="all"><?}?>식품<?if($CATE_CD=='22000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=21000000" class="filter-layer-link"><?if($CATE_CD=='21000000'){?><strong class="all"><?}?>디지털/가전<?if($CATE_CD=='21000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=17000000" class="filter-layer-link"><?if($CATE_CD=='17000000'){?><strong class="all"><?}?>생활/욕실<?if($CATE_CD=='17000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=15000000" class="filter-layer-link"><?if($CATE_CD=='15000000'){?><strong class="all"><?}?>침구<?if($CATE_CD=='15000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=23000000" class="filter-layer-link"><?if($CATE_CD=='23000000'){?><strong class="all"><?}?>뷰티<?if($CATE_CD=='23000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=13000000" class="filter-layer-link"><?if($CATE_CD=='13000000'){?><strong class="all"><?}?>DIY<?if($CATE_CD=='13000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=16000000" class="filter-layer-link"><?if($CATE_CD=='16000000'){?><strong class="all"><?}?>가드닝<?if($CATE_CD=='16000000'){?></strong><?}?></a></li>
                                <li class="filter-layer-item"><a href="/goods/best_item?C=24000000" class="filter-layer-link"><?if($CATE_CD=='24000000'){?><strong class="all"><?}?>에타홈클래스<?if($CATE_CD=='24000000'){?></strong><?}?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- // 대분류 -->

				<!-- 상품리스트// -->
				<div class="prd-list-wrap">
					<ul class="prd-list prd-list--modify">
						<?
						$idx = 1;
						foreach($goods as $row){?>
						<li class="prd-item">
                            <div class="pic">
                                <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                    <div class="item auto-img">
                                        <div class="img">
                                            <img src="<?=$row['IMG_URL']?>" alt="">
                                        </div>
                                    </div>
                                    <div class="tag-wrap">
                                        <?if(!empty($row['DEAL'])){?><?}?><!-- <span class="circle-tag deal"><em class="blk">에타<br>딜</em></span> -->
                                        <?if($row['CLASS_GUBUN']=='C'){?><!--<span class="circle-tag class"><em class="blk">에타<br>클래스</em></span>--><?}?>
                                        <?if($row['CLASS_GUBUN']=='G'){?><!--<span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span>--><?}?>
                                    </div>
                                </a>
                            </div>
                            <div class="prd-info-wrap">
                                <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                    <dl class="prd-info">
                                        <dt class="prd-item-brand"><?=$row['BRAND_NM']?></dt>
                                        <dd class="prd-item-tit"><?=$row['GOODS_NM']?></dd>
                                        <dd class="prd-item-price">
                                            <? if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                                $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
                                                echo number_format($price);
                                                $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                                $sale_percent = strval($sale_percent);
                                                $sale_percent_array = explode('.',$sale_percent);
                                                $sale_percent_string = $sale_percent_array[0];
                                                ?>
                                                <span class="won">원</span><br>
                                                <del class="del-price"><?=number_format($row['SELLING_PRICE'])?></del>
                                                <!--<span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100)?>%<span class="spr-common ico-arrow-down"></span>)</span>-->
                                                <span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)</span>
                                            <?} else {
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
                                            <li class="prd-label-item free_shipping">무료배송</li>
                                        <?} if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){?>
                                            <li class="prd-label-item">마일리지</li>
                                        <?}?>
                                    </ul>
                                </a>
                            </div>



							<span class="best-num"><?=$idx?></span>
						</li>
						<?
						$idx++;
						}?>
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


			<script>

			//====================================
			// 공유하기 레이어
			//====================================
            function openShareLayer(gubun, code, img, name){

                $.ajax({
                    type: 'POST',
                    url: '/main/layer_share',
                    dataType: 'json',
                    data: { gubun : gubun,
                        code : code,
                        name : name,
                        img	: img},
					error: function(res) {
						alert('Database Error');
					},
					async : false,
					success: function(res) {
						if(res.status == 'ok'){
							$("#share_sns").html(res.share);

						}
						else alert(res.message);
					}
				});

				$('#layerSnsShare').addClass('layer-wrap--view');
				$('#wrap').addClass('layer-open');

			}

			</script>
            <!--GA script-->
            <script>
            //Impression
//            ga('require', 'ecommerce', 'ecommerce.js');
//            <?//foreach ($goods as $grow){?>
//            ga('ecommerce:addImpression', {
//                'id': <?//=$grow['GOODS_CD']?>//,                   // Product details are provided in an impressionFieldObject.
//                'name': "<?//=$grow['GOODS_NM']?>//",
//                'category':<?//=$grow['CATEGORY_CD']?>//,
//                'brand': <?//=$grow['BRAND_NM']?>//',
//                'list': 'Mob_Best_item Results'
//            });
//            <?//}?>
//            ga('ecommerce:send');
//
//            //action
//            function onProductClick(param,param2) {
//                var goods_cd = param;
//                var goods_nm = param2;
//                ga('ecommerce:addProduct', {
//                    'id': goods_cd,
//                    'name': goods_nm
//                });
//                ga('ecommerce:setAction', 'click', {list: 'Mob_Best_item Results'});
//
//                // Send click with an event, then send user to product page.
//                ga('send', 'event', 'UX', 'click', 'Results', {
//                    hitCallback: function() {
//                        //alert(goods_cd + '/' + goods_nm);
//                        document.location = '/goods/detail/'+goods_cd;
//                    }
//                });
//            }
            </script>
            <!--/GA script-->