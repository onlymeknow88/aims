@php
    $id = empty($id) ? null : $id;
@endphp

<div class="container mt-3">
    <button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#ModalCategoryK3lhAward">
        Open modal
    </button>
</div>

<!-- The Modal -->
<div class="modal fade" id="ModalCategoryK3lhAward">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" id="ModalCategoryHeader" style="cursor: move;">
                <h6 class="modal-title">Penghargaan K3LH</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-3">

                <div class="k3lh-award-body">
                    @foreach ($data as $index => $list)
                        <div class="k3lh-award-item d-flex align-items-center gap-1 mb-2">
                            <div class="circle bg-secondary">{{ $list['rank'] }}</div>

                            <div class="right-c flex-grow-1 d-flex flex-column  lh-1  p-2">
                                <span>{{ $list['company'] }}</span>
                            </div><!-- /.right-c -->
                        </div><!-- /.calendar-list-item -->
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>



<script>
    //Make the DIV element draggagle:
    dragElement(document.getElementById("ModalCategoryK3lhAward"));

    function dragElement(elmnt) {
        var pos1 = 0,
            pos2 = 0,
            pos3 = 0,
            pos4 = 0;
        if (document.getElementById(elmnt.id + "header")) {
            /* if present, the header is where you move the DIV from:*/
            document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
        } else {
            /* otherwise, move the DIV from anywhere inside the DIV:*/
            elmnt.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            // set the element's new position:
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
        }

        function closeDragElement() {
            /* stop moving when mouse button is released:*/
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
</script>
