{include file="header.tpl"}
{foreach from="$updates" item="update"}
    <a href="/user/{$update.username}">{$update.username}</a> did {$update.value} {$update.var} <span class="date_words">{$update.ago|wordify_seconds}</span><br/>
{/foreach}
{include file="footer.tpl"}
