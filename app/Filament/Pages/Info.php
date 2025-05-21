<?php

namespace App\Filament\Pages;
use Illuminate\Support\Facades\DB;
use Filament\Pages\Page;

class Info extends Page
{
	protected static ?string $navigationIcon = 'heroicon-o-information-circle';
	protected static ?string $navigationLabel = 'Informatie';
	protected static string $view = 'filament.pages.info';
	protected static ?int $navigationSort = 3;

	public string $laravelVersion;
	public string $filamentVersion;
	public string $phpVersion;
	public string $mysqlVersion = 'Unknown';

	public function mount(): void
	{
        // Retrieve Laravel version. This will return something like "9.19.0" or "10.x" depending on your installation.
		$this->laravelVersion = app()->version();

        // Retrieve Filament version if available; otherwise, show a fallback value.
		$this->filamentVersion = 'v3.3.14';

        // Retrieve the current PHP version
		$this->phpVersion = phpversion();

         // Get the MySQL server version via PDO (works with Laravel's DB facade)
		try {
			$this->mysqlVersion = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_SERVER_VERSION);
		} catch (\Exception $e) {
			$this->mysqlVersion = 'Unable to retrieve MySQL version.';
		}
	}






}
