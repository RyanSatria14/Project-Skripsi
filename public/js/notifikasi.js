const base_url = $('meta[name="base_url"]').attr("content");
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
$(document).on("click", ".btn-detail-notif", function () {

    let id = $(this).data("id");
    console.log(base_url);
    $.ajax({
        url: base_url +"/detail-notifikasi",
        data: {
            id: id,
        },
        method: "POST",
        dataType: "json",
        success: function (data) {
            let isi = "";
            let j = 1;
            $.each(data, function (i, val) {
                //console.log(data);
                isi +=
                    "<h6>Judul</h6>"+
                    "<div class='alert alert-secondary'>"+val.jd+"</div>" +
                    "<h6>Isi</h6>"+
                    "<div class='alert alert-secondary'>"+val.ket+"</div>";
            });
            $("#isi-notif").html(isi);
        },
    });
});
