<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InspectionResource\Pages;
use App\Filament\Resources\InspectionResource\RelationManagers;
use App\Models\Inspection;
use App\Models\Dut;
use App\Models\User;
use App\Models\Location;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\PassFail;
use App\Enums\Lekstroom;
use App\Enums\InspectionResult;

class InspectionResource extends Resource
{
	protected static ?string $model = Inspection::class;

	protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

	protected static ?string $navigationGroup = 'Resources';

	public static function form(Form $form): Form
	{

		return $form
		->schema([

			Forms\Components\Section::make()
			->schema([ 

				Forms\Components\TextInput::make('user_id')
				->default(fn ($livewire) => $data = auth()->id())
				->extraInputAttributes(['readonly' => true]),

				Forms\Components\DatePicker::make('date_of_inspection')
				->native(false)
				->label('Inspectiedatum')
				->displayFormat('l d F Y')
				->locale('nl')
				->closeOnDateSelection()
				->required(),

				Forms\Components\Textarea::make('visual_inspection')
				->required(),

				Forms\Components\ToggleButtons::make('visual_inspection_result')
				->inline()
				->options(PassFail::class)
				->required(),

			])
			->columns(2),


			Forms\Components\Section::make('Veiligheids testen')
			->description('Lekstroom, aarding')
			->schema([ 

				Forms\Components\TextInput::make('isolation_resistance')
				->required()
				->numeric(),

				Forms\Components\ToggleButtons::make('isolation_resistance_result')
				->inline()
				->options(PassFail::class)
				->required(),

				Forms\Components\TextInput::make('earth_conductor_resistance')
				->required()
				->numeric(),

				Forms\Components\ToggleButtons::make('earth_conductor_resistance_result')
				->inline()
				->options(PassFail::class)
				->required(),

				Forms\Components\TextInput::make('leakage_current')
				->required()
				->numeric(),

				Forms\Components\ToggleButtons::make('leakage_current_type')
				->inline()
				->options(Lekstroom::class)
				->required(),

				Forms\Components\ToggleButtons::make('leakage_current_result')
				->inline()
				->options(PassFail::class)
				->required(),
				
				Forms\Components\ToggleButtons::make('functional_test_result')
				->inline()
				->options(PassFail::class)
				->required(),


				Forms\Components\Textarea::make('remarks')
				->required()
				->columnSpanFull(),

				Forms\Components\ToggleButtons::make('inspection_result')
				->inline()
				->options(InspectionResult::class)
				->required(),

			])
			->columns(2),

		]);

	}

	public static function table(Table $table): Table
	{
		return $table
		->columns([
			Tables\Columns\TextColumn::make('date_of_inspection')
			->date()
			->sortable(),
			Tables\Columns\TextColumn::make('user.name')
			->sortable(),
			Tables\Columns\TextColumn::make('isolation_resistance')
			->numeric()
			->toggleable(isToggledHiddenByDefault: true)
			->sortable(),
			Tables\Columns\TextColumn::make('earth_conductor_resistance')
			->numeric()
			->toggleable(isToggledHiddenByDefault: true)
			->sortable(),
			Tables\Columns\TextColumn::make('real_leakage_current')
			->numeric()
			->toggleable(isToggledHiddenByDefault: true)
			->sortable(),
			Tables\Columns\TextColumn::make('replacement_leakage_current')
			->numeric()
			->toggleable(isToggledHiddenByDefault: true)
			->sortable(),
		])
		->filters([
                //
		])
		->actions([
			Tables\Actions\EditAction::make(),
		])
		->bulkActions([
			Tables\Actions\BulkActionGroup::make([
				Tables\Actions\DeleteBulkAction::make(),
			]),
		]);
	}

	public static function getRelations(): array
	{
		return [
            //
		];
	}

	public static function getPages(): array
	{
		return [
			'index' => Pages\ListInspections::route('/'),
			'create' => Pages\CreateInspection::route('/create'),
			'edit' => Pages\EditInspection::route('/{record}/edit'),
		];
	}
}
