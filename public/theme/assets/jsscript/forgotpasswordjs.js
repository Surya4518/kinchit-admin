$((function(){$("#successmsg").hide()})),$("#frm input").keypress((function(t){if(13==t.which)return $("#txtsubmitbtn").click(),!1})),$("#txtsubmitbtn").click((function(){var t=$("#txtemailid"),e=$("#txtemailiderror");if(function(){var a=t.val();if(a.length<1)return e.text("Please enter your email address"),t.addClass("form-control-danger"),!1;var r=0;if("-1"!=a.indexOf("@")){var s=a.split("@");if(""!=s[1]){var n=s[1];for(i=0;i<n.length;i++)"."==n.charAt(i)&&r++}}if(r>3)return e.text("Please enter a valid email address"),t.addClass("form-control-danger"),!1;if(!/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(a))return e.text("Please enter a valid email address"),t.addClass("form-control-danger"),!1;$("#txtsubmitbtn").html("Please Wait ..."),$("#txtsubmitbtn").prop("disabled",!0),setTimeout((function(){var a=!0;return $.ajax({type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},async:!1,url:$("#hidbaseurl").val()+"/verifyemailid",data:{type:"verifyemailid",txtemailid:t.val()},success:function(r){"0"==r.status_code?(e.text("This email address is not avaliable."),t.addClass("form-control-danger"),a=!1):(e.text(""),t.removeClass("form-control-danger"),a=!0,t.val(""),$("#successmsg").show())},complete:function(){$("#txtsubmitbtn").html("Send"),$("#txtsubmitbtn").prop("disabled",!1)}}),a}),1e3)}())return!1;return!1}));