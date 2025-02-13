<?php

use PHPUnit\Framework\Attributes\DataProvider;
use Deivz\DesafioSoftexpert\models\ProductType;
use PHPUnit\Framework\TestCase;

class ProductTypeModelTest extends TestCase
{

  private ProductType $productType;

  protected function setUp(): void
  {
    // ARRANGE
    $requestOk = [
      'name' => 'Eletroeletrônicos'
    ];

    $productType = new ProductType($requestOk);
    $this->productType = $productType;
  }

  public static function invalidProductTypeDataProvider()
  {
    return [
      [['name' => str_repeat('A', 300)]], // Mais de 255 caracteres
      [['name' => ""]],
    ];
  }

  public function test_validate_returns_true_for_valid_product_type(): void
  {
    // ACT
    $validation = $this->productType->validate();

    // ASSERT
    $this->assertTrue($validation);
  }

  #[DataProvider('invalidProductTypeDataProvider')]
  public function test_validate_returns_false_for_invalid_product_type(array $invalidDataArray): void
  {
    // ACT
    $productType = new ProductType($invalidDataArray);
    $validation = $productType->validate();

    // ASSERT
    $this->assertFalse($validation);
  }

  public function test_uuid_matches_regex()
  {
    // ACT
    $uuid = $this->productType->getUuid();
    $regexUuid = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    // ASSERT
    $this->assertMatchesRegularExpression($regexUuid, $uuid);
  }
}
