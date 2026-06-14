<div class="inner-content">
    <div class="header-detail-maker h-60px border d-flex gap-2 align-items-center px-3">
        <div class="left-header">
            <a href="#" onclick="history.back();"
               class="d-flex align-items-center gap-3">
                <span><i class="fa-solid fa-arrow-left"></i></span>
                <span>KO</span>
            </a>
        </div>
        <div class="right-header">
            <div class="text-white">
                {{-- Last update Sep 24, 2022 . 15.00 pm --}}
            </div>
        </div>
    </div>

    <div class="addnew-maker-content container py-5 px-3">

    	<div class="row justify-content-center m-5">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">NOMOR URUT KOMISIONING ANDA</h5>
                        <h2 class="card-text text-center">{{$ko_proposal->number}}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-8">
                <form class="form-horizontal" enctype="multipart/form-data">
                    <div class="own-info mb-5">
                        <div class="mb-3">
                            <h5 class="fw-normal">DOKUMEN PENDUKUNG</h5>
                        </div>

                        @if(in_array("stnk", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Fotokopi STNK</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="stnk" name="stnk" class="form-control @error('stnk') is-invalid @enderror" required>
                                @error('stnk')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("nota_pajak", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Copy Nota Pajak</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="nota_pajak" name="nota_pajak" class="form-control @error('nota_pajak') is-invalid @enderror" required>
                                @error('nota_pajak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("surat_pengantar", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Surat Pengantar</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="surat_pengantar" class="form-control @error('surat_pengantar') is-invalid @enderror" required>
                                @error('surat_pengantar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("re_manufacture", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Bukti Service/Re-Manufacture</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="re_manufacture" class="form-control @error('re_manufacture') is-invalid @enderror" required>
                                @error('re_manufacture')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("oem", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Data Pemeriksaan (OEM)</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="oem" class="form-control @error('oem') is-invalid @enderror" required>
                                @error('oem')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("dokumen_sertifikat", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Dokumen Sertifikat ROPs / FOPs</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="dokumen_sertifikat" class="form-control @error('dokumen_sertifikat') is-invalid @enderror" required>
                                @error('dokumen_sertifikat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("inspeksi_p3k", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Hasil Inspeksi Kotak P3K</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="inspeksi_p3k" class="form-control @error('inspeksi_p3k') is-invalid @enderror" required>
                                @error('inspeksi_p3k')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("kir", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Copy KIR Aktif</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="kir" class="form-control @error('kir') is-invalid @enderror" required>
                                @error('kir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("uji_pjit", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Riksa Uji PJIT</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="uji_pjit" class="form-control @error('uji_pjit') is-invalid @enderror" required>
                                @error('uji_pjit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("pra_komisioning", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Pra Komisioning</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="pra_komisioning" class="form-control @error('pra_komisioning') is-invalid @enderror" required>
                                @error('pra_komisioning')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("setting_radio", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Bukti Setting Radio</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="setting_radio" class="form-control @error('setting_radio') is-invalid @enderror" required>
                                @error('setting_radio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("slo", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">SLO/Sertifikan Distributor</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="slo" class="form-control @error('slo') is-invalid @enderror" required>
                                @error('slo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("komisioning_internal", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Bukti Commissioning Internal</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="komisioning_internal" class="form-control @error('komisioning_internal') is-invalid @enderror" required>
                                @error('komisioning_internal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        @if(in_array("com", $ko_proposal->koUnit->koSpipUnit->attachment_field ?? []))
                        <div class="mb-3 row form-group required">
                            <label for="area" class="col-sm-4 col-form-label">Dokumen Kajian Teknis/COM</label>
                            <div class="col-sm-8">
                                <input type="file" wire:model="com" class="form-control @error('com') is-invalid @enderror" required>
                                @error('com')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endif

                    </div>

                    <div class="footer-action mb-2">
                        <div class="action-wrapper d-flex align-items-center justify-content-end gap-2">
                            <div class="button-document">
                                <button wire:loading.attr="disabled"
                                    class="dropdown-toggle btn btn-outline-default bg-green d-flex justify-content-center align-item-center text-white position-relative px-4"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Submit Action
                                </button>
                                <ul class="dropdown-menu" wire:ignore>
                                    <li>
                                        <button type="button" wire:loading.attr="disabled" wire:click="store(1)" class="dropdown-item"
                                            href="#">
                                            Submit as Draft
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" wire:loading.attr="disabled" wire:click="store()" class="dropdown-item"
                                            href="#">
                                            Submit to Admin KO
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        })
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.hook('message.sent', (message, component) => {
                
                if (message.updateQueue[0].payload.method === 'startUpload') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload ' + message.updateQueue[0].payload.params[0],
                        timer: false,
                        didOpen: (toast) => {
                            Toast.showLoading();
                        }
                    });
                }

                if (message.updateQueue[0].payload.method === "finishUpload") {
                    console.log(message.updateQueue[0].payload.params[0])
                    Toast.fire({
                        icon: 'success',
                        title: 'Proses Upload ' + message.updateQueue[0].payload.params[0] + ' Success',
                        timer: 2000,
                    });
                }
                
            })

        });
        
    </script>
@endpush