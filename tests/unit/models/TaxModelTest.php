<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Deivz\DesafioSoftexpert\models\Tax;

class TaxModelTest extends TestCase
{

  private Tax $tax;

  protected function setUp(): void
  {
    // ARRANGE
    $requestOk = [
      'name' => 'Teste',
      'tax' => '10,50',
      'product_type' => '1',
    ];

    $tax = new Tax($requestOk);
    $this->tax = $tax;
  }

  public static function taxDataProvider(): array
  {
    return [
      'should be converted and return the converted number' => [
        [
          'name' => "Taxa vai virar numero inteiro",
          'tax' => '10,50',
          'product_type' => 'Não está sendo avaliado',
        ],
        1050,
      ],
      'should not be converted and return -1' => [
        [
          'name' => "Taxa vai virar menos um",
          'tax' => 'invalid',
          'product_type' => 'Não está sendo avaliado',
        ],
        -1,
      ],
      'should return 0' => [
        [
          'name' => 'Sem taxa vai virar zero',
          'product_type' => 'Não está sendo avaliado',
        ],
        0,
      ],
    ];
  }

  public static function productTypeDataProvider(): array
  {
    return [
      'should be converted to int and return the number' => [
        [
          'name' => 'Product type vai virar numero inteiro',
          'tax' => 'Não está sendo avaliado',
          'product_type' => '15',
        ],
        15,
      ],
      'should not be converted and return -1' => [
        [
          'name' => 'Product type vai virar menos um',
          'tax' => 'Não está sendo avaliado',
          'product_type' => 'invalid',
        ],
        -1,
      ],
      'should return 0' => [
        [
          'name' => 'Sem product type retorna 0',
          'tax' => 'Não está sendo avaliado',
        ],
        0,
      ],
    ];
  }

  #[DataProvider('taxDataProvider')]
  public function test_tax_convertions($request, $valueExpected): void
  {
    // ARRANGE
    $this->tax = new Tax($request);

    // ACT
    $tax = $this->tax->getTax();

    // ASSERT
    $this->assertEquals($valueExpected, $tax);
  }

  #[DataProvider('productTypeDataProvider')]
  public function test_product_type_convertions($request, $valueExpected): void
  {
    // ARRANGE
    $this->tax = new Tax($request);

    // ACT
    $tax = $this->tax->getProductType();

    // ASSERT
    $this->assertEquals($valueExpected, $tax);
  }

  public function test_uuid_matches_regex(): void
  {
    // ACT
    $uuid = $this->tax->getUuid();
    $regexUuid = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/';

    // ASSERT
    $this->assertMatchesRegularExpression($regexUuid, $uuid);
  }
}
