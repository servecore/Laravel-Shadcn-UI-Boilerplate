<?php

use App\Support\ToastFactory;

if (! function_exists('toast')) {
    function toast(): ToastFactory
    {
        return app(ToastFactory::class);
    }
}
