<?php
require_once("config.php");
require_once(INCLUDES_URL."check_session.php");
$_SESSION["Page"] = "index";
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once(INCLUDES_URL."head.php"); ?>
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "index.css" ?>">
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "dataTables.bootstrap4.min.css" ?>">
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "buttons.dataTables.min.css" ?>">
        <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "responsive.dataTables.min.css" ?>">
        
        <script src="<?= JS_URL.'AppController.js'?>"></script>

        <!-- DataTables -->
        <script src="<?= JS_URL.'jquery.dataTables.min.js'?>"></script>
        <script src="<?= JS_URL.'dataTables.buttons.min.js'?>"></script>
        <script src="<?= JS_URL.'dataTables.bootstrap4.min.js'?>"></script>
        <script src="<?= JS_URL.'dataTables.responsive.min.js'?>"></script>
        <script src="<?= JS_URL.'buttons.flash.min.js'?>"></script>
        <script src="<?= JS_URL.'buttons.html5.min.js'?>"></script>
        <script src="<?= JS_URL.'pdfmake.min.js'?>"></script>
        <script src="<?= JS_URL.'buttons.print.min.js'?>"></script>
        <script src="<?= JS_URL.'jszip.min.js'?>"></script>
        <script src="<?= JS_URL.'vfs_fonts.js'?>"></script>
        <script src="<?= JS_URL.'buttons.colVis.min.js'?>"></script>
        <script src="<?= JS_URL.'date-eu.js'?>"></script>
        
        <script>
            $(document).ready(function() {
                var d = new Date();

                var month = d.getMonth()+1;
                var day = d.getDate();

                var FullDate = (day<10 ? '0' : '') + day + "." +
                    (month<10 ? '0' : '') + month + '.' +
                    d.getFullYear();
                var NDate = new Date(FullDate);
                $('#TerminiTable').DataTable({
                    <?php
                        $GreenRed = '"createdRow": function( row, data, dataIndex ) {
                        if ( data[3] == "Yes" ) {
                            row.style.backgroundColor = "#66ff66";
                        }else {
                            row.style.backgroundColor = "#ff9999";
                        }
                    },'; echo $GreenRed
                    ?>
                    "language": {
    							"url": "static/lang/Slovenian.json"
    						},
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copyHtml5',
                            exportOptions: {
                                columns: [ 0, 1, 2, 4, 5, 6 ]
                            }
                        },
                        {
                            extend: 'csv',
                            exportOptions: {
                                columns: [ 0, 1, 2, 4, 5, 6 ]
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: [ 0, 1, 2, 4, 5, 6 ]
                            }
                        },
                        {
                            extend: 'print',
                            exportOptions: {
                                columns: [ 0, 1, 2, 4, 5, 6 ]
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            exportOptions: {
                                columns: [ 0, 1, 2, 4, 5, 6 ]
                            }
                        }
                    ],
                    columnDefs: [
                        {
                            "targets": [ 3 ],
                            "visible": false,
                            "searchable": false
                        },
                        { 
                            type: 'date-eu', targets: 1
                        }
                    ],
                    "order": [[ 1, "desc" ]],
                    responsive: true
                });
            } );
        </script>
    </head>
    <body>
        <?php require(INCLUDES_URL."navbar.php"); ?>
        <div class="container">
            <?php
            if($_SESSION["TypeOfUser"] == "Student"){
                $Termini = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/MyTerminStudent/".$_SESSION["UserID"]);
            }else if($_SESSION["TypeOfUser"] == "Tutor"){
                $Termini = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/MyTerminTutor/".$_SESSION["UserID"]);
                $TerminiReserved = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/MyTerminTutorReserved/".$_SESSION["UserID"]);
            }
            ?>
            <div class="row mt-lg-5 mt-3 justify-content-center" id="VsiTermini">
            <table id="TerminiTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <?php if($_SESSION["TypeOfUser"] == "Student"){ ?>
                        <th>Predmet</th>
                        <th>Datum</th>
                        <th>Čas</th>
                        <th>DateBiggerThanToday</th>
                        <th>Tutor</th>
                        <th>Naslov</th>
                        <th>Cena</th>
                        <th>Oceni tutora</th>
                    <?php } else if($_SESSION["TypeOfUser"] == "Tutor"){ ?>
                            <th>Predmet</th>
                            <th>Datum</th>
                            <th>Čas</th>
                            <th>DateBiggerThanToday</th>
                            <th>Učenec</th>
                            <th>Rezervirano</th>
                            <th>Cena</th>
                            <th>Izbriši termin</th>
                    <?php } ?>
                </thead>
                <tbody>
            <?php
            foreach($Termini as $Termin){
                $TerminInfo = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/TerminInfoById/".$Termin["idTermin"]);
                $DateTime = DateTime::createFromFormat('d-m-Y H-i', $Termin["date"]);
                $DateTime2 = DateTime::createFromFormat('d-m-Y H-i', Date('d-m-Y H-i'));
                $DateFormated = $DateTime->format('d.m.Y');
                $TimeFormated = $DateTime->format('H:i');
                ?>
                <tr>
                    <td><?= $Termin["subject"] ?></td>
                    <td><?= $DateFormated ?></td>
                    <td><?= $TimeFormated ?></td>
                    <td>
                    <?php 
                        if($DateTime > $DateTime2){
                            $YesNo = "Yes";
                        }else{
                            $YesNo = "No";
                        }
                        echo $YesNo;
                    ?></td>
                    <?php if($_SESSION["TypeOfUser"] == "Student"){ ?>
                        <td><?= $Termin["tutorName"]. " " .$Termin["tutorLastname"] ?></td>
                    <?php } else{ echo "<td></td>"; } 
                    if($_SESSION["TypeOfUser"] == "Student"){ ?>
                    <td><?= $Termin["address"] ?></td>
                    <?php } else{ echo "<td>Ne</td>"; } ?>
                    <td><?= $TerminInfo[0]["price"] ?>€</td>
                    <td class="text-center">
                    <?php
                        if($YesNo == "No" && $_SESSION["TypeOfUser"] == "Student"){
                            ?>
                            <input type="button" id="<?= $Termin["idTermin"] ?>" class="btn btn-primary d-inline OceniTutorjaButton" value="Oceni">
                            <?php
                        }else if($_SESSION["TypeOfUser"] == "Tutor"){
                            ?>
                            <input type="button" id="<?= $Termin["idTermin"] ?>" class="btn btn-danger d-inline IzbrišiTerminButton" value="Izbriši">
                        <?php
                        }
                    ?>
                    </td>
                </tr>
                <?php
            }
            if($_SESSION["TypeOfUser"] == "Tutor"){
            foreach($TerminiReserved as $Termin){
                $TerminInfo = Call_API("http://apitutor.azurewebsites.net/RestServiceImpl.svc/TerminInfoById/".$Termin["idTermin"]);
                $DateTime = DateTime::createFromFormat('d-m-Y H-i', $Termin["date"]);
                $DateTime2 = DateTime::createFromFormat('d-m-Y H-i', Date('d-m-Y H-i'));
                $DateFormated = $DateTime->format('d.m.Y');
                $TimeFormated = $DateTime->format('H:i');
                ?>
                <tr>
                    <td><?= $Termin["subject"] ?></td>
                    <td><?= $DateFormated ?></td>
                    <td><?= $TimeFormated ?></td>
                    <td>
                    <?php 
                        if($DateTime > $DateTime2){
                            $YesNo = "Yes";
                        }else{
                            $YesNo = "No";
                        }
                        echo $YesNo;
                    ?></td>
                    <td><?= $Termin["studentName"] . " " . $Termin["studentLastname"] ?></td>
                    <td>Da</td>
                    <td><?= $TerminInfo[0]["price"] ?>€</td>
                    <td class="text-center">
                    <?php
                        if($YesNo == "No"){
                            ?>
                            <input type="button" id="<?= $Termin["idTermin"] ?>" class="btn btn-danger d-inline IzbrišiTerminButton" value="Izbriši">
                        <?php }
                            ?>
                        </td>
                </tr>
                <?php
            }
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                <?php if($_SESSION["TypeOfUser"] == "Student"){ ?>
                        <th>Predmet</th>
                        <th>Datum</th>
                        <th>Čas</th>
                        <th>DateBiggerThanToday</th>
                        <th>Tutor</th>
                        <th>Naslov</th>
                        <th>Cena</th>
                        <th>Oceni tutora</th>
                    <?php } else if($_SESSION["TypeOfUser"] == "Tutor"){ ?>
                        <th>Predmet</th>
                        <th>Datum</th>
                        <th>Čas</th>
                        <th>DateBiggerThanToday</th>
                        <th>Učenec</th>
                        <th>Rezervirano</th>
                        <th>Cena</th>
                        <th>Izbriši termin</th>
                    <?php } ?>
                </tr>
            </tfoot>
            </div>
        </div>
    </body>
            <?php if($_SESSION["TypeOfUser"] == "Student"){ ?>
            <div class="modal" id="OceniTutorjaModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Oceni tutorja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="col-4 offset-4">
                        <div class="form-group">
                            <label for="OcenaTutorjaInput">Ocena:</label>
                            <input name="OcenaTutorjaInput" id="OcenaTutorjaInput" type="number" min="1" max="5" class="form-control text-center" />
                        </div>
                        </div>
                        <div id="TerminSuccess" class="alert alert-success d-none" role="alert">
                            Vspešno ste ocenili tutorja.
                        </div>
                        <div id="TerminFail" class="alert alert-danger d-none" role="alert">
                            Prišlo je do napake, prosim poskusite še enkrat!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="OceniTutorjaButtonModal">Oceni tutorja</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nazaj</button><br>
                    </div>
                    </div>
                </div>
            </div>

            <?php } else if($_SESSION["TypeOfUser"] == "Tutor"){ ?>
            <div class="modal" id="IzbrisiTerminModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Izbriši termin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h5> Ali ste prepričani da želite izbrisati ta termin? </h5>
                        <div id="DeleteTerminSuccess" class="alert alert-success d-none" role="alert">
                            Vspešno ste izbrisali termin.
                        </div>
                        <div id="DeleteTerminFail" class="alert alert-danger d-none" role="alert">
                            Prišlo je do napake, prosim poskusite še enkrat!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="IzbrisiTerminModalButton">Izbriši termin</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Nazaj</button><br>
                    </div>
                    </div>
                </div>
            </div>
            <?php } ?>

</html>