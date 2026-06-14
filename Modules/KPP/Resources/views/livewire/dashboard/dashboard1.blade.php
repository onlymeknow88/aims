<div class="inner-dashboard">

    <div class="mb-3 row form-group required">
        <!-- <label for="agency_authority" class="col-sm-4 col-form-label">Section</label> -->
        <div class="col-4">
            <x-kpp-select-2 wire:model="rule" id="rule" placeholder="Select Peraturan">
                @foreach ($this->rules as $key => $rule)
                    <option value="{{ $rule->id }}">{{$rule->number}} - {{$rule->title}}</option>
                @endforeach
            </x-kpp-select-2>
        </div>
        <div class="col-2">
            <a href="#" wire:click="resetFilter()" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>
    <div class="mb-3 row form-group required">
    </div>
    
    <div class="dashboard-top px-5 py-3 d-flex justify-content-between align-items-center mb-4">

        <div class="content-top">
            <div class="title text-white mb-2">Complied</div>
            <div class="content d-flex gap-3 align-items-center">
                <div class="icon text-success"></div>
                <div class="text-wrapper d-flex align-items-center gap-1">
                    <span class="text text-white fw-semibold fs-3">{{round($this->compliedExtractionTotal / $this->extractionTotal * 100)}}</span>
                    <span class="sub-text text-white">%</span>
                </div>                        
            </div>
        </div><!-- /.content-top -->

        <div class="content-top">
            <div class="title text-white mb-2">Not Comply</div>
            <div class="content d-flex gap-3 align-items-center">
                <div class="icon text-success"></div>
                <div class="text-wrapper d-flex align-items-center gap-1">
                    <span class="text text-white fw-semibold fs-3">{{round($this->notComplyExtractionTotal / $this->extractionTotal * 100)}}</span>
                    <span class="sub-text text-white">%</span>
                </div>                        
            </div>
        </div><!-- /.content-top -->

        <div class="content-top">
            <div class="title text-white mb-2">Not Applicable</div>
            <div class="content d-flex gap-3 align-items-center">
                <div class="icon text-success"></div>
                <div class="text-wrapper d-flex align-items-center gap-1">
                    <span class="text text-white fw-semibold fs-3">{{round($this->notApplicableExtractionTotal / $this->extractionTotal * 100)}}</span>
                    <span class="sub-text text-white">%</span>
                </div>                        
            </div>
        </div><!-- /.content-top -->

        <div class="content-top">
            <div class="title text-white mb-2">In Progress</div>
            <div class="content d-flex gap-3 align-items-center">
                <div class="icon text-success"></div>
                <div class="text-wrapper d-flex align-items-center gap-1">
                    <span class="text text-white fw-semibold fs-3">{{round($this->inProgressExtractionTotal / $this->extractionTotal * 100)}}</span>
                    <span class="sub-text text-white">%</span>
                </div>                        
            </div>
        </div><!-- /.content-top -->

        

    </div><!-- /.dashboard-top -->

    <div class="dashboard-main">
        <div class="row">
            <div class="col-6">

                <div class="chart-card bg-green rounded-4 p-3">
                    <div class="chart-header text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-normal">Performance</h6>
                        <button type="button" class="btn btn-transparent p-0 text-white opacity-50"><i class="fa-solid fa-ellipsis"></i></button>
                    </div><!-- /.chart-header -->
                    <div class="chart-content">
                        @livewire(
                            'chart.chart-bar', 
                            [
                                'idChart'   =>  'chart1',
                                'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                                'datasets'  =>  [[
                                    'label' => 'Performance',
                                    'backgroundColor'   => '#009D50',
                                    'hoverBackgroundColor'  => '#D9DC30',
                                    'data'  =>  [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56]
                                ]],
                                'labelX'    => [
                                    'display'       => true,
                                    'color'         => '#ffffff',
                                    'beginAtZero'   => true
                                ]
                            ]
                        )
                    </div><!-- /.chart-content -->
                </div><!-- /.chart-card -->
                
            </div>
            <div class="col-6">
                <div class="chart-card bg-green rounded-4 p-3">
                    <div class="chart-header text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-normal">Performance</h6>
                        <button type="button" class="btn btn-transparent p-0 text-white opacity-50"><i class="fa-solid fa-ellipsis"></i></button>
                    </div><!-- /.chart-header -->
                    <div class="chart-content">
                        @livewire(
                            'chart.chart-bar', 
                            [
                                'idChart'   =>  'chart2',
                                'labels'    =>  ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                                'datasets'  =>  [
                                    [
                                        'label' => 'Performance',
                                        'backgroundColor'   => '#009D50',
                                        'hoverBackgroundColor'  => '#ffffff',
                                        'data'  =>  [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56]
                                    ],
                                    [
                                        'label' => 'Perfor',
                                        'backgroundColor'   => '#D9DC30',
                                        'hoverBackgroundColor'  => '#ffffff',
                                        'data'  =>  [65, 59, 20, 81, 56, 55, 40, 65, 59, 20, 81, 56]
                                    ]
                                ],
                                'labelX'    => [
                                    'display'       => true,
                                    'color'         => '#ffffff',
                                    'beginAtZero'   => true
                                ]
                            ]
                        )
                    </div><!-- /.chart-content -->
                </div><!-- /.chart-card -->
            </div>
        </div>
    </div>
    
</div>
