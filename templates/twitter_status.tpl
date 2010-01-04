<status>
    <created_at>{$update.added|date_format:"%a %b %d %H:%M:%S %z %Y"}</created_at>
    <id>{$update.id}</id>
    <text>{$update.var}: {$update.value}</text>
    <source>web</source>
    <truncated>false</truncated>
    <user>
        <id>{$update.user_id}</id>
        <name>{$update.name}</name>
        <location></location>
        <description></description>
        <screen_name>{$update.username}</screen_name>
        <profile_image_url>http://www.gravatar.com/avatar/{$update.email_hash}.jpg</profile_image_url>
        <url></url>
        <protected>false</protected>
    </user>
</status>
