<?php

namespace App\Helpers;

namespace App\Helpers;

class FirestoreHelper
{
    public static function formatDocument(array $document): array
    {
        $fields = [];

        foreach ($document as $key => $value) {
            if (is_int($value)) {
                $fields[$key] = ['integerValue' => $value];
            } elseif (is_bool($value)) {
                $fields[$key] = ['booleanValue' => $value];
            } elseif (is_array($value)) {
                $fields[$key] = [
                    'arrayValue' => [
                        'values' => array_map([self::class, 'formatValue'], $value)
                    ]
                ];
            } elseif (is_object($value) && method_exists($value, 'format')) {
                $fields[$key] = self::formatDocument($value->format());
            } else {
                $fields[$key] = ['stringValue' => (string) $value];
            }
        }

        return $fields;
    }

    private static function formatValue($value): array
    {
        if (is_int($value)) {
            return ['integerValue' => $value];
        }
        if (is_bool($value)) {
            return ['booleanValue' => $value];
        }
        if (is_string($value)) {
            return ['stringValue' => $value];
        }

        return ['stringValue' => (string) $value];
    }

    public static function parseDocument(array $document): array
    {
        $fields = $document['fields'] ?? [];
        $parsed = [];

        foreach ($fields as $key => $value) {
            $parsed[$key] = self::parseValue($value);
        }

        return $parsed;
    }

    private static function parseValue(array $value)
    {
        if (isset($value['stringValue'])) {
            return $value['stringValue'];
        }
        if (isset($value['integerValue'])) {
            return (int) $value['integerValue'];
        }
        if (isset($value['booleanValue'])) {
            return (bool) $value['booleanValue'];
        }
        if (isset($value['arrayValue'])) {
            return array_map([self::class, 'parseValue'], $value['arrayValue']['values'] ?? []);
        }
        if (isset($value['mapValue'])) {
            return self::parseDocument(['fields' => $value['mapValue']['fields']]);
        }

        return $value;
    }
}
