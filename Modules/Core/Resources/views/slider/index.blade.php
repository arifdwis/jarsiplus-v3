@extends('layouts.app')
@section('title', $title)

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.0/lity.min.css">
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lity/2.4.0/lity.min.js"></script>
<script>
    var table = HSCore.components.HSDatatables.init('.js-datatable', {
        scrollY: 'calc(100vh - 250px)',
        ajax : '{!! request()->fullUrl() !!}?datatable=true', 
        columns: [
            { data: 'pilihan', name: 'pilihan', className: 'text-center', orderable: false, searchable: false },
            { data: 'id', name: 'id' },
            { data: 'file', name: 'file' },
            { data: 'judul', name: 'judul' },
            { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false }
        ],
        @include('nue::partials.datatable.script')
    });

    function openCreateSliderModal() {
        $('#createLabel').val('');
        $('#createSliderFileInput').val('');
        $('#createSliderPreview').attr('src', '{{ asset("assets/img/holder.jpg") }}');
        var modal = new bootstrap.Modal(document.getElementById('modalCreateSlider'));
        modal.show();
    }

    function openEditSliderModal(url, label, fileUrl) {
        $('#formEditSlider').attr('action', url);
        $('#editLabel').val(label);
        $('#editSliderPreview').attr('src', fileUrl);
        var modal = new bootstrap.Modal(document.getElementById('modalEditSlider'));
        modal.show();
    }

    function previewSliderImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function deleteSliderItem(url) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Slider?',
                text: "Data slider ini akan dihapus dari sistem.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';
                    form.innerHTML = '<input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="{{ csrf_token() }}">';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    }
</script>
@endsection

@section('content')
{!! Form::open(['method' => 'DELETE', 'route' => ["$prefix.destroy", 'hapus-all'], 'id' => 'submit-all']) !!}

@include('layouts.breadcrumb', ['lists' => [
'Dashboard' => 'javascript:;', 
$title => 'active'
]])

@include('layouts.datatable.header', [
'title' => $title, 
'description' => 'Here is a list of all your data from your database.', 
'create' => 'javascript:openCreateSliderModal()', 
'datatable' => true
])

<div class="card card-bordered shadow-none rounded-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="datatable" class="js-datatable align-middle table-bordered table table-sm table-hover table-thead-bordered table-nowrap">
                <thead class="thead-light">
                    <tr>
                        <th class="table-column-pr-0" width="1">
                            <div class="form-check mb-0">
                                <input id="datatable-checkbox-check" type="checkbox" class="form-check-input">
                                <label class="form-check-label" for="check-all"></label>
                            </div>
                        </th>
                        <th width="1">ID</th>
                        <th width="10%">Preview</th>
                        <th>Judul</th>
                        <th width="1">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    @include('layouts.datatable.footer')
</div>

{!! Form::close() !!}

{{-- MODAL CREATE SLIDER --}}
<div class="modal fade" id="modalCreateSlider" tabindex="-1" aria-labelledby="modalCreateSliderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header border-bottom px-4 py-3 bg-white">
                <h5 class="modal-title font-weight-bold mb-0" id="modalCreateSliderLabel" style="font-size: 1.1rem; color: #1E293B;">Tambah Slider Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route($prefix.'.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-4" style="background: #FFFFFF;">
                    {{-- Judul / Label --}}
                    <div class="mb-4">
                        <label class="form-label font-weight-bold mb-2" style="font-size: 13.5px; color: #334155;">Judul / Label Slider <span class="text-danger">*</span></label>
                        <input type="text" name="label" id="createLabel" class="form-control" required placeholder="Judul slider..." style="font-size: 14px; border-radius: 8px; padding: 10px 14px;">
                    </div>

                    {{-- File Banner --}}
                    <div>
                        <label class="form-label font-weight-bold mb-2" style="font-size: 13.5px; color: #334155;">File Gambar (Landscape)</label>
                        
                        <div class="d-flex align-items-center gap-3 p-3 border rounded-3" style="background: #F8FAFC; border-color: #E2E8F0 !important;">
                            <div class="flex-shrink-0 border rounded-2 overflow-hidden bg-white shadow-sm" style="width: 130px; height: 75px;">
                                <img id="createSliderPreview" src="{{ asset('assets/img/holder.jpg') }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            </div>
                            <div class="flex-grow-1">
                                <label class="form-label small font-weight-bold text-secondary mb-1">Pilih File Slider</label>
                                <input type="file" name="file" id="createSliderFileInput" class="form-control form-control-sm" accept="image/*" onchange="previewSliderImage(this, 'createSliderPreview')" style="border-radius: 6px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light btn-sm font-weight-bold px-3" data-bs-dismiss="modal" style="border: 1px solid #CBD5E1;">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-4" style="border-radius: 6px;">Simpan Slider</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT SLIDER --}}
<div class="modal fade" id="modalEditSlider" tabindex="-1" aria-labelledby="modalEditSliderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 14px; overflow: hidden;">
            <div class="modal-header border-bottom px-4 py-3 bg-white">
                <h5 class="modal-title font-weight-bold mb-0" id="modalEditSliderLabel" style="font-size: 1.1rem; color: #1E293B;">Edit Slider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditSlider" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4" style="background: #FFFFFF;">
                    {{-- Judul / Label --}}
                    <div class="mb-4">
                        <label class="form-label font-weight-bold mb-2" style="font-size: 13.5px; color: #334155;">Judul / Label Slider <span class="text-danger">*</span></label>
                        <input type="text" name="label" id="editLabel" class="form-control" required placeholder="Judul slider..." style="font-size: 14px; border-radius: 8px; padding: 10px 14px;">
                    </div>

                    {{-- File Banner --}}
                    <div>
                        <label class="form-label font-weight-bold mb-2" style="font-size: 13.5px; color: #334155;">File Gambar (Landscape)</label>
                        
                        <div class="d-flex align-items-center gap-3 p-3 border rounded-3" style="background: #F8FAFC; border-color: #E2E8F0 !important;">
                            <div class="flex-shrink-0 border rounded-2 overflow-hidden bg-white shadow-sm" style="width: 130px; height: 75px;">
                                <img id="editSliderPreview" src="" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            </div>
                            <div class="flex-grow-1">
                                <label class="form-label small font-weight-bold text-secondary mb-1">Ganti File Slider (Opsional)</label>
                                <input type="file" name="file" class="form-control form-control-sm" accept="image/*" onchange="previewSliderImage(this, 'editSliderPreview')" style="border-radius: 6px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light btn-sm font-weight-bold px-3" data-bs-dismiss="modal" style="border: 1px solid #CBD5E1;">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm font-weight-bold px-4" style="border-radius: 6px;">Perbarui Slider</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection