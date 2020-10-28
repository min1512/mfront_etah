			<link rel="stylesheet" href="/assets/css/mypage.css">

			<?
				$date_today = date("Y-m-d", time());
				$date_w1 = date("Y-m-d", strtotime("-1 week"));
				$date_m1 = date("Y-m-d", strtotime("-1 month"));
				$date_m2 = date("Y-m-d", strtotime("-3 month"));
				$date_m3 = date("Y-m-d", strtotime("-6 month"));
			?>

			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">활동 및 문의</h2>
				<div class="prd-order-section mypage-top-btn">
					<h3 class="info-title info-title--sub">1:1 문의</h3>
					<a href="/customer/register_qna" class="btn-prd-order-detail">1:1 문의하기</a>
				</div>
				<div class="mypage-top-select">
					<input type="hidden" id="date_type" value="<?=$date_type?>">
					<ul class="tab-common-mypage-list">
						<li class="tab-common-mypage-item <?=$date_type == '0' ? 'active' : ''?>" id="btn0">
							<a href="javascript:;" onClick="javaScrjpt:jsSetDate(0,'<?=$date_w1?>','<?=$date_today?>');" class="tab-common-mypage-link">1주일</a>
						</li>
						<li class="tab-common-mypage-item <?=$date_type == '1' ? 'active' : ''?>" id="btn1">
							<a href="javascript:;" onClick="javaScript:jsSetDate(1,'<?=$date_m1?>','<?=$date_today?>');" class="tab-common-mypage-link">1개월</a>
						</li>
						<li class="tab-common-mypage-item <?=$date_type == '2' ? 'active' : ''?>" id="btn2">
							<a href="javascript:;" onClick="javaScript:jsSetDate(2,'<?=$date_m2?>','<?=$date_today?>');" class="tab-common-mypage-link">3개월</a>
						</li>
						<li class="tab-common-mypage-item <?=$date_type == '3' ? 'active' : ''?>" id="btn3">
							<a href="javascript:;" onClick="javaScript:jsSetDate(3,'<?=$date_m3?>','<?=$date_today?>');" class="tab-common-mypage-link">6개월</a>
						</li>
					</ul>

					<!-- 달력부분 // -->
					<div class="date_option_select">
						<div class="date_option_select_item">
							<input type="text" class="input-text datepicker" readonly id="date_from" value="<?=$date_from?>"/>
							<button type="button" class="btn_calendar"><span class="spr-common spr-calendar"></span></button>
						</div>
						<span class="date_option_select_dash">~</span>
						<div class="date_option_select_item">
							<input type="text" class="input-text datepicker" readonly id="date_to" value="<?=$date_to?>"/>
							<button type="submit" class="btn_calendar"><span class="spr-common spr-calendar"></span></button>
						</div>
						<button type="button" class="btn-gray btn-check" onClick="javaScript:jsSearch();">조회</button>
					</div>
					<!-- // 달력부분 -->
				</div>


				<!-- 1:1 문의 // -->
				<div class="mypage-qna-box">
					<ul class="prd-qna-list">
					<?
					if($qna_list){
						foreach($qna_list as $row){?>
						<li class="prd-qna-item">
							<!-- 활성화 시 클래스 active 추가 -->
							<!-- 글제목//-->
							<div class="prd-question-box">
								<!-- <span class="prd-ico">Q</span> -->
								<dl class="prd-question">
									<dt class="prd-question-tlt">[<?=$row['CS_QUE_TYPE_CD_NM']?>]<span class="answere-title-color"><?=$row['A_NO'] ? "답변완료" : "답변대기"?></span></dt>
									<dd class="prd-question-tlt"><?=$row['Q_TITLE']?></dd>
									<?if($row['ORDER_GOODS_CD']){?><dd class="prd-question-txt">[<?=$row['ORDER_BRAND_NM']?>] <?=$row['ORDER_GOODS_NM']?> - <?=$row['ORDER_GOODS_OPTION_NM']?></dd><?}?>
								</dl>
								<span class="prd-question-date"><?=$row['Q_REG_DT']?></span>
								<a href="#" class="btn-prd-answere"></a>
							</div>
							<!-- //글제목 -->

							<!-- 답변// -->
							<div class="prd-answere-box">
								<?if($row['ORDER_GOODS_CD']){?>
								<div class="media-area prd-order-media">
									<span class="media-area-img prd-order-media-img"><img src="<?=$row['ORDER_GOODS_IMG_URL']?>" alt=""></span>
									<span class="media-area-info prd-order-media-info">
										<span class="prd-order-media-info-brand"><?=$row['ORDER_BRAND_NM']?></span>
									<span class="prd-order-media-info-name"><?=$row['ORDER_GOODS_NM']?> - <?=$row['ORDER_GOODS_OPTION_NM']?></span>
									</span>
								</div>
								<?}?>

								<div class="media-area prd-order-section">
									<span class="prd-ico">Q</span>
									<p class="prd-answere-txt"><?=$row['Q_CONTENTS']?></p>
									<?if($row['FILE_PATH']){?>
									<div class="prd-answere-img">
										<img src="<?=$row['FILE_PATH']?>" alt="">
									</div>
									<?}?>
									<ul class="media-common-btn-list">
										<li class="media-common-btn-item"><a href="javaScript:;" onClick="javaScript:ModifyQnaOpen('<?=$row['CS_NO']?>');" class="btn-prd-order-detail" >수정</a></li>
										<li class="media-common-btn-item"><a href="javaScript:;" onClick="javaScript:delete_qna('<?=$row['CS_NO']?>');" class="btn-prd-order-detail">삭제</a></li>
									</ul>
								</div>

								<?if($row['A_NO']){?>
								<div class="media-area">
									<span class="prd-ico">A</span>
									<p class="prd-answere-txt"><?=$row['A_CONTENTS']?></p>
								</div>
								<?}?>
							</div>
							<!-- //답변 -->
						</li>
						<?
						}
					}else{?>
						<li class="prd-qna-item">
							<!-- 활성화 시 클래스 active 추가 -->
							<!-- 글제목//-->
							<div class="prd-question-box">
								<!-- <span class="prd-ico">Q</span> -->
								<ul class="check-text-list check-text-list--mypage">
									<li class="check-text-item">
									</li>
								</ul>
								<dl class="prd-question">
									<dt class="prd-question-tlt"></span></dt>
									<dd class="prd-question-tlt">등록된 문의가 없습니다.</dd>
								</dl>
							</div>
						</li>
					<?}?>
					</ul>
					<!-- 페이징
					<div class="page">
						<ul class="page-num-list">
							<li class="page-num-item page-num-left page-num-double-left">
								<a href="#" class="page-num-link"></a>
							</li>
							<li class="page-num-item page-num-left">
								<a href="#" class="page-num-link"></a>
							</li>
							<li class="page-num-item active">
								<a href="#" class="page-num-link">1</a>
							</li>
							<li class="page-num-item">
								<a href="#" class="page-num-link">2</a>
							</li>
							<li class="page-num-item">
								<a href="#" class="page-num-link">3</a>
							</li>
							<li class="page-num-item">
								<a href="#" class="page-num-link">4</a>
							</li>
							<li class="page-num-item">
								<a href="#" class="page-num-link">5</a>
							</li>
							<li class="page-num-item page-num-right active">
								<a href="#" class="page-num-link"></a>
							</li>
							<li class="page-num-item page-num-right page-num-double-right">
								<a href="#" class="page-num-link"></a>
							</li>
						</ul>
					</div>
					페이징  -->

					<?=$pagination?>

					<div id="modify_qna"></div>

				</div>
				<!-- // 1:1 문의 -->

			</div>


			<script>
			//datepicker
			$(function()
			{
				$(".datepicker").datepicker(
				{
					showOn: "button",
					dateFormat: 'yy-mm-dd',
					//numberOfMonths: 1,
					prevText: "",
					nextText: "",
					monthNames: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
					monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
					dayNames: ["일", "월", "화", "수", "목", "금", "토"],
					dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
					dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
					showMonthAfterYear: true,
					yearSuffix: ".",
				});
			});


			/* mypage 1:1문의 */
			$('.btn-prd-answere').click(function()
			{
				var thisParents = $(this).parents('.prd-qna-item')
				if ($(thisParents).hasClass('active'))
				{
					$(thisParents).find('.prd-answere-box').slideUp();
					$(thisParents).removeClass('active');
				}
				else
				{
					$(thisParents).find('.prd-answere-box').slideDown();
					$(thisParents).addClass('active');
				}
				return false;
			});

			$(document).ready(function()
			{
				var fileTarget = $('.file-upload .upload-hidden');

				fileTarget.on('change', function()
				{ // 값이 변경되면
					if (window.FileReader)
					{ // modern browser
						var filename = $(this)[0].files[0].name;
					}
					else
					{
						var filename = $(this).val().split('/').pop().split('\\').pop();
					}

					$(this).siblings('.input-text').val(filename);
				});
			});

			//====================================
			// 날짜버튼
			//====================================
			function jsSetDate(idx, date, date_to){
				for(var i=0; i<4; i++){
					if(idx == i){
						document.getElementById("btn"+i).className = "tab-common-mypage-item active";
						document.getElementById("date_to").value = date_to;
						document.getElementById("date_from").value = date;
					}else{
						document.getElementById("btn"+i).className = "tab-common-mypage-item";
					}
					document.getElementById("date_type").value = idx;
				}
			}

			//====================================
			// 조회
			//====================================
			function jsSearch()
			{
				var date_from	= $('#date_from').val(),
					date_to		= $('#date_to').val(),
					date_type	= $('#date_type').val(),
					page		= 1;

				var param = "";
				param += "page="			+ page;
				param += "&date_from="		+ date_from;
				param += "&date_to="		+ date_to;
				param += "&date_type="		+ date_type;
	
				document.location.href = "/mywiz/qna_page/"+page+"?"+param;
			}

			//====================================
			// 1:1 문의 수정 레이어
			//====================================
			function ModifyQnaOpen(qna_no){
				
				$.ajax({
					type: 'POST',
					url: '/mywiz/layer_modify_qna',
					dataType: 'json',
					data: { qna_no : qna_no},
					error: function(res) {
						alert('Database Error');
					},
					async : false,
					success: function(res) {
						if(res.status == 'ok'){
//								alert("수정되었습니다.");
//								location.reload();
//							alert(res.search_address);
							$("#modify_qna").html(res.modify_qna);

						}
						else alert(res.message);
					}
				});
				

				$('#layerInquireModify').addClass('common-layer-wrap--view');
				
			}

			//=====================================
			// 문의 삭제하기
			//=====================================
			function delete_qna(qna_no){
				if(confirm("문의를 삭제하시겠습니까?")){
					$.ajax({
						type: 'POST',
						url: '/mywiz/delete_qna',
						dataType: 'json',
						data: {	qna_no: qna_no	},
						error: function(res) {
							alert('Database Error');
						},
						success: function(res) {
							if(res.status == 'ok'){
									alert("삭제되었습니다.");
									location.reload();
							}
							else alert(res.message);
						}
					});
				}
			}

			</script>