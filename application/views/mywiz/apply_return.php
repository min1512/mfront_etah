				<link rel="stylesheet" href="/assets/css/vip.css">

				<!-- 취소/반품신청 레이어 // -->
				<div class="common-layer-wrap layer-shopping-cancel-return" id="layerShoppingCancelReturn">
					<h3 class="common-layer-title">반품신청</h3>
					<!-- common-layer-content // -->
					<div class="common-layer-content ">
						<!--<div class="common-form-line-wrap">
							<div class="form-line">
								<div class="form-line-title"><label for="mypageShoppingName">주문자명</label></div>
								<div class="form-line-info">
									<input type="text" class="input-text" id="mypageShoppingName" placeholder="etah">
								</div>
							</div>
							<div class="form-line">
								<div class="form-line-title"><label for="mypageShoppingPayment">결제수단</label></div>
								<div class="form-line-info">
									<input type="text" class="input-text" id="mypageShoppingPayment" placeholder="무통장입금">
								</div>
							</div>
							<div class="form-line form-line--cols">
								<div class="form-line-title"><label for="mypageShoppingPhone_1_1">연락처</label></div>
								<div class="form-line-info">
									<input type="text" class="input-text" id="mypageShoppingPayment" placeholder="숫자만 입력해주세요." onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
								</div>
							</div>
						</div>-->

						<h3 class="info-title info-title--sub">상품정보</h3>
						<div class="media-area prd-order-media">
							<span class="media-area-img prd-order-media-img"><img src="<?=$order['IMG_URL']?>" alt=""></span>
							<span class="media-area-info prd-order-media-info">
							<span class="prd-order-media-info-brand">[<?=$order['BRAND_NM']?>] <?=$order['GOODS_NM']?></span>
							<span class="prd-order-media-info-name">옵션명 : <?=$order['GOODS_OPTION_NM']?><?=$order['SELLING_ADD_PRICE'] > 0 ? " (+".number_format($order['SELLING_ADD_PRICE']).")" : ""?></span>
							<span class="prd-order-media-info-price">상품금액 <strong class="bold"><?=number_format($order['SELLING_PRICE'])?></strong><span class="won">원</span></span>/
							<span class="prd-order-media-info-price">
								<?
								$str_delivery = "";
								$deli_cost = "";
								switch($order['PATTERN_TYPE_CD']){
									case 'PRICE' :	if($order['DELI_LIMIT']>$order['SELLING_PRICE']){
														$str_delivery = "배송비 ".number_format($order['DELI_COST'])."원";
														$deli_cost = $order['DELI_COST'];
													}else{
														$str_delivery = "무료배송";
														$deli_cost = "0";
													} break;
									case 'FREE'  :	$str_delivery = "무료배송"; 
													$deli_cost = "0";	break;
									case 'STATIC': 	$str_delivery = "배송비 ".number_format($order['DELI_COST'])."원";
													$deli_cost = $order['DELI_COST']; break;
								}
								echo $str_delivery;
								?>
							</span>
							<div style="padding-top:10px; padding-right:20%;">
							<div class="ui-buy-quantity">
								<input type="text" class="quantity_input" value="1" name="qty" readonly>
								<button type="button" class="quantity_minus_btn" onClick="javaScript:clickQty('M');"><span class="hide-text">minus</span></button>
								<button type="button" class="quantity_plus_btn" onClick="javaScript:clickQty('P');"><span class="hide-text">plus</span></button>
							</div>
							</div>
							</span>
							
							
						</div>
						<h3 class="info-title info-title--sub">반품방법</h3>
						<div class="media-area prd-order-media">
							
							<div class="common-form-line-wrap">
							<div class="form-line">
								<div class="form-line-title"><label for="mypageShoppingName">반품여부</label></div>
								<div class="form-line-info">
									<label class="common-radio-label" for="joinGenderCheck1">
									<input type="radio" id="joinGenderCheck1" name="return_delivery_yn" class="common-radio-btn" onClick="javaScript:sendReturnDeli('Y');" value="01">발송&nbsp;&nbsp;
									<label class="common-radio-label" for="joinGenderCheck2">
									<input type="radio" id="joinGenderCheck2" name="return_delivery_yn" class="common-radio-btn" onClick="javaScript:sendReturnDeli('N');" value="03">미발송
								</div>
							</div>
							<div class="form-line" id='return_d1' style="display:none;">
								<div class="form-line-title"><label for="mypageShoppingPayment">발송정보</label></div>
								<div class="form-line-info">
									<div class="select-box select-box--big">
										<select class="select-box-inner" name="deli_com">
											<option value="" selected>택배사 선택</option>
											<?foreach($deli_list as $row){?>
											<option value="<?=$row['DELIV_COMPANY_CD']?>"><?=$row['CD_NM']?></option>
											<?}?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-line" id='return_d2' style="display:none;">
								<div class="form-line-title"><label for="mypageShoppingPayment">송장번호</label></div>
								<div class="form-line-info">
									<input type="text" class="input-text" id="mypageShoppingPayment" name="invoice_no" placeholder="송장번호를 입력해주세요." onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
								</div>
							</div>
							<div class="form-line form-line--cols" id='return_d3' style="display:none;">
								<div class="form-line-title"><label for="mypageShoppingPhone_1_1">발송일</label></div>
								<div class="form-line-info">
									<input type="text" class="input-text" id="mypageShoppingPayment" name="invoice_date" placeholder="예) 2016-05-31">
								</div>
							</div>
							<div class="form-line" id='return_d4' style="display:none;">
								<div class="form-line-title"><label for="mypageShoppingPayment">반품정보</label></div>
								<div class="form-line-info">
									<span class="prd-order-media-info-price">[반품 지정택배] <?=$order['DELIVERY_NAME']?><input type="hidden" name="deli_com2" value="<?=$order['DELIVERY_CODE']?>"></span>
								</div>
							</div>
							<div class="form-line">
								<div class="form-line-title"><label for="mypageShoppingPayment">반품 배송비</label></div>
								<div class="form-line-info">
									<span class="prd-order-media-info-price"><b>
										<input type="hidden" name="deli_cost" value="<?=$order['RETURN_DELIV_COST']?>">
										<input type="hidden" name="first_deli_cost" value="<?=$order['ORDER_REFER_DELI_COST'] == '0' ? $order['DELI_COST'] : 0?>">
										<?=number_format($order['RETURN_DELIV_COST'])?></b>원
									</span>
								</div>
							</div>
							<div class="form-line">
								<div class="form-line-title"><label for="mypageShoppingPayment">배송비 결제</label></div>
								<div class="form-line-info">
									<div class="select-box select-box--big">
										<select class="select-box-inner" name="deli_cost_type" onChange="javaScript:changeDeliCost(this.value);">
											<option value="" selected>반품 배송비 결제방식 선택</option>
											<?foreach($return_pay_type as $row){?>
											<option value="<?=$row['RETURN_DELIVFEE_PAY_WAY_CD']?>"><?=$row['RETURN_DELIVFEE_PAY_WAY_CD_NM']?></option>
											<?}?>
										</select>
									</div>
								</div>
							</div>
							
						</div>

						<h3 class="info-title info-title--sub">반품사유</h3>

						<div class="form-line form-line--wide">
							<div class="select-box select-box--big">
								<select class="select-box-inner" name="reason" onChange="javaScript:changeReturnReason(this.value);">
									<option value="" selected>반품사유 선택</option>
									<?foreach($reason_list as $row){?>
									<option value="<?=$row['CANCEL_RETURN_REASON_CD']?>"><?=$row['CANCEL_RETURN_REASON_CD_NM']?></option>
									<?}?>
								</select>
							</div>
						</div>
						<div class="form-line form-line--wide">
							<div class="form-line-info">
								<label>
									<textarea type="text" class="input-text input-text--textarea" placeholder="상세사유를 입력해주세요." name="reason_detail"></textarea>
								</label>
							</div>
						</div>

                        <form id="updFile" name="updFile" method="post"  enctype="multipart/form-data">
                            <div class="mypage-cancle-file" id="tblFileUpload">
                                <div class="form-line form-line--wide" name="row[]">
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
                        </form>
						
						<br/><br/>
						<div class="media-area prd-order-media">
							<h3 class="info-title info-title--sub">환불예상금액</h3>
						</div>

						<div class="media-area prd-order-media">
							<div style="font-family:'맑은 고딕';  padding-left:20px;">
								<div style=" color:gray;">
								<b>· </b><span class="prd-order-media-info-price" id="str_goods_pri">상품금액 : <?=number_format($order['SELLING_PRICE'])?><span class="won">원</span></span><br/>
								<b>· </b><span class="prd-order-media-info-price" id="str_deli_cost">배송비 &nbsp;&nbsp;&nbsp;: <span class="won">원</span></span><input type="hidden" id="t_deli_cost" value=0><br/>
								<b>· </b><span class="prd-order-media-info-price">할인금액 : -<?=number_format($order['DC_AMT'])?><span class="won">원</span></span><br/><br/>
								</div>
								<b><span class="prd-order-media-info-price" id="str_total_price">환불예상금액 : 원</span></b>
								
							</div>
						</div>
						<br/><br/><br/>
						
						<div class="mypage-info-section">
							<h4 class="mypage-info-section-title"><span class="ico-i">i</span>반품 시 유의사항</h4>
							<ul class="text-list">
								<li class="text-item">신용카드는 승인취소의 방법으로 환불처리가 되고, 체크카드는 승인취소 후 해당 카드 계좌로 입금이 됩니다.</li>
								<li class="text-item">환불은 취소 승인 후 약 3~5일(주말&#47;공휴일 제외) 소요될 수 있습니다.</li>
								<li class="text-item">장바구니 구매건 중 일부 상품이 취소되는 경우, 카드사에 따라 부분취소 또는 재결제의 방식으로 대금 환급이 진행될 수 있습니다.</li>
								<li class="text-item">초기 무료배송 주문의 경우, 반품 시 초도배송비에 대한 추가 결제가 발생할 수 있습니다.</li>
							</ul>
						</div>
						<ul class="common-btn-box">
							<li class="common-btn-item"><a href="javaScript:;" class="btn-white btn-white--big" onClick="javaScript:$('#layerShoppingCancelReturn').attr('class','common-layer-wrap layer-shopping-cancel-return');">신청취소</a></li>
							<li class="common-btn-item"><a href="javaScript:;" class="btn-black btn-black--big" onClick="javaScript:return_apply('<?=$order['ORDER_REFER_NO']?>');">반품신청</a></li>
						</ul>
					</div>
					<a href="#" class="btn-layer-close" onClick="javaScript:document.getElementById('layerShoppingCancelReturn').className = 'common-layer-wrap layer-shopping-cancel-return'; $('html').removeClass('bottom-layer-open');"><span class="hide"><span class="hide">닫기</span></a>
					<!-- // common-layer-content -->
				</div>

				<!-- // 취소/반품신청 레이어 -->



				<script>
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
                    var index = document.getElementsByName("row[]").length;

                    if(index == 5 ) {
                        alert("이미지는 최대 5개까지 업로드 가능합니다.");
                        return false;
                    }

                    $("#tblFileUpload").append(
                        "<div class=\"form-line form-line--wide\" name=\"row[]\">" +
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

				//========================================
				//반품발송여부
				//========================================
				function sendReturnDeli(val){
					if(val == 'Y'){
						$('#return_d1').css('display', ''); 
						$('#return_d2').css('display', ''); 
						$('#return_d3').css('display', '');
						$('#return_d4').css('display', 'none');
					}else{
						$('#return_d1').css('display', 'none'); 
						$('#return_d2').css('display', 'none'); 
						$('#return_d3').css('display', 'none');
						$('#return_d4').css('display', '');
					}
				}

				//====================================
				// 반품신청
				//====================================
				function return_apply(val){
					var order_refer_no = val, 
						gb = 'RETURN',
						qty = $('input[name=qty]').val(),
						deli_com = $('select[name=deli_com]').val(),
						deli_com2 = $('input[name=deli_com2]').val(),
						invoice_no = $('input[name=invoice_no]').val(),
						invoice_date = $('input[name=invoice_date]').val(),
						first_deli_cost = $('input[name=first_deli_cost]').val(),
						deli_cost = $('input[name=deli_cost]').val(),
						deli_cost_type = $('select[name=deli_cost_type]').val(),
						deli_type = $(":input:radio[name=return_delivery_yn]:checked").val(),
						
						reason = $('select[name=reason]').val(),
						reason_detail = $('textarea[name=reason_detail]').val(),
						state_cd = 'OR01';


					if(!deli_type){
						alert("반품 발송여부를 선택해주세요.");
						return false;
					}
					if(deli_type == '01'){
						if(deli_com == ''){
							alert("발송하신 택배업체를 선택해주세요.");
							$('select[name=deli_com]').focus();
							return false;
						}
						if(invoice_no == ''){
							alert("운송장 번호를 입력해주세요.");
							$('input[name=invoice_no]').focus();
							return false;
						}
						if(invoice_date == ''){
							alert("반품 발송일을 입력해주세요.");
							$('input[name=invoice_date]').focus();
							return false;
						}
					}else{
						deli_com = deli_com2;
					}
					if(deli_cost_type == ''){
						alert("반품 배송비 결제 방식을 선택해주세요.");
						$('select[name=deli_cost_type]').focus();
						return false;
					}
					if(reason == ''){
						alert("반품사유를 선택해주세요.");
						$('select[name=reason]').focus();
						return false;
					}
					if(reason_detail == ''){
						alert("상세사유를 입력해주세요.");
						$('textarea[name=reason_detail]').focus();
						return false;
					}
                    if( (reason=='04') && ($('#file_url_0').val()=='') ){
                        alert('반품사유가 \'상품 파손/훼손\'의 경우 사진을 첨부해주세요.');
                        return false;
                    }
					

					if(confirm("반품신청 하시겠습니까?")){
					
						$.ajax({
							type: 'POST',
							url: '/mywiz/return_apply',
							dataType: 'json',
							data: {	order_refer_no : order_refer_no,
									gb : gb,
									qty : qty,
									deli_com : deli_com,
									invoice_no : invoice_no,
									invoice_date : invoice_date,
									first_deli_cost : first_deli_cost,
									deli_cost : deli_cost,
									deli_cost_type : deli_cost_type,
									deli_type : deli_type,
									reason : reason,
									reason_detail : reason_detail,
									state_cd : state_cd },
							error: function(res) {
								alert('Database Error');
								alert(res.message);
							},
							success: function(res) {
								if(res.status == 'ok'){
//										alert("반품신청이 완료되었습니다.");
//										location.reload();
                                    reg_image(res.return_no);
								}
								else alert(res.message);
							}
						});
					}
				}

                function reg_image(return_no){
                    if($('#file_url_0').val()==''){
                        alert("반품신청이 완료되었습니다.");
                        location.reload();
                    } else{
                        var data = new FormData($('#updFile')[0]);

                        data.append('return_no', return_no);

                        $.ajax({
                            type: 'POST',
                            url: '/mywiz/return_apply_image',
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
                                    alert("반품신청이 완료되었습니다.");
                                    location.reload();
                                }
                                else alert("파일첨부에 실패하였습니다.");
                            }
                        });
                    }
                }
				
				//========================================
				//배송비 결제
				//========================================
				function changeDeliCost(val){
					var return_reason = $('select[name=reason]').val(),
						order_refer_deli_cost = <?=$order['ORDER_REFER_DELI_COST']?>,
						return_deliv_cost = <?=$order['RETURN_DELIV_COST']?>,
						o_deli_cost = <?=$order['DELI_COST']?>;

					
					if(return_reason == '02' || return_reason == '04'){
						$('input[name=first_deli_cost]').val(0);
						$('input[name=deli_cost]').val(0);
						$("#str_deli_cost").text("배송비　 : <?=$order['ORDER_REFER_DELI_COST'] == 0 ? '-0' : '+'.number_format($order['RETURN_DELIV_COST']) ;?>원");
						$("#t_deli_cost").val(order_refer_deli_cost == 0 ? 0 : order_refer_deli_cost );

						var goods_pri = "<?=$order['SELLING_PRICE']?>";
						var qty		  = $('input[name=qty]').val();
						var t_deli_cost = parseInt($("#t_deli_cost").val());
						var	dc_amt	  = <?=$order['DC_AMT']?>;

						var total_price = (goods_pri*qty)+t_deli_cost-dc_amt;
						$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");

					}else{

						$('input[name=first_deli_cost]').val(order_refer_deli_cost == '0' ? o_deli_cost : 0);
						$('input[name=deli_cost]').val(return_deliv_cost);

						var	deli_cost = $('input[name=deli_cost]').val();

						if(val == '02'){
							$("#str_deli_cost").text("배송비　 : <?=$order['ORDER_REFER_DELI_COST'] == 0 ? '-'.number_format($order['RETURN_DELIV_COST']+$order['DELI_COST']) : '-"+numberFormat(deli_cost)+"';?>원");
		//					$("#str_deli_cost").text("배송비　 : 123123123");
		//					$("#t_deli_cost").val(<?=$order['ORDER_REFER_DELI_COST'] == 0 ? ($order['RETURN_DELIV_COST']+$order['DELI_COST']) : 0 ?>);
							$("#t_deli_cost").val(order_refer_deli_cost == 0 ? ( return_deliv_cost + o_deli_cost) : deli_cost );
						}else{
							$("#str_deli_cost").text("배송비　 : -0원");
							$("#t_deli_cost").val(0);
						}
						var goods_pri = "<?=$order['SELLING_PRICE']?>";
						var qty		  = $('input[name=qty]').val();
						var t_deli_cost = parseInt($("#t_deli_cost").val());
						var	dc_amt	  = <?=$order['DC_AMT']?>;

						var total_price = (goods_pri*qty)-(t_deli_cost+dc_amt);

						$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");
					}
					
				}

				//========================================
				//천단위 콤마
				//========================================
				function numberFormat(num) {
				   num = String(num);
				   return num.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,"$1,");
				}
				
				//========================================
				//수량
				//========================================
				function clickQty(gubun){
					if(gubun == 'M'){
						if($('input[name=qty]').val()>1) $('input[name=qty]').val($('input[name=qty]').val()-1);
					}else if(gubun == 'P'){
						if($('input[name=qty]').val()<<?=$order['ORD_QTY']?>) $('input[name=qty]').val(parseInt($('input[name=qty]').val())+1)
					}
					var goods_pri = <?=$order['SELLING_PRICE']?>*$('input[name=qty]').val();
					$("#str_goods_pri").text("상품금액 : "+numberFormat(goods_pri)+"원");

					var deli_cost = parseInt($("#t_deli_cost").val());
					var	dc_amt	  = <?=$order['DC_AMT']?>;

					var total_price = goods_pri-(deli_cost+dc_amt);
					$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");
				}
				
				//========================================
				//반품사유
				//========================================
				function changeReturnReason(val){
					var order_refer_deli = <?=$order['ORDER_REFER_DELI_COST']?>;
					var return_deliv_cost = <?=$order['RETURN_DELIV_COST']?>;
					var o_deli_cost = <?=$order['DELI_COST']?>;
					var deli_cost_type = $('select[name=deli_cost_type]').val()
						

					if(val == '02' || val == '04'){
						$('input[name=first_deli_cost]').val(0);
						$('input[name=deli_cost]').val(0);
						$("#t_deli_cost").val(order_refer_deli);
						if(order_refer_deli == 0){//무료배송 일 때
							$("#str_deli_cost").text("배송비　 : -0원");
						}else{

							$("#str_deli_cost").text("배송비　 : +"+numberFormat(order_refer_deli)+"원");
						}

						var goods_pri = "<?=$order['SELLING_PRICE']?>";
						var qty		  = $('input[name=qty]').val();
						var t_deli_cost = parseInt($("#t_deli_cost").val());
						var	dc_amt	  = <?=$order['DC_AMT']?>;

						var total_price = (goods_pri*qty)+t_deli_cost-dc_amt;
						$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");
					}else{
						$('input[name=first_deli_cost]').val(order_refer_deli == '0' ? o_deli_cost : 0);
						$('input[name=deli_cost]').val(return_deliv_cost);

						var	deli_cost = $('input[name=deli_cost]').val();


						if(deli_cost_type == '02'){
							$("#str_deli_cost").text("배송비　 : <?=$order['ORDER_REFER_DELI_COST'] == 0 ? '-'.number_format($order['RETURN_DELIV_COST']+$order['DELI_COST']) : '-"+numberFormat(deli_cost)+"';?>원");
							$("#t_deli_cost").val(order_refer_deli == 0 ? ( return_deliv_cost + o_deli_cost) : deli_cost );
						}else{
							$("#str_deli_cost").text("배송비　 : -0원");
							$("#t_deli_cost").val(0);
						}

						var goods_pri = "<?=$order['SELLING_PRICE']?>";
						var qty		  = $('input[name=qty]').val();
						var t_deli_cost = parseInt($("#t_deli_cost").val());
						var	dc_amt	  = <?=$order['DC_AMT']?>;
		
						var total_price = (goods_pri*qty)-(t_deli_cost+dc_amt);
						$("#str_total_price").text("환불예상금액 : "+numberFormat(total_price)+"원");
					}


				}

				</script>