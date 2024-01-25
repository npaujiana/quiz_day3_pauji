<?php

class Controller
{

    // Method kondisi untuk menghapus user
    public function conditionDeletedUser(User &$user, string &$name_delected)
    {
        $index = 0;
        $isFind = false;

        // Perulangan melalui vektor user untuk menemukan indeks user yang sesuai dengan nama yang dihapus
        foreach ($user as $user) {
            if ($user->getName() == $name_delected) {
                $isFind = true;
            }
            $index++;
        }

        // Memeriksa apakah user dengan nama yang dihapus ditemukan atau tidak
        if (!$isFind) {
            echo "Name Not Found!!" . PHP_EOL;
            return;
        }

        // Menghapus user dari vektor berdasarkan indeks yang ditemukan
        array_splice($user, $index, 1);

        echo $name_delected . " Was Succes Deleted!!" . PHP_EOL;
    }

    // // Fungsi untuk menampilkan tanaman yang sudah terjual
    public function plantSold()
    {
        global $buyer;
        if (count($buyer->getHistory()) <= 0) {
            echo "Nothing Plant Sold!!" . PHP_EOL;
            return;
        }
        $number = 1;
        foreach ($buyer->getHistory() as $notSell) {
            echo $number . $notSell->getNamePlant() . $notSell->getQuantity() . PHP_EOL;
            $number++;
        }
    }

    // // fungsi untuk menampilkan pendapatan petani
    public function totalIncome()
    {
        global $buyer;
        $total_income = 0;
        for ($i = 0; $i < count($buyer->getHistory()); $i++) {
            $total_income += $buyer->getHistory()[$i]->getTotalPrice();
        }

        echo "Total Income: " . $total_income . PHP_EOL;
    }

    // //fungsi untuk mengedit username
    public function editUsername(int $index)
    {
        global $buyer;
        $new_username = '';
        $username_before = $buyer->getBuyersData()[$index]->getUsername();
        self::editProfile($new_username, "Username Before: ", $username_before, "New Username: ", $username_before, "Username Has Been Change!!");
    }

    // // Fungsi Untuk Mengedit Password Buyer
    public function editPassword(int $index)
    {
        global $buyer;
        $new_password = '';
        $password_before = $buyer->getBuyersData()[$index]->getPassword();
        self::editProfile($new_password, "Password Before: ", $password_before, "New Password: ", $password_before, "Password Has Been Change!");
    }

    // // Function Function yang bisa digunakan secara umum dalam program
    public function limitChooseSomething(int &$option_selected, int $min, int $max, string $text_input)
    {
        while (true) {
            $option_selected = readline($text_input);

            if ($option_selected >= $min && $option_selected <= $max) {
                break;
            }
        }
    }

    // // function untuk memeinta inputan pada user edit username atau password
    public function editProfile(string $new_password, string $text_before, string $password, string $text_input, string $password_want_to_change, string $text_alert)
    {
        echo $text_before . $password . PHP_EOL;
        $new_password = readline($text_input);

        $password_want_to_change = $new_password;

        echo $text_alert . PHP_EOL;
    }
}
