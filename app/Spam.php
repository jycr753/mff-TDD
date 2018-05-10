<?php

namespace App;

use Exception;

class Spam
{
    public function detect($body)
    {
        $this->detectInvalidKeyWords($body);

        return false;
    }

    protected function detectInvalidKeyWords($body)
    {
        $invalidKeyWords = [
            'yahoo customer support'
        ];

        foreach ($invalidKeyWords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contians spam');
            }
        }
    }
}