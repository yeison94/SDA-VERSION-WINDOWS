<div class="row" ng-controller="controllerInterfaceEst">
  <div class="col-lg-3 col-lg-offset-1">
    <div>
      <p>
        <h3>SELECCIONA EL CURSO</h3>
      </p>
      <form name="myForm">
        <select name="repeatSelect" class="form-control" ng-model='data.model'>
          <option ng-repeat="opti in oferta" value="{{opti.asignatura}}">{{opti.asignatura}} </option>
        </select>
          <br>
      </form>
      <br>
       <button type="button" class="btn btn-success btn-lg btn-block" data-ng-click="archivos_montados()">Seleccionar curso</button>
     <br>
      <p>
        {{data.singleSelect}}
      </p>
    </div>
    <div class="alert alert-info" role="alert">
      <p>
        -Para descargar un archivo montado por el profesor o subir un archivo, por favor primero seleccione el curso
      </p>
    </div>
    <br>
    <div class="alert alert-info" role="alert">
      <p>
        -El nombre del archivo a subir, debe tener un nombre que no tenga los archivos ya subidos por otros alumnos
      </p>
    </div>
  </div>
  <div class="col-lg-5 col-lg-offset-1">
    <div class="jumbotron">
      <h4><p class="text-center">  Material subido por el docente</p></h4>
      <form name="myForm2">
        <select name="repeatSelect2" class="form-control" ng-model='data2.model'>
          <option ng-repeat="opti in archi_sub" value="{{opti.nombre_archivo}}">{{opti.nombre_archivo}} </option>
        </select>
          <br>
      </form>
      <br>
      <div data-ng-init="enlace_descargar = '<?php
      $enlace = "BackEnd/LoginEst/download.php?curso=" . "{{data.model}}" . "&" . "archivo=" .  "{{data2.model}}";
      echo $enlace;
       ?>'">
      </div>
      <br>
      <?php
      $enlace = "BackEnd/LoginEst/download.php?curso=" . "{{data.model}}" . "&" . "archivo=" .  "{{data2.model}}";
      echo "<a href='$enlace'>Descargar archivo seleccionado</a>";
       ?>
      <!-- <button type="button" class="btn btn-success btn-lg btn-block"><a href={{enlace_descargar}}>Descargar archivo seleccionado</a></button> -->
       <!-- <button type="button" class="btn btn-success btn-lg btn-block" data-ng-click="descargar_archivo()">Descargar archivo seleccionado</button> -->
    </div>
    <div class="jumbotron">
      <h4><p class="text-center">Subir archivo</p></h4>
      <br>
      <div class="form-group">
          <br>
          <input type="file"  file-model = "myFile" >
          <br>
          <button type="button" class="btn btn-success btn-lg btn-block" data-ng-click="uploadFile()">Subir</button>
      </div>
    </div>
    <!-- <div>
      <?php
      $enlace = "BackEnd/LoginEst/download.php?curso=" . "{{data.model}}" . "&" . "archivo=" .  "{{data2.model}}";
      echo $enlace;
       ?>
    </div> -->

  </div>
</div>
