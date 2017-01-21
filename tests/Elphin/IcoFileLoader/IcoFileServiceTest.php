<?php
namespace Elphin\IcoFileLoader;

class IcoFileServiceTest extends IcoTestCase
{
    public function testExtract()
    {
        $service = new IcoFileService;
        $im = $service->extractIcon('./tests/assets/32bit-16px-32px-sample.ico', 64, 64);
        $this->assertImageLooksLike('32bit-64px-resize-expected.png', $im);
    }

    public function testFromWithData()
    {
        $service = new IcoFileService;
        $data = file_get_contents('./tests/assets/32bit-16px-32px-sample.ico');
        $icon = $service->from($data);
        $this->assertNotNull($icon);

        $icon = $service->fromString($data);
        $this->assertNotNull($icon);
    }

    public function testFromWithFile()
    {
        $service = new IcoFileService;
        $icon = $service->from('./tests/assets/32bit-16px-32px-sample.ico');
        $this->assertNotNull($icon);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidFrom()
    {
        $service = new IcoFileService;
        $service->from("not an icon");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidFromString()
    {
        $service = new IcoFileService;
        $service->fromString("not an icon");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidFromFile()
    {
        $service = new IcoFileService;
        $service->fromFile("not a file");
    }
}
