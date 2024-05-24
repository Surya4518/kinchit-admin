// function deleterecord(e){if(1!=confirm("Do you want to delete this record?."))return!1;$.ajax({type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},async:!1,url:$("#hidbaseurl").val()+"/deletedoctor",data:{type:"deletefaq",delid:e},success:function(e){window.location.href=$("#hidbaseurl").val()+"/doctors-list"}})}function checkboxclick_setashomepage(e){$("#txtcheckboxhome_"+e).is(":checked")?checkedvalues=1:checkedvalues=0,$.ajax({type:"POST",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},async:!1,url:$("#hidbaseurl").val()+"/setashomepage-doctors",data:{type:"setashomepage",delid:e,checkedvalues:checkedvalues},success:function(e){}})}$("#frm input").keypress((function(e){if(13==e.which)return $("#txtsubmitbtn").click(),!1})),$("#txtsubmitbtn").click((function(){return $("#frm").submit(),!1}));




function deleterecord(e) {
    if (1 != confirm("Do you want to delete this record?.")) return !1;
    $.ajax({
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      async: !1,
      url: $("#hidbaseurl").val() + "/deletedoctor",
      data: {
        type: "deletefaq",
        delid: e
      },
      success: function (e) {
        window.location.href = $("#hidbaseurl").val() + "/doctors-list"
      }
    });
  }


  function isNumber(t) {
    var e = (t = t || window.event).which ? t.which : t.keyCode;
    return !(e > 31 && (e < 48 || e > 57))
}


  function checkboxclick_setashomepage(e) {
    $("#txtcheckboxhome_" + e).is(":checked") ? checkedvalues = 1 : checkedvalues = 0;
    $.ajax({
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      async: !1,
      url: $("#hidbaseurl").val() + "/setashomepage-doctors",
      data: {
        type: "setashomepage",
        delid: e,
        checkedvalues: checkedvalues
      },
      success: function (e) {}
    });
  }

  function myFunction(t) {
    var e = $("#txtsort_" + t).val();
    "" == e && (e = 0);
    $.ajax({
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      async: !1,
      url: $("#hidbaseurl").val() + "/updatedoctorsortorder",
      data: {
        type: "updatedoctorsortorder",
        txtsort: e,
        editid: t
      },
      success: function (t) {}
    });
  }






  $("#frm input").keypress(function (e) {
    if (13 == e.which) return $("#txtsubmitbtn").click(), !1
  });

  $("#txtsubmitbtn").click(function () {
    return $("#frm").submit(), !1
  });

