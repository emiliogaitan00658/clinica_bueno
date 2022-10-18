$(function(){"use strict";
	
	    $("#to-recover").on("click",function(){
	    	$("#loginform").hide(300);
	    	$("#recoverform").show(300);
	    }),

	    $("#to-login").on("click",function(){
	    	$("#recoverform").hide(300);
	    	$("#loginform").show(300);
	    })
});