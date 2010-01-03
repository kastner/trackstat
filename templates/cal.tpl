{include file="header.tpl"}
<h1>{$var} for <a href="{$base}/user/{$user}">{$user}</a></h1>
{foreach from=$cals item=cal}
<div class="calendar" style="float:left; margin:10px;">
    {$cal}
</div>
{/foreach}
<br style="clear:both;">
{include file="footer.tpl"}
