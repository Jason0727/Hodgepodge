<?php

/**
 * 归并排序
 *
 * 介绍:利用递归，先拆分、后合并、再排序
 *
 * 步骤:
 * 1.均分数列为两个子数列
 * 2.递归重复上一步骤，直到子数列只有一个元素
 * 3.父数列合并两个子数列并排序，递归返回数列
 */

$arr = [1, 43, 54, 62, 21, 66, 32, 78, 36, 76, 39, 2];

function mergeSort(array $arr)
{
    // 元素总个数
    $len = count($arr);
    // 递归出口:数组中只包含一个元素，即分离了数组
    if ($len <= 1) return $arr;
    // 取数组中间 eg:如果$len = 3,则$mid = 1
    $mid = intval($len / 2);
    // 拆分数组0-mid这部分给左边left
    $left = array_slice($arr, 0, $mid);
    // 拆分数组mid到结尾给右边right
    $right = array_slice($arr, $mid);
    // 左边拆分完后开始递归合并往上走
    $left = mergeSort($left);
    // 右边拆分完毕开始递归往上走
    $right = mergeSort($right);
    // 合并两个数组,继续递归
    $arr = merge($left, $right);

    return $arr;
}

// 将两个数组合并并排序,前提:必须已递归到两个数组都有且只有一个元素，排序后，逆向再递归回去
function merge(array $arrA, array $arrB)
{
    $arrC = [];
    while (count($arrA) && count($arrB)) {
        $arrC[] = $arrA[0] < $arrB[0] ? array_shift($arrA) : array_shift($arrB);
    }

    return array_merge($arrC, $arrA, $arrB);
}

print_r(mergeSort($arr));