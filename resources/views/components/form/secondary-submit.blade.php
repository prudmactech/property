<div>
    <button type="button" class="btn btn-primary" wire:click="secondarySubmit" wire:loading.class="disabled" id="78787"
            data-redirect="no" wire:loading.attr="disabled">
        <div wire:loading wire:target="secondarySubmit">
            <span class="spinner-border spinner-border-sm hide" role="status" aria-hidden="true" wire:loading
                  wire:target="secondarySubmit"></span>
        </div>
        <span>{{ $slot}}</span>
    </button>
</div>
