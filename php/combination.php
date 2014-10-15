<?php
/**
 * 根据数组项生成排列组合(巧用二进制) 
 *
 * @var array
 * @return array
 */
$arr = array('dis','price','cat','xx','hu');

function combination($arr) {
    if ( empty($arr)) {
        return;
    }   
    $count = count($arr);
    $bit = 1 << $count;
    $com = array();
    for ( $i = 1; $i < $bit; $i++) {
        $item = array();
        for ($j=0; $j < $count; $j++) {
            if ((1<<$j & $i ) !=0) {
               $item[] = $arr[$j]; 
            }   
        }   
        $com[] = $item;
    }   
    return $com;
}
print_r(combination($arr));
