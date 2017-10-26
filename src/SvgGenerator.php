<?php

namespace SvgGenerator;

use Twig_Environment;
use Twig_Loader_Filesystem;

class SvgGenerator
{
    /**
     * ###################################################CONFIG#################################################
     */
    private $templateFolder = '../templates';
    private $templateName = 'template.html.twig';
    private $outputFileMainPartName = 'wynik';
    private $outputSvgFolder = 'svg';
    private $outputPdfFolder = 'pdf';
    private $parametersToChange = [
        [
            'MTASTKRB',
            'ASTKMPMT',
            'TKMTRBBB',
            'POMWRBMP',
            'MPKWMTTK',
            'DSDPKGMS',
            'BBGGMSRB',
            'NZTKGGBB',
            'POGPMBAS',
            'MTMWKWKG',
            'DPKGAOMW',
            'MWGPJKMW',
            'MBPOGGTK',
            'DSKGKWAS',
            'GGPOMBAO',
            'GPAOPOJK',
            'JKTKGPPO',
            'JKGPAOKW',
            'GGMBPOMW',
            'GPMSKWAO',
            'MBRBMTTK',
            'GGRBTKKW',
            'MWPOMTAS',
            'MSMWAODS',
            'POGGBBKG',
            'MWPODSDP',
            'DPKWBBGG',
            'MWKWJKGP',
            'GPJKMWKW',
        ]
    ];

    /**
     * ############################################END#OF#CONFIG#################################################
     */
    private $listOfRandomNumbers = [];
    private $listOfConvertedFilesNames = [];

    public function run(bool $convertToPdf = false)
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/' . $this->templateFolder);
        $twig = new Twig_Environment($loader);

        foreach (range(0, $this->getMaxNumberOfParametersInGroups() - 1) as $rowNumber) {
            $parameters = $this->getParametersArrayForTwig($rowNumber);
            $code = $twig->render($this->templateName, $parameters);
            $fileName = $this->outputFileMainPartName . date('Y-m-d_H:i:s') . '_' . $this->getUniqueRandomNumber();
            $path = __DIR__ . '/../' . $this->outputSvgFolder . '/' . $fileName . '.svg';
            file_put_contents($path, $code);
            array_push($this->listOfConvertedFilesNames, $fileName);
        }
        if ($convertToPdf) {
            foreach ($this->listOfConvertedFilesNames as $fileName) {
                exec('rsvg-convert -f pdf -o ' . $this->outputPdfFolder . '/' . $fileName . '.pdf ' . $this->outputSvgFolder . '/' . $fileName . '.svg');
            }
        }

    }

    private function getMaxNumberOfParametersInGroups()
    {
        $maxNumberOfParameters = 0;
        foreach ($this->parametersToChange as $parametersGroup) {
            $count = count($parametersGroup);
            if ($count > $maxNumberOfParameters) {
                $maxNumberOfParameters = $count;
            }
        }
        return $maxNumberOfParameters;
    }

    private function getParametersArrayForTwig($nrOfRow)
    {
        $parametersToChange = $this->parametersToChange;
        $outputArray = [];
        foreach ($parametersToChange as $parametersGroupNumber => $parametersGroup) {
            if (isset($parametersGroup[$nrOfRow])) {
                $outputArray['parameter' . ($parametersGroupNumber + 1)] = $parametersGroup[$nrOfRow];
            } else {
                $outputArray['parameter' . ($parametersGroupNumber + 1)] = '';
            }
        }
        return $outputArray;
    }

    private function getUniqueRandomNumber()
    {
        $randNumber = rand(0, PHP_INT_MAX);
        if (in_array($randNumber, $this->listOfRandomNumbers)) {
            $randNumber = $this->getUniqueRandomNumber();
        }
        array_push($this->listOfRandomNumbers, $randNumber);

        return $randNumber;
    }
}