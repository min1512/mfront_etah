<input type="hidden" id="goods_code"	name="goods_code"	value="<?=$goods_code?>">	<!--상품코드-->
<input type="hidden" id="pre_page"		name="pre_page"		value="<?=$page?>">			<!--초기엔 현재 페이지, 후엔 이전 페이지 -->
<input type="hidden" id="limit_num"		name="limit_num"	value="<?=$limit_num?>">	<!--한 페이지에 보여주는 갯수-->
<input type="hidden" id="total_cnt"		name="total_cnt"	value="<?=$total_cnt?>">	<!--전체 문의글 갯수-->
<input type="hidden" id="totla_page"	name="total_page"	value="<?=$total_page?>">	<!--전체 페이지 수-->
<input type="hidden" id="next"			name="next"			value='0'>					<!--페이징 다음 누를시 1씩 증가-->

<ul class="prd-qna-list" id="qna_body">
	<?  $i = $total_cnt;
		if($i != 0){
			foreach($goods_qna as $row)	{	?>
	<li class="prd-qna-item">
		<!-- 활성화 시 클래스 active 추가 -->
		<!-- 질문//-->
		<div class="prd-question-box">
			<span class="prd-ico">Q</span>
			<dl class="prd-question">
				<dt class="prd-question-tlt">
				<? if($row['SECRET_YN'] == 'Y'){	?>
					<span class="spr-common ico-lock" title="비공개질문"></span>
				<? }?>
				[<?=$row['ANSWER_YN']?>]<?=$row['Q_TITLE']?>
				</dt>
                <? if( ($row['SECRET_YN'] != 'Y') || ($row['SECRET_YN'] == 'Y' && $row['REAL_ID'] == $this->session->userdata('EMS_U_ID_')) ){ ?>
                    <dd class="prd-question-txt"><?=$row['Q_CONTENTS']?></dd>
                <?} else{?>
                    <dd class="prd-question-txt">비밀글입니다.</dd>
                <?}?>
			</dl>
			<span class="prd-question-nick"><?=substr($row['CUST_ID'],0,3)."****"?></span>
			<span class="prd-question-date"><?=substr($row['REG_DT'],0,10)?></span>
			<? if($row['A_CONTENTS']){
					if($row['SECRET_YN'] == 'Y' && $row['REAL_ID'] != $this->session->userdata('EMS_U_ID_')){?>
					<a href="#" onClick="javascript:alert('비밀글은 작성자만 조회할 수 있습니다.');" class="btn-prd-answere"><span class="none"></span></a>
                    <?} else {?>
                        <a href="#" class="btn-prd-answere"></a>
                    <?}
				}?>
		</div>
		<!-- //질문 -->

		<!-- 답변// -->
		<div class="prd-answere-box">
			<span class="prd-ico">A</span>
			<p class="prd-answere-txt"><?=$row['A_CONTENTS']?>
			</p>
			<span class="prd-question-nick">판매자</span>
			<span class="prd-question-date"><?=substr($row['ANSWER_REG_DT'],0,10)?></span>
		</div>
		<!-- //답변 -->
	</li>
	<? $i--;
			}
		} else {	?>
			<li class="prd-qna-item">
				<div class="prd-question-box">
				<dl class="prd-question">
					<dd class="prd-question-txt">
						등록 된 상품문의가 없습니다.
					</dd>
				</dl>
				</div>
			</li>
		<? }?>
</ul>
<!-- 페이징 // -->
<div class="position_area" id="qna_pagination_position">
<div class="page" id="qna_pagination">
	<ul class="page-num-list">
		<? if(0 < $total_cnt){	?>
<!--		<li class="page-num-item page-num-left page-num-double-left">
			<a href="#" class="page-num-link"></a>
		</li>
		<li class="page-num-item page-num-left">
			<a href="#" class="page-num-link"></a>
		</li>	-->
		<? $total_page = ceil($total_cnt/$limit_num);
			if(1 <= $total_page){	?>
		<li class="page-num-item active">
			<a href="javascript:jsPaging(1);" class="page-num-link">1</a>
		</li>
		<? }
			if(2 <= $total_page){	?>
		<li class="page-num-item">
			<a href="javascript:jsPaging(2);" class="page-num-link">2</a>
		</li>
		<? }
			if(3 <= $total_page){	?>
		<li class="page-num-item">
			<a href="javascript:jsPaging(3);" class="page-num-link">3</a>
		</li>
		<? }
			if(4 <= $total_page){	?>
		<li class="page-num-item">
			<a href="javascript:jsPaging(4);" class="page-num-link">4</a>
		</li>
		<? }
			if(5 <= $total_page){	?>
		<li class="page-num-item">
			<a href="javascript:jsPaging(5);" class="page-num-link">5</a>
		</li>
		<? }
			if($total_page != 1 && $total_page > 5){	?>
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
<!-- // 페이징  -->
<ul class="common-btn-box">
	<li class="common-btn-item"><a id="bb" href="#prdInquiryWrite" class="btn-vip-write" data-ui="vip-layer"><span class="arrow">상품 문의하기</span></a></li>
</ul>

<!-- 상품 문의하기 레이어 // -->
<div class="write-layer prd-inquiry-write" id="prdInquiryWrite">
	<h4 class="write-layer-title">상품 문의하기</h4>
	<div class="write-layer-content">
		<div class="form-line form-line--wide title-input">
			<div class="form-line-info">
				<label class="form-line-title" for="MemcustomerPrdTitleForm_1_1">제목</label>
				<input type="text" class="input-text" id="MemcustomerPrdTitleForm_1_1" name="qna_title" placeholder="문의하실 내용의 제목을 입력하세요.">
			</div>
		</div>
		<div class="form-line form-line--wide prd-comment-write-textarea">
			<div class="form-line-info">
				<textarea class="input-text input-text--textarea" placeholder="문의내용을 입력해 주세요." id="qna_contents"></textarea>
			</div>
		</div>
		<p class="form-line">
			<input type="checkbox" id="AnswereCheck2" class="checkbox" name="qna_secret" value="N">
			<label for="AnswereCheck2" class="checkbox-label">비밀글로 문의하기 (판매자와 본인만 확인 가능합니다.)</label>
		</p>
	</div>
	<ul class="common-btn-box">
		<li class="common-btn-item"><a href="#prdInquiryWrite" class="btn-white btn-white--big" data-ui="vip-layer-close">취소</a></li>
		<li class="common-btn-item"><a href="javascript:jsQna();" class="btn-black btn-black--big">등록하기</a></li>
	</ul>
	<a href="#prdInquiryWrite" class="btn-close" data-ui="vip-layer-close"><span class="hide">레이어 닫기</span></a>
</div>
<!-- // 상품 문의하기 레이어 -->


<script type="text/javascript">
//===============================================================
// 상품평쓰기 버튼을 누를 시, 로그인 상태 체크
//===============================================================
$(function(){
	$("#bb").on('click', function(e) {
		var SESSION_ID = "<?=$this->session->userdata('EMS_U_ID_')?>";

		if(SESSION_ID == '' || SESSION_ID == 'GUEST' || SESSION_ID == 'TMP_GUEST'){
			if(confirm("로그인 후 상품 문의가 가능합니다. \n로그인하시겠습니까?")){
				location.href = "https://<?=$_SERVER['HTTP_HOST']?>/member/login";
			} else {
				setTimeout(function(){
					$("#bb").removeClass();
					$("#bb").addClass('btn-vip-write');
					$("#prdInquiryWrite").hide();
				}, 1);
			}
		}
	})
})


//===============================================================
// 상품 문의하기
//===============================================================
function jsQna(){
	var qna_goods_code	= $("input[name=goods_code]").val();
	var qna_title		= $("input[name=qna_title]").val();
	var qna_contents	= $('#qna_contents').val();
	var qna_type		= "GOODS";
	var mem_id			= "<?=$this->session->userdata('EMS_U_ID_')?>";

	if( ! qna_title ){
		alert('문의 제목을 입력하시기 바랍니다.');
		$("input[name=qna_title]").focus();
		return false;
	}
//alert(qna_contents);
	if ( ! qna_contents ){
		alert('문의 내용을 입력하시기 바랍니다.');
		$('#qna_contents').focus();
		return false;
	}

	if ($("input[name=qna_secret]").is(':checked') == true)
	{
		$("input[name=qna_secret]").val('Y');
	}

	var qna_secret		= $("input[name=qna_secret]").val();

	$.ajax({
		type: 'POST',
		url: '/mywiz/qna_regist',
		dataType: 'json',
		data: {goods_code : qna_goods_code, title : qna_title, contents : qna_contents, qna_type : qna_type, mem_id : mem_id, secret_yn : qna_secret},
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
function jsPaging(page){
	var goods_code  = $("input[name=goods_code]").val();		//상품코드
	var pre_page	= $("input[name=pre_page]").val();			//이전페이지
	var total_cnt	= $("input[name=total_cnt]").val();			//전체 갯수
	var limit_num	= $("input[name=limit_num]").val();			//한 페이지당 보여줄 갯수
	var idx			= total_cnt - limit_num * (page - 1);		//순번 역순
	var next		= $('input[name=next]').val();				//다음페이지를 만들지 말지 비교를 위한 변수
	var session_id	= "<?=$this->session->userdata('EMS_U_ID_')?>";

	$.ajax({
			type: 'POST',
			url: '/goods/qna_paging',
			dataType: 'json',
			data: {goods_code : goods_code, page : page, limit : limit_num},
			error: function(res) {
				alert('Database Error');
				alert(res.responseText);
			},
			success: function(res) {
				if(res.status == 'ok'){
					var qna = res.qna;
					var qna_temp = "";

					for(var i=0; i<qna.length; i++){
						qna_temp += "<li class=\"prd-qna-item\"><div class=\"prd-question-box\"><span class=\"prd-ico\">Q</span><dl class=\"prd-question\"><dt class=\"prd-question-tlt\">";
						if(qna[i]['SECRET_YN'] == 'Y'){
							qna_temp += "<span class=\"spr-common ico-lock\" title=\"비공개질문\"></span>";
						}
						qna_temp += "["+qna[i]['ANSWER_YN']+"]"+qna[i]['Q_TITLE']+"</dt>";
						qna_temp += "<dd class=\"prd-question-txt\">"+qna[i]['Q_CONTENTS']+"</dd></dl>";
						qna_temp += "<span class=\"prd-question-nick\">"+qna[i]['CUST_ID']+"</span>";
						qna_temp += "<span class=\"prd-question-date\">"+qna[i]['REG_DT']+"</span>";

						if(qna[i]['A_CONTENTS']){
							if(qna[i]['SECRET_YN'] == 'Y' && qna[i]['REAL_ID'] != session_id){
								qna_temp += "<a href=\"#\" onClick=\"javascript:alert('비밀글은 작성자만 조회할 수 있습니다.');\" class='btn-prd-answere'><span class='none'></span></a>";
							} else {
								qna_temp += "<a href=\"#\" class='btn-prd-answere'></a>";
							}
							qna_temp += "</div>";
							qna_temp += "<div class=\"prd-answere-box\"><span class=\"prd-ico\">A</span><p class=\"prd-answere-txt\">"+qna[i]['A_CONTENTS']+"</p>";
							qna_temp += "<span class=\"prd-question-nick\">판매자</span>";
							qna_temp += "<span class=\"prd-question-date\">"+qna[i]['ANSWER_REG_DT']+"</span>";
							qna_temp += "</div>";
						} else {
						qna_temp += "</div>";
						}
						qna_temp += "</li>";


//						qna_temp += "<tr id=\"open_qna"+idx+"\" class=\"\"><td>"+idx+"</td> <td>"+qna[i]['ANSWER_YN']+"</td><td class=\"comment\"> ";
//						if(qna[i]['SECRET_YN'] == 'Y' && qna[i]['REAL_ID'] != session_id){
//							qna_temp += "<a href=\"javascript:alert('비밀글은 작성자만 조회할 수 있습니다.');\" class=\"link\">";
//						} else {
//							qna_temp += "<a href=\"javascript:jsOpen("+idx+");\" class=\"link\">";
//						}
//
//						if(qna[i]['SECRET_YN'] == 'Y'){
//							qna_temp += "<span class=\"spr-common spr-ico-lock\"></span>";
//						}
//
//						qna_temp += qna[i]['Q_TITLE']+"</a> </td> <td>"+qna[i]['CUST_ID']+"</td> <td>"+qna[i]['REG_DT']+"</td> </tr> <tr class=\"reply\"> <td colspan=\"5\">"+qna[i]['Q_CONTENTS'];
//
//						if(qna[i]['A_CONTENTS']){
//							qna_temp += "<br /><br />[답변]<br />";
//							qna_temp += qna[i]['A_CONTENTS'];
//						}
//						qna_temp += "</td> </tr>";

						idx --;
					}

					var strHtmlPag = makePaginationHtml(page, next, limit_num);
					$("#qna_pagination").remove();
					$("#qna_pagination_position").append(strHtmlPag);

					var page_c = page % 5;
					if(page_c == 0){	//클래스 입힐 페이지의 위치를 알아내기 위해
						page_c = 5;
					}

					$("#qna_body").html(qna_temp);

					$("div#qna_pagination li.page-num-item:nth-child("+pre_page+")").removeClass('active');		//이전페이지 클래스 삭제

					if(next == 0){
						$("div#qna_pagination li.page-num-item:nth-child("+page_c+")").addClass('active');			//현재페이지 위치에 클래스 적용
					} else {
						page_c ++;
						$("div#qna_pagination li.page-num-item:nth-child("+page_c+")").addClass('active');			//현재페이지 위치에 클래스 적용
					}

					$("input[name=pre_page]").val(page);		//페이지 이동 전의 페이지 저장


				}
				else alert(res.message);
			}
		})
}

/****************************/
/* 페이징 HTML 만들기 함수  */
/****************************/
function makePaginationHtml(currPage, nextPage, limitNum){
	var strHtmlPag	= "";
	var totalPage	= $("input[name=total_page]").val();
	var next = "";	//다음페이지를 만들지 말지 비교를 위한 변수

	strHtmlPag+="<div class=\"page\" id=\"qna_pagination\">";

	strHtmlPag+="<ul class=\"page-num-list\">";

	if(nextPage != 0){
		strHtmlPag+="<li class=\"page-num-item page-num-left\"><a class=\"page-num-link\" href=\"javascript:$('input[name=next]').val(parseInt($('input[name=next]').val())-1); jsPaging("+parseInt(5*nextPage)+");\"></a></li>";
	}

	if(parseInt(5*nextPage+1) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging("+parseInt(5*nextPage+1)+");\">"+parseInt(5*nextPage+1)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+2) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging("+parseInt(5*nextPage+2)+");\">"+parseInt(5*nextPage+2)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+3) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging("+parseInt(5*nextPage+3)+");\">"+parseInt(5*nextPage+3)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+4) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging("+parseInt(5*nextPage+4)+");\">"+parseInt(5*nextPage+4)+"</a></li>";
	} else {
		next = 'N';
	}

	if(parseInt(5*nextPage+5) <= totalPage){
		strHtmlPag+="<li class=\"page-num-item\"><a class=\"page-num-link\" href=\"javascript:jsPaging("+parseInt(5*nextPage+5)+");\">"+parseInt(5*nextPage+5)+"</a></li>";
	} else {
		next = 'N';
	}

	if(currPage != totalPage && totalPage > 5 && next != 'N'){
		strHtmlPag+="<li class=\"page-num-item page-num-right\"><a class=\"page-num-link\" href=\"javascript:$('input[name=next]').val(parseInt($('input[name=next]').val())+1); jsPaging("+parseInt(5*nextPage+6)+");\"></a></li>";
	}

	strHtmlPag+="</ul>";
	strHtmlPag+="</div>";

	return strHtmlPag;
}

</script>