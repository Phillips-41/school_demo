function getuserRow(classInfo) {
  var userRow = "";
  if (classInfo) {
    userRow = `<tr>
      <td>${classInfo.id}</td>
      <td>${classInfo.ClassName}</td>
     <td>
        <a href="#" class="btn btn-primary mr-3 profile" data-target="#userViewModal" data-toggle="modal" data-id=${classInfo.id}>View</a>
        <a href="#" class="btn btn-success mr-3 editClass" data-target="#userModal" data-toggle="modal" data-id=${classInfo.id}>Edit</a>
        <a href="#" class="btn btn-danger mr-3 deleteClass" data-id=${classInfo.id}>Delete</a>
    </td>
    </tr>`;
  }
  return userRow;
}

function getUsers() {
  $.ajax({
    url: "/PHPadvance/classajax.php",
    type: "GET",
    dataType: "json",
    data: { action: "getAllClass" },
    beforeSend: function () {
      console.log("data is loading");
    },
    success: function (rows) {
      console.log(rows);
      var userList = "";
      $.each(rows, function (index, classInfo) {
        userList += getuserRow(classInfo);
      });
      $("#classtable tbody").html(userList);
    },
    error: function (request, error) {
      console.log(arguments);
      console.log(request);
      console.log("Error " + error);
    },
  });
}

$(document).ready(function () {
  $(document).on("submit", "#classform", function (e) {
    e.preventDefault();
    var formData = new FormData();
    // ajax
    $.ajax({
      url: "/PHPadvance/classajax.php",
      type: "POST",
      dataType: "json",
      data: new FormData(this),
      processData: false,
      contentType: false,
      beforeSend: function () {
        console.log("data is loading");
      },
      success: function (resoponse) {
        console.log(resoponse);
        $("#classModal").modal("hide");
        $("#classform")[0].reset();
        getusers();
      },
      error: function (request, error) {
        $("#usermodal").modal("hide");
        $("#addform")[0].reset();
        getusers();
        console.log(arguments);
        console.log(request);
        console.log("Error" + error);
      },
    });
  });
  $(document).on("click", "a.editClass", function () {
    var uid = $(this).data("id");
    $.ajax({
      url: "/PHPadvance/classajax.php",
      type: "GET",
      dataType: "json",
      data: { id: uid, action: "editclassdata" },
      beforeSend: function () {
        console.log("data is loading");
      },
      success: function (rows) {
        console.log(rows);
        if (rows) {
          $("#className").val(rows.ClassName);
        }
      },
      error: function (request, error) {
        console.log(arguments);
        console.log(request);
        console.log("Error " + error);
      },
    });
  });
  $(document).on("click", "a.deleteClass", function (e) {
    e.preventDefault();
    var uid = $(this).data("id");
    $.ajax({
      url: "/PHPadvance/classajax.php",
      type: "GET",
      dataType: "json",
      data: { id: uid, action: "deleteclass" },
      beforeSend: function () {
        console.log("waiting");
      },
      error: function (request, error) {
        console.log(arguments);
        console.log(request);
        console.log("Error " + error);
      },
    });
  });

  getUsers();
});
