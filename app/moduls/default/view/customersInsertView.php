<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-4">
                <h6 class="m-0 font-weight-bold text-primary">Yeni Müşteri Ekle</h6>
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
                <input type="text" require name="customers_firstname" class="form-control" id="customersFirstName">
            </div>
            <div class="form-group">
                <label for="customersLastName">Müşteri Soyadı</label>
                <input type="text" require name="customers_lastname" class="form-control" id="customersLastName">
            </div>
            <div class="form-group">
                <label for="customersPhone">Müşteri Telefon Numarası</label>
                <input type="text" require name="customers_phone" class="form-control" id="customersPhone">
            </div>
            <div class="form-group">
                <label for="customersEmail">Müşteri E-posta Adresi</label>
                <input type="text" require name="customers_email" class="form-control" id="customersEmail">
            </div>
            <input type="hidden" name="users_id" value="<?php echo $_SESSION['users']['users_id']; ?>">
            <input type="button" name="insert" id="btn_action" class="btn btn-primary" value="Kaydet">
        </form>
    </div>
</div>

<script type="text/javascript">
    $("#btn_action").on("click", function () {
        $.ajax({
            type: "POST",
            url: "/customers/insert/customersInsertOp",
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
                    alertify.errorAlert("Müşteri başarılı bir şekilde eklendi.");
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
                    alertify.errorAlert("Müşteri eklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.");
                }
            }
        });
    });
</script>