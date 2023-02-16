<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h6 class="m-0 font-weight-bold text-primary">Ürünler</h6>
            </div>
            <div class="col-md-8 text-right">
                <a class="btn btn-primary" href="/products/insert">
                    <i class="fa fa-plus"></i> Yeni Ürün Ekle
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Ürün Fiyatı</th>
                    <th>Ürün Stok Miktarı</th>
                    <th>Düzenle</th>
                    <th>Sil</th>
                    <th>Satış Yap</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Ürün Fiyatı</th>
                    <th>Ürün Stok Miktarı</th>
                    <th>Düzenle</th>
                    <th>Sil</th>
                    <th>Satış Yap</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($data['products'] as $products) : ?>
                    <tr>
                        <td><?php echo $products['products_name']; ?></td>
                        <td><?php echo $products['products_price']; ?></td>
                        <td><?php echo $products['products_count']; ?></td>
                        <td>
                                <a href="/products/update/<?php echo $products['products_id']; ?>" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
                                </span>
                                    <span class="text">Düzenle</span>
                                </a>
                        </td>
                        <td>
                                <a onclick="deleteFunction(<?php echo $products['products_id']; ?>)" class="btn btn-danger btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-trash"></i>
                                </span>
                                    <span class="text">Sil</span>
                                </a>
                        </td>
                        <td>
                            <?php if($products['products_count'] != 0) { ?>
                                <a href="/products/sales/<?php echo $products['products_id']; ?>" class="btn btn-primary btn-icon-split">
                                    <span class="icon text-white-50">
                                    <i class="fas fa-edit"></i>
                                    </span>
                                    <span class="text">Ürünü Sat</span>
                                </a>
                            <?php } else { ?>
                                <span clas="text">Stokta yok</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function deleteFunction(id) {
        $.ajax({
            type: "GET",
            url: "/products/delete/"+id,
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
                    alertify.errorAlert("Ürün başarılı bir şekilde silindi.").set('onok', function(closeEvent){ alertify.success('Sayfa Yenileniyor.'); setTimeout(function() {location.reload();}, 2000);} );
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
                    alertify.errorAlert("Ürün silinirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.");
                }
            }
        });
    }
</script>