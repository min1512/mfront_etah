					<!-- 1:1문의수정하기 레이어 // -->
					<div class="common-layer-wrap layer-inquire-modify" id="layerInquireModify">
						<!-- common-layer-wrap view 추가 -->
						<h3 class="common-layer-title">1:1문의 수정하기</h3>
						<form id="updFile" name="updFile" method="post"  enctype="multipart/form-data">
						<!-- common-layer-content // -->
						<div class="common-layer-content">
							<!-- 1:1문의(회원) // -->
							<div class="form-line form-line--wide">
								<div class="select-box select-box--big">
									<select class="select-box-inner" name="type">
										<option value="">상세구분선택</option>
										<?foreach($qna_type as $qrow){?>
										<option value="<?=$qrow['CS_QUE_TYPE_CD']?>" <?=$qrow['CS_QUE_TYPE_CD'] = $qna['CS_QUE_GB_CD'] ? "selected" : ""?>><?=$qrow['CS_QUE_TYPE_CD_NM']?></option>
										<?}?>
									</select>
								</div>
							</div>
							<div class="form-line form-line--wide">
								<div class="form-line-info form-line-info--prd">
									<?if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
									<label class="form-line-info-label"><input type="text" class="input-text input-text-prd-name" value="<?=$qna['GOODS_NM']?>" name="goods_nm"></label>
									<a href="#orderPrdLayer" class="btn-white btn-white--bold" onClick="javaScript:$('#orderPrdLayer').addClass('common-layer-wrap--view');">주문상품조회</a>
									<?}?>
									<input type="hidden" name="goods_cd">
									<input type="hidden" name="order_refer_no">
								</div>
							</div>
							<div class="form-line form-line--wide">
								<div class="form-line-info">
									<label><input type="text" class="input-text" name="name" value="<?=$qna['QUE_CUST_NM']?>"></label>
								</div>
							</div>
							<div class="form-line form-line--wide">
								<div class="form-line-info">
									<label><input type="tel" class="input-text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="phone" value="<?=$qna['QUE_CUST_PHONE_NO']?>"></label>
								</div>
							</div>
							<div class="form-line form-line--wide form-line--cols">
								<div class="form-line-info">
									<div class="form-line--cols-item">
										<label><input type="text" class="input-text" placeholder="이메일" name="email" value="<?=explode('@',$qna['EMAIL'])[0]?>"></label>
									</div>
									<span class="dash">@</span>
									<div class="form-line--cols-item">
										<div class="select-box select-box--big">
											<label for="emailAddressSelect">이메일주소선택</label>
											<select class="select-box-inner" id="emailAddressSelect" data-ui="select-val" onChange="javaScript:if(this.value != '직접입력'){ $('input[name=email2]').val(this.value);}else{$('input[name=email2]').val('');}" >
												<option value="">선택</option>
												<option value="직접입력">직접입력</option>
												<option value="naver.com" <? if(explode('@',$qna['EMAIL'])[1] == 'naver.com'){?>selected<?}?>>naver.com</option>
												<option value="hotmail.com" <? if(explode('@',$qna['EMAIL'])[1] == 'hotmail.com'){?>selected<?}?>>hotmail.com</option>
												<option value="nate.com"  <? if(explode('@',$qna['EMAIL'])[1] == 'nate.com'){?>selected<?}?>>nate.com</option>
												<option value="yahoo.co.kr" <? if(explode('@',$qna['EMAIL'])[1] == 'yahoo.co.kr'){?>selected<?}?>>yahoo.co.kr</option>
												<option value="paran.com" <? if(explode('@',$qna['EMAIL'])[1] == 'paran.com'){?>selected<?}?>>paran.com</option>
												<option value="empas.com" <? if(explode('@',$qna['EMAIL'])[1] == 'empas.com'){?>selected<?}?>>empas.com</option>
												<option value="dreamwiz.com" <? if(explode('@',$qna['EMAIL'])[1] == 'dreamwiz.com'){?>selected<?}?>>dreamwiz.com</option>
												<option value="freechal.com" <? if(explode('@',$qna['EMAIL'])[1] == 'freechal.com'){?>selected<?}?>>freechal.com</option>
												<option value="lycos.co.kr" <? if(explode('@',$qna['EMAIL'])[1] == 'lycos.com'){?>selected<?}?>>lycos.co.kr</option>
												<option value="korea.com" <? if(explode('@',$qna['EMAIL'])[1] == 'korea.com'){?>selected<?}?>>korea.com</option>
												<option value="gmail.com" <? if(explode('@',$qna['EMAIL'])[1] == 'gmail.com'){?>selected<?}?>>gmail.com</option>
												<option value="hanmir.com" <? if(explode('@',$qna['EMAIL'])[1] == 'hanmir.com'){?>selected<?}?>>hanmir.com</option>
											</select>
											<label for="emailAddressInput">이메일 주소 직접 입력</label>
											<span class="email-address-input" style="display:none;"><input type="text" class="input-text" id="emailAddressInput" name="email2" value=<?=explode('@',$qna['EMAIL'])[1]?>></span>
										</div>
									</div>
								</div>
							</div>

							<div class="inquire-choice-box">
								<ul class="text-list">
									<li class="text-item">답변 수신방법을 선택하세요.</li>
								</ul>
								<ul class="login-check-list">
									<li class="login-check-item">
										<input type="checkbox" id="AnswereCheck1" class="checkbox" checked="checked" name="sms_yn" <?=$qna['SMS_REPLAY_YN'] == 'Y' ? "checked" : ""?>>
										<label for="AnswereCheck1" class="checkbox-label">SMS 로 답변 수신</label>
									</li>
									<li class="login-check-item">
										<input type="checkbox" id="AnswereCheck2" class="checkbox" checked="checked" name="email_yn" <?=$qna['EMAIL_REPLAY_YN'] == 'Y' ? "checked" : ""?>>
										<label for="AnswereCheck2" class="checkbox-label">이메일로 답변 수신</label>
									</li>
								</ul>
							</div>
							<div class="form-line form-line--wide">
								<div class="form-line-info">
									<label><input type="text" class="input-text"  name="title" value="<?=$qna['TITLE']?>"></label>
								</div>
							</div>
							<div class="form-line form-line--wide">
								<div class="form-line-info">
									<label>
										<textarea type="text" class="input-text input-text--textarea" name="content"><?=$qna['CONTENTS']?></textarea>
									</label>
								</div>
							</div>

							<div class="form-line form-line--wide">
								<div class="form-line-info">
									<div class="file-upload">
										<span class="file-upload-title">첨부</span>
										<input class="input-text" name="file_url" value="<?=$qna['FILE_PATH']?>" placeholder="파일선택" disabled>
										<label for="exFilename" class="btn-white btn-white--bold">파일찾기</label>
										<input type="file" id="exFilename" class="upload-hidden" onChange="javaScript:viewFileUrl(this);" name="fileUpload">
										<input type="hidden" name="qna_no" value="<?=$qna_no?>">
										<input type="hidden" name="file_url_yn" value="N">
									</div>
								</div>
							</div>
							<ul class="text-list">
								<li class="text-item">JPG, GIF 파일만 2MB까지 업로드 가능합니다.</li>
							</ul>
							<!-- // 1:1문의(회원) -->
							<ul class="common-btn-box common-btn-box--layer">
								<li class="common-btn-item"><a href="javaScript:;" class="btn-gray-link" onClick="javaScript:document.getElementById('layerInquireModify').className = 'common-layer-wrap layer-inquire-modify';">수정취소</a></li>
								<li class="common-btn-item"><a href="javaScript:;" class="btn-black-link" onClick="javaSCript:modify_qna();">수정하기</a></li>
							</ul>
							<!-- // common-layer-button -->
						</div>
						<!-- // common-layer-content -->
						</form>

						<a href="javaScript:;" class="btn-layer-close" onClick="javaScript:document.getElementById('layerInquireModify').className = 'common-layer-wrap layer-inquire-modify';"><span class="hide">닫기</span></a>
					</div>

					<!-- // 1:1문의수정하기 레이어 -->

					<!-- 주문상품조회 레이어 // -->
				<div class="common-layer-wrap order-prd-layer cart-coupon-layer" id="orderPrdLayer">
					<h3 class="common-layer-title">주문상품 조회</h3>

					<!-- common-layer-content // -->
					<div class="common-layer-content">
						<div class="basic-table-wrap">
							<table class="basic-table">
								<colgroup>
									<col style="width:30%;">
									<col style="width:47%;">
									<col style="width:23%;">
								</colgroup>
								<tr>
									<th scope="row" class="tb-info-title">주문번호</th>
									<th scope="row" class="tb-info-title">상품명</th>
									<th scope="row" class="tb-info-title">선택</th>
								</tr>
								<tbody id="order_table">
								<?if($order){
									foreach($order as $orow){?>
								<tr>
									<td class="tb-info-txt"><?=$orow['ORDER_NO']?></td>
									<td class="tb-info-txt"><?=$orow['GOODS_NM']?></td>
									<td class="tb-info-txt">
										<label class="common-radio-label" for="joinGenderCheck1">
										<input type="radio" id="joinGenderCheck1" class="common-radio-btn" name="order_refer" value="<?=$orow['ORDER_REFER_NO']."||".$orow['GOODS_CD']."||".$orow['GOODS_NM']?>">
									</td>
								</tr>
								<?	}
								}else{?>
								<tr>
									<td colspan="4">주문내역이 없습니다.</td>
								</tr>
								<?}?>
								</tbody>
							<!--<tr>
									<td class="tb-info-txt">100000073</td>
									<td class="tb-info-txt">[버플리]버플리 원목 2700거실장 세트(무도장)</td>
									<td class="tb-info-txt">
										<input type="checkbox" id="checkAgree2" class="checkbox">
										<label for="checkAgree2" class="checkbox-label"></label>
									</td>
								</tr>
								<tr>
									<td class="tb-info-txt">100000073</td>
									<td class="tb-info-txt">[버플리]버플리 원목 2700거실장 세트(무도장)</td>
									<td class="tb-info-txt">
										<input type="checkbox" id="checkAgree3" class="checkbox">
										<label for="checkAgree3" class="checkbox-label"></label>
									</td>
								</tr>-->
							</table>
						</div>
						<br/><br/>
						<!-- 페이징 // -->
						<div class="page page--prd" id="page_test">
							<ul class="page-num-list">
								
								<!--<li class="page-num-item page-num-left">
									<a href="#" class="page-num-link"></a>
								</li>-->
								<li class="page-num-item active">
									<a href="#" class="page-num-link">1</a>
								</li>
								<?for($i=2; $i<=$cnt_page; $i++){?>
								<li class="page-num-item">
									<a href="javaScript:orderPageNavigation(<?=$i?>);" class="page-num-link"><?=$i?></a>
								</li>
								<?
								}
								if($total_page > 5){?>
								<li class="page-num-item page-num-right">
									<a href="#" class="page-num-link"></a>
								</li>
								<?}?>
								
							</ul>
						</div>
						<!-- // 페이징  -->
						<div class="common-layer-button">
							<ul class="common-btn-box common-btn-box--layer">
								<li class="common-btn-item"><a href="javaScript:chkCancel();" class="btn-gray-link">적용취소</a></li>
								<li class="common-btn-item"><a href="javaScript:chkOrder($('input:radio[name=order_refer]:checked').val());" class="btn-black-link">상품적용</a></li>
							</ul>
						</div>
						<!-- // common-layer-button -->
					</div>
					<!-- // common-layer-content -->

					<a href="#" class="btn-layer-close" onClick="javaScript:document.getElementById('orderPrdLayer').className = 'common-layer-wrap order-prd-layer cart-coupon-layer';"><span class="hide">닫기</span></a>
				</div>

			<!-- // 주문상품조회 레이어 -->


			<script>
			//====================================
			// 주문내역 페이징
			//====================================
			function openOrderGoods(){
				$('#orderPrdLayer').attr('class','common-layer-wrap--view order-prd-layer cart-coupon-layer');
			}
			//====================================
			// 주문내역 페이징
			//====================================
			function orderPageNavigation( page ){
				var totalPage = "<?=$total_page?>",
					endPage = Math.ceil(page/5)*5,
					startPage = endPage-4,
					active = "";

				if(endPage > totalPage){
					endPage = totalPage;
//					startPage = Math.ceil(page%5);
				}

//				alert(page%5);

//				alert(startPage);

				$.ajax({
					type: 'POST',
					url: '/customer/order_page',
					dataType: 'json',
					data: { page : page},
					error: function(res) {
						alert('Database Error');
					},
					success: function(res) {
						if(res.status == 'ok'){
//							alert(res.result[0]['SELLING_PRICE'].replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,'));
//							alert(Math.ceil(0.																																							2));
							var str_result = "";
							var str_page = "";
							var pre	= "<li class='page-num-item page-num-left'><a href=\"javaScript:orderPageNavigation("+(page-1)+");\" class='page-num-link'></li>";
							var next = "<li class='page-num-item page-num-right'><a href=\"javaScript:orderPageNavigation("+(page+1)+");\" class='page-num-link'></li>";

							if(page == 1) pre = "";
							if(totalPage <= page) next = "";

							for(i=0; i<res.order.length; i++){

//								str_result += "<tr> <td><input type='radio' name='order_refer' value='"+res.order[i]['ORDER_REFER_NO']+"||"+res.order[i]['GOODS_CD']+"||"+res.order[i]['GOODS_NM']+"'></td> <td><a href='#' class='link'>"+res.order[i]['ORDER_NO']+"<br/>("+res.order[i]['REG_DT']+")</a></td> <td class='image'><img src='"+res.order[i]['IMG_URL']+"' alt='' width='100' height='100'/></td> <td class='goods_detail__string'> <p class='name'>"+res.order[i]['GOODS_NM']+"</p> <p class='description'>"+res.order[i]['PROMOTION_PHRASE']+"</p> <p class='option'>"+res.order[i]['GOODS_OPTION_NM']+"</p> </td> </tr>";

								str_result += "<tr>	<td class='tb-info-txt'>"+res.order[i]['ORDER_NO']+"</td> <td class='tb-info-txt'>"+res.order[i]['GOODS_NM']+"</td>	<td class='tb-info-txt'><label class='common-radio-label' for='joinGenderCheck1'><input type='radio' id='joinGenderCheck1' class='common-radio-btn' name='order_refer' value='"+res.order[i]['ORDER_REFER_NO']+"||"+res.order[i]['GOODS_CD']+"||"+res.order[i]['GOODS_NM']+"'></td> </tr>";
							}
							str_page = "<ul class='page-num-list'>"+pre;
							for(idx=startPage; idx<=endPage ; idx++){
								if(page == idx){
									active = "active";
								}else{
									active = "";
								}

								str_page += "<li class='page-num-item "+active+"'><a href='javaScript:orderPageNavigation("+idx+");' class='page-num-link'>"+idx+"</a></li>";
							}

							str_page += next+"</ul>";

//

							$("#page_test").html(str_page);
							$("#order_table").html(str_result);

						}
						else alert(res.message);
					}
				});
			}

			//=====================================
			// 상품선택(주문선택)
			//=====================================
			function chkOrder(val){
				if(!val){
					alert("적용하실 상품을 선택해주세요.");
					return false;
				}
				arr_value = val.split("||");
				$("input[name=goods_nm]").val(arr_value[2]);
				$("input[name=goods_cd]").val(arr_value[1]);
				$("input[name=order_refer_no]").val(arr_value[0]);

				$('#orderPrdLayer').attr('class','common-layer-wrap order-prd-layer cart-coupon-layer');
//				alert($("input[name=goods_nm]").val());


			}

			//=====================================
			// 선택취소
			//=====================================
			function chkCancel(){
				$('#orderPrdLayer').attr('class','common-layer-wrap order-prd-layer cart-coupon-layer');

			}

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
			function viewFileUrl(input){
				if(input.files[0].size > 1024*2000){
					alert("파일의 최대 용량을 초과하였습니다. \n파일은 2MB(2048KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

					//파일 초기화
					$("#fileUpload").replaceWith($("#fileUpload").clone(true));
                    $("#fileUpload").val('');
					return false;
				}
				else {
					$("input[name=file_url]").val($("input[name=fileUpload]").val());
				}

			}

			//=====================================
			//패스워드검사,이메일
			//=====================================
			function f_is_alpha( it ){

				//영문 숫자 조합
				var alpha ='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				var numeric = '1234567890';
				var blank = ' ';
				var nonkorean = alpha+numeric;
				var i ;
				var t = it.value ;
				for ( i=0; i<t.length; i++ )

					if( nonkorean.indexOf(t.substring(i,i+1)) < 0) {
						break ;
					}

				if ( i != t.length ) {
					return true;
				}

				return false;
			}

			function test(){
				alert($("#flUpload")[0].files[0].size);
//				if( input.files[0].size > (1024*500) ) {
//					alert("파일 최대용량을 초과하였습니다. \n파일은 500KB 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");
//
//					preImg.attr('src', '');
//					input.value="";
//					file.replaceWith( file.clone(true) );
//					return;
//				}
			}

			//=======================================
			// 확장자 체크 함수 생성
			//=======================================
			function imgChk(str){
				var pattern = new RegExp(/\.(gif|jpg|jpeg)$/i);

				if(!pattern.test(str)) {
					return false;
				} else {
					return true;
				}
			}

			//=======================================
			// 한글 체크 함수 생성
			//=======================================
			function korChk(str){
				var pattern = new RegExp(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/);

				return pattern.test(str);
			}

			//====================================
			// 문의작성
			//====================================
			function modify_qna(){
				var data = new FormData($('#updFile')[0]);

				if(trim($("select[name=type]").val()) == ""){
					alert("문의 상세 구분을 선택해주세요.");
					$("select[name=type]").focus();
					return false;
				}
				if(trim($("input[name=name]").val()) == ""){
					alert("문의자 이름을 입력해주세요.");
					$("input[name=name]").focus();
					return false;
				}
				if(trim($("input[name=phone]").val()) == ""){
					alert("연락처를 입력해주세요.");
					$("input[name=phone]").focus();
					return false;
				}
				if( ! trim($("input[name=email]").val()) ){
					alert("이메일을 입력해 주십시오.");
					$("input[name=email]").focus();
					return false;
				}
//				if(updFile.email.value.indexOf("@") < 1 || updFile.email.value.indexOf(".") < 3) {
//					alert("올바른 이메일 주소가 아닙니다.");
//					updFile.email.value = "";
//					updFile.email.focus();
//					return false;
//				}
				if(	$("input[name=email2]").val() == "" && document.getElementById("emailAddressSelect").value == ""){
					alert("이메일을 선택해주세요.");
					$("input[name=email2]").focus();
					return false;
				} 
				if(trim($("input[name=title]").val()) == ""){
					alert("문의 제목을 입력해주세요.");
					$("input[name=title]").focus();
					return false;
				}
				if(trim($("textarea[name=content]").val()) == ""){
					alert("문의 내용을 입력해주세요.");
					$("textarea[name=content]").focus();
					return false;
				}
				if($("input[name=file_url]").val()){
					if(!imgChk($("input[name=file_url]").val())){
						alert("jpg, gif 파일만 업로드 가능합니다.");
						return false;
					}
				}

				if(confirm("1:1문의를 수정하시겠습니까?")){
				
					$.ajax({
						type: 'POST',
						url: '/customer/modify_qna',
//						dataType: 'json',
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
//									location.href="/customer/qna_finish";
							}
							else alert(res.message);
						},
						error: function(res) {
							alert(res);
			//				console.log(res.responseText);
							alert(res.responseText);
			//				btn.button('reset');
			//				btn2.button('reset');
			//				jsHiddenDel();
							return false;
						}
					});
				}
			}