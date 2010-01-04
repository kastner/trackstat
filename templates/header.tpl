<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>{$title|default:"trackstat.us - your anything tracker"}</title>
    <meta name="description" content="A place to track stuff" />
    <link rel="Stylesheet" href="{$base}/css/mayday.css" type="text/css" media="screen" />
    <script type="text/javascript">
        var my_id = "{$my_id}";
        var page = "{$smarty.server.PHP_SELF|replace:"/":""}";
    </script>
    <script type="text/javascript" src="{$base}/js/main.js"></script>
    {literal}
    <script type="text/javascript"><!--//--><![CDATA[//><!--
    /* suckerfish by HtmlDOG*/

    sfHover = function() {
        var sfEls = document.getElementById("nav").getElementsByTagName("LI");
        for (var i=0; i<sfEls.length; i++) {
            sfEls[i].onmouseover=function() {
                this.className+=" sfhover";
            }
            sfEls[i].onmouseout=function() {
                this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
            }
        }
    }
    if (window.attachEvent) window.attachEvent("onload", sfHover);

    //--><!]]></script>
    {/literal}
</head>
<body>
    <div id="top">
        <div id="logo">
            <a href="{$base}/">track<span class="status">stat.us</span></a>
        </div>
        <ul id="nav">
            <li><a href="/">Home</a></li>
            <li><a href="/contest">Contests</a>
            {include file="contests.txt"}

            </li>
            <li><a href="/users">Users</a></li>
            <li><a href="/latest">Newest</a></li>
            {if !$my_id}

            <li><a href="/login">Log in</a></li>
            <li><a href="/newuser">Signup</a></li>
            {else}

            <li><a href="/user/{$username}">{$username}</a></li>
            <li><a href="/user/{$username}/today">Today</a></li>
            <li><a href="/logout">Logout</a></li>
            {/if}

        </ul>
    </div>
    <div id="main">
        {foreach from="$errors" item="error"}
        <div class="error">
            {$error}
        </div>
        {/foreach}


