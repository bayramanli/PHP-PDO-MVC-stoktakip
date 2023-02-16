<?php

class defaultModel extends mainModel
{
    public function usersInsertModel()
    {
        $users_firstname = trim(strip_tags($_POST['users_firstname']));
        $users_lastname = trim(strip_tags($_POST['users_lastname']));
        $email = trim(strip_tags($_POST['users_email']));
        $password = trim(strip_tags(md5($_POST['users_password'])));

        if (empty($users_firstname) || empty($users_lastname) || empty($email) || empty($password)) {
            return ['status' => FALSE, 'message' => "Lütfen bütün alanları doldurunuz."];
        } else {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                //benzer email adresi var mı
                $sql = $this->db->wread("users", "users_email", $email);
                $count = $sql->rowCount();
                if ($count) {
                    return ['status' => FALSE, 'message' => "Girdiğiniz email adresi başka hesaba tanımlıdır. Lütfen başka bir email adresi giriniz."];
                } else {
                    $values = [
                        "users_username" => $email,
                        "users_firstname" => $users_firstname,
                        "users_lastname" => $users_lastname,
                        "users_email" => $email,
                        "users_password" => $password
                    ];
                    //echo "<pre>";
                    //print_r($values);
                    //exit();
                    $sql = $this->db->insert("users", $values);

                    if ($sql['status']) {
                        return ['status' => TRUE, 'message' => "Kaydınız başarılı bir şekilde yapıldı. Giriş formundaki bilgileri doldurarak giriş yapabilirsiniz."];
                    } else {
                        return ['status' => FALSE, 'message' => "Kayıt Başarısız. Lütfen daha sonra tekrar deneyiniz."];
                    }
                }
            } else {
                return ['status' => FALSE, 'message' => "Lütfen email adresinizi uygun formatta giriniz. ( Örnek: example@exapmle.com )"];
            }
        }
    }

    //LOGIN
    public function loginControlModel()
    {
        //echo "<pre>";
        //print_r($_POST);
        //exit();
        $result = $this->db->usersLogin(htmlspecialchars($_POST['users_email']), htmlspecialchars($_POST['users_password']));

        return $result;
    }

    //LOGOUT
    public function logoutModel()
    {
        $this->usersLogout();
    }

    //customers
    public function customersModel($users_id)
    {
        $sql = $this->db->wread("customers", "users_id", $users_id);
        $indis = 0;
        while ($client = $sql->fetch(PDO::FETCH_ASSOC)) {
            $customers[$indis] = $client;
            $indis++;
        }
        return @$customers;
    }

    public function customersInsertOp()
    {
        //echo "<pre>";
        //print_r($_POST);
        //exit();
        $sql = $this->db->insert("customers", $_POST,
            [
                "form_name" => "insert"
            ]
        );
        return $sql;
    }

    public function customersUpdate($id)
    {
        $sql = $this->db->wread("customers", "customers_id", $id);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function customersUpdateOp()
    {

        $sql = $this->db->update("customers", $_POST, [
                "form_name" => "update",
                "columns" => "customers_id"

            ]
        );

        return $sql;
    }

    public function customersDelete($id)
    {
        $sql = $this->db->delete("customers", "customers_id", $id);
        return $sql;
    }

   //PRODUCTS
   public function productsModel()
   {
       $sql = $this->db->read("products");
       $indis = 0;
       while ($product = $sql->fetch(PDO::FETCH_ASSOC)) {
           $products[$indis] = $product;
           $indis++;
       }
       return @$products;
   }

   public function productsInsertOp()
   {
       $sql = $this->db->insert("products", $_POST,
           [
               "form_name" => "insert"
           ]
       );
       return $sql;
   }

   public function productsUpdate($products_id)
   {
       $sql = $this->db->wread("products", "products_id", $products_id);
       return $sql->fetch(PDO::FETCH_ASSOC);
   }

   public function productsUpdateOp()
   {

       $sql = $this->db->update("products", $_POST, [
               "form_name" => "update",
               "columns" => "products_id"

           ]
       );

       return $sql;
   }

   public function productsDelete($products_id)
   {
       $sql = $this->db->delete("products", "products_id", $products_id);
       return $sql;
   }

   //SALES
    public function productsInfo($products_id)
    {
        $sql = $this->db->wread("products", "products_id", $products_id);
        return $sql->fetch(PDO::FETCH_ASSOC);
    }

    public function productsSalesOp()
    {
        $products_id = trim(strip_tags($_POST['products_id']));
        $customers_id = trim(strip_tags($_POST['customers_id']));
        $sales_count = trim(strip_tags($_POST['sales_count']));

        $values = [
            "products_id" => $products_id,
            "customers_id" => $customers_id,
            "sales_count" => $sales_count,
            "sales_status" => 1
        ];

        $sql = $this->db->insert("sales", $values);

        return $sql;
    }

    public function salesModel($customers_id)
    {
        $sql = $this->db->wread("sales", "customers_id", $customers_id);
        $indis = 0;
        while ($sale = $sql->fetch(PDO::FETCH_ASSOC)) {
            $sales[$indis] = $sale;
            $sales[$indis]['products'] = $this->productsInfo($sale['products_id']);
            $sales[$indis]['customers'] = $this->customersUpdate($customers_id);
            $indis++;
        }
        return @$sales;
    }
}