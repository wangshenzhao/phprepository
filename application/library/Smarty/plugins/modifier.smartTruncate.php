<?php
function smarty_modifier_smartTruncate($remarks, $len = 20)
{
    $remarks = strip_tags( $remarks );
    $ret = utf8_substr( trim( $remarks ), 0, $len );
    if ( $remarks > $ret ) {
        return $ret . '...';
    } else {
        return $ret;
    }
}

function utf8_substr( $str,$start, $end )
{
    $null = "";
    preg_match_all( "/./u", $str, $ar );
    if ( func_num_args() >= 3 ) {
        $end = func_get_arg( 2 );
        return join( $null, array_slice( $ar[ 0 ], $start, $end ) );
    } else {
        return join( $null, array_slice( $ar[ 0 ], $start ) );
    }
}