{include file="header.tpl"}
<script type="text/javascript">
    var days = {$days};
    var base = "{$base}";
    {literal}
    function updateCell(id, value) {
        var that = document.getElementById(id);
        oldVal = parseFloat(that.firstChild.nodeValue.split(/ /)[0]);
        newVal = oldVal + parseFloat(value);
        var ave = parseInt((newVal / days) * 100) / 100;
        that.firstChild.nodeValue = (newVal) + " (" + ave + ")";
        showWinner();
    }
    function showWinner() {
        var tds = document.getElementsByTagName("td");
        var vars = new Array();
        for (var i=0, l=tds.length; i<l; i++) {
            if (tds[i].className == "value" && tds[i].firstChild) {
                tds[i].style.backgroundColor = "#ffc";
                id = tds[i].id.split(/_/)[0];
                tVar = tds[i].id.split(/_/)[1];
                cValue = parseFloat(tds[i].firstChild.nodeValue);
                if (vars[tVar]) {
                    if (cValue > vars[tVar][1]) {
                        vars[tVar][0] = id;
                        vars[tVar][1] = cValue;
                    }
                }
                else {
                    vars[tVar] = new Array();
                    vars[tVar][0] = id;
                    vars[tVar][1] = cValue;
                }
            }
        }
        for (v in vars) {
            document.getElementById(vars[v][0]+"_"+v).style.backgroundColor = "#c24";
        }
    }

    function showGraph(mark, tvar) {
        //TODO make this generic so it takes width height php and vars(aray) this wey it can be in header
        closeGraph();
        div = document.createElement("DIV");
        div.id = "graph";
        div.innerHTML = "<div style='text-align:right; color:#fff;'><a href='#' style='text-decoration:none; color:#fff;' onClick='closeGraph(); return false;'>close [X]</a></div><OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0' WIDTH=400 HEIGHT=150 id='charts' ALIGN=''><PARAM NAME=movie VALUE='"+base+"/charts.swf?php_source="+base+"/warchart.php%3Fmark%3D"+mark+"%26var%3D"+tvar+"'> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#fff><PARAM NAME=wmode VALUE=transparent> <EMBED src='"+base+"/charts.swf?php_source="+base+"/warchart.php%3Fmark%3D"+mark+"%26var%3D"+tvar+"' quality=high bgcolor=#fffffff WIDTH=400 HEIGHT=150 NAME='charts' ALIGN='' TYPE='application/x-shockwave-flash' PLUGINSPAGE='http://www.macromedia.com/go/getflashplayer'></EMBED></OBJECT>";
        //div.style.float = "left";
        div.width = "420px";
        div.style.MozOutline = "1px";
        div.style.MozOutlineRadius = "1px";
        div.style.MozOpacity = "0.4";
        div.style.opacity = "0.4";
        div.height = "160px";
        div.style.border = "1px solid black";
        div.style.position = "absolute";
        div.style.top = "20px";
        div.style.left = "20px";
        div.style.fontSize = "9px";
        div.style.backgroundColor="#000";
        document.getElementById("main").appendChild(div);
    }
    {/literal}
</script>
<h1>{$mark_name}</h1>
<h1>{$mark_left}</h2>
<strong>Vars:</strong>
<table border="1" style="border-collapse:collapse">
    <thead>
        <tr>
            <th>&nbsp;</th>
{foreach from=$uvars item=user}
            <th class="person"><a href="{$base}/user/{$user.username}">{$user.username}</a></th>
{/foreach}
            <th>Graph</th>
        </tr>
    </thead>
    <tbody>
{foreach from=$vars item=var}
        <tr>
            <th align="right">{$var}{if $my_id}<a href="#" onClick="showInput('{$var}'); return false;">+</a>{/if}</th>
    {foreach from=$uvars key=id item=user}
            <td class="value" id="{$id}_{$var}" align="center">{if $user.$var.total}{$user.$var.total} ({$user.$var.ave}){else}0 (0){/if}</td>
    {/foreach}
            <td><a href="#" onClick="showGraph('{$smarty.get.mark_id}', '{$var}'); return false;">graph</a></td>
        </tr>
{/foreach}
    </tbody>
</table>
<br />

<strong>Measurements:</strong>
<table border="1" style="border-collapse:collapse">
    <thead>
        <tr>
            <th>&nbsp;</th>
{foreach from=$mvars item=user}
            <th class="person"><a href="{$base}/user/{$user.username}">{$user.username}</a></th>
{/foreach}
            <th>Graph</th>
        </tr>
    </thead>
    <tbody>
{foreach from=$measurements item=measurement}
        <tr>
            <th align="right">
                {$measurement}
                {if $my_id}
                <a href="#" onClick="showInput('{$measurement}'); return false;">+</a>
                {/if}
            </th>
    {foreach from=$mvars key=id item=user}

            <td class="value" id="{$id}_{$measurement}" align="center">
                {if $user.$measurement.diff}
                {$user.$measurement.diff}
                {else}
                0
                {/if}
            </td>

    {/foreach}
            <td><a href="#" onClick="showGraph('{$smarty.get.mark_id}', '{$measurement}'); return false;">graph</a></td>
        </tr>
{/foreach}
    </tbody>
</table>
<br />
<div id="newStuff">
</div>
{literal}
        <script type="text/javascript">
            showWinner();
        </script>
{/literal}
{include file="footer.tpl"}
