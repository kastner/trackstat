{include file="header.tpl"}
<h1>Variables for <a href="{$base}/user/{$user}">{$user}</a> for {$date|date_format:"%A %b %e, %Y"}</h1>
<div id="dates">
    <span id="previous_day">
    {if $previous_day}
        <a href="/user/{$user}/{$previous_day}">&lt;&lt; {$previous_day|date_format}</a>
    {/if}
    </span>
    <span id="next_day">
    {if $next_day}
        <a href="/user/{$user}/{$next_day}">{$next_day|date_format} &gt;&gt;</a>
    {/if}
    </span>
</div>
<div style="float:left; margin: 6px;">
    Entries:
{include file="entries.tpl"}
</div>

<div style="float:left; margin: 6px;">
    Totals:
    <table border=1 style="border-collapse: collapse;">
        <thead>
            <th>Variable</th>
            <th>Total</th>
        </thead>
        <tbody>
    {foreach from="$totals" item="total"}
            <tr>
                <td align="right">
                    <a href="{$base}/user/{$user}/{$total.var}">{$total.var}</a>
                    {if $my_id == $their_id}
                    <a href="#" onClick="showInput('{$total.var}'); return false;">+</a>
                    {/if}

                </td>
                <td>{$total.total}</td>
            </tr>
    {foreachelse}
            <tr>
                <td colspan="2">
                    No values yet for {$date|date_format}
                </td>
            </tr>
    {/foreach}
        </tbody>
    </table>
</div>
<br style="clear: both;" />

{include file="footer.tpl"}
