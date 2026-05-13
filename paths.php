<?php
    define('ROOT', __DIR__);
    define('LOGIN_DIR', "/login");
    define('CART_DIR', "/cart");
    define('MENU_DIR', "/menu");
    define('CONTACT_DIR', "/contact");
    define('MODAL_DIR', "/modals");
    define('BASE_URL', '');

    //Main
    define('INDEX', BASE_URL. '/index.php');
    define('BOOK', BASE_URL. '/book.php');

    //Contact
    define('CONTACT', CONTACT_DIR. '/contact.php');
    define('SENDMESSAGE', CONTACT_DIR. '/sendMessage.php');
    //Login
    define('LOGIN', LOGIN_DIR . '/login.php');
    define('LOGOUT', LOGIN_DIR . '/logout.php');
    define('VIEWACCOUNT', LOGIN_DIR . '/account.php');
    define('REGISTER', LOGIN_DIR . '/register.php');
    define('CHANGEPASSWORD', LOGIN_DIR . '/changePassword.php');
    define('REMOVEUSER', LOGIN_DIR . '/removeUser.php');
    define('UPDATEACCOUNT', LOGIN_DIR . '/updateAccount.php');
    //Modale
    define('LOGINMODALS', ROOT.MODAL_DIR . '/login.php');
    define('BOOKMODALS', ROOT.MODAL_DIR . '/book.php');
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