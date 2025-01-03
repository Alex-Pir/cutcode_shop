<?php

namespace Domain\Auth;

use Carbon\CarbonImmutable;
use Domain\Auth\Exceptions\JWTExpiredException;
use Domain\Auth\Exceptions\JWTParserException;
use Domain\Auth\Exceptions\JWTValidatorException;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Encoder;
use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Builder;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Token\RegisteredClaims;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Throwable;

final readonly class JWT
{
    public function __construct(
        private string $secret,
        private Encoder $encoder = new JoseEncoder(),
    ) {
    }

    public function create(string $id, bool $refresh = false): string
    {
        $builder = new Builder(
            $this->encoder,
            ChainedFormatter::default(),
        );

        return $builder
            ->issuedAt(now()->toImmutable())
            ->expiresAt($refresh ? now()->toImmutable()->addDay() : $this->getExpiresAt())
            ->relatedTo($id)
            ->getToken(new Sha256(), InMemory::base64Encoded($this->secret))
            ->toString();
    }

    public function getExpiresAt(): CarbonImmutable
    {
        return now()->toImmutable()->addHour();
    }

    public function parse(string $token): ?string
    {
        $parser = new Parser(
            $this->encoder
        );

        try {
            $parsedToken = $parser->parse($token);
        } catch (Throwable $e) {
            throw new JWTParserException($e->getMessage());
        }

        $key = InMemory::base64Encoded($this->secret);

        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            $key
        );

        $configuration->setValidationConstraints(
            new SignedWith(
                new Sha256(),
                $key
            )
        );

        if (!$configuration->validator()->validate($parsedToken, ...$configuration->validationConstraints())) {
            throw new JWTValidatorException('Validation failed');
        }

        if ($parsedToken->isExpired(now())) {
            throw new JWTExpiredException('Token expired');
        }

        return $parsedToken
            ->claims()
            ->get(RegisteredClaims::SUBJECT);
    }
}
