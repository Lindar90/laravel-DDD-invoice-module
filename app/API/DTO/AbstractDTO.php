<?php

declare(strict_types=1);

namespace App\API\DTO;

use ReflectionClass;

abstract class AbstractDTO
{
    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);
        $methods = $reflection->getMethods();
        $result = [];

        foreach ($methods as $method) {
            if ($this->isGetterMethod($method->name)) {
                $resultField = $this->extractFieldNameFromGetter($method->name);
                $getterResult = $method->invoke($this);
                $result[$resultField] = $this->processGetterResult($getterResult);
            }
        }

        return $result;
    }

    private function isGetterMethod(string $methodName): bool
    {
        return str_starts_with($methodName, 'get');
    }

    private function extractFieldNameFromGetter(string $getterName): string
    {
        return lcfirst(substr($getterName, 3));
    }

    private function processGetterResult($getterResult): mixed
    {
        if ($getterResult instanceof AbstractDTO) {
            return $getterResult->toArray();
        }

        if (is_array($getterResult)) {
            return $this->processArray($getterResult);
        }

        return $getterResult;
    }

    /**
     * @param AbstractDTO|object[] $array
     * @return mixed[]
     */
    private function processArray(array $array): array
    {
        $arrayResult = [];
        foreach ($array as $item) {
            if ($item instanceof AbstractDTO) {
                $arrayResult[] = $item->toArray();
            }
        }
        return $arrayResult;
    }
}
