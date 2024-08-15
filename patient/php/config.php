<?php
    $conn = mysqli_connect("localhost","root","","wad",3307);
    if(!$conn)
    {
        echo "Connection failed".mysqli_connect_error() or die();
    }