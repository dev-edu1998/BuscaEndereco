<!DOCTYPE html>
<html lang="pt-br">
    
    <head>
        <meta charset="UTF-8" content="text/html">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Busca de endereço</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

   
   <style type="text/css">
      
      * { margin: 0; padding: 0; font-family:Tahoma; font-size:9pt;}
        #Center { 
                background-color: #87CEFA; 
                width: 400px; 
                height: 450px; 
                left: 50%; 
                margin: -130px 0 0 -210px; 
                padding:10px;
                position: absolute; 
                border-radius: 6%;
                top: 30%; }

   </style>

    </head>

       <body>
       
              
        <div class="container" id="Center">
               <h1>Consulta de CEP</h1><br><br>
               <form id="frmPost" class="form" method="get" action=".">
                  <div class="justify-content-center">
                     <div class="form-group">    
                        <label for="validationCep" id="validationCustom03">CEP</label>
                        <input type="text" class="form-control" maxlength="9" value size="60" id="cep" required placeholder=CEP onChange="buscarEndereco()">
                        <div style="display:none;" id="erroCep" class="invalid-feedback">
                           Por favor, insira um cep válido.
                        </div>

                     </div>
                  </div>

                  <div class="form-group">
                     <label for="logradouro">Logradouro</label>
                     <input type="text" class="form-control" id="logradouro" readonly>
                     <small>Rua.</small>
                  </div>

                  <div class="form-group">
                     <label for="bairro">Bairro</label>
                     <input type="text" class="form-control" id="bairro" readonly>
                     <small>Bairro</small>
                  </div>
                  <div class="row">
                     <div class="col-8">
                        <div class="form-group">
                           <label for="localidade">Localidade</label>
                           <input type="text" class="form-control" id="localidade" readonly>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="form-group">
                           <label for="uf">UF</label>
                           <input type="text" id="uf" class="form-control" readonly>
                           <small>Estado</small>
                        </div>
                     </div>
                  </div>   
               </form>
            </div> 
        </div>
        <script type='text/javascript'>
         
        
            function buscarEndereco(){
               
               var cep = document.getElementById('cep').value

               var httpRequest = new XMLHttpRequest();
               httpRequest.open('GET', 'requisicaoXML.php?cep='+cep, true);
               httpRequest.onreadystatechange = () => {
                  if(httpRequest.readyState == 4 && httpRequest.status == 200){
                    if(httpRequest.responseText == 'existente'){
                       
                        alert('CEP já Consultado!')
                    }else{
                        xml()
                    }
                    
                  }
               }
               httpRequest.send();

            }
           
            function xml(){
               var httpRequestXML = new XMLHttpRequest();
               httpRequestXML.open('GET', 'recebe.xml', true);
               httpRequestXML.onreadystatechange = () => {
                  if(httpRequestXML.readyState == 4 && httpRequestXML.status == 200){
                     
                     var xmlDOC = httpRequestXML.responseXML.documentElement;
                        console.log(xmlDOC)
                    
                        if(xmlDOC.getElementsByTagName("erro")[0] === undefined){
                    
                        
                        var logradouro = xmlDOC.getElementsByTagName("logradouro");
                        document.getElementById('logradouro').value = logradouro[0].firstChild.textContent
                        
                        var bairro = xmlDOC.getElementsByTagName("bairro");
                        document.getElementById('bairro').value = bairro[0].firstChild.textContent

                        var localidade = xmlDOC.getElementsByTagName("localidade");
                        document.getElementById('localidade').value = localidade[0].firstChild.textContent
                        
                        var uf = xmlDOC.getElementsByTagName("uf");
                        document.getElementById('uf').value = uf[0].firstChild.textContent

                        var cep = document.getElementById('cep')
                        cep.classList.remove("is-invalid")
                        var erroCep = document.getElementById('erroCep')
                        erroCep.setAttribute("style","display:none")
                       
                        }else{
                           document.getElementById('logradouro').value = ''
                           document.getElementById('bairro').value = ''
                           document.getElementById('localidade').value = ''
                           document.getElementById('uf').value = ''
                           
                           var cep = document.getElementById('cep')
                           cep.classList.add("is-invalid")
                           var erroCep = document.getElementById('erroCep')
                           erroCep.removeAttribute("style","display:none")
                                                
                           }
                     
                  }
               }
               httpRequestXML.send();
            }
        
        </script>
     
       </body>

</html>