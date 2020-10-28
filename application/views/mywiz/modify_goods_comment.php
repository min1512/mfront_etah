<form id="updFileEdit" name="updFileEdit" method="post"  enctype="multipart/form-data">
<!-- 상품평 수정하기 레이어 // -->
<div class="common-layer-wrap layer-prd-comment-modify" id="layerPrdCommentModify">
    <!-- common-layer-wrap--view 추가 -->
    <h3 class="common-layer-title">상품평 수정하기</h3>

    <!-- common-layer-content // -->
    <div class="common-layer-content">
        <div class="media-area prd-order-media">
            <input type="hidden" name="comment_cd" value="<?=$comment['CUST_GOODS_COMMENT']?>">
            <span class="media-area-img prd-order-media-img"><img src="<?=$comment['IMG_URL']?>" alt=""></span>
            <span class="media-area-info prd-order-media-info">
							 <span class="prd-order-media-info-brand">[<?=$comment['BRAND_NM']?>]</span>
							<span class="prd-order-media-info-name"><?=$comment['GOODS_NM']?> - <?=$comment['GOODS_OPTION_NM']?></span>
							</span>
        </div>
        <ul class="prd-comment-write-star">
            <?if(strlen($comment['GRADE_VAL']) == 1){?>
                <li class="prd-comment-write-star-item">
                    <span class="title">만족도</span>
                    <ul class="star-grade-select" id="grade01">
                        <li id="comment_05_1" name="comment_05" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 1 ? "active" : ""?>"></li>
                        <li id="comment_05_2" name="comment_05" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 2 ? "active" : ""?>"></li>
                        <li id="comment_05_3" name="comment_05" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 3 ? "active" : ""?>"></li>
                        <li id="comment_05_4" name="comment_05" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 4 ? "active" : ""?>"></li>
                        <li id="comment_05_5" name="comment_05" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 5 ? "active" : ""?>"></li>
                    </ul>
                </li>
                <input type="hidden" id="grade5" name="grade5" value="<?=$comment['GRADE_VAL1']?>">
            <?}else{?>
                <li class="prd-comment-write-star-item">
                    <span class="title">품질</span>
                    <ul class="star-grade-select" id="grade02">
                        <li id="comment_01_1" name="comment_01" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 1 ? "active" : ""?>"></li>
                        <li id="comment_01_2" name="comment_01" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 2 ? "active" : ""?>"></li>
                        <li id="comment_01_3" name="comment_01" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 3 ? "active" : ""?>"></li>
                        <li id="comment_01_4" name="comment_01" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 4 ? "active" : ""?>"></li>
                        <li id="comment_01_5" name="comment_01" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL1'] >= 5 ? "active" : ""?>"></li>
                    </ul>
                </li>
                <li class="prd-comment-write-star-item">
                    <span class="title">배송</span>
                    <ul class="star-grade-select" id="grade05">
                        <li id="comment_02_1" name="comment_02" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL2'] >= 1 ? "active" : ""?>"></li>
                        <li id="comment_02_2" name="comment_02" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL2'] >= 2 ? "active" : ""?>"></li>
                        <li id="comment_02_3" name="comment_02" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL2'] >= 3 ? "active" : ""?>"></li>
                        <li id="comment_02_4" name="comment_02" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL2'] >= 4 ? "active" : ""?>"></li>
                        <li id="comment_02_5" name="comment_02" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL2'] >= 5 ? "active" : ""?>"></li>
                    </ul>
                </li>
                <li class="prd-comment-write-star-item">
                    <span class="title">가격</span>
                    <ul class="star-grade-select" id="grade03">
                        <li id="comment_03_1" name="comment_03" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL3'] >= 1 ? "active" : ""?>"></li>
                        <li id="comment_03_2" name="comment_03" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL3'] >= 2 ? "active" : ""?>"></li>
                        <li id="comment_03_3" name="comment_03" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL3'] >= 3 ? "active" : ""?>"></li>
                        <li id="comment_03_4" name="comment_03" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL3'] >= 4 ? "active" : ""?>"></li>
                        <li id="comment_03_5" name="comment_03" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL3'] >= 5 ? "active" : ""?>"></li>
                    </ul>
                </li>
                <li class="prd-comment-write-star-item">
                    <span class="title">디자인</span>
                    <ul class="star-grade-select" id="grade04">
                        <li id="comment_04_1" name="comment_04" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL4'] >= 1 ? "active" : ""?>"></li>
                        <li id="comment_04_2" name="comment_04" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL4'] >= 2 ? "active" : ""?>"></li>
                        <li id="comment_04_3" name="comment_04" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL4'] >= 3 ? "active" : ""?>"></li>
                        <li id="comment_04_4" name="comment_04" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL4'] >= 4 ? "active" : ""?>"></li>
                        <li id="comment_04_5" name="comment_04" class="star-grade-select-item spr-common spr-star <?=$comment['GRADE_VAL4'] >= 5 ? "active" : ""?>"></li>
                    </ul>
                </li>
                <input type="hidden" id="grade1" name="grade1" value="<?=$comment['GRADE_VAL1']?>">
                <input type="hidden" id="grade2" name="grade2" value="<?=$comment['GRADE_VAL2']?>">
                <input type="hidden" id="grade3" name="grade3" value="<?=$comment['GRADE_VAL3']?>">
                <input type="hidden" id="grade4" name="grade4" value="<?=$comment['GRADE_VAL4']?>">
            <?}?>
        </ul>
        <!--<div class="form-line form-line--wide">
							<div class="form-line-info">
								<label><input type="text" class="input-text"  name="title" value="<?=$comment['TITLE']?>"></label>
							</div>
						</div>-->
        <input type="hidden" name="title" value="<?=$comment['TITLE']?>">
        <div class="form-line form-line--wide">
            <div class="form-line-info">
                <label>
                    <textarea type="text" class="input-text input-text--textarea" name="comment"><?=str_replace('<br />',"\n",$comment['CONTENTS'])?></textarea>
                </label>
            </div>
        </div>

        <!-- 첨부파일 이미지 // -->
        <div class="form-line form-line--wide" id="tblFileUpload2">
            <input type="hidden" name="comment_cd"  value="<?=$comment['CUST_GOODS_COMMENT']?>"> <!-- 상품평 코드 -->
            <input type="hidden" name="fileGb"      value="<?=(!empty($comment['FILE_PATH']))?"isEx":""?>"> <!-- 기존파일 유무 -->

            <?
            if(!empty($comment['FILE_PATH'])) {
                $idx = 0;
                foreach ($comment['FILE_PATH'] as $file) {
                    ?>
                    <div class="form-line form-line--wide" name="cmrow2[]">
                        <div class="form-line-info">
                            <div class="file-upload">
                                <input type="hidden" name="file_no2[]" value="<?=$file['CUST_GOODS_COMMENT_FILE_PATH_NO']?>"> <!-- 첨부파일 번호 -->
                                <span class="file-upload-title">첨부</span>
                                <input class="input-text" id="file_url2_<?=$idx?>" name="file_url2[]" value="<?=$file['FILE_PATH']?>" placeholder="파일선택" readonly>
                                <a href="javaScript:jsDel(<?=$idx?>)" class="spr-btn_delete plus" title="이미지삭제"></a>
                                <label for="fileUpload2_<?=$idx?>" class="btn-white btn-white--bold">파일찾기</label>
                                <input type="file" id="fileUpload2_<?=$idx?>" class="upload-hidden" onChange="javaScript:viewFileUrl(this, <?=$idx?>);" name="fileUpload2[]">
                                <button class="file_puls_btn" onclick="return false;"><img src="/assets/images/sprite/btn_plus.png" alt="" onclick="javaScript:jsAdd();"></button>
                            </div>
                        </div>
                    </div>
                    <?
                    $idx++;
                }
            }else{?>
                <div class="form-line form-line--wide" name="cmrow2[]">
                    <div class="form-line-info">
                        <div class="file-upload">
                            <input type="hidden" name="file_no2[]" value=""> <!-- 첨부파일 번호 -->
                            <span class="file-upload-title">첨부</span>
                            <input class="input-text" id="file_url2_0" name="file_url2[]" value="" placeholder="파일선택" readonly>
                            <a href="javaScript:jsDel(0)" class="spr-btn_delete plus" title="이미지삭제"></a>
                            <label for="fileUpload2_0" class="btn-white btn-white--bold">파일찾기</label>
                            <input type="file" id="fileUpload2_0" class="upload-hidden" onChange="javaScript:viewFileUrl(this, 0);" name="fileUpload2[]">
                            <button class="file_puls_btn" onclick="return false;"><img src="/assets/images/sprite/btn_plus.png" alt="" onclick="javaScript:jsAdd();"></button>
                        </div>
                    </div>
                </div>
            <?}?>
        </div>
        <!-- // 첨부파일 이미지 -->
        <ul class="text-list">
            <li class="text-item">JPG, GIF 파일만 2MB까지 업로드 가능합니다.</li>
        </ul>
        <ul class="common-btn-box common-btn-box--layer">
            <li class="common-btn-item"><a href="javaScript:;" class="btn-gray-link" onClick="javaScript:document.getElementById('layerPrdCommentModify').className = 'common-layer-wrap layer-prd-comment-modify';">수정취소</a></li>
            <li class="common-btn-item"><a href="javaScript:;" class="btn-black-link" onClick="javaScript:modify_comment();">수정하기</a></li>
        </ul>
    </div>
    <!-- // common-layer-content -->

    <a href="javaScript:;" class="btn-layer-close" onClick="javaScript:document.getElementById('layerPrdCommentModify').className = 'common-layer-wrap layer-prd-comment-modify';"><span class="hide">닫기</span></a>
</div>
<!-- // 상품평 수정하기 레이어 -->
</form>


<script>

    //별점
    $('.star-grade-select-item').on('click', function()
    {
        var str = this.id;
        var name = this.attributes['name'].value;

        if ($(this).hasClass('active'))
        {
            $(this).removeClass('active');
            $(this).nextAll().removeClass('active');

            if(name == 'comment_01') {
                $("#grade1").val(str.substring(str.length - 1) - 1);
            } else if(name == 'comment_02') {
                $("#grade2").val(str.substring(str.length - 1) - 1);
            } else if(name == 'comment_03') {
                $("#grade3").val(str.substring(str.length - 1) - 1);
            } else if(name == 'comment_04') {
                $("#grade4").val(str.substring(str.length - 1) - 1);
            } else if(name == 'comment_05') {
                $("#grade5").val(str.substring(str.length - 1) - 1);
            }
        }
        else
        {
            $(this).addClass('active');
            $(this).prevAll().addClass('active');

            if(name == 'comment_01') {
                $("#grade1").val(str.substring(str.length - 1));
            } else if(name == 'comment_02') {
                $("#grade2").val(str.substring(str.length - 1));
            } else if(name == 'comment_03') {
                $("#grade3").val(str.substring(str.length - 1));
            } else if(name == 'comment_04') {
                $("#grade4").val(str.substring(str.length - 1));
            } else if(name == 'comment_05') {
                $("#grade5").val(str.substring(str.length - 1));
            }
        }
    });

</script>

<script>
    //=====================================
    // trim 함수 생성
    //=====================================
    function trim(s){
        s = s.replace(/^\s*/,'').replace(/\s*$/,'');
        return s;
    }

    //=====================================
    // 파일경로 보여주기
    //=====================================
    function viewFileUrl(input, idx){
        if($("#fileUpload2_"+idx).val()){	//파일 확장자 확인
            if(!imgChk($("#fileUpload2_"+idx).val())){
                alert("jpg, gif, png 파일만 업로드 가능합니다.");

                //파일 초기화
                $("#fileUpload2_"+idx).replaceWith($("#fileUpload2_"+idx).clone(true));
                $("#fileUpload2_"+idx).val('');
                $("#file_url2_"+idx).val('');
                return false;
            }
        }

        if(input.files[0].size > 1024*5000){	//파일 사이즈 확인
            alert("파일의 최대 용량을 초과하였습니다. \n파일은 5MB(5120KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

            //파일 초기화
            $("#fileUpload2_"+idx).replaceWith($("#fileUpload2_"+idx).clone(true));
            $("#fileUpload2_"+idx).val('');
            $("#fileUpload2_"+idx).val('');
            return false;
        }
        else {
            $("#file_url2_"+idx).val($("#fileUpload2_"+idx).val());
        }

    }

    //=====================================
    // 지우기
    //=====================================
    function jsDel(idx){
        $("#file_url2_"+idx).val('');
        $("#fileUpload2_"+idx).replaceWith($("#fileUpload2_"+idx).clone(true));
        $("#fileUpload2_"+idx).val('');
    }

    //===============================================================
    // 추가이미지
    //===============================================================
    function jsAdd(){
        var index2 = document.getElementsByName("cmrow2[]").length;

        if(index2 == 5 ) {
            alert("이미지는 최대 5개까지 업로드 가능합니다.");
            return false;
        }

        $("#tblFileUpload2").append(
            "<div class=\"form-line form-line--wide\" name=\"cmrow2[]\">" +
            "<div class=\"form-line-info\">" +
            "<div class=\"file-upload\">" +
            "<span class=\"file-upload-title\">첨부</span>" +
            "<input class=\"input-text\" id=\"file_url2_"+index2+"\" name=\"file_url2[]\" value=\"\" placeholder=\"파일선택\" readonly>" +
            "<a href=\"javaScript:jsDel("+index2+")\" class=\"spr-btn_delete plus\" title=\"이미지삭제\"></a>" +
            "<label for=\"fileUpload2_"+index2+"\" class=\"btn-white btn-white--bold\">파일찾기</label>" +
            "<input type=\"file\" id=\"fileUpload2_"+index2+"\" class=\"upload-hidden\" onChange=\"javaScript:viewFileUrl(this, "+index2+");\" name=\"fileUpload2[]\">" +
            "<button class=\"file_puls_btn\" onclick=\"return false;\"><img src=\"/assets/images/sprite/btn_plus.png\" alt=\"\" onclick=\"javaScript:jsAdd();\"></button>" +
            "</div>" +
            "</div>" +
            "</div>"
        )
    }

    //=======================================
    // 확장자 체크 함수 생성
    //=======================================
    function imgChk(str){
        var pattern = new RegExp(/\.(gif|jpg|jpeg|png)$/i);

        if(!pattern.test(str)) {
            return false;
        } else {
            return true;
        }
    }

    //=====================================
    // 상품평 수정하기
    //=====================================
    function modify_comment(){

        if(trim($("textarea[name=comment]").val()) == ""){
            alert("상품평을 입력해주세요.");
            $("textarea[name=comment]").focus();
            return false;
        }

        var data = new FormData($('#updFileEdit')[0]);

        if(confirm("상품평을 수정하시겠습니까?")){
            $.ajax({
                type: 'POST',
                url: '/mywiz/update_goods_comment',
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
                        alert("수정되었습니다.");
                        location.reload();
                    }
                    else alert(res.message);
                }
            });
        }
    }
</script>