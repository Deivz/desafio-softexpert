<?php

namespace Deivz\DesafioSoftexpert\interfaces;

interface ValidationInterface
{
  public function validate($value): ?string;
}
