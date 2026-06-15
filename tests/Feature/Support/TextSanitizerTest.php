<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\Support\TextSanitizer;

describe('TextSanitizer::clean()', function () {
    it('returns null for null input', fn () => expect(TextSanitizer::clean(null))->toBeNull());
    it('returns null for empty string', fn () => expect(TextSanitizer::clean(''))->toBeNull());
    it('returns null for whitespace-only string', fn () => expect(TextSanitizer::clean('   '))->toBeNull());

    it('strips HTML tags', fn () => expect(TextSanitizer::clean('<b>Hello</b>'))->toBe('Hello'));

    it('decodes HTML entities', fn () => expect(TextSanitizer::clean('H&amp;M'))->toBe('H&M'));

    it('decodes quote entities', fn () => expect(TextSanitizer::clean('&quot;Test&quot;'))->toBe('"Test"'));

    it('collapses multiple spaces', fn () => expect(TextSanitizer::clean('Hello   World'))->toBe('Hello World'));

    it('trims leading and trailing whitespace', fn () => expect(TextSanitizer::clean('  Hello  '))->toBe('Hello'));

    it('strips zero-width spaces', function () {
        $value = "Hello\u{200B}World";
        expect(TextSanitizer::clean($value))->toBe('HelloWorld');
    });

    it('handles mixed HTML and entities', fn () => expect(TextSanitizer::clean('<p>Hello &amp; World</p>'))->toBe('Hello & World'));

    it('passes through plain text unchanged', fn () => expect(TextSanitizer::clean('Plain text'))->toBe('Plain text'));
});
