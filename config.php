<?php
    define("APP_NAME", "Tutor4u");
    define("IMAGES_URL", "static/images/");
    define("LOGOS_URL", "static/logos/");
    define("CSS_URL", "static/css/");
    define("JS_URL", "static/js/");
    define("INCLUDES_URL", "includes/");

    if(isset($_POST["url"]) && !empty($_POST["url"])){
        if(isset($_POST["type"]) && !empty($_POST["type"]) && $_POST["type"] == "login"){
            Call_API_Login($_POST["url"]);
        }else if(isset($_POST["type"]) && !empty($_POST["type"]) && $_POST["type"] == "registration"){
            Call_API_Registration($_POST["url"]);
        }else if(isset($_POST["type"]) && !empty($_POST["type"]) && $_POST["type"] == "PasswordChange"){
            Call_API($_POST["url"]);
        }else if(isset($_POST["type"]) && !empty($_POST["type"]) && $_POST["type"] == "TakeTermin"){
            Call_API($_POST["url"]);
        }else if(isset($_POST["type"]) && !empty($_POST["type"]) && $_POST["type"] == "Grade"){
            Call_API($_POST["url"]);
        }else if(isset($_POST["type"]) && !empty($_POST["type"]) && $_POST["type"] == "DeleteTermin"){
            Call_API($_POST["url"]);
        }else if(isset($_POST["type"]) && !empty($_POST["type"]) && $_POST["type"] == "AddTermin"){
            Call_API_Add_Termin($_POST["url"], $_POST["DateTime"]);
        }else if(isset($_POST["type"]) && !empty($_POST["type"]) && $_POST["type"] == "AddSubject"){
            Call_API($_POST["url"]);
        }
    }

    function Call_API_Add_Termin($url, $DateTime){
        $DateTime2 = DateTime::createFromFormat('Y-m-d\TH:i', $DateTime);
        $DateFormated = $DateTime2->format('d-m-Y H-i');
        $DateFormated2 = str_replace(' ', '%20', $DateFormated);
        $url2 = $url.$DateFormated2;
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url2,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $responseData = json_decode($response, true);
        
        $err = curl_error($curl);
        curl_close($curl);
        return $responseData;
    }

    function Call_API_Login($url){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $responseData = json_decode($response, true);
        $result = $responseData[0]["result"];
        if($result == "1"){
            session_start();
            if(!isset($_SESSION["user"])){
                $_SESSION["TypeOfUser"] = $_POST["user"];
                $_SESSION["user"] = $responseData[0]["name"]." ".$responseData[0]["lastname"];
                $_SESSION["name"] = $responseData[0]["name"];
                $_SESSION["lastname"] = $responseData[0]["lastname"];
                $_SESSION["email"] = $responseData[0]["mail"];
                $_SESSION["houseNumber"] = $responseData[0]["houseNumber"];
                $_SESSION["postNumber"] = $responseData[0]["postNumber"];
                $_SESSION["street"] = $responseData[0]["street"];
                $_SESSION["UserID"] = $responseData[0]["id"];
            }
        }
        $err = curl_error($curl);
        curl_close($curl);
        echo $result;
    }

    function Call_API_Registration($url){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $responseData = json_decode($response, true);
        $result = $responseData[0]["result"];
        
        $err = curl_error($curl);
        curl_close($curl);
        echo $result;
    }

    function Call_API($url){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $responseData = json_decode($response, true);
        
        $err = curl_error($curl);
        curl_close($curl);
        return $responseData;
    }
?>