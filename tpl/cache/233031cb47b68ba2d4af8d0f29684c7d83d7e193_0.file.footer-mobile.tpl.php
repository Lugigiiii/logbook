<?php
/* Smarty version 4.2.1, created on 2023-04-09 13:22:12
  from 'C:\Users\luigi\OneDrive\Web\repo_logbook\logbook\tpl\footer-mobile.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '4.2.1',
  'unifunc' => 'content_64329fe4645450_24471946',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '233031cb47b68ba2d4af8d0f29684c7d83d7e193' => 
    array (
      0 => 'C:\\Users\\luigi\\OneDrive\\Web\\repo_logbook\\logbook\\tpl\\footer-mobile.tpl',
      1 => 1680896069,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64329fe4645450_24471946 (Smarty_Internal_Template $_smarty_tpl) {
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
    })
<?php echo '</script'; ?>
>

</html><?php }
}
