<!-- Upload Action Sheet -->
<div class="modal fade action-sheet inset" id="addActionSheet" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title text-uppercase">Perbaikan Berkas</h5>
            </div>
            {!! Form::model($data, ['route' => ["$prefix.update", [$parent->uuid,$data->uuid]], 'autocomplete' => 'off', 'method' => 'PUT','files'=>true]) !!}

            <div class="modal-body px-3">
                
                <div class="form-group boxed">
                    <div class="input-wrapper">
                        <label class="label require-form" for="label">File Berkas</label>
                        <div class="custom-file-upload">
                            <input type="file" name="file" id="file-upload" accept=".pdf, .doc, .docx">
                            <label for="file-upload">
                                <span>
                                    <strong>
                                        <ion-icon name="cloud-upload-outline"></ion-icon>
                                        <i>Tap to Upload</i>
                                    </strong>
                                </span>
                            </label>
                        </div>
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