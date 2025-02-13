<?php

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

  public function testValidateReturnsTrueForValidProductType()
  {
    // ACT
    $validation = $this->productType->validate();

    // ASSERT
    $this->assertTrue($validation);
  }

  /**
   * @dataProvider invalidProductTypeDataProvider
   */
  public function testValidateReturnsFalseForInvalidProductType(array $invalidDataArray)
  {
    // ACT
    $productType = new ProductType($invalidDataArray);
    $validation = $productType->validate();

    // ASSERT
    $this->assertFalse($validation);
  }

  public function testUuidMatchesRegex()
  {
    // ACT
    $uuid = $this->productType->getUuid();
    $regexUuid = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    // ASSERT
    $this->assertMatchesRegularExpression($regexUuid, $uuid);
  }
}
