				<!-- Q&A수정하기 레이어 // -->
				<div class="common-layer-wrap layer-qna-modify" id="layerQnaModify">
					<!-- common-layer-wrap--view 추가 -->
					<h3 class="common-layer-title">Q&#38;A 수정하기</h3>

					<!-- common-layer-content // -->
					<div class="common-layer-content">

						<div class="media-area prd-order-media">
							<span class="media-area-img prd-order-media-img"><img src="<?=$qna['IMG_URL']?>" alt=""></span>
							<span class="media-area-info prd-order-media-info">
							<span class="prd-order-media-info-brand">[<?=$qna['BRAND_NM']?>]</span>
							<span class="prd-order-media-info-name"><?=$qna['GOODS_NM']?></span>
							</span>
						</div>

						<div class="form-line form-line--wide">
							<div class="form-line-info">
								<label><input type="text" class="input-text" value="<?=$qna['TITLE']?>" name="title"></label>
							</div>
						</div>
						<div class="form-line form-line--wide">
							<div class="form-line-info">
								<label>
								    <textarea type="text" class="input-text input-text--textarea" name="content"><?=str_replace("<br />","\n", $qna['CONTENTS'])?></textarea>
								</label>
							</div>
						</div>
						<ul class="common-btn-box common-btn-box--layer">
							<li class="common-btn-item"><a href="javaScript:;" class="btn-gray-link" onClick="javaScript:document.getElementById('layerQnaModify').className = 'common-layer-wrap layer-qna-modify';">수정취소</a></li>
							<li class="common-btn-item"><a href="javaScript:;" class="btn-black-link" onClick="javaScript:modify_goods_qna(<?=$qna['CS_CONTENTS_REPLY_NO']?>);">수정하기</a></li>
						</ul>
				</div>
				<!-- // common-layer-content -->

				<a href="javaScript:;" class="btn-layer-close" onClick="javaScript:document.getElementById('layerQnaModify').className = 'common-layer-wrap layer-qna-modify';"><span class="hide">닫기</span></a>
			</div>
			<!-- // Q&A수정하기 레이어 -->

