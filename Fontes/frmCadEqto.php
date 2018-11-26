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
    //Include da classe ADODB - conexão banco de dados
    require_once ("includes/pg_cnn.php");
    require_once ("includes/msg.php");

    if($_SESSION['perm'] != 1 && $_SESSION['perm'] != 4)
    {
      mensagem("Sem permissão para acesso a esta página!!");
      header ("Location: frmHome.php");
    }
    $erro_frm = false;
  }
?>
<!-- HTML confeccionado com PINGENDO - IDE para Bootstrap -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap_pers.css" type="text/css">
  <link rel="stylesheet" href="css/personalizado.css" type="text/css">
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
          <form method = "post" action="frmCadEqto.php?ins=1" data-toggle="validator">
            <div class="card">
              <div class="card-header bg-primary text-white" id="topo_cad">Cadastro de equipamentos</div>
              <div class="card-body"  style="display:none" id="div_frm">
                <div class="tab-content mt-2">
                    <div class="form-group">
                      <label for="txMarca">Marca/Fabricante:</label>
                      <input type="text" id="txMarca" name="marca" placeholder="Webber" class="form-control">
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="txModelo">Modelo:</label>
                          <input type="text" id="txModelo" name="modelo" placeholder="Modelo" class="form-control">
                          <input type="hidden" name="tipo_dml" id="tipo_dml" value="0">
                          <input type="hidden" name="id_alt" id="id_alt" value="0">
                        </div>
                        <div class="col">
                          <label for="txWatts">Watts:</label>
                          <input type="text" id="txWatts" name="watts" placeholder="200" class="form-control">
                        </div>
                      </div>
                    </div>
                </div>
                <div align="center">
                  <button type="submit" class="btn btn-success btn-sm" id="btn_confirma">Confirmar</button>
                  <a href="frmCadEqto.php" class="btn btn-warning text-white btn-sm" id="btn_cancela">Cancelar</a>
                </div>
              </div>
            </div>
          </form>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Watts</th>
                <th>Operação</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "select eq_id, eq_fabricante, eq_modelo, eq_watts from tab_eqto";
                
                //Busca dos equipamentos
                $consulta = $c->Execute($sql);
                while (!$consulta->EOF)
                {
                  echo "<tr>";
                  echo "<td>".$consulta->fields[0]."</td>";
                  echo "<td>".$consulta->fields[1]."</td>";
                  echo "<td>".$consulta->fields[2]."</td>";
                  echo "<td>".$consulta->fields[3]."</td>";
                  echo "  <td>";
                  echo "    <a class=\"btn btn-primary\" id=\"btn_adic\" href=\"#\" onclick=\"$('#div_frm').toggle();\">";
                  echo "      <i class=\"fa fa-plus fa-fw fa-1x py-1 fa-lg\"></i>";
                  echo "    </a>";
                  echo "    <a class=\"btn btn-warning\" id=\"btn_edit\" href=\"frmCadEqto.php?ac=1&&nu=".$consulta->fields[0]."\" >";
                  echo "        <i class=\"fa fa-pencil-square-o fa-fw fa-1x py-1 text-white fa-lg\"></i>";
                  echo "    </a>";
                 echo "    <a class=\"btn btn-danger\" id=\"btn_exclui\" href=\"frmCadEqto.php?ac=5&&nu=".$consulta->fields[0]."\" >";
                  echo "      <i class=\"fa fa-remove fa-fw fa-1x py-1 fa-lg\"></i>";
                  echo "    </a>";
                  echo "  </td>";
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
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous" style=""></script>
  <?php
    if ($_GET["ac"] == 1 && $_GET["nu"] <> 0)
    {
      $sql = "select eq_id, eq_fabricante, eq_modelo, eq_watts from tab_eqto where eq_id=".$_GET["nu"];
      echo "<script type=\"text/javascript\">";
      echo "document.getElementById(\"div_frm\").style.display = \"block\";";
      echo "document.getElementById(\"tipo_dml\").value = \"1\";";
      echo "document.getElementById(\"id_alt\").value = \"".$_GET["nu"]."\";";
      $dados_form = $c->Execute($sql);
      if (!$dados_form->EOF)
      {
        echo "document.getElementById(\"txMarca\").value = \"".$dados_form->fields[1]."\";";
        echo "document.getElementById(\"txModelo\").value = \"".$dados_form->fields[2]."\";";
        echo "document.getElementById(\"txWatts\").value = \"".$dados_form->fields[3]."\";";
      }
      echo "</script>";
    }
  ?>
</body>

</html>
<?php
  //VALIDAR DADOS ANTES
  if ($_GET['ins'] == 1)
  {
    if ($_POST['marca']=='' || $_POST['modelo']=='' || $_POST['watts']=='')
    {
      mensagem("Campos em branco. Por favor revisar o formulário.");
      $erro_frm = true;
    }
  }

  if ($_GET['ins'] == 1 and $_POST['id_alt'] == 0)
  {

    if (!erro_frm)
    {
      //Monta o insert
      $sql = 'insert into tab_eqto(eq_fabricante, eq_modelo, eq_watts)';
      $sql.= 'values(\''.$_POST['marca'].'\', \''.$_POST['modelo'].'\', \''.$_POST['watts'].'\')';
      //Executa inserção do registro
      if(!$c->Execute($sql))
      {
        mensagem("Erro na inserção");
      }
      else
      {
        mensagem("Registro inserido com sucesso");
      }  
    }
  }

  if ($_GET['ins'] == 1 and $_POST['id_alt'] != 0)
  {
    if (!erro_frm)
    {
      //Monta o update
      $sql = 'update tab_eqto set eq_fabricante=\''.$_POST['marca'].'\', eq_modelo=\''.$_POST['modelo'].'\', eq_watts=\''.$_POST['watts'].'\' ';
      $sql.= 'where eq_id='.$_POST['id_alt'];
      //Executa alteração do registro
      if(!$c->Execute($sql))
      {
        mensagem("Erro na alteração");
      }
      else
      {
        mensagem("Registro alterado com sucesso");
      }  
    }
  }

  if ($_GET["ac"] == 5 && $_GET["nu"] <> 0)
  {
    $sql= "delete from tab_eqto ";
    $sql.= "where eq_id=".$_GET["nu"];

    if ($c->Execute($sql))
    {
      mensagem2("Registro excluído com sucesso!");
    }      
  }
?>