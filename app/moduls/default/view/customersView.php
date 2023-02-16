<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h6 class="m-0 font-weight-bold text-primary">Müşteriler</h6>
            </div>
            <div class="col-md-8 text-right">
                <a class="btn btn-primary" href="/customers/insert">
                    <i class="fa fa-plus"></i> Yeni Müşteri Ekle
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (!isset($data['customers'])) { ?>
            <div>
                <p>Henüz müşteri eklemediniz.</p>
            </div>
        <?php } else { ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Adı</th>
                        <th>Soyadı</th>
                        <th>Telefon Numarası</th>
                        <th>Email</th>
                        <th>Düzenle</th>
                        <th>Sil</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                    <th>Adı</th>
                        <th>Soyadı</th>
                        <th>Telefon Numarası</th>
                        <th>Email</th>
                        <th>Düzenle</th>
                        <th>Sil</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($data['customers'] as $customers) : ?>
                        <tr>
                            <td><?php echo $customers['customers_firstname']; ?></td>
                            <td><?php echo $customers['customers_lastname']; ?></td>
                            <td><?php echo $customers['customers_phone']; ?></td>
                            <td><?php echo $customers['customers_email']; ?></td>
                            <td>
                                <a href="/customers/update/<?php echo $customers['customers_id']; ?>" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-edit"></i>
                                </span>
                                    <span class="text">Düzenle</span>
                                </a>
                            </td>
                            <td>
                                <a onclick="deleteFunction(<?php echo $customers['customers_id']; ?>)" class="btn btn-danger btn-icon-split">
                                <span class="icon text-white-50">
                                  <i class="fas fa-trash"></i>
                                </span>
                                    <span class="text">Sil</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    function deleteFunction(id) {
        $.ajax({
            type: "GET",
            url: "/customers/delete/"+id,
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
                    alertify.errorAlert("Müşteri başarılı bir şekilde silindi.").set('onok', function(closeEvent){ alertify.success('Sayfa Yenileniyor.'); setTimeout(function() {location.reload();}, 2000);} );
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
                    alertify.errorAlert("Müşteri silinirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.");
                }
            }
        });
    }
</script>