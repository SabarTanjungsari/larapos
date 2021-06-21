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
                    $('#photo').attr('src', 'http://via.placeholder.com/50x50');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error get data from ajax");
            },
        });
    }
}
