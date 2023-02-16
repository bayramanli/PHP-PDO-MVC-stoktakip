<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-8">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $data['products']['products_name']; ?> Ürün Bilgilerini Düzenle</h6>
            </div>
            <div class="col-md-4 text-right">
                <a class="btn btn-primary" href="/products">
                    <i class="fa fa-arrow-left"></i> Geri Dön
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="frm_submit">
            <div class="form-group">
                <label for="productsName">Ürün Adı</label>
                <input type="text" name="products_name" class="form-control" id="productsName" value="<?php echo $data['products']['products_name']; ?>">
            </div>
            <div class="form-group">
                <label for="productsPrice">Ürün Fiyatı</label>
                <input type="text" name="products_price" class="form-control" id="productsPrice" value="<?php echo $data['products']['products_price']; ?>">
            </div>
            <div class="form-group">
                <label for="productsCount">Ürün Stok Adedi</label>
                <input type="text" name="products_count" class="form-control" id="productsCount" value="<?php echo $data['products']['products_count']; ?>">
            </div>
            <input type="hidden" name="products_id" value="<?php echo $data['products']['products_id']; ?>">
            <input type="button" name="update" id="btn_action" class="btn btn-primary" value="Güncelle">
        </form>
    </div>
</div>


<script type="text/javascript">
    $("#btn_action").on("click", function () {
        $.ajax({
            type: "POST",
            url: "/products/update/productsUpdateOp",
            data: $("#frm_submit").serialize(),
            success: function (response) {
                res = JSON.parse(response);
                if(res.status) {
                    //$("form").trigger("reset");
                    $('#productsName').val(res.products.products_name);
                    $('#productsPrice').val(res.products.products_price);
                    $('#productsCount').val(res.products.products_count);
                    if (!alertify.errorAlert) {
                        //define a new errorAlert base on alert
                        alertify.dialog('errorAlert', function factory() {
                            return {
                                build: function () {
                                    var errorHeader = '<span class="fa fa-windows" '
                                        + 'style="vertical-align:middle;color:#e10000;">'
                                        + '</span> Bilgilendirme Mesajı';
                                    this.setHeader(errorHeader);
                                }
                            };
                        }, true, 'alert');
                    }
                    alertify.errorAlert("Ürün bilgileri başarılı bir şekilde güncellendi.");
                } else {
                    if (!alertify.errorAlert) {
                        //define a new errorAlert base on alert
                        alertify.dialog('errorAlert', function factory() {
                            return {
                                build: function () {
                                    var errorHeader = '<span class="fa fa-windows" '
                                        + 'style="vertical-align:middle;color:#e10000;">'
                                        + '</span> Bilgilendirme Mesajı';
                                    this.setHeader(errorHeader);
                                }
                            };
                        }, true, 'alert');
                    }
                    alertify.errorAlert("Ürün bilgileri güncellenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.");
                }
            }
        });
    });
</script>