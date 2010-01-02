{include file="header.tpl"}
<script type="text/javascript">
    base = "{$base}";
    {literal}

    function createCookie(name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function swapCookie(cookie) {
        val = (readCookie('hide_zeros') == 1) ? 0 : 1;
        createCookie('hide_zeros', val, 900);
    }

    window.onload = function() {
        swap_zeros = document.getElementById('swap_zeros');
        swap_zeros.innerHTML = (readCookie('hide_zeros') == 1) ? "Show zeros in graphs" : "Hide zeros in graphs";
        swap_zeros.innerHTML = "<a href='" + window.location + "' onClick=\"swapCookie('hide_zeros');\">" + swap_zeros.innerHTML + "</a>";
    }

    function updateCell(id, value, ave_id, ave, today_id, today) {
        var varId = document.getElementById(id);
        var aveId = document.getElementById(ave_id);
        var todayId = document.getElementById(today_id);
        varId.firstChild.nodeValue = value;
        ave = (ave * 100) / 100;
        aveId.firstChild.nodeValue = ave;
        todayId.firstChild.nodeValue = today;
    }

    function showGraph(their_id, tvar) {
        //TODO make this generic so it takes width height php and vars(aray) this wey it can be in header
        closeGraph();
        div = document.createElement("DIV");
        div.id = "graph";
        var php_src = base+"/theirchart.php%3Ftheir_id%3D" + their_id + "%26var%3D" + tvar;

        div.innerHTML = "<div style='text-align:right; color:#fff;'><a href='#' style='text-decoration:none; color:#000;' onClick='closeGraph(); return false;'>close [X]</a></div><OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' WIDTH=700 HEIGHT=250 id='charts' ALIGN=''><PARAM NAME=movie VALUE='"+base+"/charts.swf?php_source="+base+"/theirchart.php%3Ftheir_id%3D"+their_id+"%26var%3D"+tvar+"'> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#fff> <EMBED src='"+base+"/charts.swf?php_source="+base+"/theirchart.php%3Ftheir_id%3D"+their_id+"%26var%3D"+tvar+"' quality=high bgcolor=#ffffff WIDTH=700 HEIGHT=250 NAME='charts' ALIGN='' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED></OBJECT>";
        div.innerHTML = "<div style='text-align:right; color:#fff;'>" + php_src + "<a href='#' style='text-decoration:none; color:#000;' onClick='closeGraph(); return false;'>close [X]</a></div><OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' WIDTH=700 HEIGHT=250 id='charts' ALIGN=''><PARAM NAME=movie VALUE='"+base+"/charts.swf?php_source="+ php_src +"'> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#fff> <EMBED src='"+base+"/charts.swf?php_source=" + php_src + "' quality=high bgcolor=#ffffff WIDTH=700 HEIGHT=250 NAME='charts' ALIGN='' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED></OBJECT>";
        //div.innerHTML = div.innerHTML.replace(/</g, "&lt;");
        //div.style.float = "left";
        div.width = "720px";
        div.style.MozOutline = "1px";
        div.style.MozOutlineRadius = "1px";
        div.style.MozOpacity = "0.4";
        div.style.opacity = "0.4";
        div.height = "160px";
        div.style.border = "1px solid black";
        div.style.position = "absolute";
        div.style.top = "300px";
        div.style.left = "20px";
        div.style.fontSize = "9px";
        div.style.backgroundColor="#fff";
        document.getElementById("main").appendChild(div);
    }
    {/literal}
</script>
<h1>{$user} <span id="profileLink">[ <a href="/user/{$user}/profile">profile</a> ]</span></h1>
<div id='swap_zeros'>Hide zeros in graphs</div>
{if $my_id == $their_id}
<a href="#" onClick="showInput(); return false;">New Variable</a><br />
{/if}
<table border="1" style="border-collapse:collapse">
    <thead>
        <th>variable</th>
        <th>total</th>
        <th>average</th>
        <th>today</th>
        <th>started</th>
        <th>graph</th>
    <tbody>
{foreach from=$info item=var}
        <tr>
            <th align="right">
                <a href="{$base}/user/{$user}/{$var.var}">{$var.var}</a>
                {if $my_id == $their_id}
                <a href="#" onClick="showInput('{$var.var}'); return false;">+</a>
                {/if}
            </th>
            <td class="value" id="{$their_id}_{$var.var}" align="center">{$var.total}</td>
            <td class="ave" id="{$their_id}_{$var.var}_ave">{$var.ave|string_format:"%.2f"}</td>
            <td id="{$their_id}_{$var.var}_today">
                {$today[$var.var]|default:0}
            </td>
            <td>{$var.first|date_format}</td>
            <!--<td><a href="#" onClick="showGraph('{$their_id}', '{$var.var}'); return false;">graph</a></td>-->
            <td><a href="#" onClick="showGraph('{$their_id}', '{$var.var}'); return false;"><img src="/cgi-bin/spark.cgi?type=smooth&d={$data[$var.var]}&height=20&min-m=true&max-m=true&last-m=false&min-color=red&max-color=blue&last-color=green&step=2" height="20" border="0" title="{$data[$var.var]}" alt="{$data[$var.var]}"/></a></td>
        </tr>
{/foreach}
    </tbody>
</table>
<br />
<div id="newStuff">
</div>
{$chart}
{include file="footer.tpl"}
