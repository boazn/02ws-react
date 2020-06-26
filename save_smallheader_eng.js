var page = require('webpage').create();
page.open('http://www.02ws.co.il/smallheader.php?lang=0', function() {
  page.render('02ws_short_eng.png');
  page.close();
  phantom.exit();
});
