
$(document).ready(function(){
	"use strict";

	//navbar scrolling animation
	$(window).on("scroll",function()
	{
		if($(document).scrollTop() > 50	){
			$('nav').addClass('nav-scrolling');
			$('.nav-item').css({'margin':'15px auto', 'margin-left':'65px'});
			$('.navbar-brand').css("font-size","30px");
		}else{
			$('nav').removeClass('nav-scrolling');
			$('.nav-item').css({'margin':'28px auto', 'margin-left':'55px'});
			$('.navbar-brand').css("font-size","38px")
		}
	});

	/* start modal functions */

		$('.btn-login-switcher , .navbar-login').on("click",function()
		{
			$('.login-form').css("display","block");
			$('.register-form').css("display","none");
			$('.forget-password-form').css("display","none");
			$('.btn-register-switcher').addClass('switcherModal');
			$('.btn-login-switcher').removeClass('switcherModal');
			$('.forgetpass-text').show();
			$('.terms-condation-text').hide();
		});


		$('.btn-register-switcher , .navbar-register').on("click",function(){	
			$('.login-form').css("display","none");
			$('.register-form').css("display","block");
			$('.forget-password-form').css("display","none");
			$('.btn-login-switcher').addClass('switcherModal');
			$('.btn-register-switcher').removeClass('switcherModal');
			$('.forgetpass-text').hide();
			$('.terms-condation-text').show();
		});

		$('.forgetpass-text').on("click",function(){
			$('.login-form').css("display","none");
			$('.register-form').css("display","none");
			$('.forget-password-form').css("display","block");
			$(this).hide();
			$('.terms-condation-text').hide();
		});

		//Clicking to X and close error window
		$('.close-error-window').on("click",function(){
			$('.error-window').remove();
			window.location.href = "logout.php";
		});

	/* end modal functions */

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

	$('#send_comment').on("click",function(){
		var item_id = $(this).attr("id");
		var comment = $('#written_comment').val();
		$.ajax({
			url:"ajaxfiles/insert_comment.php",
			method:"POST",
			data:{item_id:item_id,comment:comment},
			success:function(){

			}
		})
	})

});