<?php

use Deivz\DesafioSoftexpert\models\ProductType;
use PHPUnit\Framework\TestCase;

class ProductTypeModelTest extends TestCase
{

  private ProductType $productTypeOk;
  private ProductType $productTypeInvalid;

  protected function setUp(): void
  {
    // ARRANGE
    $requestOk = [
      'name' => 'Eletroeletrônicos'
    ];

    $requestInvalid = [
      'name' => 'Quero que tenha mais de 255 caracteres
      Quero que tenha mais de 255 caracteres
      Quero que tenha mais de 255 caracteres
      Quero que tenha mais de 255 caracteres
      Quero que tenha mais de 255 caracteres
      Quero que tenha mais de 255 caracteres
      Quero que tenha mais de 255 caracteres'
    ];

    $productType = new ProductType($requestOk);
    $this->productTypeOk = $productType;

    $productType = new ProductType($requestInvalid);
    $this->productTypeInvalid = $productType;
  }

  public function testValidateReturnsTrueForValidProductType()
  {
    // ACT
    $validation = $this->productTypeOk->validate();
    
    // ASSERT
    $this->assertTrue($validation);
  }

  public function testValidateReturnsFalseForInvalidProductType()
  {
    // ACT
    $validation = $this->productTypeInvalid->validate();
    
    // ASSERT
    $this->assertFalse($validation);
  }

  public function testUuidMatchesRegex()
  {
    // ACT
    $uuid = $this->productTypeOk->getUuid();
    $regexUuid = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    // ASSERT
    $this->assertMatchesRegularExpression($regexUuid, $uuid);
  }
}
