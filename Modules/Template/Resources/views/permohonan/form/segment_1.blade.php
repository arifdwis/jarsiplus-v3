@extends('template::layouts.master',['footer'=>false])

@section('content')
<div class="jp-section">
    <div class="l-container">
        @include('template::permohonan.form.header')

        <div class="l-grid l-grid--4">
            <div class="jp-card" style="grid-column:span 1">
                @include('template::partials.indikator-progress',['percen'=>10])
            </div>
            <div class="jp-card" style="grid-column:span 3">
                @if($data)
                    <form action="{{ route('permohonan.berkas.store',$data->uuid) }}" method="POST" class="u-flex u-flex-col u-gap-lg" style="padding:var(--p-card) !important" id="myForm">
                @else
                    <form action="{{ route('permohonan.berkas.store',$parent->uuid) }}" method="POST" class="u-flex u-flex-col u-gap-lg" style="padding:var(--p-card) !important" id="myForm">
                @endif
                    @csrf
                    @if($parent->status != 0 && role_me() == 4)
                        @php
                            $fields = array_column($biodata->toArray(), 'value', 'field');
                        @endphp
                        @foreach($indikator as $value)
                            @if($value->type == 'heading')
                                <div class="jp-section" style="padding:0">
                                    <div class="jp-section__head u-mb-md">
                                        <p class="jp-section__eyebrow">
                                            <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                                            {{ $value->label }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                            @if($value->type == 'field')
                                @php $val = $fields[$value->name] ?? null; @endphp
                                @if($value->input == 'text' || $value->input == 'number')
                                    <x-field
                                        :id="$value->name"
                                        :name="$value->name"
                                        :label="$value->label"
                                        :value="$val"
                                        :type="$value->input"
                                        :required="$value->required == 1"
                                        :readonly="true"
                                    />
                                @endif
                                @if($value->input == 'select')
                                    <x-field
                                        :id="$value->name"
                                        :name="$value->name"
                                        :label="$value->label"
                                        :value="$val"
                                        :type="$value->input"
                                        :options="$value->options ?? []"
                                        :required="$value->required == 1"
                                        :readonly="true"
                                    />
                                @endif
                                @if($value->input == 'date')
                                    <x-field
                                        :id="$value->name"
                                        :name="$value->name"
                                        :label="$value->label"
                                        :value="$val"
                                        :type="$value->input"
                                        :required="$value->required == 1"
                                        :readonly="true"
                                    />
                                @endif
                                @if($value->input == 'file')
                                    @if($val)
                                        <div class="jp-field">
                                            <label class="jp-label">{{ $value->label }}</label>
                                            <div class="u-flex u-flex-wrap u-gap-sm u-mb-sm">
                                                @foreach(explode('/storage/',$val) as $b)
                                                    @if($b)
                                                        <div class="jp-badge jp-badge--accent u-flex u-gap-xs u-align-center" style="max-width:100%">
                                                            <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $b }}</span>
                                                            <a href="{{ file_url($b) }}" target="_blank" class="jp-btn jp-btn--quiet jp-btn--xs">
                                                                <x-icon name="eye" size="14" />
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if($value->input == 'textarea')
                                    <div class="jp-field">
                                        <label class="jp-label">{{ $value->label }}</label>
                                        <div style="padding:12px;background:var(--c-bg);border:1px solid var(--c-border);border-radius:var(--r-card)">
                                            {!! nl2br(e($val)) !!}
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @else
                        @foreach($indikator as $value)
                            @if($value->type == 'heading')
                                <div class="jp-section" style="padding:0">
                                    <div class="jp-section__head u-mb-md">
                                        <p class="jp-section__eyebrow">
                                            <span class="jp-section__eyebrow-dot" aria-hidden="true"></span>
                                            {{ $value->label }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                            @if($value->type == 'field')
                                @if($value->input == 'text' || $value->input == 'number')
                                    <x-field :id="$value->name" :name="$value->name" :label="$value->label" :value="$old[$value->name] ?? null" :type="$value->input" :required="$value->required == 1" :readonly="$value->readonly ?? false" />
                                @endif
                                @if($value->input == 'select')
                                    <x-field :id="$value->name" :name="$value->name" :label="$value->label" :value="$old[$value->name] ?? null" :type="$value->input" :options="$value->options ?? []" :required="$value->required == 1" :readonly="$value->readonly ?? false" />
                                @endif
                                @if($value->input == 'date')
                                    <x-field :id="$value->name" :name="$value->name" :label="$value->label" :value="$old[$value->name] ?? null" :type="$value->input" :required="$value->required == 1" :readonly="$value->readonly ?? false" />
                                @endif
                                @if($value->input == 'file')
                                    <div class="jp-field" style="--field-error:border-color:var(--c-danger)">
                                        <label class="jp-label">{{ $value->label }}@if($value->required == 1)<span class="jp-label__required">*</span>@endif</label>
                                        @if($old[$value->name] ?? null)
                                            <div class="u-flex u-flex-wrap u-gap-sm u-mb-sm">
                                                @foreach(explode('/storage/',$old[$value->name]) as $b)
                                                    @if($b)
                                                        <div class="jp-badge jp-badge--accent u-flex u-gap-xs u-align-center" style="max-width:100%">
                                                            <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $b }}</span>
                                                            <a href="{{ file_url($b) }}" target="_blank" class="jp-btn jp-btn--quiet jp-btn--xs">
                                                                <x-icon name="eye" size="14" />
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        <x-file-drop name="{{ $value->name }}[]" multiple accept=".pdf,.jpg,.jpeg,.png" :required="$value->required == 1" />
                                    </div>
                                @endif
                                @if($value->input == 'textarea')
                                    <div class="jp-field" style="--field-error:border-color:var(--c-danger)">
                                        <label class="jp-label">{{ $value->label }}@if($value->required == 1)<span class="jp-label__required">*</span>@endif</label>
                                        <textarea name="{{ $value->name }}" class="jp-textarea" rows="4" @if($value->required == 1) required @endif @if(($value->readonly ?? false)) readonly @endif>{{ $old[$value->name] ?? null }}</textarea>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif

                    <div class="jp-divider"></div>
                    <div class="u-flex u-justify-end u-gap-md">
                        <button type="button" onclick="history.back()" class="jp-btn jp-btn--ghost">Batal</button>
                        @if($parent->status != 0 && role_me() == 4)
                        @else
                            <button type="submit" class="jp-btn jp-btn--accent">Simpan</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection