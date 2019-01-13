$( document ).ready(function() {

    //Change value on slider change
    $("#LoginAsCheckbox").change(function(){
        if(this.checked){
            $("#LoginAs").text("Tutor");  
        }else{
            $("#LoginAs").text("Študent");
        }
    });

    $("#RegistrationAsCheckbox").change(function(){
        if(this.checked){
            $("#RegistrationAs").text("Tutor");            
            $("#TelephoneDiv").removeClass("d-none");          
        }else{
            $("#TelephoneDiv").addClass("d-none");          
            $("#RegistrationAs").text("Študent");
        }
    });

    //Change password
    $("#ChangePasswordButton").click(function(event){
        event.preventDefault();
        var geslo = $("input[name=passwordConf]").val();
        var geslo2 = $("input[name=password]").val();
        var TypeOfUser = $("#TypeOfUser").val();
        var UserID = $("#UserID").val();
        var url = ""
        if(geslo === geslo2){
            if(TypeOfUser == "Tutor"){
                url = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/ChangePassTutor/" + UserID + "/" + geslo;
            }else{
                url = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/ChangePassStudent/" + UserID + "/" + geslo;
            }
            $.ajax({
                url:"config.php", //the page containing php script
                type: "post", //request type,
                data: {user: TypeOfUser, type: "PasswordChange", url: url},
                success:function(result){
                    $("#PasswordDontMatchAlert").addClass("d-none");
                    $("#PasswordChanged").removeClass("d-none");
               },
               error: function (err) {
                   console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
               }
             });
        }else{
            $("#PasswordChanged").addClass("d-none");
            $("#PasswordDontMatchAlert").removeClass("d-none");
        }
    });

    //Login
    $("#LoginButton").click(function(){
        var upime = $("input[name=username]").val();
        var geslo = $("input[name=password]").val();
        if($("#LoginAs").text() == "Tutor"){
            console.log("Tutor");
            $.ajax({
                url:"config.php", //the page containing php script
                type: "post", //request type,
                data: {user: "Tutor", type: "login", url: "http://apitutor.azurewebsites.net/RestServiceImpl.svc/LoginTutor/"+upime+"/"+geslo},
                success:function(result){
                    if(parseInt(result) == 1){
                        location.href = "index.php";
                    }else{
                        LoginFailed();
                    }
                    console.log(result);
               },
               error: function (err) {
                   console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
               }
             });
        }else if($("#LoginAs").text() == "Študent"){
            console.log("Student");
            $.ajax({
                url:"config.php", //the page containing php script
                type: "post", //request type,
                data: {user: "Student", type: "login", url: "http://apitutor.azurewebsites.net/RestServiceImpl.svc/LoginStudent/"+upime+"/"+geslo},
                success:function(result){
                    if(parseInt(result) == 1){
                        location.href = "index.php";
                    }else{
                        LoginFailed();
                    }
                    console.log(result);
                },
                error: function (err) {
                    console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                }
             });
        }
    });

    $("form").submit(function(e){
        return false;
    });

    //Registration
    $("#RegistrationButton").click(function(){
        var ime = $("input[name=name]").val();
        var priimek = $("input[name=lastname]").val();
        var email = $("input[name=email]").val();
        var posta = $("input[name=postNumber]").val();
        var ulica = $("input[name=street]").val();
        var stevilka = $("input[name=streetNumber]").val();
        var geslo = $("input[name=password]").val();
        var telefon = "";
        var url = "";

        //Replace spaces
        ime = ime.replace(/ /g, "%20");
        priimek = priimek.replace(/ /g, "%20");
        email = email.replace(/ /g, "%20");
        posta = posta.replace(/ /g, "%20");
        ulica = ulica.replace(/ /g, "%20");
        stevilka = stevilka.replace(/ /g, "%20");
        //////////////

        if($("#RegistrationAsCheckbox").checked){
            telefon = $("input[name=telephone]").val();
            telefon = telefon.replace(/ /g, "%20");
            url = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/addTutor/"+ime+"/"+priimek+"/"+email+"/"+telefon+"/"+geslo+"/"+posta+"/"+ulica+"/"+stevilka;
        }else{
            url = "http://apitutor.azurewebsites.net/RestServiceImpl.svc/addStudent/"+ime+"/"+priimek+"/"+email+"/"+geslo+"/"+posta+"/"+ulica+"/"+stevilka;
        }
        $.ajax({
            url:"config.php", //the page containing php script
            type: "post", //request type,
            data: {type: "registration", url: url},
            success:function(result){
                $(".NeuspesnaRegistracija").remove();
                if(parseInt(result) == 1){
                    $(' <div class="alert alert-success mt-3" role="alert">Uspešna registracija. Preusmerili Vas bomo čez 3 sekund. Če vas ne preusmeri, kliknite <a href="login.php"> tukaj </a></div>').insertAfter("#RegistrationButton");
                    setTimeout( function(){ 
                        location.href = "login.php";
                    }  , 5000 );
                }else{
                    $(' <div class="mt-3 alert alert-danger NeuspesnaRegistracija" role="alert">Neuspešna registracija!</div>').insertAfter("#RegistrationButton");                    
                }
           },
           error: function (err) {
               console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
           }
         });
    });
});

function LoginFailed(){
    $("#LoginFailedAlert").removeClass("d-none");
}