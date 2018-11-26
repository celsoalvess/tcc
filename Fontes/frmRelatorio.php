<?php
  //Início da sessão PHP
  session_start();

  //Se não tiver dados gravados na sessão, redireciona para a tela de login
  if (!$_SESSION['nome'] || $_SESSION['nome'] == '')
  {
    header ("Location: index.php");
  }
  else
  {
    if($_SESSION['perm'] != 2 && $_SESSION['perm'] != 3 && $_SESSION['perm'] != 4)
    {
      mensagem("Sem permissão para acesso a esta página!!");
      header ("Location: frmHome.php");
    }
    require_once ("includes/pg_cnn.php");
    include("includes/db/adodb5/tohtml.inc.php");
  }
?>
<!-- HTML confeccionado com PINGENDO - IDE para Bootstrap -->
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap_pers.css">
  <link rel="stylesheet" href="css/personalizado.css" />
</head>

<body>
  <?php
    //inclui o script que gera o menu superior de acordo com as permissões
    include "nav.php";
  ?>
  <div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-primary text-white" id="topo_cad">Relatório de clientes instalados</div>
            <div class="card-body">              
              <table class="table">
                <thead>
                  <tr>                                   
                    <th>Nome</th>
                    <th>Dt. Nasc</th>
                    <th>Sexo</th>
                    <th>Email</th>
                    <th>CEP</th> 
                    <th>End.</th> 
                    <th>Nº</th> 
                    <th>Bairro</th> 
                    <th>Cidade</th> 
                    <th>Eq.</th> 
                    <th>Mod.</th> 
                    <th>Watts</th> 
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql = "select cl_nome, to_char(cl_dt_nasc, 'DD/MM/YYYY') data_nasc, cl_sexo, cl_email, cl_cep,";
                    $sql.= "cl_logradouro, cl_numero, cl_bairro, cl_cidade, eq_fabricante, eq_modelo, eq_watts ";
                    $sql.= "from tab_cliente, tab_eqto ";
                    $sql.= "where eq_id=cl_eq ";
                    //$sql.= "and cl_eq <> ''";

                    //Busca dos clientes
                    $consulta = $c->Execute($sql);
                    while (!$consulta->EOF)
                    {
                      echo "<tr>";
                      echo "<td>".$consulta->fields[0]."</td>";
                      echo "<td>".$consulta->fields[1]."</td>";
                      echo "<td>".$consulta->fields[2]."</td>";
                      echo "<td>".$consulta->fields[3]."</td>";
                      echo "<td>".$consulta->fields[4]."</td>";
                      echo "<td>".$consulta->fields[5]."</td>";
                      echo "<td>".$consulta->fields[6]."</td>";
                      echo "<td>".$consulta->fields[7]."</td>";
                      echo "<td>".$consulta->fields[8]."</td>";
                      echo "<td>".$consulta->fields[9]."</td>";
                      echo "<td>".$consulta->fields[10]."</td>";
                      echo "<td>".$consulta->fields[11]."</td>";
                      echo "</tr>";
                      $consulta->MoveNext();
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>