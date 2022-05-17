function countItems(data) {
    for (var id in data) {
        if (id == 'countItems') {
            $('#coui').html(data[id]);
        }
    }
}

function showCart(data) {
    for (var id in data) {
        if (id == 'cart') {
            $('#show_items').html(data[id]);
        }
    }
}

function showMenu(data) {
    for (var id in data) {
        if (id == 'menu') {
            $('ul#menu').html(data[id]);
        }
    }
}

function showCheckout(data) {
    for (var id in data) {
        if (id == 'checkout') {
            $('#checkout').html(data[id]);
        }
    }
}

function showPrice(data) {
    for (var id in data) {
        if (id == 'price') {
            $('.total>.price').html(data[id] + ' грн.');
        }
    }
}

/**
 * 
 *  ----- Додавання товару у кошик та перше його відображення -----
 * 
 */
function addItem(id) {
    let val = $('#sel' + id).val();
    if (val != 'Выбрать вкус') {
        $('ul>li>#item-' + id + '>a>img').attr('src', 'images/cart-done.png');
        $('ul>li>#item-' + id + '>a>span').text('Добавлено');
        $(".cart-block").show();
        $("body").css({ 'overflow-y': 'hidden' });
        if (val == 'Банан') {
            id = (id - 1) + 1;
        } else if (val == 'Клубника') {
            id = (id - 1) + 2;
        }  else if (val == 'Вишня') {
            id = (id - 1) + 3;
        }  else if (val == 'Малина') {
            id = (id - 1) + 4;
        }
        $.ajax({
            url: 'php/controllers/Home.php',
            type: 'POST',
            data: {"id": id},
            cache: false,
            dataType: 'html',
            success:function(data) {
                data = JSON.parse(data);
                countItems(data);
                showCart(data);
            },
            error: function() {
                alert('error');
            }
        });
    }
}

function addDoubleItem(id) {
    let val = $('#getSel' + id).val();
    if (val == 'Банан') {
        id = (id - 1) + 1;
    }
    if (val == 'Клубника') {
        id = (id - 1) + 2;
    }
    if (val == 'Вишня') {
        id = (id - 1) + 3;
    }
    if (val == 'Малина') {
        id = (id - 1) + 4;
    }
    $.ajax({
        url: 'php/controllers/Home.php',
        type: 'POST',
        data: {"id": id},
        cache: false,
        dataType: 'html',
        success:function(data) {
            data = JSON.parse(data);
            countItems(data);
            showCart(data);
        },
        error: function() {
            alert('error');
        }
    });
}




/**
 * 
 *  ----- Видалення товару з кошика -----
 * 
 */
function deleteItem(did) {
    // $('ul>li>#item-' + did + '>a>img').attr('src', 'images/cart.png');
    // $('ul>li>#item-' + did + '>a>span').text('Добавить');
    $.ajax({
        url: 'php/controllers/Home.php',
        type: 'POST',
        data: {"did": did},
        cache: false,
        dataType: 'html',
        success:function(data) {
            data = JSON.parse(data);
            countItems(data);
            showCart(data);
        },
        error: function() {
            alert('error');
        }
    });
}

function deleteItemAll(dia) {
    // $('ul>li>#item-' + did + '>a>img').attr('src', 'images/cart.png');
    // $('ul>li>#item-' + did + '>a>span').text('Добавить');
    $.ajax({
        url: 'php/controllers/Home.php',
        type: 'POST',
        data: {"dia": dia},
        cache: false,
        dataType: 'html',
        success:function(data) {
            data = JSON.parse(data);
            countItems(data);
            showCart(data);
        },
        error: function() {
            alert('error');
        }
    });
}



/* 
*
* ----- Кількість товарів у кошику (у шапці) -----
*
*/
setInterval( () => {
    $.ajax({
        url: 'php/controllers/Home.php',
        type: 'POST',
        data: {},
        cache: false,
        dataType: 'html',
        success:function(data) {
            data = JSON.parse(data);
            countItems(data);
        }
    });
    
}, 500);


/*
*
* ----- Виведення даних отриманих з БД та php -----
*
*/ 
$(document).ready( () => {
    $.ajax({
        url: 'php/controllers/Home.php',
        type: 'POST',
        data: {},
        cache: false,
        dataType: 'html',
        success:function(data) {
            data = JSON.parse(data);
            showMenu(data);
            showCart(data);
            showCheckout(data);
            showPrice(data);
        }
    });
})


/*
*
* ----- Очищення кошика -----
*
*/
// $('#form_checkout').click( () => {
//     $.ajax({
//         url: 'php/controllers/Home.php',
//         type: 'POST',
//         data: {'delete': 'delete'},
//         cache: false,
//         dataType: 'html',
//         success:function(data) {
//             // code
//         }
//     });
// })