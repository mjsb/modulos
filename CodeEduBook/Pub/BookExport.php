<?php

namespace CodeEduBook\Pub;

use CodeEduBook\Criteria\FindByBook;
use CodeEduBook\Criteria\OrderByOrder;
use CodeEduBook\Models\Livro;
use CodeEduBook\Repositories\CapituloRepository;
use CodeEduBook\Util\ExtendedZip;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Parser;

class BookExport{


    /**
     * @var CapituloRepository
     */
    private $capituloRepository;
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var Dumper
     */
    private $dumper;

    /**
     * BookExport constructor.
     * @param CapituloRepository $capituloRepository
     */
    public function __construct (CapituloRepository $capituloRepository, Parser $parser, Dumper $dumper)
    {
        $this->capituloRepository = $capituloRepository;
        $this->parser = $parser;
        $this->dumper = $dumper;
    }

    public function export(Livro $livro){

        $capitulos = $this->capituloRepository->pushCriteria(new FindByBook($livro->id))
            ->pushCriteria(new OrderByOrder())
            ->all();

        $this->exportContents($livro, $capitulos);
        file_put_contents("{$livro->contents_storage}/dedication.md",$livro->dedication);
        $configContents = file_get_contents($livro->template_config_file);
        $config = $this->parser->parse($configContents);
        $config['book']['title'] = $livro->title;
        $config['book']['author'] = $livro->author->name;

        $contents = [];
        foreach ($capitulos as $capitulo){
            $contents[] = [
                'element' => 'chapter',
                'number' => $capitulo->order,
                'content' => "{$capitulo->order}.md"
            ];
        }
        $config['book']['contents'] = array_merge($config['book']['contents'],$contents);
        $yml = $this->dumper->dump($config,4);
        file_put_contents($livro->config_file, $yml);

    }

    public function compress(Livro $livro){
        ExtendedZip::zipTree($livro->output_storage, $livro->zip_file, ExtendedZip::CREATE);
    }

    protected function exportContents(Livro $livro, $capitulos){

        if(!is_dir($livro->contents_storage)){
            mkdir($livro->contents_storage, 0775, true);
        }

        foreach ($capitulos as $capitulo){
            file_put_contents("{$livro->contents_storage}/{$capitulo->order}.md",$capitulo->content);
        }
    }
}