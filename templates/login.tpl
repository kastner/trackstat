{include file="header.tpl"}
    <br />
    {if !$my_id}
    <form id="newuserform" action="validate.php" method="post">
        <label for="email">Email: </label><input type="email" size="24" id="email" name="email" value="{$smarty.request.email}" /><br />
        <label for="password">Password: </label><input type="password" size="24" id="password" name="password" /><br />
        <input type="submit" value="Log in" />
    </form>
    <br />
    Or
    <br />
    <a href="/newuser">New Account</a> (it's free and fast!)<br />
    <script type="text/javascript">
        document.getElementById("email").focus();
    </script>
    {else}
    You are already logged in.
    {/if}
{include file="footer.tpl"}
