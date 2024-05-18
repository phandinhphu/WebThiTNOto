<?php
session_start();
require_once 'db/database.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_GET['download']) && $_GET['download'] == 'true') {
    if (!isset($_GET['testDate'])) {
        http_response_code(400);
        exit();
    }
    $testDate = $_GET['testDate'];
    $userId = $_SESSION['user']['id'];

    $spreadsheet = new Spreadsheet();

    $sheet1 = $spreadsheet->getActiveSheet();
    $sheet1->setTitle('Tổng quan bài thi');

    $sheet1->setCellValue('A1', 'Tên người thi')
           ->setCellValue('B1', 'Email')
           ->setCellValue('C1', 'Số điện thoại')
           ->setCellValue('D1', 'Tên bài thi')
           ->setCellValue('E1', 'Ngày thi')
           ->setCellValue('F1', 'Thời gian làm bài')
           ->setCellValue('G1', 'Thời gian nộp bài')
           ->setCellValue('H1', 'Tổng số câu hỏi')
           ->setCellValue('I1', 'Số câu trả lời đúng')
           ->setCellValue('J1', 'Số câu trả lời sai')
           ->setCellValue('K1', 'Số câu không trả lời')
           ->setCellValue('L1', 'Điểm số')
           ->setCellValue('M1', 'Kết quả');

    $results = getRow('SELECT userName, phone, email, result.examName, testDate, 
                        timeLimit, timeComplete, soCauHoi, soCauDung, soCauSai, soCauTrong, score, ketQua
                        FROM users, result, exam
                        WHERE users.id = result.userId AND result.examName = exam.examName
                        AND users.id = :userId AND testDate = :testDate', ['userId' => $userId, 'testDate' => $testDate]);

    $sheet1->setCellValue('A2', $results['userName'])
           ->setCellValue('B2', $results['email'])
           ->setCellValue('C2', $results['phone'])
           ->setCellValue('D2', $results['examName'])
           ->setCellValue('E2', $results['testDate'])
           ->setCellValue('F2', $results['timeLimit'] . ' phút')
           ->setCellValue('G2', $results['timeComplete'])
           ->setCellValue('H2', $results['soCauHoi'] . ' câu')
           ->setCellValue('I2', $results['soCauDung'] . ' câu')
           ->setCellValue('J2', $results['soCauSai'] . ' câu')
           ->setCellValue('K2', $results['soCauTrong'] . ' câu')
           ->setCellValue('L2', $results['score'] . ' điểm')
           ->setCellValue('M2', $results['ketQua']);

    $sheet2 = $spreadsheet->createSheet();
    $sheet2->setTitle('Chi tiết bài thi');

    $sheet2->setCellValue('A1', 'Câu hỏi')
           ->setCellValue('B1', 'Đáp án A')
           ->setCellValue('C1', 'Đáp án B')
           ->setCellValue('D1', 'Đáp án C')
           ->setCellValue('E1', 'Đáp án D')
           ->setCellValue('F1', 'Đáp án đúng')
           ->setCellValue('G1', 'Câu trả lời của bạn')
           ->setCellValue('H1', 'Kết quả');


    $questions = getRows('SELECT question, optionA, optionB, optionC, optionD, answerUser, answer, case when result = 0 then "Sai"
                            ELSE "Đúng"
                            END AS "kết quả" FROM history, questions
                            WHERE history.questionId = questions.id
                            AND dateAnswer = :dateAnswer', ['dateAnswer' => $testDate]);

    $row = 2;
    foreach ($questions as $question) {
        $sheet2->setCellValue('A' . $row, $question['question'])
               ->setCellValue('B' . $row, $question['optionA'])
               ->setCellValue('C' . $row, $question['optionB'])
               ->setCellValue('D' . $row, $question['optionC'])
               ->setCellValue('E' . $row, $question['optionD'])
               ->setCellValue('F' . $row, $question['answer'])
               ->setCellValue('G' . $row, $question['answerUser'])
               ->setCellValue('H' . $row, $question['kết quả']);
        ++$row;
    }

    $fileName = 'result_' . $results['examName'] . '_' . $results['testDate'] . '.xlsx';

    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
} else {
    http_response_code(404);
}