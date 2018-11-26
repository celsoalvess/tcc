<?php
  //Início da sessão PHP
  session_start();
  if (!$_SESSION['nome'] || $_SESSION['nome'] == '')
  {
    header ("Location: index.php");
  }
?>
  <nav class="navbar navbar-expand-md bg-secondary navbar-dark" id="barra_naveg">
    <div class="container">
      <a class="navbar-brand" href="frmHome.php">Início</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <?php
            if ($_SESSION['perm'] != 3)
            {
          ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="frmCadCli.php">Clientes</a>
              </li>
          <?php
            }
            if ($_SESSION['perm'] == 1 || $_SESSION['perm'] == 4)
            {
          ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="frmCadEqto.php">Equipamentos</a>
              </li>
          <?php
            }
            if ($_SESSION['perm'] == 2 || $_SESSION['perm'] == 4)
            {
          ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="frmCadUsu.php">Usuários</a>
              </li>
          <?php
            }
            if ($_SESSION['perm'] != 1 && $_SESSION['perm'] != 3)
            {
          ?>
              <li class="nav-item ">
                <a class="nav-link text-white" href="frmRotas.php">Rotas</a>
              </li>
          <?php
            }
            if ($_SESSION['perm'] != 1 && $_SESSION['perm'] != 5)
            {
          ?>
              <li class="nav-item">
                <a class="nav-link text-white" href="frmRelatorio.php">Relatório</a>
              </li>
          <?php
            }
          ?>

          <li class="nav-item">
            <a class="nav-link text-white" href="frmSair.php">Sair</a>
          </li>
        </ul>
        <form class="form-inline m-0">
          <li class="nav-item"> Usuário: <?php echo $_SESSION['nome']; ?> </li>
        </form>
      </div>
    </div>
  </nav>