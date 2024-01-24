<?php
require_once "buyer.php";

$farmer = new Farmer();
$buyer = new Buyer();

// Function Untuk menampilkan halaman utama
function showHomePage()
{
    echo "========== LOGIN PAGE ==========" . PHP_EOL;
    echo "| 1. Admin Login               |" . PHP_EOL;
    echo "| 2. Farmer Login              |" . PHP_EOL;
    echo "| 3. buyer login               |" . PHP_EOL;
    echo "| 4. Registrasi                |" . PHP_EOL;
    echo "| 5. Exit                      |" . PHP_EOL;
    echo "================================" . PHP_EOL;

    $selected_option = readline("Select option [1 - 5]: ");
    // limitChooseSomething($selected_option, 1, 5, "Select option [1 - 5]: ");
    mannageHomePage($selected_option);
    return;
}

// function untuk mannage home page
function mannageHomePage($option)
{
    switch ($option) {
        case 1:
            adminLogin();
            break;
        case 2:
            farmerLogin();
            break;
        case 3:
            buyerLogin();
            break;
        case 4:
            registrasi();
            break;
        default:
            exit(0);
            break;
    }
    showHomePage();
}

$wrong = 0;
// Fungsi untuk login admin
function adminLogin()
{
    global $wrong;
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
    while ($wrong < 3) {
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
            $wrong++;
            echo "Username or Password is Wrong!!" . PHP_EOL;
            echo "Remaining attempts: " . 3 - $wrong . PHP_EOL;
        }
    }

    // Jika sudah 3 kali percobaan, beri pesan dan hentikan program
    echo "You've made a mistake 3 times. Try again tomorrow." . PHP_EOL;
    $wrong = 0;
    return;
}

// // fungsi menampilkan Menu petani
function showAdminMenu()
{
    echo "========== ADMIN PAGE ==========" . PHP_EOL;
    echo "| 1. Add User                  |" . PHP_EOL;
    echo "| 2. Delete User               |" . PHP_EOL;
    echo "| 3. Delete Message            |" . PHP_EOL;
    echo "| 4. Back To Login Page        |" . PHP_EOL;
    echo "===============================" . PHP_EOL;
    $select_option = readline("Select Option: ");
    mannageAdminMenu($select_option);
    return;
}

// // Function untuk mannage showAdminMenu
function mannageAdminMenu($option_selected)
{
    switch ($option_selected) {
        case 1:
            addUser();
            break;
        case 2:
            deleteUser();
            break;
        case 3:
            deleteMessage();
            break;
        default:
            return;
    }
    showAdminMenu();
}

// // function untuk menambah user
function addUser()
{
    global $farmer, $buyer;

    // meminta nama user pada admin
    $new_name_user = readline("New Name: ");

    // boolean untuk menjadi acuan pengecekana username ada atau tidak dalam data
    $is_available_username = false;

    // penggunaan do while untuk mengulang permintaan username jika username ada yang sama
    do {
        // meminta username pada admin
        $new_user_name = readline("Username for $new_name_user");

        // variabel ini diisi function dimana functionnya menghasilkan true atau false untuk find username
        $is_available_username = checkUsername($new_user_name);
        if ($is_available_username == true) {
            echo "Username dont Same with other username!!" . PHP_EOL;
        }

        // ini akan terus dilakukan jika is_available_username berisi true dan akan berhenti jika false
    } while ($is_available_username == true);

    // Set username untuk objek Farmer dan Buyer
    $farmer->setUsername($new_user_name);
    $buyer->setUsername($new_user_name);

    // Meminta password untuk user baru
    $new_user_password = readline("Password for $new_name_user : ");

    // meminta pilihan pada admin apa yang akan dibuat farmer or buyer
    echo "== Select Option ==" . PHP_EOL;
    echo "1. Farmer" . PHP_EOL;
    echo "2. Buyer" . PHP_EOL;
    $select_option = readline("Select Option: ");

    // Menentukan tipe User (Farmer/Buyer) berdasarkan pilihan admin
    if ($select_option == 1) {
        $user = new User();
        $user->setUsername($new_user_name);
        $user->setPassword($new_user_password);
        $user->setUserType("Farmer");
        $user->setPassword($new_user_password);
        $farmer->setFarmerData($user);
    } else {
        $user = new User();
        $user->setUsername($new_user_name);
        $user->setPassword($new_user_password);
        $user->setUserType("Buyer");
        $user->setPassword($new_user_password);
        $buyer->setBuyersData($user);
    }

    // Menampilkan pesan sukses setelah data disimpan
    echo $new_name_user . " Succes save to Database " . PHP_EOL;
    return;
}

// // fungsi kondisi untuk menghapus user
function conditionDeletedUser(User $user, string $name_delected)
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

// // Function untuk menghapus user
function deleteUser()
{
    global $farmer, $buyer;
    // meminta pilihan pada admin apa yang akan dihapus farmer or buyer
    echo "== Select Option ==" . PHP_EOL;
    echo "1. Farmer" . PHP_EOL;
    echo "2. Buyer" . PHP_EOL;
    $select_option = readline("Select Option: ");

    $name_delected = readline("Enter the name to be deleted: ");

    if ($select_option == 1) {
        conditionDeletedUser($farmer->getFarmersData(), $name_delected);
        return;
    } else {
        conditionDeletedUser($buyer->getBuyersData(), $name_delected);
        return;
    }
}

// // Function Untuk menghapus message buyer ke farmer
function deleteMessage()
{
    global $farmer;
    if (count($farmer->getReviews()) <= 0) {
        echo "Nothing Review!!" . PHP_EOL;
        return;
    }
    $number = 1;
    foreach ($farmer->getReviews() as $review) {
        echo "---------------------------------" . PHP_EOL;
        echo $number << ". Name: " << $review . getName() . PHP_EOL;
        echo "   Message: " << $review . getMessage() . PHP_EOL;
        echo "   Reply Farmer: " << $review . getReply() . PHP_EOL;
        echo "---------------------------------" . PHP_EOL;
        $number++;
    }

    $select_option = 0;
    limitChooseSomething($select_option, 1, count($farmer->getReviews()), "Choose Message to delete: (Number) ");

    array_splice($farmer->getReviews, $select_option - 1, 1);

    echo "Message Was Delected!!" . PHP_EOL;
    return;
}

// //Fungsi untuk login petani
function farmerLogin()
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
        farmerLogin();
    } else {
        echo "Login Succes!!" . PHP_EOL;
        showFarmerMenu();
        return;
    }
}

// // fungsi untuk menampilkan menu petani
function showFarmerMenu()
{
    echo "========== FARMER PAGE ==========" . PHP_EOL;
    echo "| 1. Mannage Plants             |" . PHP_EOL;
    echo "| 2. Sell Plants                |" . PHP_EOL;
    echo "| 3. Plants Sold                |" . PHP_EOL;
    echo "| 4. Plants Not Been Sold       |" . PHP_EOL;
    echo "| 5. History Selling            |" . PHP_EOL;
    echo "| 6. Total Income               |" . PHP_EOL;
    echo "| 7. Show Review                |" . PHP_EOL;
    echo "| 8. Back To Menu               |" . PHP_EOL;
    echo "=================================" . PHP_EOL;
    $select_option = readline("Select Option: ");
    mannageFarmerMenu($select_option);
    return;
}

// // fungsi untuk mannage plants
function mannageFarmerMenu($selected_option)
{
    switch ($selected_option) {
        case 1:
            showMannagePlants();
            break;
        case 2:
            sellPlants();
            break;
        case 3:
            plantSold();
            break;
        case 4:
            plantNotBeenSold();
            break;
        case 5:
            historySelling();
            break;
        case 6:
            totalIncome();
            break;
        case 7:
            showReview();
            break;
        default:
            return;
            break;
    }

    showFarmerMenu();
}

// // Fungsi untuk maemannage plants
function showMannagePlants()
{
    echo "========== MANNAGE PLANTS ==========" . PHP_EOL;
    echo "| 1. Add Plant                     |" . PHP_EOL;
    echo "| 2. Edit Plant                    |" . PHP_EOL;
    echo "| 3. Delete Plant                  |" . PHP_EOL;
    echo "| 4. Back to Farmer Page           |" . PHP_EOL;
    echo "================================" . PHP_EOL;
    $select_option = readline("Select Option to Mannage Plants: ");
    mannageShowMannagePlant($select_option);

}

// // fungsi untuk mengelola mannage plants
function mannageShowMannagePlant($selected_option)
{
    switch ($selected_option) {
        case 1:
            addPlant();
            break;
        case 2:
            editPlant();
            break;
        case 3:
            deletePlant();
            break;
        default:
            return;
            break;
    }
    showMannagePlants();
}

// // fungsi untuk menambah tanaman
function addPlant()
{

    global $farmer;
    $name_plant = readline("Name Plant: ");

    echo "Example: 10000 ( for 100,000 ) " . PHP_EOL;

    $price_plant = readline("Price per Plant: ");

    echo "Example: 3 for ( 3 KG ) " . PHP_EOL;
    $quantity_plant = readline("Quantity");

    // meminta kategory pada user
    echo "----- Choose Category -----" . PHP_EOL;
    echo "1. Fruit" . PHP_EOL;
    echo "2. Vegetable" . PHP_EOL;

    // membuat variabel int sebagai penampung angka pilihan user, lalu membatasi pilihannya hanya 1 - 2
    $select_category = 0;
    limitChooseSomething($select_category, 1, 2, "Choose Category: ");

    // merubah angka menjadi string dengan if ternary
    $category_plant = ($select_category == 1) ? "Fruit" : "Vegetable";

    // membuat object Plant dan memasukan ssemua data diatas, lalu object itu dimassukan ke dalam vector Plant di farmer
    $plant = new Plant($name_plant, $category_plant, $quantity_plant, $price_plant);
    $farmer->setPlants($plant);
    echo "Add Plants Succes" . PHP_EOL;
    return;
}

// // fungsi untuk mengedit Plant
function editPlant()
{
    global $farmer;
    if (count($farmer->getPlants()) <= 0) {
        echo "Nothing Plants" . PHP_EOL;
        showMannagePlants();
    }

    $number = 1;
    foreach ($farmer->getPlants() as $plant) {
        echo $number . $plant->getName() . $plant->getQuantity() . $plant->getPrice() * $plant->getQuantity() . PHP_EOL;
        $number++;
    }
    $select_option = 0;
    limitChooseSomething($select_option, 1, count($farmer->getPlants()), "select Plant To Edit: (Number) ");

    echo "You will edit " . $farmer->getPlants()[$select_option - 1]->getName() . PHP_EOL;

    $new_name_plant = readline("Name Plants: ");

    echo "Example: 10000 ( for 100,000 ) " . PHP_EOL;
    $new_price_plant = readline("Price per Plant: ");

    echo "Example: 3 for (3 KG) " . PHP_EOL;
    $new_quantity_plant = readline("Quantity: ");

    // meminta kategory pada user
    $select_category = 0;
    $new_category_plant = '';
    chooseCategory($select_category, $new_category_plant);

    if (count($farmer->getPlants()) <= 0) {
        return;
    } else {

    }

    $plant = new Plant($new_name_plant, $new_category_plant, $new_quantity_plant, $new_price_plant);
    $farmer->getPlants()[$select_category - 1] = $plant;

    echo "Edit " . $new_name_plant . " Succesfuly " . PHP_EOL;
    return;

}

// // fungsi untuk menghaus plant
function deletePlant()
{
    global $farmer;
    if (count($farmer->getPlants()) <= 0) {
        echo "Nothing Plants" . PHP_EOL;
        showMannagePlants();
    }

    $number = 1;
    foreach ($farmer . getPlants() as $plant) {
        echo $number . $plant->getName() . $plant->getQuantity() . $plant->getPrice() * $plant->getQuantity() . PHP_EOL;
        $number++;
    }
    $new_name_plant = readline("Name Plants: ");

    $index = 0;
    $isFind = false;
    foreach ($farmer->getPlants() as $plant) {
        if ($plant->getName() == $new_name_plant) {
            $isFind = true;
            break;
        }
        $index++;
    }

    if (!$isFind) {
        echo "Name Not Found!!" . PHP_EOL;
        showMannagePlants();
    }

    $quest_next = readline("are you sure you want to delete " . $new_name_plant . " [y/n]: ");

    while ($quest_next != "n") {
        if ($quest_next == "y") {
            array_splice($farmer->getPlants(), $index, 1);
            echo "Delected Succesfully" . PHP_EOL;
            showMannagePlants();
            break;
        }
    }
    echo "You don't delete it, just go back to managing the plant" . PHP_EOL;
    return;
}

// // fungsi untuk menampilkan plant sesuai kategori di dalam sell  plant
function showPlantInSell($category_plant)
{
    global $farmer;
    $number = 1;
    foreach ($farmer->getPlants() as $plant) {
        if ($plant->getCategory() == $category_plant) {
            echo $number . $plant->getName() . $plant->getQuantity() . $plant->getPrice() . PHP_EOL;
            $number++;
        }
    }
    $name_selected = readline("Selected Vegetable: (Name) ");

    $isFind = false;
    $index = 0;
    foreach ($farmer->getPlants() as $plant) {
        if ($plant->getName() == $name_selected) {
            $isFind = true;
            break;
        }
        $index++;
    }

    if (!$isFind) {
        echo "Name Not Found!!" . PHP_EOL;
        return;
    }

    if ($farmer->getPlants()[$index]->getQuantity() <= 0) {
        return;
    }
    $quantity_sell = 0;
    while (true) {
        $quantity_sell = readline("Quantity $name_selected To Sell: ");

        if ($quantity_sell <= $farmer->getPlants()[$index]->getQuantity()) {
            break;
        }
    }

    $sell = new Sell($name_selected, $category_plant, $quantity_sell, $farmer->getPlants()[$index]->getPrice(), false);

    $farmer->setSells($sell);
    $plant = new Plant($farmer->getPlants()[$index]->getName(), $farmer->getPlants()[$index]->getCategory(), $farmer->getPlants()[$index]->getQuantity() - $quantity_sell, $farmer->getPlants()[$index]->getPrice());

    echo $name_selected . " Ready To Sell " . PHP_EOL;

    return;
}

// // Fungsi untuk menjual Tanaman
function sellPlants()
{
    global $farmer;
    // meminta kategory pada user
    $select_category = 0;
    $category_plant = '';
    chooseCategory($select_category, $category_plant);

    if ($select_category == 1) {
        echo " == Fruit Category == " . PHP_EOL;
        showPlantInSell($category_plant);

    } else {
        echo " == Vegetable Category == " . PHP_EOL;
        showPlantInSell($category_plant);
    }

}

// // Fungsi untuk menampilkan tanaman yang sudah terjual
function plantSold()
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

// // fungsi untuk menampilkan plants di plant not been sold
function showPlants(string $type_plant, string $category)
{
    global $farmer;
    $number = 1;
    foreach ($farmer->getSells() as $sell) {
        if ($sell->getCategory() == $category) {
            echo $number . $sell->getNamePlant() . $sell->getQuantity() . $sell->getPrice() . PHP_EOL;
            $number++;
        }
    }
}

// // Fungsi untuk menampilkan Tanaman Yang belum terjual
function plantNotBeenSold()
{
    global $farmer;
    // meminta kategory pada user
    $select_category = 0;
    $category_plant = '';
    chooseCategory($select_category, $category_plant);

    if ($select_category == 1) {
        showPlants("Fruit", $farmer, $category_plant);
    } else {
        showPlants("Vegetable", $farmer, $category_plant);
    }
}

// // fungsi untuk menampilkan history penjualan petani
function historySelling()
{
    global $buyer;
    if (count($buyer->getHistory()) <= 0) {
        echo "Nothing Plant Sold!!" . PHP_EOL;
        return;
    }

    foreach ($buyer->getHistory() as $history) {
        echo $history->getNameUser() . $history->getNamePlant() . $history->getQuantity() . $history->getTotalPrice() . $history->getTypePayment() . PHP_EOL;
    }
    return;
}

// // fungsi untuk menampilkan pendapatan petani
function totalIncome()
{
    global $buyer;
    $total_income = 0;
    for ($i = 0; $i < count($buyer->getHistory()); $i++) {
        $total_income += $buyer->getHistory()[$i]->getTotalPrice();
    }

    echo "Total Income: " . $total_income . PHP_EOL;
}

function showReview()
{
    global $farmer;
    if (count($farmer->getReviews()) <= 0) {
        echo "Nothing Review!!" . PHP_EOL;
        return;
    }
    $number = 1;
    echo "== List Reviewer ==" . PHP_EOL;
    foreach (farmer . getReviews() as $review) {
        echo $number . $review->getName() . $review->getNamePlant() . $review->getRatting() . PHP_EOL;
        $number++;
    }

    $index = 0;
    while (true) {
        $name_buyer = readline("Choose name to show Message: ");

        $isFind = false;
        foreach ($farmer->getReviews() as $review) {
            if ($name_buyer == $review->getName()) {
                $isFind = true;
                break;
            }
            $index++;
        }

        if ($isFind) {
            break;
        }

        echo "Name Not Found!!" . PHP_EOL;
    }

    foreach ($farmer->getReviews() as $review) {
        if ($name_buyer == $review->getName()) {
            echo "-----------------------------------------" . PHP_EOL;
            echo "Name Buyer: " << $review->getName() . PHP_EOL;
            echo "Plant: " << $review->getNamePlant() . PHP_EOL;
            echo "Message: " << $review->getMessage() . PHP_EOL;
            echo "Rating: " << $review->getRatting() . PHP_EOL;
            echo "-----------------------------------------" . PHP_EOL;
        }
    }

    $do_you_reply = readline("Do you Reply: (y/n) ");

    while (true) {
        if ($do_you_reply == "y") {
            break;
        } else if ($do_you_reply == "n") {
            return;
        }
    }

    $message_reply = readline("Messaage: ");

    // $farmer->getReviews()[$index]->getReply() = $message_reply;

    echo "Message Send Success" . PHP_EOL;

}

// // Fungsi untuk login pembeli
function buyerLogin()
{
    global $farmer, $buyer, $wrong;
    $username = readline("Input Username: ");
    $password = readline("Password: ");

    $isFind = false;
    $index = 0;
    for ($i = 0; $i < count($buyer->getBuyersData()); $i++) {
        if ($password == $buyer . getBuyersData()[i] . getPassword() && $username == $buyer . getBuyersData()[i] . getUsername()) {
            $index = i;
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
        buyerLogin();
    } else {
        echo "Login Succes!!" . PHP_EOL;
        showBuyerMenu($index);
    }
}

// // fungsi menaampilkan menu buyer
function showBuyerMenu(int $index)
{
    echo "========== BUYER PAGE ==========" . PHP_EOL;
    echo "| 1. Show Available Plants     |" . PHP_EOL;
    echo "| 2. Cart                      |" . PHP_EOL;
    echo "| 3. Edit Username             |" . PHP_EOL;
    echo "| 4. Edit Password             |" . PHP_EOL;
    echo "| 5. Checkout                  |" . PHP_EOL;
    echo "| 6. History                   |" . PHP_EOL;
    echo "| 7. Review and Rating Produk  |" . PHP_EOL;
    echo "| 8. Show Reply                |" . PHP_EOL;
    echo "| 9. Back To Login Page        |" . PHP_EOL;
    echo "================================" . PHP_EOL;
    $select_option = 0;
    limitChooseSomething($select_option, 1, 9, "Select Option: ");
    mannageBuyerMenu($select_option, $index);
}

// // fungsi untuk mannage menu pembeli
function mannageBuyerMenu(int $option_selected, int $index)
{
    switch ($option_selected) {
        case 1:
            showAvailablePlants($index);
            break;
        case 2:
            showCart();
            break;
        case 3:
            editUsername($index);
            break;
        case 4:
            editPassword($index);
            break;
        case 5:
            checkout($index);
            break;
        case 6:
            history();
            break;
        case 7:
            reviewProduk();
            break;
        case 8:
            showReply();
            break;
        default:
            return;
            break;
    }

    showBuyerMenu($index);
}

// // fungsi untuk menampilkan cart
function showCart()
{
    global $buyer;
    if (count($buyer->getCart()) <= 0) {
        echo "You haven't put the item in your cart yet" . PHP_EOL;
        return;
    }

    $number = 1;
    echo "---------- Show Cart ----------" . PHP_EOL;
    foreach ($buyer->getCart() as $cart) {
        echo $number . $cart->getName() . $cart->getQuantity() . $cart->getTotalPrice() . PHP_EOL;
        $number++;
    }
}

// // fungsi show sell in available plant
function showSellInAvailableSell(string $category_plant, string $category, int $index)
{
    global $farmer, $buyer;
    $number = 1;
    foreach ($farmer->getSells() as $sell) {
        if ($sell->getCategory() == $category_plant) {
            echo $number . $sell->getNamePlant() . $sell->getPrice() . $sell->getQuantity() . PHP_EOL;
            $number++;
        }
    }
    $name_selected = '';
    $index_plant = -1;
    while (true) {
        $name_selected = readline("Select $category to insert cart: (Name)");

        $index_plant = 0;
        $isFind = false;
        foreach ($farmer->getSells() as $sell) {
            if ($name_selected == $sell->getNamePlant()) {
                $isFind = true;
                break;
            }
            $index_plant++;
        }

        if ($isFind) {
            break;
        }

        echo PHP_EOL . "Nothing Name!!!" . PHP_EOL;
    }

    if ($index_plant == -1) {
        echo "Error: Plant not found!" . PHP_EOL;
        return;
    }

    $quantity_buy = readline("how much do you want to buy?? ");

    if ($quantity_buy > $farmer->getSells()[$index_plant]->getQuantity()) {
        echo "There are only " . $farmer->getSells()[$index_plant]->getQuantity() . " plants available, you cannot order more than that" . PHP_EOL;
        return;
    }

    $selectedSell = $farmer->getSells()[$index_plant];
    $cart = new Cart($selectedSell->getNamePlant(), $quantity_buy, $selectedSell->getPrice() * $quantity_buy);
    $selectedSell->setQuantity($selectedSell->getQuantity() - $quantity_buy);
    $buyer->setCart($cart);
}

// // fungsi untuk menampilkan plants yang dijual
function showAvailablePlants(int $index)
{
    global $farmer, $buyer;
    if (count($farmer . getSells()) <= 0) {
        echo "there are no plants for sale by farmers" . PHP_EOL;
        return;
    }
    // meminta kategory pada user
    $select_category = 0;
    $category_plant = '';
    chooseCategory($select_category, $category_plant);
    if ($select_category == 1) {
        echo "== Fruit Category ==" . PHP_EOL;
        showSellInAvailableSell($category_plant, "Fruit", $index);

    } else {
        echo "== Vegetable Category ==" . PHP_EOL;
        showSellInAvailableSell($category_plant, "Vegetable", $index);
    }
}

// //fungsi untuk mengedit username
function editUsername(int $index)
{
    global $buyer;
    $new_username = '';
    $username_before = $buyer->getBuyersData()[$index]->getUsername();
    editProfile($new_username, "Username Before: ", $username_before, "New Username: ", $username_before, "Username Has Been Change!!");
}

// // Fungsi Untuk Mengedit Password Buyer
function editPassword(int $index)
{
    global $buyer;
    $new_password = '';
    $password_before = $buyer->getBuyersData()[$index]->getPassword();
    editProfile($new_password, "Password Before: ", $password_before, "New Password: ", $password_before, "Password Has Been Change!");
}

// // fungsi checkout
function checkout(int $index)
{
    global $farmer, $buyer;
    if (count($buyer . getCart()) <= 0) {
        echo "Add plants to cart first before checkout" . PHP_EOL;
        return;
    }

    $name = '';
    echo "---------- Show Cart ----------" . PHP_EOL;
    foreach ($buyer->getCart() as $cart) {
        echo "----------------------------------" . PHP_EOL;
        echo "Name: " << $cart . getName() . PHP_EOL;
        echo "Quantity: " << $cart . getQuantity() . PHP_EOL;
        echo "Total Price: " << $cart . getTotalPrice() . PHP_EOL;
        echo "----------------------------------" . PHP_EOL;
        $name = $cart . getName();
    }

    $total_price_buy = 0;
    $total_quantity_buy = 0;
    for ($i = 0; $i < count($buyer->getCart()); $i++) {
        if ($i > 0) {
            for ($j = 1; $j < count($buyer . getCart()); $j++) {
                $total_price_buy = $buyer->getCart()[$i]->getTotalPrice() + $buyer->getCart()[$j]->getTotalPrice();
                $total_quantity_buy = $buyer->getCart()[$i]->getQuantity() + $buyer->getCart()[$j]->getQuantity();
            }
        } else {
            $total_quantity_buy = $buyer->getCart()[$i]->getQuantity();
            $total_price_buy = $buyer->getCart()[$i]->getTotalPrice();
        }
    }

    echo "Bill buying: " . $total_price_buy . PHP_EOL . PHP_EOL;

    echo " ---------- select payment method ---------- " . PHP_EOL;
    echo "1. Cash On Delivery (COD) " . PHP_EOL;
    echo "2. Transfer" . PHP_EOL;
    $select_option = 0;
    limitChooseSomething($select_option, 1, 2, "Choose Payment: ( Number ) ");

    echo "Example: Jl. Boulevard Bintaro Jaya No.6 " . PHP_EOL;
    $street_name = readline("Street Name: ");

    echo "Example: kec, Pondok Aren/ Desa, Ciniru " . PHP_EOL;
    $district_vilages = readline("sub-districts and villages: ");

    echo "Example: Kota Tanggerang Selatan" . PHP_EOL;
    $city = readline("City Name: ");

    if ($select_option == 1) {
        echo "you choose to pay using the Cash on Delivery (COD) method" . PHP_EOL;
        $history = new History($buyer->getBuyersData()[$index]->getName(), $name, $total_quantity_buy, $total_price_buy, "Cash on Delivery (COD)", $street_name + $district_vilages + $city);
        $buyer->setHistory($history);
    } else {
        echo "you choose to pay using the Transfer method" . PHP_EOL;
        $history = new History($buyer->getBuyersData()[$index]->getName(), $name, $total_quantity_buy, $total_price_buy, "Transfer", $street_name+"\n"+$district_vilages+"\n"+$city);
        $buyer->setHistory($history);
    }

    echo "Checkout Succes" . PHP_EOL;
    return;

}

// // Fungsi untuk Menampilkan History
function history()
{
    global $buyer;
    foreach ($buyer->getHistory() as $history) {
        echo $history->getNamePlant . $history->getQuantity() . $history->getTotalPrice() . $history->getTypePayment() . $history->getAddress() . PHP_EOL;
    }
}

// // fungsi untuk review produk
function reviewProduk()
{
    global $buyer, $farmer;
    $number = 1;
    echo " == items that have been purchased == " . PHP_EOL;
    foreach ($buyer->getHistory() as $history) {
        echo $number . $history->getNamePlant() . $history->getQuantity() . $history->getTotalPrice() . $history->getTypePayment() . $history->getAddress() . PHP_EOL;
        $number++;
    }

    $plant_selected = readline("Choose Plant To Review: (Name Plant) ");

    $name_buyer = '';
    $isFind = false;
    foreach ($buyer->getHistory() as $findName) {
        if ($findName->getNamePlant() == $plant_selected) {
            $isFind = true;
            $name_buyer = $findName->getNameUser();
        }
    }

    if (!$isFind) {
        echo "please enter a suitable name!!" . PHP_EOL;
        reviewProduk();
    }

    $message = readline("Message To Farmer: ");

    $rating = 0;
    limitChooseSomething($rating, 1, 5, "Rating Produk: [1-5] ");

    $review = new Review($plant_selected, $name_buyer, $message, $rating);

    $farmer->setReviews($review);

    echo "Message succees sending to Farmer" . PHP_EOL;
}

// // Fungsi untuk melihat pesan
function showReply()
{
    global $farmer;
    if (count($farmer->getReviews()) <= 0) {
        echo "Nothing Reply!!" . PHP_EOL;
        return;
    }
    foreach ($farmer->getReviews() as $review) {
        echo "----------------------------------" . PHP_EOL;
        echo "Name Plant: " << $review->getNamePlant() . PHP_EOL;
        echo "Reply: " << $review->getReply() . PHP_EOL;
        echo "----------------------------------" . PHP_EOL;
    }
}

// // function untuk registrasi
function registrasi()
{
    global $farmer, $buyer;
    $new_name = readline("New Name: ");

    $new_username = readline("New Username: ");

    // cek agar username tidak ada yang sama
    $is_available = checkUsername($new_username);
    if ($is_available) {
        registrasi($farmer, $buyer);
    }
    $farmer->setUsername($new_username);
    $buyer->setUsername($new_username);

    $new_password = readline("New Password");

    echo "== select option ==" . PHP_EOL;
    echo "1. Farmer" . PHP_EOL;
    echo "2. Buyer" . PHP_EOL;
    $select_option = 0;
    limitChooseSomething($select_option, 1, 2, "Select Option: ");

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

// // function function tambahan
// // function meminta inputan string
function checkUsername(string $username)
{
    global $farmer;
    global $buyer;
    $check = false;
    if (count($farmer->getUsername()) == 1) {
        echo "The username already exists, do not use that username" . PHP_EOL;
        $check = true;
    } else if (count($buyer->getUsername()) == 1) {
        echo "The username already exists, do not use that username" . PHP_EOL;
        $check = true;
    }

    return $check;
}

// // Function Function yang bisa digunakan secara umum dalam program
function limitChooseSomething($option_selected, $min, $max, $text_input)
{
    while (true) {
        $option_selected = readline($text_input);

        if ($option_selected >= $min && $option_selected <= $max) {
            break;
        }
    }
}

// // function untuk memeinta inputan pada user edit username atau password
function editProfile(string $new_password, string $text_before, string $password, string $text_input, string $password_want_to_change, string $text_alert)
{
    echo $text_before . $password . PHP_EOL;
    $new_password = readline($text_input);

    $password_want_to_change = $new_password;

    echo $text_alert . PHP_EOL;
}

// // Function Untuk memilih Kategori
function chooseCategory(int $select_category, string $category_plant)
{
    // meminta kategory pada user
    echo "----- Choose Category -----" . PHP_EOL;
    echo "1. Fruit" . PHP_EOL;
    echo "2. Vegetable" . PHP_EOL;

    // membuat variabel int sebagai penampung angka pilihan user, lalu membatasi pilihannya hanya 1 - 2
    limitChooseSomething($select_category, 1, 2, "Choose Category: ");
    // merubah angka menjadi string dengan if ternary
    $category_plant = ($select_category == 1) ? "Fruit" : "Vegetable";
}
