<?php
/* Smarty version 4.2.1, created on 2023-04-09 14:18:23
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\mobile.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_6432ad0f37cd96_16456326',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '397edd5be03166c46a08604e7a6321a52e7ad874' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\mobile.tpl',
      1 => 1681042655,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6432ad0f37cd96_16456326 (Smarty_Internal_Template $_smarty_tpl) {
?>    <div id="main">
        <div id="top">
            <h2 class="top-left">Hallo, <?php echo $_smarty_tpl->tpl_vars['first']->value;?>
!</h2>
            <button class="top-right" id="logout" onclick="logOut()">Abmelden</button>
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
                    <?php echo $_smarty_tpl->tpl_vars['selector']->value;?>

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
        </div>
        <div id="bottom">
            <div id="buttons">
                <div id="left">
                    <button id="btn-start" onclick="startFunc()">Start</button>
                    <button id="btn-resume" onclick="resumeFunc()">Weiter</button>
                </div>
                <div id="right">
                    <button id="btn-manual" onclick="alert('Feature noch nicht programmiert')">Manuell</button>
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
<?php }
}
