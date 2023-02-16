<?php

class defaultController extends mainController
{

    public function index()
    {
        $data = [];
        if (isset($_SESSION['users'])) {
            $this->callLayout("frontend", "main", "default", "index", $data);
        } else {
            Header("Location:/login");
        }
    }

    //404 Page
    public function page404()
    {
        $data = [];
        $this->callView("default", "404");
    }

    public function login()
    {
        $data = [];
        if (isset($_SESSION['users'])) {
            Header("Location:/dashboard");
            exit();
        } else {
            $this->callView("default", "login", $data);
        }
    }

    public function register()
    {
        $data = [];
        $this->callView("default", "register", $data);
    }

    public function usersInsertOp()
    {
        $data = [];
        $usersInsertModel = new defaultModel();
        $_SESSION['messageManagement'] = $usersInsertModel->usersInsertModel();
        if ($_SESSION['messageManagement']['status'] == 1) {
            Header("Location:/login");
        } else {
            Header("Location:{$_SERVER['HTTP_REFERER']}");
            exit();
        }
    }

    public function loginControl()
    {
        $data = [];
        $loginControlModel = new defaultModel();
        $data = $loginControlModel->loginControlModel();
        //echo "<pre>";
        //print_r($data['status']);
        //exit();

        if ($data['status']) {
            $_SESSION['messageManagement']['status'] = TRUE;
            $_SESSION['messageManagement']['message'] = "Başarılı bir şekilde giriş yapıldı.";
            Header("Location:/dashboard");
        } else {
            $_SESSION['messageManagement']['status'] = FALSE;
            $_SESSION['messageManagement']['message'] = "Giriş Başarısız. Lütfen bilgilerinizi doğru girerek tekrar deneyiniz.";
            Header("Location:{$_SERVER['HTTP_REFERER']}");
            exit;
        }
    }

    public function logout()
    {
        $data = [];
        $logout = new defaultModel();
        $logout->logoutModel();
        $this->callView("default", "login", $data);

    }

    //customers
    public function customers()
    {
        $users_id = $_SESSION['users']['users_id'];
        $data = [];
        $customersModel = new defaultModel();
        $data['customers'] = $customersModel->customersModel($users_id);
        $this->callLayout("frontend", "main", "default", "customers", $data);
    }

    public function customersInsert()
    {
        $data = [];
        $this->callLayout("frontend", "main", "default", "customersInsert", $data);
    }

    public function customersInsertOp()
    {
        $customersInsertOp = new defaultModel();
        $data = $customersInsertOp->customersInsertOp();
        echo json_encode($data);
        exit();
    }

    public function customersUpdate($customers_id)
    {
        $data = [];
        $customersUpdateModel = new defaultModel();
        $data['customers'] = $customersUpdateModel->customersUpdate($customers_id);
        $this->callLayout("frontend", "main", "default", "customersUpdate", $data);
    }

    public function customersUpdateOp()
    {

        $customersUpdateOpModel = new defaultModel();
        $data = $customersUpdateOpModel->customersUpdateOp();
        $data['customers'] = $customersUpdateOpModel->customersUpdate($_POST['customers_id']);
        echo json_encode($data);
        exit();
    }

    public function customersDelete($customers_id)
    {
        $customersDeleteModel = new defaultModel();
        $data = $customersDeleteModel->customersDelete($customers_id);
        echo json_encode($data);
        exit();
    }

    //PRODUCTS
    public function products()
    {
        $data = [];
        $productsModel = new defaultModel();
        $data['products'] = $productsModel->productsModel();
        $this->callLayout("frontend", "main", "default", "products", $data);
    }

    public function productsInsert()
    {
        $data = [];
        $this->callLayout("frontend", "main", "default", "productsInsert", $data);
    }

    public function productsInsertOp()
    {
        $productsInsertOp = new defaultModel();
        $data = $productsInsertOp->productsInsertOp();
        echo json_encode($data);
        exit();
    }

    public function productsUpdate($products_id)
    {
        $data = [];
        $productsUpdateModel = new defaultModel();
        $data['products'] = $productsUpdateModel->productsUpdate($products_id);
        $this->callLayout("frontend", "main", "default", "productsUpdate", $data);
    }

    public function productsUpdateOp()
    {

        $productsUpdateOpModel = new defaultModel();
        $data = $productsUpdateOpModel->productsUpdateOp();
        $data['products'] = $productsUpdateOpModel->productsUpdate($_POST['products_id']);
        echo json_encode($data);
        exit();
    }

    public function productsDelete($products_id)
    {
        $productsDeleteModel = new defaultModel();
        $data = $productsDeleteModel->productsDelete($products_id);
        echo json_encode($data);
        exit();
    }

    public function productsSales($products_id)
    {
        $users_id = $_SESSION['users']['users_id'];
        $data = [];
        $productModel = new defaultModel();
        $data['products'] = $productModel->productsInfo($products_id);
        $data['customers'] = $productModel->customersModel($users_id);
        //echo "<pre>";
        //print_r($data);
        //exit();
        $this->callLayout("frontend", "main", "default", "productsSales", $data);
    }


    public function productsSalesOp()
    {
        $data = [];

        if($_POST['products_count'] < $_POST['sales_count']) {
            $_SESSION['messageManagement']['status'] = FALSE;
            $_SESSION['messageManagement']['message'] = "Girdiğiniz ürün miktarı kadar ürün stokta bulunmamaktadır.";
            Header("Location:{$_SERVER['HTTP_REFERER']}");
            exit;
        }
        
        $productsModel = new defaultModel();
        $data = $productsModel->productsSalesOp();

        if ($data['status']) {
            $_SESSION['messageManagement']['status'] = TRUE;
            $_SESSION['messageManagement']['message'] = "Ürün  Seçilen Müşteriye başarılı bir şekilde satıldı.";
            Header("Location:/sales");
            exit;
        } else {
            $_SESSION['messageManagement']['status'] = FALSE;
            $_SESSION['messageManagement']['message'] = "Ürün seçilen müşteriye satılırken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            Header("Location:{$_SERVER['HTTP_REFERER']}");
            exit;
        }
    }

    //SALES
    public function sales()
    {
        $users_id = $_SESSION['users']['users_id'];
        $data = [];
        $results = [];
        $salesModel = new defaultModel();
        $results['customers'] = $salesModel->customersModel($users_id);
        //echo "<pre>";
        //print_r($results);
        //exit();
        if ($results['customers']) {
            $indis = 0;
            foreach ($results['customers'] as $customers) {
                $sales[$indis] = $salesModel->salesModel($customers['customers_id']);
                if ($sales[$indis]) {
                    $data['sales'][$indis] = $sales[$indis];
                }
                $indis++;
            }
        }
        //echo "<pre>";
        //print_r($data);
        //exit();
        $this->callLayout("frontend", "main", "default", "sales", $data);
    }

}