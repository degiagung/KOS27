$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// console.log(1);
$(document).ready(function() {
    // // Delay the execution of getMenuAccess() by 2 seconds
    // setTimeout(function() {
    //     getMenuAccess();
    // }, 1000); // 2000 milliseconds = 2 seconds
    getMenuAccess();
});

function getMenuAccess() {
    $.ajax({
        url: baseURL + "/getAccessMenu",
        type: "POST",
        data: JSON.stringify({ uid: 2}),
        dataType: "json",
        contentType: "application/json",
        beforeSend: function () {
            // Swal.fire({
            //     title: "Loading",
            //     text: "Please wait...",
            //     showConfirmButton: false, // Menyembunyikan tombol OK
            // });
        },
        complete: function () {
            // swal.close();
        },
        success: function (response) {
            // Handle response sukses
            if (response.code == 0) {
                // swal("Saved !", response.info, "success").then(function () {
                //     location.reload();
                // });
                // Reset form
                let data = response.data;
                let groupedData = {};
                let allGroupHTML = ""; // Tambahkan variabel di sini untuk menggabungkan semua grup
                // Loop through the data and group items based on "header_menu"
                data.forEach(function (item) {
                    let groupName = item.header_menu;

                    if (!groupedData[groupName]) {
                        groupedData[groupName] = [];
                    }

                    groupedData[groupName].push(item);
                });

                for (var groupName in groupedData) {
                    var groupItems = groupedData[groupName];


                    // var groupHTML = `<ul class="metismenu" id="${groupName}">
                    //   <li class="menu-title">${groupName}</li>`;
                    var groupHTML = '';

                    groupItems.forEach(function (item) {
                        groupHTML += `
                                        <li class="nav-item">
                                            <a class="nav-link collapsed" id="${groupName}" href="${item.url}">
                                            <i class="bi bi-grid"></i>
                                            <span>${item.menu_name}</span>
                                            </a>
                                        </li>
                                    `;
                        });

                        // groupHTML += `
                        //             <li>
                        //                 <a href="${item.url}" class="">
                        //                     <div class="menu-icon">
                        //                         <i class="bi bi-dot"></i>
                        //                     </div>
                        //                     <span class="nav-text">${item.menu_name}</span>
                        //                 </a>
                        //             </li>`;
                        // });

                    // groupHTML += `</ul>`;

                    allGroupHTML += groupHTML; // Gabungkan semua grup
                }

                // Setelah loop selesai, append semua grup ke elemen dengan class "isSidebarMenu"
                $(".isSidebarMenu").html(allGroupHTML);
            } else {
                sweetAlert("Oops...", response.info, "error");
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            sweetAlert("Oops...", xhr.responseText, "error");
        },
    });
}

function validationSwalFailed(param, isText) {
    // console.log(param);
    if (param == "" || param == null) {
        sweetAlert("Oops...", isText, "warning");

        return 1;
    }
}

function formatRupiah(angka, prefix) {
    // var angka = angka.split(".");
	if(angka){
		var seeminus = angka.substr(0,1);
		if(seeminus == '-'){
			var minus = '-';
			var angka = angka.substr(1).replace(/[^,\d]/g, ',');
		}else{
			var minus = '';
			
			var angka = angka.replace(/[^,\d]/g, ',');
		}
		var number_string = angka.toString(),
			split = number_string.split(","),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		
		if (ribuan) {
			separator = sisa ? "," : "";
			rupiah += separator + ribuan.join(",");
		}
	
		rupiah = split[1] != undefined ? minus+rupiah + "." + split[1] : rupiah;
		return prefix == undefined ? rupiah : rupiah ? "Rp " + rupiah : "";
	}else{
		return '';
	}
    
}