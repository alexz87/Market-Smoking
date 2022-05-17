<?php

    require 'DB.php';

    class Products {
        private $pdo;
        private $_db = null;
        
        // Під'єднуємо БД
        public function __construct() {
            $this->_db = DB::getInstance();
        }

        // Функція для виведення товару на сайті
        public function setItemsMenu($session) {

            $items = explode(',', $session);
            $numArr = [1, 2, 3];
            $id = '';
            for ($i = 0; $i < count($numArr); $i++) {
                $id .= $numArr[$i] . 1 . ',';
            }
            $id = rtrim($id, ',');
            
            $sql = "SELECT * FROM `products` WHERE `id` IN ($id)";
            $query = $this->_db->prepare($sql);
            $query->execute();
            $products = $query->fetchAll(PDO::FETCH_ASSOC);
                        
            $html = '';
            $i = 0;
            while ($i < count($products)) {
                $div_sale = '';
                $price_red = '';
                $price_through = '';
                $done = '';
                $adding = 'Добавить';
                $option = 'Выбрать вкус';
                $sale = $products[$i]['price'] - $products[$i]['sale'];
                if ($products[$i]['sale'] > 0) {
                    $div_sale = '<div class="sale flex"><span>Sale</span></div>';
                    $price_red = 'red';
                    $price_through = 'through';
                }
                
                for ($d = 0; $d < count($items); $d++) {
                    if ($products[$i]['id'] == $items[$d]) {
                        $done = '-done';
                        $adding = 'Добавлено';
                        // $option = $products[$i]['optional'];
                    }
                }
                $html .= '<li>
                            <div class="border flex" id="item-'.$products[$i]['id'].'">'
                                .$div_sale.
                                '<div class="main-img" style="background-image: url(images/'.$products[$i]['img'].');"></div>
                                <h3>'.$products[$i]['title'].'</h3>
                                <div class="price '.$price_red.'">'.$sale.' грн.</div>
                                <div class="old-price '.$price_through.'">'.$products[$i]['price'].' грн.</div>
                                <select class="turnintodropdown tastes" id="sel'.$products[$i]['id'].'">
                                    <option>'.$option.'</option>
                                    <option>Банан</option>
                                    <option>Клубника</option>
                                    <option>Вишня</option>
                                    <option>Малина</option>
                                </select>
                                <a href="#" class="black-btn flex open-cart" onclick="addItem('.$products[$i]['id'].'); return false;">
                                    <span>'.$adding.'</span>
                                    <img class="status" src="images/cart'.$done.'.png">
                                </a>
                            </div>
                        </li>';
                $i++;
            }

            return $html;
        }

        // Функція для виведення товару у кошику
        public function setItemsCart($session) {

            $sql = "SELECT * FROM `products` WHERE `id` IN ($session)";
            $query = $this->_db->prepare($sql);
            $query->execute();
            $products = $query->fetchAll(PDO::FETCH_ASSOC);

            $items = explode(",", $session);
            $fieldCount = array_count_values($items);
          
            $html = '';
            if ($items[0] == '') {
                $html = '<div class="content-empty flex">
                                <img class="empty-ico" src="images/cart-b.svg">
                                <p>Ваша корзина на данный <br>момент пустая</p>
                                <a href="#goods" class="black-btn navigate" id="view-items"><span>Смотреть товар</span></a>
                            </div>';
            } else {
                $item = '';
                $price = 0;
                $i = 0;
                while ($i < count($products)) {
                    $sale = $products[$i]['price'] - $products[$i]['sale'];
                    $thisPrice = $sale * $fieldCount[$products[$i]['id']];
                    $price += $thisPrice;
                    $item .= '<div class="item flex" id="item-'.$products[$i]['id'].'">
                                <div class="left flex">
                                    <img src="images/'.$products[$i]['img'].'">
                                    <a href="#" class="delete" onclick="deleteItemAll('.$products[$i]['id'].')">Удалить</a>
                                </div>
                                <div class="right">
                                    <h3>'.$products[$i]['title'].'</h3>
                                    <select class="turnintodropdown tastes" id="getSel'.$products[$i]['id'].'">
                                        <option>'.$products[$i]['optional'].'</option>
                                        <option>Банан</option>
                                        <option>Клубника</option>
                                        <option>Вишня</option>
                                        <option>Малина</option>
                                    </select>
                                    <div class="bottom flex">
                                        <div class="counter flex">
                                            <button type="button" class="but counterBut dec" onclick="deleteItem('.$products[$i]['id'].')"></button>
                                            <input type="text" class="field fieldCount" value="'.$fieldCount[$products[$i]['id']].'" data-min="1" data-max="99">
                                            <button type="button" class="but counterBut inc" onclick="addDoubleItem('.$products[$i]['id'].')"></button>
                                        </div>
                                        <div class="price"><span class="cartPrice">'.$thisPrice.'</span> грн.</div>
                                    </div>
                                </div>
                            </div>';
                    $i++;
                }
                $more = 1500 - $price;
                if ($more > 0) {
                    $more = $more;
                } else {
                    $more = 0;
                }
                $html = '<div class="content-full">
                            <div class="items" id="items">'.$item.
                            '</div>
                            <div class="total">
                                <div class="ttop flex">
                                    <h3>Итого:</h3>
                                    <div class="price"><span id="price-value">'.$price.'</span> грн.</div>
                                </div>
                                <p>Добавьте ещё товаров на сумму <br><span id="add-more">'.$more.'</span> гривен и получите
                                    бесплатную доставку!</p>
                                <a href="checkout.html" class="black-btn flex">
                                    <span>Оформить заказ</span>
                                    <img class="status" src="images/arrow.png">
                                </a>
                            </div>
                        </div>';
            }
            
            return $html;
        }

        // Функція для виведення товару на сторінці оформлення замовлення
        public function checkout($session) {

            $sql = "SELECT * FROM `products` WHERE `id` IN ($session)";
            $query = $this->_db->prepare($sql);
            $query->execute();
            $products = $query->fetchAll(PDO::FETCH_ASSOC);

            $items = explode(",", $session);
            $fieldCount = array_count_values($items);
          
            $data = [];
            for ($i = 0; $i < count($products); $i++) {
                $sale = $products[$i]['price'] - $products[$i]['sale'];
                $thisPrice = $sale * $fieldCount[$products[$i]['id']];
                $data['html'] .= '<div class="item flex">
                        <div class="left flex">
                            <img src="images/'.$products[$i]['img'].'">
                        </div>
                        <div class="right">
                            <h3>'.$products[$i]['title'].'</h3>
                            <div class="taste-count">'.$products[$i]['optional'].', '.$fieldCount[$products[$i]['id']].' шт.</div>
                            <div class="price">'.$thisPrice.' грн.</div>
                        </div>
                    </div>';
                $price += $thisPrice;
            }
            $data['price'] = $price;

            return $data;
        }

        // Отримання даних про товар з замовлення
        public function getProducts($session) {

            $items = explode(",", $session);
            $fieldCount = array_count_values($items);

            $sql = "SELECT * FROM `products` WHERE `id` IN ($session)";
            $query = $this->_db->prepare($sql);
            $query->execute();
            $products = $query->fetchAll(PDO::FETCH_ASSOC);

            $data = '';
            for ($i = 0; $i < count($products); $i++) {
                $sale = $products[$i]['price'] - $products[$i]['sale'];
                $thisPrice = $sale * $fieldCount[$products[$i]['id']];
                $data .= 
                    $products[$i]['title'] . 
                    ' со вкусом ' . $products[$i]['optional'] . 
                    ', количество: ' . $fieldCount[$products[$i]['id']] . 
                    ' шт. <br>Стоимость: ' . $thisPrice . 
                    ' грн.<br><br>';
                $price += $thisPrice;
            }
            $data .= 'Итого: '. $price;

            return $data;
        }
    }