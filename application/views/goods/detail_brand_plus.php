<?foreach($brand_goods as $brow){?>
    <li class="prd-item" name="row[]">
        <div class="pic">
            <a href="/goods/detail/<?=$brow['GOODS_CD']?>">
                <div class="item auto-img">
                    <div class="img">
                        <img src="<?=$brow['IMG_URL']?>" alt="">
                    </div>
                </div>
                <div class="tag-wrap">
                    <?if(!empty($brow['DEAL'])){?>
                        <span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>
                    <?}?>
                    <?if($brow['CLASS_GUBUN']=='C'){?>
                        <span class="circle-tag class"><em class="blk">공방<br>클래스</em></span>
                    <?}?>
                    <?if($brow['CLASS_GUBUN']=='G'){?>
                        <span class="circle-tag class"><em class="blk">공방<br>제작상품</em></span>
                    <?}?>
                </div>
            </a>
        </div>
        <div class="prd-info-wrap">
            <a href="/goods/detail/<?=$brow['GOODS_CD']?>">
                <dl class="prd-info">
                    <dt class="prd-item-brand"><?=$brow['BRAND_NM']?></dt>
                    <dd class="prd-item-tit"><?=$brow['GOODS_NM']?></dd>
                    <dd class="prd-item-price">
                        <?if($brow['COUPON_CD']){
                            $price = $brow['SELLING_PRICE'] - ($brow['RATE_PRICE']) - ($brow['AMT_PRICE']);
                            echo number_format($price);
                            $sale_percent = (($brow['SELLING_PRICE'] - $price)/$brow['SELLING_PRICE']*100);
                            $sale_percent = strval($sale_percent);
                            $sale_percent_array = explode('.',$sale_percent);
                            $sale_percent_string = $sale_percent_array[0];
                            ?><span class="won"> 원</span><br>
                            <del class="del-price"><?=number_format($brow['SELLING_PRICE'])?>원</del>
                            <span class="dc-rate">(<?=floor((($brow['SELLING_PRICE']-$price)/$brow['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)
												</span>
                        <? } else {
                            echo number_format($price = $brow['SELLING_PRICE']);
                            ?><span class="won"> 원</span><?
                        }
                        ?>
                    </dd>
                </dl>
                <ul class="prd-label-list">
                    <? if($brow['COUPON_CD']){?>
                        <li class="prd-label-item">쿠폰할인</li>
                    <?}?>
                    <? if(($brow['PATTERN_TYPE_CD'] == 'FREE') || ( $brow['DELI_LIMIT'] > 0 && $price > $brow['DELI_LIMIT'])) {?>
                        <li class="prd-label-item free_shipping">무료배송</li>
                    <?} if($brow['GOODS_MILEAGE_SAVE_RATE'] > 0){?>
                        <li class="prd-label-item">마일리지</li>
                    <?}?>
                </ul>
            </a>
        </div>
    </li>
<?}?>