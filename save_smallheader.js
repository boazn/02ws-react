/*var page = require('webpage').create();
page.open('https://www.02ws.co.il/smallheader.php', function() {
  page.render('02ws_short.png');
  page.close();
  phantom.exit();
});*/


var resourceWait  = 6000,
    maxRenderWait = 10000,
    url           = 'https://www.02ws.co.il/smallheader.php';

var page          = require('webpage').create(),
    count         = 0,
    forcedRenderTimeout,
    renderTimeout;

page.viewportSize = { width: 1024, height : 600 };

function doRender() {
    page.render('02ws_short.png');
	phantom.exit();
}

page.onResourceRequested = function (req) {
    count += 1;
    console.log('> ' + req.id + ' - ' + req.url);
    clearTimeout(renderTimeout);
};

page.onResourceReceived = function (res) {
    if (!res.stage || res.stage === 'end') {
        count -= 1;
        console.log(res.id + ' ' + res.status + ' - ' + res.url);
        if (count === 0) {
            renderTimeout = setTimeout(doRender, resourceWait);
        }
    }
};

page.open(url, function (status) {
    if (status !== "success") {
        console.log('Unable to load url:' + status);
        phantom.exit();
    } else {
        forcedRenderTimeout = setTimeout(function () {
            console.log(count);
            doRender();
        }, maxRenderWait);
    }
});