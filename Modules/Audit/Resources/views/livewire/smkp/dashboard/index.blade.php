<x-slot name="sidebar">
    @include('audit::livewire.layouts.sidebar')
</x-slot>
<div class="inner-content">
    @include('audit::livewire.layouts.breadcrumb',[
        'trees'=>[
            ['name'=>strtoupper($audit_category)],
            ['name'=>'Dashboard']
        ]
    ])
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-sm-12">
                <div class="row">
                    <div class="title-form text-center mb-3 p-3">
                    <h3>DASHBOARD SMKP</h3>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col col-sm-4">
                <div class="chart-card bg-green rounded-3 p-3">
                    <div class="chart-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white fw-normal">Audit {{$audit_category}}</h6>
                        <button type="button" class="btn btn-transparent text-white p-0"><i class="fa-solid fa-ellipsis"></i></button>
                    </div><!-- /.chart-header -->
                    <div class="chart-content">
                                
                            @livewire(  
                            'dashboard.components.vertical-bar-chart', 
                            [
                                'idChart'   =>  'yearsChart',
                                'labels'    =>  $years['labels'],
                                'datasets'  =>  [
                                    [
                                        'label' => 'Audit SMKP',                                                
                                        'backgroundColor'   => '#D9DC30',
                                        'data'  =>  $years['data'],
                                        'borderColor' => '#D9DC30',
                                    ],
                                    
                                ],
                                'labelX'    => [
                                    'display'       => true,
                                    'color'         => '#ffffff',
                                    'beginAtZero'   => true
                                ],
                            ]
                        )
                        
                    </div>
                    <!-- /.chart-content -->
                </div><!-- /.chart-card -->
            </div>

            <div class="col col-sm-4">
                <div class="chart-card bg-green rounded-3 p-3">
                    <div class="chart-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white fw-normal">Audit {{$audit_category}} CCOW</h6>
                        <button type="button" class="btn btn-transparent text-white p-0"><i class="fa-solid fa-ellipsis"></i></button>
                    </div><!-- /.chart-header -->
                    <div class="chart-content">
                            
                            @livewire(
                            'dashboard.components.vertical-bar-chart', 
                            [
                                'idChart'   =>  'chartCCOW',
                                'labels'    =>  $companies_ccow["labels"],
                                'datasets'  =>  [
                                    [
                                        'label' => 'Perusahaan',                                                
                                        'backgroundColor'   => '#D9DC30',
                                        'data'  =>  $companies_ccow["data"],
                                        'borderColor' => '#D9DC30',
                                    ],
                                    
                                ],
                                'labelX'    => [
                                    'display'       => true,
                                    'color'         => '#ffffff',
                                    'beginAtZero'   => true
                                ],
                            ]
                        )
                        
                    </div>
                    <!-- /.chart-content -->
                </div><!-- /.chart-card -->
            </div>
    
            <div class="col col-sm-4">
                <div class="chart-card bg-green rounded-3 p-3">
                    <div class="chart-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white fw-normal">Audit {{$audit_category}} Perusahaan</h6>
                        <button type="button" class="btn btn-transparent text-white p-0"><i class="fa-solid fa-ellipsis"></i></button>
                    </div><!-- /.chart-header -->
                    <div class="chart-content">
                        
                            @livewire(
                            'dashboard.components.vertical-bar-chart', 
                            [
                                'idChart'   =>  'chartCompanies',
                                'labels'    =>  $companies["labels"],
                                'datasets'  =>  [
                                    [
                                        'label' => 'Audit SMKP Perusahaan',                                                
                                        'backgroundColor'   => '#D9DC30',
                                        'data'  =>  $companies["data"],
                                        'borderColor' => '#D9DC30',
                                    ],
                                    
                                ],
                                'labelX'    => [
                                    'display'       => true,
                                    'color'         => '#ffffff',
                                    'beginAtZero'   => true
                                ],
                            ]
                        )
                        
                    </div>
                    <!-- /.chart-content -->
                </div><!-- /.chart-card -->
            </div> 

        </div>
        <div class="row justify-content-center mb-5">
            <div class="col col-sm-6">
                <div class="chart-card bg-green rounded-3 p-3">
                    <div class="chart-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white fw-normal">Audit {{$audit_category}}</h6>
                        <button type="button" class="btn btn-transparent text-white p-0"><i class="fa-solid fa-ellipsis"></i></button>
                    </div><!-- /.chart-header -->
                    <div class="chart-content">
                                
                    @livewire(  
                                'dashboard.components.vertical-bar-chart', 
                                [
                                    'idChart'   =>  'percentsChart',
                                    'labels'    =>  $percentages['labels'],
                                    'datasets'  =>  [
                                        [
                                            'label' => 'Audit SMKP',                                                
                                            'backgroundColor'   => '#D9DC30',
                                            'data'  =>  $percentages['data'],
                                            'borderColor' => '#D9DC30',
                                        ],
                                        
                                    ],
                                    'labelX'    => [
                                        'display'       => true,
                                        'color'         => '#ffffff',
                                        'beginAtZero'   => true
                                    ],
                                ]
                            )
                            
                        
                    </div>
                    <!-- /.chart-content -->
                </div><!-- /.chart-card -->
            </div>

            <div class="col col-sm-6">
                <div class="chart-card bg-green rounded-3 p-3">
                    <div class="chart-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 text-white fw-normal">Audit {{$audit_category}} CCOW</h6>
                        <button type="button" class="btn btn-transparent text-white p-0"><i class="fa-solid fa-ellipsis"></i></button>
                    </div><!-- /.chart-header -->
                    <div class="chart-content">
                            
                    @livewire(  
                            'dashboard.components.vertical-bar-chart', 
                            [
                                'idChart'   =>  'statusChart',
                                'labels'    =>  $statuses['labels'],
                                'datasets'  =>  [
                                    [
                                        'label' => 'Audit SMKP',                                                
                                        'backgroundColor'   => '#D9DC30',
                                        'data'  =>  $statuses['data'],
                                        'borderColor' => '#D9DC30',
                                    ],
                                    
                                ],
                                'labelX'    => [
                                    'display'       => true,
                                    'color'         => '#ffffff',
                                    'beginAtZero'   => true
                                ],
                            ]
                        )
                    </div>
                    <!-- /.chart-content -->
                </div><!-- /.chart-card -->
            </div>
    
          

        </div>
       
    </div>

</div>

