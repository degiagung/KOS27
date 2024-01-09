

let dtpr;
var isObject = {};
$(document).ready(function () {
    loadData();
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();
});


function checkValidation() {
    if (
        validationSwalFailed(
            (isObject["nama"] = $("#form-nama").val()),
            "Nama harus diisi."
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["handphone"] = $("#form-handphone").val()),
            "Handphone harus diisi."
        )
    )
        return false;
    // isObject["password"] = $("#form-password").val();
    saveData();
}

function saveData() {
    const formData    = new FormData(document.getElementById("formfoto"));
    formData.append('nama',isObject['nama']);
    formData.append('handphone',isObject['handphone']);
    $.ajax({
        url: baseURL + "/editprofile",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            Swal.fire({
                title: "Loading",
                text: "Please wait...",
            });
        },
        complete: function () {
            $('#table-list').DataTable().ajax.reload();
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                 swal("Berhasil !", response.info, "success").then(function () {
                    location.reload();
                });
            } else {
                sweetAlert("Oops...", response.message, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            // console.log("ERROR");
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

async function loadData() {
    $(".inputan").val('');
    try {
        const response = await $.ajax({
            url: baseURL + "/getdataprofile",
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                // Swal.fire({
                //     title: "Loading",
                //     text: "Please wait...",
                // });
            },
        });
        const res = response.data.map(function (item) {
            console.log(item);
            $("#form-nama").val(item.name);
            $("#form-handphone").val(item.handphone);
            $(".name").html(item.name);
            file = baseURL+item.profile.replaceAll('../public','');

            $(".showfoto").append(`
            <img src="`+file+`"  style="width:100%">
            `);
            // return {
            //     id: item.id,
            //     text: item.role_name,
            // };
        });

        $("#form-role").select2({
            data: res,
            placeholder: "Please choose an option",
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}