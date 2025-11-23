<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <small class="text-muted font-size-sm ml-2"></small></h3>
        <a href="javascript:void(0)" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <div class="offcanvas-content">
        <div class="symbol symbol-100">
            <div class="symbol-label" style="background-image:url('{{ asset('metronic/media/users/default.jpg') }}"></div>
        </div>
        <div class="row">
            <div class="col-12 mt-4">
                <span class="font-weight-bold font-size-h5 text-dark-75">{{ Auth::user()->nombre_completo }}</span> <br>
                <span class="font-weight-bold font-size-h5 text-dark-75">{{ Auth::user()->rfc }}</span>
            </div>
            <div class="col-12 mt-1">
                <span>{{ Auth::user()->email }}</span>
            </div>
            <div class="col-12 mt-1">
                <span class="text-uppercase"> {{ Auth::user()->area->identificador }} - {{ Auth::user()->area->nombre }} </span>
            </div>
        </div>
        <div class="separator separator-solid my-8"></div>
        <div class="row">
            <div class="col-12">
                @foreach (Auth::user()->roles as $rol)
                    <span class="badge badge-success mb-2"> {{ $rol->label }} </span>
                @endforeach
            </div>
        </div>    
        <div class="separator separator-solid mt-6 mb-8"></div>
        <div class="row">
            <div class="col-12">
                <a href="javascript:void(0)" class="btn btn-danger btn-block" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </div> 
        </div>
    </div>
</div>