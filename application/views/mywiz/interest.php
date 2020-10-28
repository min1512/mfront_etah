			<link rel="stylesheet" href="/assets/css/mypage.css?ver=1.0">

			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">나의 관심목록</h2>
				<h3 class="info-title info-title--sub">관심상품</h3>

				<div class="mypage-favorite-all-check position-area">
					<input type="checkbox" id="mypageCheckAll" class="checkbox" onClick="javascript:jsChkAll(this.checked);">
					<label for="mypageCheckAll" class="checkbox-label">전체선택 <span id="chkNum" class="num">(0/<?=count($wish_list)?>)</span></label>
					<a href="javascript:;" onClick="javaScript:chkInterestDelete();" class="btn-white position-right btn-select-delete">선택삭제</a>
				</div>


				<? foreach($wish_list as $key=>$wrow){
				?>
				<div class="mypage-favorite-prd">
					<div class="mypage-favorite-prd-check">
						<input type="checkbox" id="mypageCheck<?=$key?>" name="chkGoods[]" class="checkbox" value="<?=$wrow['GOODS_CD']?>" onClick="javascript:jsChkNum();">
						<label for="mypageCheck<?=$key?>" class="checkbox-label"></label>
						<a href="/goods/detail/<?=$wrow['GOODS_CD']?>" class="media-area mypage-favorite-media">
							<span class="media-area-img"><img src="<?=$wrow['IMG_URL']?>" alt=""></span>
							<span class="media-area-info">
								<span class="mypage-favorite-prd-name">
									<?=$wrow['GOODS_NM']?><br/>
								</span>
								<span class="mypage-favorite-prd-price">
									판매가 <strong><?=number_format($wrow['SELLING_PRICE'])?></strong><span class="won">원</span>
									<span class="tip">(배송비
										<?
										if( $wrow['DELI_LIMIT'] >= 0 || $wrow['DELI_LIMIT']>$wrow['SELLING_PRICE'] ){
											echo number_format($wrow['DELI_COST'])."원";
										}else{
											echo "무료배송";
										}
										?>)</span>
								</span>
							</span>
						</a>
					</div>
					<ul class="mypage-favorite-prd-btn">
						<li class="mypage-favorite-prd-btn-item"><a href="#layerSnsShare" class="btn-gray" data-layer="layer-open" onClick="javaScript:openShareLayer('G', '<?=$wrow['GOODS_CD']?>', '<?=$wrow['IMG_URL']?>', '<?=$wrow['GOODS_NM']?>');">공유하기</a></li>
						<li class="mypage-favorite-prd-btn-item"><a href="javaScript:interestDelete(<?=$key?>);" class="btn-white">삭제</a></li>
					</ul>
				</div>
				<?}?>
<!--
				<div class="mypage-favorite-prd">
					<div class="mypage-favorite-prd-check">
						<input type="checkbox" id="mypageCheck2" class="checkbox">
						<label for="mypageCheck2" class="checkbox-label">
							<span class="media-area mypage-favorite-media">
								<span class="media-area-img"><img src="../assets/images/data/data_100x100.jpg" alt=""></span>
								<span class="media-area-info">
									<span class="mypage-favorite-prd-name">
										[해오름가구] 버플리 원목 레시아 렌지대 [해오름가구] 버플리 원목 레시아 렌지대
									</span>
									<span class="mypage-favorite-prd-price">
										판매가 <strong>1,315,000</strong><span class="won">원</span>
										<span class="tip">(배송비 2,500원)</span>
									</span>
								</span>
							</span>
						<label>
					</div>
					<ul class="mypage-favorite-prd-btn">
						<li class="mypage-favorite-prd-btn-item"><a href="#layerSnsShare" class="btn-gray" data-layer="layer-open">공유하기</a></li>
						<li class="mypage-favorite-prd-btn-item"><a href="#" class="btn-white">삭제</a></li>
					</ul>
				</div>
-->
<br/>
				<!-- 페이징 //-->
				<?=$pagination?>
				<!-- // 페이징 -->

				<!-- 공유하기 레이어 // -->
				<div id="share_sns"></div>
				<!-- // 공유하기 레이어 -->

				<!-- 공유하기 레이어 // -->
				<?// if($wish_list){?>
				<?// foreach($wish_list as $wrow){?>
		<!--		<div class="layer-wrap layer-sns-share" id="layerSnsShare<?=$wrow['GOODS_CD']?>">
					<div class="layer-inner">
						<h1 class="layer-title">공유하기</h1>
						<div class="layer-content">
							<ul class="layer-sns-list">
								<li class="layer-sns-item">
									<a href="javaScript:jsGoodsAction('S','K','<?=$wrow['GOODS_CD']?>','','<?=$wrow['GOODS_NM']?>');" class="layer-sns-link"><span class="spr-layer layer-sns-kakaotalk"></span>카카오톡</a>
								</li>
								<li class="layer-sns-item">
									<a href="javaScript:jsGoodsAction('S','F','<?=$wrow['GOODS_CD']?>','<?=$wrow['IMG_URL']?>','<?=$wrow['GOODS_NM']?>');" class="layer-sns-link"><span class="spr-layer layer-sns-facebook"></span>페이스북</a>
								</li>
								<li class="layer-sns-item">
									<a href="#" class="layer-sns-link"><span class="spr-layer layer-sns-instagram"></span>인스타그램</a>
								</li>
							</ul>
							<a href="javaScript:jsUrlCopy('devm.etah.co.kr/goods/detail/<?=$wrow['GOODS_CD']?>');" class="btn-layer-url-copy">URL 복사하기</a>
						</div>
						<a href="#" class="btn-layer-close" data-close="layer-close"><span class="hide">닫기</span></a>
					</div>
				</div>		-->
				<?// }}?>
				<!-- // 공유하기 레이어 -->


			<script type="text/javaScript">

			//====================================
			// 체크박스 전체선택
			//====================================
			function jsChkAll(pBool){
				for (var i=0; i<document.getElementsByName("chkGoods[]").length; i++){
					document.getElementsByName("chkGoods[]")[i].checked = pBool;
				}
				jsChkNum();
			}

			//====================================
			// 체크박스 선택시
			//====================================
			function jsChkNum(){
				var num = 0;
				var totalCnt = <?=count($wish_list)?>;
				for (var i=0; i<document.getElementsByName("chkGoods[]").length; i++){
					if(document.getElementsByName("chkGoods[]")[i].checked){
						num += 1;
					}
				}
				document.getElementById("chkNum").innerHTML = '('+num+'/'+totalCnt+')';
			}

			//====================================
			// 삭제
			//====================================
			function interestDelete(idx){
				var goods_cd = document.getElementsByName("chkGoods[]")[idx].value;
				if(confirm("해당 상품을 관심상품에서 삭제하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/delete_interest',
						dataType: 'json',
						data: { goods_cd : goods_cd },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								alert("삭제되었습니다.");
								document.location.href = "/mywiz/interest/";
							}
							else alert(res.message);
						}
					});
				}
			}

			//====================================
			// 선택삭제
			//====================================
			function chkInterestDelete(){
				var goodsArr = new Array();
				$("input:checkbox[name='chkGoods[]']:checked").each(function() {
					goodsArr.push($(this).val());     // 체크된 것만 값을 뽑아서 배열에 push
				});

				if(goodsArr.length == 0){
					alert("삭제할 상품을 선택해주세요.");
					return false;
				}

				if(confirm("선택한 상품들을 관심상품에서 삭제하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/chk_delete_interest',
						dataType: 'json',
						data: { goodsArr : goodsArr },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								alert("삭제되었습니다.");
								document.location.href = "/mywiz/interest/";
							}
							else alert(res.message);
						}
					});
				}
			}
			</script>