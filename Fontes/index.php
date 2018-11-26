<?php
  //Parâmetros abaixo só devem ser usados em abiente de desenvolvimento; pois mostram q.q erro
  //ini_set( "display_errors", true );
  //error_reporting( E_ALL ^ E_NOTICE );

  //início da sessão PHP
  session_start();
  if ($_GET["try"] == 1)
  {
    //Include da classe ADODB - conexão banco de dados
    require_once ("includes/pg_cnn.php");
    require_once ("includes/msg.php");
    
    $sql =  "select us_nome, us_perm from tab_usuario ";
    $sql .= "where us_email='".$_POST["email"]."' ";
    $sql .= "and us_senha='".$_POST["senha"]."'";
    
    //Busca do usuário e senha no banco de dados
    $consulta = $c->Execute($sql);
    if ($consulta->EOF)
    {
      //Redireciona para a página de login se usuário ou senha estiverem errados
      mensagem("Usuário inexistente ou senha incorreta. Tente novamente");
      header ("Location: index.php");
    }
    else
    {
      //Grava dados na sessão se login for com sucesso
      $_SESSION['nome'] = $consulta->fields[0];
      $_SESSION['perm'] = $consulta->fields[1];
      header ("Location: frmHome.php");
    }
    $c->Close();
  }
?>
<!-- HTML confeccionado com PINGENDO - IDE para Bootstrap -->
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap_pers.css">
  <link rel="stylesheet" href="css/personalizado.css" />  
</head>

<body class="bg-info">
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6">
          <div class="card text-white p-5 bg-secondary" id="tela_login">
            <div class="card-body">
              <h1 class="mb-4">Rota de vendas</h1>
              <form action="index.php?try=1" method="post" data-toggle="validator">
                <div class="form-group">
                  <label>Usuário</label>
                  <input type="email" class="form-control" placeholder="email@dominio.com" name="email"> </div>
                <div class="form-group">
                  <label>Senha</label>
                  <input type="password" class="form-control" placeholder="Senha" name="senha"> </div>
                <button type="submit" class="btn btn-primary" id="btn_entrar">Entrar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>   
  <script src="js/jquery-3.2.1.slim.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>