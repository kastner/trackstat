{include file="header.tpl"}
<script type="text/javascript">
    <!--
    {literal}
    function checkField(field) {
        //alert(field.id + " is already taken... by " + field.value);
    }
    {/literal}
    -->
</script>
{if $error}
<h2>{$error}</h2>
{/if}
<form id="newuserform" action="/newuser" method="POST">
    <label for="username">Username: </label><input onBlur="checkField(this);" type="text" size="25" id="username" name="username" value="{$username}" /><br />
    <label for="email">Email: </label><input type="text" size="25" id="email" name="email" value="{$email}" /><br />
    <label for="name">Name (optional): </label><input type="text" size="25" id="name" name="name" /><br />
    <label for="password">Password: </label><input type="password" size="25" id="password" name="password" /><br />
    <label for="password2">Again: </label><input type="password" size="25" id="password2" name="password2" /><br />
    <label for="tz">Timezone: </label>
    <select name="tz" id="tz">
        <option value="-12:00">-12:00 International Date Line West</option>
        <option value="-11:00">-11:00 Midway Island, Samoa</option>
        <option value="-10:00">-10:00 Hawaii</option>
        <option value="-09:00">-09:00 Alaska</option>
        <option value="-08:00">-08:00 Pacific Time (US &amp; Canada); Tijuana</option>

        <option value="-07:00">-07:00 Arizona</option>
        <option value="-07:00">-07:00 Chihuahua, La Paz, Mazatlan</option>
        <option value="-07:00">-07:00 Mountain Time (US &amp; Canada)</option>
        <option value="-06:00">-06:00 Central America</option>
        <option value="-06:00">-06:00 Central Time (US &amp; Canada)</option>

        <option value="-06:00">-06:00 Guadalajara, Mexico City, Monterrey</option>
        <option value="-06:00">-06:00 Saskatchewan</option>
        <option value="-05:00">-05:00 Bogota, Lima, Quito</option>
        <option value="-05:00" selected>-05:00 Eastern Time (US &amp; Canada)</option>
        <option value="-05:00">-05:00 Indiana (East)</option>

        <option value="-04:00">-04:00 Atlantic Time (Canada)</option>
        <option value="-04:00">-04:00 Caracas, La Paz</option>
        <option value="-04:00">-04:00 Santiago</option>
        <option value="-03:30">-03:30 Newfoundland</option>
        <option value="-03:00">-03:00 Brasilia</option>
        <option value="-03:00">-03:00 Buenos Aires, Georgetown</option>

        <option value="-03:00">-03:00 Greenland</option>
        <option value="-02:00">-02:00 Mid-Atlantic</option>
        <option value="-01:00">-01:00 Azores</option>
        <option value="-01:00">-01:00 Cape Verde Is.</option>
        <option value="+00:00">+00:00 Casablanca, Monrovia</option>
        <option value="+00:00">+00:00 GMT: Dublin, Edinburgh, Lisbon, London</option>

        <option value="+01:00">+01:00 Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
        <option value="+01:00">+01:00 Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
        <option value="+01:00">+01:00 Brussels, Copenhagen, Madrid, Paris</option>
        <option value="+01:00">+01:00 Sarajevo, Skopje, Warsaw, Zagreb</option>
        <option value="+01:00">+01:00 West Central Africa</option>
        <option value="+02:00">+02:00 Athens, Beirut, Istanbul, Minsk</option>

        <option value="+02:00">+02:00 Bucharest</option>
        <option value="+02:00">+02:00 Cairo</option>
        <option value="+02:00">+02:00 Harare, Pretoria</option>
        <option value="+02:00">+02:00 Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
        <option value="+02:00">+02:00 Jerusalem</option>
        <option value="+03:00">+03:00 Baghdad</option>

        <option value="+03:00">+03:00 Kuwait, Riyadh</option>
        <option value="+03:00">+03:00 Moscow, St. Petersburg, Volograd</option>
        <option value="+03:00">+03:00 Nairobi</option>
        <option value="+03:30">+03:30 Tehran</option>
        <option value="+04:00">+04:00 Abu Dhabi, Muscat</option>
        <option value="+04:00">+04:00 Baku, Tbilisi, Yerevan</option>

        <option value="+04:30">+04:30 Kabul</option>
        <option value="+05:00">+05:00 Ekaterinburg</option>
        <option value="+05:00">+05:00 Islamabad, Karachi, Tashkent</option>
        <option value="+05:30">+05:30 Chennai, Kolkata, Mumbai, New Delhi</option>
        <option value="+05:45">+05:45 Kathmandu</option>
        <option value="+06:00">+06:00 Almaty, Novosibirsk</option>

        <option value="+06:00">+06:00 Astana, Dhaka</option>
        <option value="+06:00">+06:00 Sri Jayawardenepura</option>
        <option value="+06:30">+06:30 Rangoon</option>
        <option value="+07:00">+07:00 Bangkok, Hanoi, Jakarta</option>
        <option value="+07:00">+07:00 Krasnoyarsk</option>
        <option value="+08:00">+08:00 Beijing, Chongqing, Hong Kong, Urumqi</option>

        <option value="+08:00">+08:00 Irkstsk, Ulaan Bataar</option>
        <option value="+08:00">+08:00 Kuala Lumpur, Singapore</option>
        <option value="+08:00">+08:00 Perth</option>
        <option value="+08:00">+08:00 Taipei</option>
        <option value="+09:00">+09:00 Osaka, Sapporo, Tokyo</option>
        <option value="+09:00">+09:00 Seoul</option>

        <option value="+09:00">+09:00 Yakutsk</option>
        <option value="+09:30">+09:30 Adelaide</option>
        <option value="+09:30">+09:30 Darwin</option>
        <option value="+10:00">+10:00 Brisbane</option>
        <option value="+10:00">+10:00 Canberra, Melbourne, Sydney</option>
        <option value="+10:00">+10:00 Guam, Port Moresby</option>

        <option value="+10:00">+10:00 Hobart</option>
        <option value="+10:00">+10:00 Vladivostok</option>
        <option value="+11:00">+11:00 Magadan, Soloman Is., New Caledonia</option>
        <option value="+12:00">+12:00 Auckland, Wellington</option>
        <option value="+12:00">+12:00 Fiji, Kamchatka, Marshall Is.</option>
        <option value="+13:00">+13:00 Nuku'alofa</option>

    </select><br />
    <label for="dst">Daylight Savings: </label><input checked type="checkbox" name="dst" value="1" /><br />
    <br />
    <input type="submit" value="Add Me!" />
</form>
<script type="text/javascript">
    <!--
    {literal}
        document.getElementById("username").focus();
    {/literal}
    -->
</script>
{include file="footer.tpl"}
