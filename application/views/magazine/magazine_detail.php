<link rel="stylesheet" href="/assets/css/vip.css?ver=2.2.8">
<link rel="stylesheet" type="text/css" href="/assets/css/owl.carousel.min.css">

<div class="content <?=($cateGubun==9)?'vip_02':'vip_03'?>">
    <div class="magazine-view-top">
        <div class="magazine-main-img">
            <img src="<?=$detail['MOB_IMG_URL']?>" alt="">
        </div>
        <h3 class="info-title info-title--sub"><?=$detail['CATEGORY_NM']?></h3>
        <div class="status black">
            <a href="javascript:jsLoveAction(<?=$detail['MAGAZINE_NO']?>)" class="like <?echo ($heart=='Y')?'active':''?>" class="like active"><?=$detail['LOVE_CNT']?></a> <!-- 활성화 됐을때 클래스 active 추가 -->
            <a href="#layerSnsShare" class="share" data-layer="layer-open" onClick="javaScript:openShareLayer('M', '<?=$detail['MAGAZINE_NO']?>', '<?=$detail['MOB_IMG_URL']?>', '<?=$detail['TITLE']?>');"><?=$detail['SHARE']?></a>
            <span class="view">조회 <?=$detail['HITS']?></span>
        </div>
    </div>

    <div class="magazine-view">
        <h4 class="magazine-view-title"><?=$detail['TITLE']?></h4>
        <div class="date-created"><?=substr($detail['REG_DT'],0,10)?></div>
        <div class="magazine-view-cont">
            <?foreach($magazine_contents as $row){
                if($row['MAGAZINE_CONTENTS_GB_CD'] == 'IMG'){	?>
                    <div class="magazine-view-img"><img src="<?=$row['HEADER_DESC']?>" alt="" /></div>
                <?} else if($row['MAGAZINE_CONTENTS_GB_CD'] == 'TEXT'){?>
                    <p class="magazine-view-text"><?=$row['HEADER_DESC']?></p>
                <?} else if($row['MAGAZINE_CONTENTS_GB_CD'] == 'HTML'){?>
                    <?=$row['HEADER_DESC']?>
                <?} else if($row['MAGAZINE_CONTENTS_GB_CD'] == 'VIDEO'){?>
                    <div style="position: relative; padding-top: 56%;">
                        <iframe src="https://www.youtube.com/embed/<?=$row['HEADER_DESC']?>?autoplay=1" frameborder="0" style="position: absolute; top: 0; width: 100%; height: 100%;"></iframe>
                    </div>
                <?}
            }?>
            <br><br>
            <!--지도-->
            <?if($cateGubun == 7 || $cateGubun == 8) {?>
                <div style="font:normal normal 400 12px/normal dotum, sans-serif; width:100%; height:auto; color:#333; position:relative">
                    <div style="height: auto;">
                        <div id="map" style="border:1px solid #ccc;width:auto;height:200px;position: relative;"></div>
                    </div>
                    <div style="overflow: hidden; padding: 7px 11px; border: 1px solid rgba(0, 0, 0, 0.1); border-radius: 0px 0px 2px 2px; background-color: rgb(249, 249, 249);">
                        <a href="https://map.kakao.com" target="_blank" style="float: left;">
                            <img src="//t1.daumcdn.net/localimg/localimages/07/2018/pc/common/logo_kakaomap.png" width="72" height="16" alt="카카오맵" style="display:block;width:72px;height:16px">
                        </a>
                        <div style="float: right; position: relative; top: 1px; font-size: 11px;">
                            <a id="path" target="_blank" href="#" style="float:left;height:15px;padding-top:1px;line-height:15px;color:#000;text-decoration: none;">길찾기</a>
                        </div>
                    </div>
                </div>
            <?}?>
        </div>
    </div>

    <!-- 매거진에 나온 상품 영역// -->
    <?if(count($magazineGoods) != 0){?>
        <?if($cateGubun == 4 || $cateGubun == 5 || $cateGubun == 6){?><h3 class="prd-list-title">매거진에 나온 상품</h3><?}?>
        <?if($cateGubun == 7){?><h3 class="prd-list-title">공방 상품</h3><?}?>

        <div class="prd-list-wrap">
            <ul class="prd-list prd-list--main prd-list--main--2 owl-carousel <?=count($magazineGoods)>8?'owl-nav1':'owl-dot2'?>">
                <?foreach($magazineGoods as $row) {?>
                    <li class="prd-item">
                        <div class="pic">
                            <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                <div class="item auto-img">
                                    <div class="img">
                                        <img src="<?=$row['IMG_URL']?>" alt="">
                                    </div>
                                </div>
                                <div class="tag-wrap">
                                    <?if(!empty($row['DEAL'])){?><!--<span class="circle-tag deal"><em class="blk">에타<br>딜</em></span>--><?}?>
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
                                        <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                            $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
                                            echo number_format($price);

                                            $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?><span class="won">원</span><br>
                                            <del class="del-price"><?=number_format($row['SELLING_PRICE'])?>원</del>
                                            <span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)</span>
                                        <?}else{
                                            echo number_format($price = $row['SELLING_PRICE'])."<span class=\"won\">원</span>";
                                        }?>
                                    </dd>
                                </dl>
                                <ul class="prd-label-list">
                                    <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){?>
                                        <li class="prd-label-item">쿠폰할인</li>
                                    <?} if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){ ?>
                                        <li class="prd-label-item">마일리지</li>
                                    <?} if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])){?>
                                        <li class="prd-label-item free_shipping">무료배송</li>
                                    <?}?>
                                </ul>
                            </a>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
    <?}?>
    <!-- //매거진에 나온 상품 영역 -->

    <?if($cateGubun == 9){?>
        <!-- 댓글// -->
        <div class="vip-tab-cont prd-assessment-wrap">
            <input type="hidden" id="magazine_no"		name="magazine_no"		value="<?=$this->uri->segment(3)?>">	<!--상품코드-->
            <input type="hidden" id="pre_page_C"		name="pre_page_C"		value="<?=$page?>">			<!--초기엔 현재 페이지, 후엔 이전 페이지 -->
            <input type="hidden" id="limit_num_C"		name="limit_num_C"		value="<?=$limit_num?>">	<!--한 페이지에 보여주는 갯수-->
            <input type="hidden" id="total_cnt_C"		name="total_cnt_C"		value="<?=$detail['COMMENT_CNT']?>">	<!--전체 문의글 갯수-->
            <input type="hidden" id="totla_page_C"		name="total_page_C"		value="<?=$total_page?>">	<!--전체 페이지 수-->
            <input type="hidden" id="next_C"			name="next_C"			value='0'>					<!--페이징 다음 누를시 1씩 증가-->

            <h3 class="info-title info-title--sub">댓글</h3>
            <ul class="prd-assessment-list" id="comment-list">
                <?
                $i=count($comment);
                foreach($comment as $row) {?>
                    <li class="prd-assessment-item" data-toggle="toggle-parent">
                        <span class="prd-assessment-nick"><?=$row['CUST_ID']?></span>
                        <span class="prd-assessment-date"><?=$row['REG_DT']?></span>
                        <div class="prd-assessment-link">
                            <p class="prd-assessment-txt">
                                <?=nl2br(iconv_substr((str_replace("<br />","\n",$row['CONTENTS'])),0,300,"utf-8"))?>
                                <span style="display: none;" id="hidContents<?=$i?>"><?=nl2br(iconv_substr((str_replace("<br />","\n",$row['CONTENTS'])),300))?></span>
                            </p>
                            <?if(iconv_strlen((str_replace("<br />","\n",$row['CONTENTS'])), "utf-8")>300){?>
                                <ul class="media-common-btn-list">
                                    <li class="media-common-btn-item"><a href="javaScript://" class="btn-prd-order-detail" onclick="javaScript:folding_contents('M', <?=$i?>)" id="fold_btn<?=$i?>">더보기</a></li>
                                </ul>
                            <?}?>
                            <?if($row['CUST_NO']==$this->session->userdata('EMS_U_NO_')) {?>
                                <ul class="media-common-btn-list">
                                    <li class="media-common-btn-item"><a href="javaScript:comment_update_layer(<?=$row['COMMENT_NO']?>)" class="btn-prd-order-detail">수정</a></li>
                                    <li class="media-common-btn-item"><a href="javaScript:jsDelComment(<?=$row['COMMENT_NO']?>)" class="btn-prd-order-detail">삭제</a></li>
                                </ul>
                            <?}?>
                        </div>

                        <div class="prd_review" id="prd_review">
                            <?if(isset($row['FILE_PATH'])){?>
                                <ul>
                                    <li class="list">
                                        <ul class="detail">
                                            <li>
                                                <span class="hide"><?=$i?></span>
                                                <a class="view" href="#pro<?=$i?>">
                                                    <img src="<?=$row['FILE_PATH']?>" alt="">
                                                </a>
                                            </li>
                                        </ul><!--detail-->
                                        <div class="summary">
                                            <div class="summarybg">
                                                <div id="pro<?=$i?>" class="product">
                                                    <div class="list_img">
                                                        <img src="<?=$row['FILE_PATH']?>" alt="">
                                                    </div>

                                                </div>
                                            </div><!--//summarybg-->
                                        </div><!--//summary-->
                                    </li><!--//list-->
                                </ul>
                            <?}?>
                        </div>
                    </li>
                    <?$i--;
                }?>
            </ul>

            <!-- 페이징 // -->
            <div class="page" id="page">
                <? if(0 < $detail['COMMENT_CNT']){	?>
                    <ul class="page-num-list" id="page-num-list">
                        <? $total_page = ceil($detail['COMMENT_CNT']/$limit_num);
                        if(1 <= $total_page){	?>
                            <li class="page-num-item active"><a href="javascript:jsPaging_Comment(1);" class="page-num-link">1</a></li>
                        <? }
                        if(2 <= $total_page){	?>
                            <li class="page-num-item"><a href="javascript:jsPaging_Comment(2);" class="page-num-link">2</a></li>
                        <? }
                        if(3 <= $total_page){	?>
                            <li class="page-num-item"><a href="javascript:jsPaging_Comment(3);" class="page-num-link">3</a></li>
                        <? }
                        if(4 <= $total_page){	?>
                            <li class="page-num-item"><a href="javascript:jsPaging_Comment(4);" class="page-num-link">4</a></li>
                        <? }
                        if(5 <= $total_page){	?>
                            <li class="page-num-item"><a href="javascript:jsPaging_Comment(5);" class="page-num-link">5</a></li>
                        <? }?>
                        <? if($total_page != 1 && $total_page > 5){	?>
                            <li class="page-num-item page-num-right"><a href="javascript:$('input[name=next]').val(parseInt($('input[name=next]').val())+1); jsPaging(6);" class="page-num-link"></a></li>
                        <? }?>
                    </ul>
                <? }?>
            </div>
            <!-- // 페이징  -->

            <ul class="common-btn-box">
                <li class="common-btn-item"><a id="aa" href="#prdCommentWrite" class="btn-vip-write" data-ui="vip-layer"><span class="arrow">댓글 작성하기</span></a></li>
            </ul>

            <!--댓글 작성하기 레이어 // -->
            <form name="regCommentForm" id="regCommentForm" method="post" enctype="multipart/form-data">
                <div class="write-layer prd-comment-write" id="prdCommentWrite">
                    <h4 class="write-layer-title">댓글 작성하기</h4>
                    <div class="write-layer-content">
                        <input type="hidden" name="magazine_no" id="magazine_no" value="<?=$this->uri->segment(3)?>">
                        <div class="form-line form-line--wide prd-comment-write-textarea">
                            <div class="form-line-info">
                                <textarea class="input-text input-text--textarea" placeholder="댓글을 입력해 주세요." id="comment_contents" name="comment_contents"></textarea>
                            </div>
                        </div>
                        <div class="form-line form-line--wide">
                            <div class="form-line-info">
                                <div class="file-upload">
                                    <span class="file-upload-title">첨부</span>
                                    <input class="input-text" placeholder="파일찾기로 첨부할 이미지를 선택하세요." readonly name="file_url">
                                    <a href="javaScript:jsDel()" class="spr-btn_delete" title="이미지삭제"></a>
                                    <label for="fileUpload" class="btn-white btn-white--bold">파일찾기</label>
                                    <input type="file" id="fileUpload" name="fileUpload" class="upload-hidden" onChange="javaScript:viewFileUrl(this);">
                                </div>
                            </div>
                        </div>
                        <ul class="text-list">
                            <li class="text-item">jpg, gif 파일만 5MB까지 업로드 가능 합니다.</li>
                        </ul>
                    </div>
                    <ul class="common-btn-box">
                        <li class="common-btn-item"><a href="#prdCommentWrite" class="btn-white btn-white--big" data-ui="vip-layer-close">취소</a></li>
                        <li class="common-btn-item"><a href="#" class="btn-black btn-black--big" onclick="javascript:jsRegComment()">등록하기</a></li>
                    </ul>
                    <a href="#prdCommentWrite" class="btn-close" data-ui="vip-layer-close"><span class="hide">레이어 닫기</span></a>
                </div>
            </form>
            <!-- //댓글 작성하기 레이어 -->
        </div>
        <!-- //댓글 -->

        <!--댓글 수정하기 레이어 // -->
        <div id="modify_comment"></div>
        <!-- //댓글 수정하기 레이어 -->
    <?} else {?>
        <!-- 댓글 영역// -->
        <div class="comment">
            <div class="page-info">
                <span>좋아요 <i><?=$detail['LOVE_CNT']?></i></span><span>공유 <i><?=$detail['SHARE']?></i></span><span>댓글 <i><?=$detail['COMMENT_CNT']?></i></span><span>조회 <i><?=$detail['HITS']?></i></span>
            </div>
            <p class="comment-count">댓글 <?=$detail['COMMENT_CNT']?></p>

            <form name="regCommentForm" id="regCommentForm" method="post">
                <div class="comment-write">
                    <div class="personal-img"></div>
                    <div class="comment-input">
                        <input type="hidden" name="magazine_no" id="magazine_no" value="<?=$this->uri->segment(3)?>">
                        <textarea name="comment_contents" id="comment_contents" cols="30" rows="2"></textarea>
                        <button type="button" class="btn-regist" onclick="javascript:jsRegComment()">등록</button>
                    </div>
                </div>
            </form>

            <div class="comment-read">
                <input type="hidden" id="magazine_no"		name="magazine_no"		value="<?=$this->uri->segment(3)?>">	<!--상품코드-->
                <input type="hidden" id="pre_page_C"		name="pre_page_C"		value="<?=$page?>">			<!--초기엔 현재 페이지, 후엔 이전 페이지 -->
                <input type="hidden" id="limit_num_C"		name="limit_num_C"		value="<?=$limit_num?>">	<!--한 페이지에 보여주는 갯수-->
                <input type="hidden" id="total_cnt_C"		name="total_cnt_C"		value="<?=$detail['COMMENT_CNT']?>">	<!--전체 문의글 갯수-->
                <input type="hidden" id="totla_page_C"		name="total_page_C"		value="<?=$total_page?>">	<!--전체 페이지 수-->
                <input type="hidden" id="next_C"			name="next_C"			value='0'>					<!--페이징 다음 누를시 1씩 증가-->
                <ul class="comment-list" id="comment-list">
                    <?foreach($comment as $row) {?>
                        <li class="comment-box">
                            <span class="author"><?=$row['CUST_ID']?></span>
                            <span id="commentText<?=$row['COMMENT_NO']?>">
                                <span class="date"><?=substr($row['REG_DT'], 0, 10)?></span>
                                <p class="text"><?=$row['CONTENTS']?>﻿</p>
                                <?if($row['CUST_NO']==$this->session->userdata('EMS_U_NO_')) {?>
                                    <div class="modify">
                                        <button type="button" class="btn-delete" onclick="javaScript:jsDelComment(<?=$row['COMMENT_NO']?>)">삭제</button>
                                        <button type="button" class="btn-modify" onclick="javascript:change_input(<?=$row['COMMENT_NO']?>, '<?=$row['CONTENTS']?>')">수정</button>
                                    </div>
                                <?}?>
                            </span>
                        </li>
                    <?}?>
                </ul>
            </div>
        </div>
        <!-- //댓글 영역 -->

        <!-- 페이징 // -->
        <div class="page" id="page">
            <? if(0 < $detail['COMMENT_CNT']){	?>
                <ul class="page-num-list" id="page-num-list">
                    <? $total_page = ceil($detail['COMMENT_CNT']/$limit_num);
                    if(1 <= $total_page){	?>
                        <li class="page-num-item active"><a href="javascript:jsPaging_Comment(1);" class="page-num-link">1</a></li>
                    <? }
                    if(2 <= $total_page){	?>
                        <li class="page-num-item"><a href="javascript:jsPaging_Comment(2);" class="page-num-link">2</a></li>
                    <? }
                    if(3 <= $total_page){	?>
                        <li class="page-num-item"><a href="javascript:jsPaging_Comment(3);" class="page-num-link">3</a></li>
                    <? }
                    if(4 <= $total_page){	?>
                        <li class="page-num-item"><a href="javascript:jsPaging_Comment(4);" class="page-num-link">4</a></li>
                    <? }
                    if(5 <= $total_page){	?>
                        <li class="page-num-item"><a href="javascript:jsPaging_Comment(5);" class="page-num-link">5</a></li>
                    <? }?>
                    <? if($total_page != 1 && $total_page > 5){	?>
                        <li class="page-num-item page-num-right"><a href="javascript:$('input[name=next]').val(parseInt($('input[name=next]').val())+1); jsPaging(6);" class="page-num-link"></a></li>
                    <? }?>
                </ul>
            <? }?>
        </div>
        <!-- // 페이징  -->
    <?}?>

    <!-- 관련상품 추천 영역// -->
    <?if(($cateGubun != 8 && $cateGubun != 9) && count($plusGoods) != 0){?>
        <h3 class="prd-list-title">관련상품 추천</h3>
        <div class="prd-list-wrap">
            <ul class="prd-list prd-list--main owl-carousel owl-dot2">
                <?foreach($plusGoods as $row) {?>
                    <li class="prd-item">
                        <div class="pic">
                            <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                <div class="item auto-img">
                                    <div class="img">
                                        <img src="<?=$row['IMG_URL']?>" alt="">
                                    </div>
                                </div>
                                <div class="tag-wrap">
                                    <?if(!empty($row['DEAL'])){?><span class="circle-tag deal"><em class="blk">에타<br>딜</em></span><?}?>
                                    <?if($row['CLASS_GUBUN']=='C'){?><span class="circle-tag class"><em class="blk">에타<br>클래스</em></span><?}?>
                                    <?if($row['CLASS_GUBUN']=='G'){?><span class="circle-tag class-prd"><em class="blk">공방<br>제작상품</em></span><?}?>
                                </div>
                            </a>
                        </div>
                        <div class="prd-info-wrap">
                            <a href="/goods/detail/<?=$row['GOODS_CD']?>">
                                <dl class="prd-info">
                                    <dt class="prd-item-brand"><?=$row['BRAND_NM']?></dt>
                                    <dd class="prd-item-tit"><?=$row['GOODS_NM']?></dd>
                                    <dd class="prd-item-price">
                                        <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){
                                            $price = $row['SELLING_PRICE'] - ($row['RATE_PRICE_S'] + $row['RATE_PRICE_G']) - ($row['AMT_PRICE_S'] + $row['AMT_PRICE_G']);
                                            echo number_format($price);

                                            $sale_percent = (($row['SELLING_PRICE'] - $price)/$row['SELLING_PRICE']*100);
                                            $sale_percent = strval($sale_percent);
                                            $sale_percent_array = explode('.',$sale_percent);
                                            $sale_percent_string = $sale_percent_array[0];
                                            ?><span class="won">원</span><br>
                                            <del class="del-price"><?=number_format($row['SELLING_PRICE'])?>원</del>
                                            <span class="dc-rate">(<?=floor((($row['SELLING_PRICE']-$price)/$row['SELLING_PRICE'])*100) == 0 ? 1 : $sale_percent_string?>%<span class="spr-common ico-arrow-down"></span>)</span>
                                        <?}else{
                                            echo number_format($price = $row['SELLING_PRICE'])."<span class=\"won\">원</span>";
                                        }?>
                                    </dd>
                                </dl>
                                <ul class="prd-label-list">
                                    <?if($row['COUPON_CD_S'] || $row['COUPON_CD_G']){?>
                                        <li class="prd-label-item">쿠폰할인</li>
                                    <?} if($row['GOODS_MILEAGE_SAVE_RATE'] > 0){ ?>
                                        <li class="prd-label-item">마일리지</li>
                                    <?} if(($row['PATTERN_TYPE_CD'] == 'FREE') || ( $row['DELI_LIMIT'] > 0 && $price > $row['DELI_LIMIT'])){?>
                                        <li class="prd-label-item free_shipping">무료배송</li>
                                    <?}?>
                                </ul>
                            </a>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
    <?}?>
    <!-- //관련상품 추천-->


    <!-- 다른 매거진 더보기 영역// -->
    <?if($cateGubun != 9 && count($otherMagazine) != 0){?>
        <h3 class="prd-list-title">다른 매거진 더보기</h3>
        <div class="prd-list-wrap">
            <ul class="prd-list prd-list--main owl-carousel owl-dot2">
                <?foreach($otherMagazine as $row) {?>
                    <li class="prd-item">
                        <div class="pic">
                            <a href="/magazine/detail/<?=$row['MAGAZINE_NO']?>">
                                <div class="item auto-img">
                                    <div class="img">
                                        <img src="<?=$row['MOB_IMG_URL']?>" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="prd-info-wrap">
                            <a href="/magazine/detail/<?=$row['MAGAZINE_NO']?>">
                                <dl class="prd-info">
                                    <dt class="prd-item-brand"><?=$row['CATEGORY_NM']?></dt>
                                    <dd class="prd-item-tit">#<?=$row['TITLE']?></dd>
                                </dl>
                            </a>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
    <?}?>
    <!-- //다른 매거진 더보기 영역-->
</div>
</div>

<div id="share_sns"></div>
<!-- // 공유하기 레이어 -->


<script type="text/javascript">
    //google_gtag
    gtag('event', 'select_content', {
        "promotions": [
            {
                "id": "<?=$detail['MAGAZINE_NO']?>",
                "name": "ETAH - magazine"
            }
        ]
    });

    $(function(){
        etahUi.layercontroller2();
    });

    //GNB 슬라이드
    $(".gnb-list").owlCarousel({
        items: 3,
        autoWidth: true,
        loop: false,
        margin: 15,
        nav: true,
        dots: false,
        smartSpeed: 200,
        responsive:{
            0:{
                items: 3
            },
            500:{
                items: 5,
                center: false,
                loop: false
            }
        }
    });

    //매거진에 나온 상품
    $(".prd-list--main--2").owlCarousel({
        loop: false,
        autoHeight: true,
        smartSpeed: 300,
        autoplay: true,
        <?if(count($magazineGoods)>8){?>
        nav: true,
        <?}?>
        autoplayTimeout: 5000,
        responsiveClass:true,
        responsive:{
            0:{
                items:2
            },
            768:{
                items:4
            }
        }
    });

    //관련상품 추천, 다른 매거진 더보기 슬라이드
    $(".prd-list--main").owlCarousel({
        loop: false,
        autoHeight: true,
        smartSpeed: 300,
        autoplay: true,
        autoplayTimeout: 5000,
        responsiveClass:true,
        responsive:{
            0:{
                items:2
            },
            768:{
                items:4
            }
        }
    });

    $(function(){
        var vipLayerBtn = $('[data-ui="vip-layer"]')
            ,vipLayerClose = $('[data-ui="vip-layer-close"]');
        $(vipLayerBtn).on('click', function(){
            var thisHref = $(this).attr('href');
            if($(this).hasClass('active')){
                $(this).removeClass('active');
                $(thisHref).slideUp();
            }else{
                $(this).addClass('active');
                $(thisHref).slideDown();
            }
            return false;
        });
        $(vipLayerClose).on('click', function(){
            var thisHref = $(this).attr('href');
            $(thisHref).slideUp();
            $(vipLayerBtn).removeClass('active');
            return false;
        });
    });


    //calculate image size
    function calcImgSize() {
        $("img", ".auto-img").each(function() {
            var $el = $(this);
            $el.parents(".img").addClass(function() {
                var $height = $el.height();
                var $width = $el.width();
                if ($height > $width) return "port";
                else return "land";
            });
        });
    };
    //이미지가 모두 로드 된 후 실행
    jQuery.event.add(window,"load",function(){
        calcImgSize();
    });
</script>

<?if($cateGubun == 7 || $cateGubun == 8) {?>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=a05f67602dc7a0ac2ef1a72c27e5f706&libraries=services"></script>
    <script>
        //===============================================================
        // 다음지도 API
        //===============================================================
        var mapContainer = document.getElementById('map'), // 지도를 표시할 div
            mapOption = {
                center: new daum.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
                level: 3 // 지도의 확대 레벨
            };

        // 지도를 생성합니다
        var map = new daum.maps.Map(mapContainer, mapOption);

        // 주소-좌표 변환 객체를 생성합니다
        var geocoder = new daum.maps.services.Geocoder();

        // 주소로 좌표를 검색합니다
        geocoder.addressSearch('<?=$detail['ADDRESS']?>', function(result, status) {

            // 정상적으로 검색이 완료됐으면
            if (status === daum.maps.services.Status.OK) {

                var coords = new daum.maps.LatLng(result[0].y, result[0].x);
                x = result[0].y;
                y = result[0].x;

                // 결과값으로 받은 위치를 마커로 표시합니다
                var marker = new daum.maps.Marker({
                    map: map,
                    position: coords
                });
                var infowindow = new daum.maps.InfoWindow({
                    content: '<div style="width:280px;text-align:center;padding:6px 0;">' +
                    '<span style="font-weight:600;"><?=$detail['ADDRESS']?>' +
                    '</span></div>'
                });
                infowindow.open(map, marker);

                // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                map.setCenter(coords);


                var path = 'https://map.kakao.com/link/to/<?=$detail['ADDRESS']?>' + ','+ x + ',' + y;

                $("#path").attr("href",path);
            }
        });
    </script>
<?}?>

<script type="text/javascript">
    //=====================================
    // 댓글 내용 더보기
    //=====================================
    function folding_contents(gb, idx) {

        if(gb == 'M') {
            $("#hidContents"+idx).css("display", "inline");  //내용보이기
            $("#fold_btn"+idx).removeAttr("onclick");
            $("#fold_btn"+idx).attr("onclick", "javaScript:folding_contents('F',"+idx+")");

            $("#fold_btn"+idx).text($("#fold_btn"+idx).text() == '더보기' ? "접기" : "더보기");
        }

        if(gb == 'F') {
            $("#hidContents"+idx).css("display", "none");  //내용보이기
            $("#fold_btn"+idx).removeAttr("onclick");
            $("#fold_btn"+idx).attr("onclick", "javaScript:folding_contents('M',"+idx+")");
            $("#fold_btn"+idx).text($("#fold_btn"+idx).text() == '더보기' ? "접기" : "더보기");
        }

    }

    //===============================================================
    // 댓글 작성하기 버튼을 누를 시, 로그인 상태 체크
    //===============================================================
    $(function(){
        $("#aa").on('click', function(e) {
            var SESSION_ID = "<?=$this->session->userdata('EMS_U_ID_')?>";

            if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){
                if(confirm("로그인 후 댓글 작성이 가능합니다. \n로그인하시겠습니까?")){
                    location.href = "https://<?=$_SERVER['HTTP_HOST']?>/member/login";
                } else {
                    setTimeout(function(){
                        $("#aa").removeClass();
                        $("#aa").addClass('btn-vip-write');
                        $("#prdCommentWrite").hide();
                    }, 1);
                }
            }
        })
    })

    //=====================================
    // SNS 공유하기
    //=====================================
    function jsMagazineAction(share, val, title, img) {
        var url = '<?=base_url()?>magazine/detail/'+val;
        //네이버
        if(share == 'N') {
            var url = encodeURI(encodeURIComponent(url));
            var title = encodeURI(title);
            window.open("https://share.naver.com/web/shareView.nhn?url=" + url + "&title=" + title, '', 'width=626,height=436');
        }
        //페이스북
        else if(share == 'F'){
            window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(url)+'&title='+title+'&img='+img,'facebook-share-dialog','width=626,height=436');
        }
        //카카오스토리
        else if(share == 'K'){
            shareStory(url,title);
        }
        //카카오톡
        else if(share == 'T'){
            shareKakaoTalk(url, img, title);
        }

        $.ajax({
            type: 'POST',
            url: '/main/layer_share',
            dataType: 'json',
            data: {
                'gubun' : 'M',
                'code' : val
            }
        })
    }

    //=====================================
    // 카카오스토리 공유하기
    //=====================================
    function shareStory(url, text) {
        Kakao.Story.share({
            url: url,
            text: text
        });
    }

    //=====================================
    // 카카오톡 공유하기
    //=====================================
    Kakao.init('a05f67602dc7a0ac2ef1a72c27e5f706');

    function shareKakaoTalk(url, img, title){
        //카카오링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
        Kakao.Link.sendDefault({
            objectType: 'feed',
            content: {
                title: title,
                imageUrl: img,
                link: {
                    mobileWebUrl: url,
                    webUrl: url
                }
            },
            buttons: [
                {
                    title: '매거진 보러가기',
                    link: {
                        mobileWebUrl: url,
                        webUrl: url
                    }
                }
            ]
        });
    }
</script>
<script type="text/javascript">
    //===============================================================
    // 매거진 좋아요
    //===============================================================
    function jsLoveAction(magazine_no) {

        var magazine_no = magazine_no;

        var SESSION_ID	= "<?=$this->session->userdata('EMS_U_ID_')?>";
        if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST') {
            if(confirm("로그인 후 이용가능합니다. \n로그인하시겠습니까?")){
                location.href = "https://<?=$_SERVER['HTTP_HOST']?>/member/login";
                return false;
            } else {
                return false;
            }
        }

        $.ajax({
            type: 'POST',
            url: '/magazine/magazine_love',
            dataType: 'json',
            data: {'magazine_no' : magazine_no},
            error: function(res) {
                alert(res);
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    location.reload();
                }
                else alert(res.message);
            }
        })
    }

    //===============================================================
    // 파일경로 보여주기
    //===============================================================
    function viewFileUrl(input){
        if($("input[name=fileUpload]").val()){	//파일 확장자 확인
            if(!imgChk($("input[name=fileUpload]").val())){
                alert("jpg, gif 파일만 업로드 가능합니다.");

                //파일 초기화
                $("#fileUpload").replaceWith($("#fileUpload").clone(true));
                $("#fileUpload").val('');
                $("input[name=file_url]").val('');
                return false;
            }
        }

        if(input.files[0].size > 1024*2000){	//파일 사이즈 확인
            alert("파일의 최대 용량을 초과하였습니다. \n파일은 2MB(2048KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB")
            //파일 초기화
            $("#fileUpload").replaceWith($("#fileUpload").clone(true));
            $("#fileUpload").val('');
            $("input[name=file_url]").val('');
            return false;
        }
        else {
            $("input[name=file_url]").val($("input[name=fileUpload]").val());
        }
    }

    //===============================================================
    // 지우기
    //===============================================================
    function jsDel(){
        $("#fileUpload").replaceWith($("#fileUpload").clone(true));
        $("#fileUpload").val('');
        $("input[name=file_url]").val('');
    }

    //===============================================================
    // 확장자 체크 함수 생성
    //===============================================================
    function imgChk(str){
        var pattern = new RegExp(/\.(gif|jpg|jpeg)$/i);

        if(!pattern.test(str)) {
            return false;
        } else {
            return true;
        }
    }

    //===============================================================
    // 매거진 댓글 등록하기
    //===============================================================
    function jsRegComment(){

        if( ! $("#comment_contents").val() ){
            alert('댓글을 입력하시기 바랍니다.');
            $("input[name=comment_contents]").focus();
            return false;
        }

        var data = new FormData($('#regCommentForm')[0]);

        $.ajax({
            type: 'POST',
            url: '/magazine/comment_regist',
            dataType: 'json',
            data: data,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    location.reload();
                }
                else alert(res.message);
            }
        })

    }

    //===============================================================
    // 매거진 댓글 수정
    //===============================================================
    //댓글 수정 입력란
    function change_input(val, txt){
        $("#commentText"+val).html("<div class=\"comment-input\"><textarea name='comment_contents_update' id='comment_contents_update' cols='30' rows='2'>"+txt+"</textarea>" +
            "<button type='button'  class=\"btn-modify\" onclick='javascript:jsUpdComment("+val+")'>수정</button></div>");
    }

    //매거진 상세페이지 댓글 수정
    function jsUpdComment(val){
        var gubun = 'A';
        var txt = $("#comment_contents_update").val();

        $.ajax({
            type: 'POST',
            url: '/magazine/comment_update',
            dataType: 'json',
            data: {
                'gubun' : gubun,
                'comment_no' : val,
                'comment_txt' : txt
            },
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert('수정되었습니다.');
                    location.reload();
                }
                else alert(res.message);
            }
        })
    }

    //댓글 수정 레이어
    function comment_update_layer(val){
        $.ajax({
            type: 'POST',
            url: '/magazine/comment_update_layer',
            dataType: 'json',
            data: { 'comment_no' : val },
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    $("#modify_comment").html(res.modify_comment);
                }
                else console.log(res.message);
            }
        })
    }

    //===============================================================
    // 매거진 댓글 삭제
    //===============================================================
    function jsDelComment(comment_no) {
        if(!confirm('삭제하시겠습니까?')) {
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '/magazine/comment_delete',
            dataType: 'json',
            data: {'comment_no' : comment_no},
            error: function(res) {
                alert('Database Error');
            },
            success: function(res) {
                if(res.status == 'ok'){
                    alert('삭제되었습니다');
                    location.reload();
                }
                else alert(res.message);
            }
        })
    }


    //===============================================================
    // 페이징
    //===============================================================
    function jsPaging_Comment(page){
        var magazine_no = $("input[name=magazine_no]").val();		//매거진 번호
        var pre_page	= $("input[name=pre_page_C]").val();		//이전페이지
        var limit_num	= $("input[name=limit_num_C]").val();		//한 페이지당 보여줄 갯수
        var total_cnt	= $("input[name=total_cnt_C]").val();		//전체 갯수
        var idx			= total_cnt - limit_num * (page - 1);		//순번 역순
        var next		= $('input[name=next_C]').val();			//다음페이지를 만들지 말지 비교를 위한 변수

        $.ajax({
            type: 'POST',
            url: '/magazine/comment_paging',
            dataType: 'json',
            data: {magazine_no : magazine_no, page : page, limit : limit_num},
            error: function(res) {
                alert('Database Error');
                alert(res.responseText);
            },
            success: function(res) {
                if(res.status == 'ok'){
                    var comment = res.comment;
                    var comment_temp = "";


                    <?if($cateGubun == 9) {?>
                    for(var i=0; i<comment.length; i++){
                        comment_temp += "<li class=\"prd-assessment-item\" data-toggle=\"toggle-parent\">" +
                            "<span class=\"prd-assessment-nick\">"+comment[i]['CUST_ID']+"</span>" +
                            "<span class=\"prd-assessment-date\">"+comment[i]['REG_DT']+"</span>" +
                            "<div class=\"prd-assessment-link\">" +
                            "<p class=\"prd-assessment-txt\">"+comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').substring(0,300).replace(/(\n|\r\n)/g, '<br>')+
                            "<span style=\"display: none;\" id=\"hidContents"+idx+"\">"+comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').substring(300).replace(/(\n|\r\n)/g, '<br>')+"</span>" +
                            "</p>";

                        if(comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').length > 300){
                            comment_temp += "<ul class=\"media-common-btn-list\">" +
                                "<li class=\"media-common-btn-item\"><a href=\"javaScript://\" class=\"btn-prd-order-detail\" onclick=\"javaScript:folding_contents('M', "+idx+")\" id=\"fold_btn"+idx+"\">더보기</a></li>" +
                                "</ul>";
                        }

                        if(comment[i]['CUST_NO']=='<?=$this->session->userdata('EMS_U_NO_')?>') {
                            comment_temp += "<ul class=\"media-common-btn-list\">" +
                                "<li class=\"media-common-btn-item\"><a href=\"javaScript:comment_update_layer("+comment[i]['COMMENT_NO']+")\" class=\"btn-prd-order-detail\">수정</a></li>" +
                                "<li class=\"media-common-btn-item\"><a href=\"javaScript:jsDelComment("+comment[i]['COMMENT_NO']+")\" class=\"btn-prd-order-detail\">삭제</a></li>" +
                                "</ul>";
                        }

                        comment_temp += "</div>" +
                            "<div class=\"prd_review\" id=\"prd_review\">";

                        if( comment[i]['FILE_PATH'] ) {
                            comment_temp += "<ul>" +
                                "<li class=\"list\">" +
                                "<ul class=\"detail\">" +
                                "<li>" +
                                "<span class=\"hide\">"+idx+"</span>" +
                                "<a class=\"view\" href=\"#pro"+idx+"\">" +
                                "<img src=\""+comment[i]['FILE_PATH']+"\" alt=\"\">" +
                                "</a>" +
                                "</li>" +
                                "</ul>" +
                                "<div class=\"summary\">" +
                                "<div class=\"summarybg\">" +
                                "<div id=\"pro"+idx+"\" class=\"product\">" +
                                "<div class=\"list_img\">" +
                                "<img src=\""+comment[i]['FILE_PATH']+"\" alt=\"\">" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</div>" +
                                "</li>" +
                                "</ul>";
                        }

                        comment_temp += "</div></li>";

                        idx--;
                    }

                    <?} else {?>
                    for(var i=0; i<comment.length; i++){
                        comment_temp += "<li class=\"comment-box\">" +
                            "<span class=\"author\">"+comment[i]['CUST_ID']+"</span>" +
                            "<span id=\"commentText"+comment[i]['COMMENT_NO']+"\">" +
                            "<span class=\"date\">"+comment[i]['REG_DT']+"</span>" +
                            "<p class=\"text\">"+comment[i]['CONTENTS']+"</p>";

                        if(comment[i]['CUST_NO']=='<?=$this->session->userdata('EMS_U_NO_')?>') {
                            comment_temp += "<div class=\"modify\">" +
                                "<button type=\"button\" class=\"btn-delete\" onclick=\"javaScript:jsDelComment("+comment[i]['COMMENT_NO']+")\">삭제</button>" +
                                "<button type=\"button\" class=\"btn-modify\" onclick=\"javascript:change_input("+comment[i]['COMMENT_NO']+", '"+comment[i]['CONTENTS']+"')\">수정</button>" +
                                "</div>";
                        }

                        comment_temp += "</span></li>";
                    }
                    <?}?>

                    var strHtmlPag = makePaginationHtml_Comment(page, next, limit_num);
                    $("#page-num-list").remove();
                    $("#page").append(strHtmlPag);

                    var page_c = page % 5;
                    if(page_c == 0){	//클래스 입힐 페이지의 위치를 알아내기 위해
                        page_c = 5;
                    }

                    $("#comment-list").html(comment_temp);
                    $("div#page li.page-num-item:nth-child("+pre_page+")").removeClass('active');		//이전페이지 클래스 삭제
                    $("div#page li.page-num-item:nth-child("+page_c+")").addClass('active');			//현재페이지 위치에 클래스 적용
                    $("input[name=pre_page_C]").val(page);		//페이지 이동 전의 페이지 저장

                }
                else alert(res.message);
            }
        })

        $(document).bind('ready ajaxComplete', function(){  //자바스크립트 로드

            $('header').mouseenter(function(){
                //alert()
                $('.subBg').stop().slideDown()
            })
            $('header').mouseleave(function(){
                $('.subBg').stop().slideUp()
            })

            $('a.view').click(function(e){
                e.preventDefault();
                var current=$(this).parents('.detail')

                $('.detail').not(current).next().animate({'height':0})
                // $('.detail').next().animate({'height':0})

                var href=$(this).attr('href');//화면에 보여라 안보여라
                $('.detail li a').removeClass('on');
                $(this).addClass('on')

                //alert(href)
                $('.product').fadeOut()
                $(href).fadeIn()

                $(href).find('.detail_arrow').addClass('on')


                var h=$(href).height()
                $(current).next().animate({'height':h})

            })

            $('.close').click(function(e){
                e.preventDefault();
                $(this).parents('.summary').animate({'height':0})
                $('.detail_arrow').removeClass('on')
                $('a.view').removeClass('on');
            })

        });
    }
    /****************************/
    /* 페이징 HTML 만들기 함수  */
    /****************************/
    function makePaginationHtml_Comment(currPage, nextPage, limitNum){
        var strHtmlPag	= "";
        var totalPage	= $("input[name=total_page_C]").val();
        var next = "";	//다음페이지를 만들지 말지 비교를 위한 변수

        strHtmlPag+="<ul class=\"page-num-list\" id=\"page-num-list\">";
        if(nextPage != 0){
            strHtmlPag+="<li class=\"page-num-item page-num-left\"><a href=\"javascript:$('input[name=next_C]').val(parseInt($('input[name=next_C]').val())-1); jsPaging_Comment("+parseInt(5*nextPage)+");\" class=\"page-num-link\"></a></li>";
        }

        if(parseInt(5*nextPage+1) <= totalPage){
            strHtmlPag+="<li class=\"page-num-item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+1)+");\" class=\"page-num-link\">"+parseInt(5*nextPage+1)+"</a></li> ";
        } else {
            next = 'N';
        }

        if(parseInt(5*nextPage+2) <= totalPage){
            strHtmlPag+="<li class=\"page-num-item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+2)+");\" class=\"page-num-link\">"+parseInt(5*nextPage+2)+"</a></li> ";
        } else {
            next = 'N';
        }

        if(parseInt(5*nextPage+3) <= totalPage){
            strHtmlPag+="<li class=\"page-num-item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+3)+");\" class=\"page-num-link\">"+parseInt(5*nextPage+3)+"</a></li> ";
        } else {
            next = 'N';
        }

        if(parseInt(5*nextPage+4) <= totalPage){
            strHtmlPag+="<li class=\"page-num-item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+4)+");\" class=\"page-num-link\">"+parseInt(5*nextPage+4)+"</a></li> ";
        } else {
            next = 'N';
        }

        if(parseInt(5*nextPage+5) <= totalPage){
            strHtmlPag+="<li class=\"page-num-item\"><a href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+5)+");\" class=\"page-num-link\">"+parseInt(5*nextPage+5)+"</a></li> ";
        } else {
            next = 'N';
        }

        if(currPage != totalPage && totalPage > 5 && next != 'N'){
            strHtmlPag+="<li class=\"page-num-item page-num-right\"><a href=\"javascript:$('input[name=next_C]').val(parseInt($('input[name=next_C]').val())+1); jsPaging_Comment("+parseInt(5*nextPage+6)+");\" class=\"page-num-link\"></a></li>";
            strHtmlPag+="</ul>";
        }

        return strHtmlPag;
    }
</script>



<script>

    $(function(){
        $('header').mouseenter(function(){
            //alert()
            $('.subBg').stop().slideDown()
        })
        $('header').mouseleave(function(){
            $('.subBg').stop().slideUp()
        })

        $('a.view').click(function(e){
            e.preventDefault();
            var current=$(this).parents('.detail')

            $('.detail').not(current).next().animate({'height':0})
            // $('.detail').next().animate({'height':0})

            var href=$(this).attr('href');//화면에 보여라 안보여라
            $('.detail li a').removeClass('on');
            $(this).addClass('on')

            //alert(href)
            $('.product').fadeOut()
            $(href).fadeIn()

            $(href).find('.detail_arrow').addClass('on')


            var h=$(href).height()
            $(current).next().animate({'height':h})

        })

        $('.close').click(function(e){
            e.preventDefault();
            $(this).parents('.summary').animate({'height':0})
            $('.detail_arrow').removeClass('on')
            $('a.view').removeClass('on');
        })
    })

</script>