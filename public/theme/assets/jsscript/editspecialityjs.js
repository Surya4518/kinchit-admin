function tabclick(e){return"1"==e?($("#general-tab").removeClass("d-block"),$("#image-tab").removeClass("d-block"),$("#additional-details-tab").removeClass("d-block"),$("#seo-details-tab").removeClass("d-block"),$("#sectiontwo-details-tab").removeClass("d-block"),$("#sectionthree-details-tab").removeClass("d-block"),$("#general-tab").addClass("d-block"),$("#image-tab").addClass("d-none"),$("#additional-details-tab").addClass("d-none"),$("#seo-details-tab").addClass("d-none"),$("#sectiontwo-details-tab").addClass("d-none"),$("#sectionthree-details-tab").addClass("d-none")):"2"==e?($("#general-tab").removeClass("d-block"),$("#image-tab").removeClass("d-block"),$("#additional-details-tab").removeClass("d-block"),$("#seo-details-tab").removeClass("d-block"),$("#sectiontwo-details-tab").removeClass("d-block"),$("#sectionthree-details-tab").removeClass("d-block"),$("#general-tab").addClass("d-none"),$("#image-tab").addClass("d-block"),$("#additional-details-tab").addClass("d-none"),$("#seo-details-tab").addClass("d-none"),$("#sectiontwo-details-tab").addClass("d-none"),$("#sectionthree-details-tab").addClass("d-none")):"3"==e?($("#general-tab").removeClass("d-block"),$("#image-tab").removeClass("d-block"),$("#additional-details-tab").removeClass("d-block"),$("#seo-details-tab").removeClass("d-block"),$("#sectiontwo-details-tab").removeClass("d-block"),$("#sectionthree-details-tab").removeClass("d-block"),$("#general-tab").addClass("d-none"),$("#image-tab").addClass("d-none"),$("#additional-details-tab").addClass("d-block"),$("#seo-details-tab").addClass("d-none"),$("#sectiontwo-details-tab").addClass("d-none"),$("#sectionthree-details-tab").addClass("d-none")):"4"==e?($("#general-tab").removeClass("d-block"),$("#image-tab").removeClass("d-block"),$("#additional-details-tab").removeClass("d-block"),$("#seo-details-tab").removeClass("d-block"),$("#sectiontwo-details-tab").removeClass("d-block"),$("#sectionthree-details-tab").removeClass("d-block"),$("#general-tab").addClass("d-none"),$("#image-tab").addClass("d-none"),$("#additional-details-tab").addClass("d-none"),$("#seo-details-tab").addClass("d-block"),$("#sectiontwo-details-tab").addClass("d-none"),$("#sectionthree-details-tab").addClass("d-none")):"5"==e?($("#general-tab").removeClass("d-block"),$("#image-tab").removeClass("d-block"),$("#additional-details-tab").removeClass("d-block"),$("#seo-details-tab").removeClass("d-block"),$("#sectiontwo-details-tab").removeClass("d-block"),$("#sectionthree-details-tab").removeClass("d-block"),$("#general-tab").addClass("d-none"),$("#image-tab").addClass("d-none"),$("#additional-details-tab").addClass("d-none"),$("#seo-details-tab").addClass("d-none"),$("#sectiontwo-details-tab").addClass("d-block"),$("#sectionthree-details-tab").addClass("d-none")):"6"==e&&($("#general-tab").removeClass("d-block"),$("#image-tab").removeClass("d-block"),$("#additional-details-tab").removeClass("d-block"),$("#seo-details-tab").removeClass("d-block"),$("#sectiontwo-details-tab").removeClass("d-block"),$("#sectionthree-details-tab").removeClass("d-block"),$("#general-tab").addClass("d-none"),$("#image-tab").addClass("d-none"),$("#additional-details-tab").addClass("d-none"),$("#seo-details-tab").addClass("d-none"),$("#sectiontwo-details-tab").addClass("d-none"),$("#sectionthree-details-tab").addClass("d-block")),!1}function fetcheditorhtmloutput(e){var t="";return $(".note-editable").each((function(a,n){a==e&&(t=$(n).html())})),t}function piciconclick(){return $("#txtimgfile").click(),!1}function validate_bannerfileupload(e){var t=document.getElementById("txtbannerimgfileerror"),a=e.value;a=a.toLowerCase(),valid=!1;for(var n=new Array("jpg","jpeg","png","gif","svg"),l=a.split(".").pop(),s=0;s<n.length;s++)if(n[s]==l&&(valid=!0,t.innerHTML="",e.files&&e.files[0])){var i=new FileReader;i.onload=function(e){},i.readAsDataURL(e.files[0])}if(1==valid){e.files[0].size/1024/1024>2?(t.innerHTML="File size exceeds 2 MB",valid=!1):(t.innerHTML="",valid=!0)}else t.innerHTML="This file type not supported.",valid=!1}function validate_sectiononefileupload(e){var t=document.getElementById("txtsectiononefileerror"),a=e.value;a=a.toLowerCase(),valid=!1;for(var n=new Array("jpg","jpeg","png","gif","svg"),l=a.split(".").pop(),s=0;s<n.length;s++)if(n[s]==l&&(valid=!0,t.innerHTML="",e.files&&e.files[0])){var i=new FileReader;i.onload=function(e){},i.readAsDataURL(e.files[0])}if(1==valid){e.files[0].size/1024/1024>2?(t.innerHTML="File size exceeds 2 MB",valid=!1):(t.innerHTML="",valid=!0)}else t.innerHTML="This file type not supported.",valid=!1}function validate_sectiontwofileupload(e){var t=document.getElementById("txtsectiontwofileerror"),a=e.value;a=a.toLowerCase(),valid=!1;for(var n=new Array("jpg","jpeg","png","gif","svg"),l=a.split(".").pop(),s=0;s<n.length;s++)if(n[s]==l&&(valid=!0,t.innerHTML="",e.files&&e.files[0])){var i=new FileReader;i.onload=function(e){},i.readAsDataURL(e.files[0])}if(1==valid){e.files[0].size/1024/1024>2?(t.innerHTML="File size exceeds 2 MB",valid=!1):(t.innerHTML="",valid=!0)}else t.innerHTML="This file type not supported.",valid=!1}function validate_sectionthreefileupload(e){var t=document.getElementById("txtsectionthreefileerror"),a=e.value;a=a.toLowerCase(),valid=!1;for(var n=new Array("jpg","jpeg","png","gif","svg"),l=a.split(".").pop(),s=0;s<n.length;s++)if(n[s]==l&&(valid=!0,t.innerHTML="",e.files&&e.files[0])){var i=new FileReader;i.onload=function(e){},i.readAsDataURL(e.files[0])}if(1==valid){e.files[0].size/1024/1024>2?(t.innerHTML="File size exceeds 2 MB",valid=!1):(t.innerHTML="",valid=!0)}else t.innerHTML="This file type not supported.",valid=!1}function deleterecordsectiononeimg(e){if(1!=confirm("Do you want to delete this record?."))return!1;$("table#tblimgtbl tr#"+e).remove(),$.ajax({type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},async:!1,url:$("#hidbaseurl").val()+"/deletesectiononeimage",data:{type:"deletesectiononeimage",delid:e},success:function(e){}})}function deleterecordsectiontwoimg(e){if(1!=confirm("Do you want to delete this record?."))return!1;$("table#tblimgtbltwo tr#"+e).remove(),$.ajax({type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},async:!1,url:$("#hidbaseurl").val()+"/deletesectiontwoimage",data:{type:"deletesectiontwoimage",delid:e},success:function(e){}})}function deleterecordsectionthreeimg(e){if(1!=confirm("Do you want to delete this record?."))return!1;$("table#tblimgtblthree tr#"+e).remove(),$.ajax({type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},async:!1,url:$("#hidbaseurl").val()+"/deletesectionthreeimage",data:{type:"deletesectionthreeimage",delid:e},success:function(e){}})}$("#frm1 input").keypress((function(e){if(13==e.which)return $("#txtgsubmitbtnone").click(),!1})),$("#txtgsubmitbtnone").click((function(){var e=$("#txtmenuname"),t=$("#txtmenunameerror"),a=$("#txtpagetitle"),n=$("#txtpagetitleerror");return(a.val().length<1?(n.text("Please enter the page title"),a.addClass("form-control-danger"),!1):(n.text(""),a.removeClass("form-control-danger"),!0))&(e.val().length<1?(t.text("Please enter the menu name"),e.addClass("form-control-danger"),!1):(t.text(""),e.removeClass("form-control-danger"),!0))&&$("#frm1").submit(),!1})),$("#frm2 input").keypress((function(e){if(13==e.which)return $("#txtgsubmitbtntwo").click(),!1})),$("#txtgsubmitbtntwo").click((function(){var e=$("#txtbannertitle"),t=$("#txtbannertitleerror"),a=$("#txtbannersubtitle"),n=$("#txtbannersubtitleerror");return(e.val().length<1?(t.text("Please enter the banner title"),e.addClass("form-control-danger"),!1):(t.text(""),e.removeClass("form-control-danger"),!0))&(a.val().length<1?(n.text("Please enter the banner sub title"),a.addClass("form-control-danger"),!1):(n.text(""),a.removeClass("form-control-danger"),!0))&function(){var e=$("#txtbannerimgfileerror").html();document.getElementById("txtbannerimgfile").files.length;return e.length<1}()&&$("#frm2").submit(),!1})),$("#frm3 input").keypress((function(e){if(13==e.which)return $("#txtgsubmitbtnthree").click(),!1})),$("#txtgsubmitbtnthree").click((function(){return $("#frm3").submit(),!1})),$("#txtgsubmitbtnthreeone").click((function(){var e,t,a=$("#txtsectiononecaption"),n=$("#txtsectiononecaptionerror");return(a.val().length<1?(n.text("Please enter the caption"),a.addClass("form-control-danger"),!1):(n.text(""),a.removeClass("form-control-danger"),!0))&(e=$("#txtsectiononefileerror"),t=e.html(),"0"==document.getElementById("txtsectiononefile").files.length?(e.text("Please upload image"),!1):t.length<1)&&$("#frm31").submit(),!1})),$("#frm4 input").keypress((function(e){if(13==e.which)return $("#txtgsubmitbtnfour").click(),!1})),$("#txtgsubmitbtnfour").click((function(){return $("#frm4").submit(),!1})),$("#frm5 input").keypress((function(e){if(13==e.which)return $("#txtgsubmitbtnfive").click(),!1})),$("#txtgsubmitbtnfive").click((function(){return $("#frm5").submit(),!1})),$("#txtgsubmitbtnfiveone").click((function(){var e,t,a=$("#txtsectiontwocaption"),n=$("#txtsectiontwocaptionerror");return(a.val().length<1?(n.text("Please enter the title"),a.addClass("form-control-danger"),!1):(n.text(""),a.removeClass("form-control-danger"),!0))&(e=$("#txtsectiontwofileerror"),t=e.html(),"0"==document.getElementById("txtsectiontwofile").files.length?(e.text("Please upload image"),!1):t.length<1)&&$("#frm51").submit(),!1})),$("#frm6 input").keypress((function(e){if(13==e.which)return $("#txtgsubmitbtnsix").click(),!1})),$("#txtgsubmitbtnsix").click((function(){return $("#frm6").submit(),!1})),$("#txtgsubmitbtnsixone").click((function(){var e,t,a=$("#txtsectionthreecaption"),n=$("#txtsectionthreecaptionerror");return(a.val().length<1?(n.text("Please enter the title"),a.addClass("form-control-danger"),!1):(n.text(""),a.removeClass("form-control-danger"),!0))&(e=$("#txtsectionthreefileerror"),t=e.html(),"0"==document.getElementById("txtsectionthreefile").files.length?(e.text("Please upload image"),!1):t.length<1)&&$("#frm61").submit(),!1}));