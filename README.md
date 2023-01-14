# Использование технологии AJAX в разработке ленты новостей
## Текст задания
### Цель работы
Разработать и реализовать анонимный чат с возможностью создания каналов. В интерфейсе отображается список каналов, пользователь может либо подключиться к существующему каналу, либо создать новый. Сообщения доставляются пользователю без обновления страницы. Дополнительно реализовать разделение каналов на общие и приватные, а также удаление старых сообщений и каналов.
## Ход работы
- Пользовательский интерфейс
- Пользовательские сценарии работы
- API сервера и хореография
- Структура базы данных
- Алгоритмы
## 1. [Пользовательский интерфейс](https://www.figma.com/file/JZ8IkvesVxhYVCMjVP04I3/Web-Chat?node-id=0%3A1&t=hNqefdqpdW0b7VQe-1)

## 2. Пользовательские сценарии работы

Пользователь попадает на страницу *index.php*. Регистрируется или заходит под уже зарегистрированным именем. Если данные введены корректно, осуществляется подгрузка всей логики чата из файла *chat.php*. Есть возможность создать новый канал (приватный или публичный) или присоединиться к уже существующему чату, где можно отправлять сообщения. Также можно выйти со страницы *index.php* c помощью кнопки *Выход*, при нажании на которую пользователь переходит на страницу *index.php* с регистрацией и входом.

## 3. API сервера и хореография

[Создание нового чата](https://imgur.com/a/YtyftN1)

[Авторизация](https://imgur.com/a/WY72i9b)

## 4. Структура БД

*chats*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT | - | - | id канала |
| **chatname** | VARCHAR | 40 | - | имя чата |
| **type** | VARCHAR | 40 | - | тип чата |
| **login** | VARCHAR | 40 | - | имя того, кто создал чат |
| **messtime** | TEXT | - | - | время последнего сообщения |

*messages*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT | - | - | id сообщения |
| **chatid** | INT | - | - | id чата |
| **text** | TEXT | - | - | текст сообщения |
| **login** | VARCHAR | 40 | - | имя пользователя |
| **dtime** | TEXT | - | - | время сообщения |

*permissions*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT | - | - | id сообщения |
| **chat_id** | VARCHAR | 40 | - | id чата |
| **login** | VARCHAR | 40 | - | имя пользователя |

*users*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT | - | - | id пользователя |
| **login** | VARCHAR | 40 | - | имя пользователя |

## 5. Алгоритмы
[Создание нового чата](https://imgur.com/a/NtRkMxa)
[Приватный чат](https://imgur.com/a/sJEAJX9)
## 6. HTTP запросы/ответы
### Начальная страница
<br>GET /chat_src/index.php HTTP/1.1
<br>Host: localhost
<br>Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
<br>sec-ch-ua: "Not_A Brand";v="99", "Google Chrome";v="109", "Chromium";v="109"
<br>sec-ch-ua-mobile: ?0
<br>sec-ch-ua-platform: "Windows"
<br>Upgrade-Insecure-Requests: 1
<br>User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36

<br>HTTP/1.1 200 OK
<br>Cache-Control: no-store, no-cache, must-revalidate
<br>Connection: Keep-Alive
<br>Content-Length: 1958
<br>Content-Type: text/html; charset=UTF-8
<br>Date: Fri, 13 Jan 2023 12:47:38 GMT
<br>Expires: Thu, 19 Nov 1981 08:52:00 GMT
<br>Keep-Alive: timeout=5, max=97
<br>Pragma: no-cache
<br>Server: Apache/2.4.54 (Win64) PHP/8.1.10
<br>X-Powered-By: PHP/8.1.10

### Проверка логина
<br>POST /chat_src/login.php HTTP/1.1
<br>Host: localhost
<br>Accept: */*
<br>Content-Type: application/x-www-form-urlencoded
<br>sec-ch-ua: "Not_A Brand";v="99", "Google Chrome";v="109", "Chromium";v="109"
<br>sec-ch-ua-mobile: ?0
<br>sec-ch-ua-platform: "Windows"
<br>User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36
<br>X-Requested-With: XMLHttpRequest

<br>HTTP/1.1 200 OK
<br>Cache-Control: no-store, no-cache, must-revalidate
<br>Connection: Keep-Alive
<br>Content-Length: 0
<br>Content-Type: text/html; charset=UTF-8
<br>Date: Fri, 13 Jan 2023 17:54:23 GMT
<br>Expires: Thu, 19 Nov 1981 08:52:00 GMT
<br>Keep-Alive: timeout=5, max=100
<br>Pragma: no-cache
<br>Server: Apache/2.4.54 (Win64) PHP/8.1.10
<br>X-Powered-By: PHP/8.1.10

### Добавление канала

<br>POST /chat_src/add_chat.php HTTP/1.1
<br>Host: localhost
<br>Accept: text/html, */*
<br>Content-Type: application/x-www-form-urlencoded
<br>sec-ch-ua: "Not_A Brand";v="99", "Google Chrome";v="109", "Chromium";v="109"
<br>sec-ch-ua-mobile: ?0
<br>sec-ch-ua-platform: "Windows"
<br>User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36
<br>X-Requested-With: XMLHttpRequest

<br>HTTP/1.1 200 OK
<br>Connection: Keep-Alive
<br>Content-Length: 1
<br>Content-Type: text/html; charset=UTF-8
<br>Date: Fri, 13 Jan 2023 17:56:50 GMT
<br>Keep-Alive: timeout=5, max=100
<br>Server: Apache/2.4.54 (Win64) PHP/8.1.10
<br>X-Powered-By: PHP/8.1.10

## 7. Значимые фрагменты кода
### Функции проверки регистрации и входа
``` js
function checkLogin() {
        //Считываем сообщение из поля ввода
        var login = $("#login").val();
        // Отсылаем параметры
        $.ajax({
            type: "POST",
            url: "register.php",
            data: "login=" + login,
            success: function (html) {
                $("#check_login").html(html);
                $("#login").val('');
            }
        });
    }
    function checkEnter() {
        //Считываем сообщение из поля ввода
        var logent = $("#logent").val();
        // Отсылаем параметры
        $.ajax({
            type: "POST",
            url: "login.php",
            data: "login=" + logent,
            success: function (html) {
                $("#check_enter").html(html);
                $("#logent").val('');
                setTimeout(function(){
                    window.location.href="index.php";
                },1000);
            }
        });
    }

```
### Функции загрузки чатов
```js
  function loadchats(){
        $.ajax({
            url: "load_chat.php",
            type: "POST",
            cache: false,
            data: {"user": user},
            dataType: "html",
            success: function (data) {
                if (chats_data != data) {
                    chats_data = data;
                    $("#chats").empty();
                    $("#chats").append(data);
                    $.ajax({
                        url: "chat_check.php",
                        type: "POST",
                        cache: false,
                        data: {"chat": opened_chat, "user": user},
                        dataType: "html",
                        success: function(exist){
                            if (exist == '1') {
                                $("#" + opened_chat).attr("disabled", true);
                            }
                            else{
                                opened_chat = null;
                            }
                        }
                    });
                }
            }
        });
    }
```
