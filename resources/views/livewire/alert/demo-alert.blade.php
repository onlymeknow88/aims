<div class="inner-alert">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Demo alert</h1>
                <p>Click button untuk melihat demo nya</p>
                <p class="text-danger">function nya ada di livewire</p>
            </div>
            <div class="col-12">
                <button wire:click.prevent='success()' type="button" class="btn btn-outline-success">Success</button>
                <button wire:click.prevent='info()' type="button" class="btn btn-outline-info">Info</button>
                <button wire:click.prevent='danger()' type="button" class="btn btn-outline-danger">Error</button>
                <button wire:click.prevent='warning()' type="button" class="btn btn-outline-warning">Warning</button>                
                <button wire:click.prevent="$emit('triggerDelete','01')"" type="button" class="btn btn-outline-primary">Question</button>
                <button wire:click.prevent='timer()' type="button" class="btn btn-outline-danger">With Timer</button>               
            </div>            
        </div>
    </div>
</div><!-- ./inner-alert -->

@push('scripts')
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {

        @this.on('triggerDelete', dataId => {
            Swal.fire({
                title: 'Are You Sure?',
                text: 'Yakin akan menghapus data ini?',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'Hapus'
            }).then((result) => {

                if (result.value) {

                    @this.call('destroy',dataId)
                    
                }
                
            });
        });
    })
</script>
@endpush
