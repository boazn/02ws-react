var page = require('webpage').create();
page.open('http://www.02ws.co.il/small.php?section=forecast.php', function() {
  var name = '02ws_forecast';
  var now = new Date();
  var month = now.getMonth() + 1;
  name = name + "_" + now.getFullYear()+ month + now.getDate()+ ".png";
  page.render(name);
  phantom.exit();
});
/*page.open('http://www.02ws.co.il/smallheader.php?lang=0', function() {
  page.render('02ws_short_eng.png');
  phantom.exit();
});*/