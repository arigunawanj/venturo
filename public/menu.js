function menu() {  
    $.ajax({
        type: "get",
        url: "/menu",
        dataType: "json",
        success: function (response) {
            response.map((value) => {
                $('#tahun').append($('<tbody>', {
                    tr: value.kategori,
                    td: value.menu
                }));
            }) 
        }
    });
}

