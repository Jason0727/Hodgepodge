<?php

/**
 * 快速排序
 *
 * 介绍:快速排序是由东尼·霍尔所发展的一种排序算法。在平均状况下，排序 n 个项目要Ο(n log n)次比较。在最坏状况下则需要Ο(n2)次比较，但这种状况并不常见。事实上，快速排序通常明显比其他Ο(n log n) 算法更快，因为它的内部循环（inner loop）可以在大部分的架构上很有效率地被实现出来，且在大部分真实世界的数据，可以决定设计的选择，减少所需时间的二次方项之可能性
 *
 * 步骤:
 * 1.从数列中挑出一个元素，称为 “基准”（pivot)
 * 2.重新排序数列，所有元素比基准值小的摆放在基准前面，所有元素比基准值大的摆在基准的后面（相同的数可以到任一边）。在这个分区退出之后，该基准就处于数列的中间位置。这个称为分区（partition）操作。
 * 3.递归地（recursive）把小于基准值元素的子数列和大于基准值元素的子数列排序
 */

$arr = [1, 43, 54, 62, 21, 66, 32, 78, 36, 76, 39, 2];

function quick_sort(array $arr)
{
    $len = count($arr);
    if ($len <= 1) return $arr; // 递归出口:单个元素或者空数组直接返回
    // 定义两个空数组
    $left = $right = [];
    for ($i = 1; $i < $len; $i++) {
        // 数组的第一个元素作为“基准”
        if ($arr[$i] < $arr[0]) {
            $left[] = $arr[$i];
        } else {
            $right[] = $arr[$i];
        }
    }

    $left = quick_sort($left);
    $right = quick_sort($right);

    return array_merge($left, [$arr[0]], $right);
}

print_r(quick_sort($arr));