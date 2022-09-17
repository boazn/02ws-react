
    <style>
      #baseGraph, #rainDailyGraph, .imgresponsive {
              width:315px
          }
      @media only screen and (min-width: 1500px) {
          #baseGraph, #rainDailyGraph, .imgresponsive {
              width:630px
          }
      }
      #moregraphs{ 
		list-style-type: bullet;float:<?=get_s_align();?>;margin-<?=get_s_align();?>:2em
	}
	#relatedgraphs{ 
		list-style-type: bullet;width: 180px;margin-<?=get_s_align();?>:3em
	}
	#currentinfo_container
	{
		font-size: 1.2em;
		float:none;
		margin-bottom: 2em;
		background: white;
	}
	#latestrain .trendstable
	{
		top: 6.5em
	}
	#latestrain .paramtrend
	{
		top: 5.7em;
		font-size: 0.8em;
	}
	#latestrain .highlows
	{
		top:3.6em
	}
	.graphslink
	{
		visibility:hidden;
	}
    .inparamdiv{
		height:280px;
	}         
      
      
      
  </style>

  <div class="inv_plain_3 float" style="padding:1em">
      <div>
          <img name="baseGraph" id="baseGraph" src="https://www.02ws.co.il/images/profile2/dustLatestArchive.php?level=1&freq=2&datasource=LatestArchive.csv&&lang=1" />
      </div>
  <div class="inv_plain_3 float" style="padding:1em">
<a href="https://meteologix.com/il/satellite/satellite-dust-15min.html" rel="external" title="אבק זמן אמת"><img src="images/tn_rgb_composites.jpg" width="50px" alt="אבק זמן אמת"/><br/>אבק זמן אמת</a>
</div>
 </div>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript">
    $('#startinfo_container').hide();
    $('#info_btns').hide();
    $('#legends').hide();
    $('#for24_given').hide();
    $('#graph_forcastWrapper').hide();
    $('#adunit3').hide();
    $('#for24_hours').hide();
    $('#currentinfo_container').css("margin-top", "7em").show();
    $('#spacer1, #spacer2, #spacer3, #spacer4').hide();
    $(document).ready(function() {
    $('#aq_btn').click();
    });
</script>
