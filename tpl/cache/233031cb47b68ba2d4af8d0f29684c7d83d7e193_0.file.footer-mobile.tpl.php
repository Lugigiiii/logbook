<?php
/* Smarty version 4.2.1, created on 2023-05-07 22:21:45
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\footer-mobile.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64580859158247_75153895',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '233031cb47b68ba2d4af8d0f29684c7d83d7e193' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\footer-mobile.tpl',
      1 => 1683490816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64580859158247_75153895 (Smarty_Internal_Template $_smarty_tpl) {
?></body>
<?php echo '<script'; ?>
 src="../resources/js/timer.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="../resources/js/main-functions.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
    // loading items from browser
    if(localStorage.getItem("savedComplete")){
        loadDefault();
    }

    // start main function
    loadView();

    // jQuery to adjust input format
    $(function() {
        an = new AutoNumeric('#numeric', {currencySymbol :' km', allowDecimalPadding:"false",currencySymbolPlacement:'s',digitGroupSeparator:"'"});
    });

    // get km after car ist selected
    $('#car-selector').change(function(){
        aj_getKM();
        // get location and write to input and localStorage. Get from Storage if already set
        if(!localStorage.getItem("apiRequest")){     
            window.onpaint = getLocation();
        } else {
            document.getElementById("input-loc").value = localStorage.getItem("apiRequest");
        }
    })

    if (typeof navigator.serviceWorker !== 'undefined') {
        navigator.serviceWorker.register('/sw.js')
    }
<?php echo '</script'; ?>
>

</html><?php }
}
