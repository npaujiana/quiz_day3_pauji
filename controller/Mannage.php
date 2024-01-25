<?php

require_once "auth.php";
require_once "controller.php";

$auth = new Auth();
$controller = new Controller();
class Mannage
{

    // method untuk mannage home page
    public function mannageHomePage($option)
    {
        $auth = new Auth();
        switch ($option) {
            case 1:
                $auth->adminLogin();
                break;
            case 2:
                $auth->farmerLogin();
                break;
            case 3:
                $auth->buyerLogin();
                break;
            case 4:
                $auth->registrasi();
                break;
            default:
                exit(0);
        }
        showHomePage();
    }

    // Function untuk mannage showAdminMenu
    public function mannageAdminMenu($option_selected)
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

    // // fungsi untuk mannage plants
    public function mannageFarmerMenu($selected_option)
    {
        global $controller;
        switch ($selected_option) {
            case 1:
                showMannagePlants();
                break;
            case 2:
                sellPlants();
                break;
            case 3:
                $controller->plantSold();
                break;
            case 4:
                plantNotBeenSold();
                break;
            case 5:
                historySelling();
                break;
            case 6:
                $controller->totalIncome();
                break;
            case 7:
                showReview();
                break;
            default:
                return;
        }

        showFarmerMenu();
    }

    // // fungsi untuk mengelola mannage plants
    public function mannageShowMannagePlant($selected_option)
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
        }
        showMannagePlants();
    }

    // // fungsi untuk mannage menu pembeli
    public function mannageBuyerMenu(int $option_selected, int $index)
    {
        global $controller, $auth;
        switch ($option_selected) {
            case 1:
                showAvailablePlants($index);
                break;
            case 2:
                showCart();
                break;
            case 3:
                $controller->editUsername($index);
                break;
            case 4:
                $controller->editPassword($index);
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
        }

        showBuyerMenu($index);
    }
}
