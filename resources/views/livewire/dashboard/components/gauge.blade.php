<div class="gauge-wrapper position-relative">
    <div class="gauge-container">
		<div class="gauge-a"></div>
		<div class="gauge-b"></div>
		<div class="gauge-c"></div>
		<div class="gauge-data">
            <h2>{{ $textCenter }}</h2>
        </div>
	</div>
</div>
@push('scripts')

<script>
    var persen = (({{$percent}}/100) * 180).toFixed(2);
    document.querySelector('.gauge-c').style.transform = "rotate("+persen+"deg)";
</script>
    
@endpush
@push('styles')
<style>
.gauge-container{
	width:250px;
	height:125px;
	position: relative;
	overflow: hidden;
	text-align: center;
}
.gauge-a{
	z-index: 1;
	position: absolute;
	background-color: rgba(255,255,255,.2);
	width: 250px;
	height: 125px;
	top: 0%;
	border-radius:250px 250px 0px 0px ;
}
.gauge-b{
	z-index: 3;
	position: absolute;
	background-color: #ffffff;
	width: 200px;
	height: 125px;
	top: 25px;
	margin-left: 25px;
	margin-right: auto;
	border-radius:250px 250px 0px 0px ;
}
.gauge-c{
	z-index: 2;
	position: absolute;
	background-color: #19A7CE;
	width: 250px;
	height: 125px;
	top: 125px;
	margin-left: auto;
	margin-right: auto;
	border-radius:0px 0px 150px 150px ;
    transform-origin:center top;
	transition: all 1.3s ease-in-out;
    transform: rotate(0deg)
}

.gauge-container:hover .gauge-c{
	transform:rotate(.5turn);
}

.gauge-data{
	z-index: 4;
	color: #000000;
	font-size: 1.5em;
	line-height: 25px;
	position: absolute;
	width: 250px;
	height: 150px;
	top: 75px;
	margin-left: auto;
	margin-right: auto;
	transition: all 1s ease-out;
}
</style>
@endpush
