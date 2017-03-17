<?php

namespace tests\Model;

use KeylightUtilBundle\Model\Url\Url;
use PHPUnit\Framework\TestCase;


class UrlTest extends TestCase
{
    /**
     * @var Url
     */
    private $url;
    private $noDomainUrl;
    private $noProtocolUrl;
    private $noPathUrl;

    public function setUp()
    {
        $urlstring = "http://sdTwo.sdOne.sdZero.domain.tld/path/subpath/file=bla?muh#fragment";
        $this->url = new Url($urlstring);
        $this->noDomainUrl = new Url("http://.de/dump");
        $this->noProtocolUrl = new Url("www.google.de");
        $this->noPathUrl = new Url("http://sdTwo.sdOne.sdZero.domain.tld");
    }

    public function testGetSubdomain()
    {
        $sdOne = "sdOne";
        $sdZero = "sdZero";

        $resultZero = $this->url->getSubDomain(0);
        $resultOne = $this->url->getSubDomain(1);
        $resultDefault = $this->url->getSubDomain();

        $this->assertEquals($sdZero, $resultZero);
        $this->assertEquals($sdOne, $resultOne);
        $this->assertEquals($sdZero, $resultDefault);
        $this->expectException(\Exception::class);
        $this->url->getSubDomain(5);
    }

    public function testGetDomain()
    {
        $domain = "domain";

        $result = $this->url->getDomain();

        $this->assertEquals($domain, $result);
        $this->expectException(\Exception::class);
        $this->noDomainUrl->getDomain();
    }

    public function testGetTopLevelDomain()
    {
        $tld = "tld";

        $result = $this->url->getTopLevelDomain();

        $this->assertEquals($tld, $result);
    }

    public function testGetProtocol()
    {
        $protocol = "http";

        $result = $this->url->getProtocol();

        $this->assertEquals($protocol, $result);
        $this->expectException(\Exception::class);
        $this->noProtocolUrl->getProtocol();
    }

    public function testGetPath()
    {
        $path = "/path/subpath/file=bla";

        $result = $this->url->getPath();

        $this->assertEquals($path, $result);

        $this->assertEquals("",$this->noPathUrl->getPath());
    }

    public function testGetQuery()
    {
        $query = "muh";

        $result = $this->url->getQuery();

        $this->assertEquals($query, $result);

        $this->assertEquals("",$this->noPathUrl->getQuery());
    }

    public function  testGetFragment()
    {
        $fragment = "fragment";

        $result = $this->url->getFragment();

        $this->assertEquals($fragment,$result);

        $this->assertEquals("",$this->noPathUrl->getFragment());
    }
}
