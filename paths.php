<?php
    /*
require_once __DIR__ . '/../db.php'; 
require_once __DIR__ . '/../paths.php';    
    */
    define('ROOT', __DIR__);
    define('LOGIN_DIR', "/login");
    define('CART_DIR', "/cart");
    define('MENU_DIR', "/menu");

    //Login
    define('LOGIN', LOGIN_DIR . '/login.php');
    define('LOGOUT', LOGIN_DIR . '/logout.php');
    define('VIEWACCOUNT', LOGIN_DIR . '/account.php');
    define('REGISTER', LOGIN_DIR . '/register.php');
    define('CHANGEPASSWORD', LOGIN_DIR . '/changePassword.php');
    define('REMOVEUSER', LOGIN_DIR . '/removeUser.php');
    //Koszyk
    define ('ADDTOCART', CART_DIR. '/addToCart.php');
    define ('VIEWCART', CART_DIR. '/cart.php');
    define ('PAYMENT', CART_DIR. '/payment.php');
    define ('REMOVEFROMCART', CART_DIR. '/removeFromCart.php');
    //Menu
    define ('VIEWMENU', MENU_DIR. '/menu.php');
    define ('NEWMEAL', MENU_DIR. '/newMeal.php');
    define ('DELETEMEAL', MENU_DIR. '/deleteMeal.php');
    define ('MODIFYMENU', MENU_DIR. '/modifyMenu.php');
    define ('RATE', MENU_DIR. '/ocen.php');
?>