<?php
$notifications_file = "notifications.json";
$notifications = file_exists($notifications_file) ? json_decode(file_get_contents($notifications_file), true) : [];

echo "<div style='background:#fff3e0;padding:15px;border-radius:8px;margin-bottom:15px'>";
echo "<h3>🔔 الإشعارات</h3>";
foreach($notifications as $n){
    if($n['for']=='all' || $n['for']==$_SESSION['username']){
        echo "<p>[{$n['date']}] {$n['message']}</p>";
    }
}
echo "</div>";
?>