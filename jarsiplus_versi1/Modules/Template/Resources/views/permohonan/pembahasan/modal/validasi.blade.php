<!-- Upload Action Sheet -->
<div class="modal fade action-sheet inset" id="addActionSheet" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title text-uppercase">Validasi Berkas</h5>
            </div>

            {!! Form::model($data, ['route' => ["$prefix.validate", [$parent->uuid,$data->uuid]], 'autocomplete' => 'off', 'method' => 'PUT','files'=>true]) !!}

            <div class="modal-body px-3">
                
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label pb-2" for="label">Berkas ini telah dinyatakn valid, jika anggota Pembahas telah memberikan rekomendasi persetujuan, yang di wakilkan dengan tombol di bawah ini.</label>
                        <ul class="listview image-listview">
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                       <ion-icon name="checkmark-sharp"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>setujui berkas</div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="validate" class="custom-control-input" id="validate"/>
                                            <label class="custom-control-label" for="validate"></label>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <label class="label text-muted pt-3" for="label">Dengan ini saya menyatakan bahwa berkas ini telah sesuai dengan persyaratan yang telah ada, dan hasil validasi saya dapat sebagai rujukan admin dalam merubah status berkas tersebut.</label>

                    </div>
                </div>

                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
               
            </div>
            {!! Form::close() !!}
            
        </div>
    </div>
</div>
<!-- * Upload Action Sheet -->