<?php
if (!file_exists("./install/install.lock")) {
    header("location:./install/step1.php");
    exit();
} else {
    header("location:home/index.php");
}