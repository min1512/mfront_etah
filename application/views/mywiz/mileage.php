			<link rel="stylesheet" href="/assets/css/mypage.css">

			<?
				$date_today = date("Y-m-d", time());
				$date_w1 = date("Y-m-d", strtotime("-1 week"));
				$date_m1 = date("Y-m-d", strtotime("-1 month"));
				$date_m2 = date("Y-m-d", strtotime("-3 month"));
				$date_m3 = date("Y-m-d", strtotime("-6 month"));
			?>
			
			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">나의 혜택관리</h2>
				<div class="mypage-benefit-wrap">
					<h3 class="info-title info-title--sub">마일리지</h3>
					<div class="mypage-use-mileage">
						<p class="mypage-use-mileage-info"><span class="mypage-benefit-mileage spr-common"></span>사용 가능한 마일리지<strong class="mypage-num-info"><?=number_format($mileage)?></strong>마일</p>
						<span class="mypage-benefit-info-sub">(마일리지 보유금액 1,000P이상부터 사용가능합니다.)</span>
					</div>

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

					<div class="basic-table-wrap basic-table-wrap--title-bg">
						<table class="basic-table">
							<colgroup>
								<col style="width:20%;">
								<col style="width:50%;">
								<col style="width:25%;">
								<!--<col style="width:20%;">-->
							</colgroup>
							<thead>
								<tr>
									<th scope="col" class="tb-info-title">유형</th>
									<th scope="col" class="tb-info-title">내용</th>
									<th scope="col" class="tb-info-title">내역</th>
									<!--th scope="col" class="tb-info-title">잔여</th>-->
								</tr>
							</thead>
							<tbody>
							<?if($mileage_list){
								foreach($mileage_list as $row){
							?>
								<tr>
									<td class="tb-info-txt">
										<?=$row['TYPE'] == 'S' ? "적립" : ($row['TYPE'] == 'C' ? "취소" : "사용")?>
									</td>
                                    <td class="tb-info-txt">
                                        <?
                                        switch($row['TYPE']) {
                                            case 'S':
                                                echo "<p>".$row['SAVING_REASON_ETC']."</p>";
                                                break;
                                            case 'C':
                                                echo "주문취소( <a href='/mywiz/order_detail/".$row['ORDER_NO']."'>".$row['ORDER_NO']."</a> )";
                                                break;
                                            case 'P':
                                                echo "주문결제( <a href='/mywiz/order_detail/".$row['ORDER_NO']."'>".$row['ORDER_NO']."</a> )";
                                        }
                                        ?>
<!--                                        --><?//=$row['ORDER_PAY_DTL_NO'] ? "주문결제( <a href='/mywiz/order_detail/".$row['ORDER_NO']."'>".$row['ORDER_NO']."</a> )" : "<p>".$row['SAVING_REASON_ETC']."</p>"?>
                                        <span class="tb-info-txt-sub"><?=$row['REG_DT']?></span></td>
									<td class="tb-info-txt tb-info-txt--num-info">
                                        <?
                                        switch($row['TYPE']) {
                                            case 'S':
                                                echo number_format($row['MILEAGE_AMT']);
                                                break;
                                            case 'C':
                                                echo number_format(substr($row['MILEAGE_AMT'],1));
                                                break;
                                            case 'P':
                                                echo '-'.number_format($row['MILEAGE_AMT']);
                                                break;
                                        }
                                        ?>
<!--                                        --><?//=$row['TYPE'] == 'S' ? number_format($row['MILEAGE_AMT']) : '-'.number_format($row['MILEAGE_AMT'])?>
                                    </td>
									<!--<td class="tb-info-txt tb-info-txt--num-info">1,100</td>-->
								</tr>
								<!--<tr>
									<td class="tb-info-txt">적립</td>
									<td class="tb-info-txt">까사미아 브랜드<br>마일리지 이벤트 상품 구입<span class="tb-info-txt-sub">2016.11.30</span></td>
									<td class="tb-info-txt tb-info-txt--num-info">+11,500</td>
									<td class="tb-info-txt tb-info-txt--num-info">1,100</td>
								</tr>
								<tr>
									<td class="tb-info-txt">적립</td>
									<td class="tb-info-txt">디즈니 액자 마일리지 이벤트 상품 구입<span class="tb-info-txt-sub">2016.11.30</span></td>
									<td class="tb-info-txt tb-info-txt--num-info">+600</td>
									<td class="tb-info-txt tb-info-txt--num-info">1,100</td>
								</tr>-->
							<?
								}
							}else{?>
								<tr>
									<td class="tb-info-txt" colspan="3">마일리지 내역이 없습니다.</td>
								</tr>
							<?}?>
							</tbody>
						</table>
					</div>
				</div>
				<?=$pagination?>
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
	
				document.location.href = "/mywiz/mileage_page/"+page+"?"+param;
			}
			</script>