<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h6 class="m-0 font-weight-bold text-primary">Müşteri Bilgilerini Düzenle</h6>
            </div>
            <div class="col-md-8 text-right">
                <a class="btn btn-primary" href="/customers">
                    <i class="fa fa-arrow-left"></i> Geri Dön
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="frm_submit">
            <div class="form-group">
                <label for="customersFirstName">Müşteri Adı</label>
                <input type="text" name="customers_firstname" class="form-control" id="customersFirstName" value="<?php echo $data['customers']['customers_firstname']; ?>">
            </div>
            <div class="form-group">
                <label for="customersLastName">Müşteri Soyadı</label>
                <input type="text" name="customers_lastname" class="form-control" id="customersLastName" value="<?php echo $data['customers']['customers_lastname']; ?>">
            </div>
            <div class="form-group">
                <label for="customersPhone">Müşteri Telefon Numarası</label>
                <input type="text" name="customers_phone" class="form-control" id="customersPhone" value="<?php echo $data['customers']['customers_phone']; ?>">
            </div>
            <div class="form-group">
                <label for="customersEmail">Müşteri E-Posta Adresi</label>
                <input type="text" name="customers_email" class="form-control" id="customersEmail" value="<?php echo $data['customers']['customers_email']; ?>">
            </div>
            <input type="hidden" name="customers_id" value="<?php echo $data['customers']['customers_id']; ?>">
            <input type="button" name="update" id="btn_action" class="btn btn-primary" value="Güncelle">
        </form>
    </div>
</div>

<script type="text/javascript">
    $("#btn_action").on("click", function () {
        $.ajax({
            type: "POST",
            url: "/customers/update/customersUpdateOp",
            data: $("#frm_submit").serialize(),
            success: function (response) {
                res = JSON.parse(response);
                if(res.status) {
                    //$("form").trigger("reset");
                    $('#customersFirstName').val(res.customers.customers_firstname);
                    $('#customersLastName').val(res.customers.customers_lastname);
                    $('#customersPhone').val(res.customers.customers_phone);
                    $('#customersEmail').val(res.customers.customers_email);
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
                    alertify.errorAlert("Müşteri bilgileri başarılı bir şekilde güncellendi.");
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
                    alertify.errorAlert("Müşteri bilgileri güncellenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.");
                }
            }
        });
    });
</script>