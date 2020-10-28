<link rel="stylesheet" href="/assets/css/mypage.css">
		<!-- 우편번호 검색 레이어 // -->
		<div class="layer layer__postal_code_search" id="layer__postal_code_search_01">
			<div class="layer_inner">

				<h1 class="layer_title layer_title__line">주소 찾기</h1>
					<div class="layer_cont">
						<h2 class="layer_title_sub">도로명 주소</h2>

						<div class="radio_area postal_code_select">
							<input type="radio" name="a" class="radio" id="formapostalCodeSelect01" checked="checked" onClick="javascript:$('#postal01').show(); $('#postal02').hide(); $('#postal03').hide(); $('ul[name=postalCodeCont01]').html('');" /> <label for="formapostalCodeSelect01" class="radio_label">동(읍&#47;면) + 지번</label>
							<input type="radio" name="a" class="radio" id="formapostalCodeSelect02" onClick="javascript:$('#postal02').show(); $('#postal01').hide(); $('#postal03').hide(); $('ul[name=postalCodeCont01]').html('');"/> <label for="formapostalCodeSelect02" class="radio_label">도로명주소 + 건물번호</label>
							<input type="radio" name="a" class="radio" id="formapostalCodeSelect03" onClick="javascript:$('#postal03').show(); $('#postal01').hide(); $('#postal02').hide(); $('ul[name=postalCodeCont01]').html('');"/> <label for="formapostalCodeSelect03" class="radio_label">건물명(아파트명)</label>
						</div>

						<!-- 동(읍/면) + 지번 // -->
						<div id="postal01">
							<p class="postal_code_search_text">
								<em class="bold">검색방법 : 시&#47;도 및 시&#47;군&#47;구 선택 후 동(읍&#47;면) + 지번 입력</em> 예) 역삼동 737 -> 서울특별시 선택 후 역삼동(동명) + 737(지번)
								<span class="tip">* 도로명 주소가 검색되지 않은 경우는 행정안전부 새주소 안내시스템 (<a href="http://www.juso.go.kr" target="_blank">http://www.juso.go.kr</a>)에서<br />확인하시기 바랍니다.</span>
							</p>
							<div class="postal_code_search_area">
								<table class="normal_table">
									<caption class="hide">회원가입 필수항목 입력표</caption>
									<colgroup>
										<col style="width:72px" />
										<col style="width:169px" />
										<col style="width:65px" />
										<col />
									</colgroup>
									<tbody>
										<tr>
											<th sope="row"><label for="formPostalSearch0101">시도</label></th>
											<td>
												<div class="select_wrap" style="width:157px;">
													<select id="formPostalSearch0101" style="width:157px;" onChange="javascript:jsFindGungu(this.value,'01')">
													<option value=''>선택</option>
													<? foreach($deliv_sido_list as $row){	?>
													<option value="<?=$row['SIDO']?>"><?=$row['SIDO']?></option>
													<? }?>
												</select>
												</div>
											</td>
											<th sope="row"><label for="formPostalSearch0102">시군구</label></th>
											<td>
												<div class="select_wrap" style="width:157px;">
													<select id="formPostalSearch0102" style="width:157px;" onChange="javscript:$('#formPostalSearch0103').val('');">
													<option value=''>선택</option>
												</select>
												</div>
											</td>
										</tr>
										<tr>
											<th sope="row"><label for="formPostalSearch0103">검색어</label></th>
											<td colspan="3">
												<input type="text" class="input_text" id="formPostalSearch0103" name="formPostalSearchDong" placeholder="동(읍/면)" style="width: 376px;" />
											<!--	<span class="spr-common spr-ico_plus">+</span>
												<label><input type="text" class="input_text" placeholder="지번" style="width: 162px;" /></label>	-->
												<button type="submit" class="btn_black" onClick="javascript:jsPostnum('01')">검색</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- // 동(읍/면) + 지번 -->

						<!-- 도로명주소 + 건물번호 // -->
						<div id="postal02" style="display:none;">
							<p class="postal_code_search_text">
								<em class="bold">검색방법 : 시&#47;도 및 시&#47;군&#47;구 선택 후 도로명과 건물번호 입력</em> 예) 테헤란로(도로명) + 152(건물번호)
								<span class="tip">* 도로명 주소가 검색되지 않은 경우는 행정안전부 새주소 안내시스템 (<a href="http://www.juso.go.kr" target="_blank">http://www.juso.go.kr</a>)에서<br />확인하시기 바랍니다.</span>
							</p>
							<div class="postal_code_search_area">
								<table class="normal_table">
									<caption class="hide">회원가입 필수항목 입력표</caption>
									<colgroup>
										<col style="width:72px" />
										<col style="width:169px" />
										<col style="width:65px" />
										<col />
									</colgroup>
									<tbody>
										<tr>
											<th sope="row"><label for="formPostalSearch0201">시도</label></th>
											<td>
												<div class="select_wrap" style="width:157px;">
													<select id="formPostalSearch0201" style="width:157px;" onChange="javascript:jsFindGungu(this.value,'02')">
													<option value=''>선택</option>
													<? foreach($deliv_sido_list as $row){	?>
													<option value="<?=$row['SIDO']?>"><?=$row['SIDO']?></option>
													<? }?>
												</select>
												</div>
											</td>
											<th sope="row"><label for="formPostalSearch0202">시군구</label></th>
											<td>
												<div class="select_wrap" style="width:157px;">
													<select id="formPostalSearch0202" style="width:157px;" onChange="javscript:$('#formPostalSearch0203').val(''); $('#formPostalSearch0204').val('');">
													<option>선택</option>
												</select>
												</div>
											</td>
										</tr>
										<tr>
											<th sope="row"><label for="formPostalSearch0203">검색어</label></th>
											<td colspan="3">
												<input type="text" class="input_text" id="formPostalSearch0203" placeholder="도로명" style="width: 162px;" />
												<span class="spr-common spr-ico_plus">+</span>
												<label><input type="text" id="formPostalSearch0204" class="input_text" placeholder="건물번호" style="width: 162px;" /></label>
												<button type="submit" class="btn_black" onClick="javascript:jsPostnum('02')">검색</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- // 도로명주소 + 건물번호 -->

						<!-- 건물명(아파트명) // -->
						<div id="postal03" style="display:none;">
							<p class="postal_code_search_text">
								<em class="bold">검색방법 : 시&#47;도 및 시&#47;군&#47;구 선택 후 건물명 입력</em> 예) 강남파이낸스센터(건물명)
								<span class="tip">* 도로명 주소가 검색되지 않은 경우는 행정안전부 새주소 안내시스템 (<a href="http://www.juso.go.kr" target="_blank">http://www.juso.go.kr</a>)에서<br />확인하시기 바랍니다.</span>
							</p>
							<div class="postal_code_search_area">
								<table class="normal_table">
									<caption class="hide">회원가입 필수항목 입력표</caption>
									<colgroup>
										<col style="width:72px" />
										<col style="width:169px" />
										<col style="width:65px" />
										<col />
									</colgroup>
									<tbody>
										<tr>
											<th sope="row"><label for="formPostalSearch0301">시도</label></th>
											<td>
												<div class="select_wrap" style="width:157px;">
													<select id="formPostalSearch0301" style="width:157px;" onChange="javascript:jsFindGungu(this.value,'03')">
													<option value=''>선택</option>
													<? foreach($deliv_sido_list as $row){	?>
													<option value="<?=$row['SIDO']?>"><?=$row['SIDO']?></option>
													<? }?>
												</select>
												</div>
												<input type="hidden" id="addr_gubun" value="<?=$gubun?>">
											</td>
											<th sope="row"><label for="formPostalSearch0302">시군구</label></th>
											<td>
												<div class="select_wrap" style="width:157px;">
													<select id="formPostalSearch0302" style="width:157px;" onChange="javscript:$('#formPostalSearch0303').val('');">
													<option>선택</option>
												</select>
												</div>
											</td>
										</tr>
										<tr>
											<th sope="row"><label for="formPostalSearch0303">검색어</label></th>
											<td colspan="3">
												<input type="text" class="input_text" id="formPostalSearch0303" placeholder="건물명(아파트명)" style="width: 376px;" />
												<button type="submit" class="btn_black" onClick="javascript:jsPostnum('03')">검색</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- // 건물명(아파트명) -->

					<!-- // 우편번호 검색 필드 -->

					<!-- 우편번호 검색 결과 // -->
					<div class="postal_code">
						<ul class="postal_code_list" id="postalCodeCont01" name="postalCodeCont01">
						<!--<li class="postal_code_item">
								<a href="#">
									<input type="hidden" name="addr_v1[]" value="인천광역시 용현동">
									<input type="hidden" name="addr_post1[]" value="402-202">
									<span class="address" onClick="javascript:jsPastepost()";>인천광역시 용현동</span>
									<span class="code">402-202</span>
								</a>
							</li>-->
						</ul>
					</div>
					<!-- // 우편번호 검색 결과 -->
				</div>

				<a href="#layer__postal_code_search_01" data-ui="layer-closer" class="spr-common layer_close" title="레이어 닫기"></a>
			</div>
			<div class="dimd"></div>
		</div>
		<!-- // 우편번호 검색 레이어 -->

		<script type="text/javaScript">

		//=====================================
		// 시/군/구 리스트 불러오기
		//=====================================
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

		//=====================================
		// 우편번호 검색
		//=====================================
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

		//=====================================
		// 콤보박스 초기화
		//=====================================
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

		</script>