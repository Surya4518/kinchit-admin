$("#frm input").keypress((function(t){
    if(13==t.which)return $("#txtsubmitbtn").click(),!1}))
    ,$("#txtsubmitbtn").click((function(){
        var t=$("#txtmenuname"),e=$("#txtmenunameerror"),r=$("#txtpagetitle"),n=$("#txtpagetitleerror"),u=$("#txturl"),l=$("#txturlerror");
        return(u.val().length<1?(l.text("Please enter the URL"),u.addClass("form-control-danger"),!1):(l.text(""),u.removeClass("form-control-danger"),!0))&(r.val().length<1?(n.text("Please enter the page title"),r.addClass("form-control-danger"),!1):(n.text(""),r.removeClass("form-control-danger"),!0))&(t.val().length<1?(e.text("Please enter the menu name"),t.addClass("form-control-danger"),!1):(e.text(""),t.removeClass("form-control-danger"),!0))&&$("#frm").submit(),!1}));