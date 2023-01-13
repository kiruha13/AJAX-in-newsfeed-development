<?php
$login = $_SESSION['login'];
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript">
    let opened_chat = null;
    let user = '<?php echo $login?>';
    let messages_data = null;
    let chats_data = null;

    function add_channel() {
        let name = prompt('enter name');
        if (name == null || name.trim() == "") {
            alert("fill the fields");
            return 0;
        }
        if (name.length > 40) {
            alert("Max length is 40");
            return 0;
        }
        let type = confirm("Make a chat private?");
        if (type == true) {
            type = "private";
        } else {
            type = "public";
        }

        $.ajax({
            url: "add_chat.php",
            type: "POST",
            cache: false,
            data: {"name": name, "type": type, "creator": user},
            dataType: "html",
            success: function (data) {
                if (data == "1") {
                    loadchats();
                } else {
                    alert("Chat with this name already exists");
                }
            }
        });
    }

    function loadchats() {
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
                        success: function (exist) {
                            if (exist == '1') {
                                $("#" + opened_chat).attr("disabled", true);
                            } else {
                                opened_chat = null;
                            }
                        }
                    });
                }
            }
        });
    }

    function open_channel(id) {
        if (opened_chat != null) {
            $("#" + opened_chat).attr("disabled", false);
        }
        opened_chat = id;
        $("#" + id).attr("disabled", true);
        $("#send").attr("disabled", false);
        load_permissions();

        $.ajax({
            url: "chat_open.php",
            type: "POST",
            cache: false,
            data: {"channel_id": id},
            dataType: "html",
            success: function (data) {
                if (messages_data != data) {
                    messages_data = data;
                    $("#messages").empty();
                    $("#messages").append(data);
                    $("#messages").scrollTop(10000);
                }
            }
        });
    }

    function send_message() {
        let message = $("#new_message").val();
        $.ajax({
            url: "add_message.php",
            type: "POST",
            cache: false,
            data: {"channel_id": opened_chat, "message": message, "user": user},
            dataType: "html",
            success: function (data) {
                open_channel(opened_chat);
                $("#new_message").val('');
            }
        });
    }

    function load_permissions() {
        $.ajax({
            url: "checkforperm.php",
            type: "POST",
            cache: false,
            data: {"channel_id": opened_chat, "user": user},
            dataType: "html",
            success: function (data) {
                $("#permissions").empty();
                $("#permissions").append(data);
            }
        });
    }

    function delete_permission(user) {
        $.ajax({
            url: "delperm.php",
            type: "POST",
            cache: false,
            data: {"user": user, "channel": opened_chat},
            dataType: "html",
            success: function (data) {
                load_permissions();
            }
        });
    }

    function add_permission() {
        let name = prompt('Введите никнейм нового участника');
        if (name == null || name.trim() == "") {
            alert("Введено пустое поле");
            return 0;
        }
        if (name.length > 32) {
            alert("Максимальная длина никнейма - 32 символа");
            return 0;
        }
        $.ajax({
            url: "addperm.php",
            type: "POST",
            cache: false,
            data: {"channel_id": opened_chat, "name": name},
            dataType: "html",
            success: function (data) {
                if (data == "1") {
                    load_permissions();
                } else {
                    alert("Пользователь уже состоит в канале или не существует");
                }
            }
        });
    }


    loadchats();

</script>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/index.css">
</head>
<div class="container">
    <div><br>
        <div id="chats"></div>
    </div>
    <table class="chatmess">
        <tr>
            <td>
                <div id="messages" class="mess"></div>
            </td>
        </tr>
        <tr>

            <td>
                <form class="senbtn">
                    <input type="text" class="msg" id="new_message">
                    <button type="button" class="sendmsg" id="send" onclick="send_message()">Send</button>
                </form>
            </td>

        </tr>
    </table>
    <div class="col"><br><br>
        <div id="permissions"></div>
    </div>
</div>
<script>
    $("#send").attr("disabled", true);
    setInterval(function () {
        loadchats();
        if (opened_chat != null) {
            open_channel(opened_chat);
        } else {
            $("#send").attr("disabled", true);
            $("#permissions").empty();
            $("#messages").empty();
        }
    }, 2000);
</script>
</html>