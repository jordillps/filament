<!-- Nova pàgina Login -->
<form wire:submit.prevent="authenticate" class="space-y-8">
    {{ $this->form }}

    <x-filament::button type="submit" form="authenticate" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>
    <div class="flex items-center space-x-4">
        <div class="border-t-2 border-slate-600 w-full h-1"></div>
        <hr>
        <div class="border-t-2 border-slate-600 w-full h-1"></div>
    </div>
    {{-- <div class="flex space-x-4 items-center justify-evenly">
		// icons from iconify
        <span class="iconify w-5 h-5" data-icon="flat-color-icons:google"></span>
        <span class="iconify w-5 h-5" data-icon="logos:github-icon"></span>
        <span class="iconify w-5 h-5" data-icon="logos:facebook"></span>
    </div> --}}
</form>