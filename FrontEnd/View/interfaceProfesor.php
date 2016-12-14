<div class="row" ng-controller="controllerInterfaceProf">
  <div class="row">
      <div class="col-lg-4 col-lg-offset-1 jumbotron">
        <table class="table">
          <tr>
            <th><b>ARCHIVOS SUBIDOS POR EL PROFESOR</b></th>
          </tr>
          <tr data-ng-repeat="x in archi_sub">
            <td>{{x.nombre_archivo}}</td>
            <td>{{x.asignatura}}</td>
            <td>{{x.contra}}</td>
          </tr>
        </table>
        <br>
        <button type="button" class="btn btn-success btn-lg btn-block" data-ng-click="recargar()">Cargar actualizaciones</button>
        <br>
        <br>
        <h4><p class="text-center">SUBIR ARCHIVOS</p></h4>
        <div class="form-group">
            <br>
            <input type="file"  file-model = "myFile" >
            <br>
            <button type="button" class="btn btn-success btn-lg btn-block" data-ng-click="uploadFile()">Subir</button>
        </div>
      </div>
      <div class="col-lg-4 col-lg-offset-1">
        <div class="jumbotron">
          <h5><b>ARCHIVOS SUBIDOS POR LOS ALUMNOS</b></h5>
          <form name="myForm2">
            <select name="repeatSelect" class="form-control" ng-model='data2.model'>
              <option ng-repeat="opti in archi_sub_alumnos" value="{{opti.nombre_archivo}}">{{opti.nombre_archivo}} </option>
            </select>
              <br>
          </form>
          <?php
          $enlace = "BackEnd/LoginProf/download.php?profesor=" . "{{profesor_logeado}}" . "&" . "archivo=" .  "{{data2.model}}";
          echo "<a href='$enlace'>Descargar archivo seleccionado</a>";
           ?>
        </div>
        <div class="jumbotron">
            <h5><b>OTRAS OPCIONES</b></h5>
          <!-- <button type="button" class="btn btn-primary" data-ng-click="agregarProfesor()">Añadir</button>
          <button type="button" class="btn btn-danger" data-ng-click="eliminarProfesor()">Eliminar</button> -->
          <button type="button" class="btn btn-success" data-ng-click="cerrarSesion()">Cerrar Sesion</button>
        </div>
      </div>
  </div>
</div>
