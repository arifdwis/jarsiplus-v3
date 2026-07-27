<!-- iOS Add to Home Action Sheet -->
<div class="modal inset fade action-sheet ios-add-to-home" style="display: block;" id="ios-add-to-home-screen" tabindex="-1"
    role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add to Home Screen</h5>
                <a href="javascript:;" class="close-button" data-dismiss="modal">
                    <ion-icon name="close"></ion-icon>
                </a>
            </div>
            <div class="modal-body">
                <div class="action-sheet-content text-center">
                    <div class="mb-1"><img src="{{asset('images/logo-mobile/android/Icon-48.png')}}" alt="image" class="imaged w48">
                    </div>
                    <h4>{{env('APP_NAME')}}</h4>
                    <div class="mb-2">
                        Install {{env('APP_NAME')}} on your Phone's home screen.
                    </div>
                    <div>
                        <button class="add-button btn btn-sm btn-primary w-100">Add to home screen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- * iOS Add to Home Action Sheet -->