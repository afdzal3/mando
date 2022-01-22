@extends(backpack_view('blank'))

@php
    $unmappedZip  = App\Common\CommonHelper::getUnmappedRev()->count();
	
	$revCount = App\Models\RevAddress::count() + 1;
	$productCount = App\Models\Product::count();
	$zipCount = App\Models\Zip::count();
	$userCount = App\User::count();
	$articleCount = \Backpack\NewsCRUD\app\Models\Article::count();
	$lastArticle = \Backpack\NewsCRUD\app\Models\Article::orderBy('date', 'DESC')->first();
	$lastArticleDaysAgo = \Carbon\Carbon::parse($lastArticle->date)->diffInDays(\Carbon\Carbon::today());
 
 	// notice we use Widget::add() to add widgets to a certain group
	 Widget::add()->to('before_content')->type('div')->class('row')->content([
		// notice we use Widget::make() to add widgets as content (not in a group)
		Widget::make()
		    ->wrapper(['class' => 'col-4'])
			->type('progress')
			->class('card border-0 text-white bg-primary')
			->style('height:100%')
			->progressClass('progress-bar')
			->value($unmappedZip)
			->description('Unmapped Zip Code.')
			->progress(100*(int)$unmappedZip/$revCount)
			->hint($unmappedZip.' out of '.($revCount-1).'are unmapped'),
		// alternatively, to use widgets as content, we can use the same add() method,
		// but we need to use onlyHere() or remove() at the end
		Widget::add()
		    ->type('progress')
			->wrapper(['class' => 'col-4'])
		    ->class('card border-0 text-white bg-success')
		    ->progressClass('progress-bar')
		    ->value($zipCount)
		    ->description('Zip Codes Map.')
		    ->progress(100)
		    ->hint('Zipcode and city mapping')
		    ->onlyHere(),

	]);

	




    $widgets['before_content'][] = [
	  'type' => 'div',
	  'class' => 'row h-100',	  

	  'content' => [ // widgets 




		[ 
		        'type' => 'chart',
		        'wrapperClass' => 'col-md-6 h-100',
				'wrapper' => [

'style' => 'height: 1000;',

],
				'controller' => \App\Http\Controllers\Admin\Charts\ErrByInputStateChartController::class,
				'content' => [
				'header' => 'Input Data Error By State', // optional
				]
	    	],

		  	[ 
		        'type' => 'chart',
		        'wrapperClass' => 'col-md-6',
		      
		        'controller' => \App\Http\Controllers\Admin\Charts\ErrByStateChartController::class,
				'content' => [
				    'header' => 'Revised Data Error By State', // optional
				  
					
		    	]
	    	],


    	]
	];

 



@endphp

@section('content')
	{{-- In case widgets have been added to a 'content' group, show those widgets. --}}
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('group', 'content')->toArray() ])
@endsection
