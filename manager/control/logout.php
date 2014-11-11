<?php
session_start();
session_destroy();
echo "<script>location.href='../manager.php'</script>";
?>