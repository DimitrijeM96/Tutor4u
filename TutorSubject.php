<?php
require_once("config.php");
require_once(INCLUDES_URL."check_session.php");
$_SESSION["Page"] = "TutorSubject";
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once(INCLUDES_URL."head.php"); ?>
        <script src="<?=JS_URL.'loginController.js'?>"></script>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
        <script src="<?= JS_URL.'AppController.js'?>"></script>
    </head>
    <body>
        <?php require(INCLUDES_URL."navbar.php"); ?>
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <form class="col-4" method="POST">
                    <div class="form-group">
                        <label for="Predmet">Izberi predmet:</label>
                        <select id="PredmetSelect" name="Predmet" class="form-control">
                            <?php
                                $Predmeti = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/SubjectList");
                                foreach($Predmeti as $Predmet){?>
                                    <option id="<?= $Predmet["id"] ?>" value="<?= $Predmet["name"] ?>"><?= $Predmet["name"] ?></option>                                    
                                   <?php 
                                }
                            ?>
                        </select>

                        <input type="hidden" id="TutorID" value="<?= $_SESSION["UserID"] ?>"/>

                        <label for="Cena">Cena termina (v evrih):</label>
                        <input type="number" id="CenaPredmeta" class="form-control" required/>
                    </div>
                    <div id="TerminFail" class="alert alert-danger d-none" role="alert">
                        Prišlo je do napake, prosimo poskusite še enkrat!
                    </div>
                    <div id="TerminSuccess" class="alert alert-success d-none" role="alert">
                        Vspešno ste dodali predmet!
                    </div>
                    <input value="Potrdi" type="submit" id="AddSubjectButton" class="btn btn-primary"/>
                </form>
            </div>
        </div>
    </body>

</html>