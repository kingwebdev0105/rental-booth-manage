<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Export to CSV
// 
// This method generates a csv file and then returns the generated content

if (!function_exists('arrayToCSV')) {
    function arrayToCSV($query, $fields, $filename = "CSV")
    {
        if (count($query) == 0) {
            return "The query is empty. It doesn't have any data.";
        } else {
            $headers = rowCSV($fields);

            $data = "";
            foreach ($query as $row) {
                $line = rowCSV($row);
                $data .= trim($line) . "\n";
            }
            $data = str_replace("\r", "", $data);

            $content = $headers . $data;
            $filename = date('YmdHis') . "_export_{$filename}.csv";
       
            header('Content-Encoding: UTF-8');
            header("Content-Description: File Transfer");
            header("Content-type: application/csv; charset=UTF-8");
            header("Content-Disposition: attachment; filename={$filename}");
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Cache-Control: must-revalidate");
            header("Pragma: public");
            header("Content-Length: " . strlen($content));

            echo "\xEF\xBB\xBF";

            return $content;
        }
    }
}

if (!function_exists('rowCSV')) {
    function rowCSV($fields)
    {
        $output = '';
        $separator = '';
        foreach ($fields as $field) {
            if (preg_match('/\\r|\\n|,|"/', $field)) {
                $field = '"' . str_replace('"', '""', $field) . '"';
            }
            $output .= $separator . $field;
            $separator = ',';
        }
        return $output . "\r\n";
    }
}