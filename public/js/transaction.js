$(function () {
    $(".myselect").select2();


})

function getDetailProduct() {
    var id = $('[name="product_id"]').val();
console.log(APP_URL);

    if (id != '') {
        $.ajax({
            url: APP_URL + "/api/product/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('#addCart').attr('href', APP_URL + '/add-to-cart/' + id);
                $('#name').html(data.code + '# ' + data.name);
                $('#price').html(
                    accounting.formatMoney(data.price,  {
                        symbol: 'Rp. '
                    })
                    );
                $('#showImage').removeClass('d-none');
                if(data.photo){
                    $('#photo').attr('src', APP_URL + '/uploads/product/' + data.photo);
                } else {
                    $('#photo').attr('src', APP_URL + '/dist/img/50x50.png');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error get data from ajax");
            },
        });
    }
}
