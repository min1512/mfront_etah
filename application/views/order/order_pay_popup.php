<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.2.js"></script>
<script type="text/javascript">

function req_approval00()
{
	//결제코드
	var IMP = window.IMP;
	IMP.init('imp46808156'); // 'iamport' 대신 부여받은 "가맹점 식별코드"를 사용.
	var SSL_val = "<?=$_SERVER['HTTP_HOST']?>";

//	if(document.getElementById("formpay01").checked || document.getElementById("formpay03").checked || document.getElementById("formpay04").checked ){
//
//		if(document.getElementById("formpay01").checked){    //이니페이:카드
//			document.OrderForm.order_payment_type.value  = "01";
//			document.OrderForm.gopaymethod.value     = "card";
////			document.OrderForm.paymethod.value       = "onlycard";
//		} else if(document.getElementById("formpay03").checked){   //이니페이:계좌이체
//			document.OrderForm.order_payment_type.value  = "03";
//			document.OrderForm.gopaymethod.value     = "trans";
////			document.OrderForm.paymethod.value       = "onlydbank";
//		} else if(document.getElementById("formpay04").checked){  //이니페이:가상계좌
//                document.OrderForm.order_payment_type.value  = "02";
//                document.OrderForm.gopaymethod.value     = "vbank";
////                document.OrderForm.paymethod.value       = "onlyvbank";
//        }
//부모창 제어를 하기 위해선 프로토콜 타입을 https://로 동일하게 맞춰줘야함.	2017-01-02
//alert($(opener.document).find('input[name=escrowuse]').val());
		if($(opener.document).find('input[name=escrowuse]').val() == 'Y'){	//에스크로여부 동의했을경우
			var escrow_yn	= true;
		} else {
			var escrow_yn	= false;
		}
//alert($(opener.document).find('input[name=goodname]').val());
//alert($(opener.document).find('input[name=gopaymethod]').val());
//alert($(opener.document).find('input[name=buyeremail]').val());
//alert($(opener.document).find('input[name=buyername]').val());
//alert($(opener.document).find('input[name=buyertel]').val());
//alert($(opener.document).find('input[name=order_addr1]').val()+$(opener.document).find('input[name=order_addr2]').val());
//alert($(opener.document).find('input[name=order_postnum]').val());
//alert($(opener.document).find('input[name=total_payment_money]').val());

		var order_name	= $(opener.document).find('input[name=goodname]').val();
		var pay_method	= $(opener.document).find('input[name=gopaymethod]').val();
		var b_email		= $(opener.document).find('input[name=buyeremail]').val();
		var b_name		= $(opener.document).find('input[name=buyername]').val();
		var b_tel		= $(opener.document).find('input[name=buyertel]').val();
		var b_addr		= $(opener.document).find('input[name=order_addr1]').val()+$(opener.document).find('input[name=order_addr2]').val();
		var b_postcode	= $(opener.document).find('input[name=order_postnum]').val();
		var pay_amonut	= $(opener.document).find('input[name=total_payment_money]').val();
		var nowDate		= "<?=date('Ymd')+3?>";

//		var order_name	= "결제테스트강민경";
//		var pay_method  = "vbank";
//		var b_email		= "pipi0824@naver.com";
//		var b_name		= "결제테스트강민경";
//		var b_tel		= "01028001923";
//		var b_addr		= "서울시 강남구 논현로 71길 18 (신성타워) 2층";
//		var b_postcode	= "06248";
//		var nowDate		= "20170102";
//		var pay_amonut	= "1000";
//		var escrow_yn	= false;


		IMP.request_pay({
		pg : 'inicis', // version 1.1.0부터 지원.
			/*
				'kakao':카카오페이,
				'inicis':이니시스, 'html5_inicis':이니시스(웹표준결제),
				'nice':나이스,
				'jtnet':jtnet,
				'uplus':LG유플러스,
				'danal':다날
			*/
		pay_method : pay_method, // 'card':신용카드, 'trans':실시간계좌이체, 'vbank':가상계좌, 'phone':휴대폰소액결제
		escrow : escrow_yn,
		merchant_uid : 'merchant_' + new Date().getTime(),
		name : order_name,
		amount : pay_amonut,
		buyer_email : b_email,
		buyer_name : b_name,
		buyer_tel : b_tel,
		buyer_addr : b_addr,
		buyer_postcode : b_postcode,
		vbank_due : nowDate,
		m_redirect_url : 'https://'+SSL_val+'/order/pay_result'
	}, function(rsp) {		//모바일에선 페이지가 날라가버려서 아래 내용 실행 안하고 /order/pay_result로 바로 넘어감
		if ( rsp.success ) {
			var msg = '결제가 완료되었습니다.';
			msg += '고유ID : ' + rsp.imp_uid;
			msg += '상점 거래ID : ' + rsp.merchant_uid;
			msg += '결제 금액 : ' + rsp.paid_amount;
			msg += '카드 승인번호 : ' + rsp.apply_num;

			window.opener.document.OrderForm.imp_uid.value		= rsp.imp_uid;			//아임포트 결제 고유 UID
			window.opener.document.OrderForm.receipt_url.value	= rsp.receipt_url;		//신용카드 매출전표 확인 URL
			window.opener.document.OrderForm.card_name.value	= rsp.card_name;		//카드사명
			window.opener.document.OrderForm.card_quota.value	= rsp.card_quota;		//카드할부개월
			window.opener.document.OrderForm.vbank_name.value	= rsp.vbank_name;		//가상계좌은행명
			window.opener.document.OrderForm.vbank_num.value	= rsp.vbank_num;		//가상계좌번호
			window.opener.document.OrderForm.vbank_date.value	= rsp.vbank_date;
			window.opener.document.OrderForm.pg_tid.value		= rsp.pg_tid;
			window.opener.document.OrderForm.pay_result.value	= 'Y';					//결제 완료

			window.open('','_self').close();

//			var param = $(opener.document).find("#OrderForm").serialize();
//            $.ajax({
//                type: 'POST',
//                url: 'https://'+SSL_val+'/order/process',
//                dataType: 'json',
//                data: param,
//                error: function(res) {
//                    alert('Database Error');
//                },
//                success: function(res) {
//                    if(res.status == 'ok'){
//						location.href = 'https://'+SSL_val+'/cart/Step3_Order_finish?order_no='+res.order_no;
//                    }
//                    else alert(res.message);
//                }
//            });
		} else {
			window.opener.document.OrderForm.pay_result.value	= 'N';
			var msg = '결제에 실패하였습니다.';
			msg += '에러내용 : ' + rsp.error_msg;

			alert(msg);

			window.open('','_self').close();
		}
	});

return false;

//    }

}

req_approval00();

</script>