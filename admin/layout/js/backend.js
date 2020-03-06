$(document).ready(function()
{
	"use strict";


	/* function to sure that you want delete the item*/
	$('.confirm').on("click",function ()
	{
		return confirm("Are You Sure Delete ?");
	});

	/* funtion to view overlay on categories with two options (edit,delte)*/
	$('.category-part').on("hover",function()
	{
		('.category-part-overlay').css("display","blcok")
	});

	/* function change img preview when edit item ... before upload page */
	$('#upload').change(function(){
	    var input = this;
	    var url = $(this).val();
	    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
	     {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	           $('#img').attr('src', e.target.result);
	        }
	       reader.readAsDataURL(input.files[0]);
	    }
	    else
	    {
	      $('#img').attr('src', 'Uploads/empty.jpg');
	    }
	});

	


});

function showitems(str) {
  var xhttp;   
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("category-select").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "Ajax/category-select.php?category_id="+str, true);
  xhttp.send();
}