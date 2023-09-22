<?php
    include "config.php";
    $original_url = mysqli_real_escape_string($conn, $_POST['original_url']);
    //if orifinal url is not empty and the user entered url is a valid url
    if(!empty($original_url) && filter_var($original_url, FILTER_VALIDATE_URL)){
        $ran_url = substr(md5(microtime()), rand(0, 26), 5);
        //checking random generated url already exit in db or not
        $sql = mysqli_query($conn, "SELECT * FROM url WHERE shorten_url = '{$ran_url}'");
        if(mysqli_num_rows($sql) > 0){
            echo "Something went wrong. Please regenerate url again!";
        }else{
            //let's insert the user typed url into table with short url
            $sql2 = mysqli_query($conn, "INSERT INTO url (original_url, shorten_url, clicks) 
                                         VALUES ('{$original_url}', '{$ran_url}', '0')");
            if($sql2){//if data inserted successfully
                $sql3 = mysqli_query($conn, "SELECT shorten_url FROM url WHERE shorten_url = '{$ran_url}'");
                if(mysqli_num_rows($sql3) > 0){
                    $shorten_url = mysqli_fetch_assoc($sql3);
                    echo $shorten_url['shorten_url'];
                }
            }
        }
    }else{
        echo "$original_url - This is not a valid URL!";
    }
?>