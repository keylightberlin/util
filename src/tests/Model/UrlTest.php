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
    /**
     * @var Url
     */
    private $noSubDomainUrl;
    /**
     * @var Url
     */
    private $noPathUrl;

    public function setUp()
    {
        $this->url = new Url("http://sdTwo.sdOne.sdZero.domain.tld/path/subpath/file=bla?muh#fragment");
        $this->noSubDomainUrl = new Url("http://google.de/dump");
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
    }

    public function testGetAllSubDomainsAsString()
    {
        $allSubDomainsString = "sdTwo.sdOne.sdZero";
        $emptyString = "";

        $resultOne = $this->url->getAllSubDomainsAsString();
        $resultTwo = $this->noSubDomainUrl->getAllSubDomainsAsString();

        $this->assertEquals($allSubDomainsString, $resultOne);
        $this->assertEquals($emptyString, $resultTwo);
    }

    public function testGetAllSubDomainsAsArray()
    {
        $allSubDomainsArray = [
            "sdTwo",
            "sdOne",
            "sdZero",
        ];
        $emptyArray = [];

        $resultOne = $this->url->getAllSubDomainsAsArray();
        $resultTwo = $this->noSubDomainUrl->getAllSubDomainsAsArray();

        $this->assertEquals($allSubDomainsArray, $resultOne);
        $this->assertEquals($emptyArray, $resultTwo);
    }

    public function testGetNumberOfSubdomains()
    {
        $numberOfSubDomains = 3;

        $resultOne = $this->url->getNumberOfSubdomains();
        $resultTwo = $this->noSubDomainUrl->getNumberOfSubdomains();

        $this->assertEquals($numberOfSubDomains, $resultOne);
        $this->assertEquals(0, $resultTwo);
    }

    public function testGetDomain()
    {
        $domain = "domain";

        $result = $this->url->getDomain();

        $this->assertEquals($domain, $result);

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

    public function testCheckUrlIsValid()
    {
        $this->expectException(\Exception::class);
        new Url("http:///path/bla");
        $this->expectException(\Exception::class);
        new Url("www.google.de");
        $this->expectException(\Exception::class);
        new Url("http://de");
    }
}
