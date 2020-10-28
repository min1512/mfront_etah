<form name="updCommentForm" id="updCommentForm" method="post" enctype="multipart/form-data">
    <!--댓글 수정하기 레이어 // -->
    <div class="common-layer-wrap layer-prd-comment-modify common-layer-wrap--view" id="layerPrdCommentModify"> <!-- common-layer-wrap--view 추가 -->
        <h3 class="common-layer-title">댓글 수정하기</h3>

        <input type="hidden" name="gubun" id="gubun" value="B">
        <input type="hidden" name="comment_no" id="comment_no" value="<?=$comment['COMMENT_NO']?>">

        <!-- common-layer-content // -->
        <div class="common-layer-content">
            <!--            <div class="media-area prd-order-media">-->
            <!--                <span class="media-area-img prd-order-media-img"><img src="../assets/images/data/data_100x100.jpg" alt=""></span>-->
            <!--                <span class="media-area-info prd-order-media-info">-->
            <!--                            <span class="prd-order-media-info-brand">[해오름가구] 버플리 원목 레시아 렌지대 [해오름가구] 버플리 원목 레시아 렌지대</span>-->
            <!--                            <span class="prd-order-media-info-name">[움브라] 줄라 링 브라스 - 고양이 [움브라] 줄라 링 브라스 - 고양이</span>-->
            <!--                        </span>-->
            <!--            </div>-->
            <div class="form-line form-line--wide">
                <div class="form-line-info">
                    <label>
                        <textarea type="text" class="input-text input-text--textarea" id="comment_txt" name="comment_txt"><?=$comment['CONTENTS']?></textarea>
                    </label>
                </div>
            </div>

            <div class="form-line form-line--wide">
                <div class="form-line-info">
                    <div class="file-upload">
                        <span class="file-upload-title">첨부</span>
                        <input class="input-text" placeholder="파일찾기로 첨부할 이미지를 선택하세요." readonly name="file_url2" id="file_url2" value="<?=$comment['FILE_PATH']?>">
                        <a href="javaScript:jsDel2()" class="spr-btn_delete" title="이미지삭제"></a>
                        <label for="fileUpload2" class="btn-white btn-white--bold">파일찾기</label>
                        <input type="file" id="fileUpload2" name="fileUpload2" class="upload-hidden" onChange="javaScript:viewFileUrl2(this);">
                    </div>
                </div>
            </div>
            <ul class="text-list">
                <li class="text-item">JPG, GIF 파일만 2MB까지 업로드 가능합니다.</li>
            </ul>
            <ul class="common-btn-box common-btn-box--layer">
                <li class="common-btn-item"><a href="javaScript:comment_layer_close()" class="btn-gray-link" data-close="bottom-layer-close2">수정취소</a></li>
                <li class="common-btn-item"><a href="javaScript:comment_layer_update()" class="btn-black-link">수정하기</a></li>
            </ul>
        </div>
        <!-- // common-layer-content -->

        <a href="javaScript:comment_layer_close()" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
    </div>
    <!-- //댓글 수정하기 레이어 -->
</form>


<script>
    //===============================================================
    // 파일경로 보여주기
    //===============================================================
    function viewFileUrl2(input){
        if($("input[name=fileUpload2]").val()){	//파일 확장자 확인
            if(!imgChk2($("input[name=fileUpload2]").val())){
                alert("jpg, gif 파일만 업로드 가능합니다.");

                //파일 초기화
                $("#fileUpload2").replaceWith($("#fileUpload2").clone(true));
                $("#fileUpload2").val('');
                $("input[name=file_url2]").val('');
                return false;
            }
        }

        if(input.files[0].size > 1024*2000){	//파일 사이즈 확인
            alert("파일의 최대 용량을 초과하였습니다. \n파일은 2MB(2048KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

            //파일 초기화
            $("#fileUpload2").replaceWith($("#fileUpload2").clone(true));
            $("#fileUpload2").val('');
            $("input[name=file_url2]").val('');
            return false;
        }
        else {
            $("input[name=file_url2]").val($("input[name=fileUpload2]").val());
        }
    }

    //===============================================================
    // 지우기
    //===============================================================
    function jsDel2(){
        $("#fileUpload2").replaceWith($("#fileUpload2").clone(true));
        $("#fileUpload2").val('');
        $("input[name=file_url2]").val('');
    }

    //===============================================================
    // 확장자 체크 함수 생성
    //===============================================================
    function imgChk2(str){
        var pattern = new RegExp(/\.(gif|jpg|jpeg)$/i);

        if(!pattern.test(str)) {
            return false;
        } else {
            return true;
        }
    }

    function comment_layer_close()
    {
        $('#layerPrdCommentModify').removeClass('common-layer-wrap--view');
    }

    //===============================================================
    // 매거진 댓글 수정
    //===============================================================
    //매거진 이벤트 상세페이지 댓글 수정
    function comment_layer_update(){
        var data = new FormData($('#updCommentForm')[0]);

        $.ajax({
            type: 'POST',
            url: '/magazine/comment_update',
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
                    alert('수정되었습니다.');
                    location.reload();
                }
                else console.log(res.message);
            }
        })
    }
</script>