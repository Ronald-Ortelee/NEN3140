<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PDF</title>

	<link href="{{ public_path('pdf.css') }}" rel="stylesheet">
	<style>

		#inspectie_object {
			border-collapse: collapse;
			width: 100%;
		}

		#inspectie_object td, #inspectie_object th {
			border: 1px solid #ddd;
			padding: 8px;
		}

		#inspectie_object tr:nth-child(even){background-color: #f2f2f2;}

		#inspectie_object tr:hover {background-color: #ddd;}

		#inspectie_object th {
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			background-color: #04AA6D;
			color: white;
		}
		
		#inspectie_items {
			border-collapse: collapse;
			width: 100%;
		}

		#inspectie_items td, #inspectie_items th {
			border: 1px solid #ddd;
			padding: 8px;
		}

		#inspectie_items tr:nth-child(even){background-color: #f2f2f2;}

		#inspectie_items tr:hover {background-color: #ddd;}

		#inspectie_items th {
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			background-color: #04AA6D;
			color: white;
		}
	</style>

</head>


<body>
	<h1>Test Certificaat <br> voor arbeidsmiddel # {{ $parent->id }}</h1>
	<p>Keuringen uitgevoerd door: {{ $child->user->name }}</p>
	<p>Keuringen uitgevoerd voor: Stichting CREA</p>


	<p>Locatie van dit arbeidsmiddel: {{ $parent->location->name}}</p>


	<p>Het hieronder vermelde arbeidsmiddel is getest volgens NEN-EN50110/ NEN3140, <br>
	met het eveneens vermelde resultaat zoals bevonden op het moment van testen.</p>


	<h4>Arbeidsmiddel en test details</h4>

	<hr>

<!-- 	<table>
		<tr>
			<td><p>Arbeidsmiddel</p></td>
			<td>:  </td>
			<td><p># {{ $parent->id }}</p></td>
			<td></td>
			<td><p>Getest door</p></td>
			<td>:  </td>
			<td><p>{{ $child->user->name }}</p></td>
		</tr>
		<tr>
			<td><p>Soort</p></td>
			<td>:  </td>
			<td><p> {{ $parent->type->name }}</p></td>
			<td></td>
			<td><p>Testinstrument</p></td>
			<td>:  </td>
			<td><p>EazyPAT3140 USB</p></td>
		</tr>
		<tr>
			<td><p>Merk</p></td>
			<td>:  </td>
			<td><p> {{ $parent->brand->name }}</p></td>
			<td></td>
			<td><p>Serienummer tester</p></td>
			<td>:  </td>
			<td><p>30R-0936</p></td>
		</tr>
		<tr>
			<td><p>Type</p></td>
			<td>:  </td>
			<td><p>{{ $parent->type->name}}</p></td>
			<td></td>
			<td><p>Inspectie datum</p></td>
			<td>:  </td>
			<td><p>datum</p></td>
		</tr>
		<tr>
			<td><p>Inspectie datum</p></td>
			<td>:  </td>
			<td><p>{{ $child->date_of_inspection }}</p></td>
		</tr>
	</table> -->

	<table id="inspectie_object">
		<tr>
			<th>Test item</th>
			<th>Waarde</th>
			<th>Resultaat</th>
		</tr>
		<tr>
			<td>Visuele inspection</td>
			<td>{{ $child->visual_inspection }}</td>
			<td>{{ $child->visual_inspection_result }}</td>
		</tr>
		<tr>
			<td>Isolatieweerstand</td>
			<td>{{ number_format($child->isolation_resistance, 2, ',', '.') }} &#937;</td>
			<td>{{ $child->isolation_resistance_result }}</td>
		</tr>
		<tr>
			<td>Aardingsweerstand</td>
			<td>{{ number_format($child->earth_conductor_resistance, 2, ',', '.') }} &#937;</td>
			<td>{{ $child->earth_conductor_resistance_result }}</td>
		</tr>
		<tr>
			<td>{{ $child->leakage_current_type }} lekstroom </td>
			<td>{{ number_format( $child->leakage_current , 2, ',', '.') }} mA;</td>
			<td>{{ $child->leakage_current_result }}</td>
		</tr>
		<tr>
			<td>Functionele test</td>
			<td>{{ $child->functional_test_result }}</td>
			<td>{{ $child->isolation_resistance_result }}</td>
		</tr>
		<tr>
			<td>Bijzonderheden</td>
			<td>{{ $child->remarks }}</td>
			<td></td>
		</tr>
		<tr>
			<td>Eindresultaat</td>
			<td>{{ $child->inspection_result }}</td>
			<td></td>
		</tr>

		<tr>
			<td>Volgende inspectie</td>
			<td>{{ $nextInspection}}</td>
			<td></td>
		</tr>

	</table>

	

	<table id="inspectie_items">
		<tr>
			<th>Test item</th>
			<th>Waarde</th>
			<th>Resultaat</th>
		</tr>
		<tr>
			<td>Visuele inspection</td>
			<td>{{ $child->visual_inspection }}</td>
			<td>{{ $child->visual_inspection_result }}</td>
		</tr>
		<tr>
			<td>Isolatieweerstand</td>
			<td>{{ number_format($child->isolation_resistance, 2, ',', '.') }} &#937;</td>
			<td>{{ $child->isolation_resistance_result }}</td>
		</tr>
		<tr>
			<td>Aardingsweerstand</td>
			<td>{{ number_format($child->earth_conductor_resistance, 2, ',', '.') }} &#937;</td>
			<td>{{ $child->earth_conductor_resistance_result }}</td>
		</tr>
		<tr>
			<td>{{ $child->leakage_current_type }} lekstroom </td>
			<td>{{ number_format( $child->leakage_current , 2, ',', '.') }} mA;</td>
			<td>{{ $child->leakage_current_result }}</td>
		</tr>
		<tr>
			<td>Functionele test</td>
			<td>{{ $child->functional_test_result }}</td>
			<td>{{ $child->isolation_resistance_result }}</td>
		</tr>
		<tr>
			<td>Bijzonderheden</td>
			<td>{{ $child->remarks }}</td>
			<td></td>
		</tr>
		<tr>
			<td>Eindresultaat</td>
			<td>{{ $child->inspection_result }}</td>
			<td></td>
		</tr>

		<tr>
			<td>Volgende inspectie</td>
			<td>{{ $nextInspection}}</td>
			<td></td>
		</tr>

	</table>

	<!-- <h2>Inspectie</h2>
	<p><strong>Inspectie datum:</strong> {{ $child->date_of_inspection }}</p>
	<p><strong>Resultaat:</strong> {{ $child->inspection_result }}</p>
	<p><strong>Tester:</strong> {{ $child->user->name }}</p>

	<h2>Details</h2>

	<p><strong>Visuele inspection:</strong> {{ $child->visual_inspection }}</p>
	<p><strong>Resultaat:</strong> {{ $child->visual_inspection_result }}</p>

	<p><strong>Isolatieweerstand:</strong> {{ number_format($child->isolation_resistance, 2, ',', '.') }} &#937;</p>  
	<p><strong>Resultaat:</strong> {{ $child->isolation_resistance_result }}</p>

	<p><strong>Aardingsweerstand:</strong> {{ number_format($child->earth_conductor_resistance, 2, ',', '.') }} &#937;</p>
	<p><strong>Resultaat:</strong> {{ $child->earth_conductor_resistance_result }}</p>

	<p><strong>Lekstroom:</strong> {{ number_format( $child->leakage_current , 2, ',', '.') }} mA;</p>
	<p><strong>Resultaat:</strong> {{ $child->leakage_current_result }}</p>
	<p><strong>Meetprincipe:</strong> {{ $child->leakage_current_type }} lekstroom</p>

	<p><strong>Functionele test:</strong> {{ $child->functional_test_result }}</p>
	<p><strong>Resultaat:</strong> {{ $child->isolation_resistance_result }}</p>

	<p><strong>Bijzonderheden:</strong> {{ $child->remarks }}</p>
	<p><strong>Eindresultaat:</strong> {{ $child->inspection_result }}</p>
 -->

</body>
</html>
