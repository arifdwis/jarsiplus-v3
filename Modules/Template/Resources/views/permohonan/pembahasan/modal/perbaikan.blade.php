<!-- Upload Action Sheet -->
<div class="modal fade action-sheet inset" id="addActionSheet" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title text-uppercase">
                    @if($data->jenis == 'url')
                        Perbarui Link
                    @else
                        Perbaikan Berkas
                    @endif
                </h5>
            </div>
            {!! Form::model($data, ['route' => ["$prefix.update", [$parent->uuid, $data->uuid]], 'autocomplete' => 'off', 'method' => 'PUT', 'files' => true]) !!}

            <div class="modal-body px-3">

                @if ($errors->any())
                    <div class="alert alert-danger mb-2">
                        <ul class="mb-0 pl-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($data->jenis == 'url')
                    {{-- Jenis URL: tampilkan field URL --}}
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label require-form" for="url">URL / Link</label>
                            {!! Form::text('url', $data->url, ['class' => 'form-control', 'placeholder' => 'Masukkan URL lengkap (https://...)']) !!}
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                @else
                    {{-- Jenis File: tampilkan field file upload --}}
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <label class="label require-form" for="file-upload">File Berkas</label>
                            <div
                                style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 8px 12px; font-size: 12px; color: #856404; margin-bottom: 10px;">
                                <strong>⚠ Perhatian:</strong> Ukuran file maksimal <b>10 MB</b>
                            </div>
                            <div class="custom-file-upload">
                                <input type="file" name="file" id="file-upload-perbaikan"
                                    accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.mp4">
                                <label for="file-upload-perbaikan">
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
                @endif


                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>

            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>
<!-- * Upload Action Sheet -->

@section('js')
    @parent
    <script>
        // Validasi ukuran file maksimal 10MB pada perbaikan
        $(document).ready(function () {
            $('#file-upload-perbaikan').on('change', function () {
                var file = this.files[0];
                if (file && file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file maksimal 10 MB! File yang dipilih: ' + (file.size / 1024 / 1024).toFixed(2) + ' MB');
                    $(this).val('');
                }
            });
        });
    </script>
@endsection