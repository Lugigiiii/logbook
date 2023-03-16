<!DOCTYPE html>
<html lang="device-width">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logbook</title>
    <link rel="stylesheet" href="../resources/css/app-mobile-1.css">
</head>
<body>
    <div id="main">
        <div id="top">
            <div id="timer">
                <label id="hours">00</label>:<label id="minutes">00</label>:<label id="seconds">00</label>
            </div>
        </div>
        <div id="bottom">
            <div id="buttons">
                <button id="btn-start" onclick="setTS();">Fahrt beginnen</button>
                <button id="btn-stop" style="display: none;" onclick="stopTimer();">Fahrt beenden</button>
            </div>
        </div>
    </div>
</body>
<script src="../resources/js/timer.js"></script>
</html>