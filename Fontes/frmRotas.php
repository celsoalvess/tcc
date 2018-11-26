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

    if($_SESSION['perm'] != 2 && $_SESSION['perm'] != 4 && $_SESSION['perm'] != 5)
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
  <script src="http://www.openlayers.org/api/OpenLayers.js"></script>  
  <script type="text/javascript">
    var map,vectorLayer,selectMarkerControl,selectedFeature;
    var lat             =   -23.083357;
    var lon             =   -47.219190;
    var zoom            =   10;
    var curpos          =   new Array();
    var position;

    var fromProjection  =   new OpenLayers.Projection("EPSG:4326");   // Transform from WGS 1984
    var toProjection    =   new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
    var cntrposition    =   new OpenLayers.LonLat(lon, lat).transform( fromProjection, toProjection);

    function init()
    {
      map = new OpenLayers.Map("Map",{
        controls: 
        [
          new OpenLayers.Control.PanZoomBar(),                        
          new OpenLayers.Control.LayerSwitcher({}),
          new OpenLayers.Control.Permalink(),
          new OpenLayers.Control.MousePosition({}),
          new OpenLayers.Control.ScaleLine(),
          new OpenLayers.Control.OverviewMap(),
        ]
      }
      );
      var mapnik      = new OpenLayers.Layer.OSM("MAP"); 
      var markers     = new OpenLayers.Layer.Markers( "Markers" );

      map.addLayers([mapnik,markers]);
      map.addLayer(mapnik);
      map.setCenter(cntrposition, zoom);

      <?php
        require_once ("includes/pg_cnn.php");
        $sql = 'select ST_X(cl.cl_xy) cl_nox, ST_Y(cl.cl_xy) cl_noy, cl_eq from tab_cliente cl';
        $consulta = $c->Execute($sql);
        while (!$consulta->EOF)
        {
          echo "cntrposition = new OpenLayers.LonLat(".$consulta->fields[1].", ".$consulta->fields[0].").transform( fromProjection, toProjection);";
          echo "markers.addMarker(new OpenLayers.Marker(cntrposition));";
          $consulta->MoveNext();
        }
      ?>

      var click = new OpenLayers.Control.Click();
      map.addControl(click);

      click.activate();
    };

    OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {               
    defaultHandlerOptions: {
      'single': true,
      'double': false,
      'pixelTolerance': 0,
      'stopSingle': false,
      'stopDouble': false
    },

    initialize: function(options) {
      this.handlerOptions = OpenLayers.Util.extend(
      {}, this.defaultHandlerOptions
      );
    OpenLayers.Control.prototype.initialize.apply(
      this, arguments
    );
    this.handler = new OpenLayers.Handler.Click(
      this, {
        'click': this.trigger
      }, this.handlerOptions
    );
   },

  trigger: function(e) {
    var lonlat = map.getLonLatFromPixel(e.xy);
      lonlat1= new OpenLayers.LonLat(lonlat.lon,lonlat.lat).transform(toProjection,fromProjection);
      addElement(lonlat1.lat, lonlat1.lon);
  }
  });

  function addElement(v_lat, v_lon)
  {
    var campos_max = 10;
    var x = 1;

    if (x < campos_max) {
      $('#campos').append('<div class="form-control">\
        <input type="text" name="lat[]" value="'+v_lat+'" readonly>\
        <input type="text" name="lon[]" value="'+v_lon+'" readonly>\
        <a href="#" class="btn btn-danger btn-sm" id="btn_sair" onclick="remove_div()">Remover</a>\
      </div>');
      x++;
    }
  }

  // Remover o div anterior
  $('#btn_sair').on("click",".btn",function(e) {
    e.preventDefault();
    $(this).parent('div').remove();
    x--;
  });
  </script>
</head>
<body onload="init();">  
  <?php 
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
                <div id="Map" style="height: 500px"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <form method="post" action="frmRotas.php?try=1">
        <label for="vendedor">Selecione o vendedor</label>
        <select id="vendedor" class="form-control" name= "vendedor">
          <?php
            //inclui arquivo de conexão somenete se necessário
            require_once ("includes/pg_cnn.php");
            $sql = 'select us_nome, us_email, us_nome||\'|\'||us_email as campo from tab_usuario where us_perm=5';//somente vendedores
            $consulta = $c->Execute($sql);
            while (!$consulta->EOF)
            {
              echo "<option value=\"".$consulta->fields[2]."\">".$consulta->fields[0]."->".$consulta->fields[1]."</option>";
              $consulta->MoveNext();
            }
          ?>
        </select>
        <div id="campos">
          <!-- Adicionar os campos conforme clicar no mapa -->
        </div>       
        <button type="submit" class="btn btn-success btn-sm" id="btn_confirma">Confirmar</button>
      </form>
      
    </div>    
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous" style=""></script>
</body>
</html>
<?php 
  if($_GET['try'] == 1)
  {   
    $vendedor = explode("|", $_POST['vendedor']);
    $nome = $vendedor[0];
    $email = $vendedor[1];
    $msg= "Sr(a) ".$nome." segue a sua rota de ".date("m.d.y");
    $msg.= "<br";

    for($i=0; $i <= count($_POST['lat']); $i++)
    {
      $lat = $_POST['lat'][$i];
      $lon = $_POST['lon'][$i];
      $url = "http://nominatim.openstreetmap.org/reverse?&format=xml&lat=".$lat."&lon=".$lon."&zoom=21&addressdetails=1";
      $xml = simplexml_load_file($url);
      $rua = $xml->addressparts->road;
      $cidade = $xml->addressparts->city;
      $bairro = $xml->addressparts->suburb;
      $estado = $xml->addressparts->state;             

      //envia a rota para o email do vendedor
      $msg.= "Visita ".($i+1)." Lat: ".$lat." Lon: ".$lon;
      $msg.= "<br>";
      $msg.= "Endereço-> ".$rua." Cidade: ".$cidade." Bairro: ".$bairro." Estado: ".$estado;
    }
    mail($email, "Rota para ".$nome, $msg, "From: rotas@teste.com.br");
  }
?>