<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DutResource\Pages;
use App\Filament\Resources\DutResource\RelationManagers;
use App\Models\Dut;
use App\Models\DeviceType;
use App\Models\Category;
use App\Models\User;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Group;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Get;
use Closure;
use Filament\Actions\Modal;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Resources\Forms\Components;


use Carbon\Carbon;

class DutResource extends Resource
{

	protected static ?string $modelLabel = 'Arbeidsmiddel';
	protected static ?string $pluralModelLabel = 'Arbeidsmiddelen';
	protected static ?string $model = Dut::class;

// navigatie

	protected static ?string $navigationBadgeTooltip = 'Het aantal geregistreerde apparaten';

	protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

	protected static ?string $navigationLabel = 'Arbeidsmiddelen';

	public static function getNavigationBadge(): ?string
	{
		return static::getModel()::count();
	}

	protected static ?string $interval = '10';

	protected static ?string $recordTitleAttribute = 'id';

	public static function form(Form $form): Form
	{
		return $form
		->schema([

			Forms\Components\Group::make()
			->schema([

				Forms\Components\Section::make('Locatie')
				->schema([  

					Forms\Components\Select::make('location_id')
					->relationship(name: 'DutLocationId', titleAttribute: 'name')
					->required()
					->searchable()
					->label('De gangbare locatie van dit arbeidsmiddel')
					->preload()->createOptionForm([
						Forms\Components\TextInput::make('name')
						->unique(ignoreRecord: true)
						->label('De gangbare locatie van dit arbeidsmiddel'),
					])
					->columns(2),

				])
				->columnSpan(['lg' => 2]),

				Forms\Components\Section::make('Algemene kenmerken')
				->schema([ 

					Forms\Components\Select::make('devicetype_id')
					->relationship(name: 'DutDeviceTypeId', titleAttribute: 'name')
					->required()
					->label('Soort arbeidsmiddel')
					->searchable()
					->preload()
					->createOptionForm([
						Forms\Components\TextInput::make('name')
						->label('Soort arbeidsmiddel')
						->unique(ignoreRecord: true)
						->required(),
						Forms\Components\Select::make('category_id')
						->relationship(name: 'category', titleAttribute: 'category')
						->required()
						->label('Risico categorie')
						->hintAction(
							Action::make('showHint')
							->modalHeading('Risico categorieën')
							->modalDescription('De bij het arbeidsmiddel behorende categorie bepaalt de inspectie-interval.')
							->modalContent(view('filament.modals.info-category-modal', [
								'categories' => Category::all(),
							]))
            			->modalSubmitAction(false) // Hides the submit button
            		)
						->preload()
					]),

					Forms\Components\Select::make('safety_class_id')
					->relationship(name: 'DutSafetyClassId', titleAttribute: 'name')
					->required()
					->label('Veiligheidsklasse')
					->preload(),

					Forms\Components\Select::make('brand_id')
					->relationship(name: 'DutBrandId', titleAttribute: 'name')
					->required()
					->label('Merk')
					->searchable()
					->preload()
					->createOptionForm([
						Forms\Components\TextInput::make('name')
						->unique(ignoreRecord: true)
						->label('Merk'),
					]),

					Forms\Components\Select::make('type_id')
					->relationship(name: 'DutTypeId', titleAttribute: 'name')
					->required()
					->label('Modelnummer')
					->searchable()
					->preload()
					->createOptionForm([
						Forms\Components\TextInput::make('name')
						->unique(ignoreRecord: true)
						->label('Modelnummer'),
					]),

					Forms\Components\DatePicker::make('date_in_use')
					->native(false)
					->displayFormat('l d F Y')
					->locale('nl')
					->default(now()) 
					->closeOnDateSelection()
					->label('In gebruik sinds')
					->required(),

					Forms\Components\DatePicker::make('date_out_of_use')
					->native(false)
					->displayFormat('l d F Y')
					->locale('nl')
					->label('Buiten gebruik gesteld')

					->required(fn ($get) => ! $get('status'))
					->visible(fn ($get) => ! $get('status'))


					->closeOnDateSelection(),

				])
				->columns(2),

			])
			->columnSpan(['lg' => 2]),

			Forms\Components\Group::make()
			->schema([

				Forms\Components\Section::make('Status')
				->schema([

					Forms\Components\Toggle::make('status')
					->label('In gebruik')
					->helperText('This product will be hidden from all sales channels.')
					->reactive()
					->default(true),

					Forms\Components\Placeholder::make('Laatste_inspectie')
					->columns(4)
					->label('Laatste inspectie')
					->content(fn ($record) => optional($record->inspections()->latest('date_of_inspection')->first())->date_of_inspection ?? 'Nog nooit geinspecteerd'
				),



				// 	Forms\Components\Placeholder::make('Staat')
				// 	->inlinelabel()
				// 	->columns(4)
				// 	->label('Laatste inspectie')
				// 	->content(fn ($record) => optional($record->inspections()->latest('date_of_inspection')->first())->inspection_result ?? 'Nog nooit geinspecteerd'
				// ),



					Forms\Components\Placeholder::make('Inspectie interval')
					->content(fn ($record): string => $record->DutsInCategory->inspection_interval . ' jaar')
					->label('Inspectie interval'),

					Forms\Components\Placeholder::make('Volgende_inspectie')
					->label('Volgende inspectie')
					->content(function ($record) {
						$latestInspection = optional($record->inspections()->latest('date_of_inspection')->first())->date_of_inspection;
						if ($latestInspection) {
							return Carbon::parse($latestInspection)
							->addYears($record->DutsInCategory->inspection_interval)
							->format('Y-m-d');
						}
						return now()->format('Y-m-d');
					}),

                // Forms\Components\Placeholder::make('created_at')
                // ->label('Geregistreerd')
                // ->content(fn (Dut $record): ?string => $record->created_at?->diffForHumans()),

                // Forms\Components\Placeholder::make('updated_at')
                // ->label('Aangepast')
                // ->content(fn (Dut $record): ?string => $record->updated_at?->diffForHumans()),

				]),

			])
			->hidden(fn (?Dut $record) => $record === null)
			->columnSpan(['lg' => 1]),
		])
->columns(3);
}

public static function table(Table $table): Table
{  
	return $table
	->description('Overzicht van geregistreerde arbeidsmiddelen.')
	->defaultPaginationPageOption(15)
	->columns


	([

		Tables\Columns\TextColumn::make('id')
		->numeric(decimalPlaces: 0)
		->numeric(thousandsSeparator: '')
		->searchable()
		->badge()
		->label('CREA ID'),


		Tables\Columns\TextColumn::make('inspection_resultss')
		->label('Status')

		->formatStateUsing(fn ($record) => optional($record->inspections()->latest('date_of_inspection')->first())->inspection_result)
		->placeholder('nog niet getest')

		->getStateUsing(function ($record) {
			return optional($record->inspections()->latest('date_of_inspection')->first())->inspection_result;
		})
		->badge(),


		Tables\Columns\TextColumn::make('Volgende_inspectie')
		->label('Volgende inspectie')
		->getStateUsing(function ($record) {
			return optional($record->inspections()->latest('date_of_inspection')->first())->date_of_inspection;
		})
		->placeholder('nog nooit gekeurd')
// ->placeholder(now()->format('Y-m-d'))
		->sortable(query: function (Builder $query, string $direction, $column): Builder {
			return $query->withAggregate('inspections', 'date_of_inspection')
			->orderBy(implode('_', ['inspections', 'date_of_inspection']), $direction);
		})
		->formatStateUsing(function ($record) {
// Retrieve the latest inspection date.
			$latestInspection = optional(
				$record->inspections()->latest('date_of_inspection')->first()
			)->date_of_inspection;
// If a latest inspection exists, add the inspection interval and format the date.
			if ($latestInspection) {
				return Carbon::parse($latestInspection)
				->addYears($record->DutsInCategory->inspection_interval)
				->format('Y-m-d');
			}
		}),


		Tables\Columns\TextColumn::make('Laatste_inspectie')
		->label('Laatste inspectie')
		->toggleable(isToggledHiddenByDefault: true)
		->formatStateUsing(fn ($record) => optional($record->inspections()->latest('date_of_inspection')->first())->date_of_inspection)
		->placeholder(now()->format('Y-m-d'))
		->getStateUsing(function ($record) {
			return optional($record->inspections()->latest('date_of_inspection')->first())->date_of_inspection;
		})
		->sortable(query: function (Builder $query, string $direction, $column): Builder {
			return $query->withAggregate('inspections', 'date_of_inspection')
			->orderBy(implode('_', ['inspections', 'date_of_inspection']), $direction);
		}),






		Tables\Columns\TextColumn::make('DutDeviceTypeId.name')
		->label('Soort')
		->sortable(),

		Tables\Columns\TextColumn::make('DutBrandId.name')
		->numeric()
		->label('Merk')
		->sortable(),

		Tables\Columns\TextColumn::make('DutsInCategory.category')
		->label('Risico klasse')
		->sortable()
		->toggleable(isToggledHiddenByDefault: true),

		Tables\Columns\TextColumn::make('DutsInCategory.inspection_interval')
		->label('inspectie interval')
		->sortable()
		->toggleable(isToggledHiddenByDefault: true),

		Tables\Columns\TextColumn::make('DutTypeId.name')
		->numeric()
		->sortable()
		->label('Modelnummer')
		->toggleable(isToggledHiddenByDefault: true),

		Tables\Columns\TextColumn::make('DutLocationId.name')
		->numeric()
		->label('Locatie')
		->sortable(),

		Tables\Columns\TextColumn::make('DutUserId.name')
		->label('Tester'),

		Tables\Columns\TextColumn::make('date_in_use')
		->date()
		->label('Datum in gebruikname')
		->toggleable(isToggledHiddenByDefault: true)
		->sortable(),

		Tables\Columns\TextColumn::make('date_out_of_use')
		->date()
		->label('Datum uit gebruik genomen')
		->toggleable(isToggledHiddenByDefault: true)
		->sortable(),

		Tables\Columns\TextColumn::make('DutSafetyClassId.name')
		->toggleable(isToggledHiddenByDefault: true)
		->label('Veiligheidsklasse')
		->sortable(),

		Tables\Columns\TextColumn::make('created_at')
		->dateTime()
		->sortable()
		->toggleable(isToggledHiddenByDefault: true),

		Tables\Columns\TextColumn::make('updated_at')
		->dateTime()
		->sortable()
		->toggleable(isToggledHiddenByDefault: true),

	])
	->defaultSort('Volgende_inspectie', 'asc')

	->actions([
		Tables\Actions\EditAction::make()->label(__('Bewerk')),
		// Tables\Actions\ViewAction::make()->label(__('Bekijk')),
	])
	->bulkActions([
// Tables\Actions\BulkActionGroup::make([
//     Tables\Actions\DeleteBulkAction::make(),
// ]),
	]);
}




public static function getRelations(): array
{
	return [
		RelationManagers\InspectionsRelationManager::class
	];
}


public static function getPages(): array
{
	return [
		'index' => Pages\ListDuts::route('/'),
		'create' => Pages\CreateDut::route('/create'),
		'edit' => Pages\EditDut::route('/{record}/edit'),
        // 'view' => Pages\ViewDut::route('/{record}'),
	];
}

}
