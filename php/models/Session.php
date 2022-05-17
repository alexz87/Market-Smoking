<?php

    session_start();

    class Session {
        
        private $name = 'cart';

        // Перевіряємо чи є сессія
        public function isSetSession() {
            return isset($_SESSION[$this->name]);
        }

        // Видалення сессії
        public function deleteSession() {
            unset($_SESSION[$this->name]);
        }

        // Видалення дублю окремого товару з сессії
        public function deleteFromCart($itemID) {
            $arr = explode(',', $this->getSession());
            
            foreach($arr as $key => $value){
                if($value == $itemID){
                    $unset  = $key;
                    break;
                }
            }
        
            $val = $arr[$unset];
            unset($arr[$unset]);
            $arr[] = $val; 
        
            $un = count($arr);
            unset($arr[$un]);

            if ((bool) array_filter($arr)) {
                $_SESSION[$this->name] = implode(',', $arr);
            } else {
                $this->deleteSession();
            }
        }

        // Видалення окремого товару з сессії
        public function deleteFromCartIdAll($itemID) {
            $arr = explode(',', $this->getSession());
            
            foreach($arr as $key => $value){
                if($value == $itemID){
                    unset($arr[$key]);
                }
            }
        
            if ((bool) array_filter($arr)) {
                $_SESSION[$this->name] = implode(',', $arr);
            } else {
                $this->deleteSession();
            }
        }

        // Отримання сессії
        public function getSession() {
            return $_SESSION[$this->name];
        }

        // Додавання товару з сессії
        public function addToCart($itemID) {
            if (!$this->isSetSession()) {
                $_SESSION[$this->name] = $itemID;
            } else {
                $_SESSION[$this->name] = $_SESSION[$this->name] . ',' . $itemID;
            }
        }

        // Підрахунок товарів у сессії
        public function countItems() {
            if (!$this->isSetSession()) {
                return 0;
            } else {
                $items = explode(',', $_SESSION[$this->name]);
                return count($items);
            }
        }
    }