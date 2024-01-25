<?php

require_once "controller.php";
$controller = new Controller();
class Auth
{

    public $wrong = 0;
    // // function untuk registrasi
    public function registrasi()
    {
        global $controller;
        global $farmer, $buyer;
        $new_name = readline("New Name: ");

        $new_username = readline("New Username: ");

        // cek agar username tidak ada yang sama
        $is_available = self::checkUsername($new_username);
        if ($is_available) {
            self::registrasi();
        }
        $farmer->setUsername($new_username);
        $buyer->setUsername($new_username);

        $new_password = readline("New Password: ");

        echo "== select option ==" . PHP_EOL;
        echo "1. Farmer" . PHP_EOL;
        echo "2. Buyer" . PHP_EOL;
        $select_option = 0;
        $controller->limitChooseSomething($select_option, 1, 2, "Select Option: ");

        if ($select_option == 1) {
            // pemanggilan constructor untuk menyimpan data ke vector user di class farmer
            $user = new User();
            $user->setUsername($new_username);
            $user->setPassword($new_password);
            $user->setUserType("Farmer");
            $user->setName($new_name);
            $farmer->setFarmerData($user);
        } else {
            // pemanggilan constructor untuk menyimpan data ke vector user di class buyer
            $user = new User();
            $user->setUsername($new_username);
            $user->setPassword($new_password);
            $user->setUserType("Buyer");
            $user->setName($new_name);
            $buyer->setBuyersData($user);
        }

        echo "Registrasi Succesfully Thank you " . $new_name . PHP_EOL;
        showHomePage();

    }

// Fungsi untuk login admin
    public function adminLogin()
    {
        $dataLogin = [
            "username" => "admin",
            "password" => "123",
        ];
        if (!$dataLogin) {
            echo "Open File Failed!!" . PHP_EOL;
            return;
        }

        $username = '';
        $password = '';

        // Batasi percobaan login hingga 3 kali
        while ($this->wrong < 3) {
            $username = readline("Input Username: ");
            $password = readline("Input Password: ");

            $checkUsername = false;
            $checkPassword = false;

            if ($username == $dataLogin["username"] && $password == $dataLogin["password"]) {
                $checkUsername = true;
                $checkPassword = true;
            }

            if ($checkUsername && $checkPassword) {
                echo "Login success!!" . PHP_EOL;
                showAdminMenu();
                return;
            } else {
                $this->wrong++;
                echo "Username or Password is Wrong!!" . PHP_EOL;
                echo "Remaining attempts: " . 3 - $this->wrong . PHP_EOL;
            }
        }

        // Jika sudah 3 kali percobaan, beri pesan dan hentikan program
        echo "You've made a mistake 3 times. Try again tomorrow." . PHP_EOL;
        $this->wrong = 0;
        return;
    }

    // //Fungsi untuk login petani
    public function farmerLogin()
    {
        global $farmer, $buyer, $wrong;
        $username = readline("Input Username: ");

        $password = readline("Password: ");

        $isFind = false;
        for ($i = 0; $i < count($farmer->getFarmersData()); $i++) {
            if ($password == $farmer->getFarmersData()[$i]->getPassword() && $username == $farmer->getFarmersData()[$i]->getUsername()) {
                $isFind = true;
                break;
            }
        }
        $wrong++;
        if ($wrong > 3) {
            echo "You've made a mistake 3 times, try again tomorrow" . PHP_EOL;
            $wrong = 0;
            showHomePage();
        }
        if ($isFind == false) {
            echo "Username or Password is wrong" . PHP_EOL;
            self::farmerLogin();
        } else {
            echo "Login Succes!!" . PHP_EOL;
            showFarmerMenu();
            return;
        }
    }

    // // Fungsi untuk login pembeli
    public function buyerLogin()
    {
        global $farmer, $buyer, $wrong;
        $username = readline("Input Username: ");
        $password = readline("Password: ");

        $isFind = false;
        $index = 0;
        for ($i = 0; $i < count($buyer->getBuyersData()); $i++) {
            if ($password == $buyer->getBuyersData()[$i]->getPassword() && $username == $buyer->getBuyersData()[$i]->getUsername()) {
                $index = $i;
                $isFind = true;
                break;
            }
        }

        $wrong++;
        if ($wrong > 3) {
            echo "You've made a mistake 3 times, try again tomorrow" . PHP_EOL;
            $wrong = 0;
            showHomePage();
        }

        if ($isFind == false) {
            echo "Username or Password is Wrong" . PHP_EOL;
            self::buyerLogin();
        } else {
            echo "Login Success!!" . PHP_EOL;
            showBuyerMenu($index);
        }
    }

    // // function function tambahan
// // function meminta inputan string
    public function checkUsername(string $username)
    {
        global $farmer, $buyer;
        $check = false;
        foreach ($farmer->getUsername() as $data) {
            if ($data == $username) {
                echo "The username already exists, do not use that username" . PHP_EOL;
                $check = true;
            }
        }

        foreach ($buyer->getBuyersData() as $data) {
            if ($data == $username) {
                echo "The username already exists, do not use that username" . PHP_EOL;
                $check = true;
            }
        }

        return $check;
    }
}
