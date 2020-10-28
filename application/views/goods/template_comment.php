

<form id="updFile" name="updFile" method="post" enctype="multipart/form-data">

	<input type="hidden" id="goods_code"		name="goods_code"		value="<?=$goods_code?>">	<!--상품코드-->
	<input type="hidden" id="pre_page_C"		name="pre_page_C"		value="<?=$page?>">			<!--초기엔 현재 페이지, 후엔 이전 페이지 -->
	<input type="hidden" id="limit_num_C"		name="limit_num_C"		value="<?=$limit_num?>">	<!--한 페이지에 보여주는 갯수-->
	<input type="hidden" id="total_cnt_C"		name="total_cnt_C"		value="<?=$total_cnt?>">	<!--전체 문의글 갯수-->
	<input type="hidden" id="totla_page_C"		name="total_page_C"		value="<?=$total_page?>">	<!--전체 페이지 수-->
	<input type="hidden" id="next_C"			name="next_C"			value='0'>					<!--페이징 다음 누를시 1씩 증가-->

				<ul class="prd-assessment-list" id="comment_body">
			<? $i = $total_cnt;
				if($i != 0){
					foreach($goods_comment as $row){	?>

                        <li class="prd-assessment-item" data-toggle="toggle-parent">
                            <span class="prd-assessment-nick"><?=substr($row['CUST_ID'],0,3)."****"?></span>
                            <span class="prd-assessment-date"><?=substr($row['CUST_GOODS_COMMENT_REG_DT'],0,10)?></span>
                            <div class="star-grade-box">
                                <span class="star-rating spr-common"><span class="star-ico spr-common" style="width:<?=$row['TOTAL_GRADE_VAL']*20?>%"></span></span>
                            </div>
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
                                <br>
                                <p class="prd-assessment-name"><?=$row['GOODS_OPTION_NM']?></p>
                                <?if(!empty($row['CUST_NO']) && ($row['CUST_NO'] == $this->session->userdata('EMS_U_NO_'))){?>
                                    <ul class="media-common-btn-list">
                                        <li class="media-common-btn-item"><a href="#layerPrdCommentModify" class="btn-prd-order-detail" onclick="javaScript:modify_comment_layer(<?=$row['CUST_GOODS_COMMENT']?>)">수정</a></li>
                                        <li class="media-common-btn-item"><a href="javaScript:;" class="btn-prd-order-detail" onclick="javaScript:delete_comment(<?=$row['CUST_GOODS_COMMENT']?>)">삭제</a></li>
                                    </ul>
                                <?}?>
                            </div>
                            <div class="prd_review" id="prd_review">
                                <ul>
                                    <li class="list">
                                        <ul class="detail">
                                            <?
                                            $j=0;
                                            if($row['FILE_PATH']){
                                                foreach($row['FILE_PATH'] as $file){
                                                    ?>
                                                    <?
                                                    $exif = @exif_read_data($file['FILE_PATH']); //2019-12-02 이미지 회전되어 나오는 문제
                                                    $degree = 0;
                                                    if(!empty($exif['Orientation'])) {
                                                        switch($exif['Orientation']) {
                                                            case 8:  $degree = -90;   break;
                                                            case 3:  $degree = 180;   break;
                                                            case 6:  $degree = 90;    break;
                                                            default: $degree = 0;    break;
                                                        }
                                                    }

                                                    ?>
                                                    <li>
                                                        <span class="hide"><?=$i?>_<?=$j?></span>
                                                        <a class="view" href="#pro<?=$i?>_<?=$j?>">
                                                            <img src="<?=$file['FILE_PATH']?>" alt="" style="transform: rotate(<?=$degree?>deg);">
                                                        </a>
                                                    </li>
                                                    <?
                                                    $j++;
                                                }
                                            }?>
                                        </ul><!--detail-->
                                        <div class="summary">
                                            <div class="summarybg">
                                                <?
                                                $j=0;
                                                if($row['FILE_PATH']){
                                                    foreach($row['FILE_PATH'] as $file){
                                                        ?>
                                                        <?
                                                        $exif = @exif_read_data($file['FILE_PATH']); //2019-12-02 이미지 회전되어 나오는 문제
                                                        $degree = 0;
                                                        if(!empty($exif['Orientation'])) {
                                                            switch($exif['Orientation']) {
                                                                case 8:  $degree = -90;   break;
                                                                case 3:  $degree = 180;   break;
                                                                case 6:  $degree = 90;    break;
                                                                default: $degree = 0;    break;
                                                            }
                                                        }

                                                        ?>
                                                        <div id="pro<?=$i?>_<?=$j?>" class="product">
                                                            <div class="list_img">
                                                                <img src="<?=$file['FILE_PATH']?>" alt="" style="transform: rotate(<?=$degree?>deg);">
                                                            </div>
                                                        </div>
                                                        <?
                                                        $j++;
                                                    }
                                                }?>
                                            </div><!--//summarybg-->
                                        </div><!--//summary-->
                                    </li><!--//list-->
                                </ul>
                            </div>
                        </li>

			<? $i--;
					}
				} else {	?>
					<li class="prd-qna-item">
						<div class="prd-question-box">
							<dl class="prd-question">
								<dd class="prd-question-txt">
									등록 된 상품평이 없습니다.
								</dd>
							</dl>
						</div>
					</li>
			<?	}?>
					<!--
					<li class="prd-assessment-item">
						<span class="prd-assessment-nick">lul***</span>
						<span class="prd-assessment-date">2016.11.22</span>
						<a href="#" class="prd-assessment-link">
							<p class="prd-assessment-txt">기다린만큼 좋아요. 배송도 빠르고 적극 추천합니다!</p>
							<p class="prd-assessment-name">움브라 바나 더블 타올홀더</p>
						</a>
						<div class="star-grade-box">
							<span class="star-rating spr-common"><span class="star-ico spr-common" style="width:80%"></span></span>
						</div>
					</li>
					<li class="prd-assessment-item">
						<span class="prd-assessment-nick">lul***</span>
						<span class="prd-assessment-date">2016.11.22</span>
						<a href="#" class="prd-assessment-link">
							<p class="prd-assessment-txt">기다린만큼 좋아요. 배송도 빠르고 적극 추천합니다!</p>
							<p class="prd-assessment-name">움브라 바나 더블 타올홀더</p>
						</a>
						<div class="star-grade-box">
							<span class="star-rating spr-common"><span class="star-ico spr-common" style="width:80%"></span></span>
						</div>
					</li>	-->
				</ul>
				<!-- 페이징 // -->
<!--			<div class="position_area" id="comment_pagination_position">-->
                <div id="comment_pagination_position">
                    <div class="page" id="comment_pagination">
                    <? if(0 < $total_cnt){	?>
                        <ul class="page-num-list">
                        <!--	<li class="page-num-item page-num-left page-num-double-left">
                                <a href="#" class="page-num-link"></a>
                            </li>
                            <li class="page-num-item page-num-left">
                                <a href="#" class="page-num-link"></a>
                            </li>	-->
                        <? $total_page = ceil($total_cnt/$limit_num);
                            if(1 <= $total_page){	?>
                            <li class="page-num-item active">
                                <a href="javascript:jsPaging_Comment(1);" class="page-num-link">1</a>
                            </li>
                        <? }
                            if(2 <= $total_page){	?>
                            <li class="page-num-item">
                                <a href="javascript:jsPaging_Comment(2);" class="page-num-link">2</a>
                            </li>
                        <? }
                            if(3 <= $total_page){	?>
                            <li class="page-num-item">
                                <a href="javascript:jsPaging_Comment(3);" class="page-num-link">3</a>
                            </li>
                        <? }
                            if(4 <= $total_page){	?>
                            <li class="page-num-item">
                                <a href="javascript:jsPaging_Comment(4);" class="page-num-link">4</a>
                            </li>
                        <? }
                            if(5 <= $total_page){	?>
                            <li class="page-num-item">
                                <a href="javascript:jsPaging_Comment(5);" class="page-num-link">5</a>
                            </li>
                        <? }?>
                        <? if($total_page != 1 && $total_page > 5){	?>
                            <li class="page-num-item page-num-right active">
                                <a href="javascript:$('input[name=next]').val(parseInt($('input[name=next]').val())+1); jsPaging(6);" class="page-num-link"></a>
                            </li>
                        <? }?>
                        <!--	<li class="page-num-item page-num-right page-num-double-right">
                                <a href="#" class="page-num-link"></a>
                            </li>	-->
                        </ul>
                    <? }?>
                    </div>
                </div>
<!--			</div>-->
				<!-- // 페이징  -->
				<ul class="common-btn-box">
					<li class="common-btn-item"><a id="aa" href="#prdCommentWrite" class="btn-vip-write" data-ui="vip-layer"><span class="arrow">상품평 작성하기</span></a></li>
				</ul>

				<!-- 상품평 작성하기 레이어 // -->
				<div class="write-layer prd-comment-write" id="prdCommentWrite">
					<h4 class="write-layer-title">상품평 작성하기</h4>
					<div class="write-layer-content">
						<ul class="prd-comment-write-star">
                            <?if($mid_category_code == 24010000){?>
                                <input type="hidden" id="grade_val05" name="grade_val05" value="">

                                <li class="prd-comment-write-star-item">
                                    <span class="title">만족도</span>
                                    <ul class="star-grade-select" id="grade05">
                                        <li id="comment_05_1" name="comment_05" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_05_2" name="comment_05" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_05_3" name="comment_05" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_05_4" name="comment_05" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_05_5" name="comment_05" class="star-grade-select-item spr-common spr-star"></li>
                                    </ul>
                                </li>
                            <?}else{?>
                                <input type="hidden" id="grade_val01" name="grade_val01" value="">
                                <input type="hidden" id="grade_val02" name="grade_val02" value="">
                                <input type="hidden" id="grade_val03" name="grade_val03" value="">
                                <input type="hidden" id="grade_val04" name="grade_val04" value="">

                                <li class="prd-comment-write-star-item">
                                    <span class="title">품질</span>
                                    <ul class="star-grade-select" id="grade01">
                                        <li id="comment_01_1" name="comment_01" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_01_2" name="comment_01" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_01_3" name="comment_01" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_01_4" name="comment_01" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_01_5" name="comment_01" class="star-grade-select-item spr-common spr-star"></li>
                                    </ul>
                                </li>
                                <li class="prd-comment-write-star-item" id="grade02">
                                    <span class="title">배송</span>
                                    <ul class="star-grade-select">
                                        <li id="comment_02_1" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_02_2" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_02_3" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_02_4" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_02_5" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                                    </ul>
                                </li>
                                <li class="prd-comment-write-star-item" id="grade03">
                                    <span class="title">가격</span>
                                    <ul class="star-grade-select">
                                        <li id="comment_03_1" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_03_2" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_03_3" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_03_4" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_03_5" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                                    </ul>
                                </li>
                                <li class="prd-comment-write-star-item" id="grade04">
                                    <span class="title">디자인</span>
                                    <ul class="star-grade-select">
                                        <li id="comment_04_1" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_04_2" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_04_3" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_04_4" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                                        <li id="comment_04_5" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                                    </ul>
                                </li>
                            <?}?>
						</ul>
						<div class="form-line form-line--wide prd-comment-write-textarea">
							<div class="form-line-info">
								<textarea class="input-text input-text--textarea" id="comment_contents" name="comment_contents" placeholder=" * 20자 이상 구매평을 남겨주셔야 등록이 가능합니다.
 * 텍스트 구매평 1000점 마일리지 / 사진 추가시 2000점 마일리지
 * 후기하고 관련 된 상품의 사진 아니면 마일리지 추후 차감 될수 있습니다.
 * 구매평 적립 제외 : 실 결제금액이 5000원 미만인경우 상품평 작성에 대한 마일리지 적립이 제외됩니다.
 * 동일상품에 대한 구매평 적립혜택은 1회로 제한 되며 적립후 30일 경과시 구매평 적립혜택을 다시 받을수 있습니다. "></textarea>
							</div>
						</div>
                        <!-- 첨부파일 이미지 // -->
                        <div class="form-line form-line--wide" id="tblFileUpload">
                            <div class="form-line form-line--wide" name="cmrow[]">
                                <div class="form-line-info">
                                    <div class="file-upload">
                                        <span class="file-upload-title">첨부</span>
                                        <input class="input-text" placeholder="파일찾기로 첨부할 이미지를 선택하세요." readonly name="file_url[]" id="file_url_0">
                                        <a href="javaScript:jsDel(0)" class="spr-btn_delete plus" title="이미지삭제"></a>
                                        <label for="fileUpload_0" class="btn-white btn-white--bold">파일찾기</label>
                                        <input type="file" id="fileUpload_0" name="fileUpload[]" class="upload-hidden" onChange="javaScript:viewFileUrl(this, 0);">
                                        <button class="file_puls_btn" onclick="return false;"><img src="/assets/images/sprite/btn_plus.png" alt="" onclick="javaScript:jsAdd();"></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="text-list">
                            <li class="text-item">jpg, gif 파일만 5MB까지 업로드 가능 합니다.</li>
                        </ul>
                        <!-- // 첨부파일 이미지 -->
					</div>
					<ul class="common-btn-box">
						<li class="common-btn-item"><a href="#" class="btn-white btn-white--big">취소</a></li>
						<li class="common-btn-item"><a href="javascript:jsComment();" class="btn-black btn-black--big">등록하기</a></li>
					</ul>
					<a href="#prdCommentWrite" class="btn-close" data-ui="vip-layer-close"><span class="hide">레이어 닫기</span></a>
				</div>
				<!-- // 상품평 작성하기 레이어 -->
	</form>

<div id="modify_comment"></div>


<script type="text/javascript">
//===============================================================
// 상품평쓰기 버튼을 누를 시, 로그인 상태 체크
//===============================================================
$(function(){
	$("#aa").on('click', function(e) {
		var SESSION_ID = "<?=$this->session->userdata('EMS_U_ID_')?>";

		if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){
			if(confirm("로그인 후 상품평 쓰기가 가능합니다. \n로그인하시겠습니까?")){
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

$(function(){
	$("#grade01").on('click', function(e) {
		var idx = 1;														//상품평의 별 갯수 체크하기 위한 인덱스
		var comment_grade_val01	= 0;										//상품평(품질)
		$("li[name='comment_01']").each(function() {
			if($("#comment_01_"+idx).attr('class') == 'star-grade-select-item spr-common spr-star active'){
				comment_grade_val01 ++;
			}
			idx ++;
		})
		$("input[name='grade_val01']").val(comment_grade_val01);
	})
})

$(function(){
	$("#grade02").on('click', function(e) {
		var idx = 1;														//상품평의 별 갯수 체크하기 위한 인덱스
		var comment_grade_val02	= 0;										//상품평(배송)
		$("li[name='comment_02']").each(function() {
			if($("#comment_02_"+idx).attr('class') == 'star-grade-select-item spr-common spr-star active'){
				comment_grade_val02 ++;
			}
			idx ++;
		})
		$("input[name='grade_val02']").val(comment_grade_val02);
	})
})

$(function(){
	$("#grade03").on('click', function(e) {
		var idx = 1;														//상품평의 별 갯수 체크하기 위한 인덱스
		var comment_grade_val03	= 0;										//상품평(가격)
		$("li[name='comment_03']").each(function() {
			if($("#comment_03_"+idx).attr('class') == 'star-grade-select-item spr-common spr-star active'){
				comment_grade_val03 ++;
			}
			idx ++;
		})
		$("input[name='grade_val03']").val(comment_grade_val03);
	})
})

$(function(){
	$("#grade04").on('click', function(e) {
		var idx = 1;														//상품평의 별 갯수 체크하기 위한 인덱스
		var comment_grade_val04	= 0;										//상품평(디자인)
		$("li[name='comment_04']").each(function() {
			if($("#comment_04_"+idx).attr('class') == 'star-grade-select-item spr-common spr-star active'){
				comment_grade_val04 ++;
			}
			idx ++;
		})
		$("input[name='grade_val04']").val(comment_grade_val04);
	})
})

$(function(){
    $("#grade05").on('click', function(e) {
        var idx = 1;														//상품평의 별 갯수 체크하기 위한 인덱스
        var comment_grade_val05	= 0;										//상품평(만족도)
        $("li[name='comment_05']").each(function() {
            if($("#comment_05_"+idx).attr('class') == 'star-grade-select-item spr-common spr-star active'){
                comment_grade_val05 ++;
            }
            idx ++;
        })
        $("input[name='grade_val05']").val(comment_grade_val05);
    })
})
//===============================================================
// 파일경로 보여주기
//===============================================================
function viewFileUrl(input, idx){
    if($("#fileUpload_"+idx).val()){	//파일 확장자 확인
        if(!imgChk($("#fileUpload_"+idx).val())){
            alert("jpg, gif, png 파일만 업로드 가능합니다.");

            //파일 초기화
            $("#fileUpload_"+idx).replaceWith($("#fileUpload_"+idx).clone(true));
            $("#fileUpload_"+idx).val('');
            $("#file_url_"+idx).val('');
            return false;
        }
    }

    if(input.files[0].size > 1024*5000){	//파일 사이즈 확인
        alert("파일의 최대 용량을 초과하였습니다. \n파일은 5MB(5120KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

        //파일 초기화
        $("#fileUpload_"+idx).replaceWith($("#fileUpload_"+idx).clone(true));
        $("#fileUpload_"+idx).val('');
        $("#fileUpload_"+idx).val('');
        return false;
    }
    else {
        $("#file_url_"+idx).val($("#fileUpload_"+idx).val());
    }
}

//===============================================================
// 지우기
//===============================================================
function jsDel(idx){
    $("#fileUpload_"+idx).replaceWith($("#fileUpload_"+idx).clone(true));
    $("#fileUpload_"+idx).val('');
    $("#file_url_"+idx).val('');
}

//===============================================================
// 추가이미지
//===============================================================
function jsAdd(){
    var index = document.getElementsByName("cmrow[]").length;

    if(index == 5 ) {
        alert("이미지는 최대 5개까지 업로드 가능합니다.");
        return false;
    }

    $("#tblFileUpload").append(
        "<div class=\"form-line form-line--wide\" name=\"cmrow[]\">" +
        "<div class=\"form-line-info\">" +
        "<div class=\"file-upload\">" +
        "<span class=\"file-upload-title\">첨부</span>" +
        "<input class=\"input-text\" placeholder=\"파일찾기로 첨부할 이미지를 선택하세요.\" readonly name=\"file_url[]\" id=\"file_url_"+index+"\">" +
        "<a href=\"javaScript:jsDel("+index+")\" class=\"spr-btn_delete plus\" title=\"이미지삭제\"></a>" +
        "<label for=\"fileUpload_"+index+"\" class=\"btn-white btn-white--bold\">파일찾기</label>" +
        "<input type=\"file\" id=\"fileUpload_"+index+"\" name=\"fileUpload[]\" class=\"upload-hidden\" onChange=\"javaScript:viewFileUrl(this, "+index+");\">" +
        "<button class=\"file_puls_btn\" onclick=\"return false;\"><img src=\"/assets/images/sprite/btn_plus.png\" alt=\"\" onclick=\"javaScript:jsAdd();\"></button>" +
        "</div>" +
        "</div>" +
        "</div>"
    )
}


//===============================================================
// 확장자 체크 함수 생성
//===============================================================
function imgChk(str){
	var pattern = new RegExp(/\.(gif|jpg|jpeg|png)$/i);

	if(!pattern.test(str)) {
		return false;
	} else {
		return true;
	}
}

//===============================================================
// 상품평 등록하기
//===============================================================
function jsComment(){
	var data = new FormData($('#updFile')[0]);

	var comment_goods_code	= $("input[name=goods_code]").val();		//상품코드
	var comment_contents	= $("#comment_contents").val();				//상품평 내용
	var comment_grade_val01 = $("input[name='grade_val01']").val();		//상품평(품질)
	var comment_grade_val02 = $("input[name='grade_val02']").val();		//상품평(배송)
	var comment_grade_val03 = $("input[name='grade_val03']").val();		//상품평(가격)
	var comment_grade_val04 = $("input[name='grade_val04']").val();		//상품평(디자인)
    var comment_grade_val05 = $("input[name='grade_val05']").val();		//상품평(만족도)

	var mem_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";	//상품평 작성하는 아이디

	if( comment_grade_val01 == 0){
		alert('품질 만족도를 표시해주시기 바랍니다.');
		return false;
	}

	if( comment_grade_val02 == 0){
		alert('배송 만족도를 표시해주시기 바랍니다.');
		return false;
	}

	if( comment_grade_val03 == 0){
		alert('가격 만족도를 표시해주시기 바랍니다.');
		return false;
	}

	if( comment_grade_val04 == 0){
		alert('디자인 만족도를 표시해주시기 바랍니다.');
		return false;
	}

    if( comment_grade_val05 == 0){
        alert('만족도를 표시해주시기 바랍니다.');
        return false;
    }

	if( ! comment_contents ){
		alert('상품평 내용을 입력하시기 바랍니다.');
		$("input[name=comment_contents]").focus();
		return false;
	}
    if(comment_contents.length < 20){
        alert('20자 이상 구매평을 남겨주세요.');
        $("input[name=comment_contents]").focus();
        return false;
    }

// 2016-12-22 mywiz controller에 추가
	$.ajax({
		type: 'POST',
		url: '/mywiz/comment_regist',
//		dataType: 'json',
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
				alert('등록이 완료 되었습니다.');
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
	var goods_code  = $("input[name=goods_code]").val();		//상품코드
	var pre_page	= $("input[name=pre_page_C]").val();		//이전페이지
	var total_cnt	= $("input[name=total_cnt_C]").val();		//전체 갯수
	var limit_num	= $("input[name=limit_num_C]").val();		//한 페이지당 보여줄 갯수
	var idx			= total_cnt - limit_num * (page - 1);		//순번 역순
	var next		= $('input[name=next_C]').val();			//다음페이지를 만들지 말지 비교를 위한 변수

	$.ajax({
			type: 'POST',
			url: '/goods/comment_paging',
			dataType: 'json',
			data: {goods_code : goods_code, page : page, limit : limit_num},
			error: function(res) {
				alert('Database Error');
				alert(res.responseText);
			},
			success: function(res) {
				if(res.status == 'ok'){
					var comment = res.comment;
					var comment_temp = "";

					for(var i=0; i<comment.length; i++){

                        comment_temp += "<li class=\"prd-assessment-item\" data-toggle=\"toggle-parent\">" +
                            "<span class=\"prd-assessment-nick\">"+comment[i]['CUST_ID']+"</span>" +
                            "<span class=\"prd-assessment-date\">"+comment[i]['CUST_GOODS_COMMENT_REG_DT']+"</span>" +
                            "<div class=\"star-grade-box\">" +
                            "<span class=\"star-rating spr-common\"><span class=\"star-ico spr-common\" style=\"width:"+comment[i]['TOTAL_GRADE_VAL']*20+"%\"></span></span>" +
                            "</div>" +
                            "<div class=\"prd-assessment-link\">" +
                            "<p class=\"prd-assessment-txt\">"+comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').substring(0,300).replace(/(\n|\r\n)/g, '<br>')+
                            "<span class=\"prd-assessment-txt\" style=\"display: none;\" id=\"hidContents"+idx+"\">"+comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').substring(300).replace(/(\n|\r\n)/g, '<br>')+"</span>" +
                            "</p>";

                        if(comment[i]['CONTENTS'].replace(/<br\s*[\/]?>/gi, '\n').length > 300){
                            comment_temp += "<ul class=\"media-common-btn-list\">" +
                                "<li class=\"media-common-btn-item\"><a href=\"javaScript://\" class=\"btn-prd-order-detail\" onclick=\"javaScript:folding_contents('M', "+idx+")\" id=\"fold_btn"+idx+"\">더보기</a></li>" +
                                "</ul>";
                        }

                        comment_temp += "<br/><p class=\"prd-assessment-name\">"+comment[i]['GOODS_OPTION_NM']+"</p>";


                        if( (comment[i]['CUST_NO'] != null) && (comment[i]['CUST_NO'] == '<?=$this->session->userdata('EMS_U_NO_')?>') ){
                            comment_temp += "<ul class=\"media-common-btn-list\">" +
                                "<li class=\"media-common-btn-item\"><a href=\"#layerPrdCommentModify\" class=\"btn-prd-order-detail\" onclick=\"javaScript:modify_comment_layer("+comment[i]['CUST_GOODS_COMMENT']+")\">수정</a></li>"+
                                "<li class=\"media-common-btn-item\"><a href=\"javaScript:;\" class=\"btn-prd-order-detail\" onclick=\"javaScript:delete_comment("+comment[i]['CUST_GOODS_COMMENT']+")\">삭제</a></li>" +
                                "</ul>";
                        }


                        comment_temp += "</div>" +
                            "<div class=\"prd_review\" id=\"prd_review\">" +
                            "<ul>" +
                            "<li class=\"list\">" +
                            "<ul class=\"detail\">";

                        if(comment[i]['FILE_PATH']){
                            for(var j=0;j<comment[i]['FILE_PATH'].length;j++){
                                comment_temp += "<li>" +
                                    "<span class=\"hide\">"+idx+"_"+j+"</span>" +
                                    "<a class=\"view\" href=\"#pro"+idx+"_"+j+"\">" +
                                    "<img src=\""+comment[i]['FILE_PATH'][j]['FILE_PATH']+"\" alt=\"\">" +
                                    "</a>" +
                                    "</li>";
                            }
                        }

                        comment_temp += "</ul>" +
                            "<div class=\"summary\">" +
                            "<div class=\"summarybg\">";

                        if(comment[i]['FILE_PATH']){
                            for(var p=0;p<comment[i]['FILE_PATH'].length;p++){
                                comment_temp += "<div id=\"pro"+idx+"_"+p+"\" class=\"product\">" +
                                    "<div class=\"list_img\">" +
                                    "<img src=\""+comment[i]['FILE_PATH'][p]['FILE_PATH']+"\" alt=\"\">" +
                                    "</div>" +
                                    "</div>";
                            }
                        }

                        comment_temp += "</div>" +
                            "</div>" +
                            "</li>" +
                            "</ul>" +
                            "</div>" +
                            "</li>";


						idx --;
					}


					var strHtmlPag = makePaginationHtml_Comment(page, next, limit_num);
					$("#comment_pagination").remove();
					$("#comment_pagination_position").append(strHtmlPag);

					var page_c = page % 5;
					if(page_c == 0){	//클래스 입힐 페이지의 위치를 알아내기 위해
						page_c = 5;
					}

					$("#comment_body").html(comment_temp);
					$("div#comment_pagination li.page-num-item:nth-child("+pre_page+")").removeClass('active');		//이전페이지 클래스 삭제
					if(next == 0){
						$("div#comment_pagination li.page-num-item:nth-child("+page_c+")").addClass('active');			//현재페이지 위치에 클래스 적용
					} else {
						page_c ++;
						$("div#comment_pagination li.page-num-item:nth-child("+page_c+")").addClass('active');			//현재페이지 위치에 클래스 적용
					}
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

	strHtmlPag+="<div class=\"page\" id=\"comment_pagination\">";

	strHtmlPag+="<ul class=\"page-num-list\">";

	if(nextPage != 0){
		strHtmlPag+="<li class=\"page-num-item page-num-left\"><a class=\"page-num-link\" href=\"javascript:$('input[name=next_C]').val(parseInt($('input[name=next_C]').val())-1); jsPaging_Comment("+parseInt(5*nextPage)+");\"></a></li>";
	}

	if(parseInt(5*nextPage+1) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+1)+");\">"+parseInt(5*nextPage+1)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+2) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+2)+");\">"+parseInt(5*nextPage+2)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+3) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+3)+");\">"+parseInt(5*nextPage+3)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+4) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+4)+");\">"+parseInt(5*nextPage+4)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+5) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging_Comment("+parseInt(5*nextPage+5)+");\">"+parseInt(5*nextPage+5)+"</a></li>";
	} else {
		next = 'N';
	}

	if(currPage != totalPage && totalPage > 5 && next != 'N'){
		strHtmlPag+="<li class=\"page-num-item page-num-right\"><a class=\"page-num-link\" href=\"javascript:$('input[name=next_C]').val(parseInt($('input[name=next_C]').val())+1); jsPaging_Comment("+parseInt(5*nextPage+6)+");\"></a></li>";
	}

	strHtmlPag+="</ul>";
	strHtmlPag+="</div>";

	return strHtmlPag;
}

</script>

<script>
    //=====================================
    // 상품평 내용 더보기
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

    //====================================
    // 상품평 수정 레이어
    //====================================
    function modify_comment_layer(comment_no){

        $.ajax({
            type: 'GET',
            url: '/mywiz/update_goods_comment',
            dataType: 'json',
            data: { comment_no : comment_no},
            error: function(res) {
                alert('Database Error');
            },
            async : false,
            success: function(res) {
                if(res.status == 'ok'){
                    $("#modify_comment").html(res.modify_comment);

                }
                else alert(res.message);
            }
        });

        $('#layerPrdCommentModify').addClass('common-layer-wrap--view');
    }

    //=====================================
    // 상품평 삭제하기
    //=====================================
    function delete_comment(comment_cd){
        if(confirm("상품평을 삭제하시겠습니까?")){
            $.ajax({
                type: 'POST',
                url: '/mywiz/delete_goods_comment',
                dataType: 'json',
                data: {  comment_cd:comment_cd},
                error: function(res) {
                    alert('Database Error');
                },
                success: function(res) {
                    if(res.status == 'ok'){
                        alert("삭제되었습니다.");
                        location.reload();
                    }
                    else alert(res.message);
                }
            });
        }
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