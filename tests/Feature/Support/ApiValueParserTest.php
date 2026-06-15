<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\Support\ApiValueParser;

describe('ApiValueParser::bool()', function () {
    it('converts string "true" to true', fn () => expect(ApiValueParser::bool('true'))->toBeTrue());
    it('converts string "false" to false', fn () => expect(ApiValueParser::bool('false'))->toBeFalse());
    it('converts string "1" to true', fn () => expect(ApiValueParser::bool('1'))->toBeTrue());
    it('converts string "0" to false', fn () => expect(ApiValueParser::bool('0'))->toBeFalse());
    it('passes through native true', fn () => expect(ApiValueParser::bool(true))->toBeTrue());
    it('passes through native false', fn () => expect(ApiValueParser::bool(false))->toBeFalse());
    it('treats integer 1 as true', fn () => expect(ApiValueParser::bool(1))->toBeTrue());
    it('treats integer 0 as false', fn () => expect(ApiValueParser::bool(0))->toBeFalse());
    it('treats null as false', fn () => expect(ApiValueParser::bool(null))->toBeFalse());
});

describe('ApiValueParser::amount()', function () {
    it('parses a European decimal comma', fn () => expect(ApiValueParser::amount('19,99'))->toBe(19.99));
    it('parses a negative amount', fn () => expect(ApiValueParser::amount('-12,35'))->toBe(-12.35));
    it('returns 0.0 for null', fn () => expect(ApiValueParser::amount(null))->toBe(0.0));
    it('returns 0.0 for empty string', fn () => expect(ApiValueParser::amount(''))->toBe(0.0));
    it('parses a plain integer string', fn () => expect(ApiValueParser::amount('100'))->toBe(100.0));
    it('parses zero', fn () => expect(ApiValueParser::amount('0,00'))->toBe(0.0));
});

describe('ApiValueParser::countries()', function () {
    it('returns list of strings from array', fn () => expect(ApiValueParser::countries(['ES', 'IT']))->toBe(['ES', 'IT']));
    it('returns empty array for null', fn () => expect(ApiValueParser::countries(null))->toBe([]));
    it('returns empty array for scalar', fn () => expect(ApiValueParser::countries('ES'))->toBe([]));
    it('filters out non-string array elements', fn () => expect(ApiValueParser::countries(['ES', 42, null, 'IT']))->toBe(['ES', 'IT']));
    it('returns empty array for empty array', fn () => expect(ApiValueParser::countries([]))->toBe([]));
});

describe('ApiValueParser::cancelReturnInitiator()', function () {
    it('returns null for null', fn () => expect(ApiValueParser::cancelReturnInitiator(null))->toBeNull());
    it('returns null for empty string', fn () => expect(ApiValueParser::cancelReturnInitiator(''))->toBeNull());
    it('returns null for "null-null"', fn () => expect(ApiValueParser::cancelReturnInitiator('null-null'))->toBeNull());
    it('returns null when actor is null', fn () => expect(ApiValueParser::cancelReturnInitiator('null-cancel'))->toBeNull());
    it('returns null when action is null', fn () => expect(ApiValueParser::cancelReturnInitiator('buyer-null'))->toBeNull());
    it('returns value for valid initiator', fn () => expect(ApiValueParser::cancelReturnInitiator('buyer-cancel'))->toBe('buyer-cancel'));
    it('returns value for system initiator', fn () => expect(ApiValueParser::cancelReturnInitiator('system-cancel'))->toBe('system-cancel'));
});
