<style>
 #sigrunwalkextended{
	<?if (isHeb()) echo "direction:rtl"; else echo "direction:ltr";?>;
	 
 }
</style>
<h1><?=$RUN_WALK[$lang_idx]?></h1>
<br/>
<br/>
<div class="big exp" >
<ul id="sigrunwalkextended">
                                <?
                                //if (count($sigRun) > 2)
                                        for ($i = 0; $i < count($sigRun); $i++) {

                                        echo "<li>";
                                        echo "<a class=\"hlink\" style=\"font-weight:normal\" title=\"\" href=\"".$_SERVER['SCRIPT_NAME'].$sigRun[$i]['url']."\" >{$sigRun[$i]['sig'][$lang_idx]} "." <br/> ".$sigRun[$i]['extrainfo'][$lang_idx][0].get_arrow()."</a></li>\n";          
                                } 
                                ?> 
                                </ul>      
</div>
<a href="runningtreks.php?lang=<? echo $lang_idx;?>" class="hlink"><? echo $RUNNING_TREKS[$lang_idx].get_arrow();?></a>