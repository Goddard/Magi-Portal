// Following is a javascript function that makes a httprequest - AJAX. This is the AJAX bit and all that is needed in that manner.
// Only in this one we won't be using XML in our response, we will accept and handle
// pure text and html and display this response directly to the user within the
// desired <div id> tags. It can even be used to include pure html files as a substitute
// solution to the "old" frames method where as no php or other scripting language is nessesary on the server.
// but use it with care - it is not a search engine supported method and indexing will fail. Workaround for this is not included here

function MyAjaxRequest(target_div,file,check_div){
	var MyHttpRequest = false;
	var MyHttpLoading = '<p>Loading...</p>'; // or use an animated gif instead: var MyHttpLoading = '<img src="loading.gif" border="0" alt="running" />';
	var ErrorMSG = 'Sorry - No XMLHTTP support in your browser, buy a newspaper instead';

		if(check_div){
			var check_value = document.getElementById(check_div).value;
		}else{
			var check_value = '';
		}


		if(window.XMLHttpRequest){// client use Firefox, Opera etc - Non Microsoft product
			try{
				MyHttpRequest = new XMLHttpRequest();
			}catch(e){
				MyHttpRequest = false;
			}
		}else if(window.ActiveXObject){
			try{
				MyHttpRequest = new ActiveXObject("Msxml2.XMLHTTP");
			}catch(e){
				try{
					MyHttpRequest = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(e){
					MyHttpRequest = false;
				}
			}
		}else{
			MyHttpRequest = false;
		}



	if(MyHttpRequest){// browser supports httprequest
		var random = Math.random() * Date.parse(new Date()); // make a random string to prevent caching

		var file_array = file.split('.'); // prepare to check if we have a query string or a html/htm file

	if(file_array[1] == 'php'){// no query string, just calling a php file
		var query_string = '?rand=' + random;
	}else if(file_array[1] == 'htm' || file_array[1] == 'html'){// calling a htm or html file
		var query_string = '';
	}else{// we have presumable a php file with a query string attached
		var query_string = check_value + '&rand=' + random;
	}


	MyHttpRequest.open("get", url_encode(file + query_string), true); // <-- run the httprequest using GET


// handle the httprequest
	MyHttpRequest.onreadystatechange = function (){
		if(MyHttpRequest.readyState == 4){// done and responded
			document.getElementById(target_div).innerHTML = MyHttpRequest.responseText; // display result
		}else{
			document.getElementById(target_div).innerHTML = MyHttpLoading; // still working
		}
	}
		MyHttpRequest.send(null);
		}else{
			document.getElementById(target_div).innerHTML = ErrorMSG; // the browser was unable to create a httprequest
		}
}
// end of "AJAX" function


// Here follows a function to urlencode the string we run through our httprequest, it has nothing to do with AJAX itself
// If you look carefully in the above httprequest you se that we use this url_encode function around the file and query_string
// This is very handy since we are using GET in our httprequest and for instance
// any occurrance of the char # (from textboxes etc) will brake the string we are sending to our file - we don't want that to brake!
// It will also convert spaces to +

function url_encode(string){
	var string;
	var safechars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz/-_.&?=";
	var hex = "0123456789ABCDEF";
	var encoded_string = "";

	for(var i = 0; i < string.length; i++){
		var character = string.charAt(i);

		if(character == " "){
			encoded_string += "+";
		}else if(safechars.indexOf(character) != -1){
			encoded_string += character;
		}else{
			var hexchar = character.charCodeAt(0);

		if(hexchar > 255){
			encoded_string += "+";
		}else{
			encoded_string += "%";
			encoded_string += hex.charAt((hexchar >> 4) & 0xF);
			encoded_string += hex.charAt(hexchar & 0xF);
		}
		}
	}
	return encoded_string;
}
