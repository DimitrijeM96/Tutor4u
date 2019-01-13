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
        <div class="container mt-3 mb-3">
            <div class="row justify-content-center align-items-center">
                <form id="RegistrationForm" class="col-4" method="POST">
                    <div class="form-group">
                        <label for="passowrd">Registriraj se kot:</label>
                        <div class="float-right">
                            <p id="RegistrationAs" class="d-inline-block">Študent</p>
                            <label class="switch d-inline-block">
                                <input id="RegistrationAsCheckbox" type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Ime:</label>
                        <input name="name" type="text" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Priimek:</label>
                        <input name="lastname" type="text" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input name="email" placeholder="janez@gmail.com" type="text" class="form-control" required/>
                    </div>
                    <div id="TelephoneDiv" class="form-group d-none">
                        <label for="telephone">Telefon:</label>
                        <input name="telephone" placeholder="070 123 456" type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label for="postNumber">Poštna številka:</label>
                        <input name="postNumber" type="text" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="street">Ulica:</label>
                        <input name="street" type="text" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="streetNubmer">Hišna številka:</label>
                        <input name="streetNumber" type="text" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="passowrd">Geslo:</label>
                        <input name="password" type="password" class="form-control" autocomplete="on"/>
                    </div>
                    <input type="submit" value="Registracija" id="RegistrationButton" class="btn btn-primary"/>
                </form>
            </div>
        </div>
    </body>

</html>