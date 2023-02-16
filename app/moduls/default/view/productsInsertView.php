<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-6">
                <h6 class="m-0 font-weight-bold text-primary"> Yeni Ürün Ekle</h6>
            </div>
            <div class="col-md-6 text-right">
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
                <input type="text" name="products_name" class="form-control" id="productsName">
            </div>
            <div class="form-group">
                <label for="productsPrice">Ürün Fiyatı <small>Türk Lirası cinsinden</small></label>
                <input type="text" name="products_price" class="form-control" id="productsPrice">
            </div>
            <div class="form-group">
                <label for="productsName">Ürün Adedi</label>
                <input type="text" name="products_count" class="form-control" id="productsCount">
            </div>
            <input type="button" name="insert" id="btn_action" class="btn btn-primary" value="Kaydet">
        </form>
    </div>
</div>

<script type="text/javascript">
    $("#btn_action").on("click", function () {
        $.ajax({
            type: "POST",
            url: "/products/insert/productsInsertOp",
            data: $("#frm_submit").serialize(),
            success: function (response) {
                res = JSON.parse(response);
                if(res.status) {
                    $("form").trigger("reset");
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
                    alertify.errorAlert("Ürün başarılı bir şekilde eklendi.");
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
                    alertify.errorAlert("Ürün eklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.");
                }
            }
        });
    });
</script>