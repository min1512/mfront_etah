<form id="updFile" name="updFile" method="post" enctype="multipart/form-data">
    <div class="common-layer-wrap layer-prd-comment-modify" id="layerPrdCommentModify"> <!-- common-layer-wrap--view 추가 -->
        <h3 class="common-layer-title">상품평 작성하기</h3>
        <!-- common-layer-content // -->
        <div class="common-layer-content">
            <input type="hidden" name="goods_code" value="<?=$goods['GOODS_CD']?>">
            <div class="media-area prd-order-media">
                <span class="media-area-img prd-order-media-img"><img src="<?=$goods['IMG_URL']?>" alt=""></span>
                <span class="media-area-info prd-order-media-info">
                                    <span class="prd-order-media-info-brand">[<?=$goods['BRAND_NM']?>]</span>
                                    <span class="prd-order-media-info-name"><?=$goods['GOODS_NM']?> - <?=$goods['GOODS_OPTION_NM']?></span>
                                </span>
            </div>
            <ul class="prd-comment-write-star">
                <?if($goods['CLASS_NO'] != NULL){?>
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
                    <li class="prd-comment-write-star-item">
                        <span class="title">배송</span>
                        <ul class="star-grade-select" id="grade02">
                            <li id="comment_02_1" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_02_2" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_02_3" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_02_4" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_02_5" name="comment_02" class="star-grade-select-item spr-common spr-star"></li>
                        </ul>
                    </li>
                    <li class="prd-comment-write-star-item">
                        <span class="title">가격</span>
                        <ul class="star-grade-select" id="grade03">
                            <li id="comment_03_1" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_03_2" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_03_3" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_03_4" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_03_5" name="comment_03" class="star-grade-select-item spr-common spr-star"></li>
                        </ul>
                    </li>
                    <li class="prd-comment-write-star-item">
                        <span class="title">디자인</span>
                        <ul class="star-grade-select" id="grade04">
                            <li id="comment_04_1" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_04_2" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_04_3" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_04_4" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                            <li id="comment_04_5" name="comment_04" class="star-grade-select-item spr-common spr-star"></li>
                        </ul>
                    </li>
                <?}?>
            </ul>
            <div class="form-line form-line--wide">
                <div class="form-line-info">
                    <label>
                        <textarea type="text" class="input-text input-text--textarea" name="comment_contents" id="comment_contents" placeholder=" * 20자 이상 구매평을 남겨주셔야 등록이 가능합니다.
 * 텍스트 구매평 1000점 마일리지 / 사진 추가시 2000점 마일리지
 * 후기하고 관련 된 상품의 사진 아니면 마일리지 추후 차감 될수 있습니다.
 * 구매평 적립 제외 : 상품평 금액 기준 구매금액 5,000원 미만인 경우 작성에 대한 마일리지 적립이 제외 됩니다.
 * 동일상품에 대한 구매평 적립혜택은 1회로 제한 되며 적립후 30일 경과시 구매평 적립혜택을 다시 받을수 있습니다. "></textarea>
                    </label>
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
                <li class="text-item">JPG, GIF 파일만 5MB까지 업로드 가능합니다.</li>
            </ul>
            <ul class="common-btn-box common-btn-box--layer">
                <li class="common-btn-item"><a href="javaScript:;" class="btn-gray-link" onClick="javaScript:document.getElementById('layerPrdCommentModify').className = 'common-layer-wrap cart-coupon-layer';">취소</a></li>
                <li class="common-btn-item"><a href="javaScript:;" class="btn-black-link" onclick="javaSCript:write_comment();">등록하기</a></li>
            </ul>
        </div>
        <!-- // common-layer-content -->

        <a href="javaScript:;" class="btn-layer-close" onClick="javaScript:document.getElementById('layerPrdCommentModify').className = 'common-layer-wrap cart-coupon-layer';"><span class="hide">닫기</span></a>
    </div>
</form>

<script src="/assets/js/common.js"></script>
<script type="text/javascript">
    //===============================================================
    // 별점
    //===============================================================
    $('.star-grade-select-item').on('click', function()
    {
        if ($(this).hasClass('active'))
        {
            $(this).removeClass('active');
            $(this).nextAll().removeClass('active');
        }
        else
        {
            $(this).addClass('active');
            $(this).prevAll().addClass('active');
        }
    });

    $(function(){
        $("#grade01").on('click', function(e) {
            var idx = 1;														//상품평의 별 갯수 체크하기 위한 인덱스
            var comment_grade_val01	= 0;										//상품평(품질)
            $("li[name='comment_01']").each(function() {
                if($("#comment_01_"+idx).attr('class') == 'star-grade-select-item spr-common spr-star active'){
                    comment_grade_val01 ++;
                }
                idx ++;
            });
            $("input[name='grade_val01']").val(comment_grade_val01);
        })
    });

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

    //=====================================
    // 상품평 수정하기
    //=====================================
    function write_comment(){
        var data = new FormData($('#updFile')[0]);

        var comment_goods_code	= $("input[name=goods_code]").val();		//상품코드
        var comment_contents	= $("#comment_contents").val();				//상품평 내용
        var comment_grade_val01 = $("input[name='grade_val01']").val();		//상품평(품질)
        var comment_grade_val02 = $("input[name='grade_val02']").val();		//상품평(배송)
        var comment_grade_val03 = $("input[name='grade_val03']").val();		//상품평(가격)
        var comment_grade_val04 = $("input[name='grade_val04']").val();		//상품평(디자인)
        var comment_grade_val05 = $("input[name='grade_val05']").val();		//상품평(만족도)

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

        $.ajax({
            type: 'POST',
            url: '/mywiz/comment_regist',
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

</script>