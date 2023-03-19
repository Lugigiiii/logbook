<!DOCTYPE html>
<html lang="device-width">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Logbook</title>
    <link rel="stylesheet" href="../resources/css/app-mobile-1.css">
    <script src="../resources/js/autonumeric.js"></script>
    <script src="../resources/js/jquery-3.6.4.min.js"></script>
    <script src="https://kit.fontawesome.com/4cc784d7e8.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="main">
        <div id="top">
            <h2 class="top-left">Hallo, Luigi!</h2>
            <h2 id="title-top"></h2>
        </div>
        <div id="center">
            <div id="timer">
                <div id="timer-live">
                    <label id="hours">00</label>:<label id="minutes">00</label>:<label id="seconds">00</label>
                </div>
            </div>
            <div id="form">
                <form name="meta" method="post">
                    <input class="inp-fw" name="loc" type="text" placeholder="Startort..." value=""/>
                    <input id="numeric" class="inp-fw" name="km" type="text" placeholder="KM Stand..." value=""/>
                </form>
            </div>
            <div id="pause-view">
                <i id="pause" class="fa-solid fa-circle-pause"></i>
                <div id="form-pause">
                    <form name="meta-pause" method="post">
                        <input class="inp-fw" name="loc-pause" type="text" placeholder="Zwischenhalt..." value=""/>
                    </form>
                </div>
            </div>
        </div>
        <div id="bottom">
            <div id="buttons">
                <div id="left">
                    <button id="btn-start" onclick="startFunc()">Start</button>
                    <button id="btn-resume" onclick="resumeFunc()">Weiter</button>
                </div>
                <div id="right">
                    <button id="btn-manual">Manuell</button>
                    <button id="btn-stop" onclick="stopFunc()">Beenden</button>
                </div>
                <div id="stretch">
                    <button id="btn-pause" onclick="pauseFunc()">Pause</button>
                    <button id="btn-save" onclick="saveFunc()">Speichern</button>
                    <button id="btn-back" onclick="loadDefault()">Zurück zum Anfang</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="../resources/js/timer.js"></script>
<script src="../resources/js/main-functions.js"></script>
<script>
    if(localStorage.getItem("savedComplete")){
        loadDefault();
    }
    loadView();
    $(function() {
        new AutoNumeric('#numeric', {currencySymbol :' km', allowDecimalPadding:'false',currencySymbolPlacement:'s',digitGroupSeparator:"'"});
    });
</script>
</html>