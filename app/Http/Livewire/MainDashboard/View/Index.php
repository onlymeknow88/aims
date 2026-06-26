<?php

namespace App\Http\Livewire\MainDashboard\View;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $widgets = [];

    protected $widgetKeys = [
        'video_slide',
        'calendar_of_event_list',
        'production_ytd_chart',
        'production_mtd',
        'safety_performance_chart',
        'image_banner',
        'health_performance_chart',
        'calendar',
        'strategic_project',
        'news_update',
        'penghargaan_k3lh',
        'incident_notification',
        'kegiatan_k3lh',
        'safety_accountability_program',
        'achievement_sap',
        'sap_ytd',
        'coe',
        'ds',
        'sap',
        'fls',
        'inspection',
        'audit',
        'mr',
        'ko',
        'cr',
        'mcu',
        'csms',
    ];

    public function mount()
    {
        foreach ($this->widgetKeys as $key) {
            $settingVal = DB::table('app_settings')->where('id', 'widget_' . $key)->value('val');
            // Default to true (visible) unless explicitly configured as 'false'
            $this->widgets[$key] = ($settingVal !== 'false');
        }
    }

    public function toggleWidget($key)
    {
        if (!in_array($key, $this->widgetKeys)) {
            return;
        }

        $currentVal = $this->widgets[$key];
        $newVal = !$currentVal;
        $this->widgets[$key] = $newVal;

        DB::table('app_settings')->updateOrInsert(
            ['id' => 'widget_' . $key],
            [
                'name' => 'Widget ' . ucwords(str_replace('_', ' ', $key)),
                'val'  => $newVal ? 'true' : 'false'
            ]
        );

        session()->flash('message', 'Widget visibility updated successfully.');
    }

    public function render()
    {
        return view('livewire.main-dashboard.view.index')
            ->layout('layouts.main-dashboard.admin.admin-dashboard');
    }
}
