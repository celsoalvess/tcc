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
  <link rel="stylesheet" href="https://openlayers.org/en/v4.6.5/css/ol.css" type="text/css">
  <script src="https://openlayers.org/en/v4.6.5/build/ol.js" type="text/javascript"></script>
  <script src="js/mapa.js" type="text/javascript"></script>  
</head>
  <?php 
    $sql = 'select ST_X(cl.cl_xy) cl_nox, ST_Y(cl.cl_xy) cl_noy, cl_eq from tab_cliente cl';
    echo "<body onload=\"initialize_map();";
    $consulta = $c->Execute($sql);
    while (!$consulta->EOF)
    {
      if ($consulta->fields[2] == 0 || $consulta->fields[2] == '' || $consulta->fields[2] == null)
      {
        echo "add_map_point_yell(".$consulta->fields[0].", ".$consulta->fields[1].");";
      }
      else
      {
        echo "add_map_point(".$consulta->fields[0].", ".$consulta->fields[1].");";
      }
      $consulta->MoveNext();
    }
    echo "\">";

    //inclui o script que gera o menu superior de acordo com as permissões
    include "nav.php";
  ?>
  <div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-primary text-white" id="topo_cad">Cadastro de rotas</div>
            <div class="card-body">
              <div class="tab-content mt-2">
                <div id="map" onclick="getLocation()"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous" style=""></script>
  <script type="text/javascript">
  
  function getLocation()
  {
    if (navigator.geolocation)
    {
      navigator.geolocation.getCurrentPosition(showPosition);
      alert("Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;);
    }
    else
    {
      x.innerHTML="O seu navegador não suporta Geolocalização.";
    }
  }

  function showPosition(position)
  {
    x.innerHTML="Latitude: " + position.coords.latitude +
    "<br>Longitude: " + position.coords.longitude; 
  }
</script>
</body>
</html>