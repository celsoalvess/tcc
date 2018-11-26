    function buscaCoord(p_num, p_lograd, p_cidade, p_uf){
      var xhttp = new XMLHttpRequest();
      var v_url = "https://nominatim.openstreetmap.org/search/"+p_num+"%20"+p_lograd+"%20"+p_cidade+"%20"+p_uf+"?format=json&addressdetails=0&limit=1";
      //var v_url2 = encodeURI(v_url);
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var res = JSON.parse(this.responseText);
          $("#txCox").val(res[0].lat);
          $("#txCoy").val(res[0].lon);
        }
      };

      xhttp.open("POST", v_url, true);
      xhttp.send();
    }

    $("#cidade").blur(function() {
      buscaCoord(document.getElementById("numero").value, document.getElementById("logradouro").value, document.getElementById("cidade").value, document.getElementById("estado").value);
    })