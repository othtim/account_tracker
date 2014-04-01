
function getXMLHttp(){

	var pageRequest = false ;

      try {
      		pageRequest = new ActiveXObject("Msxml2.XMLHTTP");
      }
      catch (e){
         	try {
         		pageRequest = new ActiveXObject("Microsoft.XMLHTTP");
         	}
         	catch (e2){
         		pageRequest = false;
         	}
      }


	if (!pageRequest && typeof XMLHttpRequest != 'undefined')

	pageRequest = new XMLHttpRequest();

return pageRequest;
}





function makeRequest(url,params){

	var xmlHttp = getXMLHttp();
	var timestamp = new Date();
 

	xmlHttp.onreadystatechange = function(){
		
		if(xmlHttp.readyState == 4 && xmlHttp.status == 200){

			HandleResponse(xmlHttp.responseText);
			delete xmlHttp;
		}
	}


	params = params + "&timestamp=" + timestamp.getTime();
	<!-- alert(params); -->

xmlHttp.open("GET", url + '?' + params, true);
xmlHttp.send(null);
}


function HandleResponse(response){

	document.getElementById("statusInfo").innerHTML=response;
	delete xmlHttp;
}
