<h3 class="common-layer-title">구매가이드</h3>

<?
		$GOODS_GUIDE = 'N';
		$CATEGORY_GUIDE = 'N';
		$BRAND_GUIDE = 'N';

		foreach($goods_buy_guide as $row){
			if($row['gubun'] == 'GOODS_GUIDE'){
				$GOODS_GUIDE = 'Y';
			}
			if($row['gubun'] == 'CATEGORY_GUIDE'){
				$CATEGORY_GUIDE = 'Y';
			}
			if($row['gubun'] == 'BRAND_GUIDE'){
				$BRAND_GUIDE = 'Y';
			}
		}
	if($goods_buy_guide){
		if($GOODS_GUIDE == 'Y'){	?>

		<div class="common-layer-content">
			<h3 class="info-title info-title--sub"><?=$goods_name?></h3>
			<div class="vip-purchase-guide-wrap">
			<? foreach($goods_buy_guide as $row){
				if($row['gubun'] == 'GOODS_GUIDE'){
					if($row['BUY_GUIDE_BLOG_GB_CD'] == 'TEXT'){	?>
				<p class="vip-purchase-guide-txt">
				<?=$row['HEADER_DESC']?>
				</p>
				<?	} else if ($row['BUY_GUIDE_BLOG_GB_CD'] == 'IMG'){	?>
				<div class="vip-purchase-guide-img">
				<img src="<?=$row['HEADER_DESC']?>" alt="">
				</div>
				<? } else {?>
				<?=$row['HEADER_DESC']?>
				<? }?>
				<? }
			}?>
			</div>
		</div>
	<? } ?>

	<? if($CATEGORY_GUIDE == 'Y'){	?>

		<div class="common-layer-content">
			<h3 class="info-title info-title--sub"><?=$category_name?></h3>
			<div class="vip-purchase-guide-wrap">
			<? foreach($goods_buy_guide as $row){
				if($row['gubun'] == 'CATEGORY_GUIDE'){
					if($row['BUY_GUIDE_BLOG_GB_CD'] == 'TEXT'){	?>
				<p class="vip-purchase-guide-txt">
				<?=$row['HEADER_DESC']?>
				</p>
				<?	} else if ($row['BUY_GUIDE_BLOG_GB_CD'] == 'IMG'){	?>
				<div class="vip-purchase-guide-img">
				<img src="<?=$row['HEADER_DESC']?>" alt="">
				</div>
				<? } else {?>
				<?=$row['HEADER_DESC']?>
				<? }?>
				<? }
			}?>
			</div>
		</div>
	<? } ?>

	<? if($BRAND_GUIDE == 'Y'){	?>

		<div class="common-layer-content">
			<h3 class="info-title info-title--sub"><?=$brand_name?></h3>
			<div class="vip-purchase-guide-wrap">
			<? foreach($goods_buy_guide as $row){
				if($row['gubun'] == 'BRAND_GUIDE'){
					if($row['BUY_GUIDE_BLOG_GB_CD'] == 'TEXT'){	?>
				<p class="vip-purchase-guide-txt">
				<?=$row['HEADER_DESC']?>
				</p>
				<?	} else if ($row['BUY_GUIDE_BLOG_GB_CD'] == 'IMG'){	?>
				<div class="vip-purchase-guide-img">
				<img src="<?=$row['HEADER_DESC']?>" alt="">
				</div>
				<? } else {?>
				<?=$row['HEADER_DESC']?>
				<? }?>
				<? }
			}?>
			</div>
		</div>
	<? } ?>
	<? }?>

			<ul class="common-btn-box">
				<li class="common-btn-item"><a href="#" class="btn-gray btn-gray--big" data-close="bottom-layer-close2">상세페이지로 돌아가기</a></li>
			</ul>
			<a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>

