

let dtpr;

$(document).ready(function () {
    loadfasilitas('kos','fasilitas');
    loadfasilitas('penghuni','fasilitas-penghuni');
    loadtipe();
    loadpenghuni();
    getListData();
 $('.select2').select2();

});

function getListData() {
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getListKamar",
            type: "POST",
            dataSrc: function (response) {
                if (response.code == 0) {
                    es = response.data;
                    // console.log(es);

                    return response.data;
                } else {
                    return response;
                }
            },
            complete: function () {
                // loaderPage(false);
            },
        },
        autoWidth: false,
        dom: '<"datatable-header"lfB><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        language: {
            search      : '_INPUT_',
            lengthMenu  : '_MENU_',
            paginate    : { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        buttons: [
            
            { 
                className: 'btnreload',
                text: '<i class="bi bi-arrow-clockwise" ></li>',
                action: function ( e, dt, node, config ) {     
                    $('#table-list').DataTable().ajax.reload();
                }
            },
            { text: ' ', extend: 'pdfHtml5',  className: 'btndownload iconpdf',  title:'List kamar', exportOptions: {columns:[':not(.notdown)']}},
            { text: ' ', extend: 'excel',  className: 'btndownload iconexcel',  title:'List kamar', exportOptions: {columns:[':not(.notdown)']}},
        ],
        columns: [
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "name" },
            { data: "email" },
            { data: "role_name" },
            { data: "status_name" },
            { 
                mRender: function (data, type, row) {
                    var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm mx-2 edit-btn"><i class="bi bi-pencil-square"></i></button>`;
                    $rowData += `<button type="button" class="btn btn-danger btn-icon-sm delete-btn"><i class="bi bi-x-square"></i></button>`;
                    return $rowData;
                },
                visible: true,
                targets: 5,
                className: "text-center"},
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: "current" }).nodes();
            var last = null;

            $(rows)
                .find(".edit-btn")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    editdata(rowData);
                });
            $(rows)
                .find(".delete-btn")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    deleteData(rowData);
                });
        },
    });
}

let isObject = {};

function editdata(rowData) {
    isObject = {};
    isObject = rowData;
    $('#formkamar input').val('');
    $('#formkamar select').val('').trigger('change');
    $("#form-fasilitas").val(rowData.fasilitas);
    $("#modal-data").modal("show");
}

$("#add-btn").on("click", function (e) {
    e.preventDefault();

    $('#formkamar input').val('');
    $('#formkamar select').val('').trigger('change');

    isObject = {};
    isObject["id"] = null;
    $("#modal-data").modal("show");
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    // checkValidation();
               var formData = new FormData(document.getElementById("formkamar"));

    console.log(formData);
});

function checkValidation() {

    if (
        validationSwalFailed(
            (isObject["no"] = $("#form-no").val()),
            "No Kamar tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["lantai"] = $("#form-lantai").val()),
            "Lantai tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["tipe"] = $("#form-tipe").val()),
            "Tipe Kamar tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["harga"] = $("#form-harga").val()),
            "Harga Kamar tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["fasilitas"] = $("#form-fasilitas").val()),
            "fasilitas dari kos tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            (isObject["sampul"] = $("#form-sampul").val()),
            "Foto Sampul Kamar tidak boleh kosong"
        )
    )
        return false;
    
    saveData();
}

function deleteData(data) {
    isObject = {};
    isObject["tipe"]    = 'deleted';
    isObject["id"]      = data.id;
    swal({
        title: "Apakah Yakin untuk mendelete ?",
        text: "Data tidak dapat di kembalikan",
        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Delete !!",
        cancelButtonText: "Tidak,Batalkan !!",
        closeOnConfirm: !1,
        closeOnCancel: !1,
    }).then(function (e) {
        console.log(e);
        if (e.value) {
            $.ajax({
                url: baseURL + "/actionFasilitas",
                type: "POST",
                data: JSON.stringify(isObject),
                dataType: "json",
                contentType: "application/json",
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
                        swal("Berhasil Delete !", response.message, "success");
                    } else {
                        sweetAlert("Oops...", response.message, "error");
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    // console.log(xhr.responseText);
                    sweetAlert("Oops...", xhr.responseText, "error");
                },
            });
        } else {
            swal(
                "Cancelled !!",
                "Hey, your imaginary file is safe !!",
                "error"
            );
        }
    });
}

function saveData() {
    isObject["tipe"] = '';
    $.ajax({
        url: baseURL + "/actionKamar",
        type: "POST",
        data: JSON.stringify(isObject),
        dataType: "json",
        contentType: "application/json",
        beforeSend: function () {
            Swal.fire({
                title: "Loading",
                text: "Please wait...",
            });
        },
        complete: function () {
            $("#modal-data").modal("hide");
            $('#table-list').DataTable().ajax.reload();
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                swal("Berhasil !", response.message, "success");
            } else {
                sweetAlert("Oops...", response.message, "error");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", xhr.responseText, "error");
        },
    });
}

async function loadpenghuni() {
    $("#form-penghuni").empty();
    try {
        const response = await $.ajax({
            url: baseURL + "/getPenghuni",
            type: "POST",
            dataType: "json",
            beforeSend: function () {
                // Swal.fire({
                //     title: "Loading",
                //     text: "Please wait...",
                // });
            },
        });

        const res = response.data ;
        let content = '<option value="">Pilih Penghuni</option>';
        for (let i = 0; i < res.length; i++) {
            const penghuni = res[i]['name'];

            content += `
                <option value="`+penghuni+`">`+penghuni+`</option>
            `;
        }
        $("#form-penghuni").append(content);
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "error");
    }
}

async function loadtipe() {
    try {
        const response = await $.ajax({
            url: baseURL + "/getTipeKamar",
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
            return {
                id: item.id,
                text: item.tipe,
            };
        });

        $("#form-tipe").select2({
            data: res,
            placeholder: "Please choose an option",
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "error");
    }
}

async function loadfasilitas(jenis,id) {
    try {
        $("#form-"+id).empty();
        const response = await $.ajax({
            url: baseURL + "/getFasilitas",
            type: "POST",
            dataType: "json",
            data:{
                jenis : jenis
            }
        });

        const res = response.data ;
        let content = '';
        for (let i = 0; i < res.length; i++) {
            const fasilitas = res[i]['fasilitas'];

            content += `
                <option value="`+fasilitas+`">`+fasilitas+`</option>
            `;
        }
        $("#form-"+id).append(content);
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "error");
    }
}