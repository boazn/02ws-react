jQuery(document).ready(function() {

	function getData (e) {
		
		eval('var obj = ' + e.data); // get JSON object
				
		if (obj.details_dynamic==true)
		{
		 document.profile_form.details_dynamic.value = 1;
		}
		else
		{
		 document.profile_form.details_dynamic.value = 0;
		}
		
		if (document.profile_form.old_details_dynamic.value != document.profile_form.details_dynamic.value)
		{
			document.profile_form.submit();
		}
		
	}
	
  if(typeof window.addEventListener != 'undefined') { 
		window.addEventListener('message', getData, false); 
	} 
	else if(typeof window.attachEvent != 'undefined') { 
		window.attachEvent('onmessage', getData); 
	}
})
