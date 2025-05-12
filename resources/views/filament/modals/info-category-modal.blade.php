<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PDF</title>

	<link href="{{ public_path('css/filament/filament/app.css') }}" rel="stylesheet">

	<style>

		ul {
			list-style-type:disc;
			margin-bottom:1.25em;
			margin-top:1.25em;
			padding-inline-start:1.625em
		}

		fieldset, legend {
			padding: 5px;
		}

	</style>

</head>

<body>

	<div class="p-4">
		<div class="space-y-4">
			@foreach ($categories as $category)
			<fieldset class="border border-gray-300 rounded-lg p-4">
				
				<legend class="text-md font-semibold">{!! $category['category'] !!}</legend>


				<div class="mt-2">
					<label class="fi-modal-heading text-base font-semibold leading-6 text-gray-950 dark:text-white me-6">Omschrijving</label>
					<p class="fi-modal-description text-sm text-gray-500 dark:text-gray-400 mt-2">{!! $category->category_remark !!}</p>
				</div>


				<div class="mt-2">
					<label class="fi-modal-heading text-base font-semibold leading-6 text-gray-950 dark:text-white me-6">Voorbeelden</label>
					<p class="fi-modal-description text-sm text-gray-500 dark:text-gray-400 mt-2">{!! $category->example !!}</p>
				</div>


				<div class="mt-2">
					<label class="fi-modal-heading text-base font-semibold leading-6 text-gray-950 dark:text-white me-6">Inspectie interval</label>
					<!-- <p class="fi-modal-description text-sm text-gray-500 dark:text-gray-400 mt-2">
						{!! 'Eens in de ' . $category->inspection_interval . ' jaar' !!}
					</p> -->

					<p class="fi-modal-description text-sm text-gray-500 dark:text-gray-400 mt-2">
						@if ($category->inspection_interval == 0)Nooit
						@elseif ($category->inspection_interval == 1) {!! 'Eens per jaar '!!}
						@else {!! 'Eens in de ' . $category->inspection_interval . ' jaar' !!}
						@endif
					</p>

				</div>

			</fieldset>
			@endforeach
		</div>
	</div>



</body>
</html>



