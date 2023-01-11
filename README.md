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
## 1. [Пользовательский интерфейс]()

## 2. Пользовательские сценарии работы

Пользователь попадает на страницу *index.php*. Регистрируется или заходит под уже зарегистрированным именем. Если данные введены корректно, осуществляется подгрузка всей логики чата из файла *chat.php*. Есть возможность создать новый канал (приватный или публичный) или присоединиться к уже существующему каналу, где можно отправлять сообщения. Также можно выйти со страницы *chat.php* c помощью кнопки *Выход*, при нажании на которую пользователь переходит на страницу *index.php* с регистрацией и входом.

## 3. API сервера и хореография

![Добавление]()

![Удаление]()

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

## 6. HTTP запросы/ответы

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
                },2000);
            }
        });
    }

```
### Функции загрузки чатов
```js
  function load_channels(){
        $.ajax({
            url: "load_chat.php",
            type: "POST",
            cache: false,
            data: {"user": user},
            dataType: "html",
            success: function (data) {
                if (channels_data != data) {
                    channels_data = data;
                    $("#channels").empty();
                    $("#channels").append(data);
                    $.ajax({
                        url: "chat_check.php",
                        type: "POST",
                        cache: false,
                        data: {"channel": active_channel, "user": user},
                        dataType: "html",
                        success: function(exist){
                            if (exist == '1') {
                                $("#" + active_channel).attr("disabled", true);
                            }
                            else{
                                active_channel = null;
                            }
                        }
                    });
                }
            }
        });
    }
```
