    <div id="main">
        <div id="top">
            <h2 class="top-left">Hallo, {$first}!</h2>
            <div class="dropdown top-right">
                <button class="dropbtn"><i class="fa-solid fa-bars"></i></button>
                <div class="dropdown-content">
                  {if $admin eq true}<a href="/index.php?view=admin">Admin</a>{/if}
                  <button id="logout" onclick="logOut()">Abmelden</button>
                </div>
              </div>
            <h2 id="title-top"></h2>
            <div id="subtitle-top"></div>
        </div>
        <div id="center">
            <div id="timer">
                <div id="timer-live">
                    <label id="hours">00</label>:<label id="minutes">00</label>:<label id="seconds">00</label>
                </div>
            </div>
            <div id="form">
                <form name="meta" method="post">
                    {$selector}
                    <input id="input-loc" class="inp-fw" name="loc" type="text" placeholder="Startort..." value=""/>
                    <input id="numeric" class="inp-fw" name="km" type="text" placeholder="KM Stand..." value=""/>
                </form>
            </div>
            <div id="pause-view">
                <i id="pause" class="fa-solid fa-circle-pause"></i>
                <div id="form-pause">
                    <form name="meta-pause" method="post">
                        <input id="input-loc-pause" class="inp-fw" name="loc-pause" type="text" placeholder="Zwischenhalt..." value=""/>
                    </form>
                </div>
            </div>
            <div id="manual-view">
                <div id="form-manual">
                    <form id="meta-manual" name="meta-manual" method="post">
                        <input id="man-start" class="inp-fw datetime" name="man-date-start" type="datetime-local" placeholder="Startzeitpunkt..." value="" data-input> <!-- input is mandatory -->
                        <input id="man-end" class="inp-fw datetime" name="man-date-end" type="datetime-local" placeholder="Endzeitpunkt..." data-input> <!-- input is mandatory -->
                        <input id="numeric-2" class="inp-fw" name="man-km-end" type="text" placeholder="KM Stand..." value=""/>
                        <input id="man-loc-end" class="inp-fw" name="man-loc-end" type="text" placeholder="Zielort..." value=""/>
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
                    <button id="btn-manual" onclick="showManualFunc()">Manuell</button>
                    <button id="btn-stop" onclick="stopFunc()">Beenden</button>
                </div>
                <div id="stretch">
                    <button id="btn-pause" onclick="pauseFunc()">Pause</button>
                    <button id="btn-save" onclick="saveFunc()">Speichern</button>
                    <button id="btn-save-manual" onclick="saveManualFunc()">Speichern</button>
                    <button id="btn-back" onclick="loadDefault()">Zurück zum Anfang</button>
                </div>
            </div>
        </div>
    </div>
