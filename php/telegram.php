<?php

  /* https://api.telegram.org/botXXXXXXXXXXXXXXXXXXXXXXX/getUpdates,
  де, XXXXXXXXXXXXXXXXXXXXXXX - токен вашого бота, отриманий раніше */

  require 'models/Products.php';
  require 'models/Session.php';

  $products = new Products();
  $cart = new Session();

  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $cityNumber = $_POST['city-number'];
  if ($_POST['del'] == 'pickup') {
    $del = $cityNumber;
  } else {
    $del = $_POST['del'];
  }
  $pay = $_POST['pay'];
  $comment = $_POST['comment'];
  $token = "";
  $chat_id = "";
  $arr = array(
    'Получатель: ' => $name,
    'Телефон: ' => $phone,
    'Email: ' => $email,
    'Способ доставки: ' => $del,
    'Способ оплаты: ' => $pay,
    'Комментарий: ' => $comment,
    'Заказ: ' => $products->getProducts($cart->getSession())
  );

  foreach($arr as $key => $value) {
    $txt .= "<b>" . $key . "</b>" . $value . "%0A";
  };

  // Відправляємо повідомлення у Telegram
  $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");

  if ($sendToTelegram) {
    header('Location: ../order.html'); // Переводимо на сторінку вдалого замовлення
    $cart->deleteSession(); // Очищення кошика після вдалого замовлення
  } else {
    header('Location: ../order.html'); // Виводимо помилку
    $cart->deleteSession();
  }
