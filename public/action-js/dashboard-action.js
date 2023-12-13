
$.extend($.fn.dataTable.defaults, {
    autoWidth: false,
    columnDefs: [
      {
        orderable: false,
        width: "100px",
        targets: [5],
      },
    ],
    dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
    language: {
        search      : '_INPUT_',
        lengthMenu  : '_MENU_',
        paginate    : { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
    },
    buttons: [
        { 
            className: 'btnreload',
            text: '<i class="icon-reload-alt" ></li>',
            action: function ( e, dt, node, config ) {     
                getListData();
            }
        },
    ],
    drawCallback: function () {
      $(this)
        .find("tbody tr")
        .slice(-3)
        .find(".dropdown, .btn-group")
        .addClass("dropup");
    },
    preDrawCallback: function () {
      $(this)
        .find("tbody tr")
        .slice(-3)
        .find(".dropdown, .btn-group")
        .removeClass("dropup");
    },
});

$('.select2').select2();

$("#filter-btn").on('click',function(e){
    	
    getListData()
    
})
getListData();
function getListData() {
    filtersisa = $("#filter-sisa").val() ;
    $('#table-list').dataTable().fnClearTable();
    $('#table-list').dataTable().fnDraw();
    $('#table-list').dataTable().fnDestroy();
    dtpr = $("#table-list").DataTable({
        ajax: {
            url: baseURL + "/listKamarDashboard",
            type: "POST",
            data: {
                sisawaktu   : filtersisa,
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
            { data: "durasi",sClass:"td150",
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
            { mRender: function (data, type, row) {
                    // if(row.sisa_durasi < 0)
                    // return `<p style="color:red;font-weight:bold;">Habis</p>`
                    // else
                    return `<a style="cursor:pointer;color:#fff;background: green;" class="showbill" > Sudah Bayar</a>`
                }
            },
            { 
                mRender: function (data, type, row) {
                    var $rowData = `<button type="button" class="btn btn-primary btn-icon-sm mx-2 edit-btn"><i class="bi bi-pencil-square"></i></button>`;
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
                .find(".showbill")
                .on("click", function () {
                    var tr = $(this).closest("tr");
                    var rowData = dtpr.row(tr).data();
                    showbill(rowData);
                });
            $(rows)
                .find(".showbilln")
                .on("click", function () {
                    swalwarning('Penghuni Belum Bayar');
                });
        },
    });
}

function showbill(params) {
    $("#modal-bill").modal('show');
}

function generatePDF(){   
    
    // var testDivElement = document.getElementById('sertifikat');
    var imgData;
    html2canvas($("#tablebill"), {
        useCORS: true,
        onrendered: function (canvas) {
            imgData = canvas.toDataURL('image/png');
            // var doc = new jsPDF();
            var doc = new jsPDF('landscape', 'mm', 'a4');
            doc.addImage(imgData, 'PNG', 15, 40, 150, 60);
            // doc.addImage(imgData, 'PNG', 15, 40, 180, 160);
            doc.save('bill'.replaceAll(' ','')+'.pdf');
            // window.open(imgData);
        }
    });

    // $("#myModal").modal('hide');
    
};