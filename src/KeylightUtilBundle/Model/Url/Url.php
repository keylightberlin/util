<?php

namespace KeylightUtilBundle\Model\Url;

class Url
{
    const NO_PROTOCOL = "There is no protocol in the given URL";
    const NO_SUBDOMAIN = "There is no subdomain at the index in the given URL";
    const NO_DOMAIN = "There is no domain in the given URL";
    const NO_TLD = "There is no Top Level Domain in the given URL";
    const NO_HOST = "There is no Host in the given URL";

    private $url;
    private $urlParsed;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getUrlParsed()
    {
        return $this->urlParsed;
    }

    /**
     * Url constructor.
     * @param string $url
     */
    function __construct($url)
    {
        $this->url = $url;
        $this->urlParsed = parse_url($url);
    }
    /**
     * Returns the Subdomain at the given index starting at 0, if no index is given it returns the highest subdomain.
     * @param int $index
     * @return string
     */
    public function getSubDomain($index=0)
    {
        if (!array_key_exists ( "host" , $this->getUrlParsed())) {
            throw new \Exception(static::NO_HOST);
        }
        $host = $this->getUrlParsed()["host"];
        $subDomainAndDomain = explode(".",$host);
        if (count($subDomainAndDomain) <= $index + 1) {
            throw new \Exception(static::NO_SUBDOMAIN);
        } else {
            $subdomain = $subDomainAndDomain[count($subDomainAndDomain)-3-$index];
        }
        return $subdomain;
    }

    /**
     * Returns the Domain.
     * @return string
     */
    public function getDomain()
    {
        if (!array_key_exists ( "host" , $this->getUrlParsed())) {
            throw new \Exception(static::NO_HOST);
        }
        $host = $this->getUrlParsed()["host"];
        $subDomainAndDomain = explode(".",$host);
        if ($subDomainAndDomain[count($subDomainAndDomain)-2] == "") {
            throw new \Exception(static::NO_DOMAIN);
        } else {
            $domain = $subDomainAndDomain[count($subDomainAndDomain)-2];
        }
        return $domain;
    }

    /**
     * Returns the Top Level Domain.
     * @return string
     */
    public function getTopLevelDomain()
    {
        if (!array_key_exists ( "host" , $this->getUrlParsed())) {
            throw new \Exception(static::NO_HOST);
        }
        $host = $this->getUrlParsed()["host"];
        $domainAndTopLevelDomain = explode(".",$host);
        if ($domainAndTopLevelDomain[count($domainAndTopLevelDomain)-1] == "") {
            throw new \Exception(static::NO_TLD);
        } else {
            $tld = $domainAndTopLevelDomain[count($domainAndTopLevelDomain)-1];
        }
        return $tld;
    }

    /**
     * Returns the Protocol.
     * @return string
     */
    public function getProtocol()
    {
        if (!array_key_exists ( "scheme" , $this->getUrlParsed())) {
            throw new \Exception(static::NO_PROTOCOL);
        }
        else if ($this->getUrlParsed()["scheme"] != "") {
            $protocol = $this->getUrlParsed()["scheme"];
        } else {
            throw new \Exception(static::NO_PROTOCOL);
        }
        return $protocol;
    }

    /**
     * Returns the Path.
     * @return string
     */
    public function getPath()
    {
        return $this->getUrlParsed()["path"] ?? "";
    }

    /**
     * Returns the Query.
     * @return string
     */
    public function getQuery()
    {
        return $this->getUrlParsed()["query"] ?? "";
    }

    /**
     * Returns the Fragment.
     * @return string
     */
    public function getFragment()
    {
        return $this->getUrlParsed()["fragment"] ?? "";
    }
}
