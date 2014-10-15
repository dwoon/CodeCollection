<?php
/**
 * 根据数组名递归生成 php代码片段 
 *
 * @var array
 * @return array
 */
function genRecursiveCode($arr) {
    $level =count($arr);
    $i = 0;
    $phpcode ='%s';
    if (empty($arr)) {
        return;
    } 
    while(!empty($arr)) {
        $arrayname = array_shift($arr);
        //增加缩进
        $spaceNum = $i * 4;
        $spaceStr =str_repeat(" ",$spaceNum);
        if ($level== $i+1) {
           $ls = 'echo ';
           for ($j = 0; $j < $level; $j++) {
               if ($j != $i) {
                   $ls .= "\$key{$j}.\$vl{$j}.";  
               } else {
                   $ls .= "\$key{$j}.\$vl{$j}"; 
               }
           }
           $ls .= '; echo "\n";';
           $fragment =
           $spaceStr . "foreach( \$$arrayname as \$key{$i} => \$vl{$i}) {\n".
           $spaceStr . "   $ls\n". 
           $spaceStr . "}";
        } else { 
           $fragment = 
           $spaceStr . "foreach( \$$arrayname as \$key{$i} => \$vl{$i}) {\n".
           $spaceStr . "    %s\n". 
           $spaceStr ."}";
        }
        $phpcode = sprintf($phpcode,$fragment);
        $i++;
    }
    return  $phpcode;
}                                                                                                                                                                                                          
$arr  = array('var1','var2');
$var1 = array(
        '0' => 'p',
        '1' => 'p',
        );
$var2 = array(
        '0' => 'v',
        '1' => 'v',
        );

$phpcode = genRecursiveCode($arr);
eval($phpcode);
