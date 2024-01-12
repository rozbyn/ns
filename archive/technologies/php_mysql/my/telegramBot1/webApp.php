<?php


?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test telegram web app</title>
    <script src='https://telegram.org/js/telegram-web-app.js'></script>
</head>
<body style="background-color: #ffffff">

<form id="jsCommandForm">
    <div id="inputContainer">
        <label for="js_command">js command</label>
        <br>
        <textarea id="js_command" name="bob" style="width: 100%" rows="5"></textarea>
    </div>
    <input type="submit">
</form>
<div id="echoContainer" >
    <pre id="output"></pre>
</div>

<script>
    (function () {
        let jsCommandForm = document.getElementById('jsCommandForm');
        let jsCommandEl = document.getElementById('js_command');
        let outputEl = document.getElementById('output');
        if (!jsCommandForm || !jsCommandEl || !outputEl) {
            return;
        }
        jsCommandEl.addEventListener('keypress', function (e) {
            if (e.code === 'Enter' && e.ctrlKey === true) {
                jsCommandForm.dispatchEvent(new SubmitEvent("submit", {submitter: jsCommandEl}));
            }
        })
        jsCommandForm.addEventListener('submit', function (e) {
            let result;
            e.preventDefault();
            let code = jsCommandEl.value;
            try {
                result = eval(code);
                outputEl.innerHTML = JSON.stringify(result, null, 4);
            } catch (e) {
                outputEl.innerHTML = e.toString();
            }
        });


    })();
</script>
</body>
</html>
