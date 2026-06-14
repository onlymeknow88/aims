<div>
    <div class="modal fade" wire:ignore.self id="modalFormTeam" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveTeam' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Auditor Team</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Role</label>
                                <x-inputs.select2
                                id="role_id"
                                error="role_id"
                                wire:model="role_id"
                                >
                                    @foreach($team_roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </x-inputs.select2>

                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Nama</label>
                            <x-inputs.text id="name" wire:model="name" autocomplete="off" error="name">name</x-inputs.text>
                        </div>
                        @if($role_id != 3 )
                        <div class="form-group mt-3">
                            <label for="registration_number">Nomor Registrasi</label>
                            <x-inputs.text id="registration_number" autocomplete="off" wire:model="registration_number" error="registration_number">name</x-inputs.text>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveTeam'
                                type="button" wire:click="saveTeam">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveTeam"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
</div>
