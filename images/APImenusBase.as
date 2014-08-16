

//BUILD MENUS: #################################################
APIarguments.push(
  "MENU0","horizontal","fixo",
  "Data"        ,"","MENU1",
  "Whats new"    ,"whatsnew.htm","MENU2",
  "Pictures"  ,"pictures.htm","MENU3",
  "Guest Book"     ,"guestbook.php","MENU4",
  "Links","","MENU5",
  "Contact info","../WAP/",""
)
dummy = addMENU()

APIarguments.push(
  "MENU1","vertical","flutuante",
  "Current data","Current_Vantage_Pro.htm","",
  "Complete data","Tag-List.htm","",
  "summary","","MENU1_1",
  "Extreme records", "records.htm","",
  "Browse last 2 days","reports/downld02.txt","",
  "Browse date...","","",
  "Averages","averages.html",""
)
dummy = addMENU()

APIarguments.push(
  "MENU5","vertical","flutuante",
  "My general site"         ,"http://boaz.has.it","",
  "My station at NOAA","http://www.findu.com/cgi-bin/wxpage.cgi?call=CW0641"  ,"",
  "Stations at NOAA", "http://www-frd.fsl.noaa.gov/mesonet/","",
  "METAR", "http://weather.noaa.gov/pub/data/observations/metar/decoded/LLJR.TXT"    ,"",
  "forum ", "http://www.tapuz.co.il/tapuzforum/main/forumpage.asp?id=393" ,"",
  "Weather site ", "http://www.israelweather.co.il",""
)
dummy = addMENU()



APIarguments.push(
  "MENU1_1","vertical","flutuante",
  "This Month","reports/NOAAMO.TXT","",
  "This Year", "reports/NOAAYR.TXT","",
  "Last month", "reports/NOAAPRMO.TXT","",
  "Last year", "reports/NOAAPRYR.TXT","",
  "choose month...", "choose.htm",""
)
dummy = addMENU()





