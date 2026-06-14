<!-- Template Accordion -->
<div id="template" class="section-template" x-data="{accordionOpen: true}">

    <button 
        class="header-accordion d-flex justify-content-between w-100 border-0 bg-white py-3 px-0"
        @click.prevent="accordionOpen = ! accordionOpen"
    >
        <h6 class="mb-0 fw-normal title-accordion">Template</h6>
        <span x-bind:class="accordionOpen ? 'open' : ''"><img src="{{asset('/images/icons/angle-down.png')}}" alt="" /></span>
    </button>
    <div 
        class="wrapper-content-accordion max-h-0 overflow-hidden position-relative transition-all duration-700"
        x-ref="karyawan" 
        x-bind:style="accordionOpen ? 'max-height: ' + $refs.karyawan.scrollHeight + 'px' : ''"
    >

        <div class="content-section p-4">
        </div><!-- /.content-section -->

    </div><!-- /.wrapper-content-accordion -->
    
</div><!-- /.template -->