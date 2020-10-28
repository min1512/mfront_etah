
<!DOCTYPE html>
<html lang="ko-KR">

	<head>
		<title>ETAHOME MOBILE</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta id="web_image" property="og:image" content="http://www.etah.co.kr/assets/images/common/etah_image.png" />
		<link rel="shortcut icon" href="/favicon.ico">

		<style type="text/css">
			body {
				margin: 0;
			}

			li {
				list-style: none;
			}

			a {
				color: #999;
				text-decoration: none;
			}
			/* button */

			.common-btn-box .common-btn-item+.common-btn-item {
				margin-left: 10px;
			}

			.common-btn-box {
				padding: 10px 15px;
				display: flex;
				width: 100%;
				box-sizing: border-box;
			}

			.common-btn-item {
				flex: 1;
				font-size: 11px;
				text-align: center;
			}

			.btn-gray {
				display: block;
				padding: 0.5rem 0;
				border: 1px solid #6e6e6e;
				background: #6e6e6e;
				color: #fff;
				box-sizing: border-box;
				text-align: center;
				font-size: 15px;
				height: 40px;
				line-height: 40px;
				padding: 0;
			}

			.btn-black {
				display: block;
				padding: 0;
				border: 1px solid #000;
				background: #000;
				font-size: 15px;
				height: 40px;
				line-height: 40px;
				color: #fff;
				box-sizing: border-box;
				text-align: center;
			}

			.error-page {
				padding-top: 50px;
			}

			.error-page-result {
				position: relative;
			}

			.error-page-txt {
				margin-top: 110px;
				margin-bottom: 13px;
				font-size: 15px;
				text-align: center;
				color: #000;
			}

			.error-page-txt-sub {
				padding-bottom: 25px;
				font-size: 11px;
				text-align: center;
				color: #666;
				line-height: 20px;
			}

			.error-page-ico {
				display: block;
				position: absolute;
				top: -75px;
				left: 50%;
				text-align: center;
				width: 14px;
				height: 80px;
				background-image: url("../assets/images/error/error_img.jpg");
				background-repeat: no-repeat;
			}
            
			.error-page-ico:after {
				display: inline-block;
				width: 75px;
				height: 75px;
				border: 3px solid #f3f3f3;
				position: absolute;
				top: -20px;
				left: 3px;
				border-radius: 50%;
				content: '';
				transform: translateX(-50%);
			}

			.text-list {
				padding: 15px 0;
				background: #f6f6f6;
				border-top: 1px solid #ebebeb;
			}

			.text-item {
				color: #666;
				font-size: 11px;
				line-height: 15px;
				text-indent: -7px;
				padding-left: 7px;
				margin: 0 15px;
				display: block;
			}

			.text-item+.text-item {
				padding-top: 5px;
			}

			.text-item:before {
				display: inline-block;
				content: '';
				width: 2px;
				height: 2px;
				background: #d7d7d7;
				border-radius: 50%;
				vertical-align: middle;
				margin-right: 5px;
			}

			.text-color {
				color: #000;
			}
		</style>
	</head>

	<body>
		<div class="error-page">
			<div class="error-page-wrap">
				<div class="error-page-result">
					<span class="error-page-ico"></span>
					<p class="error-page-txt"><strong>404 ERROR</strong></p>
					<p class="error-page-txt-sub">죄송합니다.<br>요청하신 페이지를 찾을 수 없습니다.</p>
				</div>
				<ul class="text-list">
					<li class="text-item">일시적으로 요청하신 페이지를 사용하지 못하는 것일 수 있습니다.</li>
					<li class="text-item">요청하신 페이지가 변경되었거나 삭제되어 찾을 수 없을 수<br> 있습니다. (이벤트의 경우 종료 후 삭제될 수 있습니다.)</li>
					<li class="text-item">문의사항은 고객센터 02-569-6227로 문의주시거나,<br><span class="text-color">MY PAGE > 1:1 문의하기</span>를 이용하여 주세요.</li>
				</ul>
			</div>
			<ul class="common-btn-box">
				<li class="common-btn-item"><a href="#" class="btn-gray">이전 페이지로</a></li>
				<li class="common-btn-item"><a href="/" class="btn-black">홈으로</a></li>
			</ul>
		</div>
	</body>

</html>