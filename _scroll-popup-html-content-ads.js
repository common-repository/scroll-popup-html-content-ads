// float directions
var leftRight = 1;
var rightLeft = 2;
var topDown = 3;
var bottopUp = 4;

// side
var leftSide = 1;
var rightSide = 2;

// position
var topCorner = 1;
var bottomCorner = 2;

// default title
var _title = '';

// default width
var popupWidth = 210;
var popupHeight = 81;

var only_once_per_browser = false;

var ns4 = document.layers;
var ie4 = document.all;
var ns6 = document.getElementById&&!document.all;
var crossobj;

function getCrossObj()
{
    var contentDiv;
    var titleDiv;
    
    if (ns4)
    {
        crossobj = document.layers.postit;
        contentDiv = document.layers.postit_content;
        titleDiv = document.layers.postit_title;
    }
    else if (ie4||ns6)
    {
        crossobj = ns6? document.getElementById("postit") : document.all.postit;
        contentDiv = ns6? document.getElementById("postit_content") : document.all.postit_content;
        titleDiv = ns6? document.getElementById("postit_title") : document.all.postit_title;
    }   
    crossobj.style.width = popupWidth + 'px';
    crossobj.style.height = popupHeight + 'px';
    
    // adjust the size of the div "content"
    contentDiv.style.width = (popupWidth-8) + 'px';
    contentDiv.style.height = (popupHeight-26) + 'px';
    
    // adjust the width of the div "title"
    titleDiv.style.width = (popupWidth-8) + 'px';
    
}

//
//  sphca_loadpopup
//
function sphca_loadpopup(width, height, title, htmlCode)
{
    if (width)
        popupWidth = width;
       
    if (height)
        popupHeight = height;

    if (title)
        _title = title

    document.write('<div id="postit" class="postit">');
    document.write('<div id="postit_title" class="title"><b>' + _title + ' <span class="spantitle"><img src="close.gif" border="0" title="Close" align="right" WIDTH="11" HEIGHT="11" onclick="closeit()">&nbsp;</b></span></div>');
    document.write('<div id="postit_content" class="content">'); 
    document.write(htmlCode);				
    document.write('</div></div>');
    getCrossObj();
}

//
//  closeit
//
function closeit()
{
    if (ie4||ns6)
        crossobj.style.visibility="hidden";
    else if (ns4)
        crossobj.visibility="hide";
}

//
//  get_cookie
//
function get_cookie(Name) 
{
    var search = Name + "=";
    var returnvalue = "";

    if (document.cookie.length > 0) 
    {
        offset = document.cookie.indexOf(search);
        if (offset != -1) 
        { 
            // if cookie exists
            offset += search.length;
            // set index of beginning of value
            end = document.cookie.indexOf(";", offset);
            // set index of end of cookie value
            if (end == -1)
                end = document.cookie.length;
            returnvalue=unescape(document.cookie.substring(offset, end));
         }
    }
    return returnvalue;
}

//
// check the cookie
//
function showOrNot(direction)
{
    var showit = false;
    
    if (get_cookie('postTheBoxDisplay')=='')
    {
        showit = true;
        document.cookie = "postTheBoxDisplay=yes";
    }
    return showit;
}

//
//  showItRight
//
function showIt(direction)
{
    var steps;
    
    steps = Math.floor(popupHeight / 4)+5;
  
    
    if (ie4||ns6)
    {
        crossobj.style.visibility = "visible";
        if ((direction == rightLeft) || (direction == leftRight))
            flyTheBox(direction, 0, popupWidth , steps, 1000);
        else 
            flyTheBox(direction, 0, popupHeight , steps, 1000);
    }
    else if (ns4)
        crossobj.visibility = "show";
}

//
//  flyTheBox
//
function flyTheBox(direction, start, end, steps, msec, counter)
{
	if(!counter)
		counter = 1;

	var tmp;

	if(start < end)
	{
	    if (direction == rightLeft)
	        crossobj.style.width = end / steps * counter + 'px'; 
	    else if (direction == bottopUp)
	        crossobj.style.height = end / steps * counter + 'px'; 
	    else if (direction == topDown)
	        crossobj.style.top = ((end / steps * counter) - popupHeight) + 'px'; 
        else if (direction == leftRight)
	        crossobj.style.left = (end / steps * counter)-popupWidth + 'px'; 
	        
    }
	else 
	{ 

	    tmp=steps -	counter; 
	    if (direction == rightLeft)
	        crossobj.style.width = start / steps * tmp + 'px'; 
	    else if (direction == bottopUp)
	        crossobj.style.height = start / steps * tmp + 'px'; 
	    else if (direction == topDown)
	        crossobj.style.top = ((end / steps * counter) - popupHeight) + 'px'; 

	} 
	if(counter != steps) 
	{ 
	    counter++; 
	    flyTheBox_timer=setTimeout('flyTheBox('+ direction + ',' + start + ','+ end + ',' + steps + ',' + msec + ', '+ counter + ')', msec/steps); 
	} 
	else 
	{ 
	    if(start > end)
			crossobj.style.display = 'none';
	}
}


//
// ShowTheBox
//
function ShowTheBox(only_once, side, corner, direction)
{
    if (side == leftSide)
    {
        if (direction == rightLeft)
            return;
        crossobj.style.left = '1px';
    }
    else
    {
        if (direction == leftRight)
            return;
	    crossobj.style.right = '1px'; 
    }

    if ((corner == topCorner) && (direction == bottopUp))
        return;

    if ((corner == bottomCorner) && (direction == topDown))
        return;
        
    if ( (direction == topDown) && (corner == topCorner) )
        crossobj.style.top = '-' + popupHeight + 'px';    
    else if ( ((direction == rightLeft)||(direction == leftRight)) && (corner == topCorner) )
        crossobj.style.top = '1px';
    else if (corner == bottomCorner)
        crossobj.style.bottom = '2px';

    if (only_once)
        only_once_per_browser = only_once;
  
    if (only_once_per_browser)
    {
        // verify the presence of a cookie
	    if (showOrNot())
	        showIt(direction);
    }
    else
	    setTimeout("showIt("+ direction + ")",1030);
}