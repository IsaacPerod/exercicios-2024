<?php

namespace Chuva\Php\WebScrapping;

use Chuva\Php\WebScrapping\Entity\Paper;
use Chuva\Php\WebScrapping\Entity\Person;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper
{

    /**
     * Loads paper information from the HTML and returns the array with the data.
     */
    public function scrap(\DOMDocument $dom): array
    {

        // Cria uma matriz vazia para armazenar os papers
        $papers = [];

        // Cria um novo objeto DOMXPath para poder fazer consultas XPath no documento
        $xpath = new \DOMXPath($dom);

        // Encontra todos os elementos 'a' com a classe 'paper-card'
        $paperNodes = $xpath->query('//a[contains(@class, "paper-card")]');

        // Itera sobre cada elemento 'a'
        foreach ($paperNodes as $paperNode) {
            // Extrai o título do trabalho
            $title = $xpath->query('.//h4', $paperNode)->item(0)->nodeValue;

            // Extrai os autores do trabalho e suas instituições
            $authorNodes = $xpath->query('.//div[@class="authors"]/span', $paperNode);
            $authors = [];
            foreach ($authorNodes as $authorNode) {
                $name = $authorNode->nodeValue;
                $institution = $authorNode->getAttribute('title');
                $authors[] = new Person($name, $institution);
            }

            // Extrai o tipo de apresentação
            $type = $xpath->query('.//div[@class="tags mr-sm"]/text()', $paperNode)->item(0)->nodeValue;

            // Extrai o ID do paper
            $paperID = $xpath->query('.//div[@class="volume-info"]', $paperNode)->item(0)->nodeValue;

            // Cria um novo objeto Paper e o adiciona à matriz de papers
            $papers[] = new Paper($paperID, $title, $type, $authors);
        }

        // Retorna a matriz de papers
        return $papers;
    }
}
