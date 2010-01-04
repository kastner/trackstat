<?xml version="1.0" encoding="UTF-8"?>
<statuses type="array">
{foreach from="$updates" item="update"}
{include file="twitter_status.tpl"}
{/foreach}
</statuses>


