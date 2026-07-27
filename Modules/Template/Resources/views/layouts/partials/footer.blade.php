<!-- app footer -->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 265">
    <path class="svg-color-footer" fill-opacity="1" d="M0,256L60,240C120,224,240,192,360,181.3C480,171,600,181,720,202.7C840,224,960,256,1080,256C1200,256,1320,224,1380,208L1440,192L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z">
    </path>
</svg>
<div class="appFooter">
    <div class="footer-title">
        <a href="https://enterwind.com">
        <!-- Support By <img src="https://enterwind.com/favicon.png" alt="icon" class="footer-logo"> -->
        BAPPEDALITBANG {{Carbon\Carbon::now()->year}} ver.{{ env('APP_VERSION') }}. All Rights Reserved.
        </a>
    </div>
    <div class="mb-1 text-white">{{env('APP_DESCRIPTION')}}.</div>
    
    {{-- <div class="mt-2">
        <a href="javascript:;" class="btn btn-icon btn-sm btn-facebook">
            <ion-icon name="logo-facebook"></ion-icon>
        </a>
        <a href="javascript:;" class="btn btn-icon btn-sm btn-twitter">
            <ion-icon name="logo-twitter"></ion-icon>
        </a>
        <a href="javascript:;" class="btn btn-icon btn-sm btn-linkedin">
            <ion-icon name="logo-linkedin"></ion-icon>
        </a>
        <a href="javascript:;" class="btn btn-icon btn-sm btn-instagram">
            <ion-icon name="logo-instagram"></ion-icon>
        </a>
        <a href="javascript:;" class="btn btn-icon btn-sm btn-whatsapp">
            <ion-icon name="logo-whatsapp"></ion-icon>
        </a>
        <a href="#" class="btn btn-icon btn-sm btn-secondary goTop">
            <ion-icon name="arrow-up-outline"></ion-icon>
        </a>
    </div>
 --}}
</div>
<!-- * app footer -->
