    <table border=1 style="border-collapse: collapse;">
        <thead>
            <th>Variable</th>
            <th>Value</th>
            <th>Added</th>
        </thead>
        <tbody>
    {foreach from="$entries" item="entry"}
            <tr>
                <td><a href="{$base}/user/{$user}/{$entry.var}">{$entry.var}</a></td>
                <td>{$entry.value}</td>
                <td>
                    {$entry.added|date_format:"%b %e, %Y %l:%M %p"}
                    {if $my_id == $their_id}<span class="edit_entry">[ <a href="/edit/{$entry.id}">change</a> ]<span>{/if}
                </td>
            </tr>
    {foreachelse}
            <tr>
                <td colspan="3">
                    No values for {$date|date_format}
                </td>
            </tr>
    {/foreach}
        </tbody>
    </table>
