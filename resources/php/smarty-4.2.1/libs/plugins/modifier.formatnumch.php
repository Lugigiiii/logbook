<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.format_num_ch.php
 * Type:     modifier
 * Name:     formatnumch
 * Purpose:  Format number to thousands in CH format
 * -------------------------------------------------------------
 */
function smarty_modifier_formatnumch($num)
{
    return number_format(intval($num), 0, '', "'");
}
?>
