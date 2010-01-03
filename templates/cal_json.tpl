addTsStat([{foreach from="$vars_all" item="entry" name="ents"}
{ldelim}"t":"{$entry.var}","v":"{$entry.total}","d":"{$entry.day_added}"{rdelim}{if !$smarty.foreach.ents.last},{/if}{foreachelse} {ldelim}{rdelim}{/foreach}]);
