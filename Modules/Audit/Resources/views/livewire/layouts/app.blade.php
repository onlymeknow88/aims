<x-layouts.audit>

    <!-- header start -->
    @livewire('audit::layouts.header')
    <!-- /. header end-->

    {{--<div class="page-wrapper">

        <div class="content-wrapper d-flex">

            <div :class="isSidebar ? 'show' : 'hidden'" class="sidebar offcanvas offcanvas-start h-auto"
                 data-bs-backdrop="false" data-bs-scroll="true" id="sidebar">
                @isset($sidebar)
                    {{$sidebar}}
                @endisset
            </div><!-- /.sidebar -->

            <div class="col main-content" :class="isSidebar ? 'sidebar-open' : ''">
                @isset($breadcrumb)
                {{ $breadcrumb }}
                @endisset
                {{ $slot }}
            </div> <!-- /.main-content -->

        </div><!-- /.content-wrapper-->

    </div><!-- /.page-wrapper -->--}}

    <div class="page-wrapper">

        <div class="content-wrapper d-flex">

            <div 
                :class="$store.isSidebar.open ? 'show' : 'hidden'"
                class="sidebar offcanvas offcanvas-start" id="sidebar"
                data-bs-backdrop="false"
                data-bs-scroll="true"
            >
                @isset($sidebar)
                    {{$sidebar}}
                @endisset
            </div><!-- /.sidebar -->

            <div 
                class="col main-content"
                :class="$store.isSidebar.open ? 'sidebar-open' : ''"
            >
                @isset($breadcrumb)
                {{ $breadcrumb }}
                @endisset
                {{ $slot }}
            </div> <!-- /.main-content -->    

        </div><!-- /.content-wrapper-->                

    </div><!-- /.page-wrapper -->

</x-layouts.audit>