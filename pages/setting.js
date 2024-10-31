function sphca_submit()
{
	if((document.sphca_form.sphca_width.value=="") || isNaN(document.sphca_form.sphca_width.value))
	{
		alert(scroll_popup_adminscripts.sphca_width)
		document.sphca_form.sphca_width.focus();
		return false;
	}
	else if((document.sphca_form.sphca_height.value=="") || isNaN(document.sphca_form.sphca_height.value))
	{
		alert(scroll_popup_adminscripts.sphca_height)
		document.sphca_form.sphca_height.focus();
		return false;
	}
	else if(document.sphca_form.sphca_text.value=="")
	{
		alert(scroll_popup_adminscripts.sphca_text)
		document.sphca_form.sphca_text.focus();
		return false;
	}
	_sphca_escapeVal(document.sphca_form.sphca_text,'<br>');
}

function sphca_delete(id)
{
	if(confirm(scroll_popup_adminscripts.sphca_delete))
	{
		document.frm_sphca_display.action="options-general.php?page=scroll-popup-html-content-ads&ac=del&did="+id;
		document.frm_sphca_display.submit();
	}
}	

function sphca_redirect()
{
	window.location = "options-general.php?page=scroll-popup-html-content-ads";
}

function sphca_help()
{
	window.open("http://www.gopiplus.com/work/2012/02/05/scroll-popup-html-content-ads-wordpress-plugin/");
}


function _sphca_escapeVal(textarea,replaceWith)
{
	textarea.value = escape(textarea.value) //encode textarea strings carriage returns
	for(i=0; i<textarea.value.length; i++)
	{
		//loop through string, replacing carriage return encoding with HTML break tag
		if(textarea.value.indexOf("%0D%0A") > -1)
		{
			//Windows encodes returns as \r\n hex
			textarea.value=textarea.value.replace("%0D%0A",replaceWith)
		}
		else if(textarea.value.indexOf("%0A") > -1)
		{
			//Unix encodes returns as \n hex
			textarea.value=textarea.value.replace("%0A",replaceWith)
		}
		else if(textarea.value.indexOf("%0D") > -1)
		{
			//Macintosh encodes returns as \r hex
			textarea.value=textarea.value.replace("%0D",replaceWith)
		}
	}
	textarea.value=unescape(textarea.value) //unescape all other encoded characters
}
