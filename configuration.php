<?php
require_once("config.php");
require_once(INCLUDES_URL."check_session.php");
$_SESSION["Page"] = "configuration";
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once(INCLUDES_URL."head.php"); ?>
        <script src="<?=JS_URL.'loginController.js'?>"></script>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
    </head>
    <body>
        <?php require(INCLUDES_URL."navbar.php"); ?>
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <form class="col-4" method="POST">
                    <div class="form-group">
                        <label for="password">Vnesi novo geslo:</label>
                        <input name="password" type="password" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label for="passowrdConf">Ponovno vnesi novo geslo:</label>
                        <input name="passwordConf" type="password" class="form-control" autocomplete="on" required/>
                    </div>
                    <div id="PasswordDontMatchAlert" class="alert alert-danger d-none" role="alert">
                        Gesli se ne ujemata!
                    </div>
                    <div id="PasswordChanged" class="alert alert-success d-none" role="alert">
                        Vspešno ste spremenili svoje geslo.
                    </div>
                    <input type="hidden" value="<?= $_SESSION["TypeOfUser"] ?>" id="TypeOfUser" />
                    <input type="hidden" value="<?= $_SESSION["UserID"] ?>" id="UserID" />
                    <input value="Submit" id="ChangePasswordButton" class="btn btn-primary"/>
                </form>
            </div>
        </div>
    </body>

</html>