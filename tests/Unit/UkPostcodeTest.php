<?php

namespace Tests\Unit;

use App\Rules\UkPostcode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class UkPostcodeTest extends TestCase
{
    #[DataProvider('validPostcodes')]
    public function test_valid_uk_postcodes(string $postcode): void
    {
        $this->assertTrue(UkPostcode::isValid($postcode));
    }

    #[DataProvider('invalidPostcodes')]
    public function test_invalid_postcodes(?string $postcode): void
    {
        $this->assertFalse(UkPostcode::isValid($postcode));
    }

    public function test_normalize_inserts_space(): void
    {
        $this->assertSame('SW1A 1AA', UkPostcode::normalize('sw1a1aa'));
        $this->assertSame('M1 1AE', UkPostcode::normalize('m11ae'));
    }

    public static function validPostcodes(): array
    {
        return [
            ['SW1A 1AA'],
            ['sw1a1aa'],
            ['EC1A 1BB'],
            ['W1A 0AX'],
            ['M1 1AE'],
            ['B33 8TH'],
            ['CR2 6XH'],
            ['DN55 1PT'],
            ['GIR 0AA'],
        ];
    }

    public static function invalidPostcodes(): array
    {
        return [
            [null],
            [''],
            ['12345'],
            ['ABC'],
            ['SW1A'],
            ['90210'],
            ['XXXX XXX'],
        ];
    }
}
