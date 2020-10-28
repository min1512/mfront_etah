			<link rel="stylesheet" href="/assets/css/display.css?ver=1.2">
			<div class="content">
				<h2 class="page-title-basic">입점&#47;제휴문의</h2>
				<ol class="inquiry-office-progress">
					<li class="inquiry-office-progress-item">
						<span class="spr-common spr-ico-inquiry-01"></span>
						<span class="title">입점업체<br>문의</span>
						<span class="text">입점문의 작성</span>
					</li>
					<li class="inquiry-office-progress-item">
						<span class="spr-common spr-ico-inquiry-02"></span>
						<span class="title">담당MD 검토 후<br>연락</span>
						<span class="text">검토결과 E-Mail로<br>발송</span>
					</li>
					<li class="inquiry-office-progress-item">
						<span class="spr-common spr-ico-inquiry-03"></span>
						<span class="title">입점의뢰서<br>작성</span>
						<span class="text">회원정보 입력 및<br>구비서류를 발송</span>
					</li>
					<li class="inquiry-office-progress-item inquiry-office-progress-item--reverse">
						<span class="spr-common spr-ico-inquiry-04"></span>
						<span class="title">담당MD 승인 후<br>상품판매</span>
						<span class="text">상품 검토 후<br>판매 승인</span>
					</li>
					<li class="inquiry-office-progress-item inquiry-office-progress-item--reverse">
						<span class="spr-common spr-ico-inquiry-05"></span>
						<span class="title">계약체결 및<br>상품 업로드</span>
						<span class="text">구비서류 최종확인<br>상품 업로드</span>
					</li>
					<li class="inquiry-office-progress-item">
						<span class="spr-common spr-ico-inquiry-06"></span>
						<span class="title">담당MD<br>입점 승인</span>
						<span class="text">회원정보 검증&#47;접수된<br>구비서류 심사</span>
					</li>
				</ol>

                <form id="updFile" name="updFile" method="post"  enctype="multipart/form-data">
				<div class="inquiry-input">
					<h3 class="info-title info-title--sub">문의내용 입력</h3>
					<div class="form-line">
						<div class="form-line-title"><label for="inquiryForm_1_1">회사명</label></div>
						<div class="form-line-info">
							<input type="text" class="input-text" id="inquiryForm_1_1" name="company_nm">
						</div>
					</div>
					<div class="form-line form-line--rows">
						<div class="form-line-title"><label for="inquiryForm_2_1">사업장주소</label></div>
						<div class="form-line-info">
							<div class="form-line--rows-item position-area form-line-info-item--btn">
								<input type="text" class="input-text" id="inquiryForm_2_1" name="post_no" disabled>
								<!--<a href="#postcodeSearchLayer" class="btn-white btn-white--bold position-right" data-layer="bottom-layer-open2">우편번호 검색</a>-->
								<button type="button" class="btn-white btn-white--bold position-right" onclick="mobile_execDaumPostcode('inquiryForm_2_1','','address1','','address2');">우편번호검색</button>
							</div>
							<div id="layer_post" style="display:none;position:absolute;overflow:hidden;z-index:100;-webkit-overflow-scrolling:touch;top:100px;">
								<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:100" onclick="closeDaumPostcode()" alt="닫기 버튼">
							</div>

							<div class="form-line--rows-item" style="padding-top: 0.3125rem;">
								<label><input type="text" class="input-text" id="address1" name="address1"></label>
							</div>
							<div class="form-line--rows-item">
								<label><input type="text" class="input-text" id="address2" name="address2"></label>
							</div>
						</div>
					</div>
					<div class="form-line form-line--cols">
						<div class="form-line-title"><label for="inquiryForm_3_1">상품카테고리</label></div>
						<div class="form-line-info">
							<div class="form-line--cols-item">
								<div class="select-box select-box--big">
								<select class="select-box-inner" id="inquiryForm_3_1" name="category" onChange="javaScript:if(this.value == 'write'){ $('#disp_cate').css('display','');}else{$('#disp_cate').css('display','none');}">
									<!--<option value="">상품카테고리</option>-->
									<option value="write" checked>직접입력</option>
									<?foreach($category_list as $crow){?>
									<option value="<?=$crow['CATEGORY_DISP_NM']?>"><?=$crow['CATEGORY_DISP_NM']?></option>
									<?}?>
								</select>
								</div>
							</div>
							<div class="form-line--cols-item">
								<label><input type="text" class="input-text" name="category_write"></label>
							</div>
						</div>
					</div>
					<div class="form-line">
						<div class="form-line-title"><label for="inquiryForm_4_1">브랜드&#47;상품명</label></div>
						<div class="form-line-info">
							<input type="text" class="input-text" id="inquiryForm_4_1" name="brand_goods_nm">
						</div>
					</div>
					<div class="form-line">
						<div class="form-line-title"><label for="inquiryForm_5_1">상품&#47;회사설명</label></div>
						<div class="form-line-info">
							<textarea type="text" class="input-text input-text--textarea" id="inquiryForm_5_1" name="company_desc" placeholder="상품과 회사에 대한 설명을 입력해주세요."></textarea>
						</div>
					</div>
					<div class="form-line">
						<div class="form-line-title"><label for="inquiryForm_6_1">담당자명</label></div>
						<div class="form-line-info">
							<input type="text" class="input-text" id="inquiryForm_6_1" name="name">
						</div>
					</div>
					<div class="form-line">
						<div class="form-line-title"><label for="inquiryForm_7_1">전화번호</label></div>
						<div class="form-line-info">
							<input type="tel" class="input-text" id="inquiryForm_7_1" placeholder="연락가능한 전화번호를 입력해주세요." name="phone" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
						</div>
					</div>
					<div class="form-line">
						<div class="form-line-title"><label for="inquiryForm_8_1">이메일</label></div>
						<div class="form-line-info">
							<input type="text" class="input-text" id="inquiryForm_8_1" name="email">
						</div>
					</div>
                    <div class="form-line">
                        <div class="form-line-title"><label for="inquiryForm_9_1">사이트주소</label></div>
                        <div class="form-line-info">
                            <input type="text" class="input-text" id="inquiryForm_9_1" name="siteMapUrl">
                        </div>
                    </div>
                    <div class="form-line">
                        <div class="form-line-title"><label for="inquiryForm_10_1">파일첨부</label></div>
                        <div class="form-line-info">
                            <div class="file-upload">
                                <input class="input-text" readonly="" id="inquiryForm_10_1" placeholder="PPT, PDF 파일만 2MB까지 업로드 가능합니다." name="file_url" style="padding:0.625rem">
                                <a href="javaScript:jsDel();" class="spr-btn_delete" title="이미지삭제"></a>
                                <label for="exFilename" class="btn-white btn-white--bold">파일찾기</label>
                                <input type="file" id="exFilename" class="upload-hidden" onChange="javaScript:viewFileUrl(this);" name="fileUpload">
                            </div>
                        </div>
                    </div>
				</div>
				<h3 class="info-title info-title--sub">입점&#47;제휴문의 및 상담을 위한 정보수집동의</h3>
				<div class="inquiry-agree">
					<ul class="text-list">
						<li class="text-item">(주)에타는 개인정보보호법, 정보통신망 이용촉진 및 정보보호 등에 관한 법률 등 관련 법령 상의 개인정보보호 규정을 준수하며, 서비스 제공을 위하여 필요한 최소한의 정보만을 아래와 같이 수집 및 이용하고 있습니다.</li>
					</ul>
					<div class="basic-table-wrap basic-table-wrap--title-bg">
						<table class="basic-table">
							<colgroup>
								<col style="width:37%;">
								<col style="width:25%;">
								<col>
							</colgroup>
							<thead>
								<tr>
									<th scope="col" class="tb-info-title">수집항목</th>
									<th scope="col" class="tb-info-title">이용목적</th>
									<th scope="col" class="tb-info-title">보유기간</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="tb-info-txt">입점&#47;제휴 문의자가 입력한 회사명, 사업장주소, 담당자명, 전화번호, 이메일</td>
									<td class="tb-info-txt">입점&#47;제휴상담 및 검토</td>
									<td class="tb-info-txt">수집된 정보는 입점/제휴문의 및 상담서비스가 종료되는 시점까지</td>
								</tr>
							</tbody>
						</table>
					</div>

					<ul class="text-list">
						<li class="text-item">귀하는 개인정보제공 등에 관해 동의하지 않거나 거부할 권리가 있으며, 정보 제공을 거부하는 경우 해당 정보가 필요한 일부 서비스의 제공이 제한될 수 있습니다.</li>
					</ul>

					<div class="check-text-bg-item">
						<input type="checkbox" id="inquiryCheckForm_1_1" class="checkbox" name="chk_agree">
						<label for="inquiryCheckForm_1_1" class="checkbox-label checkbox-label--right">입점&#47;제휴문의 및 상담을 위한 개인정보를 수집하는데 동의합니다.</label>
					</div>

					<ul class="common-btn-box">
						<li class="common-btn-item"><a href="/" class="btn-white btn-white--big">문의취소</a></li>
						<li class="common-btn-item"><a href="#" class="btn-black btn-black--big" onClick="javaScript:information_submit();">문의하기</a></li>
					</ul>
				</div>
                </form>

				<!-- 주소찾기 레이어 // -->
				<div class="common-layer-wrap postcode-search-layer" id="postcodeSearchLayer">
					<h3 class="common-layer-title">주소찾기</h3>
					<div class="common-layer-content">
						<div class="common-layer-inner">
							<ul class="tab-common-list">
							<? $addr_click = 'A'; ?>
								<li class="tab-common-item active"><a href="#area-address" class="tab-common-link" data-ui="btn-tab" onClick="<? $addr_click = 'A';?>">지번주소</a></li>
								<!-- 활성화시 클래스 active추가 -->
								<li class="tab-common-item"><a href="#road-address" class="tab-common-link" data-ui="btn-tab" onClick="<? $addr_click = 'B';?>">도로명주소</a></li>
								<li class="tab-common-item"><a href="#building-address" class="tab-common-link" data-ui="btn-tab" onClick="<? $addr_click = 'C';?>">건물명</a></li>
							</ul>

							<!-- 지번주소 // -->
							<div id="area-address" class="postcode-search-form postcod-area-address" data-ui="tab-cont">
								<ul class="text-list">
									<li class="text-item">검색방법 : 시&#47;도 및 시&#47;군&#47;구 선택 후 동(읍&#47;면) + 지번 입력 예) 역삼동 737<span class="right-arrow"></span> 서울특별시 선택 후 역삼동(동명) + 737(지번)</li>
									<li class="text-item">도로명 주소가 검색되지 않은 경우는 행정안전부 새주소 안내시스템(<a class="address-link" href="http://www.juso.go.kr">http://www.juso.go.kr</a>)에서 확인하시기 바랍니다.</li>
								</ul>
								<div class="form-line form-line--top">
									<div class="form-line-title"><label for="formPostalSearch0101">시도</label></div>
									<div class="form-line-info">
										<div class="select-box select-box--big">
											<select id="formPostalSearch0101" class="select-box-inner" onChange="javascript:jsFindGungu(this.value,'01')">
												<option value="">선택</option>
												<? foreach($deliv_sido_list as $row){	?>
												<option value="<?=$row['SIDO']?>"><?=$row['SIDO']?></option>
												<? }?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-line">
									<div class="form-line-title"><label for="formPostalSearch0102">시군구</label></div>
									<div class="form-line-info">
										<div class="select-box select-box--big">
											<select id="formPostalSearch0102" class="select-box-inner" onChange="javscript:$('#formPostalSearch0103').val('');">
												<option value="">선택</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-line">
									<div class="form-line-title"><label for="formPostalSearch0103">검색어</label></div>
									<div class="form-line-info">
										<input type="text" class="input-text" id="formPostalSearch0103" placeholder="동(읍&#47;면)">
									</div>
								</div>
								<ul class="common-btn-box common-btn-box--layer">
									<li class="common-btn-item"><a href="#" onClick="javascript:jsPostnum('01');" class="btn-gray-link">검색</a></li>
								</ul>
							</div>
							<!-- // 지번주소 -->

							<!-- 도로명주소 // -->
							<div id="road-address" class="postcode-search-form postcod-area-address" data-ui="tab-cont" style="display:none">
								<div class="form-line">
									<div class="form-line-title"><label for="formPostalSearch0201">시도</label></div>
									<div class="form-line-info">
										<div class="select-box select-box--big">
											<select id="formPostalSearch0201" class="select-box-inner" onChange="javascript:jsFindGungu(this.value,'02')">
												<option value="">선택</option>
												<? foreach($deliv_sido_list as $row){	?>
												<option value="<?=$row['SIDO']?>"><?=$row['SIDO']?></option>
												<? }?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-line">
									<div class="form-line-title"><label for="formPostalSearch0202">시군구</label></div>
									<div class="form-line-info">
										<div class="select-box select-box--big">
											<select id="formPostalSearch0202" class="select-box-inner" onChange="javscript:$('#formPostalSearch0203').val(''); $('#formPostalSearch0204').val('');">
												<option value="">선택</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-line">
									<div class="form-line-title"><label for="formPostalSearch0203">도로명</label></div>
									<div class="form-line-info">
										<input type="text" class="input-text" id="formPostalSearch0203" placeholder="도로명">
									</div>
								</div>
								<div class="form-line">
									<div class="form-line-title"><label for="formPostalSearch0204">건물번호</label></div>
									<div class="form-line-info">
										<input type="text" class="input-text" id="formPostalSearch0204" placeholder="건물번호">
									</div>
								</div>
								<ul class="common-btn-box common-btn-box--layer">
									<li class="common-btn-item"><a href="#" onClick="javascript:jsPostnum('02');" class="btn-gray-link">검색</a></li>
								</ul>
							</div>
							<!-- // 도로명주소 -->

							<!-- 건물명 // -->
							<div id="building-address" class="postcode-search-form postcod-area-address" data-ui="tab-cont" style="display:none">
								<div class="form-line">
									<div class="form-line-title"><label for="formPostalSearch0301">시도</label></div>
									<div class="form-line-info">
										<div class="select-box select-box--big">
											<select id="formPostalSearch0301" class="select-box-inner" onChange="javascript:jsFindGungu(this.value,'03')">
												<option value="">선택</option>
												<? foreach($deliv_sido_list as $row){	?>
												<option value="<?=$row['SIDO']?>"><?=$row['SIDO']?></option>
												<? }?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-line">
									<div class="form-line-title"><label for="formPostalSearch0302">시군구</label></div>
									<div class="form-line-info">
										<div class="select-box select-box--big">
											<select id="formPostalSearch0302" class="select-box-inner" onChange="javscript:$('#formPostalSearch0303').val('');">
												<option value="">선택</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-line">
									<div class="form-line-title"><label for="formPostalSearch0303">검색어</label></div>
									<div class="form-line-info">
										<input type="text" class="input-text" id="formPostalSearch0303">
									</div>
								</div>
								<ul class="common-btn-box common-btn-box--layer">
									<li class="common-btn-item"><a href="#" onClick="javascript:jsPostnum('03');" class="btn-gray-link">검색</a></li>
								</ul>
							</div>
							<!-- // 건물명 -->

					<!--		<ul class="common-btn-box common-btn-box--layer">
								<li class="common-btn-item"><a href="#" onClick="javascript:jsPostnum('01');" class="btn-gray-link">검색</a></li>
							</ul>		-->

							<!-- 우편번호 검색결과 리스트(지번) // -->
							<ul class="postcode-result-list" id="postalCodeCont01" name="postalCodeCont01">
<!--								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">서울특별시 양천구 신정6동</p>
									</div>
									<a href="#" class="btn-white">선택</a>
								</li>
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">서울특별시 양천구 신정6동 동문비젼오피스텔</p>
									</div>
									<a href="#" class="btn-white">선택</a>
								</li>
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">서울특별시 양천구 신정6동 삼성쉐르빌</p>
									</div>
									<a href="#" class="btn-white">선택</a>
								</li>
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">서울특별시 양천구 신정6동 서울양천경찰서</p>
									</div>
									<a href="#" class="btn-white">선택</a>
								</li>
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">서울특별시 양천구 신정6동 신시가지 13단지아파트(1301~1333동)</p>
									</div>
									<a href="#" class="btn-white">선택</a>
								</li>
							</ul>
							<!-- // 우편번호 검색결과 리스트(지번) -->

							<!-- 우편번호 검색결과 리스트(도로명) // -->
<!--							<ul class="postcode-result-list" style="display:none">
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">경기도 의정부시 호암로 158</p>
									</div>
									<a href="#" class="btn-white">선택</a>
								</li>
							</ul>
							<!-- // 우편번호 검색결과 리스트(도로명) -->

							<!-- 우편번호 검색결과 리스트(건물명) // -->
<!--							<ul class="postcode-result-list" style="display:none">
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">경기도 의정부시 경의로146번길 81 신한주택 (의정부동 ,신한주택)</p>
									</div>
									<a href="#" class="btn-white">선택</a>
								</li>
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">경기도 의정부시 경의로146번길 81 신한주택 (의정부동 ,신한주택)</p>
									</div>
									<a href="#" class="btn-white">선택</a>
								</li>
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">경기도 의정부시 경의로146번길 81 신한주택 (의정부동 ,신한주택)</p>
									</div>
									<a href="#" class="btn-white">선택</a>
								</li>
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">경기도 의정부시 경의로146번길 81 신한주택 (의정부동 ,신한주택)</p>
										<a href="#" class="btn-white">선택</a>
									</div>
								</li>
								<li class="postcode-result-item">
									<div class="address-box">
										<span class="area-postocode">446-025</span>
										<p class="area-address">경기도 의정부시 경의로146번길 81 신한주택 (의정부동 ,신한주택)</p>
										<a href="#" class="btn-white">선택</a>
									</div>
								</li>	-->
							</ul>
							<!-- // 우편번호 검색결과 리스트(건물명) -->
						</div>
						<a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
					</div>
				</div>


			<script>

            //=======================================
            // URL 형식 체크 함수 생성
            //=======================================
            function urlChk(str){
                var pattern = new RegExp(/^(((http(s?))\:\/\/)?)([0-9a-zA-Z\-]+\.)+[a-zA-Z]{2,6}(\:[0-9]+)?(\/\S*)?$/);

                if(!pattern.test(str)) {
                    return false;
                } else {
                    return true;
                }
            }

			//====================================
			// 문의하기
			//====================================
			function information_submit(){
                var data = new FormData($('#updFile')[0]);
                data.append("post_no", $('input[name=post_no]').val());
                data.append("address1", $('input[name=address1]').val());

				var company_nm = $('input[name=company_nm]').val(), 
					post_no = $('input[name=post_no]').val(),
					address1 = $('input[name=address1]').val(),
					address2 = $('input[name=address2]').val(),
					category = $('select[name=category]').val(),
					name = $('input[name=name]').val(),
					phone = $('input[name=phone]').val(),
					email = $('input[name=email]').val(),
					category_write = $('input[name=category_write]').val(),
					brand_goods_nm = $('input[name=brand_goods_nm]').val(),
					company_desc = $('textarea[name=company_desc]').val(),
                    siteMapUrl = $('input[name=siteMapUrl]').val();;

				if(company_nm == ""){
					alert("회사명을 입력해주세요.");
					$('input[name=company_nm]').focus();
					return false;
				}
				if((post_no == "")||(address1 == "")){
					alert("주소를 입력해주세요.");
					$('input[name=post_no]').focus();
					return false;
				}
				if(address2 == ""){
					alert("상세주소를 입력해주세요.");
					$('input[name=address2]').focus();
					return false;
				}
				if(category == ""){
					alert("카테고리를 선택해주세요.");
					$('select[name=category]').focus();
					return false;
				}else if(category == "write"){
					if(category_write == ""){
						alert("카테고리를 입력해주세요.");
						$('input[name=category_write]').focus();
						return false;
					}
				}
				if(brand_goods_nm == ""){
					alert("브랜드/상품명 입력해주세요.");
					$('input[name=brand_goods_nm]').focus();
					return false;
				}
				if(company_desc == ""){
					alert("상품/회사설명을 입력해주세요.");
					$('textarea[name=company_desc]').focus();
					return false;
				}
				if(name == ""){
					alert("담당자명을 입력해주세요.");
					$('input[name=name]').focus();
					return false;
				}
				if(phone == ""){
					alert("전화번호를 입력해주세요.");
					$('input[name=phone]').focus();
					return false;
				}
				if(email == ""){
					alert("이메일을 입력해주세요.");
					$('input[name=email]').focus();
					return false;
				}
				if(email.indexOf("@") < 1 || email.indexOf(".") < 3) {
					alert("올바른 이메일 주소가 아닙니다.");
//					updFile.email.value = "";
					$('input[name=email]').focus();
					return false;
				}
                if(siteMapUrl != ""){
                    if(!urlChk(siteMapUrl)){
                        alert("사이트주소URL을 다시 확인하십시오!");
                        $('input[name=siteMapUrl]').focus();
                        return false;
                    }
                }
                if($("input[name=fileUpload]").val()){
                    if(!fileChk($("input[name=fileUpload]").val())){
                        alert("ppt, pdf 파일만 업로드 가능합니다.");
                        return false;
                    }
                }
				if(!($("input[name=chk_agree]").is(":checked"))){
					alert("입점/제휴문의 및 상담을 위한 개인정보를 수집하는데 동의하셔야만 입점문의가 가능합니다.");
					$('input[name=chk_agree]').focus();
					return false;
				}

				$.ajax({
					type: 'POST',
					url: '/footer/inquiry_for_office',
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
                            location.href="/footer/finish_inquiry_for_office";
						}
						else alert(res.message);
					}
				});

			}

			//====================================
			// 콤보박스 초기화
			//====================================
			function initCombo(pObj, pTitle)
			{
				for (var i = document.getElementById(pObj).length; i >=0; i-- ){
					document.getElementById(pObj)[i] = null;
				}

				var option 		= document.createElement("option");
				option.value 	= "";
				option.text 	= pTitle;
				document.getElementById(pObj).appendChild(option);
				document.getElementById(pObj).value = "";
			}

			///====================================
			// 시/군/구 리스트
			//====================================
			function jsFindGungu(sido, idx){
				//콤보박스 초기화
				initCombo("formPostalSearch"+idx+"02", "선택");
				if(idx == '01' || idx == '03'){
					$("#formPostalSearch"+idx+"03").val('');
				} else if (idx == '02'){
					$("#formPostalSearch"+idx+"03").val('');
					$("#formPostalSearch"+idx+"04").val('');
				}

				$.ajax({
						type: 'POST',
						url: '/cart/get_post_sigungu',
						dataType: 'json',
						data: { sido : sido },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								for (var i=0; i < res.sigungu_list.length; i++){
									if(res.sigungu_list[i]['SIGUNGU'] != null){
										var option		= document.createElement("option");
										option.value	= res.sigungu_list[i]['SIGUNGU'];
										option.text		= res.sigungu_list[i]['SIGUNGU'];

										document.getElementById("formPostalSearch"+idx+"02").appendChild(option);
									} else {
										//콤보박스 초기화
										initCombo("formPostalSearch"+idx+"02", "전체");
										document.getElementById("formPostalSearch"+idx+"02")[0].value = 'N/A';
									}
								}
							}
							else alert(res.message);
						}
				});
			}

			
			//====================================
			// 우편번호 검색
			//====================================
			function jsPostnum(gb){
				if(gb == '01'){
					var sido	= $("#formPostalSearch0101").val();
					var sigungu = $("#formPostalSearch0102").val();
					var dong	= $("#formPostalSearch0103").val();

					if(sido == ''){
						alert("시/도를 선택해주세요.");
						$("#formPostalSearch0101").focus();
						return false;
					}

					if(sigungu == ''){
						alert("시/군/구를 선택해주세요.");
						$("#formPostalSearch0102").focus();
						return false;
					}

					if(dong == ''){
						alert("동(읍/면)을 입력해주세요.");
						$("#formPostalSearch0103").focus();
						return false;
					}

					$('#loading').show();

					$.ajax({
						type: 'POST',
						url: '/cart/get_postnum',
						dataType: 'json',
						data: { sido : sido, sigungu : sigungu, dong : dong, gb : gb },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								$('#loading').hide();

								if(res.old_addr_cnt == 0){
									$('ul[name=postalCodeCont01]').html('<center>검색된 주소가 없습니다.</center>');	//지번주소
								} else {
									//검색결과 붙여넣기
									$('span[name=old_addr_cnt]').text('('+res.old_addr_cnt+')');
									$('ul[name=postalCodeCont01]').html(res.old_addr);	//지번주소
								}
							}
							else alert(res.message);
						}
					})
				} else if(gb == '02'){
					var sido		= $("#formPostalSearch0201").val();
					var sigungu		= $("#formPostalSearch0202").val();
					var road_name	= $("#formPostalSearch0203").val();
					var road_no		= $("#formPostalSearch0204").val();

					if(sido == ''){
						alert("시/도를 선택해주세요.");
						$("#formPostalSearch0201").focus();
						return false;
					}

					if(sigungu == ''){
						alert("시/군/구를 선택해주세요.");
						$("#formPostalSearch0202").focus();
						return false;
					}

					if(road_name == ''){
						alert("도로명을 입력해주세요.");
						$("#formPostalSearch0203").focus();
						return false;
					}

					if(road_no == ''){
						alert("건물번호를 입력해주세요.");
						$("#formPostalSearch0204").focus();
						return false;
					}

					$('#loading').show();

					$.ajax({
						type: 'POST',
						url: '/cart/get_postnum',
						dataType: 'json',
						data: { sido : sido, sigungu : sigungu, road_name : road_name, road_no : road_no, gb : gb },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								$('#loading').hide();

								if(res.new_addr_cnt == 0){
									$('ul[name=postalCodeCont01]').html('<center>검색된 주소가 없습니다.</center>');	//지번주소
								} else {
									//검색결과 붙여넣기
									$('span[name=new_addr_cnt]').text('('+res.new_addr_cnt+')');
									$('ul[name=postalCodeCont01]').html(res.new_addr);	//지번주소
								}
							}
							else alert(res.message);
						}
					})
				} else if(gb == '03'){
					var sido			= $("#formPostalSearch0301").val();
					var sigungu			= $("#formPostalSearch0302").val();
					var building_name	= $("#formPostalSearch0303").val();

					if(sido == ''){
						alert("시/도를 선택해주세요.");
						$("#formPostalSearch0301").focus();
						return false;
					}

					if(sigungu == ''){
						alert("시/군/구를 선택해주세요.");
						$("#formPostalSearch0302").focus();
						return false;
					}

					if(building_name == ''){
						alert("건물명(아파트명)을 입력해주세요.");
						$("#formPostalSearch0303").focus();
						return false;
					}

					$('#loading').show();

					$.ajax({
						type: 'POST',
						url: '/cart/get_postnum',
						dataType: 'json',
						data: { sido : sido, sigungu : sigungu, building_name : building_name, gb : gb },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								$('#loading').hide();

								if(res.new_addr_cnt == 0){
									$('ul[name=postalCodeCont01]').html('<center>검색된 주소가 없습니다.</center>');	//지번주소
								} else {
									//검색결과 붙여넣기
									$('span[name=new_addr_cnt]').text('('+res.new_addr_cnt+')');
									$('ul[name=postalCodeCont01]').html(res.new_addr);	//지번주소
								}
							}
							else alert(res.message);
						}
					})
				}
			}

			//====================================
			// 주소 클릭시 붙여넣기
			//====================================
			function jsPastepost(gubun, idx){

				if(gubun == '1'){	//지번주소
					var postnum = $($("input[name='addr_post1[]']").get(idx)).val();

					if($($("input[name='addr_post1[]']").get(idx)).val().length == '7'){	//우편번호 6자리일경우 '-'표시 제거
						postnum = $($("input[name='addr_post1[]']").get(idx)).val().split("-")[0] + $($("input[name='addr_post1[]']").get(idx)).val().split("-")[1];
					}

					$('input[name=address1]').val($($("input[name='addr_v1[]']").get(idx)).val());
					$('input[name=post_no]').val(postnum);	//우편번호 히든값 넣기


					//레이어 닫기
					$('#postcodeSearchLayer').removeClass();
					$('#postcodeSearchLayer').addClass('common-layer-wrap postcode-search-layer');
					$("#etah_html").removeClass();

				} else if(gubun == '2'){	//도로명주소

					var postnum = $($("input[name='addr_post2[]']").get(idx)).val();

					if($($("input[name='addr_post2[]']").get(idx)).val().length == '7'){	//우편번호 6자리일경우 '-'표시 제거
						postnum = $($("input[name='addr_post2[]']").get(idx)).val().split("-")[0] + $($("input[name='addr_post2[]']").get(idx)).val().split("-")[1];
					}
					
					$('input[name=address1]').val($($("input[name='addr_v2[]']").get(idx)).val());
					$('input[name=post_no]').val(postnum);	//우편번호 히든값 넣기


					//레이어 닫기
					$('#postcodeSearchLayer').removeClass();
					$('#postcodeSearchLayer').addClass('common-layer-wrap postcode-search-layer');
					$("#etah_html").removeClass();
				}
			//
			//	$("input[name=order_addr2]").val('');			//상세주소
			//	$("select[name=order_mobile1]").val('');		//핸드폰번호
			//	$("input[name=order_mobile2]").val('');
			//	$("input[name=order_mobile3]").val('');
			//	$("select[name=order_phone1]").val('');			//전화번호
			//	$("input[name=order_phone2]").val('');
			//	$("input[name=order_phone3]").val('');
			//	$("input[name=order_requst]").val('');			//요청사항



			}

            //=======================================
            // 확장자 체크 함수 생성
            //=======================================
            function fileChk(str){
                var pattern = new RegExp(/\.(ppt|pptx|pdf)$/i);

                if(!pattern.test(str)) {
                    return false;
                } else {
                    return true;
                }
            }

            //===============================================================
            // 파일경로 지우기
            //===============================================================
            function jsDel(){
                $("#exFilename").replaceWith($("#exFilename").clone(true));
                $("#exFilename").val('');
                $("input[name=file_url]").val('');
            }

            //=====================================
            // 파일경로 보여주기
            //=====================================
            function viewFileUrl(input){
                if($("input[name=fileUpload]").val()){	//파일 확장자 확인
                    if(!fileChk($("input[name=fileUpload]").val())){
                        alert("ppt, pdf 파일만 업로드 가능합니다.");

                        //파일 초기화
                        $("#exFilename").replaceWith($("#exFilename").clone(true));
                        $("#exFilename").val('');
                        $("input[name=file_url]").val('');
                        return false;
                    }
                }

                if(input.files[0].size > 1024*2000){
                    alert("파일의 최대 용량을 초과하였습니다. \n파일은 2MB(2048KB) 제한입니다. \n현재 파일용량 : "+ parseInt(input.files[0].size/1024)+"KB");

                    //파일 초기화
                    $("#exFilename").replaceWith($("#exFilename").clone(true));
                    $("input[name=file_url]").val('');
                    return false;
                }

                else {
                    $("input[name=file_url]").val($("input[name=fileUpload]").val());
                }

            }
				
			</script>