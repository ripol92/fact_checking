<?php


namespace App\FactChecking\Helpers;

class JSONToHtmlTable {
    /**
     * @param Object $data
     * @return string
     */
    public function jsonToTable($data) {
        $table = '
    <table class="json-table" width="100%">
    ';
        foreach ($data as $key => $value) {
            $table .= '
        <tr valign="top">
        ';
            if ( ! is_numeric($key)) {
                $table .= '
            <td style="border: 1px solid #ddd !important;">
                <strong>'. $key .':</strong>
            </td>
            <td style="border: 1px solid #ddd !important;">
            ';
            } else {
                $table .= '
            <td colspan="2">
            ';
            }
            if (is_object($value) || is_array($value)) {
                $table .= $this->jsonToTable($value);
            } else {
                $table .= $value;
            }
            $table .= '
            </td>
        </tr>
        ';
        }
        $table .= '
    </table>
    ';
        return $table;
    }
}
