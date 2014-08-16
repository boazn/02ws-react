<?php 
			class WeatherParams{
					var $date;
					var $time;
					var $day;
					var $temp;
					var $dew;
					var $pressure;
					var $hum;
					var $windspd;
					var $rainrate;
					var $light = true;
					
				 function set_time($time){
				 		$this->time = $time;
				 }
				 function set_date($date){
				 		$this->date = $date;
				 }
				 function set_day($day){
				 		$this->day = $day;
				 }
				 function set_temp($temp){
				 		$this->temp = $temp;
				 }
				 function set_dew($dew){
				 		$this->dew = $dew;
				 }
				 function set_hum($hum){
				 		$this->hum = $hum;
				 }
				 function set_windspd($wind){
				 		$this->windspd = $wind;
				 }
				 function set_rainrate($rrate){
				 		$this->rainrate = $rrate;
				 }
				 function set_pressure($bar){
				 		$this->pressure = $bar;
				 }
				 function set_dark(){
				    $this->light = false;
				 }
				 function set_light(){
				    $this->light = true;
				 }
				 function get_date(){
				 		return $this->date;
				 }
				 function get_time(){
				 		return $this->time;
				 }
				 function get_temp(){
				 		return $this->temp;
				 }
				 function get_dew(){
				 		return $this->dew;
				 }
				 function get_hum(){
				 		return $this->hum;
				 }
				 function get_windspd(){
				 		return $this->windspd;
				 }
				 function get_pressure(){
				 		return $this->pressure;
				 }
				 function get_rainrate(){
				 		return $this->rainrate;
				 }
				 function is_light(){
				    return $this->light;
				 }
			}

			class WeatherExtreme{
						var $hightemp;
						var $lowtemp;
						var $highhum;
						var $lowhum;
						var $highbar;
						var $lowbar;
						var $highwind;
						var $highrainrate;
				 function get_hightemp(){
				 		return $this->hightemp;
				 }
				 function get_highbar(){
				 		return $this->highbar;
				 }
				 function get_lowtemp(){
				 		return $this->lowtemp;
				 }
				 function get_highhum(){
				 		return $this->highhum;
				 }
				 function get_lowhum(){
				 		return $this->lowhum;
				 }
				 function get_highwind(){
				 		return $this->highwind;
				 }
				 function get_lowbar(){
				 		return $this->lowbar;
				 }
				 function get_highrainrate(){
				 		return $this->highrainrate;
				 }
				 function set_hightemp($hightemp){
				 		$this->hightemp = $hightemp;
				 }
				 function set_lowtemp($lowtemp){
				 		$this->lowtemp = $lowtemp;
				 }	
				 function set_highhum($highhum){
				 		$this->highhum = $highhum;
				 }	
				 function set_lowhum($lowhum){
				 		$this->lowhum = $lowhum;
				 }
				 function set_lowbar($lowbar){
				 		$this->lowbar = $lowbar;
				 }	
				 function set_highbar($highbar){
				 		$this->highbar = $highbar;
				 }	
					function set_highwind($highwind){
				 		$this->highwind = $highwind;
				 }	
				 function set_highrainrate($rainrate){
				 		$this->highrainrate = $rainrate;
				 }	
			}
			
			function randomFile ($file){
			 		$items = file($file);
					$item = rand(0, sizeof($items)-1);
					return $items[$item];				 
			}


 ?>