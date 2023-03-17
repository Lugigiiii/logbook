<!DOCTYPE html>
<html lang="device-width">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Logbook</title>
    <link rel="stylesheet" href="../resources/css/app-mobile-1.css">
    <script src="../resources/js/autonumeric.js"></script>
    <script src="../resources/js/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div id="main">
        <div id="top">
            <h2 class="top-left">Hallo, Luigi!</h2>
        </div>
        <div id="center">
            <!--
            <div id="timer">
                <label id="hours">00</label>:<label id="minutes">00</label>:<label id="seconds">00</label>
            </div>
            -->
            <div id="form">
                <form name="meta-start" method="post">
                    <input class="inp-fw" name="loc-start" type="text" placeholder="Startort..." value=""/>
                    <input id="numeric" class="inp-fw" name="km-start" type="text" placeholder="KM Stand..." value=""/>
                </form>
            </div>
        </div>
        <div id="bottom">
            <div id="buttons">
                <div id="left">
                    <button id="btn-start" onclick="checkInput();">Start</button>
                    <button id="btn-resume">Weiter</button>
                </div>
                <div id="right">
                    <button id="btn-manual">Manuell</button>
                    <button id="btn-stop">Beenden</button>
                </div>
                <div id="stretch">
                    <button id="btn-pause">Pause</button>
                    <button id="btn-save">Speichern</button>
                </div>
            </div>
        </div>
    </div>
</body>
<!--<script src="../resources/js/timer.js"></script>-->
<script src="../resources/js/main-functions.js"></script>
<script>
    loadSaved();
    $(function() {
        new AutoNumeric('#numeric', {currencySymbol :' km', allowDecimalPadding:'false',currencySymbolPlacement:'s',digitGroupSeparator:"'"});
    });
</script>
</html>