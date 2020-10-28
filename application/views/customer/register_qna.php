			<link rel="stylesheet" href="/assets/css/vip.css">
			<link rel="stylesheet" href="/assets/css/customert_center.css?var=1.1">
			
			<div class="content">
				<h2 class="page-title-basic">고객센터</h2>

				<!-- FAQ, 1:1문의, 묻고 답하기, 공지사항 // -->
				<div class="tab-customer-center">
					<!-- tab영역// -->
                    <ul class="tab-common-list">
                        <li class="tab-common-btn"><a href="/customer/faq" class="tab-common-btn-link">FAQ</a></li>
                        <li class="tab-common-btn active"><a href="#InquireTab" class="tab-common-btn-link" data-ui="btn-tab">1:1문의</a></li>
<!--                        <li class="tab-common-btn"><a href="/customer/qna_list_all" class="tab-common-btn-link">묻고 답하기</a></li>-->
                        <li class="tab-common-btn"><a href="/customer/notice" class="tab-common-btn-link">공지사항</a></li>
                    </ul>
					<!-- //tab영역 -->

					<!-- 1:1문의(회원) // -->
                    <div id="InquireTab" class="inquire-content-wrap">
						<h3 class="info-title info-title--sub">1:1 문의하기</h3>

						<form id="updFile" name="updFile" method="post"  enctype="multipart/form-data">
                            <div class="login-form login-form--modify">
                                <div class="form-line">
                                    <div class="select-box select-box--big">
                                        <select class="select-box-inner" name="type">
                                            <option value="">상세구분선택</option>
                                            <?foreach($qna_type as $qrow){?>
                                                <option value="<?=$qrow['CS_QUE_TYPE_CD']?>"><?=$qrow['CS_QUE_TYPE_CD_NM']?></option>
                                            <?}?>
                                        </select>
                                    </div>
                                </div>
                                <?if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
                                    <div class="form-line form-line--modify form-line--modify--prd-name">
                                        <div class="form-line-info form-line-info--prd">
                                            <label class="form-line-title" for="MemcustomerPrdNameForm_1_1">상품명</label>
                                            <input type="text" id="fileName" class="input-text input-text-prd-name" name="goods_nm"></li>
                                            <a href="#orderPrdLayer" class="btn-white btn-white--bold" data-layer="bottom-layer-open2">주문상품조회</a>
                                            <input type="hidden" name="goods_cd">
                                            <input type="hidden" name="order_refer_no">
                                        </div>
                                    </div>
                                <?}?>
                                <div class="form-line form-line--modify">
                                    <div class="form-line-info">
                                        <label class="form-line-title" for="MemcustomerNameForm_1_1">이름</label>
                                        <input type="text" class="input-text" id="MemcustomerNameForm_1_1" placeholder="성함을 입력하세요." name="name">
                                    </div>
                                </div>
                            </div>

                            <div class="inquire-choice-box">
                                <div class="form-line form-line--modify">
                                    <div class="form-line-info">
                                        <label class="form-line-title" for="MemcustomerPhoneForm_1_1">연락처</label>
                                        <input type="number" class="input-text" id="MemcustomerPhoneForm_1_1" placeholder="숫자만입력" name="phone" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
                                    </div>
                                </div>

                                <div class="form-line">
                                    <ul class="check-text-list">
                                        <li class="check-text-item">
                                            <input type="checkbox" id="AnswereCheck1" class="checkbox" name="sms_yn" value="Y">
                                            <label for="AnswereCheck1" class="checkbox-label">SMS 로 답변 수신</label>
                                        </li>
                                        <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
                                            <li class="check-text-item">
                                                <input type="checkbox" id="AnswereCheck2_1" class="checkbox">
                                                <label for="AnswereCheck2_1" class="checkbox-label">개인정보 수집·이용에 동의</label>
                                                <a href="#layerPersonalInfoAgree2" class="btn-all-view-link" data-layer="bottom-layer-open2">내용보기</a>
                                            </li>
                                        <?}?>
                                    </ul>
                                </div>
                            </div>

                            <div class="inquire-choice-box">
                                <div class="form-line form-line--cols form-line--modify">
                                    <div class="form-line-info">
                                        <div class="form-line-title"><label for="orderForm_7_1">이메일</label></div>
                                        <div class="form-line--cols-item">
                                            <input type="text" class="input-text" id="orderForm_7_1" name="email">
                                        </div>
                                        <span class="dash">@</span>
                                        <div class="form-line--cols-item">
                                            <div class="select-box select-box--big">
                                                <label for="emailAddressSelect">이메일주소선택</label>
                                                <select class="select-box-inner" id="emailAddressSelect" data-ui="select-val" onChange="javaScript:if(this.value != '직접입력'){ $('input[name=email2]').val(this.value);}else{$('input[name=email2]').val('');}" >
                                                    <option value="">선택</option>
                                                    <option value="직접입력">직접입력</option>
                                                    <option value="naver.com" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'naver.com'){?>selected<?}?>>naver.com</option>
                                                    <option value="hotmail.com" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'hotmail.com'){?>selected<?}?>>hotmail.com</option>
                                                    <option value="nate.com"  <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'nate.com'){?>selected<?}?>>nate.com</option>
                                                    <option value="yahoo.co.kr" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'yahoo.co.kr'){?>selected<?}?>>yahoo.co.kr</option>
                                                    <option value="paran.com" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'paran.com'){?>selected<?}?>>paran.com</option>
                                                    <option value="empas.com" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'empas.com'){?>selected<?}?>>empas.com</option>
                                                    <option value="dreamwiz.com" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'dreamwiz.com'){?>selected<?}?>>dreamwiz.com</option>
                                                    <option value="freechal.com" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'freechal.com'){?>selected<?}?>>freechal.com</option>
                                                    <option value="lycos.co.kr" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'lycos.com'){?>selected<?}?>>lycos.co.kr</option>
                                                    <option value="korea.com" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'korea.com'){?>selected<?}?>>korea.com</option>
                                                    <option value="gmail.com" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'gmail.com'){?>selected<?}?>>gmail.com</option>
                                                    <option value="hanmir.com" <? if($this->session->userdata('EMS_U_EMAIL_') && explode('@',$this->session->userdata('EMS_U_EMAIL_'))[1] == 'hanmir.com'){?>selected<?}?>>hanmir.com</option>
                                                </select>
                                                <label for="emailAddressInput">이메일 주소 직접 입력</label>
                                                <span class="email-address-input" style="display:none;"><input type="text" class="input-text" id="emailAddressInput"  name="email2"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
                                    <input type="hidden" class="checkbox" checked="checked" name="email_yn" value="Y">
                                    <ul class="text-list">
                                        <li class="text-item">비회원 문의는 이메일로 답변을 받아보실 수 있습니다.</li>
                                    </ul>
                                <?}?>

                                <ul class="check-text-list">
                                    <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
                                        <li class="check-text-item">
                                            <input type="checkbox" id="AnswereCheck2_2" class="checkbox">
                                            <label for="AnswereCheck2_2" class="checkbox-label">개인정보 수집·이용에 동의</label>
                                            <a href="#layerPersonalInfoAgree2" class="btn-all-view-link" data-layer="bottom-layer-open2">내용보기</a>
                                        </li>
                                    <?}else{?>
                                        <li class="check-text-item">
                                            <input type="checkbox" id="AnswereCheck2" class="checkbox" name="email_yn" value="Y">
                                            <label for="AnswereCheck2" class="checkbox-label">이메일로 답변 수신</label>
                                        </li>
                                    <?}?>
                                </ul>
                            </div>

                            <div class="login-form login-form--modify">
                                <?if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
                                    <div class="form-line">
                                        <ul class="check-text-list">
                                            <li class="check-text-item">
                                                <input type="checkbox" id="AnswereCheck3" class="checkbox"	name="secret_yn" value="Y" checked>
                                                <label for="AnswereCheck3" class="checkbox-label">비밀글</label>
                                            </li>
                                        </ul>
                                    </div>
                                <?}?>

                                <div class="form-line form-line--modify">
                                    <div class="form-line-info">
                                        <label class="form-line-title" for="MemcustomerPrdTitleForm_1_1">제목</label>
                                        <input type="text" class="input-text" id="MemcustomerPrdTitleForm_1_1" placeholder="문의하실 내용의 제목을 입력하세요." name="title">
                                    </div>
                                </div>
                                <div class="form-line form-line--wide">
                                    <div class="form-line-info">
                                        <label>
                                            <textarea type="text" class="input-text input-text--textarea"  placeholder="* 문의하실 주문번호 or 상품번호를 남겨주세요." name="content"></textarea>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-line form-line--modify">
                                    <div class="form-line-info form-line-info--file">
                                        <div class="file-upload">
                                            <span class="file-upload-title">첨부</span>
                                            <input class="input-text" placeholder="파일선택" name="file_url" readonly>
                                            <a href="javaScript:jsDel()" class="spr-btn_delete" title="이미지삭제"></a>
                                            <label for="exFilename" class="btn-white btn-white--bold" style="font-size: 0.6875rem;">파일찾기</label>
                                            <input type="file" id="exFilename" class="upload-hidden" onChange="javaScript:viewFileUrl(this);" name="fileUpload">
                                        </div>
                                    </div>
                                </div>
                                <ul class="text-list">
                                    <li class="text-item">JPG, GIF 파일만 2MB까지 업로드 가능합니다.</li>
                                </ul>
                            </div>

                            <ul class="common-btn-box common-btn-box-member">
                                <li class="common-btn-item"><a href="javascript://" onClick="javaScript:register_qna();" class="btn-black btn-black--big">문의하기</a></li>
                                <li class="common-btn-item"><a href="/" class="btn-white btn-white--big">문의취소</a></li>
                            </ul>
                        </form>
					</div>
					<!-- // 1:1문의(회원) -->
				</div>
				<!-- // FAQ, 1:1문의, 묻고 답하기, 공지사항 -->

				<!-- 주문상품조회 레이어 // -->
                <?if($this->session->userdata('EMS_U_ID_') && $this->session->userdata('EMS_U_ID_') != 'GUEST'){?>
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
                                <li class="common-btn-item"><a href="javaScript:chkOrder($('input:radio[name=order_refer]:checked').val());" class="btn-black-link">상품적용</a></li>
                                <li class="common-btn-item"><a href="javaScript:chkCancel();" class="btn-gray-link">적용취소</a></li>
							</ul>
						</div>
						<!-- // common-layer-button -->
					</div>
					<!-- // common-layer-content -->

					<a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
				</div>
                <?}?>
                <!-- // 주문상품조회 레이어 -->

                <!-- 개인정보 수집·이용 동의 레이어 // -->
                <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
                    <div class="common-layer-wrap layer-personal-info-agree cart-coupon-layer" id="layerPersonalInfoAgree2">
                        <h3 class="common-layer-title">개인정보 수집·이용 동의</h3>
                        <div class="common-layer-content join-layer">
                            <div class="join-layer-txt">
                                <ul>
                                    <li>
                                        <span class="title">■ [필수] 개인정보 수집·이용 동의</span>
                                        <ul>
                                            <li class="use-clause-item">
                                                <div class="basic-table-wrap basic-table-wrap--layer">
                                                    <table class="basic-table">
                                                        <colgroup>
                                                            <col style="width:33%;">
                                                            <col style="width:33%;">
                                                            <col>
                                                        </colgroup>
                                                        <thead>
                                                        <tr>
                                                            <th scope="col" class="tb-info-title">목적</th>
                                                            <th scope="col" class="tb-info-title">항목</th>
                                                            <th scope="col" class="tb-info-title">보유기간</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td class="tb-info-txt">이용자 식벽 및 본인여부 확인</td>
                                                            <td class="tb-info-txt">성명, 아이디, 비밀번호, 비밀번호 힌트</td>
                                                            <td class="tb-info-txt">답변 등록 후 7일까지</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-info-txt">계약 이행을 위한 연락 민원<br> 등 고객 고충 처리</td>
                                                            <td class="tb-info-txt">연락처(이메일, 휴대전화번호)</td>
                                                            <td class="tb-info-txt">답변 등록 후 7일까지</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tb-info-txt">만 14세 미만 아동인지 확인</td>
                                                            <td class="tb-info-txt">법정 생년월일</td>
                                                            <td class="tb-info-txt">답변 등록 후 7일까지</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </li>
                                            <ul>
                                                <li class="use-clause-item">※ 서비스 제공을 위해서 필요한 최소한의 개인정보이므로 동의를 해 주셔야 서비스를 이용하실 수 있습니다.</li>
                                            </ul>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <div class="common-layer-button">
                                <ul class="common-btn-box common-btn-box--layer">
                                    <li class="common-btn-item"><a href="#" class="btn-gray-link" data-close="bottom-layer-close2">확인</a></li>
                                </ul>
                            </div>
                        </div>
                        <a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
                    </div>
                <?}?>
                <!-- // 개인정보 수집·이용 동의 레이어  -->

			<script>
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
							var str_result = "";
							var str_page = "";
							var pre	= "<li class='page-num-item page-num-left'><a href=\"javaScript:orderPageNavigation("+(page-1)+");\" class='page-num-link'></li>";
							var next = "<li class='page-num-item page-num-right'><a href=\"javaScript:orderPageNavigation("+(page+1)+");\" class='page-num-link'></li>";

							if(page == 1) pre = "";
							if(totalPage <= page) next = "";

							for(i=0; i<res.order.length; i++){
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
			}

			//=====================================
			// 선택취소
			//=====================================
			function chkCancel(){
				$('#orderPrdLayer').attr('class','common-layer-wrap order-prd-layer cart-coupon-layer');
				$("#etah_html").removeClass();

			}

			//=====================================
			// trim 함수 생성
			//=====================================
			function trim(s){
				s = s.replace(/^\s*/,'').replace(/\s*$/,'');
				return s;
			}

			//=====================================
			// 지우기
			//=====================================
			function jsDelete(val){
				if(val == 'G'){
					$("input[name=goods_nm]").val("");
					$("input[name=goods_cd]").val("");
					$("input[name=order_refer_no]").val("");
				}
				if(val == 'F'){
					$("input[name=file_url]").val("");
					$("input[name=fileUpload]").val("");
					$("input[name=fileUpload]").replaceWith( $("input[name=fileUpload]").clone(true) );
				}
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

            //===============================================================
            // 파일 지우기
            //===============================================================
            function jsDel(){
                $("#fileUpload").replaceWith($("#fileUpload").clone(true));
                $("#fileUpload").val('');
                $("input[name=file_url]").val('');
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
			function register_qna(){
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
                <?if(!$this->session->userdata('EMS_U_ID_') || $this->session->userdata('EMS_U_ID_') == 'GUEST'){?>
                if($("#AnswereCheck2_1").is(":checked") == false || $("#AnswereCheck2_2").is(":checked") == false){
                    alert("개인정보 수집·이용에 동의해주시기 바랍니다.");
                    return false;
                }
                <?}?>
				if(confirm("1:1문의를 등록하시겠습니까?")){
				
					$.ajax({
						type: 'POST',
						url: '/customer/register_qna',
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
								alert("등록되었습니다.");
								location.href="/customer/finish_qna";
							}
							else alert(res.message);
						},
						error: function(res) {
							alert(res);
							alert(res.responseText);
							return false;
						}
					});
				}
			}
			</script>
