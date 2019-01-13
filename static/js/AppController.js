$( document ).ready(function() {
    var terminID;
    var datum;
    var cas;
    var ocena;
    var tutor;
    var cena;
    $(".Predmet").click(function(){
        var SubjectID = this.id;
        var Predmet = $(this).children(".figure-caption").children("#PredmetName").text();
        var link = "Subjects.php?PredmetID="+SubjectID+"&Predmet="+Predmet;
        window.location.href = link;
    });

    $(".TutorFigure").click(function(){
        var TutorID = this.id;
        var ImeTutorja = $(this).children(".figure-caption").children("#ImeInPriimekTutorja").text();
        var link = "Tutors.php?TutorID="+TutorID+"&Ime="+ImeTutorja;
        window.location.href = link;
    });

    $(".Termini").click(function(){
        terminID = this.id;
        datum = $(this).children(".figure-caption").children("#TextDatum").text();
        cas = $(this).children(".figure-caption").children("#TextCas").text();
        ocena = $(this).children(".figure-caption").children("#TextOcena").text();
        tutor = $(this).children(".figure-caption").children("#TextIme").text();
        cena = $(this).children(".figure-caption").children("#TextCena").text();
        $("#ModalDatum").text(datum);
        $("#ModalCas").text(cas)
        $("#ModalOcena").text(ocena);
        $("#ModalTutor").text(tutor);
        $("#ModalCena").text(cena);
        $("#RezervirajTerminModal").modal("show");
        $("#TerminIDModal").val(terminID);
    });

    $("#RezervirajTerminButton").click(function(){
        var StudentID = $("#UserIDModal").val();
        url = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/TakeTermin/" + terminID + "/" + StudentID;
        $.ajax({
            url:"config.php", //the page containing php script
            type: "post", //request type,
            data: {user: "Student", type: "TakeTermin", url: url},
            success:function(result){
                $("#TerminSuccess").removeClass("d-none");
                $("#TerminFail").addClass("d-none");
           },
           error: function (err) {
               console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
               $("#TerminSuccess").addClass("d-none");
               $("#TerminFail").removeClass("d-none");
           }
         });
    })

    //Tutors Controller
    $("#ProstiTerminiTutorja").click(function(){
        $("#ProstiTerminiTutorjaRow").removeClass("d-none");
        $("#PodatkiTutorjaRow").addClass("d-none");
        $("#PredmetiTutorjaRow").addClass("d-none");

        $("#ProstiTerminiTutorja").addClass("ActiveTutor");
        $("#PredmetiTutorja").removeClass("ActiveTutor");
        $("#PodatkiTutorja").removeClass("ActiveTutor");
    });
    $("#PredmetiTutorja").click(function(){
        $("#PredmetiTutorjaRow").removeClass("d-none");
        $("#PodatkiTutorjaRow").addClass("d-none");
        $("#ProstiTerminiTutorjaRow").addClass("d-none");

        $("#PredmetiTutorja").addClass("ActiveTutor");
        $("#PodatkiTutorja").removeClass("ActiveTutor");
        $("#ProstiTerminiTutorja").removeClass("ActiveTutor");
    });
    $("#PodatkiTutorja").click(function(){
        $("#PodatkiTutorjaRow").removeClass("d-none");
        $("#PredmetiTutorjaRow").addClass("d-none");
        $("#ProstiTerminiTutorjaRow").addClass("d-none");

        $("#PodatkiTutorja").addClass("ActiveTutor");
        $("#PredmetiTutorja").removeClass("ActiveTutor");
        $("#ProstiTerminiTutorja").removeClass("ActiveTutor");

    });
    var OceniTerminID = 0;
    $(".OceniTutorjaButton").click(function(){
        OceniTerminID = this.id;
        $("#OceniTutorjaModal").modal("show");
    });

    $("#OceniTutorjaButtonModal").click(function(){
        var Ocena = $("#OcenaTutorjaInput").val();
        
        url = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/GiveGrade/" + OceniTerminID + "/" + Ocena;
        $.ajax({
            url:"config.php", //the page containing php script
            type: "post", //request type,
            data: {user: "Student", type: "Grade", url: url},
            success:function(result){
                $("#TerminSuccess").removeClass("d-none");
                $("#TerminFail").addClass("d-none");
           },
           error: function (err) {
               console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
               $("#TerminSuccess").addClass("d-none");
               $("#TerminFail").removeClass("d-none");
           }
         });
    });
    var TerminIDIzbrisi = 0;
    $(".IzbrišiTerminButton").click(function(){
        TerminIDIzbrisi = this.id;
        $("#IzbrisiTerminModal").modal("show");
    });

    $("#IzbrisiTerminModalButton").click(function(){
        url = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/DeleteTermin/" + TerminIDIzbrisi;
        $.ajax({
            url:"config.php", //the page containing php script
            type: "post", //request type,
            data: {user: "Tutor", type: "DeleteTermin", url: url},
            success:function(result){
                $("#DeleteTerminSuccess").removeClass("d-none");
                $("#DeleteTerminFail").addClass("d-none");
                var delay = 2000; 
                setTimeout(function(){ window.location = "index.php"; }, delay);
           },
           error: function (err) {
               console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
               $("#DeleteTerminSuccess").addClass("d-none");
               $("#DeleteTerminFail").removeClass("d-none");
           }
         });
    });

    $("#AddTerminButton").click(function(){
        var PredmetID = $("#PredmetSelect").children(":selected").attr("id");
        var TutorID = $("#TutorID").val();
        var DateTime = $("#DateTime").val();

        url = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/addTermin/" + TutorID + "/" + PredmetID + "/";
        $.ajax({
            url:"config.php", //the page containing php script
            type: "post", //request type,
            data: {user: "Tutor", type: "AddTermin", DateTime: DateTime, url: url},
            success:function(result){
                $("#TerminSuccess").removeClass("d-none");
                $("#TerminFail").addClass("d-none");
           },
           error: function (err) {
               console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
               $("#TerminSuccess").addClass("d-none");
               $("#TerminFail").removeClass("d-none");
           }
         });
    });

    $("#AddSubjectButton").click(function(){
        var PredmetID = $("#PredmetSelect").children(":selected").attr("id");
        var Cena = $("#CenaPredmeta").val();
        var TutorID = $("#TutorID").val();

        url = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/addSubjectPrice/" + TutorID + "/" + PredmetID + "/" + Cena;
        $.ajax({
            url:"config.php", //the page containing php script
            type: "post", //request type,
            data: {user: "Tutor", type: "AddSubject", url: url},
            success:function(result){
                $("#TerminSuccess").removeClass("d-none");
                $("#TerminFail").addClass("d-none");
           },
           error: function (err) {
               console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
               $("#TerminSuccess").addClass("d-none");
               $("#TerminFail").removeClass("d-none");
           }
         });
    });
});