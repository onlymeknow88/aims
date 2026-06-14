<div>
    <from class="header-search" wire:submit.prevent='searchContent()'>
        <div class="input-group">
            <span class="input-group-text"><img src="{{asset('images/icons/search.png')}}" alt="" /></span>
            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" wire:model="searchTerm">
            <span class="input-group-text cursor-pointer"><img src="{{asset('images/icons/setting.png')}}" alt="" /></span>
        </div>
    </from>
</div>
