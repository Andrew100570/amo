<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\File\FileImportRequest;

class FileController extends Controller
{

    public function showFile() {
        return view('file',['data' => '','color' => 'red']);
    }

    public function upload(FileImportRequest $request) {

        $file = $request->file('file');
        $content = file_get_contents($file->getRealPath());

        // Разбиваем содержимое файла по определенному символу (например, переводу строки)
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            $data[] = preg_match_all('/\d/', $line, $matches);
            //$data[] = iconv_strlen($line); - вариант без регулярного выражения
        }

        Storage::disk('local')->put('files/data.txt', implode(PHP_EOL, $data));

        if (Storage::exists('/files/data.txt')) {
            return view('file',['data' => $data,'color' => 'green']);
        } else {
            return view('file',['data' => ['Cохранить файл не удалось'],'color' => 'red']);
        }

    }
}
