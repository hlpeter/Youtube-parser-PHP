<?php

/**
 * Simple utility for parsing information from a Youtube URL.
 */
class Youtube
{
    /**
     * Default length of a Youtube video ID.
     *
     * @var int
     */
    private $length_id = 11;

    /**
     * Url that should be parsed.
     *
     * @var string|null
     */
    private $youtube_link;

    /**
     * Create a new Youtube parser instance.
     *
     * @param string|null $youtube_link Optional link to parse
     */
    public function __construct(?string $youtube_link = null)
    {
        $this->set($youtube_link);
    }

    /**
     * Set the Youtube link that will be parsed by all methods.
     *
     * @param string|null $youtube_link
     * @return void
     */
    public function set(?string $youtube_link): void
    {
        $this->youtube_link = $youtube_link;
    }

    /**
     * Check whether the current URL is a valid Youtube URL.
     *
     * @return bool
     */
    public function valid(): bool
    {
        return strpos($this->get_part('host'), 'youtu.be') !== false ||
            strpos($this->get_part('host'), 'youtube.com') !== false ||
            strpos($this->get_part('host'), 'youtube-nocookie.com') !== false;
    }

    /**
     * Parse the url using {@see parse_url}.
     *
     * @return array
     */
    private function parse(): array
    {
        return parse_url($this->youtube_link);
    }

    /**
     * Detect if a given string exists in the url host.
     *
     * @param string $url
     * @return bool
     */
    private function detect_url(string $url): bool
    {
        return strpos($this->get_host(), $url) !== false;
    }

    /**
     * Determine if the url points to an embedded video.
     *
     * @return bool
     */
    public function is_embed(): bool
    {
        return $this->valid() && strpos($this->get_part('path'), 'embed') !== false;
    }

    /**
     * Check for short url formats such as /e/, /v/, /shorts/.
     *
     * @return bool
     */
    private function is_short_format(): bool
    {
        $path = $this->get_part('path');
        $re = '/\/(e|v|shorts|clip|live)\/[a-zA-Z0-9_-]{11}$/';

        return preg_match($re, $path) === 1;
    }

    /**
     * Get a specific part from the parsed url.
     *
     * @param string $part
     * @return string|null
     */
    private function get_part(string $part): ?string
    {
        $parsed = $this->parse();

        return array_key_exists($part, $parsed) ? $parsed[$part] : null;
    }

    /**
     * Get host from the current youtube url.
     *
     * @return string|null
     */
    public function get_host(): ?string
    {
        return $this->get_part('host');
    }

    /**
     * Retrieve the video id from the current url if possible.
     *
     * @return string|null
     */
    public function get_id(): ?string
    {
        if ($this->valid()) {
            if ($this->detect_url('youtu.be')) {
                return str_replace('/', '', $this->get_part('path'));
            }

            if ($this->detect_url('youtube.com') || $this->detect_url('youtube-nocookie.com')) {
                if ($this->is_embed() || $this->is_short_format()) {
                    return substr($this->get_part('path'), -$this->length_id);
                }

                parse_str($this->get_part('query'), $query);

                return isset($query['v']) ? $query['v'] : null;
            }
        }

        return null;
    }

    /**
     * Get start time from the url if present.
     *
     * @return string|null
     */
    public function get_time(): ?string
    {
        if ($this->valid()) {
            parse_str($this->get_part('query'), $query);
            parse_str($this->get_part('fragment'), $fragment);

            if (isset($query['t'])) {
                return str_replace('s', '', $query['t']);
            }

            if (isset($fragment['t'])) {
                return str_replace('s', '', $fragment['t']);
            }
        }

        return null;
    }

    /**
     * Retrieve playlist identifier from the url.
     *
     * @return string|null
     */
    public function get_list(): ?string
    {
        if ($this->valid()) {
            parse_str($this->get_part('query'), $query);

            if (isset($query['list'])) {
                return $query['list'];
            }
        }

        return null;
    }

    /**
     * Casts object to string returning the original url.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->youtube_link;
    }
}

?>

