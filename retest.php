<?php
$command2 = "sudo python3 /var/www/html/hello.py";
exec($command2,$output);
print "$output[0]";
?>