<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    private $productServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productServiceMock = $this->mock(ProductService::class);
    }

    function test_it_show_product_create_form()
    {
        $url = action([ProductController::class, 'create']);

        $response = $this->get($url);

        $response->assertViewIs('product.create');
    }

    function makeInvalidData($invalidInputs)
    {
        $validInputs = [
            'name' => 'A Product',
            'sku' => 'a-product-sku',
            'qty' => 1,
            'description' => 'I am the master key, buy me!',
        ];

        return array_filter(array_merge($validInputs, $invalidInputs), function ($value) {
            return $value !== null;
        });
    }

    /**
     * @dataProvider provideInvalidName
     * @dataProvider provideInvalidQuantity
     * @dataProvider provideInvalidSku
     * @dataProvider provideInvalidImage
     */
    function test_it_show_error_when_input_invalid($inputKey, $inputValue)
    {
        $url = action([ProductController::class, 'store']);
        $inputs = $this->makeInvalidData([
            $inputKey => is_callable($inputValue) ? $inputValue() : $inputValue,
        ]);

        $this->productServiceMock->shouldNotReceive('create');

        $response = $this->post($url, $inputs);

        $response->assertSessionHasErrors([$inputKey]);
    }

    function provideInvalidName()
    {
        return [
            // Tên dataset => dataset value [$inputKey, $inputValue]
            'Name is required' => ['name', null],
            'Name is limit to 255 chars' => ['name', str_repeat('a', 256)],
        ];
    }

    function provideInvalidQuantity()
    {
        return [
            'Quantity is required' => ['qty', null],
            'Quantity should be integer' => ['qty', 1.1],
            'Quantity should be greater than 1' => ['qty', 0],
        ];
    }

    function provideInvalidSku()
    {
        return [
            'SKU is required' => ['sku', null],
            'SKU must be unique' => [
                'sku',
                function () {
                    Product::factory()->create(['sku' => 'existed-sku']);

                    return 'existed-sku';
                },
            ],
        ];
    }

    function provideInvalidImage()
    {
        return [
            'Image must be jpg or png' => [
                'image',
                function () {
                    Storage::fake();

                    return UploadedFile::fake()->image('product.gif');
                },
            ],
        ];
    }

    function test_it_create_product_if_data_is_valid()
    {
        $url = action([ProductController::class, 'store']);
        $validInputs = [
            'name' => 'A product',
            'sku' => 'a-product-sku',
            'qty' => 1,
            'description' => 'I am the master key, buy me!',
        ];

        $this->productServiceMock
            ->shouldReceive('create')
            ->andReturn(new Product);

        $response = $this->post($url, $validInputs);

        $response->assertRedirect();
        $response->assertSessionHas('product');
    }
}
