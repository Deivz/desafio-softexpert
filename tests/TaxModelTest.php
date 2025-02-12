<?php

use PHPUnit\Framework\TestCase;
use Deivz\DesafioSoftexpert\models\Tax;

class TaxModelTest extends TestCase
{

  private Tax $taxOk;
  private Tax $taxInvalid;

  protected function setUp(): void
  {
    // ARRANGE
    $requestOk = [
      'name' => 'Teste',
      'tax' => '10,50',
      'product_type' => '1',
    ];

    $requestInvalid = [
      'name' => '',
      'tax' => 'invalid',
      'product_type' => 'invalid',
    ];

    $tax = new Tax($requestOk);
    $this->taxOk = $tax;

    $tax = new Tax($requestInvalid);
    $this->taxInvalid = $tax;
  }

  public function testTaxShouldBeConvertedToInt()
  {
    // ACT
    $tax = $this->taxOk->getTax();


    // ASSERT
    $this->assertEquals(1050, $tax);
  }

  public function testTaxShouldBeMinusOne()
  {
    // ACT
    $tax = $this->taxInvalid->getTax();

    // ASSERT
    $this->assertEquals(-1, $tax);
  }

  public function testProductTypeShouldBeConvertedToInt()
  {
    // ACT
    $tax = $this->taxOk->getProductType();


    // ASSERT
    $this->assertEquals(1050, $tax);
  }

  public function testProductTypeShouldBeMinusOne()
  {
    // ACT
    $tax = $this->taxInvalid->getProductType();

    // ASSERT
    $this->assertEquals(-1, $tax);
  }

  public function testValidateReturnsTrueForValidTax()
  {
    // ACT
    $validation = $this->taxOk->validate();
    
    // ASSERT
    $this->assertTrue($validation);
  }

  public function testValidateReturnsFalseForInvalidTax()
  {
    // ACT
    $validation = $this->taxInvalid->validate();
    
    // ASSERT
    $this->assertFalse($validation);
  }

  public function testUuidMatchesRegex()
  {
    // ACT
    $uuid = $this->taxOk->getUuid();
    $regexUuid = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    // ASSERT
    $this->assertMatchesRegularExpression($regexUuid, $uuid);
  }
}
