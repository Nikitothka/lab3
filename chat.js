var messages__container = document.getElementById('messages'); // контейнер сообщений

var interval = null; // Интервал подгрузки сообщений

var sendForm = document.getElementById('chat-form'); // Форма отправки

var messageInput = document.getElementById('message-text'); // Инпут для текста сообщения

var chatUrl = new URL(window.location.href);

var chatID = chatUrl.searchParams.get('id');


function send_request(act, login=null, password = null){
    //Переменные, которые будем отправлять
    var var1 = null;
    var var2 = null;

    switch(act){
        default: break;
        case 'auth':
            var1 = login;
            var2 = password;
            break;
        case 'send':
            var1 = messageInput.value;
            break;
                }
    $.post('chat.php',{ //Отправляем переменные
        act: act,
        var1: var1,
        var2: var2,
        id: chatID
    }).done(function (data) {
        //Заносим в контейнер ответ от сервера
        messages__container.innerHTML = data;
        if(act == 'send') {
            //Если нужно было отправить сообщение, очищаем поле ввода
            messageInput.value = '';
        }
    });
}

function update(){
    send_request('load');
}
interval = setInterval(update, 500);

sendForm.onsubmit = function() {
    send_request('send');
    return false;
}