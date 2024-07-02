<?php

return [
    "hcaptcha" => [
        "secret" => env("HCAPTCHA_SECRET", "0x0000000000000000000000000000000000000000"),
        "site_key" => env("HCAPTCHA_SITE_KEY", "10000000-ffff-ffff-ffff-000000000001")
    ]
];