<dialog class="jp-modal" id="addActionSheet">
    <div class="jp-modal__head">
        <div class="u-flex u-align-center u-gap-sm">
            <span class="jp-modal__icon"><x-icon name="check-circle" size="20" /></span>
            <h3 class="jp-modal__title">Validasi Berkas</h3>
        </div>
        <button type="button" class="jp-modal__close" aria-label="Tutup" onclick="this.closest('dialog').close()">
            <x-icon name="close" size="22" />
        </button>
    </div>

    {!! Form::model($data, ['route' => ["$prefix.validate", [$parent->uuid,$data->uuid]], 'autocomplete' => 'off', 'method' => 'PUT','files'=>true]) !!}
        <div class="jp-modal__body">
            <p class="jp-field__hint u-mb-md">
                Berkas ini dinyatakan valid jika anggota Pembahas telah memberikan rekomendasi persetujuan.
            </p>

            {{--
                Sebelumnya kontrol ini berupa sakelar khusus dengan checkbox tersembunyi
                (opacity:0; width:0) dan handler onclick yang membaca status checkbox pada
                saat yang sama dengan label mengubahnya, sehingga tampilan sakelar bisa
                terbalik dari nilai yang sebenarnya terkirim. Diganti checkbox biasa.
            --}}
            <label class="jp-consent u-mb-md" for="validate">
                <input type="checkbox" name="validate" id="validate" value="1">
                <span><strong>Setujui berkas ini</strong> sebagai hasil validasi saya.</span>
            </label>

            <div class="jp-notice jp-notice--accent">
                <span class="jp-notice__icon"><x-icon name="shield" size="18" /></span>
                <div class="jp-notice__body">
                    <p class="jp-notice__text">
                        Dengan ini saya menyatakan bahwa berkas ini telah sesuai persyaratan, dan hasil
                        validasi saya dapat menjadi rujukan admin dalam mengubah status berkas tersebut.
                    </p>
                </div>
            </div>
        </div>

        <div class="jp-modal__foot">
            <button type="button" class="jp-btn jp-btn--ghost" onclick="this.closest('dialog').close()">Batal</button>
            <button type="submit" class="jp-btn jp-btn--accent">Simpan Validasi</button>
        </div>
    {!! Form::close() !!}
</dialog>
