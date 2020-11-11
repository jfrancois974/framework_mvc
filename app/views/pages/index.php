<?php

foreach ($data['users'] as  $user) {
    echo "Information : ";
    echo "<br>";
    echo "Nom : " . $user->user_name ;
    echo "<br>";
    echo "Email : " . $user->user_email; ;
}