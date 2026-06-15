<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Exceptions;

use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException as SaloonRateLimitReachedException;

final class RateLimitReachedException extends SaloonRateLimitReachedException {}
