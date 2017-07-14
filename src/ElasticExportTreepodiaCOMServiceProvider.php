<?php

namespace ElasticExportTreepodiaCOM;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\DataExchangeServiceProvider;

class ElasticExportTreepodiaCOMServiceProvider extends DataExchangeServiceProvider
{
    public function register()
    {

    }

    public function exports(ExportPresetContainer $container)
    {
        $container->add(
            'TreepodiaCOM-Plugin',
            'ElasticExportTreepodiaCOM\ResultField\TreepodiaCOM',
            'ElasticExportTreepodiaCOM\Generator\TreepodiaCOM',
            '',
            true,
			true
        );
    }
}