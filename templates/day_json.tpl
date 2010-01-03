addTs([{foreach from="$entries" item="entry" name="ents"}
{ldelim}"t":"{$entry.var}","v":"{$entry.value}","d":"{$date}"{rdelim}{if !$smarty.foreach.ents.last},{/if}{foreachelse} {ldelim}{rdelim}{/foreach}]);
