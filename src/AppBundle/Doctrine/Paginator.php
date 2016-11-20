<?php

namespace AppBundle\Doctrine;

class Paginator
{
    /**
     * @param $page
     * @param $total
     * @param int $range
     * @return array
     */
    public static function numbers($page, $total, $range = 5)
    {
        if ($range % 2 === 0) {
            $range++;
        }

        $half = ($range - 1) / 2;

        $right = $page + $half;

        if ($right > $total) {
            $left = $page - ($right - $total) - $half;
        } else {
            $left = $page - $half;
        }

        if ($left <= 0) {
            $right += abs($left);
            $right++;
            $left = 1;
        }

        $pages = [];

        for ($i = $left; $i <= $right && $i <= $total; $i++) {
            $pages[] = $i;
        }

        return $pages;
    }
}
