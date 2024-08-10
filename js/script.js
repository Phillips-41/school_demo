function getuserrow(user) {
  var userRow = "";
  if (user) {
    userRow = `<tr>
      <td scope="row"><img src=uploads/${user.image}></td>
      <td>${user.name}</td>
      <td>${user.email}</td>
      <td>${user.created_at}</td>
      <td>${user.className}</td>
      <td>
        <a href="#" class="mr-3 profile" data-target="#userViewModal" data-toggle="modal" data-id=${user.id}><i class="fas fa-eye"></i></a>
        <a href="#" class="mr-3 editStudent" data-target="#userModal" data-toggle="modal" data-id=${user.id}><i class="fas fa-edit"></i></a>
        <a href="#" class="mr-3 deleteStudent" ><i class="fas fa-trash-alt" data-id=${user.id}></i></a>
      </td>
    </tr>`;
  }
  return userRow;
}
function getusers() {
  $.ajax({
    url: "/PHPadvance/ajax.php",
    type: "GET",
    dataType: "json",
    data: { action: "getAllStudents" },
    beforeSend: function () {
      console.log("data is loading");
    },
    success: function (rows) {
      console.log(rows);
      var userlist = "";
      $.each(rows, function (index, user) {
        // iterate over rows, not rows.players
        userlist += getuserrow(user);
      });
      $("#usertable tbody").html(userlist);
    },
    error: function (request, error) {
      console.log(arguments);
      console.log(request);
      console.log("Error " + error);
    },
  });
}

$(document).ready(function () {
  $(document).on("submit", "#addform", function (e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append("userphoto", $("input[type=file]")[0].files[0]);
    // ajax
    $.ajax({
      url: "/PHPadvance/ajax.php",
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
        $("#usermodal").modal("hide");
        $("#addform")[0].reset();
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
  $(document).on("click", "a.editStudent", function () {
    var uid = $(this).data("id");
    $.ajax({
      url: "/PHPadvance/ajax.php",
      type: "GET",
      dataType: "json",
      data: { id: uid, action: "edituserdata" },
      beforeSend: function () {
        console.log("data is loading");
      },
      success: function (rows) {
        console.log(rows);
        if (rows) {
          $("#username").val(rows.name);
          $("#email").val(rows.email);
          $("#address").val(rows.address);
          $("#class").val(rows.className);
          $("#studentId").val(rows.id);
        }
      },
      error: function (request, error) {
        console.log(arguments);
        console.log(request);
        console.log("Error " + error);
      },
    });
  });
  $(document).on("click", "a.deleteStudent", function (e) {
    e.preventDefault();
    var uid = $(this).data("id");
    $.ajax({
      url: "/PHPadvance/ajax.php",
      type: "GET",
      dataType: "json",
      data: { id: uid, action: "deleteuser" },
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
  $(document).on("click", "a.profile", function () {
    var uid = $(this).data("id");
    $.ajax({
      url: "/PHPadvance/ajax.php",
      type: "GET",
      dataType: "json",
      data: { id: uid, action: "edituserdata" },
      beforeSend: function () {
        console.log("data is loading");
      },
      success: function (user) {
        if (user) {
          const profile = `
          <div class="card" style="width: 18rem;">
          <img src="uploads/${user.photo}" class="card-img-top" alt="${user.name}'s photo">
          <div class="card-body">
            <h5 class="card-title">${user.name}</h5>
            <p class="card-text"><strong>Email:</strong> ${user.email}</p>
            <p class="card-text"><strong>Address:</strong> ${user.address}</p>
            <p class="card-text"><strong>Class Name:</strong> ${user.className}</p>
            <p class="card-text"><strong>Creation Date:</strong> ${user.created_at}</p>
          </div>
        </div>
        `;
          $("#profile").html(profile);
        }
      },
      error: function (request, error) {
        console.log(arguments);
        console.log(request);
        console.log("Error " + error);
      },
    });
  });

  getusers();
});
