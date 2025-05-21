<?php

namespace App\Filament\Resources\DutResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextEntry;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\InspectionResult;
use App\Enums\Lekstroom;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\ToggleButtons;
use Carbon\Carbon;
use PDF;


class InspectionsRelationManager extends RelationManager
{
	protected static string $relationship = 'inspections';







	
	public function form(Form $form): Form
	{



// Helper to normalize enum instances or plain values.
		$normalizeValue = fn ($value) => is_object($value) ? $value->value : $value;

// Helper to compute the overall status based on the four options.
		$computeOverallStatus = function (callable $get) use ($normalizeValue) {
			return (
				$normalizeValue($get('visual_inspection_result')) === InspectionResult::FOUT->value ||
				$normalizeValue($get('isolation_resistance_result')) === InspectionResult::FOUT->value ||
				$normalizeValue($get('earth_conductor_resistance_result')) === InspectionResult::FOUT->value ||
				$normalizeValue($get('leakage_current_result')) === InspectionResult::FOUT->value ||
				$normalizeValue($get('functional_test_result')) === InspectionResult::FOUT->value
			)
			? InspectionResult::FOUT->value
			: InspectionResult::GOED->value;
		};


		return $form
		->schema([

			Forms\Components\Section::make()
			->description(new HtmlString('Registratieformulier voor de testresultaten n.a.v. de periodieke keuring van een (elektrische) arbeidsmiddel. <br /> Uitgevoerd volgens de NEN3140'))
			->schema([ 

				Forms\Components\DatePicker::make('date_of_inspection')
				->default(now())
				->native(false)
				->autofocus(false)
				->readonly()
				->displayFormat('l d F Y')
				->locale('nl')
				->closeOnDateSelection()
				->label('Inspectiedatum')
				->required(),

				Forms\Components\Hidden::make('user_id')
				->default(fn ($livewire) => $data = auth()->id())
				->dehydrated(true),

			])
			->columns(4),

			Forms\Components\Section::make('Visuele inspectie')
			->description(new HtmlString('Check voor beschadigingen en stel vast of deze consequenties hebben voor een veilig gebruik. <br /> Het arbeidsmiddel kan hierdoor als afkeur of reparatie worden aangemerkt bij eindresultaat'))

			->schema([ 

				Forms\Components\Textarea::make('visual_inspection')
				->label('Bijzonderheden'),

				Forms\Components\ToggleButtons::make('visual_inspection_result')
				->inline()
				->label('Resultaat')
				->options(function () {
					return collect(InspectionResult::cases())
					->filter(fn ($enum) => ! in_array($enum->value, [
						InspectionResult::REPARATIE->value,
						InspectionResult::ONBEKEND->value,
					]))
					->mapWithKeys(fn ($enum) => [$enum->value => $enum->getLabel()])
					->toArray();
				})

				->required()
				->reactive()
				->afterStateUpdated(function (callable $set, callable $get, $state) use ($computeOverallStatus) {
					$set('inspection_result', $computeOverallStatus($get));
				}),

			])
			->columns(2),


			Forms\Components\Section::make('Veiligheids testen')
			->description('Elektrische testen m.b.t. lekstroom (reële of vervangende), aardingsweerstand en isolatieweerstand. Langere kabellengtes kunnen tot een te hoge aardingsweerstand leiden. Hiervoor de tabel met grenswaarden raadplegen')
			->schema([ 

				Fieldset::make()
				->schema([

					Forms\Components\TextInput::make('isolation_resistance')
					->required()
					->label('Isolatieweerstand')
					->suffix('Ω')
					->numeric(),

					Forms\Components\ToggleButtons::make('isolation_resistance_result')
					->inline()
					->label('Resultaat')
					->options(function () {
						return collect(InspectionResult::cases())
						->filter(fn ($enum) => ! in_array($enum->value, [
							InspectionResult::REPARATIE->value,
							InspectionResult::ONBEKEND->value,
						]))
						->mapWithKeys(fn ($enum) => [$enum->value => $enum->getLabel()])
						->toArray();
					})
					->required()
					->reactive()
					->afterStateUpdated(function (callable $set, callable $get, $state) use ($computeOverallStatus) {
						$set('inspection_result', $computeOverallStatus($get));
					}),
				]),

				Fieldset::make()
				->schema([

					Forms\Components\TextInput::make('earth_conductor_resistance')
					->required()
					->suffix('Ω')
					->label('Aardingsweerstand')
					->numeric(),

// Forms\Components\Placeholder::make('No Label')
// ->label(false)
// ->hint(new HtmlString(
// 	'Need more info? <a href="#"class="text-primary underline"
// 	onclick="Livewire.emit(\'openModal\', \'infolist-modal\')">tabel</a> to view details.')),


					Forms\Components\ToggleButtons::make('earth_conductor_resistance_result')
					->inline()
					->label('Resultaat')
					->options(function () {
						return collect(InspectionResult::cases())
						->filter(fn ($enum) => ! in_array($enum->value, [
							InspectionResult::REPARATIE->value,
							InspectionResult::ONBEKEND->value,
						]))
						->mapWithKeys(fn ($enum) => [$enum->value => $enum->getLabel()])
						->toArray();
					})
					->required()
					->reactive()
					->afterStateUpdated(function (callable $set, callable $get, $state) use ($computeOverallStatus) {
						$set('inspection_result', $computeOverallStatus($get));
					}),
				]),

				Fieldset::make()
				->schema([

					Forms\Components\TextInput::make('leakage_current')
					->required()
					->suffix('mA')
					->label('Lekstroom')
					->numeric(),

					Forms\Components\ToggleButtons::make('leakage_current_result')
					->inline()
					->label('Resultaat')
					->options(function () {
						return collect(InspectionResult::cases())
						->filter(fn ($enum) => ! in_array($enum->value, [
							InspectionResult::REPARATIE->value,
							InspectionResult::ONBEKEND->value,
						]))
						->mapWithKeys(fn ($enum) => [$enum->value => $enum->getLabel()])
						->toArray();
					})
					->required()
					->reactive()
					->afterStateUpdated(function (callable $set, callable $get, $state) use ($computeOverallStatus) {
						$set('inspection_result', $computeOverallStatus($get));
					}),

					Forms\Components\ToggleButtons::make('leakage_current_type')
					->inline()
					->options(Lekstroom::class)
					->label('Soort lekstroommeting')
					->required(),
				])

			])
			->columns(4),

			Forms\Components\Section::make('Functionele test')
			->description('Doet dit ding eigenlijk wel wat ie zou moeten doen.')
			->schema([ 

				Forms\Components\Textarea::make('remarks')
				->label('Bijzonderheden'),

				Forms\Components\ToggleButtons::make('functional_test_result')
				->inline()
				->label('Resultaat')
				->options(function () {
					return collect(InspectionResult::cases())
					->filter(fn ($enum) => ! in_array($enum->value, [
						InspectionResult::REPARATIE->value,
						InspectionResult::ONBEKEND->value,
					]))
					->mapWithKeys(fn ($enum) => [$enum->value => $enum->getLabel()])
					->toArray();
				})
				->required()
				->reactive()
				->afterStateUpdated(function (callable $set, callable $get, $state) use ($computeOverallStatus) {
					$set('inspection_result', $computeOverallStatus($get));
				})
				->required()
				->reactive()
				->afterStateUpdated(function (callable $set, callable $get, $state) use ($computeOverallStatus) {
					$set('inspection_result', $computeOverallStatus($get));
				}),
			])
			->columns(2),


			Forms\Components\Section::make('Eindresultaat')
			->description('Het oordeel na bovenstaande testen en inspecties.')
			->schema([ 

				Forms\Components\ToggleButtons::make('inspection_result')
				->inline()
				->options(InspectionResult::class)
				->label('Resultaat')
				->default('Onbekend')
				->required()

				->afterStateHydrated(function (callable $set, callable $get, $state) use ($computeOverallStatus) {
					if ($state === null) {
						$set('inspection_result', $computeOverallStatus($get));
					}
				})
				->reactive(),
			])
			->columns(2),
		]);
}


public function table(Table $table): Table
{
	return $table

	->recordTitleAttribute('dut_id')
	->heading('Inspecties')
	->columns([
		Tables\Columns\TextColumn::make('dut_id'),

		Tables\Columns\TextColumn::make('date_of_inspection')
		->date('l d F Y')
		->label('Inspectiedatum')
		->sortable(),

		Tables\Columns\TextColumn::make('user.name')
		->label('Tester'),

		Tables\Columns\TextColumn::make('inspection_result')
		->label('Resultaat')
		->badge(),
	])

	->defaultSort('date_of_inspection', 'desc')
	->filters([
//
	])
	->headerActions([
		// Tables\Actions\CreateAction::make()

		Tables\Actions\CreateAction::make()
		->after(function ($record, $livewire) {
			$livewire->dispatch('refreshPlaceholders');
		})
		->createAnother(false),
	])
	->actions([
		Tables\Actions\EditAction::make(),
		Tables\Actions\DeleteAction::make(),

//##### PDF ###############################################################################

		Action::make('pdf')
		->icon('heroicon-o-rectangle-stack')
		->action(function ($record, $livewire) {
// Get the parent (owner) record from the relation manager context
			$parent = $livewire->ownerRecord;


// Inspection interval
			$inspectionInterval = ($parent->DutsInCategory->inspection_interval);

// Compute the next inspection date.
			$nextInspection = Carbon::parse($record->inspection_date)
			->addYears($inspectionInterval)
			->format('d-m-Y');

// Optionally, ensure the parent has the necessary relationships loaded:
			$parent->load('inspections');

// You may also load additional data on $record if needed:
			$record->load('user');
			// $record->load('inspectionType');

// Generate the PDF using your Blade view, passing both parent and record data:
			$pdf = PDF::loadView('pdf.inspection', [
				'parent' => $parent,
				'child'  => $record,
				'nextInspection' => $nextInspection,
			]);

// Construct the file name and then outputs
			$parsedDate = Carbon::parse($record->date_of_inspection);
			$filename = 'CREA#' . $parent->id . '_' . $parsedDate->format('dmy') . '.pdf';
			return Response::streamDownload(function () use ($pdf) {
				echo $pdf->output();
			}, $filename);

		}),

//##### PDF ###############################################################################


	])



	->bulkActions([
		Tables\Actions\BulkActionGroup::make([
			Tables\Actions\DeleteBulkAction::make(),
		]),
	]);
}
}
