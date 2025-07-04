<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Dut;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    public function test_brand_can_be_created(): void
    {
        $brand = Brand::factory()->create([
            'name' => 'Test Brand',
        ]);

        $this->assertDatabaseHas('brands', [
            'name' => 'Test Brand',
        ]);
    }

    public function test_brand_has_filament_name(): void
    {
        $brand = Brand::factory()->create([
            'name' => 'Test Brand',
        ]);

        $this->assertEquals('Test Brand', $brand->getFilamentName());
    }

    public function test_brand_has_display_name_attribute(): void
    {
        $brand = Brand::factory()->create([
            'name' => 'Test Brand',
        ]);

        $this->assertEquals('Test Brand', $brand->display_name);
    }

    public function test_brand_can_have_duts(): void
    {
        $brand = Brand::factory()->create();
        $dut = Dut::factory()->create(['brand_id' => $brand->id]);

        $this->assertTrue($brand->duts->contains($dut));
        $this->assertEquals(1, $brand->duts->count());
    }

    public function test_brand_search_scope(): void
    {
        Brand::factory()->create(['name' => 'Siemens']);
        Brand::factory()->create(['name' => 'ABB']);
        Brand::factory()->create(['name' => 'Schneider']);

        $results = Brand::search('Siemens')->get();

        $this->assertEquals(1, $results->count());
        $this->assertEquals('Siemens', $results->first()->name);
    }

    public function test_brand_validation_rules(): void
    {
        $rules = Brand::getValidationRules();

        $this->assertArrayHasKey('name', $rules);
        $this->assertContains('required', $rules['name']);
        $this->assertContains('string', $rules['name']);
        $this->assertContains('max:255', $rules['name']);
        $this->assertContains('unique:brands,name', $rules['name']);
    }
} 