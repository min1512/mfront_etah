<link rel="stylesheet" href="/assets/css/mypage.css">
<link rel="stylesheet" href="/assets/css/cart_order.css">


<div class="content">
<h2 class="page-title-basic page-title-basic--line">회원정보</h2>
<div class="mypage-member-info-wrap delivery-management">
	<h3 class="info-title info-title--sub">배송지관리</h3>
<!--					<div class="delivery-management-box">
		<p class="delivery-management-tlt">13단지 아파트 (기본)</p>
		<div class="delivery-management-info">
			<table class="basic-table">
				<colgroup>
					<col style="width:20%;">
					<col style="width:80%;">
				</colgroup>
				<tbody>
					<tr>
						<th scope="col" class="tb-info-title">받으시는분</th>
						<td class="tb-info-txt">홍길동</td>
					</tr>
					<tr>
						<th scope="row" class="tb-info-title">주소</th>
						<td class="tb-info-txt">
							<span class="tb-info-txt-address">446-025</span>
							<span>서울특별시 양천구 신정6동 신시가지13단지아파트(1301~1333동)</span>
						</td>
					</tr>
					<tr>
						<th scope="row" class="tb-info-title">연락처</th>
						<td class="tb-info-txt">010-1234-5678</td>
					</tr>
				</tbody>
			</table>
			<div class="common-btn-box-wrap">
				<a href="#" class="btn-white">기본배송지로 설정</a>
				<ul class="common-btn-box--delivery-list">
					<li class="common-btn-box--delivery-item"><a href="#layerMypageAddressInfo" class="btn-white" data-layer="bottom-layer-open2">수정</a></li>
					<li class="common-btn-box--delivery-item"><a href="#" class="btn-white">삭제</a></li>
				</ul>
			</div>
		</div>
	</div>-->
	<?
	if($delivery){
		foreach($delivery as $key=>$row){
	?>
	<div class="delivery-management-box">
		<p class="delivery-management-tlt"><?=$row['BASE_DELIV_ADDR_YN'] == 'N' ? $row['CUST_DELIV_ADDR_NM'] : $row['CUST_DELIV_ADDR_NM']." (기본)"?></p>
		<div class="delivery-management-info">
			<table class="basic-table">
				<colgroup>
					<col style="width:20%;">
					<col style="width:80%;">
				</colgroup>
				<tbody>
					<tr>
						<th scope="col" class="tb-info-title">받으시는분</th>
						<td class="tb-info-txt"><?=$row['RECV_NM']?></td>
					</tr>
					<tr>
						<th scope="row" class="tb-info-title">주소</th>
						<td class="tb-info-txt">
							<span class="tb-info-txt-address"><?=$row['ZIPCODE']?></span>
							<span><?=$row['ADDR1']." ".$row['ADDR2']?></span>
						</td>
					</tr>
					<tr>
						<th scope="row" class="tb-info-title">연락처</th>
						<td class="tb-info-txt"><?=$row['MOB_NO']?></td>
					</tr>
				</tbody>
			</table>
			<div class="common-btn-box-wrap">
				<a href="#" class="btn-white" onClick="javascript:baseDelivery(<?=$row['CUST_DELIV_ADDR_NO']?>);">기본배송지로 설정</a>
				<ul class="common-btn-box--delivery-list">
					<li class="common-btn-box--delivery-item"><a href="#layerMypageAddressInfo<?=$key?>" class="btn-white" data-layer="bottom-layer-open2" onClick="javascript:$('#layerKey').val(<?=$key?>)">수정</a></li>
					<?if($row['BASE_DELIV_ADDR_YN'] == 'N'){?><li class="common-btn-box--delivery-item"><a href="#" class="btn-white" onClick="javascript:deleteDelivery('<?=$row['CUST_DELIV_ADDR_NO']?>');">삭제</a></li><?}?>
				</ul>
			</div>
		</div>
	</div>
	<?}}?>
	<div class="common-btn-box-wrap common-btn-box-wrap--modify">
		<a href="#layerMypageAddressInfo" class="btn-white" data-layer="bottom-layer-open2" onClick="javascript:$('#layerKey').val('')">새 배송지 등록</a>
	</div>
</div>

<div id="layer_post" style="display:none;position:absolute;overflow:hidden;z-index:1005;-webkit-overflow-scrolling:touch;top:100px;">
<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1005" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>

<input type="hidden" id="layerKey" value="">
<br/><?=$pagination?>
<!-- 배송지등록 레이어 // -->
<div class="common-layer-wrap cart-coupon-layer" id="layerMypageAddressInfo">
	<!-- common-layer-wrap--view 추가 -->
	<h3 class="common-layer-title">배송지등록</h3>

	<!-- common-layer-content // -->
	<div class="common-layer-content mypage-delivery-info">
		<div class="form-line">
			<div class="form-line-title"><label for="formAddress0101">배송지명</label></div>
			<div class="form-line-info">
				<input type="text" class="input-text" id="formAddress0101">
			</div>
		</div>
		<div class="form-line">
			<div class="form-line-title"><label for="formAddress0201">받으시는분</label></div>
			<div class="form-line-info">
				<input type="text" class="input-text" id="formAddress0201">
			</div>
		</div>
		<div class="form-line form-line--cols">
			<div class="form-line-title"><label for="formAddress0301">휴대폰번호</label></div>
			<div class="form-line-info">
				<div class="form-line--cols-item">
					<div class="select-box select-box--big">
						<select class="select-box-inner" id="formAddress0301">
							<option>010</option>
							<option>011</option>
							<option>016</option>
							<option>017</option>
							<option>019</option>
						</select>
					</div>
				</div>
				<span class="dash">-</span>
				<div class="form-line--cols-item">
					<label for="formAddress0301-2"><input type="tel" class="input-text" id="formAddress0301-2" maxLength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"></label>
				</div>
				<span class="dash">-</span>
				<div class="form-line--cols-item">
					<label for="formAddress0301-3"><input type="tel" class="input-text" id="formAddress0301-3" maxLength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"></label>
				</div>
			</div>
		</div>
		<div class="form-line form-line--rows">
			<div class="form-line-title"><label for="formAddress0401">배송지주소</label></div>
			<div class="form-line-info">
				<div class="form-line--rows-item position-area form-line-info-item--btn">
					<input type="text" class="input-text" id="formAddress0401" onkeyup="this.value=this.value.replace(/[^0-9-]/g,'')">
					<!--<a href="#postcodeSearchLayer" class="btn-white btn-white--bold position-right" data-layer="bottom-layer-open2">우편번호 검색</a>-->
					<!--<button type="button" class="btn-white btn-white--bold position-right" onclick="execDaumPostcode('formAddress0401','','address1','','address2');">우편번호검색</button>-->
					<button type="button" class="btn-white btn-white--bold position-right" onclick="mobile_execDaumPostcode('formAddress0401','','address1','','address2');">우편번호검색</button>
				</div>
				
				<div class="form-line--rows-item">
					<label for="address1"><input type="text" class="input-text" id="address1" placeholder="주소"></label>
				</div>
				<div class="form-line--rows-item">
					<label for="address2"><input type="text" class="input-text" id="address2" placeholder="상세 주소"></label>
				</div>
			</div>
		</div>

		<ul class="common-btn-box">
			<li class="common-btn-item"><a href="#" class="btn-white btn-white--big" data-close="bottom-layer-close2">등록취소</a></li>
			<li class="common-btn-item"><a href="#" class="btn-black btn-black--big" onClick="javaScript:register_delivery();">배송지등록</a></li>
		</ul>
		<!-- // common-layer-button -->
	</div>
	<!-- // common-layer-content -->

	<a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
</div>

<!-- // 배송지등록 레이어 레이어 -->


	<?
	if($delivery){
		foreach($delivery as $key=>$row){
	?>
<!-- 배송지수정 레이어 // -->
<div class="common-layer-wrap cart-coupon-layer" id="layerMypageAddressInfo<?=$key?>">
	<!-- common-layer-wrap--view 추가 -->
	<h3 class="common-layer-title">배송지수정</h3>

	<!-- common-layer-content // -->
	<div class="common-layer-content mypage-delivery-info">
		<div class="form-line">
			<div class="form-line-title"><label for="formAddress0102">배송지명</label></div>
			<div class="form-line-info">
				<input type="text" class="input-text" id="formAddress0102" name= "deli_name<?=$key?>" value="<?=$row['CUST_DELIV_ADDR_NM']?>">
			</div>
		</div>
		<div class="form-line">
			<div class="form-line-title"><label for="formAddress0202">받으시는분</label></div>
			<div class="form-line-info">
				<input type="text" class="input-text" id="formAddress0202" name="name<?=$key?>" value="<?=$row['RECV_NM']?>">
			</div>
		</div>
		<div class="form-line form-line--cols">
			<div class="form-line-title"><label for="formAddress0302">휴대폰번호</label></div>
			<div class="form-line-info">
				<div class="form-line--cols-item">
					<div class="select-box select-box--big">
						<select class="select-box-inner" id="formAddress0302" name="phone<?=$key?>">
							<option <?=$row['arr_mob'][0] == '010' ? "selected" : ""?>>010</option>
							<option <?=$row['arr_mob'][0] == '011' ? "selected" : ""?>>011</option>
							<option <?=$row['arr_mob'][0] == '016' ? "selected" : ""?>>016</option>
							<option <?=$row['arr_mob'][0] == '017' ? "selected" : ""?>>017</option>
							<option <?=$row['arr_mob'][0] == '019' ? "selected" : ""?>>019</option>
						</select>
					</div>
				</div>
				<span class="dash">-</span>
				<div class="form-line--cols-item">
					<label for="formAddress0302-2<?=$key?>"><input type="tel" class="input-text" id="formAddress0302-2<?=$key?>" value="<?=$row['arr_mob'][1]?>" maxLength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"></label>
				</div>
				<span class="dash">-</span>
				<div class="form-line--cols-item">
					<label for="formAddress0302-3<?=$key?>"><input type="tel" class="input-text" id="formAddress0302-3<?=$key?>" value="<?=$row['arr_mob'][1]?>" maxLength="4" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"></label>
				</div>
			</div>
		</div>
		<div class="form-line form-line--rows">
			<div class="form-line-title"><label for="formAddress0402<?=$key?>">배송지주소</label></div>
			<div class="form-line-info">
				<div class="form-line--rows-item position-area form-line-info-item--btn">
					<input type="text" class="input-text" id="formAddress0402<?=$key?>" name="order_postnum_text"  value="<?=$row['ZIPCODE']?>" onkeyup="this.value=this.value.replace(/[^0-9-]/g,'')">
					<!--<a href="#postcodeSearchLayer" class="btn-white btn-white--bold position-right" data-layer="bottom-layer-open2">우편번호 검색</a>-->
					<button type="button" class="btn-white btn-white--bold position-right" onclick="mobile_execDaumPostcode('formAddress0402<?=$key?>','','address3<?=$key?>','','address4<?=$key?>');">우편번호검색</button>
				</div>
				<div class="form-line--rows-item">
					<label for="address3<?=$key?>"><input type="text" class="input-text" id="address3<?=$key?>" name="order_addr1_text" placeholder="주소" value="<?=$row['ADDR1']?>"></label>
				</div>
				<div class="form-line--rows-item">
					<label for="address4<?=$key?>"><input type="text" class="input-text" id="address4<?=$key?>" name="order_addr2" placeholder="상세 주소" value="<?=$row['ADDR2']?>"></label>
				</div>
				<input type="hidden" id="delivery_name<?=$key?>"	value="<?=$row['CUST_DELIV_ADDR_NM']?>">
				<input type="hidden" id="receiver_name<?=$key?>"	value="<?=$row['RECV_NM']?>">
				<input type="hidden" id="phone1_<?=$key?>"			value="<?=$row['arr_mob'][0]?>">
				<input type="hidden" id="phone2_<?=$key?>"			value="<?=$row['arr_mob'][1]?>">
				<input type="hidden" id="phone3_<?=$key?>"			value="<?=$row['arr_mob'][2]?>">
				<input type="hidden" id="zipcode<?=$key?>"			value="<?=$row['ZIPCODE']?>">
				<input type="hidden" id="addr1<?=$key?>"			value="<?=$row['ADDR1']?>">
				<input type="hidden" id="addr2<?=$key?>"			value="<?=$row['ADDR2']?>">
			</div>
		</div>

		<ul class="common-btn-box">
			<li class="common-btn-item"><a href="#" class="btn-white btn-white--big" data-close="bottom-layer-close2">수정취소</a></li>
			<li class="common-btn-item"><a href="#" class="btn-black btn-black--big" onClick="javascript:update_delivery('<?=$row['CUST_DELIV_ADDR_NO']?>', <?=$key?>);">배송지수정</a></li>
		</ul>
		<!-- // common-layer-button -->
	</div>
	<!-- // common-layer-content -->

	<a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
</div>

<!-- // 배송지수정 레이어 -->
<?}}?>



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

							<!-- 우편번호 검색결과 리스트(지번) // -->
							<ul class="postcode-result-list" id="postalCodeCont01" name="postalCodeCont01">
							</ul>
							<!-- // 우편번호 검색결과 리스트(건물명) -->
						</div>
						<a href="#" class="btn-layer-close" data-close="bottom-layer-close2"><span class="hide">닫기</span></a>
					</div>
				</div>

				<!-- // 주소찾기 레이어 -->


<script type="text/javascript">
			//====================================
			//trim 함수 생성
			//====================================
			function trim(s){
				s = s.replace(/^\s*/,'').replace(/\s*$/,'');
				return s;
			}

/**************************/
/**** 콤보박스 초기화 *****/
/**************************/
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


			//====================================
			// 배송지삭제
			//====================================
			function deleteDelivery(deliv_no){
				if(confirm("해당 배송지를 삭제하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/delete_delivery',
						dataType: 'json',
						data: { deliv_no : deliv_no },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								alert("삭제되었습니다.");
									document.location.href = "/mywiz/delivery/";
							}
							else alert(res.message);
						}
					});
				}
			}

			//====================================
			// 기본배송지 설정
			//====================================
			function baseDelivery(deliv_no){

				if(confirm("해당 배송지를 기본 배송지로 설정하시겠습니까?")){


					$.ajax({
						type: 'POST',
						url: '/mywiz/base_delivery',
						dataType: 'json',
						data: { deliv_no : deliv_no },
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
								alert("설정되었습니다.");
								document.location.href = "/mywiz/delivery/";
							}
							else alert(res.message);
						}
					});
				}
			}

			//====================================
			// 배송지등록
			//====================================
			function register_delivery(){

				var delivery_nm = $("#formAddress0101").val()
					, receiver_nm = $("#formAddress0201").val()
					, phone1 = $("#formAddress0301").val()
					, phone2 = $("#formAddress0301-2").val()
					, phone3 = $("#formAddress0301-3").val()
					, post_no = $("#formAddress0401").val()
					, address1 = $("#address1").val()
					, address2 = $("#address2").val();

				if(!trim(delivery_nm)){
					alert("배송지명을 입력해주세요.");
					$("#formAddress0101").focus();
					return false;
				}
				if(!trim(receiver_nm)){
					alert("받는사람을 입력해주세요.");
					$("#formAddress0201").focus();
					return false;
				}
				if(!trim(phone2)){
					alert("휴대전화의 국번을 입력해주세요.");
					$("#formAddress0301-2").focus();
					return false;
				}
				if(phone2.length < 3){
					alert("휴대전화의 국번은 3자리 이상이어야 합니다.");
					$("#formAddress0301-2").focus();
					return false;
				}
				if(!trim(phone3)){
					alert("휴대전화의 뒷자리를 입력해주세요.");
					$("#formAddress0301-3").focus();
					return false;
				}
				if(phone3.length < 4){
					alert("휴대전화의 뒷자리는 4자리 이상이어야 합니다.");
					$("#formAddress0301-3").focus();
					return false;
				}
				if(!trim(address1)){
					alert("주소를 입력해주세요.");
					$("#address1").focus();
					return false;
				}
				if(!trim(address2)){
					alert("상세주소 입력해주세요.");
					$("#address2").focus();
					return false;
				}

				if(confirm("등록하시겠습니까?")){

					$.ajax({
						type: 'POST',
						url: '/mywiz/register_delivery',
						dataType: 'json',
						data: { delivery_nm		: delivery_nm
								, receiver_nm	: receiver_nm
								, phone			: phone1+"-"+phone2+"-"+phone3
								, post_no		: post_no
								, address1		: address1
								, address2		: address2},
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
									alert("등록되었습니다.");
									document.location.href = "/mywiz/delivery/";
							}
							else alert(res.message);
						}
					});
				}
			}

			//====================================
			// 배송지수정
			//====================================
			function update_delivery(val, idx){

				var	deliv_no = val
					, delivery_nm = $("input[name=deli_name"+idx+"]").val()
					, receiver_nm = $("input[name=name"+idx+"]").val()
					, phone1 = $("select[name=phone"+idx+"]").val()
					, phone2 = $("#formAddress0302-2"+idx).val()
					, phone3 = $("#formAddress0302-3"+idx).val()
					, post_no = $("#formAddress0402"+idx).val()
					, address1 = $("#address3"+idx).val()
					, address2 = $("#address4"+idx).val();

				if(!trim(delivery_nm)){
					alert("배송지명을 입력해주세요.");
					$("input[name=deli_name"+idx+"]").focus();
					return false;
				}
				if(!trim(receiver_nm)){
					alert("받는사람을 입력해주세요.");
					$("input[name=name"+idx+"]").focus();
					return false;
				}
				if(!trim(phone2)){
					alert("휴대전화의 국번을 입력해주세요.");
					$("#formAddress0302-2"+idx).focus();
					return false;
				}
				if(phone2.length < 3){
					alert("휴대전화의 국번은 3자리 이상이어야 합니다.");
					$("#formAddress0302-2"+idx).focus();
					return false;
				}
				if(!trim(phone3)){
					alert("휴대전화의 뒷자리를 입력해주세요.");
					$("#formAddress0302-3"+idx).focus();
					return false;
				}
				if(phone3.length < 4){
					alert("휴대전화의 뒷자리는 4자리 이상이어야 합니다.");
					$("#formAddress0302-3"+idx).focus();
					return false;
				}
				if(!trim(address1)){
					alert("주소를 입력해주세요.");
					$("#address3"+idx).focus();
					return false;
				}
				if(!trim(address2)){
					alert("상세주소 입력해주세요.");
					$("#address4"+idx).focus();
					return false;
				}

				if(confirm("수정하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/update_delivery',
						dataType: 'json',
						data: { deliv_no		: deliv_no
								, delivery_nm	: delivery_nm
								, receiver_nm	: receiver_nm
								, phone			: phone1+"-"+phone2+"-"+phone3
								, post_no		: post_no
								, address1		: address1
								, address2		: address2},
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


/****************************************/
/********* 주소 클릭시 붙여넣기 *********/
/****************************************/
function jsPastepost(gubun, idx){

	if(gubun == '1'){	//지번주소
		if($('#layerKey').val() != ''){
			var key = $('#layerKey').val();
			$($('input[name=order_postnum_text]').get(key)).val($($("input[name='addr_post1[]']").get(idx)).val());
			$($('input[name=order_addr1_text]').get(key)).val($($("input[name='addr_v1[]']").get(idx)).val());
//			$($('input[name=order_addr1]').get(key)).val($($("input[name='addr_v1[]']").get(idx)).val());
		} else {
			$('#formAddress0401').val($($("input[name='addr_post1[]']").get(idx)).val());
			$('#address1').val($($("input[name='addr_v1[]']").get(idx)).val());
		}

		var postnum = $($("input[name='addr_post1[]']").get(idx)).val();

		if($($("input[name='addr_post1[]']").get(idx)).val().length == '7'){	//우편번호 6자리일경우 '-'표시 제거
			postnum = $($("input[name='addr_post1[]']").get(idx)).val().split("-")[0] + $($("input[name='addr_post1[]']").get(idx)).val().split("-")[1];
		}

		$('input[name=order_postnum]').val(postnum);	//우편번호 히든값 넣기

		//레이어 닫기
		$('#postcodeSearchLayer').removeClass();
		$('#postcodeSearchLayer').addClass('common-layer-wrap postcode-search-layer');
		$('#addressBookLayer').removeClass();
		$('#addressBookLayer').addClass('common-layer-wrap address-book-layer');

	} else if(gubun == '2'){	//도로명주소
		if($('#layerKey').val() != ''){
			var key = $('#layerKey').val();
			$($('input[name=order_postnum_text]').get(key)).val($($("input[name='addr_post2[]']").get(idx)).val());
			$($('input[name=order_addr1_text]').get(key)).val($($("input[name='addr_v2[]']").get(idx)).val());
//			$('input[name=order_addr1]').val($($("input[name='addr_v2[]']").get(idx)).val());
		} else {
			$('#formAddress0401').val($($("input[name='addr_post2[]']").get(idx)).val());
			$('#address1').val($($("input[name='addr_v2[]']").get(idx)).val());
		}
		var postnum = $($("input[name='addr_post2[]']").get(idx)).val();

		if($($("input[name='addr_post2[]']").get(idx)).val().length == '7'){	//우편번호 6자리일경우 '-'표시 제거
			postnum = $($("input[name='addr_post2[]']").get(idx)).val().split("-")[0] + $($("input[name='addr_post2[]']").get(idx)).val().split("-")[1];
		}

		$('input[name=order_postnum]').val(postnum);	//우편번호 히든값 넣기

        //레이어 닫기
        $('#postcodeSearchLayer').removeClass();
        $('#postcodeSearchLayer').addClass('common-layer-wrap postcode-search-layer');
        $('#addressBookLayer').removeClass();
        $('#addressBookLayer').addClass('common-layer-wrap address-book-layer');

	}

}


//===============================================================
// 우편번호 검색
//===============================================================
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

//===============================================================
// 시/군/구 리스트 불러오기
//===============================================================
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

</script>