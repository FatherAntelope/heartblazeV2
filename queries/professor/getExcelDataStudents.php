<?php
function getColID($colNumber) {
    $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $symbol = null;
    if($colNumber > 26) {
        $symbol = "A". $alphabet[$colNumber - 25 - 2];
    } else {
        $symbol = $alphabet[$colNumber - 1];
    }
    return $symbol;
}

require $_SERVER['DOCUMENT_ROOT'] . "/frameworks/PHPExcel.php";
require $_SERVER['DOCUMENT_ROOT'] . "/db/db.php";


$group_id = 7;

$lessons = R::findAll('lesson', 'id_group = ? AND checked = 1 ORDER BY date ASC', [$group_id]);
$students = R::findAll('student', ' id_group = ? ', [$group_id]);

foreach ($students as $student) {
    $students_id[] = $student->id;
}

$lessonsParticipation = R::findLike('lesson_participation', ['id_student' => $students_id]);

$XLS = new PHPExcel();

$XLS->setActiveSheetIndex(0);
$sheetVisitsStudents = $XLS->getActiveSheet();
$sheetVisitsStudents->setTitle("Посещения студентов");

$sheetVisitsStudents->setCellValue("A1", "ФИО");
$sheetVisitsStudents->setCellValue("B1", "Группа");

$colNumber = 3;
foreach ($lessons as $lesson) {
    $sheetVisitsStudents->setCellValue(getColID($colNumber)."1",  date("d.m.Y", strtotime($lesson->date)));
    $colNumber++;
}


$sheetVisitsStudents->getStyle("C1:".getColID($colNumber)."1")->getAlignment()->setTextRotation(90);
$sheetVisitsStudents->getColumnDimension("A")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("B")->setAutoSize(true);

$colNumber = 3;
$rowNumber = 2;
foreach ($students as $student) {
    $personStudent = R::load('person', $student->id_person);
    $fullName = $personStudent->surname . " " . substr($personStudent->name, 0, 2) . ". " . substr($personStudent->patronymic, 0, 2).".";
    $sheetVisitsStudents->setCellValue("A".$rowNumber, $fullName);
    $sheetVisitsStudents->setCellValue("B".$rowNumber, $student->group_study);
    foreach ($lessons as $lesson) {
        $studentVisit = R::findOne('lesson_participation', 'id_lesson = ? AND id_student = ?', [$lesson->id, $student->id]);
        if($studentVisit->status == 1) {
            $sheetVisitsStudents->setCellValue(getColID($colNumber)."".$rowNumber, "+");
        } elseif ($studentVisit->status == 3) {
            $sheetVisitsStudents->setCellValue(getColID($colNumber)."".$rowNumber, "-");
        } else {
            $sheetVisitsStudents->setCellValue(getColID($colNumber)."".$rowNumber, "Н");
        }
        $colNumber++;
    }
    $rowNumber++;
}
$rowNumber--;
$colNumber--;

$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);

$sheetVisitsStudents->getStyle("A1:".getColID($colNumber)."".$rowNumber)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheetVisitsStudents->getStyle("A1:".getColID($colNumber)."".$rowNumber)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheetVisitsStudents->getStyle("A1:".getColID($colNumber)."".$rowNumber)->applyFromArray($styleArray);

//////////////////////////////////////////////////////////////
$sheetVisitsStudents = $XLS->createSheet(1);
$sheetVisitsStudents->setTitle("Данные студентов");
$sheetVisitsStudents->setCellValue("A1", "Дата");
$sheetVisitsStudents->setCellValue("B1", "ФИО");
$sheetVisitsStudents->setCellValue("C1", "Группа");
$sheetVisitsStudents->setCellValue("D1", "Дистанция");
$sheetVisitsStudents->setCellValue("E1", "Время общее");
$sheetVisitsStudents->setCellValue("F1", "Время основное");
$sheetVisitsStudents->setCellValue("G1", "Время разминки");
$sheetVisitsStudents->setCellValue("H1", "Время заминки");
$sheetVisitsStudents->setCellValue("I1", "Пульс до разминки");
$sheetVisitsStudents->setCellValue("J1", "Пульс после разминки");
$sheetVisitsStudents->setCellValue("K1", "Пульс после основной");
$sheetVisitsStudents->setCellValue("L1", "Пульс после заминки");
$sheetVisitsStudents->setCellValue("M1", "Пульс ч/з 10 мин.");
$sheetVisitsStudents->setCellValue("N1", "Трекер");

$rowNumber = 2;
foreach ($lessonsParticipation as $lessonParticipation) {
    if ($lessonParticipation->status == 1) {
        $personStudent = R::load('person', $students[$lessonParticipation->id_student]->id_person);
        $sheetVisitsStudents->setCellValue("A".$rowNumber, date("d.m.Y", strtotime($lessons[$lessonParticipation->id_lesson]->date)));
        $sheetVisitsStudents->setCellValue("B".$rowNumber, $personStudent->surname . " " . substr($personStudent->name, 0, 2) . ". " . substr($personStudent->patronymic, 0, 2).".");
        $sheetVisitsStudents->setCellValue("C".$rowNumber, $students[$lessonParticipation->id_student]->group_study);
        $sheetVisitsStudents->setCellValue("D".$rowNumber, $lessonParticipation->distance);
        $sheetVisitsStudents->setCellValue("E".$rowNumber, $lessonParticipation->time_overall);
        $sheetVisitsStudents->setCellValue("F".$rowNumber, $lessonParticipation->time_main);
        $sheetVisitsStudents->setCellValue("G".$rowNumber, $lessonParticipation->time_warmup);
        $sheetVisitsStudents->setCellValue("H".$rowNumber, $lessonParticipation->time_final);
        $sheetVisitsStudents->setCellValue("I".$rowNumber, $lessonParticipation->pulse_before_warmup);
        $sheetVisitsStudents->setCellValue("J".$rowNumber, $lessonParticipation->pulse_after_warmup);
        $sheetVisitsStudents->setCellValue("K".$rowNumber, $lessonParticipation->pulse_after_main);
        $sheetVisitsStudents->setCellValue("L".$rowNumber, $lessonParticipation->pulse_after_final);
        $sheetVisitsStudents->setCellValue("M".$rowNumber, $lessonParticipation->pulse_after_rest);
        $sheetVisitsStudents->setCellValue("N".$rowNumber, $lessonParticipation->tracker_link);

    }
}
$sheetVisitsStudents->getColumnDimension("A")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("B")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("C")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("D")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("E")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("F")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("G")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("H")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("I")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("J")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("K")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("L")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("M")->setAutoSize(true);
$sheetVisitsStudents->getColumnDimension("N")->setAutoSize(true);

$sheetVisitsStudents->getStyle("A1:N".$rowNumber)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheetVisitsStudents->getStyle("A1:N".$rowNumber)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheetVisitsStudents->getStyle("A1:N".$rowNumber)->applyFromArray($styleArray);


$objWriterXLS = new PHPExcel_Writer_Excel5($XLS);
$objWriterXLS->save("dataes.xls");

?>