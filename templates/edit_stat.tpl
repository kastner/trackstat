{include file="header.tpl"}
<h2>Edit stat</h2>
{if $stat}
<form action="/update" method="POST">
    <input type="hidden" name="id" value="{$stat.id}"/>
    <fieldset>
        <legend>Stat</legend>
        <input type="text" name="var" value="{$stat.var}" size="20" maxlength="100"/>
        <input type="text" name="value" value="{$stat.value}" size="4" maxlength="10"/>
    </fieldset>
    <fieldset>
        <legend>Date entered</legend>
        {html_select_date field_array="added" start_year=+2 end_year=-1 time=$stat.added} @
        {html_select_time field_array="added" use_24_hours=false display_seconds=false time=$stat.added}<br/>
        note: you can not make the date before the date you joined.
    </fieldset>
    <fieldset>
        <legend>Extra</legend>
        <label for="hidden">Hidden:</label>
        <input type="checkbox" id="hidden" name="hidden" value="1" {if $stat.hidden == 1}checked{/if}/>
    </fieldset>
    <br/>
    <input type="submit" value="update"/>
</form>
{/if}
{include file="footer.tpl"}
