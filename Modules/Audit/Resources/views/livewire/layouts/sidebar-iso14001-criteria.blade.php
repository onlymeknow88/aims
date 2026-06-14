<div class="sidebar-menu-right sidebar">
    <div class="menu-right-content content-sidebar">
        <ul>
           @foreach($audit->criteria_module->criteria as $criteria)
                <li class="item-sidebar">
                    <a class="link-sidebar text-decoration-none dropdown {{!in_array($criteria->id,$activeSidebar)?'collapsed':''}}"
                       data-bs-toggle="collapse" href="#sub-{{$criteria->id}}" role="button"
                       aria-expanded="{{!in_array($criteria->id,$activeSidebar)?'true':'false'}}"
                       aria-controls="subSidebar">{{$criteria->title}}</a>
                    <ul class="collapse sub-menu {{!in_array($criteria->id,$activeSidebar)?'':'show'}}"
                        id="sub-{{$criteria->id}}">
                        @foreach($criteria->sub_criteria as $subCriteria)
                            <li class="item-sidebar">
                                @if($subCriteria->children->count()>0)
                                    <a class="link-sidebar text-decoration-none dropdown {{!in_array($subCriteria->id,$activeSidebar)?'collapsed':''}}"
                                       data-bs-toggle="collapse" href="#sub-{{$subCriteria->id}}" role="button"
                                       aria-expanded="{{!in_array($subCriteria->id,$activeSidebar)?'true':'false'}}"
                                       aria-controls="subSidebar">{{$subCriteria->title}}</a>
                                    <ul class="collapse sub-menu {{!in_array($subCriteria->id,$activeSidebar)?'':'show'}}"
                                        id="sub-{{$subCriteria->id}}">
                                        @foreach($subCriteria->children as $child)
                                            @if($child->children->count()>0)
                                            <a class="link-sidebar text-decoration-none dropdown {{!in_array($child->id,$activeSidebar)?'collapsed':''}}"
                                                data-bs-toggle="collapse" href="#sub-{{$child->id}}" role="button"
                                                aria-expanded="{{!in_array($child->id,$activeSidebar)?'true':'false'}}"
                                                aria-controls="subSidebar">{{$subCriteria->title}}</a>
                                                <ul class="collapse sub-menu {{!in_array($child->id,$activeSidebar)?'':'show'}}"
                                                    id="sub-{{$child->id}}">
                                                    @foreach($child->children as $childChildren)
                                                    <li class="item-sidebar">
                                                        <a href="{{route('audit::iso14001.detail.criteria-audit.detail',['id'=>$audit->id,'criteria_id'=>$childChildren->id])}}"
                                                        class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                                        <span class="d-flex gap-2">
                                                            <span>{{$childChildren->title}}</span>
                                                        </span>
                                                        </a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <li class="item-sidebar">
                                                    <a href="{{route('audit::iso14001.detail.criteria-audit.detail',['id'=>$audit->id,'criteria_id'=>$child->id])}}"
                                                    class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                                    <span class="d-flex gap-2">
                                                        <span>{{$child->title}}</span>
                                                    </span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <a href="{{route('audit::iso14001.detail.criteria-audit.detail',['id'=>$audit->id,'criteria_id'=>$subCriteria->id])}}"
                                       class="link-sidebar text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="d-flex gap-2">
                                        <span>{{$subCriteria->title}}</span>
                                    </span>
                                    </a>
                                @endif

                            </li>
                        @endforeach

                    </ul>
                </li>
            @endforeach
        </ul>
    </div><!-- /.menu-right-content -->
</div><!-- /.sidebar-menu-right -->
