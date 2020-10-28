<!--
								<tr>
									<td style="color:#999;font-size:14px;text-align: center;"><em style="color: #000; font-style:normal;">문의유형 : {{type}}</em></td>
								</tr>
								<tr>
									<td style="color:#999;font-size:14px;text-align: center;"><em style="color: #000; font-style:normal;">문의자명 : {{name}}</em></td>
								</tr>
								<tr>
									<td style="color:#999;font-size:14px;text-align: center;"><em style="color: #000; font-style:normal;">연락처   : {{phone}}</em></td>
								</tr>
								<tr>
									<td style="color:#999;font-size:14px;text-align: center;"><em style="color: #000; font-style:normal;">문의제목 : {{title}}</em></td>
								</tr>
								<tr>
									<td style="color:#999;font-size:14px;text-align: center;"><em style="color: #000; font-style:normal;">문의내용 : {{content}}</em></td>
								</tr>
								<tr>
									<td height="15"></td>


-->


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
									<td width="642"><a href="#" style="font-size:26px;color: #000; text-decoration: none;font-weight: bold;">ETA HOME</a></td>
									<td width="60"><a href="#" style="display: block;color: #999; font-size: 12px; text-decoration: none; padding-top: 8px;text-align: center;">마이페이지 </a></td>
									<td width="28">
										<a href="#" style="display: block;text-align: center; padding-top: 8px;text-align: center;"><img src="//ui.etah.co.kr/assets/images/mail/bg_bar.gif" alt="" style="border: 0 none;" /></a>
									</td>
									<td width="50"><a href="#" style="display: block;color: #999; font-size: 12px; text-decoration: none; padding-top: 8px;text-align: right;">고객센터</a></td>
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
									<td style="font-size: 30px; color:#000;text-align: center;">문의하신 내용입니다.</td>
								</tr>
								<tr>
									<td height="12"></td>
								</tr>
								<tr>
									<td style="color:#999;font-size:14px;text-align: center;"><em style="color: #000; font-style:normal;">{{name}}</em> 님 안녕하세요? 에타몰입니다.</td>
								</tr>
								<tr>
									<td height="15"></td>
								</tr>
								<tr>
									<td height="1" style="color:#999;font-size:14px;text-align: center;"><img src="http://ui.etah.co.kr/assets/images/mail/bg_line.gif" alt="" style="border: 0 none;" /></td>
								</tr>
								<tr>
									<td height="23"></td>
								</tr>
								<tr>
									<td style="color:#999;font-size:12px;text-align: center;line-height: 18px;"><em style="color: #000; font-style:normal;">{{date}}</em> 문의하신 내역입니다.<br />앞으로 <em style="color: #000; font-style:normal;">{{name}}</em> 님의 행복 쇼핑을 위해 언제나 곁에서 함께하겠습니다.</td>
								</tr>
								<tr>
									<td height="25"></td>
								</tr>
								<tr>
									<td height="53" style="border-bottom: 1px solid #eee;"></td>
								</tr>
								<tr>
									<td height="35"></td>
								</tr>
								<tr>
									<td style="color:#000;font-size:18px; padding-left: 30px;">질문내용</td>
								</tr>
								<tr>
									<td height="19"></td>
								</tr>
								<tr>
									<td style="padding-left: 30px;">
										<table width="720" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #eee;background: #f6f6f6;">
											<colgroup>
												<col width="49" />
												<col />
											</colgroup>
											<tbody>
												<tr>
													<td height="15" colspan="2"></td>
												</tr>
												<tr>
													<td style="padding-top: 2px;vertical-align: top;text-align: center;color: #212121;font-size: 15px;font-family: 'NanumMyeongjo', '나눔명조', 'Nanum Myeongjo', sans-serif;font-weight: 600;">Q</td>
													<td style="color: #999;line-height: 20px;font-size:12px;padding-left: 2px;">
														{{title}}<br/><br/>
														{{content}}
													</td>
												</tr>
												<tr>
													<td height="18" colspan="2"></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<td height="36"></td>
								</tr>
								<!--
								<tr>
									<td style="color:#000;font-size:18px; padding-left: 30px;">답변내용</td>
								</tr>
								<tr>
									<td height="19"></td>
								</tr>
								<tr>
									<td style="padding-left: 30px;">
										<table width="720" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #eee;background: #f6f6f6;">
											<colgroup>
												<col width="49" />
												<col />
											</colgroup>
											<tbody>
												<tr>
													<td height="15" colspan="2"></td>
												</tr>
												<tr>
													<td style="padding-top: 2px;vertical-align: top;text-align: center;color: #212121;font-size: 15px;font-family: 'NanumMyeongjo', '나눔명조', 'Nanum Myeongjo', sans-serif;font-weight: 600;">A</td>
													<td style="color: #999;line-height: 20px;font-size:12px;padding-left: 2px;">
														물론 퀵서비스 발송은 가능합니다만<br />퀵서비스인만큼 운임이 비싸다는 점은 꼭 숙지를 해주셔야 합니다
													</td>
												</tr>
												<tr>
													<td height="18" colspan="2"></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
								-->
								<tr>
									<td height="80"></td>
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
									<td rowspan="3" width="105" style="vertical-align: top;"><a href="#" style="font-size:26px;color: #a3a3a3; text-decoration: none;font-weight: bold;">ETA HOME</a></td>
									<td style="color:#999;font-size:11px;line-height:18px;padding-top: 5px;">
										본 메일은 발신전용 메일이므로 회신이 되지 않습니다. 문의사항은 홈페이지 <a href="#" style="color: #000; text-decoration: underline;">고객센터</a>를 이용하시기 바랍니다.<br /> This mail is only designated for informing of the mentioned context, Please do not reply to this mail.<br /> Should
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