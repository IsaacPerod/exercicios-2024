<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  /**
   * Loads paper information from the HTML and returns Paper[] the array with the data.
   */
  public function scrap(\DOMDocument $dom): array {

      // Creates an empty array to store the papers.
      $papers = [];

      // Creates a new DOMXPath obj to do XPath queries.
      $xpath = new \DOMXPath($dom);

      // Finds all 'a' elements with class 'paper-card'.
      $paperNodes = $xpath->query('//a[contains(@class, "paper-card")]');

      // Iterates over each element 'a'.
      foreach ($paperNodes as $paperNode) {
          // Extracts the title of the work.
          $title = $xpath->query('.//h4', $paperNode)->item(0)->nodeValue;

          // Extracts the authors of the work and their institutions.
          $authorNodes = $xpath->query('.//div[@class="authors"]/span', $paperNode);
          $authors = [];
          foreach ($authorNodes as $authorNode) {
              $name = $authorNode->nodeValue;
              $institution = $authorNode->getAttribute('title');
              $authors[] = new Person($name, $institution);
          }

          // Extracts the presentation type.
          $type = $xpath->query('.//div[@class="tags mr-sm"]/text()', $paperNode)->item(0)->nodeValue;

          // Extracts the paper ID.
          $paperID = $xpath->query('.//div[@class="volume-info"]', $paperNode)->item(0)->nodeValue;

          // Creates a new Paper object and adds it to the papers array.
          $papers[] = new Paper($paperID, $title, $type, $authors);
      }

      // Returns the papers array.
      return $papers;
  }

}
