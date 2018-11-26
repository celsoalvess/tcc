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
    
    if($_SESSION['perm'] != 2 && $_SESSION['perm'] != 4)
    {
      mensagem("Sem permissão para acesso a esta página!!");
      header ("Location: frmHome.php");
    }
    $erro_frm = false;
  }
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap_pers.css">
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
          <form method = "post" action="frmCadUsu.php?ins=1" data-toggle="validator">
          <div class="card">
            <div class="card-header bg-primary text-white" id="topo_cad"> Cadastro de usuários/vendedores</div>
            <div class="card-body" style="display:none" id="div_frm">
              <ul class="nav nav-tabs">
                <li class="nav-item"> <a href="" class="nav-link active show" data-toggle="tab" data-target="#tabPessoa">Dados Pessoais</a> </li>
                <li class="nav-item"> <a class="nav-link" href="" data-toggle="tab" data-target="#tabEnd">Endereço</a> </li>
                <li class="nav-item"> <a href="" class="nav-link" data-toggle="tab" data-target="#tabPerm">Permissões</a> </li>
              </ul>
              <div class="tab-content mt-2">
                <div class="tab-pane fade active show" id="tabPessoa" role="tabpanel">
                  <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" maxlength="200" placeholder="João da Silva" class="form-control">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <label for="dt_nasc">Data de nascimento:</label>
                        <input type="text" id="dt_nasc" name="dt_nasc"  maxlength="10" placeholder="10/11/1987" class="form-control">
                        <input type="hidden" name="tipo_dml" id="tipo_dml" value="0">
                        <input type="hidden" name="id_alt" id="id_alt" value="0">
                      </div>
                      <div class="col">
                          <label for="sexo">Sexo:</label>
                          <select id="sexo" name="sexo" class="form-control">
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
                        <input type="text" id="email" name="email" maxlength="100" placeholder="joaosilva@dominio.com.br" class="form-control">
                      </div>
                      <div class="col">
                        <label for="telefone">Telefone de contato:</label>
                        <input type="text" id="telefone" name="telefone" maxlength="16" placeholder="55-19-9923-5886" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <label for="cpf">C.P.F:</label>
                        <input type="text" id="cpf" name="cpf" maxlength="14" placeholder="314.827.499-19" class="form-control">
                      </div>
                      <div class="col">
                        <label for="rg">RG.:</label>
                        <input type="text" id="rg" name="rg" maxlength="20" placeholder="40.619.320-4" class="form-control">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="tabEnd" role="tabpanel">
                  <div class="form-group">
                    <div class="row">
                      <div class="col col-md-4">
                        <label for="cep">CEP:</label>
                        <input type="text" id="cep" name="cep"  maxlength="10" placeholder="13.330-603" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-8">
                      <label for="logradouro">Endereço:</label>
                      <input type="text" id="logradouro" name="logradouro" maxlength="200" placeholder="Rua da providência" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="numero">Número:</label>
                      <input type="text" id="numero" name="numero" maxlength="20" placeholder="1234" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                      <div class="form-group col-md-6">
                        <label for="complemento">Complemento:</label>
                        <input type="text" id="complemento" name="complemento" maxlength="50" name="cl_complemento" maxlength="50" placeholder="Apto. 254" class="form-control">
                      </div>
                    <div class="form-group col-md-6">
                      <label for="bairro">Bairro:</label>
                      <input type="text" id="bairro" name="bairro" maxlength="100" placeholder="Cidade Nova" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="cidade">Cidade:</label>
                      <input type="text" id="cidade" name="cidade" maxlength="100" placeholder="Cardeal" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="estado">Estado:</label>
                      <input type="text" id="estado" name="estado" maxlength="100" placeholder="SP" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="tabPerm" role="tabpanel">
                  <div class="row">
                    <div class="col col-md-6">
                      <label for="permissao">Permissão:</label>
                      <select name="permissao" id="permissao" class="form-control">
                        <option value="1">Secretária</option>
                        <option value="2">Gerente Vendas</option>
                        <option value="3">Gerente Operacional</option>
                        <option value="4">ADM</option>
                        <option value="5">Vendedores</option>
                      </select>
                    </div>
                  </div>
                  <p class="">&nbsp;</p>
                  <p class="">&nbsp;</p>
                  <p class="">&nbsp;</p>
                  <p class="">&nbsp;</p>
                  <p class="">&nbsp;</p>
                  <p class="">&nbsp;</p>
                </div>
              </div>
                <div align="center">
                  <button type="submit" class="btn btn-success btn-sm" id="btn_confirma">Confirmar</button>
                  <a href="frmCadUsu.php" class="btn btn-warning text-white btn-sm" id="btn_cancela">Cancelar</a>
                </div>
            </div>
          </div>
        </form>

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
                $sql = "select us_id, us_nome, us_dt_nasc, us_sexo, us_email, us_telefone, us_cpf, us_rg, us_cep, ";
                $sql.= "us_logradouro, us_numero, us_complemento, us_bairro, us_cidade, us_estado, ";
                $sql.= "us_perm from tab_usuario";
                
                //Busca dos usuários
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
                  echo "    <a class=\"btn btn-warning\" id=\"btn_edit\" href=\"frmCadUsu.php?ac=1&&nu=".$consulta->fields[0]."\" >";
                  echo "        <i class=\"fa fa-pencil-square-o fa-fw fa-1x py-1 text-white fa-lg\"></i>";
                  echo "    </a>";
                  echo "    <a class=\"btn btn-danger\" id=\"btn_exclui\" href=\"frmCadUsu.php?ac=5&&nu=".$consulta->fields[0]."\" >";
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
  <?php
    if ($_GET["ac"] == 1 && $_GET["nu"] <> 0)
    {
      $sql = "select us_id, us_nome, to_char(us_dt_nasc, 'DD/MM/YYYY') data_nasc, us_sexo, ";
      $sql.= "us_email, us_telefone, us_cpf, us_rg, us_cep, us_logradouro, us_numero, ";
      $sql.= "us_complemento, us_bairro, us_cidade, us_estado, us_perm ";
      $sql.= "from tab_usuario ";
      $sql.= "where us_id=".$_GET["nu"];

      echo "<script type=\"text/javascript\">";
      echo "document.getElementById(\"div_frm\").style.display = \"block\";";
      echo "document.getElementById(\"tipo_dml\").value = \"1\";";
      echo "document.getElementById(\"id_alt\").value = \"".$_GET["nu"]."\";";
      $dados_form = $c->Execute($sql);      
      if (!$dados_for->EOF)
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
        echo "document.getElementById(\"permissao\").value = \"".$dados_form->fields[15]."\";";
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
    if ($_POST['nome']=='' || $_POST['email']=='' || $_POST['cpf']=='' || $_POST['cep']=='' )
    {
      mensagem("Campos em branco. Por favor revisar o formulário.");
      $erro_frm = true;
    }
  }

  if ($_GET['ins'] == 1 and $_POST['id_alt'] == 0)
  {
    if (!$erro_frm)
    {
      //Monta o insert
      $sql = 'insert into tab_usuario(us_nome, us_dt_nasc, us_sexo, us_email, us_telefone, us_cpf, us_rg, ';
      $sql.= 'us_cep, us_logradouro, us_numero, us_bairro, us_cidade, us_estado, us_complemento, us_perm, us_senha) ';
      $sql.= 'values(\''.$_POST['nome'].'\', \''.$_POST['dt_nasc'].'\', \''.$_POST['sexo'].'\', \'';
      $sql.= $_POST['email'].'\', \''.$_POST['telefone'].'\', \''.$_POST['cpf'].'\', \''.$_POST['rg'].'\', \'';
      $sql.= $_POST['cep'].'\', \''.$_POST['logradouro'].'\', \''.$_POST['numero'].'\', \'';
      $sql.= $_POST['bairro'].'\', \''.$_POST['cidade'].'\', \''.$_POST['estado'].'\', \'';
      $sql.= $_POST['complemento'].'\', '.$_POST['permissao'].', \'abc321!\')';
        
      //Executa inserção do registro
      if(!$c->Execute($sql))
      {
        mensagem("Erro na inserção");
      }
      else
      {
        mensagem("Registro inserido com sucesso");
        mail($_POST['email'], 'Criação de acesso rota de vendas', 'Segue sua senha: abc321!<br>Por favor alterar no primeiro acesso em www.rotadevenda.com.br',"From: rotas@teste.com.br");
      }  
      $c->Close();
    }
  }

  if ($_GET['ins'] == 1 and $_POST['id_alt'] != 0)
  {
    if (!$erro_frm)
    {
      //Monta o update
      $sql = 'update tab_usuario set us_nome=\''.$_POST['nome'].'\'';
      $sql.= ',us_dt_nasc=\''.$_POST['dt_nasc'].'\'';
      $sql.= ',us_sexo=\''.$_POST['sexo'].'\'';
      $sql.= ',us_email=\''.$_POST['email'].'\'';
      $sql.= ',us_telefone=\''.$_POST['telefone'].'\'';
      $sql.= ',us_cpf=\''.$_POST['cpf'].'\'';
      $sql.= ',us_rg=\''.$_POST['rg'].'\'';
      $sql.= ',us_cep=\''.$_POST['cep'].'\'';
      $sql.= ',us_logradouro=\''.$_POST['logradouro'].'\'';
      $sql.= ',us_numero=\''.$_POST['numero'].'\'';
      $sql.= ',us_bairro=\''.$_POST['bairro'].'\'';
      $sql.= ',us_cidade=\''.$_POST['cidade'].'\'';
      $sql.= ',us_estado=\''.$_POST['estado'].'\'';
      $sql.= ',us_perm='.$_POST['permissao'];
      $sql.= ',us_complemento=\''.$_POST['complemento'].'\'';
      $sql.= 'where us_id='.$_POST['id_alt'];

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
    $sql= "delete from tab_usuario ";
    $sql.= "where us_id=".$_GET["nu"];

    if ($c->Execute($sql))
    {
      mensagem2("Registro excluído com sucesso!");
    }      
  }
?>