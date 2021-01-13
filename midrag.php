<? $section="";
if ($_GET['ntla'] != "") {$section="Search/Results?ntla=".$_GET['ntla'];}
 else if ($_GET['serviceId'] != "") {$section="Search/Results?serviceId=".$_GET['serviceId']."&cityId=".$_GET['cityId']."&areaId=".$_GET['areaId']; }?>
 <iframe src="https://www.midrag.co.il/pages/02ws/<?=$section?>" style="height:3000px;width:100%;border:none" border="0"></iframe>
