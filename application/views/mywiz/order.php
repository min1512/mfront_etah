			<link rel="stylesheet" href="/assets/css/mypage.css?ver=1.0">

			<?
				$date_today = date("Y-m-d", time());
				$date_w1 = date("Y-m-d", strtotime("-1 week"));
				$date_m1 = date("Y-m-d", strtotime("-1 month"));
				$date_m2 = date("Y-m-d", strtotime("-3 month"));
				$date_m3 = date("Y-m-d", strtotime("-6 month"));
			?>

			<div class="content">
				<h2 class="page-title-basic page-title-basic--line">쇼핑내역</h2>
				<h3 class="info-title info-title--sub"><?=$title?></h3>

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

				
				<?
				if($order){
					foreach($order as $row){?>
				<div class="prd-order-section">
					<div class="prd-order-top">
						<span class="prd-order-number"><?=$row['ORDER_NO']?> <span class="date">(<?=$row['REG_DT']?>)</span></span>
					</div>
					<div class="media-area prd-order-media">
						<span class="media-area-img prd-order-media-img"><img src="<?=$row['IMG_URL']?>" alt=""></span>
						<a href="/mywiz/order_detail/<?=$row['ORDER_NO']?>" class="media-area-info prd-order-media-info">
							<span class="prd-order-media-info-brand">[<?=$row['BRAND_NM']?>] <?=$row['GOODS_NM']?></span>
						<span class="prd-order-media-info-name"><?=$row['GOODS_OPTION_NM']?> &#47; <?=$row['ORD_QTY']?>개 </span>
						<span class="prd-order-media-info-price">상품금액 <strong class="bold"><?=number_format($row['SELLING_PRICE']);?></strong><span class="won">원</span></span>
						</a>
					</div>
					<div class="prd-order-status">
						<?=$row['ORDER_REFER_PROC_STS_CD_NM']?>
						<?if($row['INVOICE_NO']){?>
                            <a href="#layerMypageShopping" class="btn-gray btn-delivery-check" onClick="javaScript:deliveryCheck('<?=$row['INVOICE_NO']?>', '<?=$row['DELIV_COMPANY_CD']?>');">배송조회</a>
                        <?}?>
                        <?if($row['ORDER_REFER_PROC_STS_CD']=='OE02' && $row['COMMENT_YN']=='Y' && $row['MEMBER_YN']=='Y'){?>
                            <a href="#layerPrdCommentModify" class="btn-white--gray btn-write-review" onClick="javaScript:reg_comment(<?=$row['GOODS_CD']?>, <?=$row['ORDER_REFER_NO']?>);">상품평쓰기</a>
                        <?}?>
					</div>
					<a href="/mywiz/order_detail/<?=$row['ORDER_NO']?>" class="btn-prd-order-detail">상세보기</a>
				</div>
				<?
					}
				}else{
				}?>
				
				<br/></br>
				<?=$pagination?>

				<div id="chk_delivery"></div>
                <div id="write_comment"></div>
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
					title		= "<?=$title?>",
					page		= 1;

				var param = "";
				param += "page="			+ page;
				param += "&date_from="		+ date_from;
				param += "&title="			+ title;
				param += "&date_to="		+ date_to;
				param += "&date_type="		+ date_type;
	
				document.location.href = "/mywiz/order_page/"+page+"?"+param;
			}

			//====================================
			// 배송조회 레이어
			//====================================
			function check_delivery(order_no, order_refer_no){
				
				$.ajax({
					type: 'POST',
					url: '/mywiz/layer_check_delivery',
					dataType: 'json',
					data: { order_no : order_no,
							order_refer_no : order_refer_no},
					error: function(res) {
						alert('Database Error');
					},
					async : false,
					success: function(res) {
						if(res.status == 'ok'){
//								alert("수정되었습니다.");
//								location.reload();
//							alert(res.search_address);
							$("#chk_delivery").html(res.delivery);

						}
						else alert(res.message);
					}
				});
				

				$('#layerMypageShopping').addClass('common-layer-wrap--view');
				
			}

            //=====================================
            // 배송조회
            //=====================================
            function deliveryCheck(invoice_no, deli_com){
                switch(deli_com){

                    // 굿스플로어 조회
                    case '2'  : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/kdexp/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//경동
                    case '23' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/korex/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//CJGLS
                    case '40' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/korex/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//CJ GLS(HTH통합)
                    case '38' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/korex/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//HTH(EDI)
                    case '10' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/epost/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//우체국
                    case '15' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/chunil/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//천일
                    case '19' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/hanjin/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//한진
                    case '20' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/lotte/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//롯데
                    case '91' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/ems/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"                 ); break;	//EMS
                    case '96' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/aciexpress/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"          ); break;	//ACI
                    case '39' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/ilyang/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//일양
                    case '27' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/logen/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//로젠
                    case '70' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/usps/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"                ); break;	//미국우정청(USPS)
                    case '44' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/hanjin/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//네덱스(에스지엔지-한진물류대행)
//                    case '24' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/kgbps/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//KGB
                    case '45' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/daesin/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"              ); break;	//대신
                    case '48' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/hdexp/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"               ); break;	//합동
                    case '14' : window.open(" http://b2c.goodsflow.com/zkm/V1/whereis/yic/kunyoung/"+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"            ); break;	//건영
                    // 드림택배 조회  --> 2018.08.21부로 부도 KGB로 조회가능.
                    case '8'  : window.open(" http://www.idreamlogis.com/delivery/delivery_result.jsp?item_no="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes" ); break;	//드림(옐로우캡)
                    case '35' : window.open(" http://www.idreamlogis.com/delivery/delivery_result.jsp?item_no="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes" ); break;	//드림(동부)
                    case '47' : window.open(" http://www.idreamlogis.com/delivery/delivery_result.jsp?item_no="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes" ); break;	//드림(KG로지스)

                    //KGB택배
                    case '24' : window.open(" https://www.kgbps.com/delivery/delivery_result.jsp?item_no="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"      ); break;  //KGB

                    // 별도조회
                    case '37' : window.open(" http://innogis-d.com/invoice.asp?invoice="+invoice_no, "window", "width=700,height=700, status=yes, resizable=yes, scrollbars=yes"                        ); break;	//이노지스

                    // ETC
                    case 'GLOBAL' : window.open(" http://www.tntnhan.com/delivery/trackingSch/"+invoice_no, "window", " status=yes, resizable=yes, scrollbars=yes"                 ); break;

                    // 기타 직배송
                    default : alert("배송추적이 불가능한 직배송 상품입니다."); break;
                }
            }

            //=====================================
            // 상품평쓰기 레이어
            //=====================================
            function reg_comment(goods_cd, order_refer_no){
                $.ajax({
                    type: 'GET',
                    url: '/mywiz/layer_reg_comment',
                    dataType: 'json',
                    data: { goods_cd : goods_cd,
                        order_refer_no : order_refer_no},
                    error: function(res) {
                        alert('Database Error');
                    },
                    async : false,
                    success: function(res) {
                        if(res.status == 'ok'){
                            console.log(res.message);
                            $("#write_comment").html(res.comment);
                            $('#layerPrdCommentModify').addClass('common-layer-wrap--view');
                        }
                        else if(res.status == 'fail'){
                            alert(res.message);
                        }
                        else alert(res.message);
                    }
                });
            }
			</script>