<div class="content-sidebar">
    <ul>
        <li class="item-sidebar">
            <a href="{{ route('dashboard-public') }}"
                class="link-sidebar text-decoration-none">
                Home AIMS
            </a>
        </li>
        @can('COE - View Dashboard')
            <li class="item-sidebar">
                <a href="{{ route('coe::dashboard') }}" class="link-sidebar text-decoration-none {{ Request::routeIs('coe::dashboard') ? 'active' : '' }}">Dashboard</a>
            </li>
        @endcan

        {{-- @can('COE - View Callendar') --}}
        <li class="item-sidebar">
            <a href="{{ route('coe::callendar') }}" class="link-sidebar text-decoration-noner {{ Request::routeIs('coe::callendar') ? 'active' : '' }}">Calendar</a>
        </li>
        {{-- @endcan --}}

        @can('COE - View List')
            <li class="item-sidebar">
                <a href="{{ route('coe::list') }}"
                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center {{ Request::routeIs('coe::list') ? 'active' : '' }}">Invited Event

                    @if (auth()->user()->hasRole('COE - Superuser'))
                        <span
                            class="badge rounded-pill bg-danger">{{ App\Models\COE\Event::whereYear('start_date', \Carbon\Carbon::now()->year)->count() }}</span>
                    @else
                        <span
                            class="badge rounded-pill bg-danger">{{ App\Models\COE\Event::whereYear('start_date', \Carbon\Carbon::now()->year)->where('invited_emails', 'like', '%' . auth()->user()->email . '%')->orWhere('user_id', auth()->user()->id)->orWhereHas('category', function ($query) {
                                    $query->where('name', 'Umum');
                                })->count() }}</span>
                    @endif
                </a>

            </li>
        @endcan

        {{-- @can('COE - Manage Category')
            <li class="item-sidebar">
                <a href="{{ route('coe::category') }}" class="link-sidebar text-decoration-none">Data Master Kategori</a>
            </li>
        @endcan --}}

        @can('COE')
        @endcan
    </ul>
</div><!-- /.content-sidebar -->
