{include file="header.tpl"}
<h1>History for {$user} - page {$page}</h1>
{if $previous}
<a href="/{$user}/history/{$previous}">Previous {$per_page}</a>
{/if}
{if $next}
<a href="/{$user}/history/{$next}">Next {$per_page}</a>
{/if}
{if $entries}
{include file="entries.tpl"}
{else}
<h2>Sorry, no history</h2>
{/if}
{include file="footer.tpl"}
