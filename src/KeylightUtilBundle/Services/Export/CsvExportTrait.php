<?php
namespace KeylightUtilBundle\Services\Export;

trait CsvExportTrait
{
    static $COLUMN_DELIMITER = "#";
    static $ROW_DELIMITER = "\n";

    /**
     * @param array $values
     * @return string
     */
    protected function getCsvLine(array $values)
    {
        $line = "";

        foreach ($values as $value) {
            $line .= $value . static::$COLUMN_DELIMITER;
        }

        return $line . static::$ROW_DELIMITER;
    }

}
