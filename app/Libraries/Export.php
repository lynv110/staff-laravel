<?php
namespace App\Libraries;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Export {

    public function export($data = []) {
        $title = isset($data['title']) ? $data['title'] : 'WDS-DEV';
        $subject = isset($data['subject']) ? $data['subject'] : 'WDS-DEV';
        $description = isset($data['description']) ? $data['description'] : 'WDS-DEV';
        $fileName = isset($data['file_name']) ? $data['file_name'] : 'export';
        $columnInfo = isset($data['column']) ? $data['column'] : [];
        $info = isset($data['info']) ? $data['info'] : [];

        if ($columnInfo) {

            $spreadsheet = new Spreadsheet();  /*----Spreadsheet object-----*/
            //$Excel_writer = new Xls($spreadsheet);  /*----- Excel (Xls) Object*/

            $spreadsheet->getProperties()
                ->setCreator("WDS-DEV")
                ->setLastModifiedBy("WDS-DEV")
                ->setTitle($title)
                ->setSubject($subject)
                ->setDescription($description)
                ->setKeywords($description)
                ->setCategory($description);


            $spreadsheet->setActiveSheetIndex(0);
            $activeSheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

            foreach ($columnInfo as $column => $value) {
                $activeSheet->setCellValue(strtoupper($column) . '1', $value);
                $activeSheet->getStyle(strtoupper($column) . '1')->getFont()->setBold(true);
            }

            // Add some data
            $row = 2;
            foreach ($info as $key => $dataInfo) {
                foreach ($columnInfo as $column => $value) {
                    $activeSheet->setCellValue(strtoupper($column) . $row, $dataInfo[$column]);
                    $activeSheet->setCellValueExplicit('C'.$row, $dataInfo['c'],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                }

                $row++;
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }
    }
}