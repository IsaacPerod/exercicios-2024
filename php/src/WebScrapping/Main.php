<?php

namespace Chuva\Php\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

/**
 * Runner for the Webscrapping exercice.
 */
class Main {

/**
* Main runner, instantiates a Scrapper and runs.
*/
public static function run() {
    // Crie um novo objeto Scrapper
    $scrapper = new Scrapper();

    // Carrega o HTML do arquivo origin.html
    $dom = new \DOMDocument('1.0', 'utf-8');

    // Desativa os erros libxml e permite que o usuário os recupere como necessário
    libxml_use_internal_errors(true);

    $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

    // Limpa os erros
    libxml_clear_errors();

    // Extrai os dados dos papers do HTML
    $data = $scrapper->scrap($dom);

    // Cria um novo escritor Excel
    $writer = WriterEntityFactory::createXLSXWriter();

    // Abre o arquivo Excel para escrita
    $writer->openToFile('Trabalhos.xlsx');

    // Adiciona os títulos às colunas da planilha
    $titleRow = ['ID', 'Title', 'Type'];

    // Determina o número máximo de autores
    $maxAuthors = 0;
    foreach ($data as $paper) {
        $numAuthors = count($paper->getAuthors());
        if ($numAuthors > $maxAuthors) {
            $maxAuthors = $numAuthors;
        }
    }

    // Adiciona títulos para cada autor e instituição
    for ($i = 1; $i <= $maxAuthors; $i++) {
        array_push($titleRow, "Author $i", "Author $i Institution");
    }
    $writerTitleRow = WriterEntityFactory::createRowFromArray($titleRow);
    $writer->addRow($writerTitleRow);

    // Escreve os dados no arquivo Excel
    foreach ($data as $paper) {
        $row = [$paper->getId(), $paper->getTitle(), $paper->getType()];

        // Adiciona os autores e instituições à linha
        $authors = $paper->getAuthors();
        for ($i = 0; $i < $maxAuthors; $i++) {
            if (isset($authors[$i])) {
                $author = $authors[$i];
                array_push($row, $author->getName(), $author->getInstitution());
            } else {
                // Se não houver autor para este índice, adiciona valores vazios
                array_push($row, '', '');
            }
        }

        // Adiciona uma nova linha ao arquivo Excel
        $writerRow = WriterEntityFactory::createRowFromArray($row);
        $writer->addRow($writerRow);
    }

    // Fecha o arquivo Excel
    $writer->close();
    
    echo "Excel file created successfully\n";
  }
}
