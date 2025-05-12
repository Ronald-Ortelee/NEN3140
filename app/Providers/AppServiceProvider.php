<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Actions\Action;

use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use App\Http\Responses\LoginResponse as CustomLoginResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginResponse::class, CustomLoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    	Field::macro("tooltip", function(string $tooltip) {
    		return $this->hintAction(
    			Action::make('help')
    			->icon('heroicon-o-question-mark-circle')
    			->extraAttributes(["class" => "text-gray-500"])
    			->label("")
    			->tooltip($tooltip)
    		);
    	});
    }
}
