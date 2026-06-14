<div>
    <div class="modal fade" wire:ignore.self id="modalComplementaryDocument" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveComplementaryDocument' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Dokumen</label>
                            <x-inputs.text id="complementary_document" wire:model="complementary_document" autocomplete="off" error="complementary_document"></x-inputs.text>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveComplementaryDocument'
                                type="button" wire:click="saveComplementaryDocument">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveComplementaryDocument"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->

    <div class="modal fade" wire:ignore.self id="modalFormRiskPresent" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveRiskOfPresents' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Risk of Presents</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Kegiatan</label>
                            <x-inputs.text id="activity" wire:model="activity" autocomplete="off" error="activity"></x-inputs.text>

                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Risiko</label>
                            <x-inputs.text id="risk" wire:model="risk" autocomplete="off" error="risk"></x-inputs.text>
                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Nilai Risiko</label>
                            <x-inputs.text id="risk_value" wire:model="risk_value" autocomplete="off" error="risk_value"></x-inputs.text>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveRiskOfPresents'
                                type="button" wire:click="saveRiskOfPresents">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveRiskOfPresents"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->

    <div class="modal fade" wire:ignore.self id="modalFormRiskFuture" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveRiskOfFuture' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Risk of Future</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Kegiatan</label>
                            <x-inputs.text id="activity" wire:model="activity" autocomplete="off" error="activity"></x-inputs.text>

                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Risiko</label>
                            <x-inputs.text id="risk" wire:model="risk" autocomplete="off" error="risk"></x-inputs.text>
                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Nilai Risiko</label>
                            <x-inputs.text id="risk_value" wire:model="risk_value" autocomplete="off" error="risk_value"></x-inputs.text>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveRiskOfFuture'
                                type="button" wire:click="saveRiskOfFuture">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveRiskOfFuture"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->

    <div class="modal fade" wire:ignore.self id="modalLocation" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveLocation' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Tambah Lokasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Lokasi</label>
                            <x-inputs.text id="location" wire:model="location" autocomplete="off" error="location"></x-inputs.text>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveLocation'
                                type="button" wire:click="saveLocation">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveLocation"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->

    <div class="modal fade" wire:ignore.self id="modalActivity" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveActivity' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Tambah Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Activity</label>
                            <x-inputs.text id="activity" wire:model="activity" autocomplete="off" error="activity"></x-inputs.text>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveActivity'
                                type="button" wire:click="saveActivity">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveActivity"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->

    <div class="modal fade" wire:ignore.self id="modalPosition" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='savePosition' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Tambah Position</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Position</label>
                            <x-inputs.text id="position" wire:model="position" autocomplete="off" error="position"></x-inputs.text>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='savePosition'
                                type="button" wire:click="savePosition">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="savePosition"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->

    <div class="modal fade" wire:ignore.self id="modalDeviation" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveDeviation' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Tambah Deviasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Deviasi</label>
                            <x-inputs.text id="deviation" wire:model="deviation" autocomplete="off" error="deviation"></x-inputs.text>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveDeviation'
                                type="button" wire:click="saveDeviation">
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

    <div class="modal fade" wire:ignore.self id="modalCausing" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveCausing' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Tambah Faktor Penyebab Dominan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Faktor Penyebab Dominan</label>
                            <x-inputs.text id="causing" wire:model="causing" autocomplete="off" error="causing"></x-inputs.text>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveCausing'
                                type="button" wire:click="saveCausing">
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

    <div class="modal fade" wire:ignore.self id="modalMiningEquipmentWork" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveMiningEquipmentWork' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Add Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Jenis Peralatan</label>
                            <x-inputs.text id="equipment" wire:model="equipment" autocomplete="off" error="equipment"></x-inputs.text>

                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Physical Availability</label>
                            <x-inputs.text id="physical_availability" wire:model="physical_availability" autocomplete="off" error="physical_availability"></x-inputs.text>
                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Mechanical Availability</label>
                            <x-inputs.text id="mechanical_availability" wire:model="mechanical_availability" autocomplete="off" error="mechanical_availability"></x-inputs.text>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveMiningEquipmentWork'
                                type="button" wire:click="saveMiningEquipmentWork">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveMiningEquipmentWork"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->

    <div class="modal fade" wire:ignore.self id="modalKeyLeadingIndicator" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveKeyLeadingIndicator' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Add Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Key Leading Indicator</label>
                            <x-inputs.text id="key_leading_indicator" wire:model="key_leading_indicator" autocomplete="off" error="key_leading_indicator"></x-inputs.text>

                        </div>
                        <div class="form-group mt-3">
                            <label for="name">Status</label>
                            <x-inputs.text id="status" wire:model="status" autocomplete="off" error="status"></x-inputs.text>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveKeyLeadingIndicator'
                                type="button" wire:click="saveKeyLeadingIndicator">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveKeyLeadingIndicator"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->

    <div class="modal fade" wire:ignore.self id="modalFactor" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveFactor' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Add Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Factor</label>
                            <x-inputs.text id="factor" wire:model="factor" autocomplete="off" error="factor"></x-inputs.text>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveFactor'
                                type="button" wire:click="saveFactor">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveFactor"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
    <div class="modal fade" wire:ignore.self id="modalStakeholder" tabindex="-1" aria-labelledby="modalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent='saveStakeholder' wire:ignore.self id="form-date">
                    <div class="modal-header">
                        <h5 class="modal-title fw-normal" id="exampleModalLabel">Add Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="role_id">Masukan dari Pemangku Kepentingan</label>
                            <x-inputs.text id="stakeholder_input" wire:model="stakeholder_input" autocomplete="off" error="stakeholder_input"></x-inputs.text>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-outline-success bg-green text-white bg-hover-light-success"
                                wire:loading.remove wire:target='saveStakeholder'
                                type="button" wire:click="saveStakeholder">
                            @lang('global.save')
                        </button>
                        <x-button-spinner
                            target="saveStakeholder"
                            :text="trans('global.processing')"></x-button-spinner>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- modal-add -->
</div>
