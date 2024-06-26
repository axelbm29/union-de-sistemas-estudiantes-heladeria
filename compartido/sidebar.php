<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav" style="margin-top: 15px;">
    <li class="nav-item">
      <a class="nav-link" href="http://localhost:84/gestion-estudiantes/dashboard.php">
        <i class="fas fa-home menu-icon mr-3"></i>
        <span class="menu-title">Home</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="fas fa-calendar-alt menu-icon mr-3"></i>
        <span class="menu-title">Periodo Academico</span>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloCicloAcademico/add-periodo.php">
              <i class="fas fa-plus-circle mr-3"></i> Agregar Periodo Academico
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloCicloAcademico/manage-periodo.php">
              <i class="fas fa-pencil-alt mr-3"></i> Gestionar Periodo Academico
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
        <i class="fas fa-user-graduate menu-icon mr-3"></i>
        <span class="menu-title">Estudiantes</span>
      </a>
      <div class="collapse" id="ui-basic1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloEstudiante/add-students.php">
              <i class="fas fa-user-plus mr-3"></i> Agregar Estudiante
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloEstudiante/manage-students.php">
              <i class="fas fa-user-edit mr-3"></i> Gestionar Estudiante
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#at" aria-expanded="false" aria-controls="at">
        <i class="fas fa-clipboard-check menu-icon mr-3"></i>
        <span class="menu-title">Asistencia</span>
      </a>
      <div class="collapse" id="at">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloAsistencia/asistencia.php">
              <i class="fas fa-calendar-check mr-3"></i> Registrar Asistencia
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloAsistencia/show-asistencia.php">
              <i class="fas fa-calendar-alt mr-3"></i> Ver Asistencias
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
        <i class="fas fa-chalkboard-teacher menu-icon mr-3" style="margin-left: -5px;"></i>
        <span class="menu-title">Docentes</span>
      </a>
      <div class="collapse" id="auth">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloDocente/add-docente.php">
              <i class="fas fa-user-plus mr-3"></i> Agregar Docente
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloDocente/manage-docente.php">
              <i class="fas fa-user-edit mr-3"></i> Gestionar Docente
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#auth1" aria-expanded="false" aria-controls="auth1"
        style="margin-left: -1px;">
        <i class="fas fa-book menu-icon mr-3"></i>
        <span class="menu-title">Notas</span>
      </a>
      <div class="collapse" id="auth1">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloNotas/add-notas.php">
              <i class="fas fa-plus-circle mr-3"></i> Agregar Notas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost:84/gestion-estudiantes/moduloNotas/manage-notas.php">
              <i class="fas fa-pencil-alt mr-3"></i> Gestionar Notas
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#pays" aria-expanded="false" aria-controls="pays"
        style="margin-left: -1px;">
        <i class="fas fa-money-bill-alt menu-icon mr-3"></i>
        <span class="menu-title">Pagos</span>
      </a>
      <div class="collapse" id="pays">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost/gestion-estudiantes/moduloPagos/add-pagos.php">
              <i class="fas fa-plus-circle mr-3"></i> Agregar Pagos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" style="color:white;"
              href="http://localhost/gestion-estudiantes/moduloPagos/manage-pagos.php">
              <i class="fas fa-pencil-alt mr-3"></i> Gestionar Pagos
            </a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="http://localhost/gestion-estudiantes/reporte.php" style="margin-left: -5px;">
        <i class="fas fa-flag menu-icon mr-3"></i>
        <span class="menu-title">Reportes</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="http://localhost/gestion-estudiantes/search.php" style="margin-left: -5px;">
        <i class="fas fa-search menu-icon mr-3"></i>
        <span class="menu-title">Busqueda</span>
      </a>
    </li>
  </ul>
</nav>