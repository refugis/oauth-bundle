<?php declare(strict_types=1);

namespace Refugis\OAuthBundle\Encryption\KeyPair;

use Refugis\OAuthBundle\Enum\SignatureAlgorithm;

/**
 * Define an public/private key pair holder.
 */
interface KeyPairInterface
{
    /**
     * Gets the public key.
     *
     * @return string
     */
    public function getPublicKey(): string;

    /**
     * Gets the private key.
     *
     * @return string
     */
    public function getPrivateKey(): string;

    /**
     * Gets the signature algorithm for the key pair.
     *
     * @return SignatureAlgorithm
     */
    public function getSignatureAlgorithm(): SignatureAlgorithm;

    /**
     * Generates a new pair of keys and set the internal
     * state of the object accordingly.
     */
    public function resetKeyPair(): void;
}
