var pst_id = 0;

function handler(eid,etype)
        {     var str = eid.concat(etype);
            var str2 = str.concat("b");
            window.alert(str2);
            // only handle loaded requests
            if (xhr.readyState == 4)
            {
                if (xhr.status == 200)
                    {document.getElementById(str).innerHTML = xhr.responseText;
                       document.getElementById("str2").value = "Unlike";  

                    }
                else
                    alert("Error with Ajax call!");
            }
        }
function updateLike(eid,etype)
{  
	//document.getElementById("L").disabled = true; 
   // var str = eid.concat(etype);
     //       var str2 = str.concat("b");


     alert("hi");
			
	/*try
            {
                xhr = new XMLHttpRequest();
            }
            catch (e)
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // handle old browsers
            if (xhr == null)
            {
                alert("Ajax not supported by your browser!");
                return;
            }

            // construct URL
            var url = "funcs.php?eid=" + eid + "&etype=" + etype;
            //pst_id = eid;
            //inform user
            //document.getElementById("totLikes").innerHTML="Working on it...";
            // get quote
            xhr.onreadystatechange = function(){handler(eid,etype);};
            xhr.open("GET", url, true);
            xhr.send(null); */

}

f

function redirect()
{

	try
            {
                xhr = new XMLHttpRequest();
            }
            catch (e)
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }

            // handle old browsers
            if (xhr == null)
            {
                alert("Ajax not supported by your browser!");
                return;
            }


            // construct URL
            var url = "setSessionVariable.php";

            //inform user
            //document.getElementById("totLikes").innerHTML="Working on it...";
            // get quote
            xhr.onreadystatechange = handler2;
            xhr.open("POST", url, true);
            xhr.send(null);

}

function handler2()
{
if (xhr.readyState == 4)
            {
                if (xhr.status == 200)
                   window.location = "post_class.php";
                else
                    alert("Error with Ajax call!");
            }


}

/*
         * void
         * handler()
         *
         * Handles the Ajax response.
         */
        