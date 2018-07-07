<?php

namespace CodeEduBook\Pub;

use CodeEduBook\Models\Livro;
use Illuminate\Http\UploadedFile;
use Imagine\Image\Box;

class BookCoverUpload {

    public function upload(Livro $livro, UploadedFile $file){
        \Storage::disk(config('codeedubook.book_storage'))
            ->putFileAs($livro->ebook_template, $file, $livro->cover_ebook_name);

        $this->makeCoverPdf($livro);
        $this->makeThumbnail($livro);

    }

    protected function makeCoverPdf(Livro $livro){

        if(!is_dir($livro->pdf_template_storage)){
            mkdir($livro->pdf_template_storage, 0775, true);
        }

        $img = new \Imagick($livro->cover_ebook_file);
        $img->setImageFormat('pdf');

        $img->writeImage($livro->cover_pdf_file);

    }

    protected function makeThumbnail(Livro $livro){

        if(!is_dir($livro->thumbs_storage)){
            mkdir($livro->thumbs_storage, 0775, true);
        }

        $coverEbookfile = $livro->cover_ebook_file;
        $thumbnail = \Image::open($coverEbookfile)->thumbnail(new Box(356,522));
        $thumbnail->save($livro->thumbnail_file);

        $thumbnailSmall = \Image::open($coverEbookfile)->thumbnail(new Box(138,230));
        $thumbnailSmall->save($livro->thumbnail_small_file);
    }
}