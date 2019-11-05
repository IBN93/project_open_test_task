<?php
    require_once(__DIR__ . '/vendor/autoload.php');

    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    if ($ext != 'xlsx') {
        echo('Расширение файла отлично от xlsx.');
        exit;
    }

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['file']['tmp_name']);
    
    $sheet_names = $spreadsheet->getSheetNames();
    $first_sheet_max_column = $spreadsheet->getSheet(0)->getHighestColumn();
    $second_sheet_max_column = $spreadsheet->getSheet(1)->getHighestColumn();
 
//  Проверяем наличие листов с правильно введёнными названиями и количество столбцов в них
    if ($sheet_names[0] == 'first' && $sheet_names[1] == 'second') {
        if ($first_sheet_max_column == 'C' && $second_sheet_max_column == 'B') {
            $first_sheet = $spreadsheet->getSheet(0);
            $number_of_rows = $first_sheet->getHighestRow();
            $clients = [];
            $row = 1;
//  Собираем информацию о клиентах с первого листа в массив
            while ($row <= $number_of_rows) {
                $id = $first_sheet->getCell('A' . $row)->getValue();
                $name = $first_sheet->getCell('B' . $row)->getValue();
                $balance = $first_sheet->getCell('C' . $row)->getValue();
                $clients["$id"] = [
                    "name" => $name,
                    "balance" => $balance
                ];
                $row++;
            }
//  Читаем второй лист, изменяя информацию о клиентах
            $second_sheet = $spreadsheet->getSheet(1);
            $number_of_rows = $second_sheet->getHighestRow();
            $row = 1;
            while ($row <= $number_of_rows) {
                $id = $second_sheet->getCell('A' . $row)->getValue();
                $balance_change = $second_sheet->getCell('B' . $row)->getValue();
                $clients["$id"]["balance"] += $balance_change; 
                $row++;
            }
//  Формируем таблицу с текущими остатками
            $table = "<table>
                        <tr>
                            <th>ID клиента</th>
                            <th>ФИО клиента</th>
                            <th>Текущий остаток</th>
                        </tr>";            
            foreach ($clients as $id => $client) {
                $table .= "<tr>
                                <td>$id</td>
                                <td>{$client['name']}</td>
                                <td>{$client['balance']} руб.</td>
                            </tr>";
            }
            $table .= "</table>";
            echo $table;
        } else {
            echo "Проверьте количество полей (3 (id, ФИО, начальный остаток)) на первом, 2 (id, ввод/вывод) на втором)";
        }
    } else {
        echo "Проверьте названия первых двух листов!";
    }
