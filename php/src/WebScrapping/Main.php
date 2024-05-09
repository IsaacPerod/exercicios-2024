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

    // Creates a new Scrapper object.
    $scrapper = new Scrapper();

    // Loads the HTML from the origin.html file.
    $dom = new \DOMDocument('1.0', 'utf-8');

    // Disables libxml errors.
    libxml_use_internal_errors(TRUE);

    $dom->loadHTMLFile(__DIR__ . '/../../assets/origin.html');

    // Cleans up the errors.
    libxml_clear_errors();

    // Extracts data from HTML papers.
    $data = $scrapper->scrap($dom);

    // Creates a new Excel writer.
    $writer = WriterEntityFactory::createXLSXWriter();

    // Opens the Excel file for writing.
    $writer->openToFile('Trabalhos.xlsx');

    // Add titles to the spreadsheet columns.
    $titleRow = ['ID', 'Title', 'Type'];

    // Determines the maximum number of authors.
    $maxAuthors = 0;
    foreach ($data as $paper) {
      $numAuthors = count($paper->getAuthors());
      if ($numAuthors > $maxAuthors) {
        $maxAuthors = $numAuthors;
      }
    }

    // Add titles for each author and institution.
    for ($i = 1; $i <= $maxAuthors; $i++) {
      array_push($titleRow, "Author $i", "Author $i Institution");
    }
    $writerTitleRow = WriterEntityFactory::createRowFromArray($titleRow);
    $writer->addRow($writerTitleRow);

    // Write the data to the Excel file.
    foreach ($data as $paper) {
      $row = [$paper->getId(), $paper->getTitle(), $paper->getType()];

      // Adds authors and institutions to the line.
      $authors = $paper->getAuthors();
      for ($i = 0; $i < $maxAuthors; $i++) {
        if (isset($authors[$i])) {
          $author = $authors[$i];
          array_push($row, $author->getName(), $author->getInstitution());
        }
        else {
          // If there is no author for this index, add empty values.
          array_push($row, '', '');
        }
      }

      // Adds a new line to the Excel file.
      $writerRow = WriterEntityFactory::createRowFromArray($row);
      $writer->addRow($writerRow);
    }

    // Closes the Excel file.
    $writer->close();

    echo "Excel file created successfully\n";
  }

}
