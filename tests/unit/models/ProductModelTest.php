<?php

use PHPUnit\Framework\Attributes\DataProvider;
use Deivz\DesafioSoftexpert\models\Product;
use PHPUnit\Framework\TestCase;

class ProductModelTest extends TestCase
{

  private Product $product;

  protected function setUp(): void
  {
    // ARRANGE
    $requestOk = [
      'name' => 'Teste',
      'price' => '15,50',
      'product_type' => '2',
      'amount' => '5',
    ];

    $product = new Product($requestOk);
    $this->product = $product;
  }

  public static function priceRequestCases(): array
  {
    return [
      'should be converted and return the converted number' => [
        [
          'name' => "Price vai virar numero inteiro",
          'price' => '15,50',
          'product_type' => 'Não está sendo avaliado',
          'amount' => 'Não está sendo avaliado',
        ],
        1550,
      ],
      'should not be converted and return -1' => [
        [
          'name' => "Price vai virar menos um",
          'price' => 'invalid',
          'product_type' => 'Não está sendo avaliado',
          'amount' => 'Não está sendo avaliado',
        ],
        -1,
      ],
      'should return 0' => [
        [
          'name' => 'Sem price vai virar zero',
          'product_type' => 'Não está sendo avaliado',
          'amount' => 'Não está sendo avaliado',
        ],
        0,
      ],
    ];
  }

  public static function productTypeRequestCases(): array
  {
    return [
      'should be converted to int and return the number' => [
        [
          'name' => 'Product type vai virar numero inteiro',
          'price' => 'Não está sendo avaliado',
          'product_type' => '15',
          'amount' => 'Não está sendo avaliado',
        ],
        15,
      ],
      'should not be converted and return -1' => [
        [
          'name' => 'Product type vai virar menos um',
          'price' => 'Não está sendo avaliado',
          'product_type' => 'invalid',
          'amount' => 'Não está sendo avaliado',
        ],
        -1,
      ],
      'should return 0' => [
        [
          'name' => 'Sem product type retorna 0',
          'price' => 'Não está sendo avaliado',
          'amount' => 'Não está sendo avaliado',
        ],
        0,
      ],
    ];
  }

  public static function amountRequestCases(): array
  {
    return [
      'should be converted to int and return the number' => [
        [
          'name' => 'Amount vai virar numero inteiro',
          'price' => 'Não está sendo avaliado',
          'product_type' => 'Não está sendo avaliado',
          'amount' => '15',
        ],
        15,
      ],
      'should not be converted and return -1' => [
        [
          'name' => 'Amount vai virar menos um',
          'price' => 'Não está sendo avaliado',
          'product_type' => 'Não está sendo avaliado',
          'amount' => 'invalid',
        ],
        -1,
      ],
      'should return 0' => [
        [
          'name' => 'Sem amount retorna 0',
          'price' => 'Não está sendo avaliado',
          'product_type' => 'Não está sendo avaliado',
        ],
        0,
      ],
    ];
  }

  #[DataProvider('priceRequestCases')]
  public function test_price_convertions($request, $valueExpected): void
  {
    // ARRANGE
    $this->product = new Product($request);

    // ACT
    $product = $this->product->getPrice();

    // ASSERT
    $this->assertEquals($valueExpected, $product);
  }

  #[DataProvider('productTypeRequestCases')]
  public function test_product_type_convertions($request, $valueExpected): void
  {
    // ARRANGE
    $this->product = new Product($request);

    // ACT
    $product = $this->product->getProductType();

    // ASSERT
    $this->assertEquals($valueExpected, $product);
  }

  #[DataProvider('amountRequestCases')]
  public function test_amount_convertions($request, $valueExpected): void
  {
    // ARRANGE
    $this->product = new Product($request);

    // ACT
    $product = $this->product->getAmount();

    // ASSERT
    $this->assertEquals($valueExpected, $product);
  }

  public function test_uuid_matches_regex(): void
  {
    // ACT
    $uuid = $this->product->getUuid();
    $regexUuid = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    // ASSERT
    $this->assertMatchesRegularExpression($regexUuid, $uuid);
  }
}
