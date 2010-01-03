{include file="header.tpl"}
<form method="post" id="newuserform" action="/sendnag">
    <input type="hidden" name="user" value="{$user}"/>
    <label>To:</label><input type="input" disabled="true" id="username" name="user" value="{$user}" /><br/><br/>
    <label>Subject:</label><input type="text" id="subject" name="subject" value="{$subject}" /><br/><br/>
    <label>Body:</label><textarea id="body" name="body" cols="20" rows="10">{$body}</textarea><br/>
    <input type="submit" value="send nag"/>
</form>
{include file="footer.tpl"}
