{include file="header.tpl"}
<h1>Open Contests</h1>
{foreach from="$marks" item="mark"}
<div class="mark" style="margin-left: 20px;">
    <h3><a href="{$base}/contest/{$mark.id}">{$mark.mark_name}</a></h3>
    Contest Start: <span>{$mark.mark_start|date_format}</span><br />
    Contest End: <span>{$mark.mark_end|date_format}</span><br />
    Participants:<br />
    <span style="margin-left: 20px;">
    {section name=user loop=$mark.users}
        <a href="{$base}/user/{$mark.users[user]}">{$mark.users[user]}</a>
    {sectionelse}
        No participants yet
    {/section}
    </span>
    <br />
    Tracking:<br />
    <span style="margin-left: 20px;">
    {section name=var loop=$mark.vars}
        <a href="{$base}/vars/{$mark.vars[var]}">{$mark.vars[var]}</a>
    {sectionelse}
        No variables yet
    {/section}
    </span>
</div>
{foreachelse}
No open contests at this time. You could <a href="">start one (NOT YET)</a>.
{/foreach}
{include file="footer.tpl"}
