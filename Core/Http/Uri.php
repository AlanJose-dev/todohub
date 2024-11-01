<?php

namespace Core\Http;

/**
 * Handle the incoming request ui.
 */
class Uri
{
    /**
     * Store the parsed uri.
     * @var array|false|int|string|null
     */
    private array $fragmentedUri = [];

    public function __construct(array $fragmentedUri)
    {
        $this->fragmentedUri = $fragmentedUri;
    }

    /**
     * Get the fragmented uri.
     * @return array
     */
    public function getFragmentedUri(): array
    {
        return $this->fragmentedUri;
    }

    /**
     * Get the uri path.
     * @return string
     */
    public function path(): string
    {
        return $this->fragmentedUri['path'];
    }

    /**
     * Get the uri query.
     * @return string|null
     */
    public function query(): ?string
    {
        return $this->fragmentedUri['query'];
    }

    /**
     * Get the uri host.
     * @return string
     */
    public function host(): string
    {
        return $this->fragmentedUri['host'];
    }

    /**
     * Get the uri scheme.
     * @return string
     */
    public function scheme(): ?string
    {
        return $this->fragmentedUri['scheme'] ?? null;
    }

    /**
     * Get the uri port.
     * @return int
     */
    public function port(): ?int
    {
        return $this->fragmentedUri['port'] ?? null;
    }

    /**
     * Get the uri fragment.
     * @return string|null
     */
    public function fragment(): ?string
    {
        return $this->fragmentedUri['fragment'] ?? null;
    }

    /**
     * Get the uri password.
     * @return string|null
     */
    public function pass(): ?string
    {
        return $this->fragmentedUri['pass'] ?? null;
    }

    /**
     * Get the uri user.
     * @return string|null
     */
    public function user(): ?string
    {
        return $this->fragmentedUri['user'] ?? null;
    }
}
