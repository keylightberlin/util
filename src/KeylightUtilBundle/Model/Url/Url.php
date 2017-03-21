<?php

namespace KeylightUtilBundle\Model\Url;

class Url
{
    const BROKEN_URL = "The URL is too broken to be used";
    const NO_PROTOCOL = "There is no protocol in the given URL";
    const NO_DOMAIN = "There is no domain in the given URL";
    const NO_HOST = "There is no Host in the given URL";

    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $urlParsed;

    /**
     * @param string $url
     */
    function __construct($url)
    {
        $this->url = $url;
        $this->urlParsed = parse_url($url);
        $this->checkUrlIsValid();
    }

    /**
     * @return array
     */
    private function getAllDomainParts()
    {
        return explode(".", $this->urlParsed["host"]);
    }

    /**
     * Calculate Number of Subdomains.
     * @return int
     */
    public function getNumberOfSubDomains()
    {
        $allDomainParts = $this->getAllDomainParts();
        return max(0, count($allDomainParts) - 2);
    }

    /**
     * Returns the original url
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns the Domain combined with the Top Level Domain as string.
     * @return string
     */
    public function  getDomainWithTopLevelDomain()
    {
        return $this->getDomain() . "." . $this->getTopLevelDomain();
    }

    /**
     * Returns the complete host.
     * @return string
     */
    public function getHost()
    {
        return  $this->urlParsed["host"];
    }
    /**
     * Returns a string with all Subdomains or empty string if there are none.
     * @return string
     */
    public function getAllSubDomainsAsString()
    {
        return implode(".", $this->getAllSubDomainsAsArray());
    }

    /**
     * Returns all Subdomains as array.
     * @return array
     */
    public function getAllSubDomainsAsArray()
    {
        $allDomainParts = $this->getAllDomainParts();
        return array_slice($allDomainParts, 0, -2);
    }

    /**
     * Returns the Subdomain at the given index starting at 0, if no index is given it returns the highest subdomain.
     * @param int $index
     * @return string
     */
    public function getSubDomain($index = 0)
    {
        return array_reverse($this->getAllSubDomainsAsArray())[$index] ?? "";
    }

    /**
     * Returns the Domain.
     * @return string
     */
    public function getDomain()
    {
        $allDomainParts = $this->getAllDomainParts();
        return $allDomainParts[count($allDomainParts)-2];
    }

    /**
     * Returns the Top Level Domain.
     * @return string
     */
    public function getTopLevelDomain()
    {
        $allDomainParts = $this->getAllDomainParts();
        return $allDomainParts[count($allDomainParts)-1];
    }

    /**
     * Returns the Protocol.
     * @return string
     */
    public function getProtocol()
    {
        return $this->urlParsed["scheme"];
    }

    /**
     * Returns the Port or empty string if not existent.
     * @return string
     */
    public function getPort()
    {
        return $this->urlParsed["port"] ?? "";
    }

    /**
     * Returns the User or empty string if not existent.
     * @return string
     */
    public function getUser()
    {
        return $this->urlParsed["user"] ?? "";
    }

    /**
     * Returns the Pass or empty string if not existent.
     * @return string
     */
    public function getPass()
    {
        return $this->urlParsed["pass"] ?? "";
    }

    /**
     * Returns the Path or empty string if not existent.
     * @return string
     */
    public function getPath()
    {
        return $this->urlParsed["path"] ?? "";
    }

    /**
     * Returns the Query or empty string if not existent.
     * @return string
     */
    public function getQuery()
    {
        return $this->urlParsed["query"] ?? "";
    }

    /**
     * Returns the Fragment or empty string if not existent.
     * @return string
     */
    public function getFragment()
    {
        return $this->urlParsed["fragment"] ?? "";
    }

    /**
     * @throws \Exception
     */
    private function checkUrlIsValid()
    {
        if (false === $this->urlParsed) {
            throw new \Exception(static::BROKEN_URL);
        }
        if (false === array_key_exists("host", $this->urlParsed)) {
            throw new \Exception(static::NO_HOST);
        }
        if (
            false === array_key_exists("scheme" , $this->urlParsed)
            || $this->urlParsed["scheme"] === ""
        ) {
            throw new \Exception(static::NO_PROTOCOL);
        }
        $allDomainParts = $this->getAllDomainParts();
        if ($allDomainParts[count($allDomainParts) - 2] === "") {
            throw new \Exception(static::NO_DOMAIN);
        }

    }
}
