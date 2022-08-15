<?php

namespace Elphin\IcoFileLoader;

interface ParserInterface
{
    /**
     * Returns true if string is more likely to be binary ico data rather than a filename
     */
    public function isSupportedBinaryString(string $data): bool;

    /**
     * @param string $data binary string containing an icon
     */
    public function parse(string $data): Icon;
}
