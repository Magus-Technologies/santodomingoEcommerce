<?php
session_start();
session_destroy();
header("Location: http://localhost/public_html/CYM/");
