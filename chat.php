<?php
$login = $_SESSION['login'];
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript">
        let active_channel = null;
        let user = '<?php echo $login?>';
        let messages_data = null;
        let channels_data = null;

        function add_channel(){
        let name = prompt('enter name');
        if (name == null || name.trim() == ""){
        alert("fill the fields");
        return 0;
    }
        if (name.length > 40){
        alert("Max length is 40");
        return 0;
    }
        let type = confirm("Make a chat private?");
        if (type == true){
        type = "private";
    }
        else{
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
        load_channels();
    }
        else{
        alert("Chat with this name already exists");
    }
    }
    });
    }

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

        function open_channel(id){
        if (active_channel != null) {
        $("#" + active_channel).attr("disabled", false);
    }
        active_channel = id;
        $("#" + id).attr("disabled", true);
        $("#send").attr("disabled", false);
        load_permissions();

        $.ajax({
        url: "chat_open.php",
        type: "POST",
        cache: false,
        data: {"channel_id": id},
        dataType: "html",
        success: function(data){
        if (messages_data != data) {
        messages_data = data;
        $("#messages").empty();
        $("#messages").append(data);
        $("#messages").scrollTop(10000);
    }
    }
    });
    }

        function send_message(){
        let message = $("#new_message").val();
        $.ajax({
        url: "add_message.php",
        type: "POST",
        cache: false,
        data: {"channel_id": active_channel, "message": message, "user": user},
        dataType: "html",
        success: function(data){
        open_channel(active_channel);
        $("#new_message").val('');
    }
    });
    }

        function load_permissions(){
        $.ajax({
            url: "checkforperm.php",
            type: "POST",
            cache: false,
            data: {"channel_id": active_channel, "user": user},
            dataType: "html",
            success: function(data){
                $("#permissions").empty();
                $("#permissions").append(data);
            }
        });
    }

        function delete_permission(user){
        $.ajax({
            url: "delperm.php",
            type: "POST",
            cache: false,
            data: {"user": user, "channel": active_channel},
            dataType: "html",
            success: function(data){
                load_permissions();
            }
        });
    }

        function add_permission(){
        let name = prompt('Введите никнейм нового участника');
        if (name == null || name.trim() == ""){
        alert("Введено пустое поле");
        return 0;
    }
        if (name.length > 32){
        alert("Максимальная длина никнейма - 32 символа");
        return 0;
    }
        $.ajax({
        url: "addperm.php",
        type: "POST",
        cache: false,
        data: {"channel_id": active_channel, "name": name},
        dataType: "html",
        success: function (data) {
        if (data == "1") {
        load_permissions();
    }
        else{
        alert("Пользователь уже состоит в канале или не существует");
    }
    }
    });
    }


        load_channels();

</script>
<html lang="ru">
<head>
    <link rel="stylesheet" href="css/index.css">
</head>
<div class="container">
    <div class="col"><br><br>
        <div id="channels"></div>
    </div>
    <table class="chatmess">
        <tr>
            <td>
                <div id="messages" class="mess"></div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <form class="senbtn">
                    <input type="text" id="new_message">
                    <button type="button" id="send" onclick="send_message()">Send</button>
                </form>
            </td>

        </tr>
    </table>
    <div class="col"><br><br>
        <div id="permissions" class="btn-group-vertical"></div>
    </div>
</div>
<script>
    $("#send").attr("disabled", true);
    setInterval(function(){
        load_channels();
        if (active_channel != null) {
            open_channel(active_channel);
        }
        else{
            $("#send").attr("disabled", true);
            $("#permissions").empty();
            $("#messages").empty();
        }
    }, 2000);
</script>
</html>