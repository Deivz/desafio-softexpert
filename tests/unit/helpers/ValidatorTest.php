<?php

use Deivz\DesafioSoftexpert\helpers\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Deivz\DesafioSoftexpert\models\Product;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
  public static function validRequestCase(): array
  {
    return [
      'should pass through validation' => [
        [
          'name' => 'Teste Ok',
          'price' => 1555,
          'tax' => 255,
        ],
        [
          'name' => ['RequiredValidation', 'MaxLengthValidation'],
          'price' => [
            'RequiredValidation',
            'IntValidation',
            'MaxNumberValidation',
            'PositiveNumberValidation',
            'PriceConvertionValidation',
          ],
          'tax' => [
            'RequiredValidation',
            'IntValidation',
            'MaxTaxValidation',
            'PositiveNumberValidation',
          ],
        ],
      ],
    ];
  }

  public static function invalidRequestCases(): array
  {
    return [
      'should return Required error message' => [
        [
          'name' => null,
        ],
        [
          'name' => ['RequiredValidation'],
        ],
        [
          'name' => ['Este campo é obrigatório.'],
        ],
      ],
      'should return MaxLength error message' => [
        [
          'name' => str_repeat('A', 300),
        ],
        [
          'name' => ['MaxLengthValidation'],
        ],
        [
          'name' => ['Este campo deve possuir no máximo 255 caracteres.'],
        ],
      ],
      'should return IntValidation error message' => [
        [
          'price' => 'invalid',
        ],
        [
          'price' => ['IntValidation'],
        ],
        [
          'price' => ['O valor deste campo deve ser um número inteiro.'],
        ],
      ],
      'should return MaxNumberValidation error message' => [
        [
          'price' => '1000000001',
        ],
        [
          'price' => ['MaxNumberValidation'],
        ],
        [
          'price' => ['Este campo não deve possuir valor maior que 100.000.000.'],
        ],
      ],
      'should return PositiveNumberValidation error message' => [
        [
          'price' => -1,
        ],
        [
          'price' => ['PositiveNumberValidation'],
        ],
        [
          'price' => ['O valor deste campo deve ser um número maior que 0.'],
        ],
      ],
      'should return PriceConvertionValidation error message' => [
        [
          'price' => -1,
        ],
        [
          'price' => ['PriceConvertionValidation'],
        ],
        [
          'price' => ['O preço precisa ser um número válido.'],
        ],
      ],
      'should return MaxTaxValidation error message' => [
        [
          'tax' => 200001,
        ],
        [
          'tax' => ['MaxTaxValidation'],
        ],
        [
          'tax' => ['Este campo não deve possuir valor maior que 200%.'],
        ],
      ],
    ];
  }

  #[DataProvider('invalidRequestCases')]
  public function test_validation_error($data, $validationRules, $valueExpected): void
  {
    // ARRANGE
    $isValid = Validator::validate($data, $validationRules);

    // ACT
    $errorsArray = Validator::getErrors();

    // ASSERT
    $this->assertEquals($valueExpected, $errorsArray);
  }

  #[DataProvider('validRequestCase')]
  public function test_valid_data($data, $validationRules): void
  {
    // ARRANGE
    $isValid = Validator::validate($data, $validationRules);

    // ACT
    $errorsArray = Validator::getErrors();

    // ASSERT
    $this->assertEquals([], $errorsArray);
  }
}
