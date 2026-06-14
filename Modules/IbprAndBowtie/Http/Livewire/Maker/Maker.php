<?php

namespace Modules\IbprAndBowtie\Http\Livewire\Maker;

use Livewire\Component;

class Maker extends Component
{
    public $title;

    public function render()
    {
        $current_url = url()->current();
        $path_segments = explode('/', parse_url($current_url, PHP_URL_PATH)); // split the URL path into segments

        $second_to_last_segment = isset($path_segments[count($path_segments) - 2]) ? $path_segments[count($path_segments) - 2] : '';
        
        // Remove any dashes and convert to title case
        $second_to_last_segment = str_replace("-", " ", $second_to_last_segment);
        $second_to_last_segment = ucwords($second_to_last_segment);
        $this->title = $second_to_last_segment;

        return view('ibprandbowtie::livewire.ibpr-and-bowtie.maker.maker')->layout('ibprandbowtie::layouts.ibpr-and-bowtie');
    }

}
