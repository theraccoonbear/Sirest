if (typeof jQuery !== 'undefined') {
	$(function() {
		var docHost = window.location.hostname;
		var js = document.getElementById('sirest_bootstap');
		if (js != null && js !== undefined && typeof js.src !== 'undefined') {
			var jsHost = js.src;
			var hostRgx = /https?:\/\/([^:\/]+)/i;
			if (hostRgx.test(jsHost)) {
				var m = hostRgx.exec(jsHost);
				jsHost = m[1];
				
				
				var loadSirestJs = function() {
					var siresURL = 'http://' + jsHost + '/js/sirest.js';
					var sirestScript = document.createElement('script');
					sirestScript.src = siresURL;
					document.body.appendChild(sirestScript);
				}
				
				var loadClassJs = function() {
					var classURL = 'http://' + jsHost + '/js/Class.js';
					var classScript = document.createElement('script');
					classScript.src = classURL;
					classScript.onload = loadSirestJs;
					document.body.appendChild(classScript);
				}
				
				loadClassJs();
				
			} else {
				alert('unable to determine script hostname');
			}
		} else {
			alert('Give your script tag an id of "sirest_bootstap"');
		}
	});
} else {
	alert('include jQuery');
}