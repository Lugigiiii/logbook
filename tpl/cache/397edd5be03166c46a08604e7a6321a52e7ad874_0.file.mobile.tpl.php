<?php
/* Smarty version 4.2.1, created on 2023-05-18 18:59:43
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\mobile.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_6466597f7aef18_06925924',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '397edd5be03166c46a08604e7a6321a52e7ad874' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\mobile.tpl',
      1 => 1684429181,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6466597f7aef18_06925924 (Smarty_Internal_Template $_smarty_tpl) {
?>    <div id="main">
        <div id="top">
            <h2 class="top-left">Hallo, <?php echo $_smarty_tpl->tpl_vars['first']->value;?>
!</h2>
            <div class="dropdown top-right">
                <button class="dropbtn"><i class="fa-solid fa-bars"></i></button>
                <div class="dropdown-content">
                  <?php if ($_smarty_tpl->tpl_vars['admin']->value == true) {?><a href="/index.php?view=admin">Admin</a><?php }?>
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
            <div id="manual-view">
                <div id="form-manual">
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
                    <button id="btn-manual" onclick="manualFunc()">Manuell</button>
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
<?php }
}
