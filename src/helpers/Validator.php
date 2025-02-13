<?php

namespace Deivz\DesafioSoftexpert\helpers;

use Deivz\DesafioSoftexpert\interfaces\ValidationInterface;

class Validator
{
  private static $errors = [];

  public static function validate(array $data, array $rules): bool
  {
    self::$errors = [];
    foreach ($rules as $field => $strategies) {
      foreach ($strategies as $strategy) {
        $class = "Deivz\\DesafioSoftexpert\\helpers\\" . $strategy;
        $classInstance = new $class();
        $error = $classInstance->validate($data[$field] ?? null);
        if ($error) {
          self::$errors[$field][] = $error;
        }
      }
    }
    return empty(self::$errors);
  }

  public static function getErrors(): array
  {
    return self::$errors;
  }
}

class RequiredValidation implements ValidationInterface
{
  public function validate(mixed $value): ?string
  {
    return empty($value) ? "Este campo é obrigatório." : null;
  }
}

class IntValidation implements ValidationInterface
{
  public function validate(mixed $value): ?string
  {
    return is_int($value) ? null : "O valor deste campo deve ser um número inteiro.";
  }
}

class PositiveNumberValidation implements ValidationInterface
{
  public function validate(mixed $value): ?string
  {
    return $value >= 0 ? null : "O valor deste campo deve ser um número maior que 0.";
  }
}

class MaxLengthValidation implements ValidationInterface
{
  public function validate(mixed $value): ?string
  {
    return strlen($value) <= 255 ? null : "Este campo deve possuir no máximo 255 caracteres.";
  }
}

class PriceConvertionValidation implements ValidationInterface
{
  public function validate(mixed $value): ?string
  {
    return $value === -1 ? "O preço precisa ser um número válido." : null;
  }
}

class MaxNumberValidation implements ValidationInterface
{
  public function validate(mixed $value): ?string
  {
    return $value > 100000000 ? "Este campo não deve possuir valor maior que 100.000.000." : null;
  }
}

class MaxTaxValidation implements ValidationInterface
{
  public function validate(mixed $value): ?string
  {
    return $value > 20000 ? "Este campo não deve possuir valor maior que 200%." : null;
  }
}
