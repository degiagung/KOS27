let dtpr;

$(document).ready(function () {

    loadfasilitas('kos','fasilitas');
    loadfasilitas('penghuni','fasilitas-penghuni');
    loadtipe();
    loadpenghuni();
    getListData();
    
});
$('.select2').select2();

var dateToday = new Date();

$('.daterange-time').daterangepicker({
    timePicker: false,
    applyClass: 'bg-slate-600',
    cancelClass: 'btn-clear_daterange',
    locale: {
        format: 'YYYY-MM-DD',
        cancelLabel: 'Clear'
    },
    maxDate: dateToday,
});

$("#filter-btn").on('click',function(e){
    	
    getListData()
    
})

function getListData() {
    filterstatus    = $("#filter-status").val() ;
    filterkondisi   = $("#filter-kondisi").val() ;
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/getListKamar",
            type: "POST",
            data: {
                status   : filterstatus,
                kondisi  : filterkondisi,
            },
            dataType: "json",
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
                data: "id",sClass:"tdnumber",
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            { data: "no_kamar",sClass:"td100",
                render: function (data, type, row, meta) {
                    return 'Kamar '+row.no_kamar;
                }, 
            },
            { data: "lantai",sClass:"td100",
                render: function (data, type, row, meta) {
                    return 'Lantai '+row.lantai;
                },
            },
            { data: "faskos" },
            { data: "status_kamar",sClass:"td100",
                mRender: function (data, type, row) {
                    if(row.status_kamar == 'Kosong'){
                        return `<button class="nav-link active">`+row.status_kamar+`</button>`;
                    }else{
                        return `<button class="btn btn-sgn">`+row.status_kamar+`</button>`;

                    }
                }
            },
            { data: "durasi",sClass:"td200",
                mRender: function (data, type, row) {
                    return window.datetostring2('yymmdd',row.tgl_awal) +'<br><b> &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;SD </b><br>'+window.datetostring2('yymmdd',row.tgl_akhir);
                }
            },
            { data: "sisa_durasi",
                mRender: function (data, type, row) {
                    if(row.sisa_durasi < 0)
                    return `<p style="color:red;font-weight:bold;">Habis</p>`
                    else if(row.sisa_durasi == 0)
                    return `<p style="color:#e1e155;">Hari Terakhir</p>`;
                    else
                    return `<p style="color:green;">`+row.sisa_durasi+` Hari</p>`
                }
            },
            { data: "name" },
            { data: "k.status",
                mRender: function (data, type, row) {
                    if(row.status != 'perbaikan')
                    return 'fasilitas baik'
                    else
                    return 'perbaikan fasilitas'
                }
            },
            { 
                mRender: function (data, type, row) {
                    var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm mx-2 edit-btn"><i class="bi bi-pencil-square"></i></button>`;
                    $rowData += `<button type="button" class="btn btn-danger btn-icon-sm delete-btn"><i class="bi bi-x-square"></i></button>`;
                    return $rowData;
                },
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
    $("#form-no").val(rowData.no_kamar);
    $("#form-lantai").val(rowData.lantai);
    $("#form-tipe").val(rowData.tipe).trigger('change');;
    $("#form-harga").val(rowData.harga);
    $("#form-penghuni").val(rowData.user_id).trigger('change');
    $("#form-durasi").val(rowData.tgl_awal+" - "+rowData.tgl_akhir);

    var idfaskos=rowData.idfaskos;
    $.each(idfaskos.split(","), function(i,e){
        // $("#form-fasilitas option[value='" + e + "']").prop("selected", true);
    });
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

$("#form-penghuni").change(function (e) {
    if($("#form-penghuni").val()){
        $(".durasi").show();
    }else{
        $(".durasi").hide();
    }
});

$("#save-btn").on("click", function (e) {
    e.preventDefault();
    checkValidation();

});

function checkValidation() {

    if (
        validationSwalFailed(
            ($("#form-no").val()),
            "No Kamar tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            ($("#form-lantai").val()),
            "Lantai tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            ($("#form-tipekamar").val()),
            "Tipe Kamar tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            ($("#form-harga").val()),
            "Harga Kamar tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            ($("#form-fasilitas").val()),
            "fasilitas dari kos tidak boleh kosong"
        )
    )
        return false;
    if (
        validationSwalFailed(
            ($("#form-sampul").val()),
            "Foto Sampul Kamar tidak boleh kosong"
        )
    )
        return false;
        
    if($("#form-penghuni").val()){
        if (
            validationSwalFailed(
                ($("#form-durasi").val()),
                "Durasi Kos tidak boleh kosong"
            )
        )
            return false;
    }
    saveData();
}

function deleteData(data) {
    const formData    = new FormData();
    isObject = {};
    formData.append('tipe','deleted');
    formData.append('id',data.id);
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
        if (e.value) {
            $.ajax({
                url: baseURL + "/actionKamar",
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
                        swal("Berhasil Delete !", '', "success");
                    } else {
                        sweetAlert("Oops...", response.info, "ERROR");
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    // console.log("ERROR");
                    sweetAlert("Oops...", "ERROR", "ERROR");
                },
            });
        } else {
            swal(
                "Cancelled !!",
                "Hey, your imaginary file is safe !!",
                "ERROR"
            );
        }
    });
}
function saveData() {
    const formData    = new FormData(document.getElementById("formfilelainnya"));
    formData.append('tipe','');
    formData.append('no',$('#form-no').val());
    formData.append('lantai',$('#form-lantai').val());
    formData.append('tipekamar',$('#form-tipekamar').val());
    formData.append('harga',$('#form-harga').val());
    formData.append('fasilitas',$('#form-fasilitas').val());
    formData.append('fasilitaspenghuni',$('#form-fasilitas-penghuni').val());
    formData.append('penghuni',$('#form-penghuni').val());
    formData.append('durasi',$('#form-durasi').val());


    $.ajax({
        url: baseURL + "/actionKamar",
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
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                savesampul(response.data);
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
        },
    });
}

function savesampul(idkamar) {
    const formData    = new FormData(document.getElementById("formsample"));
    formData.append('idkamar',idkamar);

    $.ajax({
        url: baseURL + "/saveFileSampul",
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
            $("#modal-data").modal("hide");
            $('#table-list').DataTable().ajax.reload();
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                swal("Berhasil !", 'Data Kamar telah di perbaharui', "success");
            } else {
                sweetAlert("Oops...", response.info, "ERROR");
            }
        },
        error: function (xhr, status, error) {
            sweetAlert("Oops...", "ERROR", "ERROR");
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
            const user_id = res[i]['id'];
            const penghuni = res[i]['name'];

            content += `
                <option value="`+user_id+`">`+penghuni+`</option>
            `;
        }
        $("#form-penghuni").append(content);
        $("#form-penghuni").select2({
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
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

        $("#form-tipekamar").select2({
            data: res,
            placeholder: "Please choose an option",
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
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
            const id = res[i]['id'];
            const fasilitas = res[i]['fasilitas'];

            content += `
                <option value="`+id+`">`+fasilitas+`</option>
            `;
        }
        $("#form-"+id).append(content);
        $("#form-"+id).select2({
            dropdownParent: $("#modal-data"),
        });
    } catch (error) {
        sweetAlert("Oops...", error.responseText, "ERROR");
    }
}