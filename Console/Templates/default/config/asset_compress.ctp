[General]
cacheConfig = false

; javascript build instructions
[js]
paths[] = APP/webroot/js/*
paths[] = APP/Assets/scripts/*
cachePath = WEBROOT/js/
timestamp = false

; css build instructions  
[css]
paths[] = APP/Assets/styles/*
paths[] = APP/webroot/css/*
cachePath = WEBROOT/css/
timestamp = false
filters[] = ScssPHP
filters[] = CssMinFilter

[libs.js]
files[] = jquery-1.10.2.min.js
files[] = jquery-ui-1.10.3.custom.min.js
files[] = jquery.flexslider-min.js
files[] = jquery.als-1.2.min.js

[application.js]
files[] = jquery.meanmenu.js
files[] = fancySelect.js
files[] = jquery.cookie.js
files[] = base.js
filters[] = JsMinFilter

[application.css]
files[] = base.scss


[libs.css]
files[] = flexslider.css
files[] = meanmenu.css
files[] = fancySelect.css
files[] = dev.css