<?php 

    require '../models/Products.php';
    require '../models/Session.php';

    $products = new Products();
    $cart = new Session();

    if (isset($_POST['delete'])) {
        $cart->deleteSession();
    }
    if (isset($_POST['id'])) {
        $cart->addToCart($_POST['id']);
    }
    if (isset($_POST['did'])) {
        $cart->deleteFromCart($_POST['did']);
    }
    if (isset($_POST['dia'])) {
        $cart->deleteFromCartIdAll($_POST['dia']);
    }

    $id = $cart->getSession();
    $items = explode(',', $id);

    $data = [
        "countItems" => $cart->countItems(),
        "cart" => $products->setItemsCart($id),
        "menu" => $products->setItemsMenu($id),
        "checkout" => $products->checkout($id)['html'],
        "price" => $products->checkout($id)['price']
    ];

    // Кодуємо та надсилаємо дані до ajax
    echo json_encode($data);

    