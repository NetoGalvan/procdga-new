<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
        <ul class="menu-nav">
            {{-- <li class="menu-item @if($asideMenu['item_seleccionado'] === 'index') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('home') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-home @if($asideMenu['item_seleccionado'] === 'index') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Inicio</span>
                </a>
            </li> --}}
            @role("SUPER_ADMIN")
            <li class="menu-section mt-0">
                <h4 class="menu-text">ADMINISTRACIÓN</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'admin.usuarios') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('usuarios.index') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-users @if($asideMenu['item_seleccionado'] === 'admin.usuarios') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Usuarios</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'admin.roles') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('roles.index') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-user-tag @if($asideMenu['item_seleccionado'] === 'admin.roles') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Roles</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'admin.unidades') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('unidades.index') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-building @if($asideMenu['item_seleccionado'] === 'admin.unidades') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Unidades</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'admin.alfabetico') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('alfabetico.index') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-user-tie @if($asideMenu['item_seleccionado'] === 'admin.alfabetico') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Empleados</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'admin.formatos') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('formatos.index') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-file-pdf @if($asideMenu['item_seleccionado'] === 'admin.formatos') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Formatos</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'admin.logs') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('logs.index') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-exclamation-circle @if($asideMenu['item_seleccionado'] === 'admin.logs') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Logs</span>
                </a>
            </li>
            @endrole
            <li class="menu-section">
                <h4 class="menu-text">PROCDGA</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'tareas') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('tareas') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-tasks @if($asideMenu['item_seleccionado'] === 'tareas') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Tareas</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'notificaciones') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('notificaciones') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-bell @if($asideMenu['item_seleccionado'] === 'notificaciones') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Notificaciones <span id="total_notificaciones"></span></span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'procesos-en-curso') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('procesos.en.curso') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-sync @if($asideMenu['item_seleccionado'] === 'procesos-en-curso') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Procesos en curso</span>
                </a>
            </li>
            {{-- <li class="menu-item @if($asideMenu['item_seleccionado'] === 'tramites') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('tramites') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-folder-open @if($asideMenu['item_seleccionado'] === 'tramites') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Trámites</span>
                </a>
            </li> --}}
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'procesos') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('procesos') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-cog @if($asideMenu['item_seleccionado'] === 'procesos') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Procesos</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'reportes') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('reportes') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-file-excel @if($asideMenu['item_seleccionado'] === 'reportes') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Reportes</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'catalogos') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('catalogos') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-clipboard-list @if($asideMenu['item_seleccionado'] === 'catalogos') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Catálogos</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'archivos-externos') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('archivos.externos') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-file-download @if($asideMenu['item_seleccionado'] === 'archivos-externos') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Archivos externos</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'manuales') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('manuales') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-book @if($asideMenu['item_seleccionado'] === 'manuales') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Manuales de usuario</span>
                </a>
            </li>
            <li class="menu-item @if($asideMenu['item_seleccionado'] === 'lineamientos') menu-item-active @endif" aria-haspopup="true">
                <a href="{{ Route('lineamientos') }}" class="menu-link">
                    <span class="menu-icon">
                        <i class="fas fa-file-alt @if($asideMenu['item_seleccionado'] === 'lineamientos') icon-active @endif"></i>
                    </span>
                    <span class="menu-text">Lineamientos</span>
                </a>
            </li>
        </ul>
    </div>
</div>
