@extends('app')
@section('active_employee', 'active')
@section('content')
	<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="header">Подробная информация</div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                {{ $employee->first_name }}&nbsp;{{$employee->last_name}}
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-md-2">
									<b>День рождения</b>
                                </div>
                                <div class="col-md-10">
                                    <p>
                                        {{ $employee->birth_date }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
									<b>Пол</b>
                                </div>
                                <div class="col-md-10">
                                    <p>
                                        @if($employee->gender == 'M')
                                        Мужчина
                                        @else
                                        Женщина
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
									<b>Начало карьеры</b>
                                </div>
                                <div class="col-md-10">
                                    <p>
                                        {{ $employee->hire_date }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
									<b>Департаменты</b>
                                </div>
                                <div class="col-md-10">
                                    <p>
                                        @for ($i = 0; $i < count($departments); $i++)
										    <b>{{ $departments[$i]['dept_name'] }}</b>&nbsp;&nbsp;({{$departments[$i]['from_date']}}&nbsp;-&nbsp;{{$departments[$i]['to_date']}})<br>
										@endfor
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
									<b>Должность</b>
                                </div>
                                <div class="col-md-10">
                                    <p>
                                        @for ($i = 0; $i < count($jobs); $i++)
										    <b>{{ $jobs[$i]['position'] }}</b>&nbsp;&nbsp;({{$jobs[$i]['from_date']}}&nbsp;-&nbsp;{{$jobs[$i]['to_date']}})<br>
										@endfor
                                    </p>
                                </div>
                            </div>
                            <div class="row">		             
		                        <div class="body col-md-6">
		                            <div id="bar_chart" height="600"></div>
		                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')

	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
	$(function() {
	  'use strict';
	  (function(factory) {
	    if (typeof module === 'object' && module.exports) {
	      module.exports = factory;
	    } else {
	      factory(Highcharts);
	    }
	  }(function(Highcharts) {
	    (function(H) {
	      H.wrap(H.seriesTypes.column.prototype, 'translate', function(proceed) {
	        const options = this.options;
	        const topMargin = options.topMargin || 0;
	        const bottomMargin = options.bottomMargin || 0;

	        proceed.call(this);

	        H.each(this.points, function(point) {
	          if (options.borderRadiusTopLeft || options.borderRadiusTopRight || options.borderRadiusBottomRight || options.borderRadiusBottomLeft) {
	            const w = point.shapeArgs.width;
	            const h = point.shapeArgs.height;
	            const x = point.shapeArgs.x;
	            const y = point.shapeArgs.y;

	            let radiusTopLeft = H.relativeLength(options.borderRadiusTopLeft || 0, w);
	            let radiusTopRight = H.relativeLength(options.borderRadiusTopRight || 0, w);
	            let radiusBottomRight = H.relativeLength(options.borderRadiusBottomRight || 0, w);
	            let radiusBottomLeft = H.relativeLength(options.borderRadiusBottomLeft || 0, w);

	            const maxR = Math.min(w, h) / 2

	            radiusTopLeft = radiusTopLeft > maxR ? maxR : radiusTopLeft;
	            radiusTopRight = radiusTopRight > maxR ? maxR : radiusTopRight;
	            radiusBottomRight = radiusBottomRight > maxR ? maxR : radiusBottomRight;
	            radiusBottomLeft = radiusBottomLeft > maxR ? maxR : radiusBottomLeft;

	            point.dlBox = point.shapeArgs;

	            point.shapeType = 'path';
	            point.shapeArgs = {
	              d: [
	                'M', x + radiusTopLeft, y + topMargin,
	                'L', x + w - radiusTopRight, y + topMargin,
	                'C', x + w - radiusTopRight / 2, y, x + w, y + radiusTopRight / 2, x + w, y + radiusTopRight,
	                'L', x + w, y + h - radiusBottomRight,
	                'C', x + w, y + h - radiusBottomRight / 2, x + w - radiusBottomRight / 2, y + h, x + w - radiusBottomRight, y + h + bottomMargin,
	                'L', x + radiusBottomLeft, y + h + bottomMargin,
	                'C', x + radiusBottomLeft / 2, y + h, x, y + h - radiusBottomLeft / 2, x, y + h - radiusBottomLeft,
	                'L', x, y + radiusTopLeft,
	                'C', x, y + radiusTopLeft / 2, x + radiusTopLeft / 2, y, x + radiusTopLeft, y,
	                'Z'
	              ]
	            };
	          }

	        });
	      });
	    }(Highcharts));
	  }));
	  Highcharts.setOptions({
	    colors: ['#A3A1FB', '#5FE3A1']
		});
	  Highcharts.chart('bar_chart', {
	    chart: {
	        type: 'line'
	    },
	    title: {
	        text: ''
	    },
	    xAxis: {
	        categories: [
	        	@for ($i = 0; $i < count($date); $i++)
	        	"{{$date[$i]}}",
				@endfor
	        	],
	        labels: {
	            rotation: -70,
	            style: {
	                fontSize: '13px',
	                fontFamily: '"Proxima Nova Cn Rg", sans-serif'
	            }
	        }
	    },

	    yAxis: {
	    	gridLineColor: "#e6e6e6",
	        allowDecimals: false,
	        min: 0,
	        title: {
	            text: ''
	        }
	    },
	    tooltip: {
	        formatter: function () {
	            return '<b>' + this.x + '</b><br/>' +
	                this.series.name + ': ' + this.y ;
	        }
	    },

	   	plotOptions: {
	      	column: {
		        stacking: 'normal'
	      	},
	        style: {
	                fontSize: '13px',
	                fontFamily: '"Proxima Nova Cn Rg", sans-serif'
	            }
	    },

	    series: [{
	        name: 'Зарплата',
	        data: [
		        @for ($i = 0; $i < count($money); $i++)
		        	{{$money[$i]}},
				@endfor
			],
	        borderWidth: 0
	    }]
  	});
	});
</script>
@endsection
