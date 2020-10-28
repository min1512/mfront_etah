	<!-- 공유하기 레이어 // -->
	<?foreach($etah_choice as $row){?>
	<div class="layer-wrap layer-sns-share" id="layerSnsShare<?=$row['GOODS_CD']?>">
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
                <?
                $url = explode('.', base_url());
                $url = $url[1].'.'.$url[2].'.'.$url[3];
                ?>
				<a href="javaScript:jsUrlCopy('<?=$url?>goods/detail/<?=$row['GOODS_CD']?>');" class="btn-layer-url-copy">URL 복사하기</a>
			</div>
			<a href="#" class="btn-layer-close" data-close="layer-close"><span class="hide">닫기</span></a>
		</div>
	</div>
	<? }?>
	<!-- // 공유하기 레이어 -->

	<!-- 공유하기 레이어 // -->
	<?foreach($best_goods as $row){?>
	<div class="layer-wrap layer-sns-share" id="layerSnsShare<?=$row['GOODS_CD']?>">
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

                <?
                    $url = explode('.', base_url());
                    $url = $url[1].'.'.$url[2].'.'.$url[3];
                ?>
				<a href="javaScript:jsUrlCopy('<?=$url?>goods/detail/<?=$row['GOODS_CD']?>');" class="btn-layer-url-copy">URL 복사하기</a>
			</div>
			<a href="#" class="btn-layer-close" data-close="layer-close"><span class="hide">닫기</span></a>
		</div>
	</div>
	<? }?>
	<!-- // 공유하기 레이어 -->
</div>


<script type="text/javaScript">

function jsUrlCopy(url)
{	
//	document.getElementsByName("copy_url").focus();
//	document.getElementsByName("copy_url").select();
//	therange=document.getElementById("copy_url").createTextRange();
//
//	therange.execCommand("Copy");
//	document.getElementById("copy_url").value = url;
//	var doc = f.test_copy.createTextRange();

//	document.getElementById("copy_url").select();

	
//	var test = url.execCommand('copy');

//	if(test) alert(document.getElementById("copy_url").value);

//	alert('URL이 복사 되었습니다..');
//	return;
//	var tempval=eval("document."+theField)
//	tempval.focus()
//	tempval.select()
//	therange=tempval.createTextRange()
//	therange.execCommand("Copy")
	window.clipboardData.setData('Text',url);
}


</script>