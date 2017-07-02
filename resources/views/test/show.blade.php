<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	
</body>
	<script>
		var browser = '';
		var browserVersion = 0;

		if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
		    browser = 'Opera';
		} else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) {
		    browser = 'MSIE';
		} else if (/Navigator[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
		    browser = 'Netscape';
		} else if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
		    browser = 'Chrome';
		} else if (/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
		    browser = 'Safari';
		    /Version[\/\s](\d+\.\d+)/.test(navigator.userAgent);
		    browserVersion = new Number(RegExp.$1);
		} else if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
		    browser = 'Firefox';
		}
		if(browserVersion === 0){
		    browserVersion = parseFloat(new Number(RegExp.$1));
		}
		console.log(browser + "*" + browserVersion);
	</script>
</html>