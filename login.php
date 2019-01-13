<?php
    require_once("config.php");
    session_start();
    if(isset($_SESSION["user"])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once(INCLUDES_URL."head.php"); ?>
        <script src="<?=JS_URL.'loginController.js'?>"></script>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
    </head>

    <body>
        <div class="container h-100">
            <div class="row w-100 text-center justify-content-center align-items-center">
                
            </div>
            <div class="row h-100 justify-content-center align-items-center">
                
                <form class="col-4" method="POST">
                    <img class="img-responsive" src="<?= LOGOS_URL."tutor4u.png" ?>">
                    <div class="form-group">
                        <label for="username">Uporabniško ime:</label>
                        <input name="username" placeholder="janez@gmail.com" type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="passowrd">Geslo:</label>
                        <input name="password" type="password" class="form-control" autocomplete="on"/>
                    </div>
                    <div id="LoginFailedAlert" class="alert alert-danger d-none" role="alert">
                        Uporabniško ime ali geslo ni točno.
                    </div>
                    <input type="submit" value="Login" id="LoginButton" class="btn btn-primary"/>
                    <div class="float-right">
                        <p id="LoginAs" class="d-inline-block">Študent</p>
                        <label class="switch d-inline-block">
                            <input id="LoginAsCheckbox" type="checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <a href="registracija.php" class="btn btn-info d-block mt-3">Registracija</a>
                </form>
            </div>
        </div>
    </body>

</html>