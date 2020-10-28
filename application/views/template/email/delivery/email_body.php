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
									<td style="font-size: 30px; color:#000;text-align: center;">주문하신 상품이 발송되었습니다.</td>
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
									<td style="color:#999;font-size:12px;text-align: center;line-height: 18px;"><em style="color: #000; font-style:normal;"><?=substr($order_date,0,4)?>년 <?=substr($order_date,5,2)?>월 <?=substr($order_date,8,2)?>일</em> 주문하신 상품이 <em style="color: #000; font-style:normal;"><?=substr($deliv_date,0,4)?>년 <?=substr($deliv_date,5,2)?>월 <?=substr($deliv_date,8,2)?>일</em>에 발송되었습니다.<br />항상 에타몰을 이용해 주셔서 감사합니다.</td>
								</tr>
								<tr>
									<td height="25"></td>
								</tr>
								<tr>
									<td height="56">
										<div style="width:167px;height:35px;text-align:center;margin: 0 auto;"><a href="<?=base_url()?>member/login?return_url=/mywiz/order" style="display:block;padding:9px 0 10px;text-align:center;color:#fff;font-size:12px;background:#000;text-decoration:none;">주문내역/배송현황 보기</a></div>
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
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">상품명</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;"><span style="color: #000;">[<?=$brand_name?>]</span> <?=$goods_name?></td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">판매자/연락처</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;">에타몰 / 1522-5572</td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">상품발송일</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;"><?=substr($deliv_date,0,4)?>년 <?=substr($deliv_date,5,2)?>월 <?=substr($deliv_date,8,2)?>일 / 택배사 : <?=$deliv_company_name?> / 송장번호 : <a href="<?=$delivAddress?>" target="_blank"><?=$invoice_no?></a></td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;border-bottom: 1px solid #f0f0f0; ">수취인</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left; border-bottom: 1px solid #f0f0f0;"><?=$receiver_name?></td>
												</tr>
												<tr>
													<th height="39" style="font-weight: normal;padding-left: 20px; background: #f6f6f6;color: #666;font-size:12px;text-align: left; border-right: 1px solid #f0f0f0;">배송지주소</th>
													<td height="39" style="padding-left: 20px; color: #666;font-size:12px;text-align: left;"><?=$receiver_addr?></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<td height="8"></td>
								</tr>
								<tr>
									<td style="text-align: left;padding-left: 30px;">
										<span style="display: block; color: #999; font-size: 11px; line-height: 18px;background: url('http://etah.co.kr/assets/images/mail/bg_dot.gif') no-repeat 0 7px;padding-left: 9px;">장바구니에 여러 상품이 있는 경우, 상품별로 배송될 수 있으며 각 상품들이 발송될때마다 확인메일을 보내드립니다.</span>
										<span style="display: block; color: #999; font-size: 11px; line-height: 18px;background: url('http://etah.co.kr/assets/images/mail/bg_dot.gif') no-repeat 0 7px;padding-left: 9px;">위 상품의 주문진행상태를 확인하고 싶으시면 <span style="color: #000;"><a href="<?=base_url()?>member/login?return_url=/mywiz" style="text-decoration: underline; color: #000;">'마이페이지</a> > <a href="<?=base_url()?>member/login?return_url=/mywiz/order" style="text-decoration: underline; color: #000;">주문배송조회'</a></span>을
										클릭해 주세요.</span>
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
									<td rowspan="3" width="105" style="vertical-align: top;"><a href="<?=base_url()?>" style="font-size:26px;color: #a3a3a3; text-decoration: none;font-weight: bold;">ETAH</a></td>
									<td style="color:#999;font-size:11px;line-height:18px;padding-top: 5px;">
										본 메일은 발신전용 메일이므로 회신이 되지 않습니다. 문의사항은 홈페이지 <a href="<?=base_url()?>customer" style="color: #000; text-decoration: underline;">고객센터</a>를 이용하시기 바랍니다.<br /> This mail is only designated for informing of the mentioned context. Please do not reply to this mail.<br /> Should
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