<!DOCTYPE html>
<html lang="ko-KR">

	<head>
		<title>ETAHOME</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>
		<table width="780" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style=" margin: 0 auto; font-family: '맑은 고딕', MalgunGothic, '돋움', Helvetica, AppleSDGothicNeo, sans-serif;">
			<tbody>
				<!-- header // -->
				<tr>
					<td style="border-bottom: 5px solid #999; height: 59px;">
						<table width="780" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
							<tbody>
								<tr>
									<td width="642"><a href="<?=base_url()?>" style="font-size:26px;color: #000; text-decoration: none;font-weight: bold;">ETA HOME</a></td>
									<td width="60"><a href="<?=base_url()?>member/login?return_url=/mywiz" style="display: block;color: #999; font-size: 12px; text-decoration: none; padding-top: 8px;text-align: center;">마이페이지 </a></td>
									<td width="28">
										<a href="#" style="display: block;text-align: center; padding-top: 8px;text-align: center;"><img src="<?=base_url()?>assets/images/mail/bg_bar.gif" alt="" style="border: 0 none;" /></a>
									</td>
									<td width="50"><a href="<?=base_url()?>customer" style="display: block;color: #999; font-size: 12px; text-decoration: none; padding-top: 8px;text-align: right;">고객센터</a></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<!-- // header -->

				<!-- content // -->
				<tr>
					<td style="border-bottom: 1px solid #eee; height: 59px;">
						<table width="780" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td height="70"></td>
								</tr>
								<tr>
									<td style="font-size: 30px; color:#000;text-align: center;">주문하신 상품내역입니다!</td>
								</tr>
								<tr>
									<td height="12"></td>
								</tr>
								<tr>
									<td style="color:#999;font-size:14px;text-align: center;"><em style="color: #000; font-style:normal;">{{mem_name}}</em> 님 안녕하세요? 에타몰입니다.</td>
								</tr>
								<tr>
									<td height="15"></td>
								</tr>
								<tr>
									<td height="1" style="color:#999;font-size:14px;text-align: center;"><img src="<?=base_url()?>assets/images/mail/bg_line.gif" alt="" style="border: 0 none;" /></td>
								</tr>
								<tr>
									<td height="23"></td>
								</tr>
								<tr>
									<td style="color:#999;font-size:12px;text-align: center;line-height: 18px;"><em style="color: #000; font-style:normal;"><?=date('Y')?>년 <?=date('m')?>월 <?=date('d')?>일</em> 주문하신 내역입니다.<br />항상 에타몰을 이용해 주셔서 감사합니다.</td>
								</tr>
								<tr>
									<td height="25"></td>
								</tr>
								<tr>
									<td height="56">
										<div style="width:142px;height:35px;text-align:center;margin: 0 auto;"><a href="<?=base_url()?>member/login?return_url=/mywiz" style="display:block;padding:9px 0 10px;text-align:center;color:#fff;font-size:12px;background:#000;text-decoration:none;">최근 구매내역 보기</a></div>
									</td>
								</tr>
								<tr>
									<td height="78" style="border-bottom: 1px solid #eee;"></td>
								</tr>
								<tr>
									<td height="40"></td>
								</tr>
								<tr>
									<td height="77">
										<table width="718" border="0" cellspacing="0" cellpadding="0" style=" margin: 0 auto; border:1px solid #f0f0f0; background:#f6f6f6;">
											<tbody>
												<tr>
													<td height="77" style="color: #000;font-size:22px;text-align: center;">주문번호 : <?=$order_no?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								<tr>
									<td height="36"></td>
								</tr>
								<tr>
									<td style="color:#000;font-size:18px; padding-left: 30px;">상품정보</td>
								</tr>
								<tr>
									<td height="17"></td>
								</tr>
								<tr>
									<td>
										<table width="720" border="0" cellspacing="0" cellpadding="0" style=" margin: 0 auto;border-top:1px solid #f0f0f0;border-bottom:1px solid #f0f0f0;">
											<colgroup>
												<col width="*" />
												<col width="126" />
												<col width="70" />
												<col width="126" />
												<col width="100" />
											</colgroup>
											<thead>
												<tr>
													<td height="39" style="color: #666;font-size:12px;text-align: center; border-bottom: 1px solid #f0f0f0;background:#f6f6f6;">상품명</td>
													<td height="39" style="color: #666;font-size:12px;text-align: center;border-bottom: 1px solid #f0f0f0;background:#f6f6f6;">가격</td>
													<td height="39" style="color: #666;font-size:12px;text-align: center;border-bottom: 1px solid #f0f0f0;background:#f6f6f6;">수량</td>
													<!--	<td height="39" style="color: #666;font-size:12px;text-align: center;border-bottom: 1px solid #f0f0f0;background:#f6f6f6;">할인금액</td>	-->
													<td height="39" style="color: #666;font-size:12px;text-align: center;border-bottom: 1px solid #f0f0f0;background:#f6f6f6;">주문금액</td>
													<td height="39" style="color: #666;font-size:12px;text-align: center;border-bottom: 1px solid #f0f0f0;background:#f6f6f6;">배송방법</td>
												</tr>
											</thead>
											<tbody>
											<? foreach($goods as $row){	?>
												<tr>
													<td height="39" style="color: #666;font-size:12px;text-align: left;padding-left: 25px;"><span style="color: #000;">[<?=$row['goods_brand_name']?>]</span> <?=$row['goods_name']?><br /><p style="font-size:11px;text-align:left;padding-left:25px;">┗옵션: <?=$row['goods_option_name']?><?if($row['goods_option_add_price'] != 0){?>(+<?=number_format($row['goods_option_add_price'])?>원)<?}?></p></td>
													<td height="39" style="color: #000;font-size:12px;text-align: center;"><?=number_format($row['goods_price'])?>원</td>
													<td height="39" style="color: #666;font-size:12px;text-align: center;"><?=$row['goods_cnt']?></td>
												<!--	<td height="39" style="color: #000;font-size:12px;text-align: center;"><?=number_format($row['goods_discount_price'] == "" ? 0 : $row['goods_discount_price'])?>원</td>		-->
													<td height="39" style="color: #000;font-size:12px;text-align: center;"><?=number_format($row['goods_total_price'])?>원</td>
													<td height="39" style="color: #666;font-size:12px;text-align: center;">일반택배</td>
												</tr>
											<? }?>
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<td height="8"></td>
								</tr>
								<tr>
									<td style="text-align: left;padding-left: 30px;">
										<span style="display: block; color: #999; font-size: 11px; line-height: 18px;background: url('http://etah.co.kr/assets/images/mail/bg_dot.gif') no-repeat 0 7px;padding-left: 9px;">일반택배 : 택배사 인도 후 배송까지 1~3일 가량 소요</span>
										<span style="display: block; color: #999; font-size: 11px; line-height: 18px;background: url('http://etah.co.kr/assets/images/mail/bg_dot.gif') no-repeat 0 7px;padding-left: 9px;">퀵서비스 : 주문 후 평균 3시간 이내 발송</span>
									</td>
								</tr>

								<tr>
									<td height="36"></td>
								</tr>

								<tr>
									<td style="color:#000;font-size:18px; padding-left: 30px;">결제금액</td>
								</tr>
								<tr>
									<td height="17"></td>
								</tr>
								<tr>
									<td>
										<table width="720" border="0" cellspacing="0" cellpadding="0" style=" margin: 0 auto;border-top:1px solid #f0f0f0;border-bottom:1px solid #f0f0f0;">
											<colgroup>
												<col width="180" />
												<col width="180" />
												<col width="180" />
												<col width="180" />
											</colgroup>
											<thead>
												<tr>
													<td height="39" style="color: #666;font-size:12px;text-align: center; border-bottom: 1px solid #f0f0f0; border-right: 1px solid #f0f0f0; background:#f6f6f6;">총 상품가격</td>
													<td height="39" style="color: #666;font-size:12px;text-align: center;border-bottom: 1px solid #f0f0f0; border-right: 1px solid #f0f0f0; background:#f6f6f6;">총 할인금액</td>
													<td height="39" style="color: #666;font-size:12px;text-align: center;border-bottom: 1px solid #f0f0f0; border-right: 1px solid #f0f0f0; background:#f6f6f6;">총 배송비</td>
													<td height="39" style="color: #666;font-size:12px;text-align: center;border-bottom: 1px solid #f0f0f0;background:#f6f6f6;">총 결제금액</td>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td height="39" style="color: #000;font-size:12px;text-align: center; border-right: 1px solid #f0f0f0; "><?=number_format($order_amt)?>원</td>
													<td height="39" style="color: #000;font-size:12px;text-align: center; border-right: 1px solid #f0f0f0;"><?=number_format($order_discount_amt)?>원</td>
													<td height="39" style="color: #000;font-size:12px;text-align: center; border-right: 1px solid #f0f0f0;"><?=number_format($order_delivery_amt)?>원</td>
													<td height="39" style="color: #000;font-size:12px;text-align: center;"><?=number_format($total_pay_sum)?>원</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<td height="20"></td>
								</tr>

								<tr>
									<td>
										<table width="720" border="0" cellspacing="0" cellpadding="0" style=" margin: 0 auto;border-top:1px solid #f0f0f0;border-bottom:1px solid #f0f0f0;">
											<colgroup>
												<col width="180" />
												<col width="*" />
											</colgroup>
											<tbody>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;">사용 마일리지</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left;"><?=number_format($order_mileage_amt)?>원</td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; "><?=$order_pay_kind_name?></th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;">
                                                        <span style="color: #000;"><?=number_format($order_real_pay_amt)?>원</span>
                                                        <span style="color: #999;">
                                                            <?if($order_pay_kind_code == '01'){?><?=$order_card_company?>(안전결제 ISP ****************)
                                                            <?}else if($order_pay_kind_code == '08'){?>가상번호 <?=$vars_vnum_no?> (결제 유효기간 : <?=date("Y-m-d H:i:s", strtotime($vars_expr_dt))?>)
                                                            <?} else {?><?=$order_bank_name?><?=$order_bank_account_no?><?}?>
                                                        </span>
                                                    </td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;">체결일시</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left;"><?=$date?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<td height="36"></td>
								</tr>

								<tr>
									<td style="color:#000;font-size:18px; padding-left: 30px;">배송정보</td>
								</tr>
								<tr>
									<td height="17"></td>
								</tr>
								<tr>
									<td>
										<table width="720" border="0" cellspacing="0" cellpadding="0" style=" margin: 0 auto;border-top:1px solid #f0f0f0;border-bottom:1px solid #f0f0f0;">
											<colgroup>
												<col width="180" />
												<col width="*" />
											</colgroup>
											<tbody>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">수령인</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;"><?=$order_receiver_name?></td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">휴대전화</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;"><?=$order_mobno?></td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">전화번호</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;"><?=$order_phone?></td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;">배송지주소</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left;">(<?=strlen($order_receiver_zipcode) == 6 ? substr($order_receiver_zipcode,0,3)."-".substr($order_receiver_zipcode,3,3) : $order_receiver_zipcode?>) <?=$order_receiver_addr?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<td height="36"></td>
								</tr>

								<tr>
									<td style="color:#000;font-size:18px; padding-left: 30px;">판매자정보</td>
								</tr>
								<tr>
									<td height="17"></td>
								</tr>
								<tr>
									<td>
										<table width="720" border="0" cellspacing="0" cellpadding="0" style=" margin: 0 auto;border-top:1px solid #f0f0f0;border-bottom:1px solid #f0f0f0;">
											<colgroup>
												<col width="180" />
												<col width="*" />
											</colgroup>
											<tbody>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">판매자명</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;">에타</td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">대표자명</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;">김의종</td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">전화번호</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;">1522-5572</td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;">주소</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left;">서울특별시 성동구 성수이로 22길 37, 아크밸리지식산업센터 906호</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<td height="16"></td>
								</tr>
								<tr>
									<td style="text-align: left;padding-left: 30px;">
										<a href="<?=base_url()?>member/login?return_url=/mywiz/print_order" style="display: block; color: #000; font-size: 12px; line-height: 20px;background: url('http://etah.co.kr/assets/images/mail/bg_dot2.gif') no-repeat 0 9px;padding-left: 9px; text-decoration: none;">세금계산서 신청/구매영수증 출력/상품 배송상태 확인하기 <img src="<?=base_url()?>assets/images/mail/bg_arrow.gif" alt="" style="vertical-align: 1px;" /></a>

										<!--	<a href="#" style="display: block; color: #000; font-size: 12px; line-height: 20px;background: url('http://dev.etah.co.kr/assets/images/mail/bg_dot2.gif') no-repeat 0 9px;padding-left: 9px; text-decoration: none;">이메일주소 변경/주문 결과를 연락받을 수 있는 핸드폰번호 변경하기 <img src="http://dev.etah.co.kr/assets/images/mail/bg_arrow.gif" alt="" style="vertical-align: 1px;" /></a>	-->
									</td>
								</tr>
								<tr>
									<td height="76"></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<!-- // content -->

				<!-- footer // -->
				<tr>
					<td style="border-bottom: 1px solid #999;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td height="21" colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td rowspan="3" width="105" style="vertical-align: top;"><a href="<?=base_url()?>" style="font-size:26px;color: #a3a3a3; text-decoration: none;font-weight: bold;">ETA HOME</a></td>
									<td style="color:#999;font-size:11px;line-height:18px;padding-top: 5px;">
										본 메일은 발신전용 메일이므로 회신이 되지 않습니다. 문의사항은 홈페이지 <a href="<?=base_url()?>customer" style="color: #000; text-decoration: underline;">고객센터</a>를 이용하시기 바랍니다.<br /> This mail is only designated for informing of the mentioned context, Please do not reply to this mail.<br /> Should
										you have any questions or inquiries, please contact our customer service center.
									</td>
								</tr>
								<tr>
									<td height="14"></td>
								</tr>
								<tr>
									<td style="color:#999;font-size:11px;line-height:18px;">
                                        (주)에타		|		서울특별시 성동구 성수이로 22길 37, 아크밸리지식산업센터 906호<br />사업자 등록번호 : 423-81-00385		|		통신판매업 신고번호 : 제 2016-서울강남-02548 호
									</td>
								</tr>
								<tr>
									<td height="27" colspan="2">&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<!-- // footer -->
			</tbody>
		</table>

	</body>

</html>