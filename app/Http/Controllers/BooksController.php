<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Maatwebsite\Excel\Facades\Excel;

class BooksController extends Controller
{
    public function index()
    {
        return view('books.index');
    }

    public function booksListPhpExcel()
    {
        $fileType = \PHPExcel_IOFactory::identify(resource_path('excels/books_template.xlsx')); // đọc loại file template
        $objReader = \PHPExcel_IOFactory::createReader($fileType);
        $objPHPExcel = $objReader->load(resource_path('excels/books_template.xlsx')); //load dữ liệu từ file excel luu vao bien $objPHPExcel

        $bookData = Book::select()->get(); //đọc dữ liệu từ database

        $this->addDataToExcelFile($objPHPExcel->setActiveSheetIndex(0), $bookData); //chay ham them du lieu vao excel

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); //Ham tao moi file excel

        //Kiem tra thu muc co ton tai khong, neu khong co thi tao moi

        if (!is_dir(public_path('excel'))) {
            mkdir(public_path('excel'));
        }

        if (!is_dir(public_path('excel/import'))) {
            mkdir(public_path('excel/import'));
        }
        //-----------------------------------------------------------

        $path = 'excel/import/' . time() . 'import.xlsx'; //dat ten cho file excel

        $objWriter->save(public_path($path)); //luu file excel vao thu muc

        return redirect($path); //tra file excel ve cho nguoi dung
    }

    private function addDataToExcelFile ($setCell, $bookData) //HAM THEM DU LIEU VAO FILE EXCEL
    {
        $setCell->setCellValue('D7', 'Đào Hải Long');   //them doan text Dao Hai Long vao o D7

        $index = 1;

        $row = 12;  //danh dau dong bat dau them data, su dung trong vong lap foreach

        foreach ($bookData as $key => $item) {

            $setCell
                ->setCellValue('B' . $row, $index)  //them du lieu vao cot B
                ->setCellValue('C' . $row, $item->name)
                ->setCellValue('E' . $row, $item->author)
                ->setCellValue('F' . $row, $item->quantity)
                ->setCellValue('G' . $row, $item->price)
                ->setCellValue('H' . $row, '=F' . $row . '*G' . $row); //them dong text vao cot H, su dung ham tinh toan mac dinh trong excel de tinh gia tri

            $index++;

            $row++;
        }

        //them duong vien cho du lieu trong file excel

        $setCell->getStyle("B12:H" . ($index+10) )->applyFromArray(array(
            'borders' => array(
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                    'size' => 1,
                ),
                'inside' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                    'size' => 1,
                ),
            ),
        ));
        //------------------------------------------------------------------

        return $this;
    }

    public function booksListLaravelExcel()
    {
        $books = Book::all();

        $fileName = 'bookList'.time();

        Excel::create($fileName, function($excel) use ($books){ // su dung use($books) moi co the truyen gia tri bien $books tu ben ngoai vao ham
            $excel->sheet('Thong ke sach trong kho', function ($sheet) use ($books) {
                $sheet->mergeCells('A1:I1');

                $sheet->cell('A1', function ($cell) {
                    $cell->setValue('ABC Company Thống kê sách trong kho');

                    $cell->setFontWeight('bold');
                });

                $result = $this->getDataToLaravelExcel($books); //Goi den ham getDataToLaravelExcel de tạo mang du lieu can in ra Excel

                $sheet->fromArray($result, null, 'A3', false, false);
            });
        })->store('xlsx', public_path('/excel/import'));

        $path = 'excel/import/' . $fileName . '.xlsx';

        return redirect(url('/' . $path));
    }

    private function getDataToLaravelExcel($books)
    {
        $result = [];

        foreach ($books as $key => $value) {
            $result[] = [
                'STT' => $key + 1,
                'Tên sách' => isset($value->name) ? $value->name : '',
                'Tác giả' => isset($value->author) ? $value->author : '',
                'Số lượng' => isset($value->quantity) ? $value->quantity : '',
                'Đơn giá' => isset($value->price) ? number_format($value->price) : '',
                'Tổng' => (isset($value->quantity) && isset($value->price)) ? number_format($value->quantity * $value->price) : 0
            ];
        }
        return $result;
    }
}
