<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script>
//alert("여기 오나요?");

var STATUS	= "<?=$STATUS?>";
var Message = "<?=$MESSAGE?>";

//alert(STATUS);
if(STATUS == 'success'){
	window.opener.document.OrderForm.imp_uid.value		= "<?=$imp_uid?>";		//아임포트 결제 고유 UID
	window.opener.document.OrderForm.receipt_url.value	= "<?=$receipt_url?>";	//신용카드 매출전표 확인 URL
	window.opener.document.OrderForm.card_name.value	= "<?=$card_name?>";	//카드사명
	window.opener.document.OrderForm.card_quota.value	= "<?=$card_quota?>";	//카드할부개월
	window.opener.document.OrderForm.vbank_name.value	= "<?=$vbank_name?>";	//가상계좌은행명
	window.opener.document.OrderForm.vbank_num.value	= "<?=$vbank_num?>";	//가상계좌번호
	window.opener.document.OrderForm.vbank_date.value	= "<?=$vbank_date?>";
	window.opener.document.OrderForm.pg_tid.value		= "<?=$pg_tid?>";		//PG사 결제번호
	window.opener.document.OrderForm.pay_result.value	= 'Y';					//결제 완료


	//$(parent.document).find("#imp_uid").val(imp_uid);
	//parent.opener.document.OrderForm.receipt_url.value		= "<?=$receipt_url?>";
	//parent.opener.document.OrderForm.card_name.value		= "<?=$card_name?>";	//카드사명
	//parent.opener.document.OrderForm.card_quota.value		= "<?=$card_quota?>";	//카드할부개월
	//parent.opener.document.OrderForm.vbank_name.value		= "<?=$vbank_name?>";	//가상계좌은행명
	//parent.opener.document.OrderForm.vbank_num.value		= "<?=$vbank_num?>";	//가상계좌번호
	//parent.opener.document.OrderForm.vbank_date.value		= "<?=$vbank_date?>";
	//parent.opener.document.OrderForm.pg_tid.value			= "<?=$pg_tid?>";		//PG사 결제번호

} else if(STATUS == 'error_fail'){
	window.opener.document.OrderForm.pay_result.value	= 'N';
	alert(Message);
}

window.open('','_self').close();
</script>