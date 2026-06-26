@section('title')
    Dashboard Setting
@endsection

@push('styles')
    <style>
        .settings-card {
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border-radius: 16px;
            background: #ffffff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .settings-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        }
        .widget-group-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #10b981;
            padding-bottom: 0.5rem;
            margin-bottom: 1.25rem;
            margin-top: 1.5rem;
        }
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            transition: background-color 0.2s ease;
        }
        .toggle-row:last-child {
            border-bottom: none;
        }
        .toggle-row:hover {
            background-color: #f8fafc;
            border-radius: 8px;
        }
        .toggle-label {
            font-weight: 600;
            color: #334155;
            font-size: 0.95rem;
        }
        .toggle-desc {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 400;
            display: block;
            margin-top: 0.15rem;
        }
        .form-switch .form-check-input {
            width: 2.5em;
            height: 1.25em;
            cursor: pointer;
        }
        .form-switch .form-check-input:checked {
            background-color: #10b981;
            border-color: #10b981;
        }
    </style>
@endpush

<div>
    <div class="row justify-content-center">
        <div class="col-11 col-md-10 col-lg-8 py-4">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert" style="border-radius: 12px; background-color: #ecfdf5; color: #065f46;">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card settings-card p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="fw-bold text-dark m-0"><i class="fa-solid fa-sliders text-success me-2"></i> Widget Visibility Settings</h4>
                        <p class="text-muted small m-0 mt-1">Configure which sections and charts are displayed on the main landing dashboard.</p>
                    </div>
                </div>

                <!-- Group 1: Hero & Events Section -->
                <div class="widget-group-title"><i class="fa-solid fa-clapperboard me-2"></i> Hero & Events</div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Promotional Video Slide</span>
                        <span class="toggle-desc">Plays uploaded slideshow videos at the top carousel.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('video_slide')" @if($widgets['video_slide']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Calendar of Event List</span>
                        <span class="toggle-desc">Shows upcoming event activities list on the right.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('calendar_of_event_list')" @if($widgets['calendar_of_event_list']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Monthly Calendar View</span>
                        <span class="toggle-desc">Displays a full grid calendar of monthly events.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('calendar')" @if($widgets['calendar']) checked @endif>
                    </div>
                </div>

                <!-- Group 2: Production Charts -->
                <div class="widget-group-title"><i class="fa-solid fa-cubes me-2"></i> Production Metrics</div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Production YTD Chart</span>
                        <span class="toggle-desc">Renders Yearly-to-Date target vs actual coal production bar graph.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('production_ytd_chart')" @if($widgets['production_ytd_chart']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Production MTD Chart</span>
                        <span class="toggle-desc">Displays Month-to-Date target ratios.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('production_mtd')" @if($widgets['production_mtd']) checked @endif>
                    </div>
                </div>

                <!-- Group 3: Safety & Health Performance -->
                <div class="widget-group-title"><i class="fa-solid fa-shield-halved me-2"></i> Safety & Health</div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Safety Performance Chart</span>
                        <span class="toggle-desc">Visualizes safety KPIs, LTIs, and trends.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('safety_performance_chart')" @if($widgets['safety_performance_chart']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Health Performance Chart</span>
                        <span class="toggle-desc">Displays workers fit/unfit health evaluation statuses.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('health_performance_chart')" @if($widgets['health_performance_chart']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Promotion Image Banner</span>
                        <span class="toggle-desc">Renders active promotional banner graphics.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('image_banner')" @if($widgets['image_banner']) checked @endif>
                    </div>
                </div>

                <!-- Group 4: Projects, News & General Content -->
                <div class="widget-group-title"><i class="fa-solid fa-newspaper me-2"></i> Strategic & News updates</div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Strategic Project Milestones</span>
                        <span class="toggle-desc">Shows major ongoing strategic projects and milestones.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('strategic_project')" @if($widgets['strategic_project']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">News & Announcements</span>
                        <span class="toggle-desc">Shows updates, articles, and newsletter announcements.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('news_update')" @if($widgets['news_update']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">K3LH Awards List</span>
                        <span class="toggle-desc">Displays achievements and certifications received.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('penghargaan_k3lh')" @if($widgets['penghargaan_k3lh']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Incident Notification Warning List</span>
                        <span class="toggle-desc">Displays warnings and notification reports of safety occurrences.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('incident_notification')" @if($widgets['incident_notification']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">K3LH Kegiatan List</span>
                        <span class="toggle-desc">Lists scheduled event agendas at the bottom.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('kegiatan_k3lh')" @if($widgets['kegiatan_k3lh']) checked @endif>
                    </div>
                </div>

                <!-- Group 5: Safety Accountability Program (SAP) -->
                <div class="widget-group-title"><i class="fa-solid fa-list-check me-2"></i> Safety Accountability Program (SAP)</div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">SAP Program Categories</span>
                        <span class="toggle-desc">Shows SAP achievement summaries by program types.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('safety_accountability_program')" @if($widgets['safety_accountability_program']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">SAP Departmental Achievements</span>
                        <span class="toggle-desc">Shows departmental performance list in safety programs.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('achievement_sap')" @if($widgets['achievement_sap']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">SAP YTD Trends</span>
                        <span class="toggle-desc">Renders safety accountability completion trends YTD.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('sap_ytd')" @if($widgets['sap_ytd']) checked @endif>
                    </div>
                </div>

                <!-- Group 6: Category Overview Widgets -->
                <div class="widget-group-title"><i class="fa-solid fa-table-cells me-2"></i> Category Overview Widgets</div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Calendar Of Event</span>
                        <span class="toggle-desc">Renders event summaries, targets, and monthly activities metrics.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('coe')" @if($widgets['coe']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Document System</span>
                        <span class="toggle-desc">Displays document status summaries, progress, and chart.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('ds')" @if($widgets['ds']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Safety Accountability Program (SAP Card)</span>
                        <span class="toggle-desc">Displays summary card & details for safety accountability program.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('sap')" @if($widgets['sap']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Field Leadership</span>
                        <span class="toggle-desc">Shows field leadership activities summaries.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('fls')" @if($widgets['fls']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Inspection</span>
                        <span class="toggle-desc">Displays inspection records and progress metrics.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('inspection')" @if($widgets['inspection']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Audit</span>
                        <span class="toggle-desc">Displays audit findings, category breakdowns, and compliance progress.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('audit')" @if($widgets['audit']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Management Resiko</span>
                        <span class="toggle-desc">Shows IBPR, Bowtie and risk management status details.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('mr')" @if($widgets['mr']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Safety Operation</span>
                        <span class="toggle-desc">Shows safety operations metrics and compliance values.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('ko')" @if($widgets['ko']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Compliance Regulation</span>
                        <span class="toggle-desc">Displays compliance items, regulatory standards, and metrics.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('cr')" @if($widgets['cr']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Medical Check Up</span>
                        <span class="toggle-desc">Shows medical evaluation status cards and charts.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('mcu')" @if($widgets['mcu']) checked @endif>
                    </div>
                </div>
                <div class="toggle-row">
                    <div>
                        <span class="toggle-label">Contractor Safety Management System</span>
                        <span class="toggle-desc">Displays CSMS evaluation compliance charts and metrics.</span>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch"
                            wire:click="toggleWidget('csms')" @if($widgets['csms']) checked @endif>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
