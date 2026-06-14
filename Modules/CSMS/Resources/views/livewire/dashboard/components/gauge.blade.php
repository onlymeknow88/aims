<div class="gauge-wrapper position-relative mb-3">
    <div class="gauge-container">
		<canvas id="gaugeSap"></canvas>
		<div class="text-gauge">{{$text}}</div>
	</div>
</div>

@once
	@push('scripts')
		<script src="{{ asset('assets/libs/gauge/gauge.min.js') }}"></script>
	@endpush
@endonce

@push('scripts')

<script>
    var opts = {
		angle: 0, // The span of the gauge arc
		lineWidth: 0.44, // The line thickness
		radiusScale: 1, // Relative radius
		pointer: {
			length: 0.6, // // Relative to gauge radius
			strokeWidth: 0.035, // The thickness
			color: '#91BA5F' // Fill color
		},
		limitMax: false,     // If false, max value increases automatically if value > maxValue
		limitMin: false,     // If true, the min value of the gauge will be fixed
		colorStart: '#00552F',   // Colors
		colorStop: '#00552F',    // just experiment with them
		strokeColor: '#E0E0E0',  // to see which ones work best for you
		generateGradient: true,
		highDpiSupport: true,     // High resolution support
	
	};
	var target = document.getElementById('gaugeSap'); // your canvas element
	var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
	gauge.maxValue = {{$maxValue}}; // set max gauge value
	gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
	gauge.animationSpeed = 55; // set animation speed (32 is default value)
	gauge.set({{$text}}); // set actual value
</script>
    
@endpush
@push('styles')
<style>
	.gauge-container{
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}
	.text-gauge{
		font-weight: 700;
		text-align: center;
		font-size: 24px;
	}
</style>
@endpush
