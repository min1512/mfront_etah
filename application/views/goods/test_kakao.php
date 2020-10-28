
<!DOCTYPE html>
<html lang="ko-KR">

	<head>
		<title>ETAH GUIDE FONTS</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="viewport" name="viewport" content="width=device-width, initial-scale=1">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

		<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<body>
	<div class="wrap">
	<button id="kakao-link-btn" onClick="javaScript:test();">카카오톡</button>
	<a href="javaScript:;"  onClick="javaScript:test();"id="kakao-link-btn">카카오톡</a>
	</div>
</body>

<script>

function test(){
	Kakao.init('4afa67f9303fa8229564d3721dac2b66');
	Kakao.Link.createTalkLinkButton({
		container: '#kakao-link-btn',
		label: '썸네일 이미지 위에 뜰 텍스트 입니다.',
		image: {
			src: 'https://i.vimeocdn.com/portrait/58832_300x300',
			width: '300',
			height: '200'
		},
		webButton: {
			text: '트라이트라이',
			url: 'http://devm.etah.co.kr/'
		}
	});
}

</script>
