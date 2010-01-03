{include file="header.tpl"}
{if $my_id == $their_id}
<script type="text/javascript">
    {literal}
        function showForm() {
            if(req = newReq()) {
                alert("req = " + req);
            }
        }
    {/literal}
</script>
{/if}
<h1>Profile of {$user}</h1>
<div class="mailto"><a href="/nag/{$user}">nag {$user}</a></div>
{if $bio}
{$bio}
{else}
{$user} doesn't have a profile yet.
    {if $my_id == $their_id}
    [ <a href="/user/{$user}/profile/edit" onClick="showForm(); return false;">edit soon</a> ]
    {/if}
{/if}
{include file="footer.tpl"}
