@props([
    'type' => 'text',
    
    'icon' => null,
    'prepend' => null,
    'append' => null,

    'size' => null,
    
    'help' => null,
    'placeholder' => null, 
    
    'model' => null,

    'debounce' => false,
    'lazy' => false,
])

<div class="row">
    
    <label for="name" class="col-sm-3 col-form-label">
        {{ __('Name') }}
    </label>
    
    <div class="col-sm-9">
        <x-nue::form.input id="name" :placeholder="__('Enter your name')"
            value="{{ old($name) }}"
            autocomplete="name" />
        <x-nue::error for="name" class="mt-2" />
    </div>

</div>