<?php
session_start();
if (session_destroy()) {
    echo 200;
} else {
    echo 500;
}
