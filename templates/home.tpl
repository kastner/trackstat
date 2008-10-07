{include file="header.tpl"}
<h1>Welcome {if $my_id} back {/if}to trackstat.us</h1>
{if $my_id}
<h2>Jump to <a href="/user/{$username}">Your page</a> and start tracking!</h2>
{/if}
This is a place to track your stats on anything!<br />
Here's how it works:
<ol>
    <li><a href="/newuser">Signup</a> for a free account</li>
    <li>Click on "new variable", type anything trackable in the first box (some ideas: pushups, situps, stairs)</li>
    <li>Enter in the number you did in the second box*</li>
    <li>hit "add"</li>
</ol>
That's it!<br />
<span style="font-size: small;">* only numbers can go in the value field</span><br/>
trackstat.us is a way for you to track your progress in anything you want to measure - from anywhere with internet access. Anything that is measured and watched, improves!
<br/>
If you find any bugs, have any suggestions or questions, drop me a line at <a href="mailto:kastner@gmail.com">kastner@gmail.com</a>
{include file="footer.tpl"}
