<?php

namespace Ast\MwbExporterExtra;

use Ast\MwbExporterExtra\Bootstrap;
use \MwbExporter\Formatter\Doctrine2\Annotation\Formatter;

class Exporter
{
    /**
     * @param $filemwb
     * @param $outDir
     * @param string $namespace
     * @param bool $info
     * @return bool|string
     */
    public static function symfony4($filemwb, $outDir, $namespace = 'App',$info = false)
    {
        $setup = array(
            Formatter::CFG_USE_LOGGED_STORAGE => $info,
            Formatter::CFG_INDENTATION => 4,
            Formatter::CFG_FILENAME => '%entity%.%extension%',
            Formatter::CFG_ANNOTATION_PREFIX => 'ORM\\',
            Formatter::CFG_BUNDLE_NAMESPACE => $namespace,
            Formatter::CFG_ENTITY_NAMESPACE => 'Entity',
            Formatter::CFG_REPOSITORY_NAMESPACE => '',
            Formatter::CFG_AUTOMATIC_REPOSITORY => false,
            Formatter::CFG_SKIP_GETTER_SETTER => false,
        );
        $start = microtime(true);
        $outputType = 'file';
        $bootstrap = new Bootstrap();
        $formatter = $bootstrap->getFormatter('doctrine2-annotationsf4');
        if ($info) {
            $logFile = $outDir . '/log.txt';
            $formatter->setup(array_merge(array(\MwbExporter\Formatter\Formatter::CFG_LOG_FILE => $logFile), $setup));
        } else {
            $formatter->setup($setup);
        }

        $document = $bootstrap->export($formatter, $filemwb, $outDir, $outputType);
        $end = microtime(true);

        if ($info) {
            if ($document) {
                $back = sprintf("<h1>%s</h1>\n", $document->getFormatter()->getTitle());

                // show some information
                $back .= "<h2>Information:</h2>\n";
                $back .= "<ul>\n";
                $back .= sprintf("<li>Filename: %s</li>\n",
                    basename($document->getWriter()->getStorage()->getResult()));
                $back .= sprintf("<li>Memory usage: %0.3f MB</li>\n", (memory_get_peak_usage(true) / 1024 / 1024));
                $back .= sprintf("<li>Time: %0.3f second(s)</li>\n", ($end - $start));
                $back .= "</ul>\n";

                // show a simple text box with the output
                $back .= "<h2>Result:</h2>\n";
                $back .= "<textarea cols=\"100\" rows=\"50\">\n";
                $back .= $document->getWriter()->getStorage()->getLogs() . "\n";
                $back .= "</textarea>\n";
            } else {
                $back = "<p>Export not performed, please review your code.</p>\n";
            }

            return $back;
        } else {
            return !empty($document);
        }
    }

    /**
     * @param $filemwb
     * @param $outDir
     * @param bool $info
     * @return bool|string
     */
    public static function symfony3($filemwb, $outDir, $namespace = 'AppBundle', $info = false)
    {
        $setup = array(
            Formatter::CFG_USE_LOGGED_STORAGE => $info,
            Formatter::CFG_INDENTATION => 4,
            Formatter::CFG_FILENAME => '%entity%.%extension%',
            Formatter::CFG_ANNOTATION_PREFIX => 'ORM\\',
            Formatter::CFG_BUNDLE_NAMESPACE => 'AppBundle',
            Formatter::CFG_ENTITY_NAMESPACE => $namespace,
            Formatter::CFG_REPOSITORY_NAMESPACE => '',
            Formatter::CFG_AUTOMATIC_REPOSITORY => false,
            Formatter::CFG_SKIP_GETTER_SETTER => false,
        );
        $start = microtime(true);
        $outputType = 'file';
        $bootstrap = new Bootstrap();
        $formatter = $bootstrap->getFormatter('doctrine2-annotationsf3');
        if ($info) {
            $logFile = $outDir . '/log.txt';
            $formatter->setup(array_merge(array(\MwbExporter\Formatter\Formatter::CFG_LOG_FILE => $logFile), $setup));
        } else {
            $formatter->setup($setup);
        }

        $document = $bootstrap->export($formatter, $filemwb, $outDir, $outputType);
        $end = microtime(true);

        if ($info) {
            if ($document) {
                $back = sprintf("<h1>%s</h1>\n", $document->getFormatter()->getTitle());

                // show some information
                $back .= "<h2>Information:</h2>\n";
                $back .= "<ul>\n";
                $back .= sprintf("<li>Filename: %s</li>\n",
                    basename($document->getWriter()->getStorage()->getResult()));
                $back .= sprintf("<li>Memory usage: %0.3f MB</li>\n", (memory_get_peak_usage(true) / 1024 / 1024));
                $back .= sprintf("<li>Time: %0.3f second(s)</li>\n", ($end - $start));
                $back .= "</ul>\n";

                // show a simple text box with the output
                $back .= "<h2>Result:</h2>\n";
                $back .= "<textarea cols=\"100\" rows=\"50\">\n";
                $back .= $document->getWriter()->getStorage()->getLogs() . "\n";
                $back .= "</textarea>\n";
            } else {
                $back = "<p>Export not performed, please review your code.</p>\n";
            }

            return $back;
        } else {
            return !empty($document);
        }
    }
}

