{include file="header.tpl"}
<h1>List of users</h1>
<ul>
{foreach item="user" from="$users"}
    <li><a href="/user/{$user.username}">{$user.username}</a></li>
{foreachelse}
No users.
{/foreach}
{include file="footer.tpl"}
