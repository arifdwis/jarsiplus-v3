<!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Header -->
    <div class="appHeader bg-primary scrolled">
        <div class="left">

            @if(Nue::user())
            
            <a href="{{ route('sso.logout') }}" class="headerButton">
                <ion-icon name="log-out-outline"></ion-icon>
            </a>

            @else

            <a href="{{ route('sso.authorize') }}" class="headerButton">
                <ion-icon name="finger-print-outline"></ion-icon>
            </a>
            @endif


            <div class="pageTitle">
                {{env('APP_NAME')}}
            </div>
        </div>
        
        <div class="right"> 
            @if(Nue::user())
            <!-- top right -->
            <div class="fab-button animate top-right dropdown">
                <a href="#" class="fab" data-toggle="dropdown" style="background: #fff;">
                    <ion-icon name="add-outline"></ion-icon>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{route('settings')}}">
                        <ion-icon name="settings-outline"></ion-icon>
                        <p>Pengaturan</p>
                    </a>
                    <a class="dropdown-item" href="{{route('permohonan.index')}}">
                        <ion-icon name="briefcase-outline"></ion-icon>
                        <p>Permohonan</p>
                    </a>
                    
                </div>
            </div>
            <!-- * top right -->
            @else

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input dark-mode-switch" id="darkmodeswitch">
                <label class="custom-control-label" for="darkmodeswitch"></label>
            </div>    

            @endif
        </div>


    </div>
    <!-- * App Header -->

    <!-- Search Component -->
    <div id="search" class="appHeader">
        <form class="search-form">
            <div class="form-group searchbox">
                <input type="text" class="form-control" placeholder="Search...">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
                <a href="javascript:;" class="ml-1 close toggle-searchbox">
                    <ion-icon name="close-circle"></ion-icon>
                </a>
            </div>
        </form>
    </div>
    <!-- * Search Component -->
