function validate_fileupload(e){var t=document.getElementById("txtimgfileerror"),r=e.value;r=r.toLowerCase(),valid=!1;for(var n=new Array("jpg","jpeg","png","gif"),i=r.split(".").pop(),l=0;l<n.length;l++)if(n[l]==i&&(valid=!0,t.innerHTML="",e.files&&e.files[0])){var o=new FileReader;o.onload=function(e){},o.readAsDataURL(e.files[0])}if(1==valid){e.files[0].size/1024/1024>2?(t.innerHTML="File size exceeds 2 MB",valid=!1):(t.innerHTML="",valid=!0)}else t.innerHTML="This file type not supported.",valid=!1}$((function(){setTimeout((function(){$("#successmsg").fadeOut("slow")}),7e3)})),$("#frm input").keypress((function(e){if(13==e.which)return $("#txtsubmitbtn").click(),!1})),$("#txtsubmitbtn").click((function(){var e=$("#txtdoctorname"),t=$("#txtdoctornameerror"),r=$("#txtdegreename"),n=$("#txtdegreenameerror");return(e.val().length<1?(t.text("Please enter Doctor Name"),e.addClass("form-control-danger"),!1):(t.text(""),e.removeClass("form-control-danger"),!0))&(r.val().length<1?(n.text("Please enter the Degree"),r.addClass("form-control-danger"),!1):(n.text(""),r.removeClass("form-control-danger"),!0))&function(){var e=$("#txtimgfileerror").html();document.getElementById("txtimgfile").files.length;return e.length<1}()&&($("#hiddescription").val($(".note-editable").html()),$("#frm").submit()),!1}));