{include file="header.tpl"}
{if $success}
<h2>Update successful</h2>
{/if}
Choose your location:
<ul>
    <li><a href="/edit/{$id}">View the edit stat page you were just on</a></li>
    <li><a href="/user/{$username}">Go to your main stats page</a></li>
    <li><a href="/user/{$username}/{$var}">Go to your {$var} page</a></li>
    <li><a href="/latest">View the latest stats from everyone</a></li>
</ul>
{include file="footer.tpl"}
