<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\Enums\Country;
use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\OrderStatus;

describe('OrderStatus::fromApiValue()', function () {
    it('normalizes a lowercase value', fn () => expect(OrderStatus::fromApiValue('pending'))->toBe('pending'));
    it('normalizes an uppercase value to lowercase', fn () => expect(OrderStatus::fromApiValue('PENDING'))->toBe('pending'));
    it('resolves the nrpending alias', fn () => expect(OrderStatus::fromApiValue('nrpending'))->toBe(OrderStatus::NonReturnablePending->value));
    it('resolves the nrconfirmed alias', fn () => expect(OrderStatus::fromApiValue('nrconfirmed'))->toBe(OrderStatus::NonReturnableConfirmed->value));
    it('resolves NRPENDING alias case-insensitively', fn () => expect(OrderStatus::fromApiValue('NRPENDING'))->toBe(OrderStatus::NonReturnablePending->value));
    it('passes through unknown values verbatim lowercased', fn () => expect(OrderStatus::fromApiValue('UNKNOWN_STATUS'))->toBe('unknown_status'));
    it('maps shipped status', fn () => expect(OrderStatus::fromApiValue('shipped'))->toBe(OrderStatus::Shipped->value));
    it('maps canceled status', fn () => expect(OrderStatus::fromApiValue('CANCELED'))->toBe(OrderStatus::Canceled->value));
});

describe('Marketplace::fromApiValue() and apiValue()', function () {
    it('normalizes lowercase miravia', fn () => expect(Marketplace::fromApiValue('miravia'))->toBe('miravia'));
    it('normalizes ae to aliexpress backing value', fn () => expect(Marketplace::fromApiValue('ae'))->toBe(Marketplace::AliExpress->value));
    it('normalizes uppercase AE', fn () => expect(Marketplace::fromApiValue('AE'))->toBe(Marketplace::AliExpress->value));
    it('apiValue returns miravia for Miravia case', fn () => expect(Marketplace::Miravia->apiValue())->toBe('miravia'));
    it('apiValue returns ae for AliExpress case', fn () => expect(Marketplace::AliExpress->apiValue())->toBe('ae'));
});

describe('Country::fromApiValue()', function () {
    it('normalizes uppercase ES to es', fn () => expect(Country::fromApiValue('ES'))->toBe('es'));
    it('passes through lowercase es', fn () => expect(Country::fromApiValue('es'))->toBe('es'));
    it('normalizes uppercase IT to it', fn () => expect(Country::fromApiValue('IT'))->toBe('it'));
    it('passes through an unknown country lowercased', fn () => expect(Country::fromApiValue('DE'))->toBe('de'));
});
