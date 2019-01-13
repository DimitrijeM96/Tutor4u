<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Tutor4u</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item <?= (($_SESSION["Page"] == "index")?"active":"")?>">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (($_SESSION["Page"] == "Tutors")?"active":"")?>" href="Tutors.php">Tutorji</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (($_SESSION["Page"] == "Subjects")?"active":"")?>" href="Subjects.php">Predmeti</a>
      </li>
      <?php if($_SESSION["TypeOfUser"] == "Tutor"){ ?>
      <li class="nav-item">
        <a class="nav-link <?= (($_SESSION["Page"] == "TutorAdd")?"active":"")?>" href="TutorAdd.php">Dodaj termin</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (($_SESSION["Page"] == "TutorSubject")?"active":"")?>" href="TutorSubject.php">Dodaj predmet</a>
      </li>
      <?php } ?>
      </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown <?= (($_SESSION["Page"] == "configuration")?"active":"")?>">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user"></i> <?= $_SESSION["user"] ?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item <?= (($_SESSION["Page"] == "configuration")?"active":"")?>" href="configuration.php"><i class="fa fa-cog"></i> Nastavitve</a>
          <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
        </div>
      </li>
      <li class="nav-item">

      </li>
    </ul>
  </div>
</nav>