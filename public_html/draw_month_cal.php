<?php
// SMARTY!

function draw_month_cal($year, $month, $vals, $href = "", $locale = 'en_US') {
    if (checkdate($month, 1, $year)) {
        if (!$day = date("w", $f_day = mktime(0, 0, 0, $month, 1, $year)))
            $day = 7; // Mon first, Sun last

        $mo = strftime("%B", $f_day);
        $ret = <<<HTML
            <table border=1 style='border-collapse:collapse'>
                <thead>
                    <tr>
                        <th colspan=7>$mo $year</th>
                    </tr>
                    <tr>

HTML;
        for ($i = 8; --$i;) {
            $da = strftime("%a", mktime(0, 0, 0, $month, 16 - $i - $day, $year));
            $ret .= <<<HTML
                        <th>$da</th>

HTML;
        }

        $emptys = str_repeat("\n<td></td>", --$day);
        $ret .= <<<HTML
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        $emptys

HTML;
        while (checkdate($month, ++$i, $year)) { // $i==0 after for :-)
            $fd = date("Y-m-d", mktime(0,0,0,$month, $i, $year));
            $value = ($vals[$fd]) ? " - <span class='red'>$vals[$fd]</span>" : "&nbsp;&nbsp;";
            # should make this rewriteable
            $out = ($vals[$fd] and $href) ? "<a href=\"" . preg_replace("/%s/", $fd, $href) . "\">$i</a>" : $i;
            $ret .= <<<HTML
                        <td>$out $value</td>

HTML;
            if (!(++$day % 7))
                $ret .= <<<HTML
                    </tr>
                    <tr>

HTML;
        }
        $emptys = str_repeat("\n<td></td>", ((($day - $i) < 0) ? 0 : $day - $i) );
       
        $ret .= <<<HTML
                        $emptys
                    </tr>
                </tbody>
            </table>
            <br />

HTML;
   }
   return $ret;
}
