<?php
require_once("config.php");
require_once(INCLUDES_URL."check_session.php");
$_SESSION["Page"] = "Subjects";
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once(INCLUDES_URL."head.php"); ?>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "index.css" ?>">
        <script src="<?= JS_URL.'AppController.js'?>"></script>
    </head>
    <body>
        <?php require(INCLUDES_URL."navbar.php"); ?>
        <div class="container h-100">
                <?php
                    if(!isset($_GET["Predmet"])){
                        echo '<div class="row mt-lg-5 mt-3">';
                        $ResponseData = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/Subject");
                        foreach($ResponseData as $Tutor){
                            ?>
                            <figure class="Predmet figure col-lg-3 col-6 py-2 rounded" id="<?= $Tutor['id'] ?>">
                                <img src="<?= IMAGES_URL.$Tutor["name"].'.png'?>" class="figure-img img-fluid rounded" alt="Slika tutorja">
                                <figcaption class="figure-caption text-left">
                                    Predmet: <b id="PredmetName"><?= $Tutor["name"] ?></b> <br>
                                    Prostih terminov: <b><?= $Tutor["freeTermin"] ?></b> <br>
                                </figcaption>
                            </figure>
                            <?php
                        }
                        echo '</div>';
                    }else{
                        $ResponseData = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/TerminInfoBySubjectId/".$_GET["PredmetID"]);
                        ?>
                        <div class="row mt-lg-5 mt-3 justify-content-center">
                            <div class="col-12 text-center">
                                <h3 class="d-inline">Prosti termini pri predmetu <?= $_GET["Predmet"] ?> </h3>
                            </div>
                        </div>
                        <div class="row mt-lg-5 mt-3">
                        <?php
                        foreach($ResponseData as $Tutor){
                            $Grade = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/Grade/".$Tutor["idTutor"]);

                            $DateTime = DateTime::createFromFormat('d-m-Y H-i', $Tutor["date"]);
                            $DateTime2 = DateTime::createFromFormat('d-m-Y H-i', Date('d-m-Y H-i'));
                            $DateFormated = $DateTime->format('d.m.Y');
                            $TimeFormated = $DateTime->format('H:i');
                            if($DateTime >= $DateTime2){
                            ?>
                            <figure class="Termini figure col-lg-3 col-6 py-2 rounded" id="<?= $Tutor['idTermin'] ?>">
                                <img src="<?= IMAGES_URL. 'placeholder2.png'?>" class="figure-img img-fluid rounded" alt="Slika tutorja">
                                <figcaption class="figure-caption text-left">
                                    Datum: <p class="mb-0 d-inline" id="TextDatum"><b> <?= $DateFormated ?></b></p><br>
                                    Čas: <p class="mb-0 d-inline" id="TextCas"><b> <?= $TimeFormated ?></b></p><br>
                                    Ocena: <p class="mb-0 d-inline" id="TextOcena"><b> <?= $Grade[0]["grade"] ?></b></p><br>
                                    Ime: <p class="mb-0 d-inline" id="TextIme"><b><?= $Tutor["tutorName"]. " " .$Tutor["tutorLastname"] ?></b></p><br>
                                    Cena: <p class="mb-0 d-inline" id="TextCena"><b><?= $Tutor["price"] ?>€</b> <br></p>
                                </figcaption>
                            </figure>
                            <?php }
                        }
                    }
                ?>
            </div>
            <?php
                if(isset($_GET["Predmet"])){
                ?>
                    <div class="modal" id="RezervirajTerminModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Rezervacija termina</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="mb-0"> Datum termina: </p>
                                <p style="font-weight: bold;" id="ModalDatum"> </p>
                                <p class="mb-0"> Čas termina: </p>
                                <p style="font-weight: bold;" id="ModalCas"> </p>
                                <p class="mb-0"> Ocena tutorja: </p>
                                <p style="font-weight: bold;" id="ModalOcena"> </p>
                                <p class="mb-0"> Ime in priimek tutorja: </p>
                                <p style="font-weight: bold;" id="ModalTutor"> </p>
                                <p class="mb-0"> Cena termina: </p>
                                <p style="font-weight: bold;" class="d-inline" id="ModalCena"> </p>
                                
                                <div id="TerminSuccess" class="alert alert-success d-none" role="alert">
                                    Vspešno ste rezervirali ta termin.
                                </div>
                                <div id="TerminFail" class="alert alert-danger d-none" role="alert">
                                    Prišlo je do napake, prosim poskusite še enkrat!
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="UserIDModal" value="<?= $_SESSION["UserID"] ?>" />
                                <button type="button" class="btn btn-primary" id="RezervirajTerminButton">Potrdi rezervacijo</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Nazaj</button><br>
                                
                            </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
            ?>
        </div>
    </body>

</html>