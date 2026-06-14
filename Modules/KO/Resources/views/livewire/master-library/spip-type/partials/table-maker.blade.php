<div x-data="{ itemSelected: @entangle('itemSelected'), info: @entangle('info') }">

    <div class="table-content table-responsive position-relative">
        <div class="table-wrapper overflow-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->spipTypes as $itemIndex => $items)
                        <tr>
                            <td scope="row">{{ $items->name }}</td>
                            <td scope="row">{{ $items->koSpipCategory->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div><!-- /.table-content-->

</div>

@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {

            @this.on('remove-item', () => {
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'Yakin akan menghapus data ini?',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Hapus'
                }).then((result) => {

                    if (result.value) {

                        @this.call('removeItem')

                    }

                });
            });
        });
    </script>
@endpush
