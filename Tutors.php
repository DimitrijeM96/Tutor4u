<?php
require_once("config.php");
require_once(INCLUDES_URL."check_session.php");
$_SESSION["Page"] = "Tutors";
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
                    if(!isset($_GET["TutorID"])){
                ?>      <div class="row mt-lg-5 mt-3"> <?php
                        $ResponseData = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/Tutor");
                        foreach($ResponseData as $Tutor){
                            $link = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/Grade/".$Tutor["idTutor"];
                            $Grade = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/Grade/".$Tutor["idTutor"]);
                            ?>
                            <figure class="TutorFigure figure col-lg-3 col-6 py-2 rounded" id="<?= $Tutor['idTutor'] ?>">
                                <img src="<?= IMAGES_URL. 'placeholder2.png'?>" class="figure-img img-fluid rounded" alt="Slika tutorja">
                                <figcaption class="figure-caption text-left">
                                    Mesto: <b><?= $Tutor["address"] ?></b> <br>
                                    Ocena: <b><?= $Grade[0]["grade"] ?></b> <br>
                                    Ime in priimek: <b id="ImeInPriimekTutorja"><?= $Tutor["name"]. " " .$Tutor["surname"] ?></b> <br>
                                </figcaption>
                            </figure>
                            <?php
                        }
                        echo '</div>';
                    }else{
                        $ResponseData = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/subjectITeach/".$_GET["TutorID"]);
                        $Grade = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/Grade/".$_GET["TutorID"]);
                        $ProstiTermini = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/MyTerminTutor/".$_GET["TutorID"]);
                        $PodatkiTutor = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/Tutor/".$_GET["TutorID"]);
                        ?>
                        <div class="row mt-lg-5 mt-3 justify-content-center">
                            <div class="col-3 py-1 text-center TutorNav ActiveTutor" id="PredmetiTutorja"> Vsi predmeti tutorja </div>
                            <div class="offset-1 col-3 py-1 text-center TutorNav" id="ProstiTerminiTutorja"> Prosti termini tutorja </div>
                            <div class="offset-1 col-3 py-1 text-center TutorNav" id="PodatkiTutorja"> Podatki o tutorju </div>
                        </div>

                        <!-- Predmeti tutorja -->

                        <div class="row mt-lg-5 mt-3 justify-content-center" id="PredmetiTutorjaRow">
                        <?php
                        foreach($ResponseData as $Tutor){
                            ?>
                            <figure class="PredmetiTutorja figure col-lg-4 col-6 py-2 rounded" id="<?= $Tutor['id'] ?>">
                                <img src="<?= IMAGES_URL.$Tutor["name"].'.png'?>" class="figure-img img-fluid rounded" alt="Slika tutorja">
                                <figcaption class="figure-caption text-left">
                                    Predmet: <p class="mb-0" id="TextPredmet"><b> <?= $Tutor["name"] ?></b></p>
                                    Prostih terminov: <p class="mb-0 d-inline" id="TextProstihTerminov"><b> <?= $Tutor["freeTermin"] ?></b></p><br>
                                    Cena: <p class="mb-0 d-inline" id="TextCena"><b><?= $Tutor["price"] ?>€</b> <br></p>
                                </figcaption>
                            </figure>
                            <?php
                        }
                        ?>
                        </div>

                        <!-- Prosti termini tutorja -->

                        <div class="row mt-lg-5 mt-3 justify-content-center d-none" id="ProstiTerminiTutorjaRow">
                        <?php
                        foreach($ProstiTermini as $Termin){
                            $DateTime = DateTime::createFromFormat('d-m-Y H-i', $Termin["date"]);
                            $DateToday = DateTime::createFromFormat('d-m-Y H-i', Date('d-m-Y H-i'));
                            $DateFormated = $DateTime->format('d.m.Y');
                            $TimeFormated = $DateTime->format('H:i');
                            if($DateTime >= $DateToday){
                            ?>
                            <figure class="Termini figure col-lg-4 col-6 py-2 rounded" id="<?= $Termin['idTermin'] ?>">
                                <img src="<?= IMAGES_URL.$Termin["subject"].'.png'?>" class="figure-img img-fluid rounded" alt="Slika tutorja">
                                <figcaption class="figure-caption text-left">
                                    Predmet: <p class="mb-0" id="TextPredmet"><b> <?= $Termin["subject"] ?></b></p>
                                    <p class="d-none" id="TextIme"><?= $PodatkiTutor[0]["name"]." ".$PodatkiTutor[0]["surname"] ?></p>
                                    <p class="d-none" id="TextOcena"><?= $Grade[0]["grade"] ?></p>
                                    Datum: <p class="mb-0" id="TextDatum"><b> <?= $DateFormated ?></b></p>
                                    Čas: <p class="mb-0 d-inline" id="TextCas"><b> <?= $TimeFormated ?></b></p><br>
                                    Cena: <p class="mb-0 d-inline" id="TextCena"><b><?= $Termin["price"] ?>€</b> <br></p>
                                </figcaption>
                            </figure>
                            <?php }
                        }
                        ?>
                        </div>

                        <!-- Podatki tutorja -->

                        <div class="row mt-lg-5 mt-3 justify-content-center d-none" id="PodatkiTutorjaRow">
                            <figure class="PredmetiTutorja figure ml-3 col-4 py-2 rounded" id="<?= $Termin['idTermin'] ?>">
                                <img src="<?= IMAGES_URL.'placeholder2.png'?>" class="figure-img img-fluid rounded" alt="Slika tutorja">
                                <figcaption class="figure-caption text-left">
                                    Ime in priimek: <p class="mb-0 d-inline" id="TextPredmet"><b> <?= $PodatkiTutor[0]["name"]." ".$PodatkiTutor[0]["surname"] ?></b></p><br>
                                    Email: <p class="mb-0 d-inline" id="TextDatum"><b> <?= $PodatkiTutor[0]["mail"] ?></b></p><br>
                                    Mobitel: <p class="mb-0 d-inline" id="TextCas"><b> <?= $PodatkiTutor[0]["phone"] ?></b></p><br>
                                    Povprečna ocena: <p class="mb-0 d-inline" id="TextCena"><b> <?= $Grade[0]["grade"] ?></b> <br></p>
                                </figcaption>
                            </figure>
                        </div>
                        <?php
                    }
                ?>
            </div>
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
                                <p style="font-weight: bold;" id="ModalOcena"> <?= $PodatkiTutor[0]["grade"] ?> </p>
                                <p class="mb-0"> Ime in priimek tutorja: </p>
                                <p style="font-weight: bold;" id="ModalTutor"> <?= $PodatkiTutor[0]["name"]." ".$PodatkiTutor[0]["surname"] ?> </p>
                                <p class="mb-0"> Cena termina: </p>
                                <p style="font-weight: bold;" class="d-inline" id="ModalCena"> </p>
                                
                                <div id="TerminSuccess" class="alert alert-danger d-none" role="alert">
                                    Prišlo je do napake, prosimo poskusite še enkrat!
                                </div>
                                <div id="TerminFail" class="alert alert-success d-none" role="alert">
                                    Vspešno ste rezervirali ta termin.
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
        </div>
    </body>

</html>