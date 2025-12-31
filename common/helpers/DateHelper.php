<?php
// common/helpers/DateHelper.php
namespace common\helpers;

class DateHelper
{
    public static function relativeTimeKk($timestamp)
    {
        $diff = time() - strtotime($timestamp);

        if ($diff < 60) return 'бірнеше секунд бұрын';
        if ($diff < 3600) return round($diff / 60) . ' минут бұрын';
        if ($diff < 86400) return round($diff / 3600) . ' сағат бұрын';
        if ($diff < 2592000) return round($diff / 86400) . ' күн бұрын';
        if ($diff < 31104000) return round($diff / 2592000) . ' ай бұрын';

        return round($diff / 31104000) . ' жыл бұрын';
    }
}
