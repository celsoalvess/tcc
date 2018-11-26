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

    if($_SESSION['perm'] == 3)
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
          <form method = "post" action="frmCadCli.php?ins=1" data-toggle="validator">
            <div class="card">
              <div class="card-header bg-primary text-white" id="topo_cad"> Cadastro de clientes</div>
              <div class="card-body" id="div_frm" style="display:none">
                <ul class="nav nav-tabs">
                  <li class="nav-item"> <a href="" class="nav-link active show" data-toggle="tab" data-target="#tabPessoa">Dados Pessoais</a> </li>
                  <li class="nav-item"> <a class="nav-link" href="" data-toggle="tab" data-target="#tabEnd">Endereço</a> </li>
                  <li class="nav-item"> <a href="" class="nav-link" data-toggle="tab" data-target="#tabEquip">Equipamento</a> 
                  </li>
                </ul>
                <div class="tab-content mt-2">
                  <div class="tab-pane fade active show" id="tabPessoa" role="tabpanel">
                    <div class="form-group">
                      <label for="nome">Nome:</label>
                      <input type="text" id="nome" name="cl_nome" maxlength="200" placeholder="João da Silva" class="form-control">
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="dt_nasc">Data de nascimento:</label>
                          <input type="text" id="dt_nasc" name="cl_dt_nasc" maxlength="10" placeholder="10/11/1987" class="form-control">
                          <input type="hidden" name="tipo_dml" id="tipo_dml" value="0">
                          <input type="hidden" name="id_alt" id="id_alt" value="0">
                        </div>
                        <div class="col">
                          <label for="sexo">Sexo:</label>
                          <select id="sexo" name="cl_sexo"  class="form-control">
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="email">E-mail:</label>
                          <input type="email" id="email" name="cl_email" maxlength="100" placeholder="joaosilva@dominio.com.br" class="form-control">
                        </div>
                        <div class="col">
                          <label for="telefone">Telefone de contato:</label>
                          <input type="text" id="telefone" name="cl_telefone" maxlength="16" placeholder="55-19-9923-5886" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label for="cpf">C.P.F:</label>
                          <input type="text" id="cpf"name="cl_cpf" maxlength="14" placeholder="314.827.499-19" class="form-control">
                        </div>
                        <div class="col">
                          <label for="rg">RG.:</label>
                          <input type="text" id="rg" name="cl_rg" maxlength="20" placeholder="40.619.320-4" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tabEnd" role="tabpanel">
                    <div class="form-group">
                      <div class="row">
                        <div class="col col-md-4">
                          <label for="cep">CEP:</label>
                          <input type="text" id="cep" name="cl_cep" maxlength="10" placeholder="13.330-603" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-8">
                        <label for="logradouro">Endereço:</label>
                        <input type="text" id="logradouro" name="cl_logradouro" maxlength="200" placeholder="Rua da providência" class="form-control">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="numero">Número:</label>
                        <input type="text" id="numero" name="cl_numero" maxlength="20" placeholder="1234" class="form-control">
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="complemento">Complemento:</label>
                        <input type="text" id="complemento" name="cl_complemento" maxlength="50" placeholder="Apto. 254" class="form-control">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="bairro">Bairro:</label>
                        <input type="text" id="bairro" name="cl_bairro" maxlength="100" placeholder="Cidade Nova" class="form-control">
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="cidade">Cidade:</label>
                        <input type="text" id="cidade" name="cl_cidade" maxlength="100"  placeholder="Cardeal" class="form-control">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="estado">Estado:</label>
                        <input type="text" id="estado" name="cl_estado" maxlength="100" placeholder="SP" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tabEquip" role="tabpanel">
                    <div class="form-group">
                      <label for="txMarca">Marca:</label>
                        <select id="txMarca" class="form-control" name="marca">
                          <?php
                            $sql = 'select distinct eq_fabricante as fabricante from tab_eqto';
                            $consulta = $c->Execute($sql);
                            while (!$consulta->EOF)
                            {
                              echo "<option value=\"".$consulta->fields[0]."\">".$consulta->fields[0]."</option>";
                              $consulta->MoveNext();
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="txModelo">Modelo:</label>
                        <select id="txModelo" class="form-control" name="modelo">
                          <?php
                            $sql = 'select distinct eq_modelo as modelo from tab_eqto';
                            $consulta = $c->Execute($sql);
                            while (!$consulta->EOF)
                            {
                              echo "<option value=\"".$consulta->fields[0]."\">".$consulta->fields[0]."</option>";
                              $consulta->MoveNext();
                            }
                          ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="txWatts">Watts:</label>
                        <select id="txWatts" class="form-control" name="watts">
                          <?php
                            $sql = 'select distinct eq_watts as watts from tab_eqto';
                            $consulta = $c->Execute($sql);
                            while (!$consulta->EOF)
                            {
                              echo "<option value=\"".$consulta->fields[0]."\">".$consulta->fields[0]."</option>";
                              $consulta->MoveNext();
                            }
                          ?>
                        </select>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                        <label for="txCox">Coordenada X:</label>
                        <input type="text" id="txCox" name="cl_cox" class="form-control" readonly>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="txCoy">Coordenada Y:</label>
                        <input type="text" id="txCoy" name="cl_coy" class="form-control" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <div align="center">
                  <button type="submit" class="btn btn-success btn-sm" id="btn_confirma">Confirmar</button>
                  <a href="frmCadCli.php" class="btn btn-warning text-white btn-sm" id="btn_cancela">Cancelar</a>
                </div>
              </div>
            </div>
          </form>

          <!-- Lista de clientes cadastrados -->
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>C.P.F</th>
                <th>Operação</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $sql = "select cl_id, cl_nome, cl_dt_nasc, cl_sexo, cl_email, cl_telefone, cl_cpf, cl_rg, cl_cep, ";
                $sql.= "cl_logradouro, cl_numero, cl_complemento, cl_bairro, cl_cidade, cl_estado, ";
                $sql.= "ST_AsText(cl_xy) AS geom  from tab_cliente";
                
                //Busca dos clientes
                $consulta = $c->Execute($sql);
                while (!$consulta->EOF)
                {
                  echo "<tr>";
                  echo "<td>".$consulta->fields[0]."</td>";
                  echo "<td>".$consulta->fields[1]."</td>";
                  echo "<td>".$consulta->fields[4]."</td>";
                  echo "<td>".$consulta->fields[6]."</td>";
                  echo "  <td>";
                  echo "    <a class=\"btn btn-primary\" id=\"btn_adic\" href=\"#\" onclick=\"$('#div_frm').toggle();\">";
                  echo "      <i class=\"fa fa-plus fa-fw fa-1x py-1 fa-lg\"></i>";
                  echo "    </a>";
                  echo "    <a class=\"btn btn-warning\" id=\"btn_edit\" href=\"frmCadCli.php?ac=1&&nu=".$consulta->fields[0]."\" >";
                  echo "        <i class=\"fa fa-pencil-square-o fa-fw fa-1x py-1 text-white fa-lg\"></i>";
                  echo "    </a>";
                 echo "    <a class=\"btn btn-danger\" id=\"btn_exclui\" href=\"frmCadCli.php?ac=5&&nu=".$consulta->fields[0]."\" >";
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
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/cep.js"></script>
  <script src="js/coord.js"></script>  
  <?php
    if ($_GET["ac"] == 1 && $_GET["nu"] <> 0)
    {
      $sql = "select cl.cl_id, cl.cl_nome, to_char(cl.cl_dt_nasc, 'DD/MM/YYYY') data_nasc, cl.cl_sexo, ";
      $sql.= "cl.cl_email, cl.cl_telefone, cl.cl_cpf, cl.cl_rg, cl.cl_cep, cl.cl_logradouro, cl.cl_numero, ";
      $sql.= "cl.cl_complemento, cl.cl_bairro, cl.cl_cidade, cl.cl_estado, ST_X(cl.cl_xy) cl_nox, ST_Y(cl.cl_xy) cl_noy, ";
      $sql.= "eq.eq_fabricante, eq.eq_modelo, eq.eq_watts ";
      $sql.= "from tab_cliente cl, tab_eqto eq ";
      $sql.= "where cl.cl_id=".$_GET["nu"]." and cl.cl_eq=eq.eq_id";

      echo "<script type=\"text/javascript\">";
      echo "document.getElementById(\"div_frm\").style.display = \"block\";";
      echo "document.getElementById(\"tipo_dml\").value = \"1\";";
      echo "document.getElementById(\"id_alt\").value = \"".$_GET["nu"]."\";";
      $dados_form = $c->Execute($sql);
      if (!$dados_form->EOF)
      {
        echo "document.getElementById(\"nome\").value = \"".$dados_form->fields[1]."\";";
        echo "document.getElementById(\"dt_nasc\").value = \"".$dados_form->fields[2]."\";";
        echo "document.getElementById(\"sexo\").value = \"".$dados_form->fields[3]."\";";
        echo "document.getElementById(\"email\").value = \"".$dados_form->fields[4]."\";";
        echo "document.getElementById(\"telefone\").value = \"".$dados_form->fields[5]."\";";
        echo "document.getElementById(\"cpf\").value = \"".$dados_form->fields[6]."\";";
        echo "document.getElementById(\"rg\").value = \"".$dados_form->fields[7]."\";";
        echo "document.getElementById(\"cep\").value = \"".$dados_form->fields[8]."\";";
        echo "document.getElementById(\"logradouro\").value = \"".$dados_form->fields[9]."\";";
        echo "document.getElementById(\"numero\").value = \"".$dados_form->fields[10]."\";";
        echo "document.getElementById(\"complemento\").value = \"".$dados_form->fields[11]."\";";
        echo "document.getElementById(\"bairro\").value = \"".$dados_form->fields[12]."\";";
        echo "document.getElementById(\"cidade\").value = \"".$dados_form->fields[13]."\";";
        echo "document.getElementById(\"estado\").value = \"".$dados_form->fields[14]."\";";
        echo "document.getElementById(\"txCox\").value = \"".$dados_form->fields[15]."\";";
        echo "document.getElementById(\"txCoy\").value = \"".$dados_form->fields[16]."\";";

        echo "document.getElementById(\"txMarca\").value = \"".$dados_form->fields[17]."\";";
        echo "document.getElementById(\"txModelo\").value = \"".$dados_form->fields[18]."\";";
        echo "document.getElementById(\"txWatts\").value = \"".$dados_form->fields[19]."\";";
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
    if ($_POST['cl_nome']=='' || $_POST['cl_email']=='' || $_POST['cl_cpf']=='' || $_POST['cl_cep']=='' )
    {
      mensagem("Campos em branco. Por favor revisar o formulário.");
      $erro_frm = true;
    }
  }

  if ($_GET['ins'] == 1 and $_POST['id_alt'] == 0)
  {
    if (!$erro_frm)
    {
      //Buscar o ID do eqto
      $sql = 'select eq_id from tab_eqto ';
      $sql.= 'where eq_fabricante=\''.$_POST['marca'].'\' and eq_modelo=\''.$_POST['modelo'].'\' ';
      $sql.= 'and eq_watts='.$_POST['watts'];
      $cons_eqto = $c->Execute($sql);
      if (!$cons_eqto->EOF)
      {
        $id_eqto = $cons_eqto->fields[0];
      }
      else
      {
        mensagem('Equipamento inexistente.');
        $id_eqto = 0;
      }//to do: unificar com o do update

      //Monta o insert
      $sql = 'insert into tab_cliente(cl_nome, cl_dt_nasc, cl_sexo, cl_email, cl_telefone, cl_cpf, cl_rg, ';
      $sql.= 'cl_cep, cl_logradouro, cl_numero, cl_bairro, cl_cidade, cl_estado, cl_complemento, cl_xy, cl_eq)';
      $sql.= 'values(\''.$_POST['cl_nome'].'\', \''.$_POST['cl_dt_nasc'].'\', \''.$_POST['cl_sexo'].'\', \'';
      $sql.= $_POST['cl_email'].'\', \''.$_POST['cl_telefone'].'\', \''.$_POST['cl_cpf'].'\', \''.$_POST['cl_rg'].'\', \'';
      $sql.= $_POST['cl_cep'].'\', \''.$_POST['cl_logradouro'].'\', \''.$_POST['cl_numero'].'\', \'';
      $sql.= $_POST['cl_bairro'].'\', \''.$_POST['cl_cidade'].'\', \''.$_POST['cl_estado'].'\', \'';
      $sql.= $_POST['cl_complemento'].'\', ';
      $sql.= 'ST_GeomFromText(\'POINT('.$_POST['cl_cox'].' '.$_POST['cl_coy'].')\', 4326), '.$id_eqto.')';
        
      //Executa inserção do registro
      if(!$c->Execute($sql))
      {
        mensagem("Erro na inserção");
      }
      else
      {
        mensagem("Registro inserido com sucesso");
      }  
      $c->Close();      
    }
  }

  if ($_GET['ins'] == 1 and $_POST['id_alt'] != 0)
  {
    if (!$erro_frm)
    {
      //Buscar o ID do eqto
      $sql = 'select eq_id from tab_eqto ';
      $sql.= 'where eq_fabricante=\''.$_POST['marca'].'\' and eq_modelo=\''.$_POST['modelo'].'\' ';
      $sql.= 'and eq_watts='.$_POST['watts'];
      $cons_eqto = $c->Execute($sql);
      if (!$cons_eqto->EOF)
      {
        $id_eqto = $cons_eqto->fields[0];
      }
      else
      {
        mensagem('Equipamento inexistente.');
        $id_eqto = 0;
      }//to do: unificar com o do update

      //Monta o update
      $sql = 'update tab_cliente set cl_nome=\''.$_POST['cl_nome'].'\'';
      $sql.= ',cl_dt_nasc=\''.$_POST['cl_dt_nasc'].'\'';
      $sql.= ',cl_sexo=\''.$_POST['cl_sexo'].'\'';
      $sql.= ',cl_email=\''.$_POST['cl_email'].'\'';
      $sql.= ',cl_telefone=\''.$_POST['cl_telefone'].'\'';
      $sql.= ',cl_cpf=\''.$_POST['cl_cpf'].'\'';
      $sql.= ',cl_rg=\''.$_POST['cl_rg'].'\'';
      $sql.= ',cl_cep=\''.$_POST['cl_cep'].'\'';
      $sql.= ',cl_logradouro=\''.$_POST['cl_logradouro'].'\'';
      $sql.= ',cl_numero=\''.$_POST['cl_numero'].'\'';
      $sql.= ',cl_bairro=\''.$_POST['cl_bairro'].'\'';
      $sql.= ',cl_cidade=\''.$_POST['cl_cidade'].'\'';
      $sql.= ',cl_estado=\''.$_POST['cl_estado'].'\'';
      $sql.= ',cl_xy='.'ST_GeomFromText(\'POINT('.$_POST['cl_cox'].' '.$_POST['cl_coy'].')\', 4326)';
      $sql.= ',cl_eq='.$id_eqto;
      $sql.= ',cl_complemento=\''.$_POST['complemento'].'\'';
      $sql.= 'where cl_id='.$_POST['id_alt'];

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
    $sql= "delete from tab_cliente ";
    $sql.= "where cl_id=".$_GET["nu"];

    if ($c->Execute($sql))
    {
      mensagem2("Registro excluído com sucesso!");
    }      
  }
?>